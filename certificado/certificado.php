<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
//$idsucursal=$_SESSION["sucursal"];
$data=$obj->consultar("SELECT * FROM certificado WHERE idcertificado='1'");
		    foreach($data as $row){
				$certificado=$row["certificado"];
       			$clave_certificado=$row["clave_certificado"];
				$estado=$row["estado"];
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
				Certificado
				</div>
			</div>
			<div class="panel-body">
	<form id="formulario" method="post" enctype="multipart/form-data">
						<div class="col-md-6 form-group">
															<label>Certificado .pfx(*):</label>
															<input type="file" class="form-control" name="imagen" id="imagen" required>
															<input type="hidden" name="certificado_actual" value="<?php echo htmlspecialchars($certificado); ?>">
															<p>Archivo actual: <?php echo htmlspecialchars($certificado); ?></p>
														</div>
			    <div class="col-md-6 form-group">
			        <label>clave certificado(*):</label>
			       <input type="password" class="form-control" name="c_ce" id="c_ce" placeholder="ingrese su clave del certificado" required value="<?php echo "$clave_certificado"; ?>">
			    </div>
					<div class="col-md-6 form-group">
							<label>estado(*):</label>
							<select name="est" id="est" class="form-control">
																<option value="Beta" <?php if($estado=='Beta'){ echo 'selected'; } ?>>Beta</option>
																<option value="Produccion" <?php if($estado=='Produccion'){ echo 'selected'; } ?>>Produccion</option>
							</select>
					</div>

       </div>
			    <div class="panel-footer">
			            <div align="right">
										<button type="button" name="btn_add" id="btn_add" class="btn btn-info"><i class="fa fa-save"></i> Configurar </button>
										<br>
										<small>Nota:(*) esperar 24 horas despues de crear su usuario y clave sol secundarios en la portal de la sunat</small>
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
$(document).on('click', '#btn_add', function(){
 var extension = $('#imagen').val().split('.').pop().toLowerCase();
	 if(extension != ''){
		if(jQuery.inArray(extension, ['pfx']) == -1)
		{
		 alert("Archivo no valido");
		 $('#imagen').val('');
		 return false;
		}
	 }
		var formData = new FormData($("#formulario")[0]);
		$.ajax({
				 url:"accion.php",
				 method:"POST",
				 data: formData,
				 contentType:false,
				 processData:false,
							success:function(data){
								alert(data);
								 window.location = 'certificado.php';
								//console.log(data);
				}
		})
});
</script>
