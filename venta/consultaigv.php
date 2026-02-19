<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
//declarar variables
$op_gravadas = 0;
$op_exoneradas = 0;
$op_inafectas = 0;
$igv = 0;
$total = 0;
$impuesto='';

						$imps=$obj->consultar("SELECT impuesto,simbolo_moneda FROM configuracion");
								foreach((array)$imps as $row){
									$impuesto=$row['impuesto'];
									$mon=$row['simbolo_moneda'];
								}
					   $data1=$obj->consultar("SELECT ROUND(SUM(valor_total),2) as op_gravadas FROM carrito WHERE operacion='OP. GRAVADAS' AND session_id='$usu'");
							foreach((array)$data1 as $row){
								$op_gravadas=$row['op_gravadas'];
							}

							$data2=$obj->consultar("SELECT ROUND(SUM(valor_total),2) as op_exoneradas FROM carrito  WHERE operacion='OP. EXONERADAS' AND session_id='$usu'");
									foreach((array)$data2 as $row){
										$op_exoneradas=$row['op_exoneradas'];
									}

								$data3=$obj->consultar("SELECT ROUND(SUM(valor_total),2) as valor_total FROM carrito  WHERE  operacion='OP. INAFECTAS' AND session_id='$usu'");
										foreach((array)$data3 as $row){
											$op_inafectas=$row['valor_total'];
										}

								$data4=$obj->consultar("SELECT ROUND(SUM(valor_total)*$impuesto/100,2) as igv FROM carrito WHERE operacion='OP. GRAVADAS' AND session_id='$usu'");
										foreach((array)$data4 as $row){
											if($row['igv']==null){
												$igv=0;
											}else{
												$igv=$row['igv'];
											}

										}
								$data5=$obj->consultar("SELECT COALESCE(SUM(importe_total), 0) as total FROM carrito WHERE session_id='$usu'");
										foreach((array)$data5 as $row){
											$total=$row['total'];
										 }
		$op_gravadas = $op_gravadas !== null ? round((float)$op_gravadas, 2) : 0;
		$op_exoneradas = $op_exoneradas !== null ? round((float)$op_exoneradas, 2) : 0;
		$op_inafectas = $op_inafectas !== null ? round((float)$op_inafectas, 2) : 0;
		$igv = $igv !== null ? round((float)$igv, 2) : 0;
		$total = $total !== null ? round((float)$total, 2) : 0;
?>
<div class="center">
	<table class="table table-striped">
	  <tr>
	    <td width="98">OP. GRAVADAS:</td>
	    <td width="52"><?php echo $mon.' '.number_format($op_gravadas, 2, '.', ''); ?></td>
  </tr>
	<tr>
		<td width="98">IGV:</td>
		<td width="52"><?php echo $mon.' '.number_format($igv, 2, '.', ''); ?></td>
	</tr>
	<tr>
		<td width="98">OP. EXONERADAS:</td>
		<td width="52"><?php echo $mon.' '.number_format($op_exoneradas, 2, '.', ''); ?></td>
	</tr>
	<tr>
		<td width="98">OP. INAFECTAS:</td>
		<td width="52"><?php echo $mon.' '.number_format($op_inafectas, 2, '.', ''); ?></td>
	</tr>
<tr>
	<td width="110"><label>IMPORTE TOTAL:</label></td>
	<td width="80"><?php echo $mon.' '.number_format($total, 2, '.', ''); ?>
		 <input type="hidden" id="total" name="total" value="<?php echo number_format($total, 2, '.', ''); ?>"/>
	</td>
</tr>
	</table>
</div>
