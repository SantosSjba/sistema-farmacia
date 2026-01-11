<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
$data=$obj->consultar("SELECT impuesto,simbolo_moneda FROM configuracion");
		foreach($data as $row){
			$impuesto=$row['impuesto'];
			$mon=$row["simbolo_moneda"];
		}
$num=$result=$obj->consultar("SELECT * FROM carritoc WHERE session_id='$usu'");
$data=$obj->consultar("SELECT ROUND(SUM(importe)*$impuesto/100+SUM(importe),2) as total FROM carritoc WHERE session_id='$usu'");
		foreach($data as $row){
			$total=$row['total'];
		}
?>
<h1 align="center"><?php  if($total==null){echo "$mon".''."0.00";}else{echo "$mon".' '."$total";}?></h1>


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
