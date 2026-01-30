<?php
include_once("conexion/clsConexion.php");
$obj = new clsConexion;
$result = $obj->consultar("SELECT logo FROM configuracion");
foreach ((array) $result as $row) {
    $logo = $row['logo'];
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Botica J&L - Iniciar Sesión</title>
    <link rel="shortcut icon" href="assets/images/logojl.png" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --color-jl-pink: #E91E8C;
            --color-jl-pink-dark: #C4177A;
            --color-jl-pink-light: #F54BA8;
            --color-jl-teal: #2EB8A6;
            --color-jl-teal-dark: #1F9A8A;
            --color-jl-teal-light: #4FCBB9;
        }
    </style>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* Animaciones personalizadas */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Spinner para loading */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Focus styles */
        input:focus {
            outline: none;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-gray-100 via-gray-50 to-gray-200">
    <!-- Elementos decorativos sutiles -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-jl-pink/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-jl-teal/5 rounded-full blur-3xl"></div>
    </div>
    
    <!-- Contenedor principal -->
    <div class="min-h-screen flex items-center justify-center p-6 relative z-10">
        <div class="w-full max-w-md">
            <!-- Card del login -->
            <div class="bg-white rounded-[24px] shadow-[0_20px_50px_rgba(0,0,0,0.12)] overflow-hidden">
                
                <!-- Contenido del formulario -->
                <div class="px-8 py-10 sm:px-10 sm:py-12">
                    
                    <!-- Logo centrado sin bloque verde -->
                    <div class="text-center mb-8">
                        <div class="animate-float inline-block">
                            <img 
                                src="assets/images/logojl.png" 
                                alt="Botica J&L" 
                                class="w-24 h-24 mx-auto object-contain drop-shadow-md"
                            >
                        </div>
                    </div>
                    
                    <!-- Títulos -->
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-800 mb-2">Bienvenido</h1>
                        <p class="text-gray-500 text-sm">Ingresa tus credenciales para acceder</p>
                    </div>
                    
                    <form name="form1" method="post" action="validasesion.php" id="loginForm" class="space-y-5">
                        <!-- Campo Usuario -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-user text-gray-400 group-focus-within:text-jl-teal transition-colors duration-300"></i>
                            </div>
                            <input 
                                type="text" 
                                name="usuario" 
                                id="usuario" 
                                required
                                placeholder="Usuario"
                                autocomplete="username"
                                class="w-full pl-12 pr-4 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 transition-all duration-300 focus:border-jl-teal focus:bg-white focus:ring-4 focus:ring-jl-teal/10"
                            />
                        </div>
                        
                        <!-- Campo Contraseña -->
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fa-solid fa-lock text-gray-400 group-focus-within:text-jl-teal transition-colors duration-300"></i>
                            </div>
                            <input 
                                type="password" 
                                name="clave" 
                                id="password" 
                                required
                                placeholder="Contraseña"
                                autocomplete="current-password"
                                class="w-full pl-12 pr-12 py-4 bg-gray-50 border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 transition-all duration-300 focus:border-jl-teal focus:bg-white focus:ring-4 focus:ring-jl-teal/10"
                            />
                            <button 
                                type="button" 
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-jl-pink transition-colors duration-300"
                            >
                                <i class="fa-solid fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        
                        <!-- Botón de ingreso -->
                        <button 
                            type="submit" 
                            id="loginButton"
                            class="w-full py-4 mt-2 bg-gradient-to-r from-jl-pink to-jl-pink-dark text-white font-semibold rounded-xl shadow-lg shadow-jl-pink/25 hover:shadow-xl hover:shadow-jl-pink/35 hover:from-jl-pink-dark hover:to-jl-pink transform hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2"
                        >
                            <span id="btnText">
                                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                                Iniciar Sesión
                            </span>
                            <span id="btnLoading" class="hidden">
                                <div class="spinner"></div>
                            </span>
                        </button>
                    </form>
                    
                    <!-- Indicadores de seguridad -->
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <div class="flex items-center justify-center gap-4 text-xs text-gray-400">
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-shield-halved text-jl-teal"></i>
                                <span>Conexión segura</span>
                            </div>
                            <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                            <div class="flex items-center gap-1.5">
                                <i class="fa-solid fa-check-circle text-jl-teal"></i>
                                <span>SUNAT</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-4 text-center border-t border-gray-100">
                    <p class="text-xs text-gray-500">
                        &copy; <?php echo date('Y'); ?> <span class="font-semibold text-jl-pink">Botica J&L</span> - Todos los derechos reservados
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Desarrollado por <a href="#" class="text-jl-teal hover:text-jl-teal-dark transition-colors">Factosys Peru</a>
                    </p>
                </div>
            </div>
            
            <!-- Logo SUNAT debajo del card -->
            <div class="mt-6 text-center">
                <img src="assets/images/sunat.png" alt="SUNAT" class="h-10 mx-auto opacity-60 hover:opacity-80 transition-opacity">
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="public/js/jquery-3.1.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const eyeIcon = $('#eyeIcon');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
            
            // Prevenir doble envío y mostrar loading
            let formSubmitted = false;
            $('#loginForm').on('submit', function(e) {
                if (formSubmitted) {
                    e.preventDefault();
                    return false;
                }
                formSubmitted = true;
                
                $('#btnText').addClass('hidden');
                $('#btnLoading').removeClass('hidden');
                $('#loginButton').prop('disabled', true).addClass('opacity-75 cursor-not-allowed');
            });
            
            // Efecto visual en inputs cuando tienen valor
            $('#usuario, #password').on('input', function() {
                if ($(this).val().length > 0) {
                    $(this).addClass('border-jl-teal/50');
                } else {
                    $(this).removeClass('border-jl-teal/50');
                }
            });
        });
    </script>
</body>

</html>
