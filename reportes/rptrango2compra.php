<?php
ob_start();
include("../seguridad.php");
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj=new clsConexion;

$totalv = 0;
if(strlen($_GET['desde'])>0 and strlen($_GET['hasta'])>0){
$desde = trim($obj->real_escape_string(htmlentities(strip_tags($_GET['desde'],ENT_QUOTES))));
$hasta =trim($obj->real_escape_string(htmlentities(strip_tags($_GET['hasta'],ENT_QUOTES))));

	$verDesde = date('d/m/Y', strtotime($desde));
	$verHasta = date('d/m/Y', strtotime($hasta));
}else{
	$desde = '1111-01-01';
	$hasta = '9999-12-30';

	$verDesde = '__/__/____';
	$verHasta = '__/__/____';
}

$result=$obj->consultar("select * from compra WHERE fecha BETWEEN '$desde' AND '$hasta' ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>lista de compras</title>

<style type="text/css">
ne {
	font-weight: bold;
}
ne {
	font-weight: bold;
}
ta {
	font-size: 16px;
}
#n {
	text-align: center;
	font-weight: bold;
	font-size: 24px;
	font-family: Georgia, "Times New Roman", Times, serif;
	color: #000;
}
.g {
	font-family: Georgia, "Times New Roman", Times, serif;
}
#l {
	font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
}
</style>
</head>

<body class="n">
<table width="280" height="65" border="1" align="center" cellspacing="0">
  <tr>
    <td width="241" bgcolor="#66CCCC" id="n">LISTADO DE COMPRAS</td>
  </tr>
    <tr>
          <td  bgcolor="#66CCCC" align="center"><?php echo 'Desde:'.$verDesde."   ".'hasta:'.$verHasta ?></td>
        </tr>
</table>
<p>&nbsp;</p>
<table width="541" border="1" align="center" cellspacing="0">
  <tr id="l">
     <th width="70" bgcolor="#66CCCC" scope="col">Tipo</th>
     <th width="80" bgcolor="#66CCCC" scope="col">Numero</th>
     <th width="66" bgcolor="#66CCCC" scope="col">Fecha</th>
     <th width="66" bgcolor="#66CCCC" scope="col">Costo Total</th>
   </tr>
   <?php foreach((array) $result as $row){
     	$totalv = $totalv + $row['total'];
     ?>
   <tr>
     <td><?php echo $row['docu']; ?></span></td>
	  <td><?php echo $row['num_docu'];?></span></td>
     <td><?php echo $row['fecha']; ?></span></td>
	   <td><?php echo $row['total']; ?></span></td>
   </tr>
  <?php };?>
 </table>

 <p align="right"><?php echo "Total compras:$totalv" ?></p>
</body>
</html>
<?php
require_once("dompdf/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new DOMPDF();
$dompdf->load_html(ob_get_clean());
$dompdf->render();
$pdf=$dompdf->output();
$filename = 'rptcompraporfecha.pdf';
file_put_contents($filename, $pdf);
//$dompdf->stream($filename);
$dompdf->stream($filename, array("Attachment" => 0));
?>
