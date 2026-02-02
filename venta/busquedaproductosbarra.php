<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
if (isset($_GET['term'])){
	# conectare la base de datos
	include_once("../conexion/clsConexion.php");
    $obj=new clsConexion;
	
	// Sanitizar entrada para prevenir SQL Injection
	$q = $obj->real_escape_string(trim($_GET['term']));

$return_arr = array();
/* Si la conexión a la base de datos, ejecuta instrucción SQL. */
	$data=$obj->consultar("SELECT presentacion.presentacion ,productos.descuento, productos.descripcion , productos.estado, productos.stock, productos.codigo , productos.idproducto , productos.precio_venta
		FROM productos INNER JOIN presentacion ON productos.idpresentacion = presentacion.idpresentacion
		WHERE stock>='1' AND estado='1' AND codigo LIKE '%".$q."%' LIMIT 0 ,50");
	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	foreach($data as $row) {
		$id_producto=$row['idproducto'];
		$precio=number_format($row['precio_venta'],2,".","");
		$descuento=number_format($row['descuento'],2,".","");
		$row_array['value'] = $row['descripcion']." ".$row['presentacion'];
		$row_array['presentacion']=$row['presentacion'];
		$row_array['idproducto']=$row['idproducto'];
		$row_array['codigo']=$row['codigo'];
		$row_array['descripcion']=$row['descripcion'];
		$row_array['descuento']=$row['descuento'];
		$row_array['precio']=$precio;
		$row_array['descuento']=$descuento;
		array_push($return_arr,$row_array);
    }
/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);
}
?>
