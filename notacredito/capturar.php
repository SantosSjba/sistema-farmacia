<?php 
include("../seguridad.php");
$usu=$_SESSION["usuario"];
?>
<head>
   <link rel="stylesheet" href="../assets/alert/alertify/alertify.css">
     <link rel="stylesheet" href="../assets/alert/alertify/themes/default.css">
   <script src="../assets/alert/alertify/alertify.js"></script>
</head>
<body>
<?php
include_once("../conexion/clsConexion.php");
//include_once("sunat.php");
$obj= new clsConexion();
$funcion=$_POST["funcion"];

if($funcion=="registrar"){

$serie_v=$obj->real_escape_string($_POST['serie_v']);
$correlativo_v=$obj->real_escape_string($_POST['correlativo_v']);

$serie_n=$obj->real_escape_string($_POST['serie_n']);
$correlativo_n=$obj->real_escape_string($_POST['correlativo_n']);

$fecha=$obj->real_escape_string($_POST['fecha']);

    $busca_idusu=$obj->consultar("SELECT * FROM usuario WHERE usuario='$usu'");
        foreach((array)$busca_idusu as $row){
            $idusuario=$row['idusu'];
        }
    $imps=$obj->consultar("SELECT ruc FROM configuracion where idconfi='1'");
    foreach((array)$imps as $row){
      $ruc=$row['ruc'];
    }

$data=$obj->consultar("SELECT
serie.serie,
serie.correlativo,
venta.*
FROM venta
INNER JOIN serie
  ON venta.idserie = serie.idserie 
WHERE serie.serie='$serie_v' AND serie.correlativo='$correlativo_v'");
foreach((array)$data as $row){
  $op_gravadas = $row["op_gravadas"];
	$op_exoneradas = $row["op_exoneradas"];
	$op_inafectas = $row["op_inafectas"];
	$igv = $row["igv"];
	$total = $row["total"];
	$idventa= $row["idventa"];
  $idserie= $row["idserie"];
  $idcliente= $row["idcliente"];
}
$nombrexml = 'R-'.''.$ruc.'-07-'.$serie_n.'-'.$correlativo_n.'.XML';
$sql="INSERT INTO `nota_credito`
(`idconf`, `tipocomp`, `idcliente`, `idusuario`, `idserie`, `fecha_emision`, `op_gravadas`, `op_exoneradas`, `op_inafectas`, `igv`, `total`, `serie_ref`, `correlativo_ref`, `codmotivo`, `feestado`, `fecodigoerror`, `femensajesunat`, `nombrexml`, `xmlbase64`, `cdrbase64`, `idventa`) 
VALUES 
('1','07','$idcliente','$idusuario','$idserie','$fecha','$op_gravadas','$op_exoneradas','$op_inafectas','$igv','$total','$serie_n','$correlativo_n','01',null,null,null,'$nombrexml',null,null,'$idventa')";

//obtener el ultimo id de serie
$data_s = $obj->consultar("SELECT COALESCE(MAX(idserie), 0) + 1 as idserie FROM serie");
$idserie_s = $data_s[0]['idserie'];

//guarda el correlativo en la tabla serie
$sql_s="INSERT INTO `serie`(`idserie`,`tipocomp`, `serie`, `correlativo`) VALUES ('$idserie_s','07','$serie_n','$correlativo_n')";
$obj->ejecutar($sql_s);

//actualizar el estado de la venta
$sql_upd = "UPDATE venta SET `estado`='anulado' WHERE idventa='$idventa'";
$obj->ejecutar($sql_upd);
$res=$obj->ejecutar($sql);

if($res){
 // $ultimo_id = mysqli_insert_id($obj->con);
    $ultimo_id = $obj->insert_id(); 
    header("Location: sunat.php?idnota=" . $ultimo_id);
    exit;
  // Obtener el último ID insertado
  // Llamar a la función en sunat.php con el ID
  
  //header("Location: sunat.php");
  //exit;
 /*    echo("<script>
     alertify.alert('mensaje', 'La nota de credito ha sido registrada con exito!', function(){
     alertify.success('Ok');
    window.location.replace('index.php');
     });
    </script>"); */
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
