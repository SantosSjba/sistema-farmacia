<?php
include("../seguridad.php");
include("../conexion/clsConexion.php");
		$obj=new clsConexion;
	  $result=$obj->consultar("select * from compra ORDER BY idcompra DESC");
		$data= Array();
	  foreach ((array)$result as $row) {
		$data[]=array(
			"0"=>$row['docu'],
			"1"=>$row['num_docu'],
			"2"=>$row['fecha'],
			"3"=>$row['total'],
			"4"=>'<a href="../reportes/ticketcompra.php?idcompra='.$row["idcompra"].'" class="btn btn-success btn-sm">Imprimir</a>',
			);
	}
	$results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
?>
