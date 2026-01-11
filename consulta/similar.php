<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
$objproductos=new clsConexion;
$cod=trim($objproductos->real_escape_string(htmlentities(strip_tags($_GET['idproducto'],ENT_QUOTES))));
// asigna los productos similares
$result=$objproductos->consultar("SELECT * from producto_similar WHERE idproducto='$cod'");
$item = array();
$index = 1;
?>
<!DOCTYPE html>
<html lang="en">

<div class="page-container">
	<div class="main-content">
<?php include('../central/cabecera.php');?>
<hr />
<h3>Productos Farmaceuticos Similares</h3>
<a href="index.php" class="btn btn-primary">
<i class="entypo-fast-backward"></i>Regresar</a>
<br/>
<br/>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info" data-collapsed="0">

      	<div class="panel-body">
      <table class="table table-bordered datatable" id="table-1">
              <thead>
                  <tr class="info">
                  <th data-hide="phone"><a href="#">#</a></th>
                  <th><a href="#">Descripcion</a></th>
                  <th><a href="#">Presentacion</a></th>
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
</div>
</div>
</html>
<?php include("../central/pieproducto.php");?>
