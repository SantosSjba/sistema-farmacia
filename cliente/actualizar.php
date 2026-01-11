<?php include("../seguridad.php");
include_once("../central/centralproducto.php");
ob_start();
 $usu=$_SESSION["usuario"];
 $estado='';
 $tipo='';
 //$idsucursal=$_SESSION["sucursal"];
 $cod=trim($obj->real_escape_string(htmlentities(strip_tags($_GET['idcliente'],ENT_QUOTES))));
 $data=$obj->consultar("SELECT
  cliente.*,
  tipo_documento.idtipo_docu
FROM cliente
  INNER JOIN tipo_documento
    ON cliente.id_tipo_docu = tipo_documento.idtipo_docu
		 WHERE idcliente='".$obj->real_escape_string($cod)."'");
 foreach($data as $row){
	  $n= $row['nombres'];
		$tipo=$row['id_tipo_docu'];
	  $dir= $row['direccion'];
	  $nrodoc= $row['nrodoc'];
		$tipocli= $row['tipo'];
	 }
	 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<script type="text/javascript">
	window.addEventListener("load", function() {
miformulario.txtdo.addEventListener("keypress", soloNumeros, false);
});

//Solo permite introducir numeros.
function soloNumeros(e){
var key = window.event ? e.which : e.keyCode;
if (key < 48 || key > 57) {
	e.preventDefault();
}
}
	</script>
</head>
<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	<div class="main-content">
	<?php include('../central/cabecera.php');?>
<hr/>
<br/>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Actualizar Cliente-Laboratorio
				</div>
			</div>
			<div class="panel-body">
				<form role="form" name="miformulario" action="capturar.php" method="post" >
					<div class="col-md-6 form-group">
							<label><strong>Razon social(*)</strong></label>
						<input type="text" name="txtno" class="form-control" required placeholder="ingrese su nombre"  value="<?php echo $n?>" >
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Tipo Documento(*)</strong></label>
							<select name="td" class="form-control" required id="td">
																<option value="1" <?php  if($tipo=='1'){ echo 'selected'; } ?>>SIN DOCUMENTO</option>
																<option value="2" <?php if($tipo=='2'){ echo 'selected'; } ?>>DNI</option>
																<option value="3" <?php if($tipo=='3'){ echo 'selected'; } ?>>CARNET DE EXTRANJERIA</option>
																<option value="4" <?php  if($tipo=='4'){ echo 'selected'; } ?>>RUC</option>
																<option value="5" <?php  if($tipo=='5'){ echo 'selected'; } ?>>PASAPORTE</option>
																<option value="6" <?php if($tipo=='6'){ echo 'selected'; } ?>>Ced. Diplomática de identidad</option>
							</select>
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Direccion:</strong></label>
						<input type="text"  name="txtdi"class="form-control"  placeholder="ingrese su direccion"  value="<?php echo $dir?>">
					</div>

					<div class="col-md-6 form-group">
							<label><strong>N. Documento(*)</strong></label>
						<input type="text"   name="txtnrodoc" class="form-control"  placeholder="ingrese su email"  value="<?php echo $nrodoc?>">
					</div>
					<div class="col-md-6 form-group">
							<label><strong>Tipo Cliente(*)</strong></label>
							<select name="txttipo" class="form-control">
																<option value="cliente" <?php if($tipocli=='cliente'){ echo 'selected'; } ?>>cliente</option>
																	<option value="laboratorio" <?php if($tipocli=='laboratorio'){ echo 'selected'; } ?>>laboratorio</option>
							</select>
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
</html>
