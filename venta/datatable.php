<?php
include("../seguridad.php");
include("../conexion/clsConexion.php");
$obj = new clsConexion;
$result = $obj->consultar("SELECT sintoma.sintoma
		     , productos.*
		     , lote.numero
		     , presentacion.presentacion
		FROM
		  productos
		INNER JOIN sintoma
		ON productos.idsintoma = sintoma.idsintoma
		INNER JOIN lote
		ON productos.idlote = lote.idlote
		INNER JOIN presentacion
		ON productos.idpresentacion = presentacion.idpresentacion  WHERE  stock>='1' AND  estado='1'");
$data = array();
foreach ((array) $result as $row) {
	$st = $row['stock'];
	if ($row['stock'] <= $row['stockminimo']) {
		$color = "<span class='label label-danger'>$st</span>";
	} else {
		$color = "<span class='label label-success'>$st</span>";
	}
	//con receta
	if ($row['ventasujeta'] == 'Con receta medica') {
		$receta = "si";
	} else {
		$receta = "no";
	}
	//estado
	if ($row['estado'] == '1') {
		$estado = "<span class='label label-success'>Activo</span>";
	} else {
		$estado = "<span class='label label-danger'>Inactivo</span>";
	}
	$data[] = array(
		"0" => $row['descripcion'],
		"1" => $row['presentacion'],
		"2" => $row['precio_venta'],
		"3" => $row['sintoma'],
		"4" => $receta,
		"5" => $estado,
		"6" => $color,
		"7" => $row['tipo'],
		"8" => '<button type="button"
				data-id1="' . $row["idproducto"] . '"
				data-id2="' . $row["descripcion"] . '"
				data-id3="' . $row["presentacion"] . '"
				data-id4="' . $row["precio_venta"] . '"
				class="btn btn-info btn-sm btn-icon btn_add">Agregar</button>',
	);
}
$results = array(
	"sEcho" => 1, //Información para el datatables
	"iTotalRecords" => count($data), //enviamos el total registros al datatable
	"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
	"aaData" => $data
);
echo json_encode($results);
?>