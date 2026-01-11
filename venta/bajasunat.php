<?php
ini_set('log_errors', 1);
ini_set('error_log', 'php-error.log');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../xml.php");
require_once("../cantidad_en_letras.php");
require_once("../ApiFacturacion_enviar.php");
include("../seguridad.php");
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();
//inicio enviar  a la sunat
$objXml = new GeneradorXML();
$api = new ApiFacturacion();
$idventa = $obj->real_escape_string($_POST['idventa']);
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

			$j=$obj->consultar("SELECT
			venta.*,
			serie.correlativo
		  FROM venta
			INNER JOIN serie
			  ON venta.idserie = serie.idserie
			   WHERE venta.idventa='$idventa'");
					  foreach((array)$j as $row){
						  $corr=$row["correlativo"];
					  }

// codigos de afectacion
$detalle = array();
$it = 0;
$data = $obj->consultar("SELECT
detalleventa.*,
tipo_afectacion.codigo
FROM detalleventa
INNER JOIN productos
  ON detalleventa.idproducto = productos.idproducto
INNER JOIN tipo_afectacion
  ON productos.idtipoaf = tipo_afectacion.idtipoa
   WHERE detalleventa.idventa='$idventa'");

foreach ((array)$data as $row) {
	$it += 1;
	$ip = $row['idproducto'];
	$v_u = $row['valor_unitario'];
	$p_u = $row['precio_unitario'];
	$igv_d = $row['igv'];
	$v_t = $row['valor_total'];
	$imp = $row['importe_total'];
	$porcentaje = $row['porcentaje_igv'];

	if($row['codigo']=='10'){
		$afe_cod='01';
	}elseif($row['codigo']=='20'){
		$afe_cod='02';
	}else{
		$afe_cod='03';
	}

	$data_p=$obj->consultar("SELECT
	tipo_afectacion.codigo_afectacion,
	tipo_afectacion.nombre_afectacion,
	tipo_afectacion.tipo_afectacion,
	unidad.codigo AS unidad,
	productos.codigo,
	productos.idproducto,
	productos.tipo_precio,
	productos.descripcion,
	tipo_afectacion.codigo AS codigoalt,
	presentacion.presentacion,
	serie.correlativo
  FROM productos
	INNER JOIN tipo_afectacion
	  ON productos.idtipoaf = tipo_afectacion.idtipoa
	INNER JOIN unidad
	  ON productos.idunidad = unidad.iduni
	INNER JOIN presentacion
	  ON productos.idpresentacion = presentacion.idpresentacion
	INNER JOIN detalleventa
	  ON detalleventa.idproducto = productos.idproducto
	INNER JOIN venta
	  ON detalleventa.idventa = venta.idventa
	INNER JOIN serie
	  ON venta.idserie = serie.idserie
			   WHERE productos.idproducto='$ip'");
					  foreach((array)$data_p as $row){
									   $codafe=$row['codigo_afectacion'];
									   $nomafe=$row['nombre_afectacion'];
									   $tipofe=$row['tipo_afectacion'];
									   //$corr=$row['correlativo'];
					  }

	$itemx = array(
		'igv' => $igv_d,
		'valor_total' => $v_t,
		'importe_total' => $imp,

		'correlativo' => $corr,

		'codigo_afectacion' => $codafe,
		'nombre_afectacion' => $nomafe,
		'tipo_afectacion' => $tipofe,

		'afectacion_codigo'=>$afe_cod
	);
	$detalle[] = $itemx;
}



$cabecera = array(
	"tipodoc"		=>"RC",
	"serie"			=>date('Ymd'),
	"correlativo"	=>$corr,
	"fecha_emision" =>date('Y-m-d'),
	"fecha_envio"	=>date('Y-m-d')
);
//print_r($cabecera);

//RUC DEL EMISOR - TIPO DE COMPROBANTE - SERIE DEL DOCUMENTO - CORRELATIVO
//01-> FACTURA, 03-> BOLETA, 07-> NOTA DE CREDITO, 08-> NOTA DE DEBITO, 09->GUIA DE REMISION
			$rutaxml = "../xml/";
			$rutacdr = "../cdr/";
			$nombre = $emisor['ruc'].'-'.$cabecera['tipodoc'].'-'.$cabecera['serie'].'-'.$cabecera['correlativo'];
			$objXml->CrearXmlResumenDiario($emisor, $cabecera, $detalle,$rutaxml.$nombre);
			$ticket = $api->EnviarResumenComprobantes($emisor,$nombre,"../", $rutaxml, $rutacdr,$idventa);
			$api->ConsultarTicket($emisor, $cabecera, $ticket,"../", $rutaxml, $rutacdr);
			//FIN baja de documentos
?>
