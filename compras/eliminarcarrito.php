<head>
   <link rel="stylesheet" href="../assets/alert/alertify/alertify.css">
    <link rel="stylesheet" href="../assets/alert/alertify/themes/default.css">
   <script src="../assets/alert/alertify/alertify.js"></script>
</head>
<body>
<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
$sql = "DELETE FROM carritoc WHERE session_id='$usu' AND idproducto = '".$_POST["id"]."'"; 
$obj->ejecutar($sql);
 ?>
 </body>
