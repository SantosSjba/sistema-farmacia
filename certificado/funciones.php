<?php
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
function cargar_imagen(){
 if(isset($_FILES["imagen"])){
  $extension = explode('.', $_FILES['imagen']['name']);
  $nuevo_name = rand() . '.' . $extension[1];
  $destino = './foto/' . $nuevo_name;
  move_uploaded_file($_FILES['imagen']['tmp_name'], $destino);
  return $nuevo_name;
 }
}

function obtener_nombreimagen($obj,$id){
  $result=$obj->consultar("SELECT certificado FROM certificado WHERE idcertificado = '1'");
  foreach((array)$result as $row){
     return $row['certificado'];
  }
}
 ?>
