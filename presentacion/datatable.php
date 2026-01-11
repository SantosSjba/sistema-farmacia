<?php
include("../seguridad.php");
include_once("../conexion/clsConexion.php");
////$idsucursal=$_SESSION["sucursal"];
		$obj=new clsConexion;
    $result=$obj->consultar("select * from presentacion");
		$data= Array();
	foreach ((array)$result as $row) {

		$data[]=array(
			"0"=>$row['presentacion'],
      "1"=>'<a href="actualizar.php?idpresentacion='.$row["idpresentacion"].'" class="btn btn-info btn-xs">Editar</a>',
			"2"=>'<button type="button" name="delete" id="'.$row["idpresentacion"].'" class="btn btn-danger btn-xs delete">Eliminar</button>'
			);
	}
	$results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
?>
