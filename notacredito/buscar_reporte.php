<?php
include ("../seguridad.php");
include_once("../conexion/clsConexion.php");
include_once("../cantidad_en_letras.php");

$obj = new clsConexion;

// Obtener los valores de serie y correlativo del formulario
$serie = $_POST['serie_v'];
$correlativo = $_POST['correlativo_v'];

// Realizar la consulta a la base de datos
$data = $obj->consultar("SELECT serie.serie, serie.correlativo, venta.*,
    detalleventa.* FROM venta
    INNER JOIN serie ON venta.idserie = serie.idserie
    INNER JOIN detalleventa ON detalleventa.idventa = venta.idventa
    WHERE serie.serie = '$serie' AND serie.correlativo = '$correlativo'");

$idventa = null;
foreach ((array)$data as $row) {
    $idventa = $row["idventa"];
}

// Obtener datos de configuración
$data_c = $obj->consultar("SELECT * FROM configuracion WHERE idconfi='1'");
foreach ($data_c as $row) {
    $logo = $row["logo"];
    $emisor = $row["ruc"];
    $sm = $row["simbolo_moneda"];
}

// Obtener datos de venta
$dataventa = $obj->consultar("SELECT cliente.nombres, cliente.direccion, cliente.nrodoc,
    tipo_documento.descripcion AS descripciontipodocu, venta.idventa, venta.igv, venta.total,
    venta.op_gravadas, venta.op_exoneradas, venta.op_inafectas, venta.fecha_emision, venta.efectivo,
    venta.vuelto, tipo_comprobante.descripcion, serie.serie, serie.correlativo
    FROM venta
    INNER JOIN cliente ON venta.idcliente = cliente.idcliente
    INNER JOIN serie ON venta.idserie = serie.idserie
    INNER JOIN tipo_documento ON cliente.id_tipo_docu = tipo_documento.idtipo_docu
    INNER JOIN tipo_comprobante ON venta.tipocomp = tipo_comprobante.codigo
    WHERE idventa='$idventa'");

foreach ((array)$dataventa as $row) {
    $razon_social = $row["nombres"];
    $direccion = $row["direccion"];
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
}

// Generar el reporte
if ($dataventa) {
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style type="text/css">
.zona_impresion {
    width: 400px;
    padding: 10px 5px;
    float: left;
    font-size: 12.5px;
}

center {
    text-align: center;
}

#negrita {
    font-weight: bold;
}
</style>
<script>
function imprimir() {
    var Obj = document.getElementById("desaparece");
    Obj.style.visibility = 'hidden';
    window.print();
}
</script>
</head>
<body>
<div class="zona_impresion">
    <table border="0" class="zona_impresion">
        <tr>
            <td colspan="2" align="center"><img src="../configuracion/foto/<?php echo htmlspecialchars($logo); ?>" width="210" height="50" /></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><?php echo "RUC: " . htmlspecialchars($emisor); ?></td>
        </tr>
        <tr>
            <td colspan="5">=======================================================</td>
        </tr>
        <tr>
            <td><b><?php echo htmlspecialchars($descripcion) . " ELECTRONICA:"; ?></b></td>
            <td><b><?php echo htmlspecialchars($serie . " - " . $correlativo); ?></b></td>
        </tr>
        <tr>
            <td width="268">CLIENTE</td>
            <td width="268"><?php echo htmlspecialchars($razon_social); ?></td>
        </tr>
        <tr>
            <td width="268">DIRECCION</td>
            <td width="268"><?php echo htmlspecialchars($direccion); ?></td>
        </tr>
        <tr>
            <td width="268"><?php echo htmlspecialchars($descripciontipodocu); ?></td>
            <td width="268"><?php echo htmlspecialchars($nrodoc); ?></td>
        </tr>
        <tr>
            <td width="268"><?php echo "FECHA DE EMISION:"; ?></td>
            <td width="268"><?php echo htmlspecialchars($fecha); ?></td>
        </tr>
        <tr>
            <td width="268"><?php echo "TIPO DE TRANSACCIÓN"; ?></td>
            <td width="268"><?php echo "CONTADO"; ?></td>
        </tr>
    </table>
    <table border="0" width="300px" align="center" class="zona_impresion">
        <br>
        <tr>
            <td width="49"><b>ITEM</b></td>
            <td width="219"><b>CANTIDAD</b></td>
            <td width="49"><b>PRODUCTO</b></td>
            <td width="49"><b>P.U.</b></td>
            <td width="68" align="right"><b>SUBTOTAL</b></td>
        </tr>
        <tr>
            <td colspan="5">=======================================================</td>
        </tr>
        <?php
        $datadet = $obj->consultar("SELECT detalleventa.item, detalleventa.cantidad, productos.descripcion,
            detalleventa.valor_unitario, detalleventa.valor_total, detalleventa.importe_total, detalleventa.idventa,
            presentacion.presentacion
            FROM detalleventa
            INNER JOIN productos ON detalleventa.idproducto = productos.idproducto
            INNER JOIN presentacion ON productos.idpresentacion = presentacion.idpresentacion
            WHERE idventa='$idventa'");

        foreach ($datadet as $row) {
        ?>
        <tr>
            <td><?php echo htmlspecialchars($row['item']); ?></td>
            <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
            <td><?php echo htmlspecialchars($row['descripcion'] . '/' . $row['presentacion']); ?></td>
            <td><?php echo htmlspecialchars($row['valor_unitario']); ?></td>
            <td align='right'><?php echo htmlspecialchars($row['importe_total']); ?></td>
        </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan="5">=======================================================</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><?php echo 'OP. GRAVADAS:'; ?></td>
            <td align="right"><?php echo htmlspecialchars($op_gravadas); ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><?php echo 'IGV (18%):'; ?></td>
            <td align="right"><?php echo htmlspecialchars($igv); ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><?php echo 'OP. EXONERADAS:'; ?></td>
            <td align="right"><?php echo htmlspecialchars($op_exoneradas); ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><?php echo 'OP. INAFECTAS:'; ?></td>
            <td align="right"><?php echo htmlspecialchars($op_inafectas); ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><?php echo 'IMPORTE TOTAL:'; ?></td>
            <td align="right"><?php echo htmlspecialchars($total); ?></td>
        </tr>
        <tr>
            <td colspan="5">=======================================================</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><?php echo 'EFECTIVO:'; ?></td>
            <td align="right"><?php echo htmlspecialchars($efectivo); ?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td colspan="3" align="right"><?php echo 'VUELTO:'; ?></td>
            <td align="right"><?php echo htmlspecialchars($vuelto); ?></td>
        </tr>
        <tr>
            <td colspan="5" align="left"><?php echo "SON: " . CantidadEnLetra($total); ?></td>
        </tr>
        <tr>
            <td colspan="5">&nbsp;</td>
        </tr>
        <?php
        $ruc = $emisor;
        $tipo_documento = $descripcion; //factura
        $tipodoccliente = $descripciontipodocu;
        $nro_doc_cliente = $nrodoc;

        $nombrexml = $ruc . "-" . $tipo_documento . "-" . $serie . "-" . $correlativo;

        $text_qr = $ruc . " | " . $tipo_documento . " | " . $serie . " | " . $correlativo . " | " . $igv . " | " . $total . " | " . $fecha . " | " . $tipodoccliente . " | " . $nro_doc_cliente;
        ?>

        <tr>
            <td colspan="5" align="center">Representación impresa de la Boleta/Factura de venta Electrónica</td>
        </tr>
    </table>
</div>
</body>
</html>
<?php
} else {
    echo "<p>No se encontraron resultados para la serie y correlativo proporcionados.</p>";
}
?>
