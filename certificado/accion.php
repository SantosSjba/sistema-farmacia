<?php
error_reporting(0);
//  include("../seguridad.php");
include_once("../conexion/clsConexion.php");
include('funciones.php');
$obj = new clsConexion();
$c_ce = trim($obj->real_escape_string(strip_tags($_POST['c_ce'])));
$est = trim($obj->real_escape_string(strip_tags($_POST['est'])));
$cod = '1';

// Obtener el nombre del archivo actual
$imagen_actual = trim($obj->real_escape_string(strip_tags($_POST['certificado_actual'])));

// Variable para el nuevo nombre del archivo
$imagen = $imagen_actual;

// Verificar si se ha subido un nuevo archivo
if ($_FILES["imagen"]["name"] != '') {
    $imagen = cargar_imagen();
    if (isset($cod)) {
        $imagen2 = obtener_nombreimagen($obj, $cod);
        if ($imagen2 != '' && $imagen2 != $imagen_actual) {
            unlink("foto/" . $imagen2);
        }
    }
}

$sql = "UPDATE `certificado` SET `certificado`='$imagen', `clave_certificado`='$c_ce', `estado`='$est' WHERE idcertificado='1'";
$res = $obj->ejecutar($sql);

if ($res) {
    echo "operacion exitosa";
} else {
    echo "algo salio mal vuelva a intentarlo";
}
?>
