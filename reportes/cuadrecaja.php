<?php
include("../seguridad.php");
ob_start();
$tipo = $_SESSION["tipo"];
$usu = $_SESSION["usuario"];
include("../conexion/clsConexion.php");
$obj=new clsConexion;
date_default_timezone_set('America/Lima');
$dia = date("Y-m-d");
$totalventas = 0;
$formaefectivo = 0;
$formapago = 0;
$formaefectivo = 0;
$formadeposito = 0;
$formatarjeta=0;

// ADMIN puede ver cuadre de cualquier usuario vía GET. USUARIO solo el propio.
$usu_cuadre = $usu;
$dia_cuadre = $dia;
if ($tipo == 'ADMINISTRADOR' && isset($_GET['usuario']) && isset($_GET['fecha'])) {
    $usu_cuadre = $obj->real_escape_string(trim($_GET['usuario']));
    $fec_get = $obj->real_escape_string(trim($_GET['fecha']));
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fec_get)) {
        $dia_cuadre = $fec_get;
    }
} elseif ($tipo == 'USUARIO') {
    $usu_cuadre = $usu;
}

// Obtener idusu del cajero
$usur = $obj->consultar("SELECT idusu FROM usuario WHERE usuario = '" . $obj->real_escape_string($usu_cuadre) . "'");
if ($usur && count($usur) > 0) {
    foreach ((array)$usur as $row) {
        $usuario = $row['idusu'];
    }
} else {
    die('Error al obtener el usuario');
}

// Obtener monto de caja_apertura (por usuario y fecha)
$monto_res = $obj->consultar("SELECT * FROM caja_apertura WHERE usuario = '" . $obj->real_escape_string($usu_cuadre) . "' AND fecha = '" . $obj->real_escape_string($dia_cuadre) . "' ORDER BY idcaja_a DESC");
$monto = 0; $caja = ''; $turno = '';
if ($monto_res && count($monto_res) > 0) {
    $row = $monto_res[0];
    $monto = $row['monto'];
    $caja = $row['caja'];
    $turno = $row['turno'];
} else {
    die('No hay datos de apertura de caja para el usuario y fecha seleccionados.');
}
// Resumen por forma de pago (EFECTIVO, YAPE, PLIN, TARJETA, etc.)
$por_forma = array();
$ventas_por_forma = $obj->consultar("SELECT formadepago, COALESCE(SUM(total), 0) as total FROM venta WHERE fecha_emision = '" . $obj->real_escape_string($dia_cuadre) . "' AND idusuario = '$usuario' GROUP BY formadepago");
foreach ((array)$ventas_por_forma as $row) {
    $por_forma[$row['formadepago']] = floatval($row['total']);
}
$formaefectivo = isset($por_forma['EFECTIVO']) ? $por_forma['EFECTIVO'] : 0;
$formatarjeta = isset($por_forma['TARJETA']) ? $por_forma['TARJETA'] : 0;
$formadeposito = isset($por_forma['DEPOSITO EN CUENTA']) ? $por_forma['DEPOSITO EN CUENTA'] : 0;
$efectivo = number_format($formaefectivo, 2);
$tarjeta = number_format($formatarjeta, 2);
$deposito = number_format($formadeposito, 2);
// Obtener cierre de caja (por usuario y fecha del cuadre)
$result = $obj->consultar("SELECT * FROM caja_cierre WHERE usuario = '" . $obj->real_escape_string($usu_cuadre) . "' AND fecha = '" . $obj->real_escape_string($dia_cuadre) . "'");

    foreach ((array)$result as $row) {
        $di = $row['diferencia'];
        $e_c = $row['efectivo_caja'];
        $c_s = $row['caja_sistema'];
    }
$result = $obj->consultar("SELECT * FROM configuracion WHERE idconfi = '1'");
if ($result) {
    foreach ((array)$result as $row) {
        $razon = $row["razon_social"];
        $dir = $row["direccion"];
        $ruc_num = $row["ruc"];
        $logo = $row["logo"];
    }
} else {
    die('Error al obtener la configuración');
}

?>
<html>
<head>
<!-- <script type='text/javascript'>
	window.onload=function(){
		self.print();
	}
