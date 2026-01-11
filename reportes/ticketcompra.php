<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
include("numerosaletras.php");

	if(!empty($_GET['idcompra'])){
	$obj=new clsConexion;
//configuracion
	$NUMDOCU= trim($obj->real_escape_string(htmlentities(strip_tags($_GET['idcompra'],ENT_QUOTES))));
	$result=$obj->consultar("SELECT compra.idcompra
     , compra.fecha
     , compra.subtotal
     , compra.igv
     , compra.total
     , compra.docu
     , compra.num_docu
     , detallecompra.cantidad
     , detallecompra.precio
     , detallecompra.importe
     , productos.descripcion
     , compra.idcliente
FROM
  detallecompra
INNER JOIN compra
ON detallecompra.idcompra = compra.idcompra
INNER JOIN productos
ON detallecompra.idproducto = productos.idproducto
WHERE
  compra.idcompra = '$NUMDOCU'");
			foreach((array)$result as $row){
			$fe=$row['fecha'];
		  $num_docu=$row['num_docu'];
			$docu=$row['docu'];
			$subtot=$row['subtotal'];
			$tot=$row['total'];
			$igv=$row['igv'];
			$de=$row['descripcion'];
		  // $pr=$row['presentacion'];
			$cant=$row['cantidad'];
			$prec=$row['precio'];
		  $imp=$row['importe'];
			$idlab=$row['idcliente'];

			$res=$obj->consultar("SELECT * from cliente WHERE idcliente = '$idlab'");
	      foreach((array)$res as $row){
				$lab=$row['nombres'];
				}
			}

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
// function regresa()
// {
//    header("Location:index.php");
// }
</script>

</head>
<body >
<div class="zona_impresion">
<table  border="0" class="zona_impresion">
	<tr>
		<td><center><strong><h3>ORDEN DE COMPRA</h3></strong></center></td>
	</tr>
	<tr>
			<td colspan="8">=======================================================</td>
	</tr>
	<tr>
    <td><b><?php echo "$docu"; ?></b></td>
    <td><b><?php echo "$num_docu";?></b></td>
  </tr>
	<tr>
		<td width="268">LABORATORIO:</td>
    <td width="268"><?php echo "$lab"?></td>
  </tr>
  <tr>
    <td>USUARIO:</td>
    <td><?php echo "$usu"?></td>
  </tr>

</table>
<table border="0" width="300px" align="center" class="zona_impresion">
<br>

    <tr>
        <td width="49"><b>CANT.</td>
        <td width="219"><b>DESCRIPCIÓN</td>
				<td width="49"><b>P.UNIT.</td>
        <td width="68" align="right"><b>IMPORTE</b></td>
  </tr>
    <tr>
      <td colspan="5">=======================================================</td>
    </tr>
   	<?php
		foreach((array)$result as $row){
			?>
					<tr>
			      <td><?php echo $row['cantidad']; ?></td>
					  <td><?php echo $row['descripcion'];?></td>
						<td><?php echo $row['precio'];?>
					  <td align='right'><?php echo $row['importe']; ?></td>
					</tr>
			<?php
			};
		?>
		<tr>
		  <td colspan="5">=======================================================</td>
		</tr>
		 <tr>
    <td>&nbsp;</td>
    <td colspan="3" align="right"><?php echo 'TOTAL A PAGAR: '?></td>
    <td align="right"><?php echo $subtot?></td>
    </tr>
	 <tr>
    <td>&nbsp;</td>
    <td colspan="3"  align="right"><?php echo "IGV: ";?></td>
    <td align="right"><?php echo $igv?></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td colspan="3"  align="right"><?php echo 'IMPORTE TOTAL: ';?></td>
    <td align="right"><?php echo $tot?></td>
    </tr>
		<tr>
		  <td colspan="5">=======================================================</td>
		</tr>
    <tr>
      <td colspan="5" align="left"><?php echo "SON:"." ".numtoletras($tot);?></td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" align="center">Firma</td>
    </tr>
		<tr>
      <td colspan="5" align="center"><b>NO VALIDO PARA LA SUNAT</td>
    </tr>
    <tr>

			<td colspan="3" align="left"><input type="button" onClick="location.href='../compras/consultacompras.php'" value="regresar">
			</td>

      <td colspan="3" align="center"><input type="button" id="desaparece" onClick="imprimir()" value="Imprimir"></td>
    </tr>

</table>
</div>
<p><br>
</p>
<p>
</body>
</html>
