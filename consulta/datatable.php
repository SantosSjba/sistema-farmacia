<?php
include("../seguridad.php");
include("../conexion/clsConexion.php");
// $idsucursal=$_SESSION["sucursal"];
		$objproductos=new clsConexion;
		$result=$objproductos->consultar("SELECT productos.*
		     , lote.fecha_vencimiento
		     , presentacion.presentacion
		     , sintoma.sintoma
		     , lote.numero
		FROM
		  productos
		INNER JOIN lote
		ON productos.idlote = lote.idlote
		INNER JOIN presentacion
		ON productos.idpresentacion = presentacion.idpresentacion
		INNER JOIN sintoma
		ON productos.idsintoma = sintoma.idsintoma");

		$data= Array();
	foreach ((array)$result as $row) {
		$st=$row['stock'];
	// while ($reg=$rspta->fetch_object()){
	if($row['stock']<=$row['stockminimo']) {
	$color="<span class='label label-danger'>$st</span>";
	}else{
	$color="<span class='label label-success'>$st</span>";
	}
	//ventasujeta
	if($row['ventasujeta']=='Con receta medica'){
	$msn="si";
	}else{
	$msn="no";
	}
	//estado
	if ($row['estado']=='1'){
	 $estado="<span class='label label-success'>Activo</span>";
	}else{
	 $estado="<span class='label label-danger'>Inactivo</span>";
	}
		$data[]=array(
			"0"=>$row['codigo'],
			"1"=>$row['descripcion'],
			"2"=>$row['presentacion'],
			"3"=>$row['fecha_vencimiento'],
			"4"=>$color,
			"5"=>$row['precio_venta'],
			"6"=>$row['tipo'],
			"7"=>$estado,
			"8"=>$row['sintoma'],
			"9"=>$row['fecha_vencimiento'],
			"10"=>$row['descuento'],
			"11"=>$msn,
			"12"=>'<a href="similar.php?idproducto='.$row["idproducto"].'" class="btn btn-success btn-xs">Similar</a>',
			);
	}
	$results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
?>
