<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
$idpc=NULL;
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
if (!empty($_POST)){
$idproducto=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['idproducto'],ENT_QUOTES))));
$des=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['des'],ENT_QUOTES))));
$pres=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['pres'],ENT_QUOTES))));
$pre=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['precio'],ENT_QUOTES))));
$cant=1;
$imp=$cant*$pre;
//registra los datos del carrito
$data=$obj->consultar("SELECT * FROM carritoc WHERE session_id='$usu' AND idproducto='$idproducto'");
foreach((array)$data as $row){
  $idpc=$row['idproducto'];
}
if ($idproducto==$idpc) {
  echo 'El Producto Ya Fue Agregado Al Carrito';
}else {
  $sql="INSERT INTO carritoc(idproducto,descripcion,presentacion,cantidad,precio,importe,session_id) VALUES ('$idproducto','$des','$pres','$cant','$pre','$imp','$usu')";
  $obj->ejecutar($sql);
  echo 'Producto Agregado Al Carrito';
    }
}
?>
