<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");

$obj=new clsConexion;

$cod=trim($obj->real_escape_string(htmlentities(strip_tags($_GET['idusu'],ENT_QUOTES))));
$data=$obj->consultar("SELECT * FROM usuario WHERE idusu='".$obj->real_escape_string($cod)."'");
		foreach($data as $row){
			  $n= $row['nombres'];
        $email= $row['email'];
        $tel= $row['telefono'];
		    $fec= $row['fechaingreso'];
		    $e= $row['estado'];
				$cu= $row['cargo_usu'];
				$u= $row['usuario'];
				$cl= $row['clave'];
				$t= $row['tipo'];

		}
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
				<div class="panel-title">Actualizar usuario   (*cambiar la clave despues de modificar)</div>
			</div>
			<div class="panel-body">
				<form role="form" name="miformulario" action="capturar.php" method="post" >
				  <div class="col-md-6 form-group">
				      <label><strong>Nombre(*)</strong></label>
				      <input type="text" name="txtn" class="form-control" required placeholder="ingrese su nombre" value="<?php echo $n?>">
				  </div>

				  <div class="col-md-6 form-group">
				      <label><strong>Email</strong></label>
				    <input type="text" name="txtmail"class="form-control"  maxlength="50" placeholder="ingrese su email" value="<?php echo $email?>">
				  </div>

				  <div class="col-md-6 form-group">
				      <label><strong>Telefono:</strong></label>
				    <input type="text" name="txtt"class="form-control" id="field-file" maxlength="15" placeholder="ingrese su Telefono" value="<?php echo $tel?>">
				  </div>

				  <div class="col-md-6 form-group">
				      <label><strong>Fecha Ingreso(*)</strong></label>
				<input type="date" name="txtfec"class="form-control" required id="field-file" value="<?php echo $fec?>">
				  </div>

				  <div class="col-md-6 form-group">
				      <label><strong>Cargo(*)</strong></label>
				  <input type="text" name="txtca"class="form-control" required id="field-file" maxlength="15" placeholder="ingrese su cargo" value="<?php echo $cu?>">
				  </div>

				      <div class="col-md-6 form-group">
				        <label><strong>Estado(*)</strong></label>
				        <select name="txte" class="form-control">
				                          <option value="Activo" <?php if($e=='Activo'){ echo 'selected'; } ?>>Activo</option>
				                            <option value="Inactivo" <?php if($e=='Inactivo'){ echo 'selected'; } ?>>Inactivo</option>
				        </select>
				      </div>
				      <div class="col-md-6 form-group">
				        <label><strong>Tipo(*)</strong></label>
				        <select name="txttipo" class="form-control">
				                          <option value="ADMINISTRADOR" <?php if($t=='ADMINISTRADOR'){ echo 'selected'; } ?>>ADMINISTRADOR</option>
				                            <option value="USUARIO" <?php if($t=='USUARIO'){ echo 'selected'; } ?>>USUARIO</option>
				        </select>
				      </div>
				      <div class="col-md-6 form-group">
				        <label><strong>Usuario(*)</strong></label>
				        <input type="text" name="txtu"class="form-control" required  maxlength="50" placeholder="ingrese su usuario" autocomplete="off" value="<?php echo $u?>">
				      </div>
				      <div class="col-md-6 form-group">
				        <label><strong>Clave(*)</strong></label>
				        <input type="password" name="txtcl"class="form-control"required   maxlength="50" placeholder="ingrese su clave" autocomplete="off" value="<?php echo $cl?>">
				      </div>
				      <div class="col-md-6 form-group">
				      </div>
				</div>
				<div class="panel-footer">
				        <div align="right">
				          <button type="submit" value="modificar" class="btn btn-info"><i class="entypo-pencil"></i>Modificar</button>
				          <input type="hidden" name="funcion" id="funcion" value="modificar"/>
				          <input type="hidden" name="cod" value="<?php echo $cod;?>"/>
				               <a class="btn btn btn-green" href="index.php"><i class="entypo-cancel"></i> Cancelar</a></button>
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
