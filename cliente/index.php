<?php
include("../seguridad.php");
include_once("../central/centralproducto.php");
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
?>
<!DOCTYPE html>
<html lang="en">
<body class="page-body" data-url="http://neon.dev">
<!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
		<div class="page-container">
	<div class="main-content">
	<?php include('../central/cabecera.php');?>
<hr/>

<h2>Cliente-Laboratorio</h2>
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
					<th><a href="#">Razon social</a></th>
					<th data-hide="phone"><a href="#">Direccion</a></th>
					<th><a href="#">N.Documento</a></th>
					<th>Editar</th>
					<th>Eliminar</th>
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
 <link rel="stylesheet" href="../assets/alert/alertify/alertify.css">
 <link rel="stylesheet" href="../assets/alert/alertify/themes/default.css">
 <script src="../assets/alert/alertify/alertify.js"></script>
 <script type="text/javascript">
 //funcion eliminar
 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id");
  alertify.confirm('Mensaje', 'Realmente desea eliminar?', function(e){
 	 if(e) {
 		 $.ajax({
 			url:"eliminar.php",
 			method:"POST",
 			data:{id:id},
 			success:function(data){
 				location.reload(true);
 			}
 	});
 	 }
  }, function(){ alertify.error('Cancelado')});
 });
 </script>
<br /><!-- Footer -->
	</div>
</div>
</body>
</html>
