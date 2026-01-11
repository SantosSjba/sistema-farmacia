<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$objusuario=new clsConexion;
$result=$objusuario->consultar("select * from usuario");
$estado="";
$tipo="";
?>
<!DOCTYPE html>
<html lang="en">
<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	<div class="main-content">
	<!-- <?php include('../central/cabecera.php');?> -->
<hr />

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Registrar usuario
				</div>

			</div>
			<div class="panel-body">
				<form role="form" name="miformulario" action="capturar.php" method="post" >
					<div class="col-md-6 form-group">
							<label><strong>Nombre(*)</strong></label>
		          <input type="text" name="txtn" class="form-control" required placeholder="ingrese su nombre" >
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Email:</strong></label>
						<input type="text" name="txtmail"class="form-control"  maxlength="50" placeholder="ingrese su email">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Telefono:</strong></label>
						<input type="text" name="txtt"class="form-control" id="field-file" maxlength="15" placeholder="ingrese su Telefono">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Fecha Ingreso(*)</strong></label>
				<input type="date" name="txtfec"class="form-control" required id="field-file">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Cargo(*)</strong></label>
					<input type="text" name="txtca"class="form-control" required id="field-file" maxlength="15" placeholder="ingrese su cargo">
					</div>

							<div class="col-md-6 form-group">
								<label><strong>Estado(*)</strong></label>
								<select name="txte" class="form-control">
																	<option value="Activo" <?php if($estado=='Activo'){ echo 'selected'; } ?>>Activo</option>
																		<option value="Inactivo" <?php if($estado=='Inactivo'){ echo 'selected'; } ?>>Inactivo</option>
								</select>
							</div>
							<div class="col-md-6 form-group">
								<label><strong>Tipo(*)</strong></label>
								<select name="txttipo" class="form-control">
																	<option value="ADMINISTRADOR" <?php if($tipo=='ADMINISTRADOR'){ echo 'selected'; } ?>>ADMINISTRADOR</option>
																		<option value="USUARIO" <?php if($tipo=='USUARIO'){ echo 'selected'; } ?>>USUARIO</option>
								</select>
							</div>
							<div class="col-md-6 form-group">
								<label><strong>Usuario(*)</strong></label>
								<input type="text" name="txtu"class="form-control" required  maxlength="50" placeholder="ingrese su usuario" autocomplete="off">
							</div>
							<div class="col-md-6 form-group">
								<label><strong>Clave(*)</strong></label>
								<input type="password" name="txtcl"class="form-control"required   maxlength="50" placeholder="ingrese su clave" autocomplete="off">
							</div>
							<div class="col-md-6 form-group">
							</div>
				</div>

					<div class="panel-footer">
									<div align="right">
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
</html>
<?php include("../central/pieproducto.php");?>