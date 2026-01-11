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
// if (!empty($_POST)){
 $cod=$obj->real_escape_string(htmlentities(strip_tags($_POST['cod'])));

 $pro=$obj->consultar("SELECT
  productos.idproducto,
  productos.codigo,
  productos.descripcion,
  productos.precio_venta,
  productos.stock,
  productos.estado,
  tipo_afectacion.descripcion AS operacion,
  presentacion.presentacion
FROM productos
  INNER JOIN tipo_afectacion
    ON productos.idtipoaf = tipo_afectacion.idtipoa
  INNER JOIN presentacion
    ON productos.idpresentacion = presentacion.idpresentacion
WHERE productos.codigo='$cod' AND productos.stock>'0.01' AND productos.estado='1'");
         		foreach((array)$pro as $row){
         		  	$idproducto=$row['idproducto'];
              	$des=$row['descripcion'];
              	$v_u=$row['precio_venta'];
                //el valor unitario es igual al precio de venta del producto
                $ope=$row['operacion'];
                $prese=$row['presentacion'];
              //  $dsc=$row['descuento'];
         		}

$cant=1;
//registra los datos del carrito
$data=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu' AND idproducto='$idproducto'");
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
        //el porentaje del igv es igual al impuesto 18.00
        //en este caso el valor unitario es igual al precio de venta del producto
        $p_u=$v_u;
        // en este caso el igv es 0
        $igv=0.00;
        //el valor total es igual a la cantidad  x el valor unitrio
        $v_t=number_format($cant*$v_u,2);
        // en este caso el importe total es igual al valor total
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
// }
?>
