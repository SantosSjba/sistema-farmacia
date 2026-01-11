<?php
include("../seguridad.php");
include("../central/centralproducto.php");
include("../conexion/clsConexion.php");
ob_start();
$usu=$_SESSION["usuario"];

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8_spanish_ci" />
</head>
<!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
		<div class="page-container">

	<div class="main-content">
	<?php include('../central/cabecera.php');?>
<hr/>
<h2>Baja de Facturas</h2>
<br/>
<form id="frmResumen" name="frmResumen" submit="return false">
            <div class="table-responsive">
                <input type="hidden" name="accion" value="ENVIO_BAJAS"/>
                <input type="hidden" name="ids" id="ids" value="0"/>
                <table id="my-example" class="table table-striped">
                    <thead>
                        <tr>
                            <th>MARCAR</th>
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
            </div>
            <div align="right" class="col-md-12">
            <button class="btn btn-danger" type="button" onclick="EnviarResumenComprobantes()">
                <span class="glyphicon glyphicon-remove"></span> Anular y Enviar
            </button>
            </div>
            <div id="divResultado"></div>
        </form>
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
        url: 'obtener_facturas.php',
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

            function EnviarResumenComprobantes() {
                var datax = $("#frmResumen").serializeArray();
                $.ajax({
                    method: "POST",
                    url: 'bajas_factura.php',
                    data: datax,
                    success: function(response) {
                        $("#divResultado").html(response);
                        // Actualiza la tabla después de enviar los datos
                        $('#my-example').DataTable().ajax.reload();
                    }
                });
            }

            function Marcar(element, idcomprobante) {
                var ids = $("#ids").val().split(',');
                if ($(element).is(':checked')) {
                    if (!ids.includes(idcomprobante)) {
                        ids.push(idcomprobante);
                    }
                } else {
                    ids = ids.filter(id => id !== idcomprobante);
                }
                $("#ids").val(ids.join(','));
            }
        </script>
        <br /><!-- Footer -->
    </div>
</div>
</html>
