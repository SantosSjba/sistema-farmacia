<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();

// Sanitizar entradas
$usu_safe = $obj->real_escape_string($usu);
$id = intval($_POST['id']); // Solo aceptar enteros para IDs
$text = floatval($_POST['text']); // Solo aceptar números para cantidades

// Validar nombre de columna - solo permitir valores específicos
$columnas_permitidas = array('cantidad', 'precio');
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';
if (!in_array($cantidad, $columnas_permitidas)) {
    $cantidad = 'cantidad'; // Valor por defecto
}

$result=$obj->consultar("SELECT * FROM carritoc WHERE session_id='".$usu_safe."' AND idproducto ='".$id."'");
$precio = 0;
foreach((array)$result as $row){
    $precio=floatval($row["precio"]);
}

$imp = $precio * $text;
$sql = "UPDATE carritoc SET ".$cantidad."=".$text.",importe=".$imp." WHERE session_id='".$usu_safe."' AND idproducto='".$id."'";
$obj->ejecutar($sql);
echo 'actualizado';

?>
