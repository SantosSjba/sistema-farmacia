<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
ob_start();
$usu=$_SESSION["usuario"];
////$idsucursal=$_SESSION["sucursal"];
?>
<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	<div class="main-content">
		<?php include('../central/cabecera.php');?>
<hr/>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Registrar lote
				</div>
			</div>
			<div class="panel-body">
				<form role="form" class="form-horizontal form-groups-bordered" action="capturar.php" method="post">
						<!--<input type="hidden" name="txtidsucu_c" value=<?php echo "$idsucursal"; ?>-->>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" >lote(*)</label>
						<div class="col-sm-5">
							<input type="text" name="txtlo" class="form-control" required placeholder="ingrese el lote">
						</div>
					</div>
					<div class="form-group">
						<label for="field-1" class="col-sm-3 control-label" >Fecha De Vencimiento(*)</label>
						<div class="col-sm-5">
										 <input type="date" name="txtfec" step="1"  class="form-control"  min="<?php echo date("Y-m-d");?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" name="funcion" value="registrar"  class="btn btn-info"><i class="entypo-check"></i>Registrar</button>
							 <a class="btn btn btn-default" href="index.php"><i class="entypo-cancel"></i>Cancelar</a></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
