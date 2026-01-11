<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
ob_start();
$usu=$_SESSION["usuario"];
// //$idsucursal=$_SESSION["sucursal"];
$objproductos=new clsConexion;

$cod=trim($objproductos->real_escape_string(htmlentities(strip_tags($_GET['idproducto'],ENT_QUOTES))));
$data=$objproductos->consultar("SELECT productos.descripcion
     , presentacion.presentacion
     , productos.idproducto
FROM
  productos
INNER JOIN presentacion
ON productos.idpresentacion = presentacion.idpresentacion WHERE idproducto='".$objproductos->real_escape_string($cod)."'");
		foreach($data as $row){
      $id=$row["idproducto"];
			$n=$row["descripcion"];
			$pre=$row["presentacion"];

		}
// asigna los productos similares
$result=$objproductos->consultar("SELECT * from producto_similar WHERE idproducto='$cod'");

$item = array();
$index = 1;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("../central/pieproducto.php");?>
  <!-- <link rel="stylesheet" href="../assets/alert/jquery-ui.css">
  <script src="../assets/alert/jquery-ui.js"></script> -->
    <link rel="stylesheet" href="../assets/ui/jquery-ui.css">
    <script src="../assets/ui/jquery-ui.min.js"></script>

<script type="text/javascript">
//busqueda de clientes
$(function() {
            $("#cli").autocomplete({
                source: "busquedaproductos.php",
                minLength: 2,
                select: function(event, ui) {
                event.preventDefault();
                  $('#cli').val(ui.item.descripcion);
                   $('#idproducto').val(ui.item.idproducto);
                   $('#presentacion').val(ui.item.presentacion);
           }
        });
    });
</script>

</head>
<div class="page-container">
	<div class="main-content">
<?php include('../central/cabecera.php');?>
<hr />

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">
			<div class="panel-heading">
				<div class="panel-title">
					Agregar productos Similares
				</div>
			</div>
			<div class="panel-body">
				<form role="form" name="miformulario" action="capturarsimilar.php" method="post">
					<div class="col-md-6 form-group">
							<label><strong>Descripcion</strong></label>
					<input type="text" class="form-control" required  readonly="true" value="<?php echo $n;?>">
					</div>
					<div class="col-md-6 form-group">
							<label><strong>Presentacion</strong></label>
					<input type="text" class="form-control" required readonly="true" value="<?php echo $pre;?>">
					</div>
          <input type="hidden" class="form-control" name="txtid" required readonly="true" value="<?php echo $id;?>">
          <div class="col-md-6 form-group">
              <label><strong>Descripcion</strong></label>
          <input type="text" class="form-control" required  name="txtde" autocomplete="off" id="cli" >
          </div>
          <div class="col-md-6 form-group">
              <label><strong>Presentacion</strong></label>
          <input type="text" class="form-control" required  name="txtpre"  id="presentacion" readonly="true">
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
			<table class="table table-bordered datatable" id="table-1">
			        <thead>
									<tr class="info">
									<th data-hide="phone"><a href="#">#</a></th>
									<th><a href="#">Descripcion</a></th>
									<th><a href="#">Presentacion</a></th>
									<th>Acciones</th>
								  </tr>
					</thead>
							<tbody>
					<?php
					foreach((array)$result as $row){
							$item[$index] = $row;
						?>
								<tr>
								<td><?php echo $index++; ?></td>
			          <td><?php echo $row['producto']; ?></td>
								<td><?php echo $row['presentacion']; ?></td>
								<td>
										<?php echo "<a href='eliminarsimilar.php?cod=".$row['idproducto']."' class='btn btn-danger btn-sm btn-icon icon-left'><i class='entypo-cancel'></i>Quitar</a>"?>
								</tr>
						<?php
						};
					?>
							</tbody>
			</table>
		</div>

	</div>

</div>
</div>
</div>
</html>
