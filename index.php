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
        /* Prevenir conflictos de Bootstrap */
        .btn-outline-primary {
            border: none !important;
        }
    </style>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-image: url('assets/images/fondo4.jpeg');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: relative;
            overflow-y: auto;
        }

        /* Efecto de partículas animadas en el fondo */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(102, 126, 234, 0.1);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                opacity: 0.3;
            }
            50% {
                opacity: 0.6;
            }
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-box1 {
            width: 100%;
            padding: 40px 35px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.6s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-box1-body {
            padding: 0;
        }

        .login-logo {
            text-align: center;
            margin-bottom: 35px;
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .login-logo img {
            display: block;
            margin: 0 auto 15px;
            transition: transform 0.3s ease;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
            max-width: 100%;
            height: auto;
        }

        .login-logo img:hover {
            transform: scale(1.05);
        }

        .login-logo img:first-child {
            margin-bottom: 20px;
        }

        /* Fallback para logo que no carga */
        .login-logo img[src=""],
        .login-logo img:not([src]) {
            display: none;
        }

        .logo-placeholder {
            display: inline-block;
            width: 150px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            margin: 0 auto 20px;
            line-height: 50px;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .login-title {
            text-align: center;
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .login-subtitle {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group.has-feedback {
            position: relative;
        }

        input.form-control,
        .form-control {
            font-size: 15px !important;
            padding: 15px 20px 15px 50px !important;
            border: 2px solid #e0e0e0 !important;
            border-radius: 12px !important;
            width: 100% !important;
            transition: all 0.3s ease !important;
            background: #f8f9fa !important;
            color: #333 !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
            box-sizing: border-box !important;
        }

        .form-control:focus {
            outline: none !important;
            border-color: #667eea !important;
            background: #fff !important;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1) !important;
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: #999;
        }

        .form-control-feedback {
            position: absolute !important;
            left: 18px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            color: #667eea !important;
            font-size: 18px !important;
            pointer-events: none !important;
            z-index: 100 !important;
            line-height: 1 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 20px !important;
            height: 20px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Asegurar que los iconos se vean correctamente */
        .form-control-feedback i {
            display: inline-block !important;
            line-height: 1 !important;
            font-size: 18px !important;
            width: 18px !important;
            height: 18px !important;
            text-align: center !important;
        }

        .form-group:focus-within .form-control-feedback {
            color: #764ba2;
            animation: iconPulse 0.5s ease;
        }

        @keyframes iconPulse {
            0%, 100% {
                transform: translateY(-50%) scale(1);
            }
            50% {
                transform: translateY(-50%) scale(1.2);
            }
        }

        /* Estilos del botón con mayor especificidad */
        button.btn,
        .btn,
        input[type="submit"].btn {
            font-size: 16px !important;
            font-weight: 600 !important;
            padding: 15px 30px !important;
            border-radius: 12px !important;
            width: 100% !important;
            transition: all 0.3s ease !important;
            text-transform: none !important;
            letter-spacing: 0.5px !important;
            border: none !important;
            cursor: pointer !important;
            position: relative !important;
            overflow: hidden !important;
            display: block !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            appearance: none !important;
        }

        button.btn-outline-primary,
        .btn-outline-primary,
        input[type="submit"].btn-outline-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4) !important;
        }

        button.btn-outline-primary:hover,
        .btn-outline-primary:hover,
        input[type="submit"].btn-outline-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6) !important;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%) !important;
        }

        button.btn-outline-primary:active,
        .btn-outline-primary:active,
        input[type="submit"].btn-outline-primary:active {
            transform: translateY(0) !important;
        }

        button.btn-outline-primary::before,
        .btn-outline-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
            z-index: 0;
        }

        button.btn-outline-primary:hover::before,
        .btn-outline-primary:hover::before {
            width: 300px;
            height: 300px;
        }

        button.btn i,
        .btn i {
            margin-right: 8px;
            position: relative;
            z-index: 1;
        }

        button.btn span,
        .btn span {
            position: relative;
            z-index: 1;
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            color: #999;
            font-size: 13px;
        }

        .footer-text a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .footer-text a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Animación de entrada para los campos */
        .form-group:nth-child(1) {
            animation: fadeInLeft 0.6s ease-out 0.2s both;
        }

        .form-group:nth-child(2) {
            animation: fadeInLeft 0.6s ease-out 0.4s both;
        }

        .text-center {
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Asegurar que el botón no se vea como input */
        #loginButton,
        button[type="submit"] {
            -webkit-appearance: button !important;
            -moz-appearance: button !important;
            appearance: button !important;
        }

        /* Override de Bootstrap que pueda afectar */
        .btn-outline-primary.btn-outline-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border: none !important;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-box1 {
                padding: 30px 25px;
                border-radius: 15px;
            }

            .login-title {
                font-size: 24px;
            }

            input.form-control,
            .form-control {
                padding: 12px 15px 12px 45px !important;
                font-size: 14px !important;
            }
        }

        /* Efecto de carga al enviar formulario - Un solo loader suave */
        .form-loading {
            pointer-events: none;
        }

        .form-loading .btn {
            position: relative;
            overflow: hidden;
        }

        /* Ocultar texto suavemente cuando está cargando */
        .form-loading .btn span,
        .form-loading .btn i {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Spinner CSS único - animación suave */
        .form-loading .btn::after {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            top: 50%;
            left: 50%;
            margin-left: -9px;
            margin-top: -9px;
            border: 2.5px solid rgba(255, 255, 255, 0.25);
            border-top-color: rgba(255, 255, 255, 0.95);
            border-right-color: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: spinLoader 0.75s linear infinite;
            z-index: 10;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Mostrar spinner cuando está cargando */
        .form-loading .btn::after {
            opacity: 1;
        }

        /* Animación suave del spinner */
        @keyframes spinLoader {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Asegurar que el botón mantenga su altura durante la carga */
        .form-loading .btn {
            min-height: 48px;
        }
    </style>


</head>

<body class="transparente">
    <div class="login-container">
        <div class="login-box1">
            <div class="login-logo">
                <?php if (!empty($logo) && file_exists("configuracion/foto/" . $logo)): ?>
                    <img src="configuracion/foto/<?php echo htmlspecialchars($logo); ?>" width="150" height="50" alt="Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';" />
                    <div class="logo-placeholder" style="display:none;">SISFARMA</div>
                <?php else: ?>
                    <div class="logo-placeholder">SISFARMA</div>
                <?php endif; ?>
                <img src="assets/images/sunat.png" width="250" height="80" alt="SUNAT" onerror="this.style.display='none';" />
            </div>
            
            <h2 class="login-title">Bienvenido</h2>
            <p class="login-subtitle">Ingresa tus credenciales para continuar</p>
            
            <div class="login-box1-body">
                <form name="form1" method="post" action="validasesion.php" id="loginForm">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="usuario" id="usuario" required
                            placeholder="Usuario" autocomplete="username" />
                        <span class="form-control-feedback">
                            <i class="fa fa-user"></i>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="clave" id="password" required
                            placeholder="Contraseña" autocomplete="current-password" />
                        <span class="form-control-feedback">
                            <i class="fa fa-lock"></i>
                        </span>
                    </div>
                    <div class="text-center" style="margin-top: 10px;">
                        <button type="submit" value="Ingresar" class="btn btn-outline-primary" id="loginButton">
                            <i class="fa fa-sign-in"></i> <span>Iniciar Sesión</span>
                        </button>
                    </div>
                </form>
                
                <div class="footer-text">
                    <div>
                        <span><?php echo date('Y'); ?></span> - <span>Todos los derechos reservados</span>
                    </div>
                    <div style="margin-top: 8px;">
                        <a href="#" target="_blank">Factosys Peru</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="public/js/jquery-3.1.1.min.js"></script>
<link rel="stylesheet" href="assets/inicio/bootstrap.min.css">
<script src="public/bootstrap/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        // Asegurar que el botón se vea correctamente
        $('#loginButton').css({
            'display': 'block',
            'background': 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            'color': 'white',
            'border': 'none'
        });

        // Prevenir doble envío y mostrar loader único con animación suave
        let formSubmitted = false;
        $('#loginForm').on('submit', function(e) {
            if (formSubmitted) {
                e.preventDefault();
                return false;
            }
            formSubmitted = true;
            
            var $btn = $('#loginButton');
            var $form = $(this);
            
            // Agregar clase de loading con pequeña demora para transición suave
            setTimeout(function() {
                $form.addClass('form-loading');
                $btn.prop('disabled', true);
            }, 50);
        });

        // Efecto de focus mejorado en los inputs
        $('.form-control').on('focus', function() {
            $(this).parent().addClass('focused');
        }).on('blur', function() {
            if ($(this).val() === '') {
                $(this).parent().removeClass('focused');
            }
        });

        // Validación en tiempo real
        $('#usuario, #password').on('input', function() {
            if ($(this).val().length > 0) {
                $(this).css('border-color', '#28a745');
            } else {
                $(this).css('border-color', '#e0e0e0');
            }
        });

        // Verificar que las imágenes carguen correctamente
        $('.login-logo img').on('error', function() {
            $(this).hide();
            if ($(this).attr('alt') === 'Logo') {
                $(this).next('.logo-placeholder').show();
            }
        });
    });
</script>