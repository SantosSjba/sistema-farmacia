<?php
include ("../seguridad.php");
include_once("../central/centralproducto.php");
include_once ("../conexion/clsConexion.php");
$obj = new clsConexion;
date_default_timezone_set('america/lima');
$dia = date("Y-m-d");
ob_start();
$usu = $_SESSION["usuario"];
$result = $obj->consultar("SELECT * from caja_apertura  WHERE usuario= '$usu' AND fecha='$dia'");
$item = array();
$index = 1;
?>
<!DOCTYPE html>

<body>
	<div class="page-container">
		<div class="main-content">
			<?php include ('../central/cabecera.php'); ?>
			<hr />
			<h2>Seguimiento de Caja</h2>
			<br />
			<br />
			<table class="table table-bordered datatable" id="table-1">
				<thead>
					<tr class="info">
						<th data-hide="phone"><a href="#">Num</a></th>
						<th><a href="#">Fecha</a></th>
						<th><a href="#">Hor.Apert.</a></th>
						<th><a href="#">Caja</a></th>
						<th><a href="#">Turno</a></th>
						<th><a href="#">Mont.Apert</a></th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ((array) $result as $row) {
						$item[$index] = $row;
						?>
						<tr>
							<td><?php echo $index++; ?></td>
							<td><?php echo $row['fecha']; ?></td>
							<td><?php echo $row['hora']; ?></td>
							<td><?php echo $row['caja']; ?></td>
							<td><?php echo $row['turno']; ?></td>
							<td><?php echo $row['monto']; ?></td>
							<td>
								<?php echo "<a href='../reportes/cuadrecaja.php' class='btn btn-default btn-sm btn-icon icon-left'><i class='entypo-print'></i>Imprimir</a>" ?>
						</tr>
						</td>
						<?php
					}
					;
					?>
				</tbody>
			</table>
			<br /><!-- Footer -->
		</div>
	</div>
</body>
<?php include_once ("../central/pieproducto.php"); ?>