</script> -->
	<meta charset="utf-8">
<style media='print'>
input{display:none;}
</style>
<style type="text/css">

.zona_impresion{
width: 400px;
padding:10px 5px 10px 5px;
float:left;
font-size:12.5px;
}

center {
	text-align: center;
}

#negrita {
	font-weight: bold;
}
</style>
<script>
function imprimir()
{
  var Obj = document.getElementById("desaparece");
  Obj.style.visibility = 'hidden';
  window.print();
}
function regresa()
{
   header("Location:index.php");
}
</script>

</head>
<body >
<div class="zona_impresion">
<table  border="0" class="zona_impresion">
  <tr>
    <td colspan="2" align="center"><img src="../configuracion/foto/<?php echo $logo?>" width="120" height="120" style="object-fit: contain;" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?php echo "$razon".'-  '."RUC".'  :'."$ruc_num";?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><?php echo "$dir";?></td>
  </tr>
  <tr>
    <td colspan="2" align="center"> <p><?php echo "FECHA DE EMISION: ".date("Y-m-d H:i:s"); ?><br>
    </p>
	</td>
  </tr>
	<tr>
	    <td colspan="5">=================================================</td>
	</tr>
	<tr>
    <td colspan="2" align="center"><b>CUADRE DIARIO DE CAJA</b></td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
	  <td>FECHA CAJA:</td>
	  <td><?php echo htmlspecialchars($dia_cuadre); ?></td>
    </tr>
	<tr>
	  <td>CAJERO:</td>
	  <td><?php echo htmlspecialchars($usu_cuadre); ?></td>
    </tr>
	<tr>
		<td width="268">TURNO:</td>
    <td width="268"><?php echo "$turno"; ?></td>
  </tr>
	<tr>
		<td width="268"><strong>MONTO APERTURA:</strong></td>
    <td width="268"><?php echo "$monto"; ?></td>
  </tr>
  <tr>
    <td colspan="2">-------------------------------------------------------------------------------------</td>
    </tr>
  <tr>
    <td><strong>TOTAL VENTA DEL DIA:</strong></td>
    <td><?php if(isset($p)) echo $p; ?></td>
  </tr>
  <tr>
    <td colspan="2">-------------------------------------------------------------------------------------</td>
    </tr>
  <tr>
    <td colspan="2">RESUMEN POR FORMA DE PAGO:</td>
    </tr>
    <?php
    foreach ((array)$por_forma as $nombre_forma => $monto) {
        $monto_f = number_format($monto, 2);
        $etiqueta = $nombre_forma;
        if ($nombre_forma === 'DEPOSITO EN CUENTA') $etiqueta = 'DEPÓSITOS';
    ?>
  <tr>
    <td><?php echo htmlspecialchars($etiqueta); ?>:</td>
    <td><?php echo $monto_f; ?></td>
  </tr>
    <?php } ?>
  <tr>
    <td colspan="2">------------------------------------------------------------------------------------</td>
  </tr>
  <tr>
    <td><strong>TOTALES:</strong></td>
    <td><?php if(isset($c_s)) echo "$c_s"; ?></td>
  </tr>
  <tr>
    <td colspan="2">-------------------------------------------------------------------------------------</td>
    </tr>
  <tr>
    <td><strong>TOTAL DE EFECTIVO EN LA CAJA:</strong></td>
    <td><?php if(isset($e_c)) echo "$e_c"; ?></td>
  </tr>
  <tr>
    <td colspan="2">-------------------------------------------------------------------------------------</td>
    </tr>
  <tr>
    <td><strong>DIFERENCIA:</strong></td>
    <td><?php if(isset($di)) echo "$di"; ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>

</table>
<table border="0" width="300px" align="center" class="zona_impresion">
<br>
    <tr>
      <td width="317" align="left"><input type="button" onClick="location.href='../caja/movimiento.php'" value="regresar"></td>
      <td width="117" align="center"><input type="button" id="desaparece" onClick="imprimir()" value="Imprimir"></td>
    </tr>

</table>
</div>
<p><br>
</p>
<p>
</body>
</html>
