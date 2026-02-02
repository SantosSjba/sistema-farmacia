<?php
include("../seguridad.php");
include("../conexion/clsConexion.php");
//$idsucursal=$_SESSION["sucursal"];
		$objcliente=new clsConexion;
	  $result=$objcliente->consultar("select * from cliente WHERE nombres <> 'publico en general'");
		$data= Array();
	foreach ((array)$result as $row) {
		// Sanitizar salida para prevenir XSS
		$data[]=array(
			"0"=>htmlspecialchars($row['nombres'], ENT_QUOTES, 'UTF-8'),
			"1"=>htmlspecialchars($row['direccion'], ENT_QUOTES, 'UTF-8'),
			"2"=>htmlspecialchars($row['nrodoc'], ENT_QUOTES, 'UTF-8'),
			"3"=>'<a href="actualizar.php?idcliente='.intval($row["idcliente"]).'" class="btn btn-info btn-xs">Editar</a>',
			"4"=>'<button type="button" name="delete" id="'.intval($row["idcliente"]).'" class="btn btn-danger btn-xs delete">Eliminar</button>',
			);
	}
	$results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
?>
