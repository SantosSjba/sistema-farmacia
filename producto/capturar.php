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
  $cb=trim($obj->real_escape_string($_POST['txtcb'],ENT_QUOTES));
  $lo=trim($obj->real_escape_string($_POST['txtlo'],ENT_QUOTES));
  $de=trim($obj->real_escape_string($_POST['txtde'],ENT_QUOTES));
  $ti=trim($obj->real_escape_string($_POST['txtti'],ENT_QUOTES));
  $st=trim($obj->real_escape_string($_POST['txtst'],ENT_QUOTES));
  $stm=trim($obj->real_escape_string($_POST['txtstm'],ENT_QUOTES));
  $pc=trim($obj->real_escape_string($_POST['txtpc'],ENT_QUOTES));
  $pv=trim($obj->real_escape_string($_POST['txtpv'],ENT_QUOTES));
  // $des=trim($obj->real_escape_string($_POST['txtdes'],ENT_QUOTES));
  $vs=trim($obj->real_escape_string($_POST['txtvs'],ENT_QUOTES));
  $fec=trim($obj->real_escape_string($_POST['txtfec'],ENT_QUOTES));
  $rs=trim($obj->real_escape_string($_POST['txtrs'],ENT_QUOTES));
  $cat=trim($obj->real_escape_string($_POST['tcat'],ENT_QUOTES));
  $pre=trim($obj->real_escape_string($_POST['tpre'],ENT_QUOTES));
  $tidcli=trim($obj->real_escape_string($_POST['tidcli'],ENT_QUOTES));
  $si=trim($obj->real_escape_string($_POST['tsi'],ENT_QUOTES));
  $estado=trim($obj->real_escape_string($_POST['txte'],ENT_QUOTES));
  $tafec=trim($obj->real_escape_string($_POST['tafec'],ENT_QUOTES));
  $tipo_pre=trim($obj->real_escape_string($_POST['tipo_pre'],ENT_QUOTES));

$sql="UPDATE `productos` SET `codigo`='$cb',`idlote`='$lo',`descripcion`='$de',
`tipo`='$ti',`stock`='$st',`stockminimo`='$stm',`precio_compra`='$pc',`precio_venta`='$pv',
`ventasujeta`='$vs',`fecha_registro`='$fec',`reg_sanitario`='$rs',
`idcategoria`='$cat',`idpresentacion`='$pre',`idcliente`='$tidcli',`idsintoma`='$si',
`idunidad`='1',`idtipoaf`='$tafec',`estado`='$estado',`tipo_precio`='$tipo_pre' where idproducto=$cod";

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
  $cb=trim($obj->real_escape_string($_POST['txtcb'],ENT_QUOTES));
  $lo=trim($obj->real_escape_string($_POST['txtlo'],ENT_QUOTES));
  $de=trim($obj->real_escape_string($_POST['txtde'],ENT_QUOTES));
  $ti=trim($obj->real_escape_string($_POST['txtti'],ENT_QUOTES));
  $st=trim($obj->real_escape_string($_POST['txtst'],ENT_QUOTES));
  $stm=trim($obj->real_escape_string($_POST['txtstm'],ENT_QUOTES));
  $pc=trim($obj->real_escape_string($_POST['txtpc'],ENT_QUOTES));
  $pv=trim($obj->real_escape_string($_POST['txtpv'],ENT_QUOTES));
  // $des=trim($obj->real_escape_string($_POST['txtdes'],ENT_QUOTES));
  $vs=trim($obj->real_escape_string($_POST['txtvs'],ENT_QUOTES));
  $fec=trim($obj->real_escape_string($_POST['txtfec'],ENT_QUOTES));
  $rs=trim($obj->real_escape_string($_POST['txtrs'],ENT_QUOTES));
  $cat=trim($obj->real_escape_string($_POST['tcat'],ENT_QUOTES));
  $pre=trim($obj->real_escape_string($_POST['tpre'],ENT_QUOTES));
  $tidcli=trim($obj->real_escape_string($_POST['tidcli'],ENT_QUOTES));
  $si=trim($obj->real_escape_string($_POST['tsi'],ENT_QUOTES));
  $estado=trim($obj->real_escape_string($_POST['txte'],ENT_QUOTES));
  $tafec=trim($obj->real_escape_string($_POST['tafec'],ENT_QUOTES));
  $tipo_pre=trim($obj->real_escape_string($_POST['tipo_pre'],ENT_QUOTES));

$sql="INSERT INTO `productos`(`codigo`, `idlote`, `descripcion`, `tipo`, `stock`, `stockminimo`, `precio_compra`, `precio_venta`, `ventasujeta`, `fecha_registro`, `reg_sanitario`, `idcategoria`, `idpresentacion`,
`idcliente`, `idsintoma`, `idunidad`, `idtipoaf`, `estado`, `tipo_precio`)
VALUES ('$cb','$lo','$de','$ti','$st','$stm','$pc','$pv','$vs','$fec','$rs','$cat','$pre','$tidcli','$si','1','$tafec','$estado','$tipo_pre')";
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
