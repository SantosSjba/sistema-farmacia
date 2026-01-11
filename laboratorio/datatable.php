<?php
include("../seguridad.php");
include("../conexion/clsConexion.php");
$idsucursal=$_SESSION["sucursal"];
		$obj=new clsConexion;
    $result=$obj->consultar("select * from laboratorio_proveedor WHERE idsucu_c='$idsucursal'");
		$data= Array();
	foreach ((array)$result as $row) {

		$data[]=array(
			"0"=>$row['laboratorio'],
			"1"=>$row['ruc'],
			"2"=>$row['direccion'],
			"3"=>$row['telefono'],
      "4"=>'<a href="actualizar.php?idlab_pro='.$row["idlab_pro"].'" class="btn btn-info btn-xs">Editar</a>',
			"5"=>'<button type="button" name="delete" id="'.$row["idlab_pro"].'" class="btn btn-danger btn-xs delete">Eliminar</button>',
			);
	}
	$results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
?>
