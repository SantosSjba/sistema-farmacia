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
  $cod=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['cod'],ENT_QUOTES))));
  $no=trim($obj->real_escape_string($_POST['txtno']));
  $td=trim($obj->real_escape_string($_POST['td']));
  $di=trim($obj->real_escape_string($_POST['txtdi']));
  $txtnrodoc=trim($obj->real_escape_string($_POST['txtnrodoc']));
  $txttipo=trim($obj->real_escape_string($_POST['txttipo']));

$sql="UPDATE `cliente` SET `nombres`='$no',`id_tipo_docu`='$td',`direccion`='$di',`nrodoc`='$txtnrodoc',`tipo`='$txttipo' WHERE idcliente=$cod";
$res=$obj->ejecutar($sql);
if($res){
    echo("<script>
     alertify.alert('mensaje', 'Registro Actualizado!', function(){
     alertify.success('Ok');
    window.location.replace('index.php');
     });
    </script>");
    }else{
      echo("<script>
       alertify.alert('mensaje', 'algo salio mal vuelva a intentarlo!', function(){
       alertify.success('Ok');
      window.location.replace('index.php');
       });
      </script>");
    }

}
if($funcion=="registrar"){
  $no=trim($obj->real_escape_string($_POST['txtno']));
  $td=trim($obj->real_escape_string($_POST['td']));
  $di=trim($obj->real_escape_string($_POST['txtdi']));
  $txtnrodoc=trim($obj->real_escape_string($_POST['txtnrodoc']));
  $txttipo=trim($obj->real_escape_string($_POST['txttipo']));

$sql="INSERT INTO `cliente`(`nombres`, `id_tipo_docu`, `direccion`, `nrodoc`, `tipo`)
VALUES ('$no','$td','$di','$txtnrodoc','$txttipo')";
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
