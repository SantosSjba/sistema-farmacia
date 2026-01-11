<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
$num=$result=$obj->consultar("SELECT * FROM carrito WHERE session_id='$usu'");
$item = array();
$index = 1;
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
						 <th width="10%">V.Unitario</th>
						 <th width="10%">P.Unitario</th>
						 <!-- <th width="10%">Descuento</th> -->
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
						<td><?php echo $row["valor_unitario"];?></td>
						<td contenteditable class="precio_unitario" id="precio_unitario" id1="<?php echo $row["idproducto"];?>"><?php echo $row["precio_unitario"];?></td>

						<!-- <td><?php echo $row["precio_unitario"];?></td> -->
						<td><?php echo number_format($row["importe_total"],2);?></td>
						<td><button type="button" name="delete_btn" data-id3="<?php echo $row["idproducto"];?>" class="btn btn-xs btn-danger btn_delete"><span class='glyphicon glyphicon-minus'></span></button></td>

				</tr>
<?php
};
}else{
echo"<tr>
<td colspan='8'align='center'>No Se Encontro Productos Agregados Al Carrito</td>
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
            //alert(vuelto);
            $("#vuelto").val(vuelto.toFixed(2));
        });
    });
  </script>
