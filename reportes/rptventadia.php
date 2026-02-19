<?php ob_start();
include("../seguridad.php");
$usu=$_SESSION["usuario"];
$tipo=$_SESSION["tipo"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;
date_default_timezone_set('america/lima');
$fecha_actual = isset($_GET['fecha']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', trim($_GET['fecha'])) ? trim($_GET['fecha']) : date("Y-m-d");
$totalv = 0;
$cond_usuario = '';
if ($tipo == 'USUARIO') {
    $usur = $obj->consultar("SELECT idusu FROM usuario WHERE usuario='" . $obj->real_escape_string($usu) . "'");
    if ($usur && count($usur) > 0) {
        $idusuario = (int)$usur[0]['idusu'];
        $cond_usuario = " AND v.idusuario=$idusuario";
    }
}
$result=$obj->consultar("SELECT v.idventa, v.fecha_emision, v.total, dv.item, dv.cantidad, dv.precio_unitario, dv.valor_unitario, dv.importe_total, p.descripcion as producto
FROM venta v
INNER JOIN detalleventa dv ON v.idventa = dv.idventa
INNER JOIN productos p ON dv.idproducto = p.idproducto
WHERE v.fecha_emision='$fecha_actual' $cond_usuario AND v.estado != 'anulado'
ORDER BY v.idventa, dv.item");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>lista de Ventas</title>

<style type="text/css">
body { max-width: 100%; }
table.rpt-tabla { width: 100%; max-width: 100%; table-layout: fixed; font-size: 11px; }
table.rpt-tabla th, table.rpt-tabla td { overflow: hidden; text-overflow: ellipsis; word-wrap: break-word; }
#n { text-align: center; font-weight: bold; font-size: 24px; }
</style>
</head>

<body class="n" style="max-width: 100%;">
<table width="100%" border="1" align="center" cellspacing="0">
  <tr>
    <td bgcolor="#66CCCC" id="n">LISTADO DE VENTAS</td>
  </tr>
    <tr>
            <td bgcolor="#66CCCC" align="center"><?php echo "$fecha_actual"; ?></td>
        </tr>
</table>
<p>&nbsp;</p>
<table class="rpt-tabla" width="100%" border="1" align="center" cellspacing="0">
  <tr id="l">
     <th width="12%" bgcolor="#66CCCC" scope="col">Fecha</th>
     <th width="38%" bgcolor="#66CCCC" scope="col">Producto</th>
     <th width="8%" bgcolor="#66CCCC" scope="col">Cant.</th>
     <th width="10%" bgcolor="#66CCCC" scope="col">P.Unit</th>
     <th width="12%" bgcolor="#66CCCC" scope="col">Subtotal</th>
     <th width="12%" bgcolor="#66CCCC" scope="col">Total Venta</th>
   </tr>
   <?php 
   $idventa_ant = 0;
   foreach((array) $result as $row){
     	$totalv = $totalv + $row['importe_total'];
     	$totalventa_td = ($idventa_ant != $row['idventa']) ? number_format($row['total'], 2) : '';
     	if ($idventa_ant != $row['idventa']) $idventa_ant = $row['idventa'];
     ?>
   <tr>
     <td><?php echo $row['fecha_emision']; ?></td>
     <td><?php echo htmlspecialchars($row['producto']); ?></td>
     <td><?php echo $row['cantidad']; ?></td>
     <td><?php echo number_format(isset($row['precio_unitario']) ? (float)$row['precio_unitario'] : $row['valor_unitario'], 2); ?></td>
     <td><?php echo number_format($row['importe_total'], 2); ?></td>
     <td><?php echo $totalventa_td; ?></td>
   </tr>
  <?php };?>
 </table>

 <p align="right"><?php echo "Total Ventas:$totalv" ?></p>
</body>
</html>
<?php
require_once("dompdf/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new DOMPDF();
$dompdf->load_html(ob_get_clean());
$dompdf->render();
$pdf=$dompdf->output();
$filename = 'rptventasdia.pdf';
file_put_contents($filename, $pdf);
$dompdf->stream($filename);
// $dompdf->stream($filename, array("Attachment" => 0));
?>
