<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
date_default_timezone_set('america/lima');
$dia= date("Y-m-d");

// Rango de fechas para Resumen Financiero: por defecto mes actual
$primer_dia_mes = date("Y-m-01");
$ultimo_dia_mes = date("Y-m-t");
$fecha_desde = isset($_GET['fecha_desde']) ? trim($_GET['fecha_desde']) : $primer_dia_mes;
$fecha_hasta = isset($_GET['fecha_hasta']) ? trim($_GET['fecha_hasta']) : $ultimo_dia_mes;
$valida_fecha = function($f) { return preg_match('/^\d{4}-\d{2}-\d{2}$/', $f) && strtotime($f) !== false; };
if (!$valida_fecha($fecha_desde)) { $fecha_desde = $primer_dia_mes; }
if (!$valida_fecha($fecha_hasta)) { $fecha_hasta = $ultimo_dia_mes; }
if ($fecha_desde > $fecha_hasta) { $fecha_desde = $primer_dia_mes; $fecha_hasta = $ultimo_dia_mes; }

$usur=$obj->consultar("SELECT razon_social FROM configuracion");
foreach($usur as $row){ $direccion=$row['razon_social']; }
$m='';
$resultcaja=$obj->consultar("SELECT * FROM caja_apertura WHERE usuario='" . $obj->real_escape_string($usu) . "' and fecha='$dia'");
foreach((array)$resultcaja as $row){ $m=$row['monto']; }

// Resumen Financiero USUARIO: solo ventas del cajero logueado
$ventas = 0; $costos = 0; $ganancia = 0; $gastos = 0; $neto = 0;
$usur_id = $obj->consultar("SELECT idusu FROM usuario WHERE usuario='" . $obj->real_escape_string($usu) . "'");
$idusuario = 0;
foreach((array)$usur_id as $row){ $idusuario = (int)($row['idusu'] ?? 0); }
$fecha_desde_sql = $obj->real_escape_string($fecha_desde);
$fecha_hasta_sql = $obj->real_escape_string($fecha_hasta);
if ($idusuario > 0) {
    $r_ventas = $obj->consultar("SELECT COALESCE(SUM(total), 0) AS total_ventas FROM venta WHERE fecha_emision BETWEEN '" . $fecha_desde_sql . "' AND '" . $fecha_hasta_sql . "' AND idusuario=" . $idusuario . " AND estado != 'anulado'");
    foreach((array)$r_ventas as $row){ $ventas = isset($row['total_ventas']) ? (float)$row['total_ventas'] : 0; }
    $r_costos = $obj->consultar("SELECT COALESCE(SUM(productos.precio_compra * detalleventa.cantidad), 0) AS total_costos FROM detalleventa INNER JOIN productos ON detalleventa.idproducto = productos.idproducto INNER JOIN venta ON detalleventa.idventa = venta.idventa WHERE venta.fecha_emision BETWEEN '" . $fecha_desde_sql . "' AND '" . $fecha_hasta_sql . "' AND venta.idusuario=" . $idusuario . " AND venta.estado != 'anulado'");
    foreach((array)$r_costos as $row){ $costos = isset($row['total_costos']) ? (float)$row['total_costos'] : 0; }
}
$ganancia = $ventas - $costos;
$neto = $ganancia - $gastos;
?>
<!DOCTYPE html>
<html lang="en">
<body class="page-body  page-fade">
<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	<div class="main-content">
<div class="row">
	<div class="col-sm-12">
    <div class="well">
			<h1><?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');?></h1>
			<h3>Bienvenido:::....<strong><?php echo "$usu";?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        razon social:::::.....<strong><?php echo "$direccion";?></strong></h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
