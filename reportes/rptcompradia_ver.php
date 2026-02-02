<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj = new clsConexion;
date_default_timezone_set('america/lima');

$fecha_actual = isset($_GET['fecha']) ? trim($_GET['fecha']) : date("Y-m-d");
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_actual)) $fecha_actual = date("Y-m-d");

$result = $obj->consultar("SELECT * FROM compra WHERE fecha='" . $obj->real_escape_string($fecha_actual) . "' ORDER BY idcompra");
$totalv = 0;
foreach ((array)$result as $row) { $totalv += $row['total']; }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Reporte Compras del Día</title>
</head>
<body>
<div class="page-container">
<div class="main-content">
<?php include('../central/cabecera.php');?>
<hr/>
<h2>Reporte Compras del Día</h2>
<br/>
<form method="get" action="" class="form-inline">
<table class="table table-bordered">
<tr>
	<td><b>Fecha</b></td>
	<td><input type="date" name="fecha" value="<?php echo htmlspecialchars($fecha_actual); ?>" class="form-control"/></td>
	<td><button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span> Ver reporte</button></td>
	<td><a href="rptcompradia.php?fecha=<?php echo urlencode($fecha_actual); ?>" target="_blank" class="btn btn-info"><span class="glyphicon glyphicon-print"></span> Imprimir PDF</a></td>
</tr>
</table>
</form>
<br/>
<p><strong>Fecha:</strong> <?php echo date('d/m/Y', strtotime($fecha_actual)); ?></p>
<div class="table-responsive">
<table class="table table-bordered table-striped">
<thead>
<tr class="info">
	<th>Tipo</th>
	<th>Número</th>
	<th>Fecha</th>
	<th>Costo Total</th>
</tr>
</thead>
<tbody>
<?php foreach ((array)$result as $row) { ?>
<tr>
	<td><?php echo htmlspecialchars($row['docu']); ?></td>
	<td><?php echo htmlspecialchars($row['num_docu']); ?></td>
	<td><?php echo $row['fecha']; ?></td>
	<td><?php echo number_format($row['total'], 2); ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<p class="text-right"><strong>Total compras: <?php echo number_format($totalv, 2); ?></strong></p>
<br/>
<footer class="main" align="center">
	&copy; <?php echo date('Y'); ?> <strong>Derechos Reservados</strong>
</footer>
</div>
</div>
<?php include("../central/pieproducto.php");?>
</body>
</html>
