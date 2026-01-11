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
if($funcion=="modificar"){
$cod=trim($obj->real_escape_string($_POST['cod'],ENT_QUOTES));
$lo=trim($obj->real_escape_string($_POST['txtlo'],ENT_QUOTES));
$fec=trim($obj->real_escape_string($_POST['txtfec'],ENT_QUOTES));
$sql="update lote set numero='$lo', fecha_vencimiento='$fec' where idlote=$cod";
$res=$obj->ejecutar($sql);
if($res){
    echo("<script>
     alertify.alert('mensaje', 'Registro Actualizado!', function(){
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
if($funcion=="registrar"){
$lo=trim($obj->real_escape_string($_POST['txtlo'],ENT_QUOTES));
$fec=trim($obj->real_escape_string($_POST['txtfec'],ENT_QUOTES));

$sql="insert into lote(numero,fecha_vencimiento,idsucu_c)values('$lo','$fec','1')";
$res=$obj->ejecutar($sql);
if($res){
    echo("<script>
     alertify.alert('mensaje', 'Registro Grabado!', function(){
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
