<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$objusuario=new clsConexion;

//print_r($result);
?>
<!DOCTYPE html>
<html lang="en">
<!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
		<div class="page-container">
	<div class="main-content">
	<!-- <?php include('../central/cabecera.php');?> -->
<hr/>
<h2>usuario</h2>
<br />
<a href="insertar.php" class="btn btn-primary">
	<i class="entypo-plus"></i>
	Nuevo
</a>
<br/>
<br/>
<div class="table-responsive">
  <table id="my-example" class="table table-striped">
		<thead>
		<tr>
			<th><a href="#">Nombre </a></th>
			<th><a href="#">Telefono</a></th>
			<th data-hide="phone"><a href="#">Fecha Ingreso</a></th>
			 <th data-hide="phone"><a href="#">Estado</a></th>
			<th>Editar</th>
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
  "iDisplayLength": 5,//Paginación
    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
 }).DataTable();
   });
 </script>
<br /><!-- Footer -->
	</div>
</div>
</html>
