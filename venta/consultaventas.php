<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../seguridad.php");
include("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
ob_start();
$usu = $_SESSION["usuario"];
$objVentas = new clsConexion;
?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8_spanish_ci" />
</head>
<!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
<div class="page-container">
  <div class="main-content">
    <?php include('../central/cabecera.php'); ?>
    <hr />
    <h2>Consulta de Ventas</h2>
    <br />
    <div class="table-responsive">
      <table id="my-example" class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <div style="position: relative; display: inline-block;">
              <input type="text" id="fechaFiltro" placeholder="Filtrar por fecha" style="padding-right: 30px;" class="form-control">
              <button id="resetFiltro" class="btn btn-primary btn-sm" title="Reiniciar filtro"
                style="position: absolute; right: 0; top: 0; height: 100%;"><i
                  class="glyphicon glyphicon-refresh"></i></button>
            </div>
            <th>PLAZO</th>
            <th>FECHA</th>
            <th>SERIE</th>
            <th>CORRELATIVO</th>
            <th>ESTADO</th>
            <th>ENVIAR</th>
            <th>RPT. SUNAT</th>
            <th>IMPRIMIR</th>
          </tr>
        </thead>
      </table>
    </div>
    <?php include_once("../central/pieproducto.php"); ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="../public/alert/alertify/alertify.css">
    <link rel="stylesheet" href="../public/alert/alertify/themes/default.css">
    <script src="../public/alert/alertify/alertify.js"></script>
    <!-- Incluye Alertify CSS y JS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <!-- Incluye Alertify CSS y JS -->
    <script type="text/javascript">
      var tabla; // Definir `tabla` en el contexto global

      $(document).ready(function () {
        tabla = $('#my-example').DataTable({
          "aProcessing": true, // Activamos el procesamiento del datatables
          "aServerSide": true, // Paginación y filtrado realizados por el servidor
          dom: 'Bfrtip', // Definimos los elementos del control de tabla
          buttons: [
            // 'copyHtml5',
            // 'excelHtml5',
            // 'csvHtml5',
            // 'pdf'
          ],
          "ajax": {
            url: 'datatableventa.php',
            type: "get",
            dataType: "json",
            error: function (e) {
              console.log(e.responseText);
            }
          },
          "bDestroy": true,
          "iDisplayLength": 10, // Paginación
          "order": [[0, "desc"]] // Ordenar (columna, orden)
        });

        $('#fechaFiltro').datepicker({
          dateFormat: 'yy-mm-dd', // Formato de la fecha
          onSelect: function (dateText) {
            tabla.column(2).search(dateText).draw(); // Filtra la columna de fecha
          }
        });

        // Limpiar el filtro de fecha al hacer clic en el botón de reinicio
        $('#resetFiltro').on('click', function () {
          $('#fechaFiltro').val('');
          tabla.column(2).search('').draw(); // Limpia el filtro
        });
      });
</script>
<script>
  $(document).on('click', '.enviar', function () {
  alertify.set('notifier', 'position', 'top-right');

  var idventa = $(this).attr('id');

  alertify.confirm('Mensaje', '¿Realmente desea enviar el comprobante a la SUNAT?',
    function () {
      $.ajax({
        url: 'ventasunat_enviar.php',
        type: 'POST',
        data: { idventa: idventa },
        success: function (response) {
          console.log('Respuesta SUNAT:', response); // ✅ Solo en consola


          if (response.includes('ESTADO: ACEPTADA')) {
            if (response.includes('|OBSERVACIONES')) {
              alertify.warning('ESTADO: Enviado con Observaciones');
            } else {
              alertify.success('ESTADO: ACEPTADA');
            }

            setTimeout(function () {
              tabla.ajax.reload(null, false);
            }, 2000);
          } else {
            alertify.error('ESTADO: Error');
            $.ajax({
              url: 'error_estado.php',
              type: 'POST',
              data: { idventa: idventa },
              success: function (data_er) {
                console.log('Error de respuesta:', data_er);
                console.log('Respuesta SUNAT:', response);
                setTimeout(function () {
                  tabla.ajax.reload(null, false);
                }, 2000);
              },
            });
          }
        },
        error: function (xhr, status, error) {
          alertify.error('Error en la solicitud AJAX');
          console.error('Error AJAX:', status, error); // ✅ Solo en consola
          console.log('Respuesta SUNAT:', response);
        }
      });
    },
    function () {
      alertify.error('Actualización cancelada');
    }
  );
});

</script>

    <script type="text/javascript">
      function VentanaCentrada(theURL, winName, features, myWidth, myHeight, isCenter) { //v3.0
        if (window.screen) if (isCenter) if (isCenter == "true") {
          var myLeft = (screen.width - myWidth) / 2;
          var myTop = (screen.height - myHeight) / 2;
          features += (features != '') ? ',' : '';
          features += ',left=' + myLeft + ',top=' + myTop;
        }
        window.open(theURL, winName, features + ((features != '') ? ',' : '') + 'width=' + myWidth + ',height=' + myHeight);
      }
      function imprimir_factura(id_factura) {
        VentanaCentrada('../reportes/ticket.php?idventa=' + id_factura, 'COMPROBANTE', '', '1024', '768', 'true');
      }
    </script>