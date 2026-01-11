<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
$num=$result=$obj->consultar("SELECT * FROM carritoc WHERE session_id='$usu'");
$item = array();
$index = 1;
$data=$obj->consultar("SELECT impuesto,simbolo_moneda FROM configuracion");
		foreach($data as $row){
			$impuesto=$row['impuesto'];
			$mon=$row["simbolo_moneda"];
		}
$data=$obj->consultar("SELECT ROUND(SUM(importe),2) as subtotal FROM carritoc WHERE session_id='$usu'");
		foreach($data as $row){
			$subtotal=$row['subtotal'];
		}
$data=$obj->consultar("SELECT ROUND(SUM(importe)*$impuesto/100 ,2) as igv FROM carritoc WHERE session_id='$usu'");
		foreach($data as $row){
			$igv=$row['igv'];
		}
$data=$obj->consultar("SELECT ROUND(SUM(importe)*$impuesto/100+SUM(importe),2) as total FROM carritoc WHERE session_id='$usu'");
		foreach($data as $row){
			$total=$row['total'];
		}
?>
<div class="center">
	<table>
	  <tr>
	    <td width="98">SUBTOTAL:</td>
	    <td width="52"><?php if($subtotal==null){ echo '0.00';}else{echo "$mon".' '."$subtotal";}?></td>
  </tr>
	<tr>
		<td width="35">IGV:</td>
		<td width="52"><?php if($igv==null){ echo '0.00'; }else{ echo "$mon".' '."$igv";}?></td>
	</tr>
<tr>
	<td width="110"><label>TOTAL:</label></td>
	<td width="80"><?php  if($total==null){ echo '0.00';	}else{echo "$mon".' '."$total";}?>
		 <input type="hidden" id="total" name="total" value="<?php echo $total;?>"/>
	</td>
</tr>
<tr>
	<td width="100" >EFECTIVO:</td>
	<td width="200">
		<div class="input-group">
							<input type="number" min="1" id="recibo" name="recibo" class="form-control" >
								<span class="input-group-btn">
									<button type="button" value="calcular" id="calcular" class="btn btn-info"><i class="entypo-minus"></i></button>
								</span>
		</div>
	</td>
</tr>
<tr>
	<td width="65">VUELTO:</td>
	<td width="144"><h5></h5>
		<input type="text" id="vuelto" name="vuelto" disabled class="form-control"/></td>
</tr>
	</table>
</div>

<script>
$(document).ready(function () {
        $("#calcular").click(function (e) {
            var recibo = $("#recibo").val();
            var total = $("#total").val();
            var vuelto = parseFloat(recibo) - parseFloat(total);
            $("#vuelto").val(vuelto.toFixed(2));
        });
    });
  </script>