<div class="col-sm-3">
	<div class="tile-stats tile-aqua">
				<div class="icon"><i class="entypo-ticket"></i></div>
				<div class="num" data-start="0" data-end="$" data-postfix="" data-duration="1400" data-delay="0"> &nbsp;</div>
				<h3>CAJA</h3>
				<p><?php echo "Apertura caja:$m"; ?></a></p>
	</div>
  </div>
    <div class="col-sm-3">
      <div class="tile-stats tile-cyan">
			<div class="icon"><i class="entypo-user"></i></div>
			<div class="num" data-start="0" data-end="vc" data-postfix="" data-duration="" data-delay="0">&nbsp;</div>
			<h3>CLIENTES</h3>
			<p><a href="../cliente/index.php">ir a clientes</a></p>
		</div>
    </div>
</div>
  </div>

<!-- Resumen Financiero (mis ventas como cajero) -->
<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">Resumen Financiero (Mis ventas)</div>
			</div>
			<div class="panel-body">
				<form method="get" action="" class="form-inline" style="margin-bottom: 20px;">
					<label class="control-label">Desde:</label>
					<input type="date" name="fecha_desde" value="<?php echo htmlspecialchars($fecha_desde); ?>" class="form-control" style="margin: 0 10px 10px 0;">
					<label class="control-label">Hasta:</label>
					<input type="date" name="fecha_hasta" value="<?php echo htmlspecialchars($fecha_hasta); ?>" class="form-control" style="margin: 0 10px 10px 0;">
					<button type="submit" class="btn btn-primary"><i class="entypo-search"></i> Filtrar</button>
					<a href="index2.php" class="btn btn-default" style="margin-left: 5px;">Mes actual</a>
				</form>
				<p style="color: #666; margin-bottom: 15px;"><strong>Período:</strong> <?php echo date('d/m/Y', strtotime($fecha_desde)); ?> – <?php echo date('d/m/Y', strtotime($fecha_hasta)); ?></p>
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" style="margin-bottom: 10px; padding: 0 5px;">
						<div style="text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 5px; min-height: 100px;">
							<div style="font-size: 14px; color: #666; margin-bottom: 8px; font-weight: 500;">Ventas</div>
							<div style="font-size: 28px; font-weight: bold; color: #333;"><?php echo number_format($ventas, 2); ?></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" style="margin-bottom: 10px; padding: 0 5px;">
						<div style="text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 5px; min-height: 100px;">
							<div style="font-size: 14px; color: #666; margin-bottom: 8px; font-weight: 500;">Costo</div>
							<div style="font-size: 28px; font-weight: bold; color: #333;"><?php echo number_format($costos, 2); ?></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" style="margin-bottom: 10px; padding: 0 5px;">
						<div style="text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 5px; min-height: 100px;">
							<div style="font-size: 14px; color: #666; margin-bottom: 8px; font-weight: 500;">Ganancia</div>
							<div style="font-size: 28px; font-weight: bold; color: #28a745;"><?php echo number_format($ganancia, 2); ?></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" style="margin-bottom: 10px; padding: 0 5px;">
						<div style="text-align: center; padding: 20px; background-color: #f5f5f5; border-radius: 5px; min-height: 100px;">
							<div style="font-size: 14px; color: #666; margin-bottom: 8px; font-weight: 500;">Gastos</div>
							<div style="font-size: 28px; font-weight: bold; color: #dc3545;"><?php echo number_format($gastos, 2); ?></div>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-2 col-lg-2" style="margin-bottom: 10px; padding: 0 5px;">
						<div style="text-align: center; padding: 20px; background-color: #e8f5e9; border-radius: 5px; border: 2px solid #4caf50; min-height: 100px;">
							<div style="font-size: 14px; color: #666; margin-bottom: 8px; font-weight: 500;">Neto</div>
							<div style="font-size: 28px; font-weight: bold; color: #2e7d32;"><?php echo number_format($neto, 2); ?></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
<br/>
<br/>
<br/>
<footer class="main" align="center">
	&copy; <?php echo date('Y'); ?> <strong>Derechos Reservados</strong> De <a href="#"  target="_blank">farmacia</a>
</footer>
</div>
 </div>
</body>
</html>
<?php include("../central/pieproducto.php");?>
