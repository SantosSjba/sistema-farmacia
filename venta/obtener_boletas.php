<?php
include("../seguridad.php");
include("../conexion/clsConexion.php");

$usu = $_SESSION["usuario"];
$obj = new clsConexion();

// Consulta para obtener los registros filtrados y paginados
$records = $obj->consultar("SELECT venta.idventa
, venta.fecha_emision
, serie.serie
, serie.correlativo
, venta.nombrexml
, venta.tipocomp
,venta.estado
FROM
venta
INNER JOIN serie
ON venta.idserie = serie.idserie
where venta.tipocomp='03'");

$data = array();
foreach ((array)$records as $row) {
    $badgeClass = ($row['estado'] == 'activo') ? 'badge bg-success' : 'badge bg-danger';
    $data[] = array(

        '<button class="btn btn-danger btn-sm" title="anular boleta" type="button" onclick="EnviarResumenComprobantes(' . $row['idventa'] . ')">
        <span class="glyphicon glyphicon-remove"></span>
        </button>',

        $row['idventa'],
        $row['fecha_emision'],
        $row['serie'],
        $row['correlativo'],
        '<span class="' . $badgeClass . '">' . $row['estado'] . '</span>'
    );
}

$response = array(
    "sEcho" => 1, // Información para el datatables
    "iTotalRecords" => count($data), // Enviamos el total registros al datatable
    "iTotalDisplayRecords" => count($data), // Enviamos el total registros a visualizar
    "aaData" => $data
);

echo json_encode($response);
?>
