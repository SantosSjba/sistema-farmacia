<?php
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
function mostrar($obj,$tico){
  $result=$obj->consultar("SELECT MAX(correlativo) as numero FROM serie WHERE tipocomp= '".$tico."'");
  //$talla = '<option value="">Seleccione</option>';
  foreach((array)$result as $row){
    if($row['numero']==null){
       //$numfac='1';
        $numfac='11';
      }else{
        $numfac=$row['numero']+1;
      }
       $numfac;
  }
  return $numfac;
}
echo mostrar($obj,$_POST['tico']);
 ?>
