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
// Sanitizar entradas para prevenir SQL Injection
$usu_safe = $obj->real_escape_string($usu);
$id_safe = intval($_POST["id"]); // Solo aceptar enteros para IDs
$sql = "DELETE FROM carritoc WHERE session_id='".$usu_safe."' AND idproducto = '".$id_safe."'"; 
$obj->ejecutar($sql);
 ?>
 </body>
