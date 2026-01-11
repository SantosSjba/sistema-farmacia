<head>
   <link rel="stylesheet" href="../assets/alert/alertify/alertify.css">
     <link rel="stylesheet" href="../assets/alert/alertify/themes/default.css">
   <script src="../assets/alert/alertify/alertify.js"></script>
</head>
<body>
<?php
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
$funcion=$_POST["funcion"];

if($funcion=="registrar"){
$fec=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtfec'],ENT_QUOTES))));
$caja=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtcaja'],ENT_QUOTES))));
$turno=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtturno'],ENT_QUOTES))));
$hor=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txthor'],ENT_QUOTES))));
$mon=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtmon'],ENT_QUOTES))));
$usu=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtusu'],ENT_QUOTES))));
$sql="INSERT INTO `caja_apertura`(`fecha`, `caja`, `turno`, `hora`, `monto`, `usuario`,`estado`)
VALUES ('$fec','$caja','$turno','$hor','$mon','$usu','Abierto')";
$obj->ejecutar($sql);
	echo"<script>
    alertify.alert('caja', 'Caja Aperturada!', function(){
    alertify.success('OK');
	self.location='../venta/index.php';
	});
</script>";
}
?>
</body>
