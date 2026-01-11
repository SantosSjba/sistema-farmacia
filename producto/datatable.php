<?php
include("../seguridad.php");
include("../conexion/clsConexion.php");
		$obj=new clsConexion;
		$result=$obj->consultar("SELECT presentacion.presentacion
		     , productos.codigo
		     , productos.descripcion
		     , productos.stock
		     , productos.precio_venta
		     , productos.estado
		     , productos.stockminimo
		     , productos.tipo
		     , productos.idproducto
		FROM
		  productos
		INNER JOIN presentacion
		ON productos.idpresentacion = presentacion.idpresentacion");
		$data= Array();
	foreach ((array)$result as $row) {
		$st=$row['stock'];
	// while ($reg=$rspta->fetch_object()){
	if($row['stock']<=$row['stockminimo']) {
	$color="<span class='label label-danger'>$st</span>";
	}else{
	$color="<span class='label label-success'>$st</span>";
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
			"3"=>$color,
			"4"=>$row['precio_venta'],
			"5"=>$estado,
			"6"=>$row['tipo'],
			"7"=>'<a href="actualizar.php?idproducto='.$row["idproducto"].'" class="btn btn-info btn-xs">Editar</a>',
			"8"=>'<button type="button" name="delete" id="'.$row["idproducto"].'" class="btn btn-danger btn-xs delete">Eliminar</button>',
			"9"=>'<a href="similar.php?idproducto='.$row["idproducto"].'" class="btn btn-success btn-xs">Similar</a>',
			);
	}
	$results = array(
		"sEcho"=>1, //Información para el datatables
		"iTotalRecords"=>count($data), //enviamos el total registros al datatable
		"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
		"aaData"=>$data);
	echo json_encode($results);
?>
