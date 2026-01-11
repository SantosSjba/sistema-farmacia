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
  $n=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtn'],ENT_QUOTES))));
  $mail=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtmail'],ENT_QUOTES))));
  $tel=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtt'],ENT_QUOTES))));
  $fec=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtfec'],ENT_QUOTES))));
  $ca=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtca'],ENT_QUOTES))));
  $e=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txte'],ENT_QUOTES))));
  $u=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtu'],ENT_QUOTES))));
  $cl=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtcl'],ENT_QUOTES))));
  $tipo=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txttipo'],ENT_QUOTES))));
$clavemd5 = md5($cl);
$sql="update usuario set usuario='$u',clave='$clavemd5',cargo_usu='$ca',nombres='$n',email='$mail',telefono='$tel',fechaingreso='$fec',tipo='$tipo',estado='$e' where idusu=$cod";
$obj->ejecutar($sql);
echo("<script>
 alertify.alert('mensaje', 'Registro Actualizado!', function(){
 alertify.success('Ok');
window.location.replace('index.php');
 });
</script>");
}
if($funcion=="registrar"){
  $n=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtn'],ENT_QUOTES))));
  $mail=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtmail'],ENT_QUOTES))));
  $tel=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtt'],ENT_QUOTES))));
  $fec=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtfec'],ENT_QUOTES))));
  $ca=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtca'],ENT_QUOTES))));
  $e=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txte'],ENT_QUOTES))));
  $u=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtu'],ENT_QUOTES))));
  $cl=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txtcl'],ENT_QUOTES))));
  $tipo=trim($obj->real_escape_string(htmlentities(strip_tags($_POST['txttipo'],ENT_QUOTES))));
$clavemd5 = md5($cl);
$sql="insert into usuario(usuario,clave,cargo_usu,nombres,email,telefono,fechaingreso,tipo,estado)values('$u','$clavemd5','$ca','$n','$mail','$tel','$fec','$tipo','$e')";
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
