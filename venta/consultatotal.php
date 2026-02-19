<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
include_once("../redondeo_venta.php");
$obj=new clsConexion;
$total=0;
$igv=0;
$data=$obj->consultar("SELECT impuesto FROM configuracion");
		foreach((array)$data as $row){
			$impuesto=$row['impuesto'];
		}

		$data=$obj->consultar("SELECT ROUND(SUM(valor_total)*$impuesto/100 ,2) as igv FROM carrito WHERE operacion='OP. GRAVADAS' AND session_id='$usu'");
				foreach((array)$data as $row){
					if($row['igv']==null){
						$igv=0;
						}else{
						$igv=$row['igv'];
					}
				}

		$data=$obj->consultar("SELECT (SUM(valor_total)+$igv) as total FROM carrito WHERE session_id='$usu'");
						foreach((array)$data as $row){
								$total=$row['total'];
					}
		$total = $total !== null ? redondear_abajo_10centimos($total) : 0;
		$igv = $igv !== null ? redondear_abajo_10centimos($igv) : 0;
?>
<h1 align="center">
<?php
if ((float)$total == 0) {
	echo "S/ 0.00";
} else {
	echo number_format((float)$total, 2, '.', '');
}
?>
</h1>
