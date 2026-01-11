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
$usu=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtusu'],ENT_QUOTES))));
$pago_e=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtp_e'],ENT_QUOTES))));

$t_v=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txttot'],ENT_QUOTES))));
$mon=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtmon'],ENT_QUOTES))));
$caja_s=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtsis'],ENT_QUOTES))));
$efec_c=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtefe'],ENT_QUOTES))));
$diferencia=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtfalta'],ENT_QUOTES))));

$sql="INSERT INTO `caja_cierre`(`fecha`, `caja`, `turno`, `hora`, `usuario`, `pagos_efectivo`, `total_venta`, `monto_a`, `caja_sistema`, `efectivo_caja`, `diferencia`)
VALUES('$fec','$caja','$turno','$hor','$usu','$pago_e','$t_v','$mon','$caja_s','$efec_c','$diferencia')";
$sqlu="UPDATE `caja_apertura` SET `estado`='Cerrado' WHERE usuario='$usu'";
$obj->ejecutar($sql);
$obj->ejecutar($sqlu);
	echo"<script>
    alertify.alert('caja', 'Caja cerrada con exito!', function(){
    alertify.success('OK');
self.location='movimiento.php';
	});
</script>";
}
?>
</body>
