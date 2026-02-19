<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj = new clsConexion;
$usu = $_SESSION["usuario"];
$tipo = $_SESSION["tipo"];

$primer_dia = date("Y-m-01");
$ultimo_dia = date("Y-m-t");
$desde = isset($_GET['desde']) ? trim($_GET['desde']) : $primer_dia;
$hasta = isset($_GET['hasta']) ? trim($_GET['hasta']) : $ultimo_dia;
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $desde)) $desde = $primer_dia;
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $hasta)) $hasta = $ultimo_dia;
if ($desde > $hasta) { $desde = $primer_dia; $hasta = $ultimo_dia; }

$cond_usuario = '';
if ($tipo == 'USUARIO') {
    $usur = $obj->consultar("SELECT idusu FROM usuario WHERE usuario='" . $obj->real_escape_string($usu) . "'");
    if ($usur && count($usur) > 0) {
        $idusuario = (int)$usur[0]['idusu'];
        $cond_usuario = " AND v.idusuario=$idusuario";
    }
}

$result = $obj->consultar("SELECT v.idventa, v.fecha_emision, v.total, dv.item, dv.cantidad, dv.precio_unitario, dv.valor_unitario, dv.importe_total, p.descripcion as producto
FROM venta v
INNER JOIN detalleventa dv ON v.idventa = dv.idventa
INNER JOIN productos p ON dv.idproducto = p.idproducto
WHERE v.fecha_emision BETWEEN '" . $obj->real_escape_string($desde) . "' AND '" . $obj->real_escape_string($hasta) . "' $cond_usuario AND v.estado != 'anulado'
ORDER BY v.fecha_emision, v.idventa, dv.item");

$totalv = 0;
foreach ((array)$result as $row) { $totalv += $row['importe_total']; }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte de Ventas</title>
</head>
<body>
<div class="page-container">
<div class="main-content">
<?php include('../central/cabecera.php');?>
<hr/>
<h2>Reporte de Ventas</h2>
<br/>
<form method="get" action="" class="form-inline">
<table class="table table-bordered">
<tr>
	<td><b>Desde</b></td>
	<td><input type="date" name="desde" value="<?php echo htmlspecialchars($desde); ?>" class="form-control"/></td>
	<td><b>Hasta</b></td>
	<td><input type="date" name="hasta" value="<?php echo htmlspecialchars($hasta); ?>" class="form-control"/></td>
	<td><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Ver reporte</button></td>
	<td><a href="rptrango2venta.php?desde=<?php echo urlencode($desde); ?>&hasta=<?php echo urlencode($hasta); ?>" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-print"></span> Imprimir PDF</a></td>
</tr>
</table>
</form>
<br/>
<p><strong>Período:</strong> <?php echo date('d/m/Y', strtotime($desde)); ?> – <?php echo date('d/m/Y', strtotime($hasta)); ?></p>
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
	<td><?php echo number_format(isset($row['precio_unitario']) ? (float)$row['precio_unitario'] : $row['valor_unitario'], 2); ?></td>
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
