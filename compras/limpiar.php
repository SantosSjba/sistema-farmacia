<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
//vacear carrito
$sql="DELETE FROM carritoc WHERE session_id='$usu'";
$obj->ejecutar($sql);
header('Location:index.php');
?>
