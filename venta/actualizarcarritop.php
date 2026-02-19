<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
include_once("../redondeo_venta.php");
$obj= new clsConexion();
$precio_unitario= $obj->real_escape_string(htmlentities(strip_tags($_POST['precio_unitario'])));
$id= $obj->real_escape_string(htmlentities(strip_tags($_POST['id'])));
$text= $obj->real_escape_string(htmlentities(strip_tags($_POST['text'])));
//$colum= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['column_name'],ENT_QUOTES))));
    $result=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu' AND idproducto ='$id'");
		foreach($result as $row){
      $ope=$row['operacion'];
      $cant=$row['cantidad'];
		}
		$result=$obj->consultar("SELECT * FROM productos where idproducto='$id'");
		foreach($result as $row){
			  $stock=$row["stock"];
      	$v_u=$row['precio_venta'];
		}
    $imps=$obj->consultar("SELECT impuesto FROM configuracion");
        foreach((array)$imps as $row){
          $impuesto=$row['impuesto'];
        }
         if ($ope=='OP. GRAVADAS') {
           $text = redondear_abajo_10centimos($text);
           $vu_g = redondear_abajo_10centimos($text / (1 + ($impuesto/100)));
           $igv = redondear_abajo_10centimos(($impuesto/100) * $vu_g * $cant);
           $v_t = redondear_abajo_10centimos($vu_g * $cant);
           $i_t = redondear_abajo_10centimos($text * $cant);

           $sql="UPDATE carrito SET ".$precio_unitario."=".$text.", valor_unitario=".$vu_g." ,
           igv=".$igv." , valor_total=".$v_t." , importe_total=".$i_t."
           WHERE idproducto='".$id."'";
           $obj->ejecutar($sql);
           echo 'ACTUALIZADO';
         }else {
            $imp = redondear_abajo_10centimos($cant * $text);
           $sql = "UPDATE carrito SET ".$precio_unitario."=".$text.",valor_unitario=".$text.",
           valor_total=".$imp." ,importe_total=".$imp." WHERE session_id='$usu' AND idproducto='".$id."'";
           $obj->ejecutar($sql);
           echo 'ACTUALIZADO';
         }
?>
