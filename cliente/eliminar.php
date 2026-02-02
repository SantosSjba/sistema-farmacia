<?php
require "../conexion/clsConexion.php";
$obj= new clsConexion();
$cod= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['id'],ENT_QUOTES))));

// Verificar si es un laboratorio con productos asociados
$productos = $obj->consultar("SELECT COUNT(*) as total FROM productos WHERE idcliente = '".$obj->real_escape_string($cod)."'");
$tiene_productos = 0;
foreach((array)$productos as $row) {
    $tiene_productos = $row['total'];
}

// Verificar si tiene ventas asociadas
$ventas = $obj->consultar("SELECT COUNT(*) as total FROM venta WHERE idcliente = '".$obj->real_escape_string($cod)."'");
$tiene_ventas = 0;
foreach((array)$ventas as $row) {
    $tiene_ventas = $row['total'];
}

// Verificar si tiene compras asociadas
$compras = $obj->consultar("SELECT COUNT(*) as total FROM compra WHERE idcliente = '".$obj->real_escape_string($cod)."'");
$tiene_compras = 0;
foreach((array)$compras as $row) {
    $tiene_compras = $row['total'];
}

// Verificar si tiene notas de crédito asociadas
$notas = $obj->consultar("SELECT COUNT(*) as total FROM nota_credito WHERE idcliente = '".$obj->real_escape_string($cod)."'");
$tiene_notas = 0;
foreach((array)$notas as $row) {
    $tiene_notas = $row['total'];
}

// Obtener información del cliente para el mensaje
$info_cliente = $obj->consultar("SELECT nombres, tipo FROM cliente WHERE idcliente = '".$obj->real_escape_string($cod)."'");
$nombre_cliente = "";
$tipo_cliente = "";
foreach((array)$info_cliente as $row) {
    $nombre_cliente = $row['nombres'];
    $tipo_cliente = $row['tipo'];
}

// Verificar si hay registros asociados
if($tiene_productos > 0 || $tiene_ventas > 0 || $tiene_compras > 0 || $tiene_notas > 0) {
    $mensaje = "No se puede eliminar ";
    $mensaje .= ($tipo_cliente == 'laboratorio') ? "el laboratorio" : "el cliente";
    $mensaje .= " '".$nombre_cliente."' porque tiene: ";
    
    $partes = array();
    if($tiene_productos > 0) {
        $partes[] = $tiene_productos . " producto(s) asociado(s)";
    }
    if($tiene_ventas > 0) {
        $partes[] = $tiene_ventas . " venta(s)";
    }
    if($tiene_compras > 0) {
        $partes[] = $tiene_compras . " compra(s)";
    }
    if($tiene_notas > 0) {
        $partes[] = $tiene_notas . " nota(s) de crédito";
    }
    $mensaje .= implode(", ", $partes) . ".";
    echo $mensaje;
} else {
    $sql= "DELETE FROM cliente WHERE idcliente='".$obj->real_escape_string($cod)."'";
    $resultado = $obj->ejecutar($sql);
    
    if($resultado) {
        echo "Eliminado satisfactoriamente...";
    } else {
        echo "Error al eliminar. Intente nuevamente.";
    }
}
?>
