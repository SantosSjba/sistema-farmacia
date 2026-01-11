<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
$idpc=NULL;
$imps=$obj->consultar("SELECT impuesto FROM configuracion");
    foreach((array)$imps as $row){
      $impuesto=$row['impuesto'];
    }
if (!empty($_POST)){
$idproducto=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['idproducto'],ENT_QUOTES))));
$des=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['des'],ENT_QUOTES))));
$prese=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['pres'],ENT_QUOTES))));
$v_u=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['pre'],ENT_QUOTES))));
//$dsc=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['dsc'],ENT_QUOTES))));

$impsd=$obj->consultar("SELECT
  tipo_afectacion.descripcion AS operacion,
  productos.idproducto
FROM productos
  INNER JOIN tipo_afectacion
    ON productos.idtipoaf = tipo_afectacion.idtipoa
where productos.idproducto='$idproducto'");
foreach((array)$impsd as $row){
  $ope=$row['operacion'];
}

$cant=1;
//$imp=$cant*$pre-$dsc;
//registra los datos del carrito
$data=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu'  AND idproducto='$idproducto'");
foreach((array)$data as $row){
  $idpc=$row['idproducto'];
}
if ($idproducto==$idpc) {
  echo 'El Producto Ya Fue Agregado Al Carrito';
}else {
  if ($ope=='OP. GRAVADAS') {
    $pu_g=number_format($v_u/(1+($impuesto/100)),2);
    //$imp_g=number_format($v_u-$op_g,2);
    //$tot_g=number_format($imp_g+$op_g,2);
    $imp_t=number_format($cant*$v_u,2);
     //referente
    $p_u=number_format(($impuesto/100*$pu_g)+$pu_g,2);
    //$p_u=number_format(($impuesto/100*$v_u)+$v_u,2);
    //  $igv=number_format(($impuesto/100)*$v_t,2);
    $igv_g=number_format(($impuesto/100)*$pu_g,2);
    $v_t=number_format($cant*$pu_g,2);
    //$imp=number_format($igv+$v_t,2);
    $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`,`presentacion`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                        VALUES ('$idproducto','$des','$prese','$cant','$pu_g','$p_u','$igv_g','$impuesto','$v_t','$imp_t','$ope','$usu')";
    $obj->ejecutar($sql);
    echo 'Producto Agregado Al Carrito';

  }elseif ($ope=='OP. EXONERADAS') {
    $p_u=$v_u;
    $igv=0.00;
    $v_t=number_format($cant*$v_u,2);
    $imp=$v_t;
    $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`,`presentacion`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                        VALUES ('$idproducto','$des','$prese','$cant','$v_u','$p_u','$igv','$impuesto','$v_t','$imp','$ope','$usu')";
    $obj->ejecutar($sql);
    echo 'Producto Agregado Al Carrito';
  }elseif ($ope=='OP. INAFECTAS') {
    $p_u=$v_u;
    $igv=0.00;
    $v_t=number_format($cant*$v_u,2);
    $imp=$v_t;
    $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`, `presentacion`,`cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                        VALUES ('$idproducto','$des','$prese','$cant','$v_u','$p_u','$igv','$impuesto','$v_t','$imp','$ope','$usu')";
    $obj->ejecutar($sql);
    echo 'Producto Agregado Al Carrito';
      }
    }
}
?>
