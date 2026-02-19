<?php
require "../conexion/clsConexion.php";
header('Content-Type: application/json; charset=utf-8');

$obj = new clsConexion();
$cod = trim($obj->real_escape_string(htmlentities(strip_tags($_POST['id'] ?? '', ENT_QUOTES))));

if (empty($cod)) {
    echo json_encode(['status' => 'error', 'message' => 'ID de venta no válido']);
    exit;
}

// Verificar que la venta existe y no está ya anulada
$venta = $obj->consultar("SELECT idventa, estado, feestado FROM venta WHERE idventa = '" . $obj->real_escape_string($cod) . "' LIMIT 1");
if (!is_array($venta) || count($venta) === 0) {
    echo json_encode(['status' => 'error', 'message' => 'Venta no encontrada']);
    exit;
}
$row_venta = (array) $venta[0];
if (isset($row_venta['estado']) && $row_venta['estado'] === 'anulado') {
    echo json_encode(['status' => 'error', 'message' => 'El ticket ya está anulado']);
    exit;
}
if (isset($row_venta['feestado']) && $row_venta['feestado'] === 'anulado') {
    echo json_encode(['status' => 'error', 'message' => 'El ticket ya está anulado']);
    exit;
}

try {
    if (method_exists($obj, 'begin_transaction')) {
        $obj->begin_transaction();
    }

    // Devolver stock: por cada línea del detalle, sumar la cantidad al producto
    $detalle = $obj->consultar("SELECT idproducto, cantidad FROM detalleventa WHERE idventa = '" . $obj->real_escape_string($cod) . "'");
    foreach ((array) $detalle as $row) {
        $idproducto = $obj->real_escape_string($row['idproducto']);
        $cantidad = floatval($row['cantidad']);
        if ($cantidad > 0) {
            $sql_stock = "UPDATE productos SET stock = stock + " . $cantidad . " WHERE idproducto = '" . $idproducto . "'";
            if (!$obj->ejecutar($sql_stock)) {
                throw new Exception("Error al devolver stock del producto " . $idproducto);
            }
        }
    }

    // Marcar venta como anulada (estado para reportes, feestado para consulta de tickets)
    $sql = "UPDATE venta SET feestado = 'anulado', estado = 'anulado' WHERE idventa = '" . $obj->real_escape_string($cod) . "'";
    if (!$obj->ejecutar($sql)) {
        throw new Exception("Error al anular la venta");
    }

    if (method_exists($obj, 'commit')) {
        $obj->commit();
    }
    echo json_encode(['status' => 'success', 'message' => 'Ticket anulado con éxito. Stock devuelto.']);
} catch (Exception $e) {
    if (method_exists($obj, 'rollback')) {
        $obj->rollback();
    }
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
