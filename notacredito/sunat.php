<?php

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__.'/../vendor/autoload.php';
$see = require __DIR__.'/../config.php';
include("../seguridad.php");
$usu=$_SESSION["usuario"];
//requires
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
require_once("../cantidad_en_letras.php");

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

// Verificar si se ha pasado el parámetro `idnota` en la URL
if (!isset($_GET['idnota']) || empty($_GET['idnota'])) {
    throw new Exception('ID de nota de crédito no proporcionado.');
}
$idnota = $_GET['idnota'];

$data_nota = $obj->consultar("SELECT idnota, idventa FROM nota_credito WHERE idnota='$idnota'");
foreach ($data_nota as $row) {
    $idventa = $row['idventa'];
}

$datacli = $obj->consultar("SELECT
cliente.id_tipo_docu,
cliente.nrodoc,
cliente.nombres,
nota_credito.idnota
FROM nota_credito
INNER JOIN cliente
  ON nota_credito.idcliente = cliente.idcliente
    WHERE nota_credito.idnota='$idnota'");

     // Verificar si la consulta devolvió resultados
     if (empty($datacli)) {
        throw new Exception('No se encontraron datos para el ID de nota de crédito proporcionado.');
    }
    
$row = $datacli[0];
$td = trim($row['id_tipo_docu']);
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
// Cliente
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

// nota de credito
$data = $obj->consultar("SELECT
nota_credito.idnota,
nota_credito.fecha_emision,
nota_credito.op_gravadas,
nota_credito.op_exoneradas,
nota_credito.op_inafectas,
nota_credito.total,
nota_credito.igv,
nota_credito.serie_ref,
nota_credito.correlativo_ref,
nota_credito.codmotivo,
nota_credito.nombrexml,
serie.serie,
serie.correlativo,
serie.tipocomp
FROM nota_credito
INNER JOIN serie
  ON nota_credito.idserie = serie.idserie
    WHERE nota_credito.idnota='$idnota'");

$row = $data[0];
$op_gravadas = $row['op_gravadas'] ?: 0;
$op_exoneradas = $row['op_exoneradas'] ?: 0;
$op_inafectas = $row['op_inafectas'] ?: 0;
$igv = $row['igv'] ?: 0;
$total = $row['total'];
$tipocomp_n = $row['tipocomp'];
$fecha_emision = $row['fecha_emision'];
$serie_n = $row['serie_ref'];
$correlativo_n = $row['correlativo_ref'];
/////
$serie = $row['serie'];
$correlativo = $row['correlativo'];

$NumDocfectado=$serie . '-' . $correlativo;
///
$ValorVenta = number_format($op_gravadas + $op_exoneradas + $op_inafectas, 2);
$fechaEmision_fe = new DateTime($fecha_emision);
$note = (new Note())
    ->setUblVersion('2.1')
    ->setTipoDoc('07')
    ->setSerie($serie_n)//FN01 serie para facturas://BN01 serie para boleta
    ->setCorrelativo($correlativo_n)//correlativo de la nota de credito
    ->setFechaEmision($fechaEmision_fe)//fecha de emision de la nota de credito
    ->setTipDocAfectado($tipocomp_n) // Tipo Doc: Factura // 03:boleta
    ->setNumDocfectado($NumDocfectado) // Factura: Serie-Correlativo del comprobante
    ->setCodMotivo('01') // Catalogo. 09
    ->setDesMotivo('ANULACION DE LA OPERACION')
    ->setTipoMoneda('PEN')
    ->setCompany($company)
    ->setClient($client)
    ->setMtoOperGravadas($op_gravadas)
    ->setMtoOperExoneradas($op_exoneradas)
    ->setMtoOperInafectas($op_inafectas)
    ->setMtoIGV($igv)
    ->setTotalImpuestos($igv)
    ->setValorVenta($ValorVenta)
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

$legend = new Legend();
$legend->setCode('1000')
        ->setValue(CantidadEnLetra($total));

$note->setDetails($items)
    ->setLegends([$legend]);

// Enviar la factura a SUNAT
$result = $see->send($note);

// Guardar XML firmado digitalmente en la carpeta especificada
file_put_contents($folderxml . $note->getName() . '.xml', $see->getFactory()->getLastXml());

// Verificamos que la conexión con SUNAT fue exitosa.
if (!$result->isSuccess()) {
    // Mostrar error al conectarse a SUNAT.
    echo 'Codigo Error: ' . $result->getError()->getCode();
    echo 'Mensaje Error: ' . $result->getError()->getMessage();
    exit();
}

// Guardamos el CDR en la carpeta especificada
file_put_contents($foldercdr . 'R-' . $note->getName() . '.zip', $result->getCdrZip());

$cdr = $result->getCdrResponse();
$code = (int)$cdr->getCode();

if ($code === 0) {
    echo 'ESTADO: ACEPTADA' . PHP_EOL;
    if (count($cdr->getNotes()) > 0) {
        echo 'OBSERVACIONES:' . PHP_EOL;
        var_dump($cdr->getNotes());
    }  
} else if ($code >= 2000 && $code <= 3999) {
    echo 'ESTADO: RECHAZADA' . PHP_EOL;
} else {
    echo 'Excepción';
}

echo $cdr->getDescription() . PHP_EOL;

echo '<p>Esta página se redirigirá en 5 segundos...</p>';
echo '<script>
    setTimeout(function() {
        window.location.href = "index.php";
    }, 5000);
</script>';