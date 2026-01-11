<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
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

// Obtener usuario
$usur = $obj->consultar("SELECT idusu FROM usuario WHERE usuario = '$usu'");
if ($usur) {
    foreach ((array)$usur as $row) {
        $usuario = $row['idusu'];
    }
} else {
    die('Error al obtener el usuario');
}

// Obtener monto
$monto = $obj->consultar("SELECT * FROM caja_apertura WHERE usuario = '$usu' AND fecha = '$dia'");
if ($monto) {
    foreach ((array)$monto as $row) {
        $monto = $row['monto'];
        $caja = $row['caja'];
        $turno = $row['turno'];
    }
} else {
    die('Error al obtener el monto');
}
// Obtener ventas en efectivo
$ventas_e = $obj->consultar("SELECT * FROM venta WHERE fecha_emision = '$dia' AND idusuario = '$usuario' AND formadepago='EFECTIVO'");
    foreach ((array)$ventas_e as $row) {
        $ef = $formaefectivo += $row['total'];
        $efectivo = number_format($ef, 2);
    }
// Obtener ventas con tarjeta
$ventas_t = $obj->consultar("SELECT * FROM venta WHERE fecha_emision = '$dia' AND idusuario = '$usuario' AND formadepago='TARJETA'");
    foreach ((array)$ventas_t as $row) {
        $ta = $formatarjeta += $row['total'];
        $tarjeta = number_format($ta, 2);
    }
// Obtener ventas con depositos
$ventas_d = $obj->consultar("SELECT * FROM venta WHERE fecha_emision = '$dia' AND idusuario = '$usuario' AND formadepago='DEPOSITO EN CUENTA'");
    foreach ((array)$ventas_d as $row) {
        $de = $formadeposito += $row['total'];
        $deposito = number_format($de, 2);
    }
// Configuración
$result = $obj->consultar("SELECT * FROM caja_cierre WHERE usuario = '$usu' AND fecha = '$dia'");

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
    <td colspan="2" align="center"><img src="../configuracion/foto/<?php echo $logo?>" width="210" height="50" /></td>
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
	  <td><?php echo "$dia"; ?></td>
    </tr>
	<tr>
	  <td>CAJERO:</td>
	  <td><?php echo "$caja"; ?></td>
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
    <td colspan="2">RESUMEN:</td>
    </tr>
    <tr>
    <td>PAGOS EN EFECTIVO:</td>
    <td><?php if(isset($efectivo)) echo "$efectivo"; ?></td>
  </tr>
  <tr>
    <td>PAGOS CON TARJETA:</td>
    <td><?php if(isset($tarjeta)) echo "$tarjeta"; ?></td>
  </tr>
  <tr>
    <td>PAGOS EN DEPOSITOS:</td>
    <td><?php if(isset($deposito)) echo "$deposito"; ?></td>
  </tr>
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
