<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj = new clsConexion;
date_default_timezone_set('america/lima');
$dia = date("Y-m-d");
$hora = date("g:i-a");
ob_start();
$mon = 0;
$totalventas = 0;
$cajatotal = 0;
$formapago = 0;
$formaefectivo = 0;
$formadeposito = 0;
$total=0;
$formatarjeta=0;
$usu = $_SESSION["usuario"];

// Obtener ID de usuario
$usur = $obj->consultar("SELECT idusu FROM usuario WHERE usuario= '$usu'");
if (empty($usur)) {
	die("No se obtuvieron resultados para la consulta de usuario.");
}
foreach ($usur as $row) {
	$usuario = $row['idusu'];
}
// obtener el monto de Apertura ,cajero , turno segun la fecha la sucursal y el usuario
$monto = $obj->consultar("SELECT * FROM caja_apertura WHERE usuario= '$usu' AND fecha= '$dia'");
if (empty($monto)) {
	die("No se obtuvieron resultados para la consulta de apertura.");
}

foreach ($monto as $row) {
	$mon = $row['monto'];
	$caja = $row['caja'];
	$turno = $row['turno'];
}
// Obtener ventas en efectivo
$ventas_e = $obj->consultar("SELECT * FROM venta WHERE fecha_emision = '$dia' AND idusuario = '$usuario' AND formadepago='EFECTIVO'");
foreach ((array) $ventas_e as $row) {
	$ef = $formaefectivo += $row['total'];
	$efectivo = number_format($ef, 2);
}
// Obtener ventas con tarjeta
$ventas_t = $obj->consultar("SELECT * FROM venta WHERE fecha_emision = '$dia' AND idusuario = '$usuario' AND formadepago='TARJETA'");
foreach ((array) $ventas_t as $row) {
	$ta = $formatarjeta += $row['total'];
	$tarjeta = number_format($ta, 2);
}
// Obtener ventas con depositos
$ventas_d = $obj->consultar("SELECT * FROM venta WHERE fecha_emision = '$dia' AND idusuario = '$usuario' AND formadepago='DEPOSITO EN CUENTA'");
foreach ((array) $ventas_d as $row) {
	$de = $formadeposito += $row['total'];
	$deposito = number_format($de, 2);
}
// Calcular la suma total
$total = $formaefectivo + $formatarjeta + $formadeposito;
$total_formateado = number_format($total, 2);
// obtener el total de ventas por usuario fecha y sucursal
/* $ventas = $obj->consultar("SELECT * FROM venta  WHERE fecha_emision= '$dia' AND idusuario= '$usuario'");
foreach ((array) $ventas as $row) {
	$r = $totalventas += $row['total'];
	//siempre usar ese formato para hacer sumas
	$p = number_format($r, 2, ".", "");
} */
?>
<div class="page-container">
	<div class="main-content">
		<hr />
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info" data-collapsed="0">
					<div class="panel-heading">
						<div class="panel-title">
							CIERRE DE CAJA
						</div>
					</div>
					<div class="panel-body">
						<form role="form" class="form-horizontal form-groups-bordered" action="capturar_c.php"
							method="post">
							<div class="form-group">
								<input type="hidden" name="txtusu" value=<?php echo "$usu"; ?>>
								<div class="col-sm-12">
									<label
										class="col-sm-8 control-label"><b>CAJERO:.....<?php echo "$usu"; ?></b></label>
								</div>
							</div>
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label">Fecha:</label>
								<div class="col-sm-5">
									<input type="text" name="txtfec" class="form-control" required readonly="true"
										value="<?php echo "$dia"; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Caja:</label>
								<div class="col-sm-5">
									<input type="text" name="txtcaja" class="form-control" required readonly="true"
										value="<?php if (isset($caja))
											echo "$caja"; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Turno:</label>
								<div class="col-sm-5">
									<input type="text" name="txtturno" class="form-control" required readonly="true"
										value="<?php if (isset($turno))
											echo "$turno"; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label">Hora:</label>
								<div class="col-sm-5">
									<input type="text" name="txthor" class="form-control" required readonly="true"
										value="<?php echo "$hora"; ?>">
								</div>
							</div>

							<div class="form-group has-warning">
								<label for="field-1" class="col-sm-3 control-label">Total de Pagos en Efectivo:</label>
								<div class="col-sm-5">
									<input type="text" name="txtp_e" id="txtp_e" class="form-control" required readonly
										value="<?php if (isset($efectivo))
											echo $efectivo; ?>">
								</div>
							</div>

							<div class="form-group has-warning">
								<label for="field-1" class="col-sm-3 control-label">Total de Pagos con Tarjetas:</label>
								<div class="col-sm-5">
									<input type="text" name="txt_t" id="txt_t" class="form-control" required readonly
										value="<?php if (isset($tarjeta))
											echo $tarjeta; ?>">
								</div>
							</div>

							<div class="form-group has-warning">
								<label for="field-1" class="col-sm-3 control-label">Total de Pagos en depositos
									bancarios:</label>
								<div class="col-sm-5">
									<input type="text" name="txt_d" id="txtp_d" class="form-control" required readonly
										value="<?php if (isset($deposito))
											echo $deposito; ?>">
								</div>
							</div>

							<div class="form-group has-success">
								<label for="field-1" class="col-sm-3 control-label">Total de ventas:</label>
								<div class="col-sm-5">
									<input type="text" name="txttot" id="txttot" class="form-control" required
										readonly="true" value="<?php if (isset($total_formateado))
											echo $total_formateado; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label">Monto de apertura:</label>
								<div class="col-sm-5">
									<input type="text" name="txtmon" id="txtmon" class="form-control" required
										readonly="true" value="<?php if (isset($mon))
											echo $mon; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"><strong>Total en Caja
										Sistema:</strong></label>
								<div class="col-sm-5">
									<input type="text" name="txtsis" id="txtsis" class="form-control" required
										readonly="true" value="
							<?php
							if (isset($total_formateado))
								echo $grantotal = number_format($total_formateado + $mon, 2, ".", "");
							?>">
								</div>
							</div>
							<div class="form-group">
								<label for="field-1" class="col-sm-3 control-label">Efectivo en Caja:</label>
								<div class="col-sm-5">
									<input type="number" name="txtefe" id="txtefe" min="0" step="0.01"
										max="<?php echo "$grantotal"; ?>" class="form-control" required
										placeholder="ingrese el monto que se encuentra en la caja fisica">
								</div>
							</div>
							<div class="form-group has-error">
								<label for="field-1" class="col-sm-3 control-label">Diferencia de caja esta
									faltando:</label>
								<div class="col-sm-5">
									<input type="text" name="txtfalta" id="txtfalta" class="form-control" required
										readonly="true">
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-5">
									<a class="btn btn btn-green" href="movimiento.php"><i class="entypo-cancel"></i>
										CANCELAR</a></button>
									<button type="submit" name="funcion" value="registrar" class="btn btn-info">CERRAR
										CAJA</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once("../central/pieproducto.php"); ?>
<script>
	$(document).ready(function () {
		$("#txtefe").blur(function (e) {
			var sistema = $("#txtsis").val();
			var efectivo = $("#txtefe").val();
			var falta = parseFloat(sistema) - parseFloat(efectivo);
			//alert(vuelto);
			$("#txtfalta").val(falta.toFixed(2));
		});
	});
</script>