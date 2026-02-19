<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
$descuento= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['descuento'],ENT_QUOTES))));
$id= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['id'],ENT_QUOTES))));
$text= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['text'],ENT_QUOTES))));
//$colum= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['column_name'],ENT_QUOTES))));
    $result=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu' AND idproducto ='$id'");
		foreach($result as $row){
			$v_u=$row["valor_unitario"];
      $ope=$row['operacion'];
      $cantidad=$row["cantidad"];
      //$importe=$row["importe"];
		}
    $imps=$obj->consultar("SELECT impuesto FROM configuracion");
        foreach((array)$imps as $row){
          $impuesto=$row['impuesto'];
        }

		 // $imp= $cantidad*$precio-$text;
		 // $sql = "UPDATE carrito SET ".$descuento."=".$text.",importe=".$imp."  WHERE session_id='$usu' AND idproducto='".$id."'";
		 // $obj->ejecutar($sql);
		 // echo 'actualizado';

     if ($ope=='OP. GRAVADAS') {
      $v_t = round((float)$v_u * $cantidad, 6);
      $igv = round(($impuesto/100) * $v_t, 2);
      $imp = round($igv + $v_t, 2);

      $sql = "UPDATE carrito SET ".$descuento."=".$text.",valor_total=".$v_t.",importe_total=".$imp.",igv=".$igv."  WHERE session_id='$usu' AND idproducto='".$id."'";
      $obj->ejecutar($sql);
      echo 'ACTUALIZADO';

     }else {
     $imp = round((float)$cantidad * $v_u, 2);
     $sql = "UPDATE carrito SET ".$descuento."=".$text.",valor_total=".$imp." ,importe_total=".$imp." WHERE session_id='$usu' AND idproducto='".$id."'";
     $obj->ejecutar($sql);
     echo 'ACTUALIZADO';
    }

?>
