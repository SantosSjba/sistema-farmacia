<?php
// include("../seguridad.php");
// ob_start();
//$idsucursal=$_SESSION["sucursal"];
require_once("qr/phpqrcode/qrlib.php");
include_once("../conexion/clsConexion.php");
include_once("../cantidad_en_letras.php");
//include("numerosaletras.php");
$obj = new clsConexion;
if (!empty($_GET['idventa'])) {
	$idventa = trim($obj->real_escape_string(htmlentities(strip_tags($_GET['idventa'], ENT_QUOTES))));
	//configuracion
	$data = $obj->consultar("SELECT * FROM configuracion WHERE idconfi='1'");
	foreach ((array) $data as $row) {
		$logo = $row["logo"];
		$emisor = $row["ruc"];
		$sm = $row["simbolo_moneda"];
		$nombreti = $row["nombre_comercial"];
	}
	$dataventa = $obj->consultar("SELECT cliente.nombres
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
					 , venta.efectivo
					 , venta.vuelto
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
	foreach ((array) $dataventa as $row) {
		$razon_social = $row["nombres"];
		$direccion = $row["direccion"];
		$nrodoc = $row["nrodoc"];
		$descripciontipodocu = $row["descripciontipodocu"];
		$descripcion = $row["descripcion"];
		$serie = $row["serie"];
		$correlativo = $row["correlativo"];
		$igv = $row['igv'];
		$total = $row['total'];
		$op_gravadas = $row['op_gravadas'];
		$op_exoneradas = $row['op_exoneradas'];
		$op_inafectas = $row['op_inafectas'];
		$fecha = $row['fecha_emision'];
		$efectivo = $row['efectivo'];
		$vuelto = $row['vuelto'];
	}
}
?>
<html>

<head>
	<meta charset="utf-8">
	<title><?php echo $serie . "-" . $correlativo . "-" . $fecha; ?></title>
	<!-- <script type='text/javascript'>
	window.onload=function(){
		self.print();
	}
</script>

<style media='print'>
input{display:none;}
</style> -->
	<style type="text/css">
		.zona_impresion {
			width: 400px;
			padding: 10px 5px 10px 5px;
			float: left;
			font-size: 12.5px;
		}

		center {
			text-align: center;
		}

		#negrita {
			font-weight: bold;
		}
	</style>
	<script>
		function imprimir() {
			/*   var Obj = document.getElementById("desaparece");
			  Obj.style.visibility = 'hidden';
			  window.print(); */
			var Obj = document.getElementById("desaparece");
			Obj.style.visibility = 'hidden';
			// Cambiar dinámicamente el título antes de imprimir
			document.title = "<?php echo $serie . "-" . $correlativo . "-" . $fecha; ?>";
			// Imprimir
			window.print();
			// Después de la impresión, restaurar el botón de impresión
			Obj.style.visibility = 'visible';
		}
		// function regresa()
		// {
		//    header("Location:index.php");
		// }
	</script>

</head>

