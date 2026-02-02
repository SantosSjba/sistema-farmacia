<?php
include ("../seguridad.php");
include_once("../central/centralproducto.php");
include_once ("../conexion/clsConexion.php");
$obj = new clsConexion;
date_default_timezone_set('america/lima');
$dia = date("Y-m-d");
ob_start();
$usu = $_SESSION["usuario"];
$tipo = $_SESSION["tipo"];

// ADMINISTRADOR: ver todas las cajas con filtros. USUARIO: solo las propias
$filtro_fecha = isset($_GET['filtro_fecha']) ? trim($_GET['filtro_fecha']) : $dia;
$filtro_usuario = isset($_GET['filtro_usuario']) ? trim($_GET['filtro_usuario']) : '';

// Validar fecha
$valida_fecha = function($f) { return preg_match('/^\d{4}-\d{2}-\d{2}$/', $f) && strtotime($f) !== false; };
if (!$valida_fecha($filtro_fecha)) { $filtro_fecha = $dia; }

$filtro_fecha_sql = $obj->real_escape_string($filtro_fecha);

if ($tipo == 'ADMINISTRADOR') {
    // ADMIN: todas las aperturas, con filtro opcional por usuario (nombre cajero)
    $cond_usuario = ($filtro_usuario !== '') ? " AND usuario = '" . $obj->real_escape_string($filtro_usuario) . "'" : '';
    $result = $obj->consultar("SELECT * FROM caja_apertura WHERE fecha = '$filtro_fecha_sql'" . $cond_usuario . " ORDER BY usuario, hora DESC");
    $lista_usuarios = $obj->consultar("SELECT DISTINCT usuario FROM caja_apertura ORDER BY usuario");
} else {
    // USUARIO: solo sus propias aperturas
    $usu_safe = $obj->real_escape_string($usu);
    $result = $obj->consultar("SELECT * FROM caja_apertura WHERE usuario = '$usu_safe' AND fecha = '$filtro_fecha_sql' ORDER BY hora DESC");
    $lista_usuarios = array();
}

$item = array();
$index = 1;
?>
<!DOCTYPE html>
<html>
<body>
	<div class="page-container">
		<div class="main-content">
			<?php include ('../central/cabecera.php'); ?>
			<hr />
			<h2>Seguimiento de Caja <?php echo ($tipo == 'ADMINISTRADOR') ? '(Todos los cajeros)' : ''; ?></h2>
			<?php if ($tipo == 'ADMINISTRADOR'): ?>
			<form method="get" action="" class="form-inline" style="margin-bottom: 15px;">
				<label class="control-label">Fecha:</label>
				<input type="date" name="filtro_fecha" value="<?php echo htmlspecialchars($filtro_fecha); ?>" class="form-control" style="margin: 0 10px 10px 0;">
				<label class="control-label">Usuario:</label>
				<select name="filtro_usuario" class="form-control" style="margin: 0 10px 10px 0;">
					<option value="">Todos</option>
					<?php foreach ((array)$lista_usuarios as $u): ?>
					<option value="<?php echo htmlspecialchars($u['usuario']); ?>" <?php echo ($filtro_usuario === $u['usuario']) ? 'selected' : ''; ?>>
						<?php echo htmlspecialchars($u['usuario']); ?>
					</option>
					<?php endforeach; ?>
				</select>
				<button type="submit" class="btn btn-primary"><i class="entypo-search"></i> Filtrar</button>
			</form>
			<?php endif; ?>
			<br />
			<table class="table table-bordered datatable" id="table-1">
				<thead>
					<tr class="info">
						<th data-hide="phone"><a href="#">Num</a></th>
						<th><a href="#">Fecha</a></th>
						<th><a href="#">Hor.Apert.</a></th>
						<?php if ($tipo == 'ADMINISTRADOR'): ?><th><a href="#">Cajero</a></th><?php endif; ?>
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
						$url_cuadre = '../reportes/cuadrecaja.php?usuario=' . urlencode($row['usuario']) . '&fecha=' . urlencode($row['fecha']);
						?>
						<tr>
							<td><?php echo $index++; ?></td>
							<td><?php echo htmlspecialchars($row['fecha']); ?></td>
							<td><?php echo htmlspecialchars($row['hora']); ?></td>
							<?php if ($tipo == 'ADMINISTRADOR'): ?><td><?php echo htmlspecialchars($row['usuario']); ?></td><?php endif; ?>
							<td><?php echo htmlspecialchars($row['caja']); ?></td>
							<td><?php echo htmlspecialchars($row['turno']); ?></td>
							<td><?php echo htmlspecialchars($row['monto']); ?></td>
							<td>
								<a href="<?php echo $url_cuadre; ?>" class="btn btn-default btn-sm btn-icon icon-left" target="_blank"><i class="entypo-print"></i>Imprimir</a>
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<br />
		</div>
	</div>
</body>
</html>
<?php include_once ("../central/pieproducto.php"); ?>
