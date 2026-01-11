<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;


require __DIR__.'/../vendor/autoload.php';
$see = require __DIR__.'/../config.php';


//requires
require_once("../cantidad_en_letras.php");
include("../seguridad.php");
$usu = $_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj = new clsConexion();
$idventa = $obj->real_escape_string($_POST['idventa']);

// Crear la carpeta si no existe cdr
$foldercdr = __DIR__ . '/../cdr/';
if (!is_dir($foldercdr)) {
    mkdir($foldercdr, 0777, true);
}

// Crear la carpeta si no existe xml
$folderxml = __DIR__ . '/../xml/';
if (!is_dir($folderxml)) {
    mkdir($folderxml, 0777, true);
}

// Cliente
$datacli = $obj->consultar("SELECT venta.idventa, cliente.nombres, cliente.direccion, cliente.nrodoc, tipo_documento.idtipo_docu
    FROM venta
    INNER JOIN cliente ON venta.idcliente = cliente.idcliente
    INNER JOIN tipo_documento ON cliente.id_tipo_docu = tipo_documento.idtipo_docu
    WHERE venta.idventa='$idventa'");
$row = $datacli[0];
$td = trim($row['idtipo_docu']);
$ruc_c = trim($row['nrodoc']);
$rz_c = trim($row['nombres']);

switch ($td) {
    case 1: $cod = 0; break;
    case 2: $cod = 1; break;
    case 3: $cod = 4; break;
    case 4: $cod = 6; break;
    case 5: $cod = 7; break;
    case 6: $cod = 'A'; break;
    default: $cod = null;
}

$client = (new Client())
    ->setTipoDoc($cod)
    ->setNumDoc($ruc_c)
    ->setRznSocial($rz_c);

// Emisor
$imps = $obj->consultar("SELECT * FROM configuracion WHERE idconfi='1'");
$row = $imps[0];
$ruc_empresa = trim($row["ruc"]);
$rz = trim($row["razon_social"]);
$nc = trim($row["nombre_comercial"]);
$dir = trim($row["direccion"]);
$dep = trim($row["departamento"]);
$pro = trim($row["provincia"]);
$dis = trim($row["distrito"]);
$ubi = trim($row["ubigeo"]);
$mon = trim($row["simbolo_moneda"]);
$impuesto = trim($row["impuesto"]);

$address = (new Address())
    ->setUbigueo($ubi)
    ->setDepartamento($dep)
    ->setProvincia($pro)
    ->setDistrito($dis)
    ->setUrbanizacion('-')
    ->setDireccion($dir)
    ->setCodLocal('0000');

$company = (new Company())
    ->setRuc($ruc_empresa)
    ->setRazonSocial($rz)
    ->setNombreComercial($nc)
    ->setAddress($address);

// Venta
$data = $obj->consultar("SELECT
    venta.op_gravadas,
    venta.op_exoneradas,
    venta.op_inafectas,
    venta.igv,
    venta.total,
    serie.tipocomp,
    serie.serie,
    serie.correlativo,
    venta.fecha_emision
    FROM venta
    INNER JOIN serie ON venta.idserie = serie.idserie
    WHERE venta.idventa='$idventa'");

$row = $data[0];
$op_gravadas = $row['op_gravadas'] ?: 0;
$op_exoneradas = $row['op_exoneradas'] ?: 0;
$op_inafectas = $row['op_inafectas'] ?: 0;
$igv = $row['igv'] ?: 0;
$total = $row['total'];
$tipodoc = $row['tipocomp'];
$serie = $row['serie'];
$correlativo = $row['correlativo'];
$fecha_emision = $row['fecha_emision'];

$ValorVenta = number_format($op_gravadas + $op_exoneradas + $op_inafectas, 2);
$fechaEmision_fe = new DateTime($fecha_emision);

$invoice = (new Invoice())
    ->setUblVersion('2.1')
    ->setTipoOperacion('0101') // Venta - Catalog. 51
    ->setTipoDoc($tipodoc) // Factura - Catalog. 01
    ->setSerie($serie)
    ->setCorrelativo($correlativo)
    ->setFechaEmision($fechaEmision_fe) // Zona horaria: Lima
    //->setFechaEmision('0000') // Zona horaria: Lima
    ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado
    ->setTipoMoneda('PEN') // Sol - Catalog. 02
    ->setCompany($company)
    ->setClient($client)
    ->setMtoOperGravadas($op_gravadas)
    ->setMtoOperExoneradas($op_exoneradas)
    ->setMtoOperInafectas($op_inafectas)
    ->setMtoIGV($igv)
    ->setTotalImpuestos($igv)
    ->setValorVenta($ValorVenta)
    ->setSubTotal($total)
    ->setMtoImpVenta($total)
    ;

// detalle venta
$items = [];
$data = $obj->consultar("SELECT * FROM detalleventa WHERE idventa='$idventa'");
foreach ($data as $row) {
    $ip = $row['idproducto'];
    $cant = $row['cantidad'];
    $v_u = $row['valor_unitario'];
    $p_u = $row['precio_unitario'];
    $igv_d = $row['igv'];
    $v_t = $row['valor_total'];
    $imp = $row['importe_total'];
    $porcentaje = $row['porcentaje_igv'];

    $data_p = $obj->consultar("SELECT
        tipo_afectacion.codigo_afectacion,
        tipo_afectacion.nombre_afectacion,
        tipo_afectacion.tipo_afectacion,
        unidad.codigo AS unidad,
        productos.codigo,
        productos.idproducto,
        productos.tipo_precio,
        productos.descripcion,
        tipo_afectacion.codigo AS codigoalt,
        presentacion.presentacion
        FROM productos
        INNER JOIN tipo_afectacion
            ON productos.idtipoaf = tipo_afectacion.idtipoa
        INNER JOIN unidad
            ON productos.idunidad = unidad.iduni
        INNER JOIN presentacion
            ON productos.idpresentacion = presentacion.idpresentacion
        WHERE productos.idproducto='$ip'");

    $row_p = $data_p[0];
    $des = $row_p['descripcion'] . " " . $row_p['presentacion'];
    $uni = $row_p['unidad'];
    $codigo_afectacion_alt = $row_p['codigoalt'];
    $tp = $row_p['tipo_precio'];

    $item = (new SaleDetail())
        ->setCodProducto($ip)
        ->setUnidad($uni) // Unidad - Catalog. 03
        ->setCantidad($cant)
        ->setMtoValorUnitario($v_u)
        ->setDescripcion($des)
        ->setMtoBaseIgv($v_t)
        ->setPorcentajeIgv($porcentaje) // 18%
        ->setIgv($igv_d)
        ->setTipAfeIgv($codigo_afectacion_alt) // Gravado Op. Onerosa - Catalog. 07
        ->setTotalImpuestos($igv_d) // Suma de impuestos en el detalle
        ->setMtoValorVenta($v_t)
        ->setMtoPrecioUnitario($p_u);

    $items[] = $item; // Agregar el detalle al array de items
}

$legend = (new Legend())
    ->setCode('1000') // Monto en letras - Catalog. 52
    ->setValue(CantidadEnLetra($total));

$invoice->setDetails($items) // Establecer todos los detalles
        ->setLegends([$legend]);

// Enviar la factura a SUNAT
$result = $see->send($invoice);

// Guardar XML firmado digitalmente en la carpeta especificada
file_put_contents($folderxml . $invoice->getName() . '.xml', $see->getFactory()->getLastXml());

// Verificamos que la conexión con SUNAT fue exitosa.
if (!$result->isSuccess()) {
    // Mostrar error al conectarse a SUNAT.
    echo 'Codigo Error: ' . $result->getError()->getCode();
    echo 'Mensaje Error: ' . $result->getError()->getMessage();
    exit();
}

// Guardamos el CDR en la carpeta especificada
file_put_contents($foldercdr . 'R-' . $invoice->getName() . '.zip', $result->getCdrZip());

    $cdr = $result->getCdrResponse();
    $code = (int)$cdr->getCode();
    //$description = $cdr->getDescription();

    if ($code === 0) {
        $sql = "UPDATE venta SET `estado`='enviado' WHERE idventa='$idventa'";
        $obj->ejecutar($sql);
        echo 'ESTADO: ACEPTADA';

        $sql = "UPDATE venta SET `femensajesunat`='Aceptada' WHERE idventa='$idventa'";
        $obj->ejecutar($sql);

        if (count($cdr->getNotes()) > 0) {
            $sql = "UPDATE venta SET `femensajesunat`='Observaciones' WHERE idventa='$idventa'";
            $obj->ejecutar($sql);
            echo '|OBSERVACIONES'; // ✅ Mensaje separado para identificarlo en JS
        }
    }

$mensaje_sunat = $cdr->getDescription().PHP_EOL;

if (!empty($mensaje_sunat)) {
    echo "|ERROR: " . $mensaje_sunat; // Se mostrará en la respuesta de la petición AJAX
} else {
    echo "|ERROR: No hay mensaje de error"; // Mensaje si está vacío
}


// if ($code === 0) {
//     echo 'ESTADO: ACEPTADA'.PHP_EOL;
//     if (count($cdr->getNotes()) > 0) {
//         echo 'OBSERVACIONES:'.PHP_EOL;
//         // Corregir estas observaciones en siguientes emisiones.
//         var_dump($cdr->getNotes());
//     }
// } else if ($code >= 2000 && $code <= 3999) {
//     echo 'ESTADO: RECHAZADA'.PHP_EOL;
// } else {
//     /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
//     /*code: 0100 a 1999 */
//     echo 'Excepción';
// }



  /*   if ($code === 0) {
        $sql = "UPDATE venta SET `estado`='enviado' WHERE idventa='$idventa'";
        $obj->ejecutar($sql);
        echo 'ESTADO: ACEPTADA';

        $sql = "UPDATE venta SET `femensajesunat`='Aceptada' WHERE idventa='$idventa'";
        $obj->ejecutar($sql);

        if (count($cdr->getNotes()) > 0) {
            echo 'Observaciones';
            $sql = "UPDATE venta SET `femensajesunat`='Observaciones' WHERE idventa='$idventa'";
            $obj->ejecutar($sql);
        }
    } */
   // echo $cdr->getDescription() . PHP_EOL;
 /*    else if($code !== 0){
        $sql = "UPDATE venta SET `femensajesunat`='Error' WHERE idventa='$idventa'";
        $obj->ejecutar($sql);
    } */
   /*   else if ($code >= 2000 && $code <= 3999) {
        echo  'ESTADO: RECHAZADA';
        $sql_r = "UPDATE venta SET `femensajesunat`='Rechazada' WHERE idventa='$idventa'";
        $obj->ejecutar($sql_r);

    } else if ($code >= 100 && $code <= 1999) {
        echo  'Excepción';
        $sql_e = "UPDATE venta SET `femensajesunat`='Excepción' WHERE idventa='$idventa'";
        $obj->ejecutar($sql_e);

    } else {
        echo  'ESTADO: ERROR';
        $sql_error = "UPDATE venta SET `femensajesunat`='Error' WHERE idventa='$idventa'";
        $obj->ejecutar($sql_error);
    }
 */
