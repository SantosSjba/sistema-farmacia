<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
date_default_timezone_set('america/lima');
$dia= date("Y-m-d");
$hora=date("g:i-a");
ob_start();
$usu=$_SESSION["usuario"];

?>
<div class="page-container">
	<div class="main-content">
<hr/>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					APERTURA DE CAJA
				</div>
			</div>
			<div class="panel-body">
				<form role="form" class="form-horizontal form-groups-bordered" action="capturar_a.php" method="post">
					<div class="form-group">
							<input type="hidden" name="txtusu" value=<?php echo "$usu"; ?>>
						<div class="col-sm-12">
	                 <label class="col-sm-8 control-label" ><b>CAJERO:.....<?php echo "$usu"; ?></b></label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label" >Fecha:</label>
						<div class="col-sm-5">
							<input type="text" name="txtfec" class="form-control" required readonly="true" value="<?php echo "$dia"; ?>">
						</div>
					</div>
						<div class="form-group">
						<label class="col-sm-3 control-label"><strong>Caja:</strong></label>
							<div class="col-sm-5">
							<select name="txtcaja" class="form-control" required>
										<option value="caja 1">CAJA 1</option>
										<option value="caja 2">CAJA 2</option>
							</select>
							</div>
					</div>
					<div class="form-group">
					<label class="col-sm-3 control-label"><strong>Turno:</strong></label>
						<div class="col-sm-5">
						<select name="txtturno" class="form-control" required>
									<option value="mañana">MAÑANA</option>
									<option value="tarde">TARDE</option>
									<option value="noche">NOCHE</option>
									<option value="completo">COMPLETO</option>
						</select>
						</div>
				</div>
          <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">Hora:</label>
						<div class="col-sm-5">
							<input type="text" name="txthor" class="form-control" required readonly="true" value="<?php echo "$hora"; ?>">
						</div>
					</div>
          <div class="form-group">
						<label for="field-1" class="col-sm-3 control-label">Monto de apertura:</label>
						<div class="col-sm-5">
							<input type="number" class="form-control" min="0" name="txtmon" id="txtmon" required  placeholder="ingrese el monto para la apertura de la caja">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
								 <a class="btn btn btn-green" href="movimiento.php"><i class="entypo-cancel"></i> CANCELAR</a></button>
							<button type="submit" name="funcion" value="registrar"  class="btn btn-info">APERTURAR CAJA</button>
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
<script type="text/javascript">
$( "#txtmon" ).blur(function() {
		this.value = parseFloat(this.value).toFixed(2);
});
</script>
