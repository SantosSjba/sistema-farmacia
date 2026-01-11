<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
$cantidad= $obj->real_escape_string(htmlentities(strip_tags($_POST['cantidad'])));
$id= $obj->real_escape_string(htmlentities(strip_tags($_POST['id'])));
$text= $obj->real_escape_string(htmlentities(strip_tags($_POST['text'])));
//$colum= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['column_name'],ENT_QUOTES))));
    $result=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu' AND idproducto ='$id'");
		foreach($result as $row){
      $ope=$row['operacion'];
      $pu_c=$row['precio_unitario'];
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
		if($text>$stock){
			echo 'NO CUENTA CON EL STOCK SUFICIENTE';
		}else{
           if ($ope=='OP. GRAVADAS') {
            $pu_g=number_format($pu_c/(1+($impuesto/100)),2);
            $v_t= $pu_g*$text;
            $imp=$text*$pu_c;
            //$p_u_new=$text*$v_u;
            $v_u_new=$pu_g*$text;
            $igv=number_format(($impuesto/100)*$v_u_new,2);

            $sql = "UPDATE carrito SET ".$cantidad."=".$text.",valor_total=".$v_t.",importe_total=".$imp.",igv=".$igv."
            WHERE session_id='$usu' AND idproducto='".$id."'";
            $obj->ejecutar($sql);
            echo 'ACTUALIZADO';
          } else {
           $imp= $pu_c*$text;
       		 $sql = "UPDATE carrito SET ".$cantidad."=".$text.",valor_total=".$imp." ,importe_total=".$imp." WHERE session_id='$usu' AND idproducto='".$id."'";
       		 $obj->ejecutar($sql);
       		 echo 'ACTUALIZADO';
          }
		}
?>
