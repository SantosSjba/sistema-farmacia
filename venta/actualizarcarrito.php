<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();

// Sanitizar entradas
$usu_safe = $obj->real_escape_string($usu);
$id = intval($_POST['id']); // Solo aceptar enteros para IDs
$text = floatval($_POST['text']); // Solo aceptar números para cantidades

// Validar nombre de columna - solo permitir valores específicos
$columnas_permitidas = array('cantidad', 'precio_unitario');
$cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : '';
if (!in_array($cantidad, $columnas_permitidas)) {
    $cantidad = 'cantidad'; // Valor por defecto
}

$result=$obj->consultar("SELECT * FROM carrito WHERE session_id='".$usu_safe."' AND idproducto ='".$id."'");
$ope = '';
$pu_c = 0;
foreach((array)$result as $row){
    $ope=$row['operacion'];
    $pu_c=floatval($row['precio_unitario']);
}

$result=$obj->consultar("SELECT * FROM productos where idproducto='".$id."'");
$stock = 0;
$v_u = 0;
foreach((array)$result as $row){
    $stock=intval($row["stock"]);
    $v_u=floatval($row['precio_venta']);
}

$imps=$obj->consultar("SELECT impuesto FROM configuracion");
$impuesto = 18;
foreach((array)$imps as $row){
    $impuesto=floatval($row['impuesto']);
}

if($text > $stock){
    echo 'NO CUENTA CON EL STOCK SUFICIENTE';
}else{
    if ($ope=='OP. GRAVADAS') {
        $pu_g = round((float)$pu_c / (1 + ($impuesto/100)), 6);
        $v_t = round($pu_g * $text, 6);
        $imp = round($text * $pu_c, 2);
        $igv = round(($impuesto/100) * $pu_g * $text, 2);

        $sql = "UPDATE carrito SET ".$cantidad."=".$text.",valor_total=".$v_t.",importe_total=".$imp.",igv=".$igv."
        WHERE session_id='".$usu_safe."' AND idproducto='".$id."'";
        $obj->ejecutar($sql);
        echo 'ACTUALIZADO';
    } else {
        $imp = round($pu_c * $text, 2);
        $sql = "UPDATE carrito SET ".$cantidad."=".$text.",valor_total=".$imp.",importe_total=".$imp." WHERE session_id='".$usu_safe."' AND idproducto='".$id."'";
        $obj->ejecutar($sql);
        echo 'ACTUALIZADO';
    }
}
?>
