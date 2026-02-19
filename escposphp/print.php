<?php
include 'vendor/autoload.php';
include_once("../conexion/clsConexion.php");
// date_default_timezone_set('America/Lima');
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
$obj = new clsConexion;
//obtener los datos de impresion
/* $data1 = $obj->consultar("SELECT `idtike`, `ip`, `nombre` FROM `tike` WHERE  idtike='1'");
foreach ($data1 as $row) {
	$ipti = $row['ip'];
	$nombreti = $row['nombre'];
} */
// obtener el maximo id del ticket para luego imprimirlo
if (!empty($_GET['idventa'])) {
	$idventa = trim($obj->real_escape_string(htmlentities(strip_tags($_GET['idventa'], ENT_QUOTES))));
	//configuracion
	$data = $obj->consultar("SELECT * FROM configuracion WHERE idconfi='1'");
	foreach ((array) $data as $row) {
		$logo = $row["logo"];
		$ruc = $row["ruc"];
		$sm = $row["simbolo_moneda"];
		$nombre_comercial = $row["nombre_comercial"];
		$razon_social = $row["razon_social"];
		$direccion = $row["direccion"];
	}
	$dataventa = $obj->consultar("SELECT
	cliente.nombres,
	cliente.direccion,
	cliente.nrodoc,
	tipo_documento.descripcion AS descripciontipodocu,
	venta.idventa,
	venta.igv,
	venta.total,
	venta.op_gravadas,
	venta.op_exoneradas,
	venta.op_inafectas,
	venta.fecha_emision,
	venta.efectivo,
	venta.vuelto,
	venta.formadepago,
	venta.numope,
	tipo_comprobante.descripcion,
	serie.serie,
	serie.correlativo,
	usuario.usuario
  FROM venta
	INNER JOIN cliente
	  ON venta.idcliente = cliente.idcliente
	INNER JOIN serie
	  ON venta.idserie = serie.idserie
	INNER JOIN tipo_documento
	  ON cliente.id_tipo_docu = tipo_documento.idtipo_docu
	INNER JOIN tipo_comprobante
	  ON venta.tipocomp = tipo_comprobante.codigo
	INNER JOIN usuario
	  ON venta.idusuario = usuario.idusu
				WHERE venta.idventa='$idventa'");
	foreach ((array) $dataventa as $row) {
		$cliente = $row["nombres"];
		$direccion_c = $row["direccion"];
		$nrodoc = $row["nrodoc"];
		$descripciontipodocu = $row["descripciontipodocu"];
		$descripcion = $row["descripcion"];
		$serie = $row["serie"];
		$correlativo = $row["correlativo"];
		$igv = $row['igv'];
		$total = $row['total'];
		$op_gravadas = $row['op_gravadas'];
		$op_exoneradas = $row['op_exoneradas'];
		$op_inafectas = $row['op_inafectas'];
		$fecha = $row['fecha_emision'];
		$efectivo = $row['efectivo'];
		$vuelto = $row['vuelto'];
		$formadepago = isset($row['formadepago']) ? $row['formadepago'] : 'EFECTIVO';
		$numope = isset($row['numope']) ? $row['numope'] : '';
		$usuario = $row['usuario'];
	}
}
$nombreImpresora = "POS80";
// $connector = new FilePrintConnector("php://stdout");
$connector = new WindowsPrintConnector($nombreImpresora);
// $connector = new FilePrintConnector("POS58 10.0.0.6");
// $connector = new FilePrintConnector("\\\\".$ipti."\\".$nombreti."");
$printer = new Printer($connector);
$printer->text(date('d/m/Y H:i:s') . "\n");
$printer->text("" . $razon_social . "\n");
$direccion = mb_convert_encoding($direccion, "ISO-8859-1", "UTF-8");
$printer->text("" . $direccion . "\n");
$printer->text(" RUC N: " . $ruc . PHP_EOL);

$printer->text("\n");
$printer->text("Cliente: " . $cliente . "\n");
$printer->text("Cajero: " . $usuario . "\n");
$printer->text("TICKET N: " . $serie . " - " . $correlativo . "\n");
$printer->text("------------------------------------" . "\n");

// Definir anchos de columna
$ancho_ticket = 38;  // Ancho total del ticket
$ancho_desc = 20;    // Ancho para la descripción
$ancho_cant = 6;     // Cantidad
$ancho_pu = 10;      // Precio Unitario
$ancho_imp = 10;     // Importe

// Imprimir encabezado alineado
$printer->text(str_pad("DESCRIPCION", $ancho_desc) .
               str_pad("CANT.", $ancho_cant, " ", STR_PAD_LEFT) .
               str_pad("P.UNIT.", $ancho_pu, " ", STR_PAD_LEFT) .
               str_pad("IMPORTE", $ancho_imp, " ", STR_PAD_LEFT) . "\n");
$printer->text(str_repeat("-", $ancho_ticket) . "\n");

$datadet = $obj->consultar("SELECT
  detalleventa.precio_unitario,
  detalleventa.cantidad,
  productos.descripcion,
  detalleventa.valor_unitario,
  detalleventa.valor_total,
  detalleventa.importe_total,
  detalleventa.idventa,
  presentacion.presentacion
FROM detalleventa
  INNER JOIN productos
    ON detalleventa.idproducto = productos.idproducto
  INNER JOIN presentacion
    ON productos.idpresentacion = presentacion.idpresentacion
		WHERE idventa='$idventa'");
// Recorrer los productos
foreach ((array) $datadet as $row) {
    $desc = $row['descripcion'] . '/' . $row['presentacion'];
    $cant = $row['cantidad'];
    $p_u = number_format($row['precio_unitario'], 2);
    $importe = number_format($row['importe_total'], 2);

    // Dividir la descripción en líneas de máximo $ancho_desc caracteres
    $desc_lineas = explode("\n", wordwrap($desc, $ancho_desc, "\n", true));

    // Imprimir la primera línea de la descripción junto con los valores
    $printer->text(str_pad($desc_lineas[0], $ancho_desc) .
                   str_pad($cant, $ancho_cant, " ", STR_PAD_LEFT) .
                   str_pad($p_u, $ancho_pu, " ", STR_PAD_LEFT) .
                   str_pad($importe, $ancho_imp, " ", STR_PAD_LEFT) . "\n");

    // Si la descripción tiene más líneas, imprimirlas debajo sin afectar la alineación
    for ($i = 1; $i < count($desc_lineas); $i++) {
        $printer->text(str_pad($desc_lineas[$i], $ancho_desc) . "\n");
    }
}

// Definir anchos de columna
$ancho_ticket = 38;  // Ancho total del ticket
$ancho_label = 28;   // Espacio para el texto ("SubTotal", "IGV", etc.)
$ancho_valor = 10;   // Espacio para el importe

// Línea de separación
$printer->text(str_repeat("-", $ancho_ticket) . "\n");

// 🔹 Alinear los totales con la columna "Importe"
$printer->text(str_pad("SubTotal", $ancho_label) . str_pad("S/ " . number_format($op_gravadas, 2), $ancho_valor, " ", STR_PAD_LEFT) . "\n");
$printer->text(str_pad("IGV-18 %", $ancho_label) . str_pad("S/ " . number_format($igv, 2), $ancho_valor, " ", STR_PAD_LEFT) . "\n");
$printer->text(str_pad("Total", $ancho_label) . str_pad("S/ " . number_format($total, 2), $ancho_valor, " ", STR_PAD_LEFT) . "\n");
$printer->text(str_pad("Forma de pago", $ancho_label) . str_pad($formadepago, $ancho_valor, " ", STR_PAD_LEFT) . "\n");
if (!empty($numope)) {
	$printer->text(str_pad("N. Operacion", $ancho_label) . str_pad($numope, $ancho_valor, " ", STR_PAD_LEFT) . "\n");
}
if (floatval($efectivo) > 0) {
	$printer->text(str_pad("Efectivo", $ancho_label) . str_pad("S/ " . number_format($efectivo, 2), $ancho_valor, " ", STR_PAD_LEFT) . "\n");
	$printer->text(str_pad("Vuelto", $ancho_label) . str_pad("S/ " . number_format($vuelto, 2), $ancho_valor, " ", STR_PAD_LEFT) . "\n");
}

// Corte de ticket
$printer->cut();
$printer->close();


?>