<?php
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;

$data=$obj->consultar("SELECT razon_social FROM configuracion");
        		foreach((array)$data as $row){
        			$direccion=$row['razon_social'];
        		}
?>
<div class="row">
	<div class="col-md-6 col-sm-8 clearfix">
		<ul class="user-info pull-left pull-none-xsm">
			<li class="profile-info dropdown">
				<a href="#"><?php echo $usu;?><i class="entypo-user"></i>
				</a>
			</li>
		</ul>
	</div>
	<div class="col-md-6 col-sm-4 clearfix hidden-xs">
		<ul class="list-inline links-list pull-right">
			<li>
			<a href="#"><?php echo "Razon Social::........$direccion";?></a>
			</li>
		</ul>
	</div>
</div>
