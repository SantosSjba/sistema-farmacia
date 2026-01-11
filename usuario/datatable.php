<?php
include("../seguridad.php");
include_once("../conexion/clsConexion.php");
// $idsucursal=$_SESSION["sucursal"];
		$objusuario=new clsConexion;
  $result=$objusuario->consultar("select * from usuario");
		$data= Array();
	foreach ((array)$result as $row) {
		if ($row['estado']=='Activo'){
		 $estado="<span class='label label-success'>Activo</span>";
		}else{
		 $estado="<span class='label label-danger'>Inactivo</span>";
		}
		$data[]=array(
			"0"=>$row['nombres'],
			"1"=>$row['telefono'],
			"2"=>$row['fechaingreso'],
			"3"=>$estado,
      "4"=>'<a href="actualizar.php?idusu='.$row["idusu"].'" class="btn btn-info btn-xs">Editar</a>',
			);
	}
	$results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
?>
