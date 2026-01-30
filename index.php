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
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* Variables de colores */
        :root {
            --color-jl-pink: #E91E8C;
            --color-jl-pink-dark: #C4177A;
            --color-jl-pink-light: #F54BA8;
            --color-jl-teal: #2EB8A6;
            --color-jl-teal-dark: #1F9A8A;
            --color-jl-teal-light: #4FCBB9;
        }
        
        /* Reset y base */
        *, *::before, *::after {
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        
        /* Animaciones */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        
        /* Layout */
        .min-h-screen { min-height: 100vh; }
        .flex { display: flex; }
        .inline-block { display: inline-block; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .text-center { text-align: center; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .fixed { position: fixed; }
        .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
        .inset-y-0 { top: 0; bottom: 0; }
        .overflow-hidden { overflow: hidden; }
        .pointer-events-none { pointer-events: none; }
        .z-10 { z-index: 10; }
        
        /* Sizing */
        .w-full { width: 100%; }
        .max-w-md { max-width: 28rem; }
        .w-80 { width: 20rem; }
        .h-80 { height: 20rem; }
        .w-96 { width: 24rem; }
        .h-96 { height: 24rem; }
        .w-24 { width: 6rem; }
        .h-24 { height: 6rem; }
        .w-1 { width: 0.25rem; }
        .h-1 { height: 0.25rem; }
        .h-10 { height: 2.5rem; }
        
        /* Spacing */
        .p-6 { padding: 1.5rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        .py-10 { padding-top: 2.5rem; padding-bottom: 2.5rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .pl-4 { padding-left: 1rem; }
        .pl-12 { padding-left: 3rem; }
        .pr-4 { padding-right: 1rem; }
        .pr-12 { padding-right: 3rem; }
        .pt-6 { padding-top: 1.5rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-6 { margin-top: 1.5rem; }
        .mt-8 { margin-top: 2rem; }
        .mr-2 { margin-right: 0.5rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .gap-1\.5 { gap: 0.375rem; }
        .gap-2 { gap: 0.5rem; }
        .gap-4 { gap: 1rem; }
        .space-y-5 > * + * { margin-top: 1.25rem; }
        
        /* Positioning */
        .-top-40 { top: -10rem; }
        .-right-40 { right: -10rem; }
        .-bottom-40 { bottom: -10rem; }
        .-left-40 { left: -10rem; }
        .left-0 { left: 0; }
        .right-0 { right: 0; }
        
        /* Typography */
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .font-bold { font-weight: 700; }
        .font-semibold { font-weight: 600; }
        .text-white { color: #ffffff; }
        .text-gray-400 { color: #9ca3af; }
        .text-gray-500 { color: #6b7280; }
        .text-gray-700 { color: #374151; }
        .text-gray-800 { color: #1f2937; }
        .text-jl-pink { color: var(--color-jl-pink); }
        .text-jl-teal { color: var(--color-jl-teal); }
        
        /* Backgrounds */
        .bg-white { background-color: #ffffff; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-gray-300 { background-color: #d1d5db; }
        .bg-gradient-to-br {
            background: linear-gradient(to bottom right, #f3f4f6, #f9fafb, #e5e7eb);
        }
        .bg-jl-pink\/5 { background-color: rgba(233, 30, 140, 0.05); }
        .bg-jl-teal\/5 { background-color: rgba(46, 184, 166, 0.05); }
        
        /* Borders */
        .border-t { border-top: 1px solid; }
        .border-2 { border-width: 2px; }
        .border-gray-100 { border-color: #f3f4f6; }
        .border-gray-200 { border-color: #e5e7eb; }
        .rounded-full { border-radius: 9999px; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-\[24px\] { border-radius: 24px; }
        
        /* Shadows & Effects */
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1); }
        .shadow-\[0_20px_50px_rgba\(0\2c 0\2c 0\2c 0\.12\)\] { box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12); }
        .shadow-jl-pink\/25 { box-shadow: 0 10px 15px -3px rgba(233, 30, 140, 0.25); }
        .drop-shadow-md { filter: drop-shadow(0 4px 3px rgba(0, 0, 0, 0.07)) drop-shadow(0 2px 2px rgba(0, 0, 0, 0.06)); }
        .blur-3xl { filter: blur(64px); }
        .object-contain { object-fit: contain; }
        .opacity-60 { opacity: 0.6; }
        .opacity-75 { opacity: 0.75; }
        
        /* Placeholder */
        .placeholder-gray-400::placeholder { color: #9ca3af; }
        
        /* Transitions */
        .transition-colors { transition-property: color, background-color, border-color; transition-duration: 150ms; }
        .transition-all { transition-property: all; transition-duration: 150ms; }
        .transition-opacity { transition-property: opacity; transition-duration: 150ms; }
        .duration-300 { transition-duration: 300ms; }
        
        /* Focus styles */
        input:focus { outline: none; }
        
        .focus\:border-jl-teal:focus { border-color: var(--color-jl-teal); }
        .focus\:bg-white:focus { background-color: #ffffff; }
        .focus\:ring-4:focus { box-shadow: 0 0 0 4px rgba(46, 184, 166, 0.1); }
        .focus\:ring-jl-teal\/10:focus { box-shadow: 0 0 0 4px rgba(46, 184, 166, 0.1); }
        
        /* Group focus-within */
        .group:focus-within .group-focus-within\:text-jl-teal { color: var(--color-jl-teal); }
        
        /* Hover states */
        .hover\:text-jl-pink:hover { color: var(--color-jl-pink); }
        .hover\:text-jl-teal-dark:hover { color: var(--color-jl-teal-dark); }
        .hover\:opacity-80:hover { opacity: 0.8; }
        .hover\:shadow-xl:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1); }
        .hover\:shadow-jl-pink\/35:hover { box-shadow: 0 20px 25px -5px rgba(233, 30, 140, 0.35); }
        .hover\:-translate-y-0\.5:hover { transform: translateY(-0.125rem); }
        
        /* Button gradient */
        .bg-gradient-to-r {
            background: linear-gradient(to right, var(--color-jl-pink), var(--color-jl-pink-dark));
        }
        .hover\:from-jl-pink-dark:hover {
            background: linear-gradient(to right, var(--color-jl-pink-dark), var(--color-jl-pink));
        }
        
        /* Utilities */
        .hidden { display: none; }
        .cursor-not-allowed { cursor: not-allowed; }
        
        /* Responsive */
        @media (min-width: 640px) {
            .sm\:px-10 { padding-left: 2.5rem; padding-right: 2.5rem; }
            .sm\:py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        }
        
        /* Visible xs (Bootstrap compatibility) */
        @media (max-width: 767px) {
            .visible-xs { display: block !important; }
        }
        @media (min-width: 768px) {
            .visible-xs { display: none !important; }
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
