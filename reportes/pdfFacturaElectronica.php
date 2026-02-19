<?php
define('FPDF_FONTPATH','font/');
require_once('fpdf/fpdf.php');
require_once("qr/phpqrcode/qrlib.php");
include_once("../conexion/clsConexion.php");
include_once("../cantidad_en_letras.php");
$obj= new clsConexion();
if(!empty($_GET['idventa'])){
		$idventa= trim($obj->real_escape_string(htmlentities(strip_tags($_GET['idventa'],ENT_QUOTES))));

$data=$obj->consultar("SELECT * FROM configuracion WHERE idconfi='1'");
		    foreach((array)$data as $row){
				$logo=$row["logo"];
				$emisor=$row["ruc"];
				$sm=$row["simbolo_moneda"];
		}
$dataventa=$obj->consultar("SELECT cliente.nombres
     , cliente.direccion
     , cliente.nrodoc
     , tipo_documento.descripcion as descripciontipodocu
     , venta.idventa
		 , venta.igv
		 , venta.total
		 , venta.op_gravadas
			, venta.op_exoneradas
			, venta.op_inafectas
		 , venta.fecha_emision
     , tipo_comprobante.descripcion
     , serie.serie
     , serie.correlativo
FROM
  venta
INNER JOIN cliente
ON venta.idcliente = cliente.idcliente
INNER JOIN serie
ON venta.idserie = serie.idserie
INNER JOIN tipo_documento
ON cliente.id_tipo_docu = tipo_documento.idtipo_docu
INNER JOIN tipo_comprobante
ON venta.tipocomp = tipo_comprobante.codigo
	WHERE idventa='$idventa'");
				    foreach((array)$dataventa as $row){
						$razon_social=$row["nombres"];
						$direccion=$row["direccion"];
						$nrodoc=$row["nrodoc"];
						$descripciontipodocu=$row["descripciontipodocu"];
						$descripcion=$row["descripcion"];
						$serie=$row["serie"];
						$correlativo=$row["correlativo"];
						$igv = $row['igv'];
						$total = $row['total'];
						$op_gravadas = $row['op_gravadas'];
						$op_exoneradas = $row['op_exoneradas'];
						$op_inafectas = $row['op_inafectas'];
						$fecha = $row['fecha_emision'];
				}
	}
$pdf = new FPDF();
$pdf->AddPage('P','A4');
//$pdf->AddPage('P',array(80,200));
$pdf->SetFont('Arial','',12);

$pdf->SetFont('Arial','B',12);
$pdf->Image("../configuracion/foto/$logo",40,2,25,25);

$pdf->Cell(100);
$pdf->Cell(80,6,$emisor,'LRT',1,'C',0);

$pdf->Cell(100);
$pdf->Cell(80,6,$descripcion." ELECTRONICA",'LR',1,'C',0);

$pdf->Cell(100);
$pdf->Cell(80,6,$serie." - ".$correlativo,'BLR',0,'C',0);

$pdf->SetAutoPageBreak('auto',2);

$pdf->SetDisplayMode(75);

$pdf->Ln();

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,6,"CLIENTE:",0,0,'L',0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,$razon_social,0,1,'L',0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,6,"DIRECCION:",0,0,'L',0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,$direccion,0,1,'L',0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,6,$descripciontipodocu,0,0,'L',0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,$nrodoc,0,1,'L',0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,6,"FECHA DE EMISION:",0,0,'L',0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,$fecha,0,1,'L',0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,6,utf8_decode("TIPO DE TRANSACCIÓN:"),0,0,'L',0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,'CONTADO',0,1,'L',0);

$pdf->Ln(3);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,6,"ITEM",1,0,'C',0);
$pdf->Cell(20,6,"CANTIDAD",1,0,'C',0);
$pdf->Cell(100,6,"PRODUCTO",1,0,'C',0);
$pdf->Cell(20,6,"P.U.",1,0,'C',0);
$pdf->Cell(25,6,"SUBTOTAL",1,1,'C',0);

$pdf->SetFont('Arial','',8);

$datadet=$obj->consultar("SELECT detalleventa.item
     , detalleventa.cantidad
     , productos.descripcion
     , detalleventa.precio_unitario
     , detalleventa.valor_unitario
     , detalleventa.valor_total
		 , detalleventa.importe_total
     , detalleventa.idventa
FROM
  detalleventa
INNER JOIN productos
ON detalleventa.idproducto = productos.idproducto
WHERE idventa='$idventa'");
		    foreach((array)$datadet as $fila){
					$pu = isset($fila['precio_unitario']) ? number_format((float)$fila['precio_unitario'], 2, '.', '') : $fila['valor_unitario'];
					$pdf->Cell(10,6,$fila['item'],1,0,'C',0);
					$pdf->Cell(20,6,$fila['cantidad'],1,0,'C',0);
					$pdf->Cell(100,6,$fila['descripcion'],1,0,'L',0);
					$pdf->Cell(20,6,$pu,1,0,'C',0);
					$pdf->Cell(25,6,$fila['importe_total'],1,1,'C',0);
	}

$pdf->Cell(150,6,"OP. GRAVADAS",'',0,'R',0);
$pdf->Cell(25,6,$op_gravadas,1,1,'C',0);
$pdf->Cell(150,6,"IGV (18%)",'',0,'R',0);
$pdf->Cell(25,6,$igv,1,1,'C',0);
$pdf->Cell(150,6,"OP. EXONERADAS",'',0,'R',0);
$pdf->Cell(25,6,$op_exoneradas,1,1,'C',0);
$pdf->Cell(150,6,"OP. INAFECTAS",'',0,'R',0);
$pdf->Cell(25,6,$op_inafectas,1,1,'C',0);
$pdf->Cell(150,6,"IMPORTE TOTAL",'0',0,'R',0);
$pdf->Cell(25,6,$sm.' '.$total,1,1,'C',0);

$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,"SON:".' '.CantidadEnLetra($total),0,1,'L',0);
//codigo qr
		/*RUC | TIPO DE DOCUMENTO | SERIE | NUMERO | MTO TOTAL IGV | MTO TOTAL DEL COMPROBANTE | FECHA DE EMISION |TIPO DE DOCUMENTO ADQUIRENTE | NUMERO DE DOCUMENTO ADQUIRENTE |*/

$ruc = $emisor;
$tipo_documento = $descripcion; //factura
$tipodoccliente = $descripciontipodocu;
$nro_doc_cliente = $nrodoc;

$nombrexml = $ruc."-".$tipo_documento."-".$serie."-".$correlativo;

$text_qr = $ruc." | ".$tipo_documento." | ".$serie." | ".$correlativo." | ".$igv." | ".$total." | ".$fecha." | ".$tipodoccliente." | ".$nro_doc_cliente;
$ruta_qr = $nombrexml.'.png';

QRcode::png($text_qr, $ruta_qr, 'Q',15, 0);

$pdf->Image($ruta_qr, 92 , $pdf->GetY(),25,25);

$pdf->Ln(30);
$pdf->Cell(160,6,utf8_decode("Representacion impresa de la Boleta/Factura de venta Electronica"),0,0,'C',0);

$pdf->Output('I',$nombrexml.'.pdf');
//$pdf->Output('D',$nombrexml.'.pdf');
?>
