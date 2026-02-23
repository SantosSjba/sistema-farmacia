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
WHERE productos.codigo='$cod' AND productos.estado='1'");
         		$idproducto=null; $des=null; $v_u=null; $ope=null; $prese=null;
         		foreach((array)$pro as $row){
         		  	$idproducto=$row['idproducto'];
              	$des=$row['descripcion'];
              	$v_u=$row['precio_venta'];
                $ope=$row['operacion'];
                $prese=$row['presentacion'];
                $stock_producto = isset($row['stock']) ? (float)$row['stock'] : 0;
         		}

if ($idproducto === null) {
  echo 'Producto no encontrado.';
  exit;
}
if (isset($stock_producto) && $stock_producto <= 0) {
  echo 'No hay stock disponible (stock 0). No se puede agregar.';
  exit;
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
        // Precio que paga el cliente = precio_venta exacto (2 decimales)
        $p_u = round((float)$v_u, 2);
        // Base imponible sin redondear a 0.10: más decimales para que IGV sea exacto (÷1.18)
        $pu_g = round((float)$v_u / (1 + ($impuesto/100)), 6);
        $igv_g = round(($impuesto/100) * $pu_g * $cant, 2);
        $v_t = round($pu_g * $cant, 6);
        $imp_t = round($p_u * $cant, 2);
        $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`,`presentacion`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                            VALUES ('$idproducto','$des','$prese','$cant','$pu_g','$p_u','$igv_g','$impuesto','$v_t','$imp_t','$ope','$usu')";
        $obj->ejecutar($sql);
        echo 'Producto Agregado Al Carrito';

      }elseif ($ope=='OP. EXONERADAS') {
        $p_u = round((float)$v_u, 2);
        $igv = 0.00;
        $v_t = round((float)$v_u * $cant, 2);
        $imp = $v_t;
        $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`,`presentacion`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                            VALUES ('$idproducto','$des','$prese','$cant','$v_u','$p_u','$igv','$impuesto','$v_t','$imp','$ope','$usu')";
        $obj->ejecutar($sql);
        echo 'Producto Agregado Al Carrito';
      }elseif ($ope=='OP. INAFECTAS') {
        $p_u = round((float)$v_u, 2);
        $igv = 0.00;
        $v_t = round((float)$v_u * $cant, 2);
        $imp = $v_t;
        $sql="INSERT INTO `carrito`(`idproducto`, `descripcion`, `presentacion`,`cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`, `operacion`, `session_id`)
                            VALUES ('$idproducto','$des','$prese','$cant','$v_u','$p_u','$igv','$impuesto','$v_t','$imp','$ope','$usu')";
        $obj->ejecutar($sql);
        echo 'Producto Agregado Al Carrito';
      }
    }
// }
?>
