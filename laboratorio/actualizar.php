<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include("../conexion/clsConexion.php");
$obj=new clsConexion;
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
$cod=trim($obj->real_escape_string(htmlentities(strip_tags($_GET['idlab_pro'],ENT_QUOTES))));
$data=$obj->consultar("SELECT * FROM laboratorio_proveedor WHERE idlab_pro='".$obj->real_escape_string($cod)."'");
		foreach($data as $row){
			  $lab= $row['laboratorio'];
				$r= $row['ruc'];
				$dir= $row['direccion'];
				$tel= $row['telefono'];
				$email= $row['email'];
		}
?>
<!DOCTYPE html>
<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	<div class="main-content">
<?php include('../central/cabecera.php');?>
<hr/>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Actualizar Laboratorio Proveedor
				</div>
			</div>
			<div class="panel-body">
		    <form role="form" name="miformulario" action="capturar.php" method="post">
					<div class="col-md-6 form-group">
							<label><strong>Laboratorio(*)</strong></label>
					<input type="text" name="txtla" class="form-control" required placeholder="ingrese la Forma Farmaceutica" value="<?php echo $lab?>">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Ruc(*)</strong></label>
					<input type="text" maxlength="11" name="txtr" required class="form-control" id="field-file" placeholder="ingrese su ruc" value="<?php echo $r; ?>"title="El numero de RUC debe contener 11 digitos" pattern="[0-9]{11}">
</div>
					<div class="col-md-6 form-group">
							<label><strong>Direccion(*):</strong></label>
					        <input type="text" name="txtdir" class="form-control" required id="field-file" placeholder="ingrese su direccion" value="<?php echo $dir ?>">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Telf(*)</strong></label>
					<input type="text" name="txtt"class="form-control" required  maxlength="15" id="field-file" placeholder="ingrese su telefono" value="<?php echo $tel ?>">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>E-mail:</strong></label>
			  	<input type="text"  name="txtemail" class="form-control" id="field-file" placeholder="ingrese su email" value="<?php echo $email; ?>" >
					</div>
				</div>

					<div class="panel-footer">
									<div align="right">
										<div align="left">
											(*) campos obligatorios
										</div>
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
