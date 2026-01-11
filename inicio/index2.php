<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
date_default_timezone_set('america/lima');
$dia= date("Y-m-d");
$usur=$obj->consultar("SELECT razon_social FROM configuracion");
              foreach($usur as $row){
              $direccion=$row['razon_social'];
              }
			  $m='';
              $resultcaja=$obj->consultar("SELECT * FROM caja_apertura WHERE usuario='$usu' and fecha='$dia'");
                            foreach((array)$resultcaja as $row){
                            $m=$row['monto'];
                            }
?>
<!DOCTYPE html>
<html lang="en">
<body class="page-body  page-fade">
<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	<div class="main-content">
<div class="row">
	<div class="col-sm-12">
    <div class="well">
			<h1><?php $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
echo $dias[date('w')]." ".date('d')." de ".$meses[date('n')-1]. " del ".date('Y');?></h1>
			<h3>Bienvenido:::....<strong><?php echo "$usu";?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        razon social:::::.....<strong><?php echo "$direccion";?></strong></h3>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
<div class="col-sm-3">
	<div class="tile-stats tile-aqua">
				<div class="icon"><i class="entypo-ticket"></i></div>
				<div class="num" data-start="0" data-end="$" data-postfix="" data-duration="1400" data-delay="0"> &nbsp;</div>
				<h3>CAJA</h3>
				<p><?php echo "Apertura caja:$m"; ?></a></p>
	</div>
  </div>
    <div class="col-sm-3">
      <div class="tile-stats tile-cyan">
			<div class="icon"><i class="entypo-user"></i></div>
			<div class="num" data-start="0" data-end="vc" data-postfix="" data-duration="" data-delay="0">&nbsp;</div>
			<h3>CLIENTES</h3>
			<p><a href="../cliente/index.php">ir a clientes</a></p>
		</div>
    </div>
</div>
  </div>

<div class="row">
	<div class="col-sm-12">
<br/>
<br/>
<br/>
<footer class="main" align="center">
	&copy; <?php echo date('Y'); ?> <strong>Derechos Reservados</strong> De <a href="#"  target="_blank">farmacia</a>
</footer>
</div>
 </div>
</body>
</html>
<?php include("../central/pieproducto.php");?>
