<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

include("../seguridad.php");
$usu = $_SESSION["usuario"];
$tipo = $_SESSION["tipo"];
include("../conexion/clsConexion.php");
$obj = new clsConexion;

$usur = $obj->consultar("SELECT idusu FROM usuario WHERE usuario = '$usu'");
if ($usur) {
    foreach ((array)$usur as $row) {
        $usuario = $row['idusu'];
    }
} else {
    die('Error al obtener el usuario');
}

$result_admin = $obj->consultar("SELECT venta.idventa, venta.idusuario, venta.tire, venta.fecha_emision, serie.serie,
serie.correlativo, venta.nombrexml, venta.estado, venta.femensajesunat, venta.feestado
FROM venta
INNER JOIN serie ON venta.idserie = serie.idserie
WHERE serie.serie = 'T001'");

$result_usuario = $obj->consultar("SELECT venta.idventa, venta.idusuario, venta.tire, venta.fecha_emision, serie.serie,
serie.correlativo, venta.nombrexml, venta.estado, venta.femensajesunat, venta.feestado
FROM venta
INNER JOIN serie ON venta.idserie = serie.idserie
WHERE venta.idusuario='$usuario' and serie.serie = 'T001'");

if ($tipo == 'ADMINISTRADOR') {
    $result_valida = $result_admin;
} else {
    $result_valida = $result_usuario;
}

$data = array();
foreach ((array)$result_valida as $row) {
    // Convertir la fecha de emisión en un objeto DateTime
    $btn_imprimir = "<a href='#' class='btn btn-primary btn-sm' title='Impresión Normal' onclick='imprimir_factura(".$row['idventa'].");'>
    <i class='glyphicon glyphicon-print'></i></a>";

    $btn_imprimir2 = "<a href='#' class='btn btn-success btn-sm' title='Imprimir Ticket Directo' onclick='imprimirTicket(".$row['idventa'].")'>
    <i class='glyphicon glyphicon-list-alt'></i></a>";

    $data[] = array(
        "0" => $row['idventa'],
        "1" => $row['fecha_emision'],
        "2" => $row['serie'],
        "3" => $row['correlativo'],
        "4" => $row['feestado'] === 'anulado' ? '<span class="badge badge-danger">Anulado</span>' : '',
        "5"=>'<button type="button" name="anular" id="'.$row["idventa"].'" class="btn btn-default btn-xs anular">Anular</button>',
        "6" => $btn_imprimir,
        "7" => $btn_imprimir2,
    );
}

$results = array(
    "sEcho" => 1, // Información para el datatables
    "iTotalRecords" => count($data), // Enviamos el total registros al datatable
    "iTotalDisplayRecords" => count($data), // Enviamos el total registros a visualizar
    "aaData" => $data
);

echo json_encode($results);
exit();
?>
