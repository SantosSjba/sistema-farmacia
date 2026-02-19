<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
include_once("../redondeo_venta.php");
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
    $p_u = redondear_abajo_10centimos($v_u);
    $pu_g = redondear_abajo_10centimos($v_u / (1 + ($impuesto/100)));
    $igv_g = redondear_abajo_10centimos(($impuesto/100) * $pu_g);
    $v_t = redondear_abajo_10centimos($cant * $pu_g);
    $imp_t = redondear_abajo_10centimos($cant * $p_u);
    $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`,`presentacion`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                        VALUES ('$idproducto','$des','$prese','$cant','$pu_g','$p_u','$igv_g','$impuesto','$v_t','$imp_t','$ope','$usu')";
    $obj->ejecutar($sql);
    echo 'Producto Agregado Al Carrito';

  }elseif ($ope=='OP. EXONERADAS') {
    $p_u = redondear_abajo_10centimos($v_u);
    $igv = 0.00;
    $v_t = redondear_abajo_10centimos($cant * $v_u);
    $imp = $v_t;
    $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`,`presentacion`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                        VALUES ('$idproducto','$des','$prese','$cant','$v_u','$p_u','$igv','$impuesto','$v_t','$imp','$ope','$usu')";
    $obj->ejecutar($sql);
    echo 'Producto Agregado Al Carrito';
  }elseif ($ope=='OP. INAFECTAS') {
    $p_u = redondear_abajo_10centimos($v_u);
    $igv = 0.00;
    $v_t = redondear_abajo_10centimos($cant * $v_u);
    $imp = $v_t;
    $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`, `presentacion`,`cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                        VALUES ('$idproducto','$des','$prese','$cant','$v_u','$p_u','$igv','$impuesto','$v_t','$imp','$ope','$usu')";
    $obj->ejecutar($sql);
    echo 'Producto Agregado Al Carrito';
      }
    }
}
?>
