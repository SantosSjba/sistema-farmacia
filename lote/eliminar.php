<?php
require "../conexion/clsConexion.php";
$obj= new clsConexion();
$cod= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['id'],ENT_QUOTES))));
$sql= "DELETE  FROM lote WHERE idlote='".$obj->real_escape_string($cod)."'";
$obj->ejecutar($sql);
   echo "Eliminado satisfactoriamente...";
 ?>
