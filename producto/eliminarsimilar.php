<?php include("../seguridad.php");?>
<head>
     <link rel="stylesheet" href="../assets/alert/alertify/alertify.css">
	  <link rel="stylesheet" href="../assets/alert/alertify/themes/default.css">
   <script src="../assets/alert/alertify/alertify.js"></script>
</head>
<body>
<?php
require "../conexion/clsConexion.php";
$obj= new clsConexion();
$cod= trim($obj->real_escape_string(htmlentities(strip_tags($_GET['cod'],ENT_QUOTES))));
$sql= "DELETE  FROM producto_similar WHERE idproducto='".$obj->real_escape_string($cod)."'";
$obj->ejecutar($sql);
echo("<script>
 alertify.alert('mensaje', 'Registro Eliminado!', function(){
 alertify.success('Ok');
window.location.replace('index.php');
 });
</script>");
?>
</body>
