<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
?>
<!DOCTYPE html>
<head>
	<style media="screen">
	.label-as-badge{
	 border-radius: 1em;
}
	</style>
</head>
<html lang="en">
<div class="page-container ">
	<div class="main-content">
<h3>Productos Farmaceuticos</h3>
<div class="table-responsive">
<table id="my-example" class="table table-striped">
  <thead>
    <tr>
						<th><a href="#">Codigo</a></th>
						<th><a href="#">Descripcion</a></th>
            <th><a href="#">Presentacion</a></th>
						<th><a href="#">Fec. venc</a></th>
						<th><a href="#">Stock</a></th>
						<th data-hide="phone"><a href="#">P.venta</a></th>
            <th data-hide="phone,tablet"><a href="#">Tipo</a></th>
						<th data-hide="phone"><a href="#">Estado</a></th>
					  <th data-hide="phone,tablet"><a href="#">Sintomas</a></th>
            <th><a href="#">Lote</a></th>
            <th><a href="#">Descuento</a></th>
            <th><a href="#">venta sujeta</a></th>
            <th><a href="#">Similar</a></th>
    </tr>
  </thead>
</table>
</div>
<?php include_once("../central/pieproducto.php"); ?>
<script type="text/javascript">
$(document).ready(function() {
  tabla=$('#my-example').dataTable(
{
  "aProcessing": true,//Activamos el procesamiento del datatables
  "aServerSide": true,//Paginación y filtrado realizados por el servidor
  dom: 'Bfrtip',//Definimos los elementos del control de tabla
  buttons: [
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdf'
        ],
"ajax":
    {
            url: 'datatable.php',
      type : "get",
      dataType : "json",
      error: function(e){
        console.log(e.responseText);
      }
    },
"bDestroy": true,
"iDisplayLength": 10,//Paginación
  "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
}).DataTable();
 });
</script>

<br /><!-- Footer -->
	</div>
</div>
</html>