<body>
	<div class="zona_impresion">
		<table border="0" class="zona_impresion">
			<tr>
				<td colspan="2" align="center"><img src="../configuracion/foto/<?php echo $logo ?>" width="210"
						height="50" /></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><?php echo "RUC:   $emisor"; ?></td>
			</tr>

			<tr>
				<td colspan="5">=======================================================</td>
			</tr>
			<tr>
				<td><b><?php echo "$descripcion  ELECTRONICA:"; ?></b></td>
				<td><b><?php echo $serie . " - " . $correlativo ?></b></td>
			</tr>
			<tr>
				<td width="268">CLIENTE</td>
				<td width="268"><?php echo "$razon_social" ?></td>
			</tr>
			<tr>
				<td width="268">DIRECCION</td>
				<td width="268"><?php echo "$direccion" ?></td>
			</tr>
			<tr>
				<td width="268"><?php echo "$descripciontipodocu"; ?></td>
				<td width="268"><?php echo "$nrodoc" ?></td>
			</tr>
			<tr>
				<td width="268"><?php echo "FECHA DE EMISION:"; ?></td>
				<td width="268"><?php echo "$fecha" ?></td>
			</tr>
			<tr>
				<td width="268"><?php echo "TIPO DE TRANSACCIÓN"; ?></td>
				<td width="268"><?php echo "CONTADO" ?></td>
			</tr>

		</table>
		<table border="0" width="300px" align="center" class="zona_impresion">
			<br>

			<tr>
				<td width="49"><b>ITEM</td>
				<td width="219"><b>CANTIDAD</td>
				<td width="49"><b>PRODUCTO</td>
				<td width="49"><b>P.U.</td>
				<td width="68" align="right"><b>SUBTOTAL</b></td>
			</tr>
			<tr>
				<td colspan="5">=======================================================</td>
			</tr>
			<?php
			$datadet = $obj->consultar("SELECT
  detalleventa.item,
  detalleventa.cantidad,
  productos.descripcion,
  detalleventa.valor_unitario,
  detalleventa.valor_total,
  detalleventa.importe_total,
  detalleventa.idventa,
  presentacion.presentacion
FROM detalleventa
  INNER JOIN productos
    ON detalleventa.idproducto = productos.idproducto
  INNER JOIN presentacion
    ON productos.idpresentacion = presentacion.idpresentacion
		WHERE idventa='$idventa'");
			foreach ((array) $datadet as $row) {
				?>
				<tr>
					<td><?php echo $row['item']; ?></td>
					<td><?php echo $row['cantidad']; ?></td>
					<td><?php echo $row['descripcion'] . '/' . $row['presentacion']; ?>
					<td><?php echo $row['valor_unitario']; ?>
					<td align='right'><?php echo $row['importe_total']; ?></td>
				</tr>
				<?php
			}
			;
			?>
			<tr>
				<td colspan="5">=======================================================</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right"><?php echo 'OP. GRAVADAS:'; ?></td>
				<td align="right"><?php echo $op_gravadas ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right"><?php echo 'IGV (18%):'; ?></td>
				<td align="right"><?php echo $igv ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right"><?php echo 'OP. EXONERADAS:'; ?></td>
				<td align="right"><?php echo $op_exoneradas ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right"><?php echo 'OP. INAFECTAS:'; ?></td>
				<td align="right"><?php echo $op_inafectas ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right"><?php echo 'IMPORTE TOTAL:'; ?></td>
				<td align="right"><?php echo $total ?></td>
			</tr>

			<tr>
				<td colspan="5">=======================================================</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right"><?php echo 'EFECTIVO:'; ?></td>
				<td align="right"><?php echo $efectivo; ?></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td colspan="3" align="right"><?php echo 'VUELTO:'; ?></td>
				<td align="right"><?php echo $vuelto; ?></td>
			</tr>
			<tr>
				<td colspan="5" align="left"><?php echo "SON:" . " " . CantidadEnLetra($total); ?></td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
			<?php
			$ruc = $emisor;
			$tipo_documento = $descripcion; //factura
			$tipodoccliente = $descripciontipodocu;
			$nro_doc_cliente = $nrodoc;

			$nombrexml = $ruc . "-" . $tipo_documento . "-" . $serie . "-" . $correlativo;

			$text_qr = $ruc . " | " . $tipo_documento . " | " . $serie . " | " . $correlativo . " | " . $igv . " | " . $total . " | " . $fecha . " | " . $tipodoccliente . " | " . $nro_doc_cliente;
			$ruta_qr = $nombrexml . '.png';
			QRcode::png($text_qr, $ruta_qr);
			?>
			<tr>
			<tr>
				<td colspan="3" align="center">
					<?php
					//$png = imagecreatefrompng(QRcode::png($ruta_qr));
					echo "<img src='$ruta_qr'>";
					?>
				</td>
			</tr>
			<td colspan="5" align="center">Representacion impresa de la Boleta/Factura de venta Electronica</td>
			</tr>
			<tr>
				<!-- <td colspan="3" align="left"><input type="button" onClick="location.href='../venta/index.php'" value="regresar"></td> -->
				<td colspan="3" align="center"><input type="button" id="desaparece" onClick="imprimir()"
						value="Imprimir"></td>
			</tr>

		</table>
	</div>
	<p><br>
	</p>
	<p>
</body>

</html>
<!-- falta poner editable el precio unitario
y evaluar el descuento en op gravadas , etc -->