<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
// $idsucursal=$_SESSION["sucursal"];
include_once("../central/centralproducto.php");
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
date_default_timezone_set('america/lima');
$dia= date("Y-m-d");
$m='';
$resultcaja=$obj->consultar("SELECT * FROM caja_apertura WHERE usuario='$usu' and fecha='$dia'");
              foreach((array)$resultcaja as $row){
              $m=$row['monto'];
}
$usur=$obj->consultar("SELECT razon_social FROM configuracion");
              foreach($usur as $row){
              $direccion=$row['razon_social'];
              }
// productos por vender
              $resultf=$obj->consultar("SELECT productos.*,lote.fecha_vencimiento FROM productos INNER JOIN lote
              ON productos.idlote = lote.idlote where date_sub(fecha_vencimiento, interval 14 day) <= curdate()");
//productos con bajo stock menor a
              $result=$obj->consultar("SELECT productos.*, lote.fecha_vencimiento FROM productos INNER JOIN lote
              ON productos.idlote = lote.idlote WHERE stock<='5'");
              $item = array();
              $index = 1;
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
        Razon Social:::::.....<strong><?php echo "$direccion";?></strong></h3>
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
    <div class="tile-stats tile-neon-red">
			<div class="icon"><i class="entypo-brush"></i></div>
			<div class="num" data-start="0" data-end="$" data-postfix="" data-duration="1400" data-delay="0">&nbsp;</div>
			<h3>COMPRAS</h3>
			<p><a href="../compras/index.php">ir a compras</a></p>
		</div>
    </div>

    <div class="col-sm-3">
      <div class="tile-stats tile-blue">
			<div class="icon"><i class="entypo-user"></i></div>
			<div class="num" data-start="0" data-end="vc" data-postfix="" data-duration="" data-delay="0">&nbsp;</div>
			<h3>CLIENTES</h3>
			<p><a href="../cliente/index.php">ir a clientes</a></p>
		</div>
    </div>

    <div class="col-sm-3">
      <div class="tile-stats tile-orange">
      <div class="icon"><i class="entypo-box"></i></div>
      <div class="num" data-start="0" data-end="$" data-postfix="" data-duration="1400" data-delay="0">&nbsp;</div>
      <h3>PRODUCTOS</h3>
      <p><a href="../producto/index.php">ir a productos</a></p>
    </div>
    </div>
</div>
  </div>

<div class="row">
	<div class="col-sm-12">
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Lista de Productos Por vencer en (14 dias)o vencidos</div>

						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
          <table class="table table-bordered datatable" id="table-1">
                  <thead>
          						<tr class="well">
          						<th data-hide="phone"><a href="#">#</a></th>
          						<th><a href="#">Cod. De Barras</a></th>
          						<th><a href="#">Descripcion</a></th>
          						<th><a href="#">Fec. vencimiento</a></th>
          						<th data-hide="phone"><a href="#">P.venta</a></th>
          						<th data-hide="phone"><a href="#">Estado</a></th>
          					  </tr>
          		</thead>
          				<tbody>
          		<?php
          		foreach((array)$resultf as $row){
          				$item[$index] = $row;
          				//estado
          				if ($row['estado']=='1'){
          				 $estado="<span class='label label-success'>Activo</span>";
          				}else{
          				 $estado="<span class='label label-danger'>Inactivo</span>";
          				}
                  $fecha="label label-danger";
          			?>
          					<tr>
          					<td><?php echo $index++; ?></td>
          					<td><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                  	<td><span class="label-as-badge <?php echo $fecha;?>"><?php echo $row['fecha_vencimiento'];?></span></td>
          					<td><?php echo $row['precio_venta']; ?></td>
          				 <td><?php echo $estado;?></td>
          					</tr>
          			<?php
          			};
          		?>
          				</tbody>
          </table>
					<div class="panel-body">
						<center><span class="chart"></span></center>
					</div>
				</div>
			</div>
			<div class="col-sm-12">

				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="panel-title">Lista de productos Con bajo Stock</div>

						<div class="panel-options">
							<a href="#sample-modal" data-toggle="modal" data-target="#sample-modal-dialog-1" class="bg"><i class="entypo-cog"></i></a>
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
							<a href="#" data-rel="reload"><i class="entypo-arrows-ccw"></i></a>
							<a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
						</div>
					</div>
          <table class="table table-bordered datatable" id="table-1">
                  <thead>
          						<tr class="well">
          						<th data-hide="phone"><a href="#">#</a></th>
          						<th><a href="#">Cod. De Barras</a></th>
          						<th><a href="#">Descripcion</a></th>
          						<th><a href="#">Fec. vencimiento</a></th>
          						<th><a href="#">Stock</a></th>
          						<th data-hide="phone"><a href="#">P.venta</a></th>
          						<th data-hide="phone"><a href="#">Estado</a></th>
          					  </tr>
          		</thead>
          				<tbody>
          		<?php
          		foreach((array)$result as $row){
          				$item[$index] = $row;
          				if($row['stock']<=$row['stockminimo']) {
          				$color="label label-danger";
          				}else{
          				$color="label label-success";
          				}
          				//estado
          				if ($row['estado']=='1'){
          				 $estado="<span class='label label-success'>Activo</span>";
          				}else{
          				 $estado="<span class='label label-danger'>Inactivo</span>";
          				}
          			?>
          					<tr>
          					<td><?php echo $index++; ?></td>
          					<td><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
          					<td><?php echo $row['fecha_vencimiento']; ?></td>
          					<td><span class="label-as-badge <?php echo $color;?>"><?php echo $row['stock'];?></span></td>
          					<td><?php echo $row['precio_venta']; ?></td>
          				 <td><?php echo $estado;?></td>
          					</tr>
          			<?php
          			};
          		?>
          				</tbody>
          </table>
				</div>
			</div>
		</div>
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
