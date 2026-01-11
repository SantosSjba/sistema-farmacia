<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
if (isset($_GET['term'])){
	include_once("../conexion/clsConexion.php");
  $obj=new clsConexion;
  $return_arr = array();
	$data=$obj->consultar("SELECT * FROM cliente WHERE tipo='laboratorio' and nombres like '%" .($_GET['term']) . "%' LIMIT 0 ,50");
	foreach($data as $row) {
		$id_producto=$row['idcliente'];
		$row_array['value'] =$row['nombres'];
		$row_array['idcliente']=$row['idcliente'];
		$row_array['nombres']=$row['nombres'];
		array_push($return_arr,$row_array);
    }
echo json_encode($return_arr);
}
?>
