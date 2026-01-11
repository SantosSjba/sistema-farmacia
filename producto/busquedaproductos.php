<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
if (isset($_GET['term'])){
	$q=$_GET['term'];
	# conectare la base de datos
	include_once("../conexion/clsConexion.php");
    $obj=new clsConexion;


$return_arr = array();
/* Si la conexi�n a la base de datos , ejecuta instrucci�n SQL. */
	$data=$obj->consultar("SELECT productos.idproducto
     , productos.descripcion
     , presentacion.presentacion
FROM
  productos
INNER JOIN presentacion
ON productos.idpresentacion = presentacion.idpresentacion WHERE descripcion LIKE '%$q%' OR presentacion LIKE '%$q%' LIMIT 0 ,50");
	/* Recuperar y almacenar en conjunto los resultados de la consulta.*/
	foreach($data as $row) {
		$id_producto=$row['idproducto'];
		$row_array['value'] =$row['descripcion']."|".$row['presentacion'];
		$row_array['idproducto']=$row['idproducto'];
		$row_array['descripcion']=$row['descripcion'];
		$row_array['presentacion']=$row['presentacion'];
		array_push($return_arr,$row_array);
    }
/* Codifica el resultado del array en JSON. */
echo json_encode($return_arr);
}
?>
