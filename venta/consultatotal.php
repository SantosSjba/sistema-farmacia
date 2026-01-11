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

		$data=$obj->consultar("SELECT ROUND(SUM(valor_total)+	$igv,2) as total FROM carrito  WHERE session_id='$usu'");
						foreach((array)$data as $row){
								$total=$row['total'];
					}
?>
<h1 align="center">
<?php
if($total==null){
	echo "S/ 0.00";
}else{
	//$o= round($total);
	//echo sprintf("%2.2f",$o);
	echo "$total";
}
?>
</h1>
