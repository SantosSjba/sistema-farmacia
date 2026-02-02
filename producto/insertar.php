<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$objproductos=new clsConexion;
ob_start();
//$idsucursal=$_SESSION["sucursal"];
$estado='';
$tipo='';
$sujeta='';
$tipo_pre='';

// Obtener IDs por defecto para productos generales
$id_categoria_default = 1;
$id_sintoma_default = 1;
$id_laboratorio_default = 1;
$id_lote_default = 1;

// Buscar categoria "No Aplica" o la primera disponible
$result_cat = $objproductos->consultar("SELECT idcategoria FROM categoria WHERE forma_farmaceutica LIKE '%No Aplica%' OR forma_farmaceutica LIKE '%General%' LIMIT 1");
if(empty($result_cat)) {
    $result_cat = $objproductos->consultar("SELECT idcategoria FROM categoria LIMIT 1");
}
foreach((array)$result_cat as $row) { $id_categoria_default = $row['idcategoria']; }

// Buscar sintoma "No Aplica" o el primero disponible
$result_sin = $objproductos->consultar("SELECT idsintoma FROM sintoma WHERE sintoma LIKE '%No Aplica%' OR sintoma LIKE '%General%' LIMIT 1");
if(empty($result_sin)) {
    $result_sin = $objproductos->consultar("SELECT idsintoma FROM sintoma LIMIT 1");
}
foreach((array)$result_sin as $row) { $id_sintoma_default = $row['idsintoma']; }

// Buscar laboratorio "SIN LABORATORIO" o el primero disponible
$result_lab = $objproductos->consultar("SELECT idcliente FROM cliente WHERE LOWER(tipo)='laboratorio' AND (nombres LIKE '%SIN LABORATORIO%' OR nombres LIKE '%GENERICO%' OR nombres LIKE '%NO APLICA%') LIMIT 1");
if(empty($result_lab)) {
    $result_lab = $objproductos->consultar("SELECT idcliente FROM cliente WHERE LOWER(TRIM(tipo))='laboratorio' LIMIT 1");
}
foreach((array)$result_lab as $row) { $id_laboratorio_default = $row['idcliente']; }

