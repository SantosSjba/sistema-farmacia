<?php
include("../seguridad.php");
ob_start();
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
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

		$data=$obj->consultar("SELECT COALESCE(SUM(importe_total), 0) as total FROM carrito WHERE session_id='$usu'");
						foreach((array)$data as $row){
								$total=$row['total'];
					}
		$total = $total !== null ? round((float)$total, 2) : 0;
		$igv = $igv !== null ? round((float)$igv, 2) : 0;
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
