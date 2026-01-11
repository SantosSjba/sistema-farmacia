<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
if (isset($_GET['term'])){
	# conectare la base de datos
	include_once("../conexion/clsConexion.php");
  $obj=new clsConexion;
  $return_arr = array();
	$data=$obj->consultar("SELECT sintoma.sintoma, productos.*, lote.numero, presentacion.presentacion
	FROM productos INNER JOIN sintoma ON productos.idsintoma = sintoma.idsintoma
	INNER JOIN lote ON productos.idlote = lote.idlote INNER JOIN presentacion
	ON productos.idpresentacion = presentacion.idpresentacion  WHERE  descripcion like '%" .($_GET['term']) . "%' ");

	foreach($data as $row) {
		$id_producto=$row['idproducto'];
		$precio=number_format($row['precio_compra'],2,".","");
		$row_array['value'] = $row['codigo']."|".$row['descripcion']."|".$row['presentacion'];
		$row_array['presentacion']=$row['presentacion'];
		$row_array['idproducto']=$row['idproducto'];
		$row_array['codigo']=$row['codigo'];
		$row_array['descripcion']=$row['descripcion'];
		$row_array['descuento']=$row['descuento'];
		$row_array['precio']=$precio;
		array_push($return_arr,$row_array);
    }
echo json_encode($return_arr);
}
?>
