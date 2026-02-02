<?php
require "../conexion/clsConexion.php";
$obj= new clsConexion();
$cod= trim($obj->real_escape_string(htmlentities(strip_tags($_POST['id'],ENT_QUOTES))));

// Verificar si el producto tiene ventas asociadas
$ventas = $obj->consultar("SELECT COUNT(*) as total FROM detalleventa WHERE idproducto = '".$obj->real_escape_string($cod)."'");
$tiene_ventas = 0;
foreach((array)$ventas as $row) {
    $tiene_ventas = $row['total'];
}

// Verificar si el producto tiene compras asociadas
$compras = $obj->consultar("SELECT COUNT(*) as total FROM detallecompra WHERE idproducto = '".$obj->real_escape_string($cod)."'");
$tiene_compras = 0;
foreach((array)$compras as $row) {
    $tiene_compras = $row['total'];
}

if($tiene_ventas > 0 || $tiene_compras > 0) {
    $mensaje = "No se puede eliminar el producto porque tiene ";
    $partes = array();
    if($tiene_ventas > 0) {
        $partes[] = $tiene_ventas . " venta(s)";
    }
    if($tiene_compras > 0) {
        $partes[] = $tiene_compras . " compra(s)";
    }
    $mensaje .= implode(" y ", $partes) . " registrada(s). Puede desactivarlo en su lugar.";
    echo $mensaje;
} else {
    // También eliminar productos similares asociados
    $sql_similar = "DELETE FROM producto_similar WHERE idproducto='".$obj->real_escape_string($cod)."'";
    $obj->ejecutar($sql_similar);
    
    $sql= "DELETE FROM productos WHERE idproducto='".$obj->real_escape_string($cod)."'";
    $resultado = $obj->ejecutar($sql);
    
    if($resultado) {
        echo "Eliminado satisfactoriamente...";
    } else {
        echo "Error al eliminar el producto. Intente nuevamente.";
    }
}
?>
