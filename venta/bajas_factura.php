<?php
require_once("../xml.php");
require_once("../cantidad_en_letras.php");
require_once("../ApiFacturacion.php");
include("../seguridad.php");
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
//inicio enviar  a la sunat
$objXml = new GeneradorXML();
$api = new ApiFacturacion();
$imps=$obj->consultar("SELECT * FROM configuracion WHERE idconfi='1'");
		foreach((array)$imps as $row){
			$ruc=$row["ruc"];
			$rz=$row["razon_social"];
			$nc=$row["nombre_comercial"];
			$dir=$row["direccion"];
			$dep=$row["departamento"];
			$pro=$row["provincia"];
			$dis=$row["distrito"];
			$ubi=$row["ubigeo"];
			$u_sol=$row["usuario_sol"];
			$c_sol=$row["clave_sol"];
			$mon=$row["simbolo_moneda"];
			$impuesto=$row["impuesto"];
		}
$emisor = 	array(
			'tipodoc'		=> '6',
			'ruc' 			=> $ruc,
			'razon_social'	=> $rz,
			'nombre_comercial'	=> $nc,
			'direccion'		=> $dir,
			'pais'			=> 'PE',
			'departamento'  => $dep,
			'provincia'		=> $pro,
			'distrito'		=> $dis,
			'ubigeo'		=> $ubi,
			'usuario_sol'	=> $u_sol, //USUARIO SECUNDARIO EMISOR ELECTRONICO
			'clave_sol'		=> $c_sol //CLAVE DE USUARIO SECUNDARIO EMISOR ELECTRONICO
			);

$cabecera = array(
						"tipodoc"		=>"RA",
						"serie"			=>date('Ymd'),
						"correlativo"	=>"1",
						"fecha_emision" =>date('Y-m-d'),
						"fecha_envio"	=>date('Y-m-d')
				);

$items = array();
$ids = $_POST['documento'];
if (empty($ids)) {
    //echo "No se proporcionaron IDs de documentos.";
    exit;
} else {
    //echo "IDs proporcionados: " . implode(", ", $ids);
}
$i=1;
				// $cant=500;
			foreach($ids as $v){
				$data3=$obj->consultar("SELECT venta.idventa
				 , serie.serie
				 , serie.correlativo
				FROM
				venta
				INNER JOIN serie
				ON venta.idserie = serie.idserie
				 WHERE venta.idventa='$v'");
				 foreach((array)$data3 as $row) {
				   // $serief= $row["serie"];
					$correlativof=	$row["correlativo"];
					}
					$items[] = array(
							"item"				=> $i,
							"tipodoc"			=> "01",
							"serie"				=> "F001",
							"correlativo"	=> $correlativof,
							"motivo"			=> "ERROR EN DOCUMENTO"
						);
						$i++;
				}
//RUC DEL EMISOR - TIPO DE COMPROBANTE - SERIE DEL DOCUMENTO - CORRELATIVO
//01-> FACTURA, 03-> BOLETA, 07-> NOTA DE CREDITO, 08-> NOTA DE DEBITO, 09->GUIA DE REMISION
			$rutaxml = "../xml/";
			$rutacdr = "../cdr/";
			$nombre = $emisor['ruc'].'-'.$cabecera['tipodoc'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
			$objXml->CrearXmlBajaDocumentos($emisor, $cabecera, $items, $rutaxml.$nombre);
			$ticket = $api->EnviarResumenComprobantes($emisor,$nombre,"../", $rutaxml, $rutacdr,$ids);
			$api->ConsultarTicket($emisor, $cabecera, $ticket,"../", $rutaxml, $rutacdr);
			//FIN baja de documentos
?>
