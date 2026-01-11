<?php include("../seguridad.php");?>
<head>
   <link rel="stylesheet" href="../assets/alert/alertify/alertify.css">
       <link rel="stylesheet" href="../assets/alert/alertify/themes/default.css">
   <script src="../assets/alert/alertify/alertify.js"></script>
</head>
<body>
<?php
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
$data=$obj->consultar("SELECT impuesto FROM configuracion");
		foreach($data as $row){
			$impuesto=$row['impuesto'];
		}
$num=$data=$obj->consultar("select * from carritoc WHERE session_id='$usu'");
if($num == 0) {
 print "<script>alert('No se pudo Registrar la compra agrege productos al carritoc.!')</script>";
 print("<script>window.location.replace('index.php');</script>");
}else{
$data=$obj->consultar("SELECT MAX(idcompra) as idcompra FROM compra");
		foreach($data as $row){
			if($row['idcompra']==NULL){
				$idcompra='1';
			}else{
				$idcompra=$row['idcompra']+1;
			}
		}
$data=$obj->consultar("SELECT ROUND(SUM(importe),2) as subtotal FROM carritoc WHERE session_id='$usu'");
		foreach($data as $row){
			$subtotal=$row['subtotal'];
		}
$data=$obj->consultar("SELECT ROUND(SUM(importe)*$impuesto/100 ,2) as igv FROM carritoc WHERE session_id='$usu'");
		foreach($data as $row){
			$igv=$row['igv'];
		}
$data=$obj->consultar("SELECT ROUND(SUM(importe)*$impuesto/100+SUM(importe),2) as total FROM carritoc WHERE session_id='$usu'");
		foreach($data as $row){
			$total=$row['total'];
		}
		  $idlab_pro=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['idlab_pro'],ENT_QUOTES))));
		  $fecha=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['fecha'],ENT_QUOTES))));
		  $docu=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['docu'],ENT_QUOTES))));
		  $numdocu=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['numdocu'],ENT_QUOTES))));

$sqlv="INSERT INTO compra(idcompra,idcliente,fecha,subtotal,igv,total,docu,num_docu)
VALUES('$idcompra','$idlab_pro','$fecha','$subtotal','$igv','$total','$docu','$numdocu')";
$obj->ejecutar($sqlv);
///guardar detalle compra obtenido de los datos del carritoc
$data=$obj->consultar("select * from carritoc WHERE session_id='$usu'");
		foreach($data as $row){
			$cod= $row['idproducto'];
      $cant= $row['cantidad'];
		  $pre= $row['precio'];
		  $imp= $row['importe'];

$sqldv="INSERT INTO detallecompra(idcompra,idproducto,cantidad,precio,importe) VALUES('$idcompra','$cod','$cant','$pre','$imp')";
$obj->ejecutar($sqldv);
}
 //actualizacion de stock
$data=$obj->consultar("select * from carritoc WHERE session_id='$usu'");
		foreach((array)$data as $row){
			$id= $row['idproducto'];
      $cantdb= $row['cantidad'];
			$p="update productos set stock=stock+$cantdb where idproducto='$id'";
			$obj->ejecutar($p);
}
//vacear carritoc
$sqlt="DELETE FROM carritoc WHERE session_id='$usu'";

$res=$obj->ejecutar($sqlt);
if($res){
    echo("<script>
     alertify.alert('mensaje', 'Compra Realizada con Exito!', function(){
     alertify.success('Ok');
    window.location.replace('index.php');
     });
    </script>");
    }else {
      echo("<script>
       alertify.alert('mensaje', 'algo salio mal vuelva a intentarlo!', function(){
       alertify.success('Ok');
      window.location.replace('index.php');
       });
      </script>");
    }


	 }
?>
</body>
