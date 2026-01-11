<?php
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
function mostrar($obj,$serie_n){
  $result=$obj->consultar("SELECT MAX(correlativo) as numero FROM serie WHERE serie= '".$serie_n."'");
  //$talla = '<option value="">Seleccione</option>';
  foreach((array)$result as $row){
    if($row['numero']==null){
        $numfac='11';
        //$numfac='1';
      }else{
        $numfac=$row['numero']+1;
      }
       $numfac;
  }
  return $numfac;
}
echo mostrar($obj,$_POST['serie_n']);
 ?>
