<?php
include("../seguridad.php");
include("../central/centralproducto.php");
include("../conexion/clsConexion.php");
ob_start();
$usu=$_SESSION["usuario"];

// $idusuario
// $result=$objVentas->consultar("select * from venta WHERE idsucu_c='$idsucursal' and idusuario='$idusuario' ORDER BY num_docu DESC");
//print_r($result);
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8_spanish_ci" />
</head>
<!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
		<div class="page-container">

	<div class="main-content">
	<?php include('../central/cabecera.php');?>
<hr/>
<h2>Baja de Boletas</h2>
<br/>
<form id="frmResumen" name="frmResumen" submit="return false">
<div class="table-responsive">
	<input type="hidden" name="accion" value="ENVIO_BAJAS"/>
	<input type="hidden" name="ids" id="ids" value="0"/>
  <table id="my-example" class="table table-striped">
		<thead>
			<tr>
				<th>ANULAR</th>
				<th>ID</th>
				<th>FECHA</th>
				<th>SERIE</th>
				<th>CORRELATIVO</th>
				<th>ESTADO</th>
			</tr>
		</thead>
		<tbody>

</tbody>
	</table>
	  </form>

			<div id="divResultado"></div>
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
          ],
	"ajax":
      {
        url: 'obtener_boletas.php',
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
 <script>
	function EnviarResumenComprobantes(idventa) {
		var datax = $("#frmResumen").serializeArray();
		datax.push({name: 'idventa', value: idventa}); // Añadir idventa a los datos del formulario

		$.ajax({
                    method: "POST",
                    url: 'bajasunat.php',
                    data: datax,
                    success: function(response) {
                        $("#divResultado").html(response);
                        // Actualiza la tabla después de enviar los datos
                        $('#my-example').DataTable().ajax.reload();
                    }
                });
	}
	/*  function Marcar(element,idcomprobante){
		 ids = $("#ids").val();
		 if($(element).is(':checked')){
			 ids = ids+','+idcomprobante+'.0';
			 $("#ids").val(ids);
		 }else{
			 ids = ids.replace(','+idcomprobante+'.0','');
			 $("#ids").val(ids);
		 }
	 } */
 </script>
<br /><!-- Footer -->
</div>
</div>
</html>
