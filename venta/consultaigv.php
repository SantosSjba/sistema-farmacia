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
								$data5=$obj->consultar("SELECT ROUND(SUM(valor_total)+$igv,2) as total FROM carrito WHERE session_id='$usu'");
										foreach((array)$data5 as $row){
											$total=$row['total'];
										 }
?>
<div class="center">
	<table class="table table-striped">
	  <tr>
	    <td width="98">OP. GRAVADAS:</td>
	    <td width="52"><?php if($op_gravadas==null){ echo '0.00';}else{echo "$mon".' '."$op_gravadas";}?></td>
  </tr>
	<tr>
		<td width="98">IGV:</td>
		<td width="52"><?php if($igv==null){ echo '0.00'; }else{ echo "$mon".' '."$igv";}?></td>
	</tr>
	<tr>
		<td width="98">OP. EXONERADAS:</td>
		<td width="52"><?php if($op_exoneradas==null){ echo '0.00'; }else{ echo "$mon".' '."$op_exoneradas";}?></td>
	</tr>
	<tr>
		<td width="98">OP. INAFECTAS:</td>
		<td width="52"><?php if($op_inafectas==null){ echo '0.00'; }else{ echo "$mon".' '."$op_inafectas";}?></td>
	</tr>
<tr>
	<td width="110"><label>IMPORTE TOTAL:</label></td>
	<td width="80"><?php  if($total==null){ echo '0.00';}else{echo "$mon".' '."$total";}?>
		 <input type="hidden" id="total" name="total" value="<?php echo $total;?>"/>
	</td>
</tr>
	</table>
</div>
