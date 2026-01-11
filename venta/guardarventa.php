<?php
include("../seguridad.php");
$usu=$_SESSION["usuario"];
//include_once("ventasunat.php");
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
$num=$data=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu'");
//$tire=$obj->real_escape_string($_POST['tire']);
$numope=$obj->real_escape_string($_POST['numope']);
$forma=$obj->real_escape_string($_POST['forma']);
$tico=$obj->real_escape_string($_POST['tico']);
$serie_p=$obj->real_escape_string($_POST['serie']);
$correlativo_p=$obj->real_escape_string($_POST['correl']);
$correlativo_i='';
$datasee=$obj->consultar("SELECT idserie,serie,correlativo FROM serie WHERE tipocomp='$tico'");
  foreach((array)$datasee as $row){
    //$serie_i=$row['serie'];
    $correlativo_i=$row['correlativo'];
  }
if($num == 0) {
  echo "No se pudo Registrar la venta agrege productos al carrito";
 // print "<script>alert('No se pudo Registrar la venta agrege productos al carrito.!')</script>";
 // print("<script>window.location.replace('index.php');</script>");
}elseif ($correlativo_i==$correlativo_p) {
   echo "El comprobante ya se encuentra registrado, favor volver a intentarlo.";
}else{
	//obteniendo igv , operaciones gravados , etc
	$op_gravadas = 0;
	$op_exoneradas = 0;
	$op_inafectas = 0;
	$igv = 0;
	$total = 0;
	$impuesto='';

							$imps=$obj->consultar("SELECT ruc,impuesto,simbolo_moneda FROM configuracion");
									foreach((array)$imps as $row){
										$impuesto=$row['impuesto'];
										$mon=$row['simbolo_moneda'];
                    $ruc=$row['ruc'];
									}
						   $data1=$obj->consultar("SELECT ROUND(SUM(valor_total),2) as op_gravadas FROM carrito WHERE operacion='OP. GRAVADAS' AND session_id='$usu'");
								foreach((array)$data1 as $row){
									$op_gravadas=$row['op_gravadas'];
								}

								$data2=$obj->consultar("SELECT ROUND(SUM(valor_total),2) as op_exoneradas FROM carrito  WHERE operacion='OP. EXONERADAS' AND session_id='$usu'");
										foreach((array)$data2 as $row){
											$op_exoneradas=$row['op_exoneradas'];
										}

									$data3=$obj->consultar("SELECT ROUND(SUM(valor_total),2) as valor_total FROM carrito  WHERE  operacion='OP. INAFECTAS' AND session_id='$usu'");
											foreach((array)$data3 as $row){
												$op_inafectas=$row['valor_total'];
											}

									$data4=$obj->consultar("SELECT ROUND(SUM(igv),2) as igv FROM carrito WHERE operacion='OP. GRAVADAS' AND session_id='$usu'");
											foreach((array)$data4 as $row){
                        $igv=$row['igv'];
												// if($row['igv']==null){
												// 	$igv=0;
												// }else{
												// }
											}
									$data5=$obj->consultar("SELECT ROUND(SUM(importe_total),2) as total FROM carrito WHERE session_id='$usu'");
											foreach((array)$data5 as $row){
												$total=$row['total'];
											 }
	//obtener el ultimo id de venta
$data_j=$obj->consultar("SELECT MAX(idventa) as idventa FROM venta");
		foreach($data_j as $row){
			if($row['idventa']==null){
        //empezar en 11 porque ya han sido registrados hasta la serie 10
        $idventa='11';
				//$idventa='1';
			}else{
				$idventa=$row['idventa']+1;
			}
		}

	//obtener el id del usuario
$data_l=$obj->consultar("SELECT * FROM usuario WHERE usuario='$usu'");
		foreach($data_l as $row){
		    $idusuario=$row['idusu'];
		}
//obtener el id del cliente
//$cliente_nd=$obj->real_escape_string($_POST['nd']);
$cliente_nd=$obj->real_escape_string($_POST['numero']);
$direccion=$obj->real_escape_string($_POST['dir']);
$td=$obj->real_escape_string($_POST['td']);
$rz=$obj->real_escape_string($_POST['rz']);
$cliente_nrodoc='';
$data_c=$obj->consultar("SELECT nrodoc,idcliente FROM cliente WHERE nrodoc='$cliente_nd'");
    foreach((array)$data_c as $row){
        $cliente_existe_id=$row['idcliente'];
        $cliente_nrodoc=$row['nrodoc'];
    }
    if ($cliente_nrodoc==$cliente_nd) {
        $idcliente=$cliente_existe_id;
    } else {
      $sql="INSERT INTO `cliente`(`nombres`, `direccion`, `id_tipo_docu`, `nrodoc`) VALUES ('$rz','$direccion','$td','$cliente_nd')";
      $obj->ejecutar($sql);
      $data_ci=$obj->consultar("SELECT nrodoc,idcliente FROM cliente WHERE nrodoc='$cliente_nd'");
          foreach($data_ci as $row){
              $cliente_existe_id2=$row['idcliente'];
          }
      $idcliente=$cliente_existe_id2;
    }
$fecha=$obj->real_escape_string($_POST['fecha']);
// $mon=$obj->real_escape_string($_POST['mon']);
//obtener el ultimo id de serie
$data_s=$obj->consultar("SELECT MAX(idserie) as idserie FROM serie");
  foreach($data_s as $row){
    if($row['idserie']==null){
      $idserie_s='1';
    }else{
      $idserie_s=$row['idserie']+1;
    }
  }
  // $datasee=$obj->consultar("SELECT idserie,serie,correlativo FROM serie WHERE serie='$serie_p' AND correlativo='$correlativo_p'");
  //   foreach((array)$datasee as $row){
  //     $cormas1=$row['correlativo']+1;
  //   }
  // $datasee=$obj->consultar("SELECT * FROM serie WHERE idserie='$idserie_s'");
  //   foreach((array)$datasee as $row){
  //     $cormas1=$row['correlativo']+1;
  //   }
  //   $sql_us = "UPDATE serie SET correlativo='$cormas1' WHERE idserie='$idserie_s'";

  //   $obj->ejecutar($sql_us);
// $sql_us = "UPDATE serie SET correlativo = correlativo + 1  WHERE idserie='$idserie_s'";
// $obj->ejecutar($sql_us);
//insertar serie
//$idcliente=$obj->real_escape_string($_POST['idcli']);
$efectivo=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['recibo'],ENT_QUOTES))));
$vuelto=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['vuelto'],ENT_QUOTES))));

