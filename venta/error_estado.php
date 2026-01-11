<?php
include_once("../conexion/clsConexion.php");
$obj = new clsConexion();
$idventa = $obj->real_escape_string($_POST['idventa']);
echo  'ESTADO: ERROR';
$sql = "UPDATE venta SET `femensajesunat`='Error' WHERE idventa='$idventa'";
$obj->ejecutar($sql);
?>