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
$funcion = isset($_POST["funcion"]) ? $_POST["funcion"] : '';

if($funcion=="modificar"){
  $cod = intval(isset($_POST['cod']) ? $_POST['cod'] : 0);
  $cb = $obj->real_escape_string(trim(isset($_POST['txtcb']) ? $_POST['txtcb'] : ''));
  $lo = intval(isset($_POST['txtlo']) ? $_POST['txtlo'] : 1);
  $txtfv = trim(isset($_POST['txtfv']) ? $_POST['txtfv'] : '');
  $de = $obj->real_escape_string(trim(isset($_POST['txtde']) ? $_POST['txtde'] : ''));
  $ti = $obj->real_escape_string(trim(isset($_POST['txtti']) ? $_POST['txtti'] : 'Generico'));
  $st = intval(isset($_POST['txtst']) ? $_POST['txtst'] : 0);
  $stm = intval(isset($_POST['txtstm']) ? $_POST['txtstm'] : 0);
  $pc = floatval(isset($_POST['txtpc']) ? $_POST['txtpc'] : 0);
  $pv = floatval(isset($_POST['txtpv']) ? $_POST['txtpv'] : 0);
  $vs = $obj->real_escape_string(trim(isset($_POST['txtvs']) ? $_POST['txtvs'] : 'sin receta medica'));
  $fec = $obj->real_escape_string(trim(isset($_POST['txtfec']) ? $_POST['txtfec'] : date('Y-m-d')));
  $rs = $obj->real_escape_string(trim(isset($_POST['txtrs']) ? $_POST['txtrs'] : ''));
  $cat = intval(isset($_POST['tcat']) ? $_POST['tcat'] : 0);
  $pre = intval(isset($_POST['tpre']) ? $_POST['tpre'] : 1);
  $tidcli = intval(isset($_POST['tidcli']) ? $_POST['tidcli'] : 0);
  $si = intval(isset($_POST['tsi']) ? $_POST['tsi'] : 0);
  $estado = $obj->real_escape_string(trim(isset($_POST['txte']) ? $_POST['txte'] : '1'));
  $tafec = intval(isset($_POST['tafec']) ? $_POST['tafec'] : 1);
  $tipo_pre = $obj->real_escape_string(trim(isset($_POST['tipo_pre']) ? $_POST['tipo_pre'] : '01'));

  // Valores por defecto para productos generales (cuando no se selecciona o está vacío)
  if(empty($ti) || $ti == 'No Aplica') $ti = 'No Aplica';
  if(empty($vs) || $vs == 'No aplica') $vs = 'No aplica';
  
  // Si categoría está vacía, buscar la primera disponible
  if(empty($cat)) {
    $result_cat = $obj->consultar("SELECT idcategoria FROM categoria LIMIT 1");
    foreach((array)$result_cat as $row) { $cat = $row['idcategoria']; }
  }
  
  // Si síntoma está vacío, buscar el primero disponible
  if(empty($si)) {
    $result_sin = $obj->consultar("SELECT idsintoma FROM sintoma LIMIT 1");
    foreach((array)$result_sin as $row) { $si = $row['idsintoma']; }
  }
  
  // Si laboratorio está vacío, buscar el primero disponible
  if(empty($tidcli)) {
    $result_lab = $obj->consultar("SELECT idcliente FROM cliente WHERE tipo='laboratorio' LIMIT 1");
    foreach((array)$result_lab as $row) { $tidcli = $row['idcliente']; }
  }

  // Actualizar fecha de vencimiento del lote si se envió
  if (!empty($txtfv) && $lo > 0) {
    $txtfv_safe = $obj->real_escape_string($txtfv);
    $obj->ejecutar("UPDATE lote SET fecha_vencimiento = '" . $txtfv_safe . "' WHERE idlote = " . $lo);
  }

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
  $cb = $obj->real_escape_string(trim(isset($_POST['txtcb']) ? $_POST['txtcb'] : ''));
  $lo = intval(isset($_POST['txtlo']) ? $_POST['txtlo'] : 0);
  $de = $obj->real_escape_string(trim(isset($_POST['txtde']) ? $_POST['txtde'] : ''));
  $ti = $obj->real_escape_string(trim(isset($_POST['txtti']) ? $_POST['txtti'] : 'Generico'));
  $st = intval(isset($_POST['txtst']) ? $_POST['txtst'] : 0);
  $stm = intval(isset($_POST['txtstm']) ? $_POST['txtstm'] : 0);
  $pc = floatval(isset($_POST['txtpc']) ? $_POST['txtpc'] : 0);
  $pv = floatval(isset($_POST['txtpv']) ? $_POST['txtpv'] : 0);
  $vs = $obj->real_escape_string(trim(isset($_POST['txtvs']) ? $_POST['txtvs'] : 'sin receta medica'));
  $fec = $obj->real_escape_string(trim(isset($_POST['txtfec']) ? $_POST['txtfec'] : date('Y-m-d')));
  $rs = $obj->real_escape_string(trim(isset($_POST['txtrs']) ? $_POST['txtrs'] : ''));
  $cat = intval(isset($_POST['tcat']) ? $_POST['tcat'] : 0);
  $pre = intval(isset($_POST['tpre']) ? $_POST['tpre'] : 1);
  $tidcli = intval(isset($_POST['tidcli']) ? $_POST['tidcli'] : 0);
  $si = intval(isset($_POST['tsi']) ? $_POST['tsi'] : 0);
  $estado = $obj->real_escape_string(trim(isset($_POST['txte']) ? $_POST['txte'] : '1'));
  $tafec = intval(isset($_POST['tafec']) ? $_POST['tafec'] : 1);
  $tipo_pre = $obj->real_escape_string(trim(isset($_POST['tipo_pre']) ? $_POST['tipo_pre'] : '01'));
  
  // Valores por defecto para productos generales (cuando no se selecciona o está vacío)
  if(empty($ti) || $ti == 'No Aplica') $ti = 'No Aplica';
  if(empty($vs) || $vs == 'No aplica') $vs = 'No aplica';
  
  // Si categoría está vacía, buscar "No Aplica" o la primera disponible
  if(empty($cat)) {
    $result_cat = $obj->consultar("SELECT idcategoria FROM categoria WHERE forma_farmaceutica LIKE '%No Aplica%' LIMIT 1");
    if(empty($result_cat)) {
      $result_cat = $obj->consultar("SELECT idcategoria FROM categoria LIMIT 1");
    }
    foreach((array)$result_cat as $row) { $cat = $row['idcategoria']; }
  }
  
  // Si síntoma está vacío, buscar "No Aplica" o el primero disponible
  if(empty($si)) {
    $result_sin = $obj->consultar("SELECT idsintoma FROM sintoma WHERE sintoma LIKE '%No Aplica%' LIMIT 1");
    if(empty($result_sin)) {
      $result_sin = $obj->consultar("SELECT idsintoma FROM sintoma LIMIT 1");
    }
    foreach((array)$result_sin as $row) { $si = $row['idsintoma']; }
  }
  
  // Si laboratorio está vacío, buscar "SIN LABORATORIO" o el primero disponible
  if(empty($tidcli)) {
    // Buscar laboratorio con diferentes criterios (insensible a mayúsculas)
    $result_lab = $obj->consultar("SELECT idcliente FROM cliente WHERE LOWER(TRIM(tipo))='laboratorio' AND (LOWER(nombres) LIKE '%sin laboratorio%' OR LOWER(nombres) LIKE '%generico%') LIMIT 1");
    if(empty($result_lab)) {
      $result_lab = $obj->consultar("SELECT idcliente FROM cliente WHERE LOWER(TRIM(tipo))='laboratorio' LIMIT 1");
    }
    // Si aún no hay laboratorios, buscar cualquier cliente
    if(empty($result_lab)) {
      $result_lab = $obj->consultar("SELECT idcliente FROM cliente LIMIT 1");
    }
    foreach((array)$result_lab as $row) { $tidcli = intval($row['idcliente']); }
  }
  
  // Si lote está vacío, buscar "SIN LOTE" o el primero disponible
  if(empty($lo)) {
    $result_lote = $obj->consultar("SELECT idlote FROM lote WHERE numero LIKE '%SIN LOTE%' OR numero = '0000' LIMIT 1");
    if(empty($result_lote)) {
      $result_lote = $obj->consultar("SELECT idlote FROM lote LIMIT 1");
    }
    foreach((array)$result_lote as $row) { $lo = intval($row['idlote']); }
  }

  // Si se ingresó fecha de vencimiento: usar o crear lote con esa fecha
  $txtfv = trim(isset($_POST['txtfv']) ? $_POST['txtfv'] : '');
  if (!empty($txtfv)) {
    $txtfv_safe = $obj->real_escape_string($txtfv);
    $rl = $obj->consultar("SELECT numero FROM lote WHERE idlote = " . intval($lo) . " LIMIT 1");
    $numero_lote = 'SIN LOTE';
    if (is_array($rl) && count($rl) > 0) {
      $numero_lote = isset($rl[0]['numero']) ? $obj->real_escape_string($rl[0]['numero']) : 'SIN LOTE';
    }
    $existe = $obj->consultar("SELECT idlote FROM lote WHERE numero = '" . $numero_lote . "' AND fecha_vencimiento = '" . $txtfv_safe . "' LIMIT 1");
    if (is_array($existe) && count($existe) > 0) {
      $lo = intval($existe[0]['idlote']);
    } else {
      $obj->ejecutar("INSERT INTO lote (numero, fecha_vencimiento, idsucu_c) VALUES ('" . $numero_lote . "','" . $txtfv_safe . "','1')");
      $lo = $obj->insert_id();
      if (empty($lo)) {
        $r2 = $obj->consultar("SELECT idlote FROM lote WHERE numero = '" . $numero_lote . "' AND fecha_vencimiento = '" . $txtfv_safe . "' ORDER BY idlote DESC LIMIT 1");
        if (is_array($r2) && count($r2) > 0) $lo = intval($r2[0]['idlote']);
      }
    }
  }
  
  // Validar que todos los campos requeridos tengan valores
  if(empty($cat)) $cat = 1;
  if(empty($si)) $si = 1;
  if(empty($tidcli)) $tidcli = 1;
  if(empty($lo)) $lo = 1;
  if(empty($pre)) $pre = 1;
  if(empty($tafec)) $tafec = 1;

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
      // Registrar error para debug
      $error_msg = $obj->error();
      error_log("Error al insertar producto: " . $error_msg . " - SQL: " . substr($sql, 0, 500));
      echo("<script>
       alertify.alert('mensaje', 'Error al registrar. Verifique que todos los campos estén correctos.', function(){
       alertify.error('Error');
      window.location.replace('insertar.php');
       });
      </script>");
    }
}
?>
</body>
