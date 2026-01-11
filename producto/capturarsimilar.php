<?php include("../seguridad.php");?>
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
  $id=trim($obj->real_escape_string($_POST['txtid'],ENT_QUOTES));
  $de=trim($obj->real_escape_string($_POST['txtde'],ENT_QUOTES));
  $pre=trim($obj->real_escape_string($_POST['txtpre'],ENT_QUOTES));

$sql="INSERT INTO `producto_similar`(`idproducto`, `producto`, `presentacion`) VALUES ('$id','$de','$pre')";
$obj->ejecutar($sql);
echo("<script>
 alertify.alert('mensaje', 'Registro Grabado!', function(){
 alertify.success('Ok');
window.location.replace('index.php');
 });
</script>");
}
?>
</body>
