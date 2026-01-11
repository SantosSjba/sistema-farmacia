<?php
session_start();
?>
<head>
  <link rel="stylesheet" href="assets/alert/alertify/alertify.css">
  <link rel="stylesheet" href="assets/alert/alertify/themes/default.css">
  <script src="assets/alert/alertify/alertify.js"></script>
</head>
<body>
<?php
include_once("conexion/clsConexion.php");
$obj=new clsConexion;
// Verificamos si se han enviado ambos campos: 'usuario' y 'clave'
if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {

    // Filtramos y limpiamos los datos para prevenir ataques XSS y otros riesgos
    $usuario = trim(htmlspecialchars($_POST['usuario']));  // Elimina espacios y convierte caracteres especiales
    $clave = $_POST['clave']; // La clave tal cual se recibe del formulario
    $clavemd5 = md5($clave); // Aplicamos MD5 al valor de la clave

    // Preparamos la consulta SQL para evitar inyecciones SQL, buscando el usuario en la base de datos
    // Usamos un marcador de posición '?' para el valor de 'usuario'
    $stmt = $obj->prepare("SELECT usuario, clave, estado, tipo FROM usuario WHERE usuario = ?");

    // Vinculamos el parámetro '$usuario' al marcador de posición en la consulta
    // "s" significa que el parámetro es una cadena (string)
    $stmt->bind_param("s", $usuario);

    // Ejecutamos la consulta preparada
    $stmt->execute();

    // Obtenemos el resultado de la ejecución de la consulta
    $result = $stmt->get_result();

    // Obtenemos los datos del usuario en la base de datos
    $usuario_db = $result->fetch_assoc();

    // Verificamos si el usuario existe y si la clave almacenada en la base de datos coincide con la clave que se ha enviado
    if ($usuario_db && $usuario_db['clave'] === $clavemd5) {

        // Si el estado del usuario es "Inactivo", mostramos un mensaje y redirigimos
        if ($usuario_db['estado'] === 'Inactivo') {
            echo "<script>
                    alertify.alert('Mensaje', 'Usted no se encuentra Activo en la base de datos.', function(){
                    alertify.message('OK');
                    self.location='index.php';
                });
              </script>";
        } else {
            // Si el usuario está activo, establecemos la sesión para el usuario
            $_SESSION["autentificado"] = 1; // Marcar al usuario como autenticado
            $_SESSION["usuario"] = $usuario_db['usuario']; // Guardamos el nombre del usuario
            $_SESSION["tipo"] = $usuario_db['tipo']; // Guardamos el tipo de usuario (ej. ADMINISTRADOR)

            // Si el usuario es administrador, redirigimos a la página de administrador
            // Si no es administrador, lo redirigimos a otra página
            if ($usuario_db['tipo'] === 'ADMINISTRADOR') {
                echo "<script>window.location='inicio/index.php';</script>";
            } else {
                echo "<script>window.location='inicio/index2.php';</script>";
            }
        }

    } else {
        // Si no se encuentra el usuario o la clave no coincide, mostramos un mensaje de error
        echo "<script>
                alertify.alert('Mensaje', 'Usuario y/o clave Incorrecta.', function(){
                alertify.message('OK');
                self.location='index.php';
            });
          </script>";
    }
} else {
    // Si los campos 'usuario' o 'clave' no están completos, mostramos un mensaje pidiendo que los complete
    echo "<script>
            alertify.alert('Mensaje', 'Por favor, complete ambos campos.', function(){
            alertify.message('OK');
            self.location='index.php';
        });
      </script>";
}
?>

</body>
