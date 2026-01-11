<?php
require "../conexion/clsConexion.php";
$obj = new clsConexion();
$cod = trim($obj->real_escape_string(htmlentities(strip_tags($_POST['id'], ENT_QUOTES))));

$sql = "UPDATE `venta` SET `feestado`='anulado' WHERE idventa='".$obj->real_escape_string($cod)."'";
$result = $obj->ejecutar($sql);
if ($result) {
    echo json_encode(['status' => 'success', 'message' => 'Ticket anulado con éxito']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error al anular el ticket']);
}
?>