$sql_s="INSERT INTO `serie`(`idserie`,`tipocomp`, `serie`, `correlativo`) VALUES ('$idserie_s','$tico','$serie_p','$correlativo_p')";
$obj->ejecutar($sql_s);
if ($tico=='00') {
  $nombrexml = 'NULL';
} else {
  $nombrexml = 'R-'.''.$ruc.'-'.$tico.'-'.$serie_p.'-'.$correlativo_p.'.XML';
}
  //guardar venta
  $sql_v="INSERT INTO `venta`(`idventa`, `idconf`, `tipocomp`, `idcliente`, `idusuario`, `idserie`, `fecha_emision`, `op_gravadas`, `op_exoneradas`, `op_inafectas`, `igv`, `total`, `feestado`, `fecodigoerror`, `femensajesunat`, `nombrexml`, `xmlbase64`, `cdrbase64`, `efectivo`, `vuelto`, `tire`, `estado`,`formadepago`,`numope`)
                      VALUES ('$idventa','1','$tico','$idcliente','$idusuario','$idserie_s','$fecha','$op_gravadas','$op_exoneradas','$op_inafectas','$igv','$total',null,null,null,'$nombrexml',null,null,'$efectivo','$vuelto','noenviado','no_enviado','$forma','$numope')";
  $obj->ejecutar($sql_v);
$it=0;
//guardar detalle venta obtenido de los datos del carrito
$data=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu'");
		foreach((array)$data as $row){
      $it += count(array($row["idproducto"]));
      $cod=$row['idproducto'];
      $cant=$row['cantidad'];
      $v_u=$row['valor_unitario'];
		  $p_u=$row['precio_unitario'];
      $igv_d=$row['igv'];
      $v_t=$row['valor_total'];
		  $imp=$row['importe_total'];
      //$dsc=$row['descuento'];

$sql_dv="INSERT INTO `detalleventa`(`idventa`, `item`, `idproducto`, `cantidad`, `valor_unitario`, `precio_unitario`, `igv`, `porcentaje_igv`, `valor_total`, `importe_total`)
      VALUES ('$idventa','$it','$cod','$cant','$v_u','$p_u','$igv_d','$impuesto','$v_t','$imp')";
    //  $i.'<br>';
$obj->ejecutar($sql_dv);
}
 //actualizacion del stock
$data=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu'");
		foreach((array)$data as $row){
			$id=$row['idproducto'];
      $cantdb=$row['cantidad'];
$up="UPDATE productos set stock=stock-$cantdb WHERE idproducto='$id' ";
$obj->ejecutar($up);
}
//vacear carrito
$sql_del="DELETE FROM carrito WHERE session_id='$usu'";
$obj->ejecutar($sql_del);
echo "VENTA REALIZADA";
echo "<script>window.open('../reportes/ticket.php?idventa=".$idventa."','_blank')</script>";
// header("Location: ../reportes/pdfFacturaElectronica.php?idventa=".$idventa."");
}
?>
