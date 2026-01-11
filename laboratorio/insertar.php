<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include("../conexion/clsConexion.php");
$obj=new clsConexion;
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
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
					Registrar Laboratorio Proveedor
				</div>
			</div>
			<div class="panel-body">
		    <form role="form" name="miformulario" action="capturar.php" method="post" >
								<!--<input type="hidden" name="txtidsucu_c" value=<?php echo "$idsucursal"; ?>-->>
					<div class="col-md-6 form-group">
							<label><strong>Laboratorio(*)</strong></label>
					  <input type="text" name="txtla" class="form-control" required placeholder="ingrese el laboratorio">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Ruc(*)</strong></label>
					<input type="text" name="txtr" class="form-control" required id="field-file" maxlength="11" placeholder="ingrese su ruc" title="El numero de RUC debe contener 11 digitos" pattern="[0-9]{11}">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Direccion(*):</strong></label>
					        <input type="text"  name="txtdir" class="form-control"required  id="field-file" placeholder="ingrese su Direccion">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Telf(*)</strong></label>
						<input type="text" name="txtt"class="form-control" required id="field-file" maxlength="15" placeholder="ingrese su Telefono">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>E-mail:</strong></label>
			        <input type="text"  name="txtemail" class="form-control" id="field-file"  placeholder="ingrese su email ">
					</div>
				</div>

					<div class="panel-footer">
									<div align="right">
										<div align="left">
											(*) campos obligatorios
										</div>
										<button type="submit" name="funcion" value="registrar"  class="btn btn-info btn-icon icon-left"><i class="entypo-check"></i>Registrar</button>
										 <a class="btn btn-green btn-icon icon-left" href="index.php"><i class="entypo-cancel"></i>Cancelar</a>
									</div>
					</div>

				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
