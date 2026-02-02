<?php
$tipo = $_SESSION["tipo"];
$usu = $_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
$dia= date("Y-m-d");
$caja_estado='';
$caja_fecha='';

// Primero verificar si hay una caja ABIERTA de cualquier día (incluyendo días anteriores)
$result_abierta=$obj->consultar("SELECT * FROM caja_apertura WHERE usuario= '$usu' AND estado='Abierto' ORDER BY fecha DESC, idcaja_a DESC LIMIT 1");
foreach ((array)$result_abierta as $row) {
	$caja_estado=$row['estado'];
	$caja_fecha=$row['fecha'];
}

// Si no hay caja abierta, verificar el estado de la caja del día actual
if($caja_estado == '') {
	$result=$obj->consultar("SELECT * FROM caja_apertura WHERE usuario= '$usu' AND fecha= '$dia' ORDER BY idcaja_a DESC LIMIT 1");
	foreach ((array)$result as $row) {
		$caja_estado=$row['estado'];
		$caja_fecha=$row['fecha'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Botica J&L - Sistema de Farmacia" />
	<meta name="author" content="" />
	<title>Botica J&L</title>
	<link rel="shortcut icon" href="../assets/images/logojl.png" />
	<style>
		/* Variables de colores del tema */
		:root {
			--color-jl-pink: #E91E8C;
			--color-jl-pink-dark: #C4177A;
			--color-jl-pink-light: #F54BA8;
			--color-jl-teal: #2EB8A6;
			--color-jl-teal-dark: #1F9A8A;
			--color-jl-teal-light: #4FCBB9;
		}
	</style>
	<link rel="stylesheet" href="../assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="../assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="../assets/css/bootstrap.css">
	<link rel="stylesheet" href="../assets/css/neon-core.css">
	<link rel="stylesheet" href="../assets/css/neon-theme.css">
	<link rel="stylesheet" href="../assets/css/neon-forms.css">
	<link rel="stylesheet" href="../assets/css/custom.css">
	<link rel="stylesheet" href="../assets/css/skins/white.css">
	<link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
	<link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
	<link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />
</head>

<body class="page-body skin-white loaded">
	<div class="page-container">
		<div class="sidebar-menu">
			<header class="logo-env">
				<!-- logo -->
				<div class="logo"><a href="#"><img src="../assets/images/logojl.png" width="120" alt="Botica J&L" /></a></div>
				<div class="sidebar-collapse"><a href="#"
						class="sidebar-collapse-icon with-animation"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i></a></div>
				<div class="sidebar-mobile-menu visible-xs"><a href="#"
						class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i></a></div>
			</header>
			<ul id="main-menu">
				<?php
				if ($tipo == "ADMINISTRADOR") {
					echo '	<li class="active">
					<a href="../inicio/index.php" ><i class="entypo-monitor"></i><span>Inicio</span></a>
					</li>';
				}
				?>
				<?php
				if ($tipo == "USUARIO") {
					echo '	<li class="active">
					 <a href="../inicio/index2.php" ><i class="entypo-monitor"></i><span>Inicio</span></a>
					 </li>';
				}
				?>
				<li>
					<a href="../consulta/index.php"><i class="entypo-search"></i><span>Consultas</span></a>
				</li>
				<?php
				if ($tipo == "ADMINISTRADOR") {
					echo '<li>
				<a href=""><i class="entypo-doc-text"></i><span>Mantenimiento</span></a>
				<ul>
					<li><a href="../cliente/index.php"><span>Cliente Laboratorio</span></a></li>
					<li><a href="../producto/index.php" ><span>Producto</span></a></li>
					 <li><a href="../categoria/index.php" ><span>Forma Farmaceutica</span></a></li>
					<li><a href="../presentacion/index.php"><span>Presentacion</span></a></li>
					<li><a href="../usuario/index.php"><span>Usuario</span></a></li>
					<li><a href="../sintomas/index.php"><span>Sintomas</span></a></li>
          			<li><a href="../lote/index.php"><span>lote</span></a></li>
				</ul>
				</li>';
				}
				?>
				<?php
				if ($tipo == "USUARIO") {
					echo '<li>
        		<a href="../cliente/index.php"><i class="entypo-user"></i><span>Clientes</span></a>
        </li>';
				}
				?>

<?php
			if ($tipo=="ADMINISTRADOR" && $caja_estado=="Abierto" || $tipo=="USUARIO" && $caja_estado=="Abierto") {
				echo '<li>
				<a href=""><i class="entypo-ticket"></i><span>Ventas</span></a>
					<ul>
						<li><a href="../venta/index.php"><span>Ventas</span></a></li>
						<li><a href="../venta/consultaventas.php"><span>Consulta Ventas</span></a></li>
						<li><a href="../venta/consultatickets.php"><span>Consulta Tickets</span></a></li>
						<li><a href="../notacredito/index.php"><span>Nota de Credito</span></a></li>
					</ul>
				</li>';
			}
		?>
        <li>
         <a href=""><i class="entypo-box"></i><span>Caja</span></a>
           <ul>
           <?php
         // Permitir aperturar caja cuando no hay caja abierta (incluye después de cerrar = permitir más de una apertura por turno)
         if (($tipo=="ADMINISTRADOR" || $tipo=="USUARIO") && $caja_estado!="Abierto") {
           echo '
          <li><a href="../caja/apertura.php"><span>Apertura caja</span></a></li>';
         }?>
            <?php
          if ($tipo=="ADMINISTRADOR" && $caja_estado=="Abierto" || $tipo=="USUARIO" && $caja_estado=="Abierto") {
            echo ' <li><a href="../caja/cierre.php"><span>Cierre de caja</span></a></li>';
           }?>
           <?php
         if ($tipo=="ADMINISTRADOR" && $caja_estado=="Abierto" || $tipo=="USUARIO" && $caja_estado=="Abierto") {
           echo ' <li><a href="../caja/movimiento.php"><span>Seguimiento de caja</span></a></li>';
          }?>
          <?php
        if ($tipo=="ADMINISTRADOR" && $caja_estado=="Cerrado" || $tipo=="USUARIO" && $caja_estado=="Cerrado") {
          echo ' <li><a href="../caja/movimiento.php"><span>Seguimiento de caja</span></a></li>';
         }?>
           </ul>
         </li>


				<?php
				if ($tipo == "ADMINISTRADOR") {
					echo '<li>
       <a href=""><i class="entypo-pencil"></i><span>Compras</span></a>
         <ul>
           <li><a href="../compras/index.php"><span>Compras</span></a></li>
           <li><a href="../compras/consultacompras.php"><span>Consulta Compras</span></a></li>
         </ul>
       </li>';
				}
				?>
				<?php
				if ($tipo == "ADMINISTRADOR") {
					echo '<li>
			<a href=""><i class="entypo-chart-bar"></i><span>Reportes</span></a>
      <ul>
				<li><a href="../reportes/rptrango1venta.php"><span>Rpt.Ventas</span></a></li>
        	<li><a href="../reportes/rptventadia.php"><span>Rpt.Ventas Del Dia</span></a></li>
				<li><a href="../reportes/rptrango1compra.php"><span>Rpt.Compras</span></a></li>
        <li><a href="../reportes/rptcompradia.php"><span>Rpt.Compras Del Dia</span></a></li>
			</ul>
			</li>';
				}
				?>
				<?php
				if ($tipo == "ADMINISTRADOR") {
					echo '<li>
          <a href="../backup/index.php"><i class="entypo-database"></i><span>Backup</span></a>
          </li>';
				}
				?>
				<?php
				if ($tipo == "ADMINISTRADOR") {
					echo '<li>
					<a href="../configuracion/configuracion.php"><i class="entypo-tools"></i><span>Configuracion</span></a>
					</li>
          ';
				}
				?>
				<?php
				if ($tipo == "ADMINISTRADOR") {
					echo '<li>
            <a href="../acerca/acerca.php"><i class="entypo-info"></i><span>Acerca de</span></a>
          </li>';
				}
				?>
				<li>
					<a href="../cerrar.php"><i class="entypo-logout"></i><span>Cerrar Sesion</span></a>
				</li>
			</ul>
		</div>
	</div>
	<!-- Profile Info and Notifications -->
	<!-- Bottom Scripts -->
	<!-- las notas de credito sirven para anular una boleta -->
</body>
</html>