// Buscar lote "SIN LOTE" o el primero disponible
$result_lote = $objproductos->consultar("SELECT idlote FROM lote WHERE numero LIKE '%SIN LOTE%' OR numero LIKE '%0000%' ORDER BY numero DESC LIMIT 1");
if(empty($result_lote)) {
    $result_lote = $objproductos->consultar("SELECT idlote FROM lote LIMIT 1");
}
foreach((array)$result_lote as $row) { $id_lote_default = $row['idlote']; }
?>
<!DOCTYPE html>
<style>
.campos-farmaceuticos { transition: all 0.3s ease; }
.campos-ocultos { display: none !important; }
.badge-tipo { 
	display: inline-block; 
	padding: 5px 10px; 
	border-radius: 15px; 
	font-size: 12px; 
	margin-left: 10px;
}
.badge-medicamento { background-color: #28a745; color: white; }
.badge-general { background-color: #17a2b8; color: white; }
</style>
<div class="page-container">
	<div class="main-content">
	<?php include('../central/cabecera.php');?>
<hr />
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Registro de Productos <span id="badge-tipo" class="badge-tipo badge-medicamento">Medicamento</span>
				</div>
			</div>
			<div class="panel-body">
		    <form role="form" name="miformulario" action="capturar.php" method="post">
				
				<!-- SELECTOR DE CLASE DE PRODUCTO -->
				<div class="col-md-12 form-group" style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
					<label><strong>Clase de Producto:</strong></label>
					<div class="radio-inline">
						<label><input type="radio" name="clase_producto" value="medicamento" checked onclick="cambiarClaseProducto('medicamento')"> <strong>Medicamento</strong> (Producto Farmacéutico)</label>
					</div>
					<div class="radio-inline">
						<label><input type="radio" name="clase_producto" value="general" onclick="cambiarClaseProducto('general')"> <strong>Producto General</strong> (Peluches, Accesorios, etc.)</label>
					</div>
				</div>

				<div class="col-md-6 form-group">
						<label><strong>Codigo de Barra:</strong></label>
						<input type="text" class="form-control"  placeholder="ingrese codigo de barra" name="txtcb" id="txtcb">
				</div>
				<div class="col-md-6 form-group">
						<label><strong>Lote</strong></label>
						<select name="txtlo" id="txtlo" class='form-control' required>
							<?php
								// Ordenar para que "SIN LOTE" o "0000" aparezca primero
								$result=$objproductos->consultar("SELECT * FROM lote ORDER BY CASE WHEN numero LIKE '%SIN LOTE%' OR numero = '0000' THEN 0 ELSE 1 END, numero ASC");
								foreach((array)$result as $row){
									if($row['idlote']==$txtlo){
										echo '<option value="'.$row['idlote'].'" selected>'.$row['numero'].' (Vence: '.$row['fecha_vencimiento'].')</option>';
									}else{
										echo '<option value="'.$row['idlote'].'">'.$row['numero'].' (Vence: '.$row['fecha_vencimiento'].')</option>';
									}
								}
							?>
						</select>
				</div>

				<div class="col-md-6 form-group">
						<label><strong>Descripcion(*)</strong></label>
				<input type="text" class="form-control" required  placeholder="ingrese su descripcion" name="txtde">
				</div>
				<div class="col-md-6 form-group campos-farmaceuticos" id="campo-tipo">
					<label><strong>Tipo</strong></label>
						<select name="txtti" id="txtti" class="form-control">
															<option value="Generico" <?php  if($tipo=='Generico'){ echo 'selected'; } ?>>Generico</option>
															<option value="No Generico" <?php if($tipo=='No Generico'){ echo 'selected'; } ?>>No generico</option>
															<option value="No Aplica">No Aplica (Producto General)</option>
						</select>
				</div>
					<div class="col-md-6 form-group">
							<label><strong>Stock(*)</strong></label>
						<input type="text"   name="txtst"class="form-control" required  placeholder="ingrese el stock">
					</div>
					<div class="col-md-6 form-group">
							<label><strong>stock minimo(*)</strong></label>
						<input type="text"   name="txtstm"class="form-control" required  placeholder="ingrese el stock minimo">
					</div>
					<div class="col-md-6 form-group">
							<label><strong>precio compra(*)</strong></label>
						<input type="text"   name="txtpc"class="form-control" required  placeholder="ingrese el precio compra">
					</div>
					<div class="col-md-6 form-group">
							<label><strong>precio venta(*)</strong></label>
						<input type="text"   name="txtpv"class="form-control"required  placeholder="ingrese el precio venta">
					</div>
					<!-- <div class="col-md-6 form-group">
							<label><strong>Descuento</strong></label>
						<input type="text"  name="txtdes"class="form-control"  placeholder="ingrese el descuento">
					</div> -->
				<div class="col-md-6 form-group campos-farmaceuticos" id="campo-venta-sujeta">
					<label><strong>Venta Sujeta</strong></label>
						<select name="txtvs" id="txtvs" class="form-control">
															<option value="Con receta medica" <?php  if($sujeta=='Con receta medica'){ echo 'selected'; } ?>>Con receta medica</option>
															<option value="sin receta medica" <?php if($sujeta=='sin receta medica'){ echo 'selected'; } ?>>sin receta medica</option>
															<option value="No aplica">No aplica (Producto General)</option>
						</select>
				</div>
					<div class="col-md-6 form-group">
						<label>Fecha De Registro(*)</label>
							 <input type="text" name="txtfec" value="<?php echo (date('Y-m-d'));?>" class="form-control" readonly required="true"/>

					</div>
				<div class="col-md-6 form-group campos-farmaceuticos" id="campo-registro-sanitario">
						<label><strong>Registro Sanitario</strong></label>
					<input type="text" name="txtrs" class="form-control" placeholder="ingrese el registro sanitario">
				</div>
				<div class="col-md-6 form-group campos-farmaceuticos" id="campo-forma-farmaceutica">
						<label><strong>Forma Farmaceutica</strong></label>
						<select name="tcat" id="tcat" class='form-control'>
							<?php
																	$result=$objproductos->consultar("select * from categoria");
																	foreach((array)$result as $row){
																	if($row['idcategoria']==$tcat){
																		echo '<option value="'.$row['idcategoria'].'" selected>'.$row['forma_farmaceutica'].'</option>';
																	}else{
																		echo '<option value="'.$row['idcategoria'].'">'.$row['forma_farmaceutica'].'</option>';
																	}
																}
								?>
						</select>
				</div>
					<div class="col-md-6 form-group">
						<label  class="col-sm-3 control-label">Presentacion(*)</label>
							<select name="tpre" class='form-control' required>
								<?php
																		$result=$objproductos->consultar("select * from presentacion");
																		foreach((array)$result as $row){
																		if($row['idpresentacion']==$tpre){
																			echo '<option value="'.$row['idpresentacion'].'" selected>'.$row['presentacion'].'</option>';
																		}else{
																			echo '<option value="'.$row['idpresentacion'].'">'.$row['presentacion'].'</option>';
																		}
																	}
									?>
							</select>
					</div>
				<div class="col-md-6 form-group campos-farmaceuticos" id="campo-laboratorio">
					<label>Laboratorio/Proveedor</label>
						<select name="tidcli" id="tidcli" class='form-control'>
							<option value="">-- Seleccione Laboratorio --</option>
							<?php
								$result=$objproductos->consultar("SELECT * FROM cliente WHERE LOWER(TRIM(tipo))='laboratorio' ORDER BY nombres ASC");
								foreach((array)$result as $row){
									if($row['idcliente']==$tla){
										echo '<option value="'.$row['idcliente'].'" selected>'.$row['nombres'].'</option>';
									}else{
										echo '<option value="'.$row['idcliente'].'">'.$row['nombres'].'</option>';
									}
								}
							?>
						</select>
				</div>
				<div class="col-md-6 form-group campos-farmaceuticos" id="campo-sintomas">
					<label>Sintomas</label>
						<select name="tsi" id="tsi" class='form-control'>
							<?php
																	$result=$objproductos->consultar("select * from sintoma");
																	foreach((array)$result as $row){
																	if($row['idsintoma']==$tsi){
																		echo '<option value="'.$row['idsintoma'].'" selected>'.$row['sintoma'].'</option>';
																	}else{
																		echo '<option value="'.$row['idsintoma'].'">'.$row['sintoma'].'</option>';
																	}
																}
								?>
						</select>
				</div>

					<div class="col-md-6 form-group">
							<label><strong>Estado(*)</strong></label>
							<select name="txte" class="form-control" required>
	 															<option value="1" <?php if($estado=='1'){ echo 'selected'; } ?>>Activo</option>
	 																<option value="0" <?php if($estado=='0'){ echo 'selected'; } ?>>Inactivo</option>
	 						</select>
					</div>

					<div class="col-md-6 form-group">
						<label>Tipo Afectacion(*)</label>
						<select name="tafec" class='form-control'required>
							<?php
																	$result=$objproductos->consultar("select * from tipo_afectacion");
																	foreach((array)$result as $row){
																	if($row['idtipoa']==$tafec){
																		echo '<option value="'.htmlspecialchars($row['idtipoa'], ENT_QUOTES, 'UTF-8').'" selected>'.htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8').'</option>';
																	}else{
																		echo '<option value="'.htmlspecialchars($row['idtipoa'], ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8').'</option>';
																	}
																}
								?>
						</select>
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Tipo Precio(*)</strong></label>
							<select name="tipo_pre" class="form-control">
																<option value="01" <?php if($tipo_pre=='01'){ echo 'selected'; } ?>>Trabaja con IGV</option>
																<option value="02" <?php if($tipo_pre=='02'){ echo 'selected'; } ?>>Valor referencial unitario en operaciones no onerosas</option>
							</select>
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
<script type="text/javascript">
// Variables con IDs por defecto para productos generales
var idCategoriaDefault = <?php echo $id_categoria_default; ?>;
var idSintomaDefault = <?php echo $id_sintoma_default; ?>;
var idLaboratorioDefault = <?php echo $id_laboratorio_default; ?>;
var idLoteDefault = <?php echo $id_lote_default; ?>;

function cambiarClaseProducto(clase) {
	var camposFarmaceuticos = document.querySelectorAll('.campos-farmaceuticos');
	var badge = document.getElementById('badge-tipo');
	var tidcli = document.getElementById('tidcli');
	var txtlo = document.getElementById('txtlo');
	
	if(clase === 'general') {
		// Ocultar campos farmacéuticos
		camposFarmaceuticos.forEach(function(campo) {
			campo.classList.add('campos-ocultos');
		});
		
		// Cambiar badge
		badge.textContent = 'Producto General';
		badge.classList.remove('badge-medicamento');
		badge.classList.add('badge-general');
		
		// Establecer valores por defecto para campos ocultos
		document.getElementById('txtti').value = 'No Aplica';
		document.getElementById('txtvs').value = 'No aplica';
		document.getElementById('tcat').value = idCategoriaDefault;
		document.getElementById('tsi').value = idSintomaDefault;
		
		// Establecer laboratorio y lote por defecto
		if(tidcli) tidcli.value = idLaboratorioDefault;
		if(txtlo) txtlo.value = idLoteDefault;
		
		// Quitar required de campos farmacéuticos
		var camposNoRequired = ['txtti', 'txtvs', 'tcat', 'tsi', 'tidcli'];
		camposNoRequired.forEach(function(id) {
			var el = document.getElementById(id);
			if(el) el.removeAttribute('required');
		});
		
	} else {
		// Mostrar campos farmacéuticos
		camposFarmaceuticos.forEach(function(campo) {
			campo.classList.remove('campos-ocultos');
		});
		
		// Cambiar badge
		badge.textContent = 'Medicamento';
		badge.classList.remove('badge-general');
		badge.classList.add('badge-medicamento');
		
		// Restaurar valores por defecto para medicamentos
		document.getElementById('txtti').value = 'Generico';
		document.getElementById('txtvs').value = 'sin receta medica';
		
		// Limpiar selección de laboratorio para que elija manualmente
		if(tidcli) tidcli.value = '';
	}
}

// Inicializar en medicamento por defecto
document.addEventListener('DOMContentLoaded', function() {
	cambiarClaseProducto('medicamento');
});
</script>
<?php include("../central/pieproducto.php");?>