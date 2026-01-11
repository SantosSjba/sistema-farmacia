<?php
include("../seguridad.php");
include("../conexion/clsConexion.php");
		$obj=new clsConexion;
    $result=$obj->consultar("select * from categoria");
		$data= Array();
	foreach ((array)$result as $row) {

		$data[]=array(
			"0"=>$row['forma_farmaceutica'],
			"1"=>$row['ff_simplificada'],
      "2"=>'<a href="actualizar.php?idcategoria='.$row["idcategoria"].'" class="btn btn-info btn-xs">Editar</a>',
			// "3"=>'<a href="eliminar.php?cod='.$row["idcategoria"].'" class="btn btn-danger btn-xs">Eliminar</a>',
			"3"=>'<button type="button" name="delete" id="'.$row["idcategoria"].'" class="btn btn-danger btn-xs delete">Eliminar</button>',
			);
	}
	$results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
?>
