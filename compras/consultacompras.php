<?php
include("../seguridad.php");
include("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
ob_start();
$usu=$_SESSION["usuario"];
$objVentas=new clsConexion;
$result=$objVentas->consultar("select * from compra ORDER BY idcompra DESC");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8_spanish_ci" />
</head>
		<div class="page-container">
	<div class="main-content">
	<?php include('../central/cabecera.php');?>
<hr/>
<h2>Compras</h2>
<br/>
<div class="table-responsive">
  <table id="my-example" class="table table-striped">
		<thead>
		<tr>
			<th><a href="#">Documento</a></th>
			<th data-hide="phone"><a href="#">Numero.</a></th>
			<th><a href="#">Fecha</a></th>
			<th><a href="#">Total</a></th>
			<th>Exportar</th>
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
        url: 'datatablecompra.php',
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
