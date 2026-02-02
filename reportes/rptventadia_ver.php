<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj = new clsConexion;
$usu = $_SESSION["usuario"];
$tipo = $_SESSION["tipo"];
date_default_timezone_set('america/lima');

$fecha_actual = isset($_GET['fecha']) ? trim($_GET['fecha']) : date("Y-m-d");
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_actual)) $fecha_actual = date("Y-m-d");

$cond_usuario = '';
if ($tipo == 'USUARIO') {
    $usur = $obj->consultar("SELECT idusu FROM usuario WHERE usuario='" . $obj->real_escape_string($usu) . "'");
    if ($usur && count($usur) > 0) {
        $idusuario = (int)$usur[0]['idusu'];
        $cond_usuario = " AND v.idusuario=$idusuario";
    }
}

$result = $obj->consultar("SELECT v.idventa, v.fecha_emision, v.total, dv.item, dv.cantidad, dv.valor_unitario, dv.importe_total, p.descripcion as producto
FROM venta v
INNER JOIN detalleventa dv ON v.idventa = dv.idventa
INNER JOIN productos p ON dv.idproducto = p.idproducto
WHERE v.fecha_emision='" . $obj->real_escape_string($fecha_actual) . "' $cond_usuario AND v.estado != 'anulado'
ORDER BY v.idventa, dv.item");

$totalv = 0;
foreach ((array)$result as $row) { $totalv += $row['importe_total']; }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte Ventas del Día</title>
</head>
<body>
<div class="page-container">
<div class="main-content">
<?php include('../central/cabecera.php');?>
<hr/>
<h2>Reporte Ventas del Día</h2>
<br/>
<form method="get" action="" class="form-inline">
<table class="table table-bordered">
<tr>
	<td><b>Fecha</b></td>
	<td><input type="date" name="fecha" value="<?php echo htmlspecialchars($fecha_actual); ?>" class="form-control"/></td>
	<td><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Ver reporte</button></td>
	<td><a href="rptventadia.php?fecha=<?php echo urlencode($fecha_actual); ?>" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-print"></span> Imprimir PDF</a></td>
</tr>
</table>
</form>
<br/>
<p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($fecha_actual)); ?></p>
<div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
<table class="table table-bordered table-striped" style="width: 100%; max-width: 100%; table-layout: fixed;">
<thead>
<tr class="info">
	<th style="width: 12%;">Fecha</th>
	<th style="width: 38%;">Producto</th>
	<th style="width: 8%;">Cant.</th>
	<th style="width: 10%;">P.Unit</th>
	<th style="width: 12%;">Subtotal</th>
	<th style="width: 12%;">Total Venta</th>
</tr>
</thead>
<tbody>
<?php
$idventa_ant = 0;
foreach ((array)$result as $row) {
	$totalventa_td = ($idventa_ant != $row['idventa']) ? number_format($row['total'], 2) : '';
	if ($idventa_ant != $row['idventa']) $idventa_ant = $row['idventa'];
?>
<tr>
	<td style="overflow: hidden; text-overflow: ellipsis;"><?php echo $row['fecha_emision']; ?></td>
	<td style="overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($row['producto']); ?>"><?php echo htmlspecialchars($row['producto']); ?></td>
	<td><?php echo $row['cantidad']; ?></td>
	<td><?php echo number_format($row['valor_unitario'], 2); ?></td>
	<td><?php echo number_format($row['importe_total'], 2); ?></td>
	<td><?php echo $totalventa_td; ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<p class="text-right"><strong>Total ventas: <?php echo number_format($totalv, 2); ?></strong></p>
<br/>
<footer class="main" align="center">
	&copy; <?php echo date('Y'); ?> <strong>Derechos Reservados</strong>
</footer>
</div>
</div>
<?php include("../central/pieproducto.php");?>
</body>
</html>
