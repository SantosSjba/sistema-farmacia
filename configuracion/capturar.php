<?php   include("../seguridad.php");?>
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
    $txtimp=trim($obj->real_escape_string(strip_tags($_POST['txtimp'],ENT_QUOTES)));
$txtra=trim($obj->real_escape_string(strip_tags($_POST['txtra'],ENT_QUOTES)));
$txtnoc=trim($obj->real_escape_string(strip_tags($_POST['txtnoc'],ENT_QUOTES)));
$txtruc=trim($obj->real_escape_string(strip_tags($_POST['txtruc'],ENT_QUOTES)));
$txtdir=trim($obj->real_escape_string(strip_tags($_POST['txtdir'],ENT_QUOTES)));
$txtmon=trim($obj->real_escape_string(strip_tags($_POST['txtmon'],ENT_QUOTES)));
$txtdepa=trim($obj->real_escape_string(strip_tags($_POST['txtdepa'],ENT_QUOTES)));
$txtpro=trim($obj->real_escape_string(strip_tags($_POST['txtpro'],ENT_QUOTES)));
$txtdist=trim($obj->real_escape_string(strip_tags($_POST['txtdist'],ENT_QUOTES)));
$txtubigeo=trim($obj->real_escape_string(strip_tags($_POST['txtubigeo'],ENT_QUOTES)));
$txtususol=trim($obj->real_escape_string(strip_tags($_POST['txtususol'],ENT_QUOTES)));
$txtclavesol=trim($obj->real_escape_string(strip_tags($_POST['txtclavesol'],ENT_QUOTES)));

    $img_eliminar_1=$_POST["img_eliminar_1"];
   if ($_FILES['imagen']['name'] == ""){
  		//$result_img=$objalumno->consultaralumnoPorParametro('id',$cod,'');
      	$result=$obj->consultar("select logo from configuracion where idconfi='1';");
  		foreach($result as $row){
  			$nom_img_1=$row['logo'];
  		}
  		$nombreFichero_1=$nom_img_1;
  		$copiarFichero_1 = false;
  	 }else{
  		//Subir fichero
  		$copiarFichero_1 = false;
  		//Para garantizar la unicidad del nombre se anade una marca de tiempo
  		if (is_uploaded_file ($_FILES['imagen']['tmp_name'])){
  			$nombreDirectorio_1 = "foto/";
  			$nombreFichero_1_1 = $_FILES['imagen']['name'];
  			$nombreFichero_1=str_replace(" ","_",$nombreFichero_1_1);

  			$copiarFichero_1 = true;
  		//Si ya existe un fichero con el mismo nombre, renombrarlo
  			$nombreCompleto_1 = $nombreDirectorio_1 . $nombreFichero_1;
  			if (is_file($nombreCompleto_1)){
  				$idUnico_1 = time();
  				$nombreFichero_1 = $idUnico_1 . "-" . $nombreFichero_1;
  			}
  		// No se ha introducido ning�n fichero
  		}else if ($_FILES['imagen']['name'] == ""){
  			$nombreFichero_1 = '';
  		// El fichero introducido no se ha podido subir
  		}else{
  			$errores["imagen"] = "No se ha podido subir el fichero!";
  			$error = true;
  		}
  	}
   // $sql="UPDATE `configuracion` SET `logo`='$nombreFichero_1',`empresa`='$empresa',`moneda`='$mo',`imp_num`='$imp_num',`imp_letra`='$imp_letra' where idconfi='1'";
 $sql="UPDATE `configuracion` SET `logo`='$nombreFichero_1',`tipodoc`='6',`ruc`='$txtruc',`razon_social`='$txtra',`nombre_comercial`='$txtnoc'
 ,`direccion`='$txtdir',`pais`='PE',`departamento`='$txtdepa',`provincia`='$txtpro',`distrito`='$txtdist',`ubigeo`='$txtubigeo',`usuario_sol`='$txtususol',
 `clave_sol`='$txtclavesol',`simbolo_moneda`='$txtmon',`impuesto`='$txtimp' where idconfi='1'";
  $obj->ejecutar($sql);
  if ($copiarFichero_1){
      	move_uploaded_file($_FILES['imagen']['tmp_name'],$nombreDirectorio_1 . $nombreFichero_1);
  		$dir="foto/".$img_eliminar_1;
  			if($img_eliminar_1!=""){
  					if(file_exists($dir)){
  						unlink($dir);
  					}
  			}
     }
       echo("<script>
        alertify.alert('configuracion', 'Configuracion Exitosa!', function(){
       	alertify.success('Ok');
       window.location.replace('configuracion.php');
       	});
       </script>");
  //    	echo"<script>
  //     alertify.alert('configuracion', 'Configuracion Exitosa!', function(){
  // 	alertify.success('Ok');
  // 	self.location='configuracion.php';
  // 	});
  // </script>";
  }

  ?>
  </body>
