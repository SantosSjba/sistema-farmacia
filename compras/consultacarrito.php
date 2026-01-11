<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
$num=$result=$obj->consultar("SELECT * FROM carritoc WHERE session_id='$usu'");
$item = array();
$index = 1;
$data=$obj->consultar("SELECT impuesto FROM configuracion");
		foreach($data as $row){
			$impuesto=$row['impuesto'];
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
<style type="text/css">
.sisee {
	font-size: 17px;
	font-family: Georgia, "Times New Roman", Times, serif;
}
</style>

 <div class="table-responsive">
	 <table class="table table-bordered">
				<tr class="info">
						 <th width="10%">Item</th>
						 <th width="40%">Descripcion</th>
						 <th width="20%">Presentacion</th>
						 <th width="10%">Cantidad</th>
						 <th width="10%">P.Compra</th>
						 <th width="10%">Importe</th>
						 <th width="10%"></th>
				</tr>
<?php
if($num > 0)
{
foreach((array)$result as $row){
$item[$index] = $row;
?>
				<tr>
					  <td><?php echo $index++;?></td>
						<td><?php echo $row["descripcion"];?></td>
						<td><?php echo $row["presentacion"];?></td>
					  <td contenteditable class="cantidad" id="cantidad" id2="<?php echo $row["idproducto"];?>"><?php echo $c=$row["cantidad"];?></td>
						<td contenteditable class="precio" id="precio" id1="<?php echo $row["idproducto"];?>"><?php echo $p=$row["precio"];?></td>
						<td><?php $im=$c*$p;echo number_format($im,2);?></td>
						<td><button type="button" name="delete_btn" data-id3="<?php echo $row["idproducto"];?>" class="btn btn-xs btn-danger btn_delete"><span class='glyphicon glyphicon-minus'></span></button></td>
				</tr>
<?php
};
}else{
echo"<tr>
<td colspan='8'align='center'>No Se Encontro Productos Agregados Al carrito</td>
						 </tr>";
}
?>
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
