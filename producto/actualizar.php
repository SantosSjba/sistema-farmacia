<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
ob_start();
$usu=$_SESSION["usuario"];
////$idsucursal=$_SESSION["sucursal"];
$objproductos=new clsConexion;

$cod=trim($objproductos->real_escape_string(htmlentities(strip_tags($_GET['idproducto'],ENT_QUOTES))));
$data=$objproductos->consultar("SELECT * FROM productos WHERE idproducto='".$objproductos->real_escape_string($cod)."'");
		foreach($data as $row){
			$cb=$row["codigo"];
			$n=$row["descripcion"];
			$stock=$row["stock"];
			$stockmin=$row["stockminimo"];
			$pc=$row["precio_compra"];
			$pv=$row["precio_venta"];
			$fec=$row["fecha_registro"];
			$tcat=$row["idcategoria"];
			$tsi=$row["idsintoma"];
			$tla=$row["idcliente"];
			$tpre=$row["idpresentacion"];
			$estado=$row["estado"];
			$tipo=$row["tipo"];
			$sujeta=$row["ventasujeta"];
			$lote=$row["idlote"];
			$rs=$row["reg_sanitario"];
		  //$des=$row["descuento"];
			$tafec=$row["idtipoaf"];
			$tipo_pre=$row["tipo_precio"];
		}

?>
<!DOCTYPE html>
<html lang="en">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	<div class="main-content">
<?php include('../central/cabecera.php');?>
<hr />

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Actualizar productos
				</div>
			</div>

			<div class="panel-body">
				<form role="form" name="miformulario" action="capturar.php" method="post" >
					<div class="col-md-6 form-group">
							<label><strong>Codigo de Barra:</strong></label>
							<input type="text" class="form-control"  placeholder="ingrese codigo de barra" name="txtcb" id="txtcb" value="<?php echo $cb;?>">
					</div>

				<div class="col-md-6 form-group">
						<label><strong>Lote</strong></label>
						<select name="txtlo" class='form-control'>
								<?php
																		$result=$objproductos->consultar("select * from lote");
																		foreach((array)$result as $row){
																		if($row['idlote']==$lote){
																			echo '<option value="'.$row['idlote'].'" selected>'.$row['numero'].'</option>';
																		}else{
																			echo '<option value="'.$row['idlote'].'">'.$row['numero'].'</option>';
																		}
																	}
									?>
							</select>
					</div>

					<div class="col-md-6 form-group">
							<label><strong>Descripcion(*)</strong></label>
					<input type="text" class="form-control" required  placeholder="ingrese su descripcion" name="txtde" value="<?php echo $n;?>">
					</div>

				<div class="col-md-6 form-group">
					<label><strong>Tipo</strong></label>
						<select name="txtti" class="form-control">
															<option value="Generico" <?php  if($tipo=='Generico'){ echo 'selected'; } ?>>Generico</option>
															<option value="No Generico" <?php if($tipo=='No Generico'){ echo 'selected'; } ?>>No generico</option>
															<option value="No Aplica" <?php if($tipo=='No Aplica'){ echo 'selected'; } ?>>No Aplica (Producto General)</option>
						</select>
				</div>

					<div class="col-md-6 form-group">
							<label><strong>Stock(*)</strong></label>
						<input type="text"   name="txtst"class="form-control" required  placeholder="ingrese el stock" value="<?php echo $stock;?>" >
					</div>

					<div class="col-md-6 form-group">
							<label><strong>stock minimo(*)</strong></label>
						<input type="text"   name="txtstm"class="form-control" required  placeholder="ingrese el stock minimo" value="<?php echo $stockmin;?>">
					</div>
					<div class="col-md-6 form-group">
							<label><strong>precio compra(*)</strong></label>
						<input type="text"   name="txtpc"class="form-control" required  placeholder="ingrese el precio compra" value="<?php echo $pc;?>">
					</div>
					<div class="col-md-6 form-group">
							<label><strong>precio venta(*)</strong></label>
						<input type="text"   name="txtpv"class="form-control"required  placeholder="ingrese el precio venta" value="<?php echo $pv;?>">
					</div>
					<!-- <div class="col-md-6 form-group">
							<label><strong>Descuento</strong></label>
						<input type="text"  name="txtdes"class="form-control" placeholder="ingrese el descuento" value="<?php echo $des;?>">
					</div> -->
				<div class="col-md-6 form-group">
					<label><strong>Venta Sujeta</strong></label>
						<select name="txtvs" class="form-control">
															<option value="Con receta medica" <?php  if($sujeta=='Con receta medica'){ echo 'selected'; } ?>>Con receta medica</option>
															<option value="sin receta medica" <?php if($sujeta=='sin receta medica'){ echo 'selected'; } ?>>sin receta medica</option>
															<option value="No aplica" <?php if($sujeta=='No aplica'){ echo 'selected'; } ?>>No aplica (Producto General)</option>
						</select>
				</div>
					<div class="col-md-6 form-group">
						<label>Fecha De Registro(*)</label>
							 <input type="text" name="txtfec" value="<?php echo $fec;?>" require class="form-control" readonly />
					</div>
					<div class="col-md-6 form-group">
							<label><strong>Registro Sanitario</strong></label>
						<input type="text"   name="txtrs"class="form-control"  placeholder="ingrese el registro sanitario" value="<?php echo $rs;?>">
					</div>
				<div class="col-md-6 form-group">
						<label><strong>Forma Farmaceutica</strong></label>
						<select name="tcat" class='form-control'>
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
			<div class="col-md-6 form-group">
				<label>Laboratorio/Proveedor</label>
					<select name="tidcli" class='form-control'>
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
				<div class="col-md-6 form-group">
					<label>Sintomas</label>
						<select name="tsi" class='form-control'>
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
																	$result=$obj->consultar("select * from tipo_afectacion");
																	foreach((array)$result as $row){
																	if($row['idtipoa']==$tafec){
																		echo '<option value="'.$row['idtipoa'].'" selected>'.$row['descripcion'].'</option>';
																	}else{
																		echo '<option value="'.$row['idtipoa'].'">'.$row['descripcion'].'</option>';
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
					<div align="left">
						(*) campos obligatorios
					</div>
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
<?php include("../central/pieproducto.php");?>
