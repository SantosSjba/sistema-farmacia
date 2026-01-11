<?php
ob_start();
include("../seguridad.php");
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$usu = $_SESSION["usuario"];
$objproductos = new clsConexion;
// //$idsucursal=$_SESSION["sucursal"];
?>
<!DOCTYPE html>

<head>
  <style media="screen">
    .label-as-badge {
      border-radius: 1em;
    }
  </style>

</head>
<html lang="en">
<div class="page-container">
  <div class="main-content">
    <?php include('../central/cabecera.php'); ?>
    <hr />
    <h2>Productos Farmaceuticos</h2>
    <br />
    <a href="insertar.php" class="btn btn-primary">
      <i class="entypo-plus"></i>
      Nuevo
    </a>
    <!--     <a href="../reportes/rptproductos.php" class="btn btn-danger">
      <i class="glyphicon glyphicon-save"></i>
      Exportar PDF
    </a>
    <a href="../reportes/EXCEL/reporteproducto.php?export" class="btn btn-success" title="EXPORTAR EXCEL">
      <i class="entypo-export"></i>
      Exportar CSV
    </a> -->
    <br />
    <br />
    <div class="table-responsive">
      <table id="my-example" class="table table-striped">
        <thead>
          <tr>
            <th>Cod.</th>
            <th>Descripcion</th>
            <th>Presentacion</th>
            <th>Stock</th>
            <th>P.Venta</th>
            <th>Estado</th>
            <th>Tipo</th>
            <th>Editar</th>
            <th>Eliminar</th>
            <th>Similar</th>
          </tr>
        </thead>
      </table>
    </div>
    <?php include_once("../central/pieproducto.php"); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script type="text/javascript">
  $(document).ready(function () {
    tabla = $('#my-example').DataTable({
      "aProcessing": true,
      "aServerSide": true,
      dom: 'Bfrtip',
      buttons: [
        {
          extend: 'excelHtml5',
          text: '<i class="fas fa-file-excel"></i> Exportar a Excel',
          title: 'LISTADO DE MEDICAMENTOS',
          className: 'btn-excel',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6] // Incluye solo las columnas del 0 al 6 en la exportación
          }
        },
        {
          extend: 'pdfHtml5',
          text: '<i class="fas fa-file-pdf"></i> Exportar a PDF',
          title: 'LISTADO DE MEDICAMENTOS',
          className: 'btn-pdf',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 6] // Incluye solo las columnas del 0 al 6 en la exportación
          }
        }
      ],
      "ajax": {
        url: 'datatable.php',
        type: "get",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        }
      },
      "bDestroy": true,
      "iDisplayLength": 10,
      "order": [[0, "desc"]],

      initComplete: function () {
        // Aplicar estilos después de que DataTables ha renderizado
        $('.btn-excel').css({
          'background-color': '#ffffff',
          'color': '#28a745',  // Cambia el color si es necesario
          'border': 'none'
        });
        $('.btn-pdf').css({
          'background-color': '#dc3545',
          'color': '#dc3545',  // Cambia el color si es necesario
          'border': 'none'
        });
      }
    });
  });
</script>

    <script type="text/javascript">
      $(document).on('click', '.delete', function () {
        var id = $(this).attr("id");
        if (confirm("realmente desea eliminar?")) {
          $.ajax({
            url: "eliminar.php",
            method: "POST",
            data: { id: id },
            success: function (data) {
              alert(data);
              tabla.ajax.reload();
              // console.log(data);
            }
          })
        }
        else {
          return false;
        }
      });
    </script>
    <br /><!-- Footer -->
  </div>
</div>

</html>