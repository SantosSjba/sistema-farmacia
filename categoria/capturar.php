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
$fa=trim($obj->real_escape_string($_POST['txtfa'],ENT_QUOTES));
$ff=trim($obj->real_escape_string($_POST['txtff'],ENT_QUOTES));

$sql="update categoria set forma_farmaceutica='$fa',ff_simplificada='$ff' where idcategoria=$cod";
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
$fa=trim($obj->real_escape_string($_POST['txtfa'],ENT_QUOTES));
$ff=trim($obj->real_escape_string($_POST['txtff'],ENT_QUOTES));
$sql="insert into categoria(forma_farmaceutica,ff_simplificada)values('$fa','$ff')";
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
