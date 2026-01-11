<?php
include_once("conexion/clsConexion.php");
$obj = new clsConexion;
// session_start();
$result = $obj->consultar("SELECT logo FROM configuracion");
foreach ((array) $result as $row) {
    $logo = $row['logo'];
}
$data = $obj->consultar("SELECT * FROM confi_backup WHERE idbackup='1'");
foreach ((array) $data as $row) {
    $host = $row["host"];
    $db_name = $row["db_name"];
    $user = $row["user"];
    $pass = $row["pass"];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SISFARMA</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/inicio/AdminLTE.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: url('assets/images/fondo4.jpeg') no-repeat center center;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            overflow-y: hidden;
        }

        .login-box1 {
            width: 300px;
            padding: 20px;
            background: transparent !important;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }

        .login-box1-body {
            padding: 20px;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-logo img {
            display: block;
            margin: 0 auto;
        }

        .form-control {
            font-size: 14px;
        }

        .btn {
            font-size: 14px;
        }
    </style>


</head>

<body class="transparente">

    <div class="login-box1">

        <div class="login-logo">
            <img src="configuracion/foto/<?php echo $logo ?>" width="150" height="50" alt="Logo" />
            <img src="assets/images/sunat.png" width="250" height="80"/>
        </div>
        <div class="login-box1-body">
            <!-- <p class="login-box-msg">Iniciar sesión</p> -->
            <form name="form1" method="post" action="validasesion.php">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control rounded-pill" name="usuario" id="usuario" required
                        placeholder="Ingrese el usuario" autocomplete="off" />
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control rounded-pill" name="clave" id="password" required
                        placeholder="Ingrese la clave" autocomplete="off" />
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="text-center">
                    <button type="submit" value="Ingresar" class="btn btn-outline-primary">
                        <i class="fa fa-unlock"></i> INICIAR SESION
                    </button>
                </div>
            </form>
            <div align="center">
            <span><?php echo date('Y'); ?></span> - <span>All rights reserved.</span>
            <br/>
                <a href="#" target="_blank" class="link-secondary small">Factosys Peru</a>
            </div>
        </div>
    </div>
</body>

</html>

<script src="public/js/jquery-3.1.1.min.js"></script>
<link rel="stylesheet" href="assets/inicio/bootstrap.min.css">
<script src="public/bootstrap/js/bootstrap.min.js"></script>