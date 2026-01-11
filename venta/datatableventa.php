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
serie.correlativo, venta.nombrexml, venta.estado, venta.femensajesunat
FROM venta
INNER JOIN serie ON venta.idserie = serie.idserie
WHERE serie.serie != 'T001'");

$result_usuario = $obj->consultar("SELECT venta.idventa, venta.idusuario, venta.tire, venta.fecha_emision, serie.serie,
serie.correlativo, venta.nombrexml, venta.estado, venta.femensajesunat
FROM venta
INNER JOIN serie ON venta.idserie = serie.idserie
WHERE venta.idusuario='$usuario' and serie.serie != 'T001'");

if ($tipo == 'ADMINISTRADOR') {
    $result_valida = $result_admin;
} else {
    $result_valida = $result_usuario;
}

$data = array();
foreach ((array)$result_valida as $row) {
    // Convertir la fecha de emisión en un objeto DateTime
    $fecha_emision = new DateTime($row['fecha_emision']);
    $fecha_actual = new DateTime();

    // Calcular la diferencia en días entre la fecha actual y la fecha de emisión
    $interval = $fecha_actual->diff($fecha_emision);
    $dias = $interval->days;

    // Determinar el mensaje del badge basado en la diferencia en días
    if ($dias > 3) {
        $plazo = '<span class="badge badge-danger">Vencido</span>';
    } else {
        $plazo = '<span class="badge badge-info">Quedan ' . (3 - $dias) . ' días</span>';
    }

    // Definir los botones con su estado predeterminado
    $boton_enviar = $row['estado'] === 'anulado'
        ? '<button type="button" class="btn btn-secondary btn-sm" disabled> </button>'
        : '<button type="button" name="enviar" id="'.$row["idventa"].'" data-nombrexml="'.$row["nombrexml"].'" class="btn btn-primary btn-sm enviar" title="enviar a la sunat"><i class="glyphicon glyphicon-share-alt"></i></button>';


        $boton_enviar = $row['femensajesunat'] === 'Aceptada'
        ? '<button type="button" class="btn btn-secondary btn-sm" disabled> </button>'
        : '<button type="button" name="enviar" id="'.$row["idventa"].'" data-nombrexml="'.$row["nombrexml"].'" class="btn btn-primary btn-sm enviar" title="enviar a la sunat"><i class="glyphicon glyphicon-share-alt"></i></button>';

        $btn_imprimir = "<a href='#' class='btn btn-default btn-sm' onclick='imprimir_factura(".$row['idventa'].");'><i class='glyphicon glyphicon-print'></i></a>";

    $badgeClass = '';
    switch ($row['estado']) {
        case 'enviado':
            $badgeClass = 'badge bg-success';
            break;
        case 'no_enviado':
            $badgeClass = 'badge bg-default';
            break;
        case 'anulado':
            $badgeClass = 'badge bg-danger';
            break;
        default:
            $badgeClass = 'badge bg-warning';
            break;
    }
    $badgeClass_fe = ($row['femensajesunat'] == 'Aceptada') ? 'badge-success' :
    (($row['femensajesunat'] == 'Observaciones') ? 'badge-warning' : 'badge-danger');

    $data[] = array(
        "0" => $row['idventa'],
        "1" => $plazo,
        "2" => $row['fecha_emision'],
        "3" => $row['serie'],
        "4" => $row['correlativo'],
        "5" => '<span class="' . $badgeClass . '">' . $row['estado'] . '</span>', // Añadir el badge a la columna estado
        "6" => $boton_enviar,
        "7" => '<span class="badge ' . $badgeClass_fe . '">' . $row['femensajesunat'] . '</span>', // Añadir el badge a la columna femensajesunat
        "8" => $btn_imprimir,
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
