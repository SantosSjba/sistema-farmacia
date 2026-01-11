<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
//$idsucursal=$_SESSION["sucursal"];
$data=$obj->consultar("SELECT * FROM configuracion WHERE idconfi='1'");
		    foreach($data as $row){
				$imagen=$row["logo"];
        $tipodoc=$row["tipodoc"];
				$ruc=$row["ruc"];
				$razon_social=$row["razon_social"];
				$nombre_comercial=$row["nombre_comercial"];
				$direccion=$row["direccion"];
				$pais=$row["pais"];
				$departamento=$row["departamento"];
				$provincia=$row["provincia"];
				$distrito=$row["distrito"];
				$ubigeo=$row["ubigeo"];
				$usuario_sol=$row["usuario_sol"];
				$clave_sol=$row["clave_sol"];
				$simbolo_moneda=$row["simbolo_moneda"];
				$impuesto=$row["impuesto"];
				//$horario=$row["horario"];
		}
?>
<!DOCTYPE html>
<div class="page-container">
	<div class="main-content">
<?php include('../central/cabecera.php');?>
<hr />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
				Configuracion
				</div>
			</div>
			<div class="panel-body">
					<form role="form"  action="capturar.php" name="miformulario" method="post" enctype="multipart/form-data">
			    <div class="col-md-6 form-group">
							<label>Razon Social(*):</label>
			    <input type="text" class="form-control" required placeholder="ingrese la razon social" name="txtra" value="<?php echo $razon_social;?>">
			    </div>
			    <div class="col-md-6 form-group">
			        <label>Nombre Comercial(*):</label>
			       <input type="text" class="form-control" required  name="txtnoc" value="<?php echo $nombre_comercial;?>">
			    </div>
					<div class="col-md-6 form-group">
							<label>Impuesto%(*):</label>
						 <input type="number" class="form-control" required  name="txtimp" step="any" value="<?php echo $impuesto;?>">
					</div>
			    <div class="col-md-6 form-group">
			            	<label>RUC(*):</label>
				<input type="text" class="form-control" required name="txtruc" value="<?php echo $ruc;?>">
			    </div>
					<div class="col-md-6 form-group">
														 <label>Direccion(*):</label>
				 <input type="text" class="form-control" required name="txtdir" value="<?php echo $direccion;?>">
				 </div>
				 <div class="col-md-6 form-group">
														 <label>Moneda(*):</label>
				 <input type="text" class="form-control" required name="txtmon" value="<?php echo 'S/';?>" readonly>
				 </div>
				 <div class="col-md-6 form-group">
														 <label>Departamento(*):</label>
				 <input type="text" class="form-control" required name="txtdepa" value="<?php echo $departamento;?>">
				 </div>
				 <div class="col-md-6 form-group">
														 <label>Provincia(*):</label>
				 <input type="text" class="form-control" required  name="txtpro" value="<?php echo $provincia;?>">
				 </div>
				 <div class="col-md-6 form-group">
														 <label>Distrito(*):</label>
				 <input type="text" class="form-control" required name="txtdist" value="<?php echo $distrito;?>">
				 </div>
				 <div class="col-md-6 form-group">
														 <label>Ubigeo(*):</label>
				 <input type="text" class="form-control" required name="txtubigeo" value="<?php echo $ubigeo;?>">
				 </div>
			    <div class="col-md-6 form-group">
			            						<label>Usuario Sol(*):</label>
			  	<input type="text" class="form-control" required name="txtususol" value="<?php echo $usuario_sol;?>">
			    </div>
					<div class="col-md-6 form-group">
															<label>Clave Sol(*):</label>
					<input type="password" class="form-control" required name="txtclavesol" value="<?php echo $clave_sol;?>">
					</div>
			    <div class="col-md-6 form-group">
			                      <label>Logo(.jpg y.png)</label>
			                      <input type="file" name="imagen" size="44" accept="image/jpeg" class="form-control file2 inline btn btn-primary" data-label="<i class='glyphicon glyphicon-file'></i> seleccionar imagen" />
			                    </div>

			    <div class="col-md-6 form-group">
			                        <label></label>
			                        <img src="foto/<?php echo $imagen ?>" width="160px" height="140px" border="1"><input type="hidden" name="img_eliminar_1" value="<?php echo $imagen ?>">
			                    </div>
       </div>
			    <div class="panel-footer">
			            <div align="right">
			              <button type="submit" value="modificar" class="btn btn-info"><i class="entypo-pencil"></i>Modificar</button>
			              <input type="hidden" name="funcion" id="funcion" value="modificar"/>
			              <input type="hidden" name="cod" value="<?php echo $cod;?>"/>
			                   <a class="btn btn btn-green" href="configuracion.php"><i class="entypo-cancel"></i> Cancelar</a></button>
			            </div>
			    </div>
			  </form>
		</div>
	</div>
</div>
</div>
</div>
<?php include("../central/pieproducto.php");?>
<script type="text/javascript">
window.addEventListener("load", function() {
miformulario.txtimpnum.addEventListener("keypress", soloNumeros, false);
});
//Solo permite introducir numeros.
function soloNumeros(e){
var key = window.event ? e.which : e.keyCode;
if (key < 48 || key > 57) {
e.preventDefault();
}
}
</script>
