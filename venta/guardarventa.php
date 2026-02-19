<?php
include("../seguridad.php");
$usu=$_SESSION["usuario"];
include_once("../conexion/clsConexion.php");
$obj= new clsConexion();

// Sanitizar usuario de sesión
$usu_safe = $obj->real_escape_string($usu);

// Verificar que el carrito tenga productos
$data=$obj->consultar("SELECT * FROM carrito WHERE session_id='".$usu_safe."'");
$num = is_array($data) ? count($data) : 0;

// Sanitizar todas las entradas
$numope=$obj->real_escape_string(isset($_POST['numope']) ? $_POST['numope'] : '');
$forma=$obj->real_escape_string(isset($_POST['forma']) ? $_POST['forma'] : 'EFECTIVO');
$tico=$obj->real_escape_string(isset($_POST['tico']) ? $_POST['tico'] : '00');
$serie_p=$obj->real_escape_string(isset($_POST['serie']) ? $_POST['serie'] : 'T001');
$correlativo_p=intval(isset($_POST['correl']) ? $_POST['correl'] : 0);

// Verificar correlativo existente
$correlativo_i=0;
$datasee=$obj->consultar("SELECT idserie,serie,correlativo FROM serie WHERE tipocomp='".$tico."' ORDER BY idserie DESC LIMIT 1");
foreach((array)$datasee as $row){
    $correlativo_i=intval($row['correlativo']);
}

if($num == 0) {
    echo "No se pudo Registrar la venta. Agregue productos al carrito.";
}elseif ($correlativo_i == $correlativo_p) {
    echo "El comprobante ya se encuentra registrado, favor volver a intentarlo.";
}else{
	// Iniciar transacción para garantizar integridad de datos
	$obj->begin_transaction();
	
	try {
		// Obteniendo igv, operaciones gravadas, etc
		$op_gravadas = 0;
		$op_exoneradas = 0;
		$op_inafectas = 0;
		$igv = 0;
		$total = 0;
		$impuesto = 18;
		$mon = 'S/';
		$ruc = '';

		$imps=$obj->consultar("SELECT ruc,impuesto,simbolo_moneda FROM configuracion LIMIT 1");
		foreach((array)$imps as $row){
			$impuesto = floatval($row['impuesto']);
			$mon = $row['simbolo_moneda'];
			$ruc = $row['ruc'];
		}
		
		$data1=$obj->consultar("SELECT COALESCE(ROUND(SUM(valor_total),2), 0) as op_gravadas FROM carrito WHERE operacion='OP. GRAVADAS' AND session_id='".$usu_safe."'");
		foreach((array)$data1 as $row){
			$op_gravadas = floatval($row['op_gravadas']);
		}

		$data2=$obj->consultar("SELECT COALESCE(ROUND(SUM(valor_total),2), 0) as op_exoneradas FROM carrito WHERE operacion='OP. EXONERADAS' AND session_id='".$usu_safe."'");
		foreach((array)$data2 as $row){
			$op_exoneradas = floatval($row['op_exoneradas']);
		}

		$data3=$obj->consultar("SELECT COALESCE(ROUND(SUM(valor_total),2), 0) as valor_total FROM carrito WHERE operacion='OP. INAFECTAS' AND session_id='".$usu_safe."'");
		foreach((array)$data3 as $row){
			$op_inafectas = floatval($row['valor_total']);
		}

		$data4=$obj->consultar("SELECT COALESCE(ROUND(SUM(igv),2), 0) as igv FROM carrito WHERE operacion='OP. GRAVADAS' AND session_id='".$usu_safe."'");
		foreach((array)$data4 as $row){
			$igv = floatval($row['igv']);
		}
		
		$data5=$obj->consultar("SELECT COALESCE(ROUND(SUM(importe_total),2), 0) as total FROM carrito WHERE session_id='".$usu_safe."'");
		foreach((array)$data5 as $row){
			$total = floatval($row['total']);
		}
		$op_gravadas = round((float)$op_gravadas, 2);
		$op_exoneradas = round((float)$op_exoneradas, 2);
		$op_inafectas = round((float)$op_inafectas, 2);
		$igv = round((float)$igv, 2);
		$total = round((float)$total, 2);
		// Obtener el último id de venta de forma segura
		$idventa = 11; // Valor inicial por defecto
		$data_j=$obj->consultar("SELECT MAX(idventa) as idventa FROM venta FOR UPDATE");
		foreach((array)$data_j as $row){
			if($row['idventa'] !== null){
				$idventa = intval($row['idventa']) + 1;
			}
		}

		// Obtener el id del usuario
		$idusuario = 0;
		$data_l=$obj->consultar("SELECT idusu FROM usuario WHERE usuario='".$usu_safe."'");
		foreach((array)$data_l as $row){
			$idusuario = intval($row['idusu']);
		}
		
		// Validar usuario
		if ($idusuario == 0) {
			throw new Exception("Usuario no válido");
		}

		// Obtener datos del cliente
		$cliente_nd = $obj->real_escape_string(isset($_POST['numero']) ? $_POST['numero'] : '');
		$direccion = $obj->real_escape_string(isset($_POST['dir']) ? $_POST['dir'] : '');
		$td = intval(isset($_POST['td']) ? $_POST['td'] : 2);
		$rz = $obj->real_escape_string(isset($_POST['rz']) ? $_POST['rz'] : 'CLIENTE VARIOS');

		// Buscar si el cliente ya existe
		$idcliente = 0;
		$data_c=$obj->consultar("SELECT idcliente FROM cliente WHERE nrodoc='".$cliente_nd."'");
		foreach((array)$data_c as $row){
			$idcliente = intval($row['idcliente']);
		}
		
		// Si no existe el cliente, crearlo
		if ($idcliente == 0 && !empty($cliente_nd)) {
			$sql="INSERT INTO cliente (nombres, direccion, id_tipo_docu, nrodoc, tipo) VALUES ('".$rz."','".$direccion."','".$td."','".$cliente_nd."', 'cliente')";
			$obj->ejecutar($sql);
			$idcliente = $obj->insert_id();
		}
		
		// Validar cliente
		if ($idcliente == 0) {
			throw new Exception("Cliente no válido");
		}

		$fecha = $obj->real_escape_string(isset($_POST['fecha']) ? $_POST['fecha'] : date('Y-m-d'));
		
		// Obtener el último id de serie
		$idserie_s = 1;
		$data_s=$obj->consultar("SELECT MAX(idserie) as idserie FROM serie FOR UPDATE");
		foreach((array)$data_s as $row){
			if($row['idserie'] !== null){
				$idserie_s = intval($row['idserie']) + 1;
			}
		}

		// Sanitizar efectivo y vuelto
		$efectivo = floatval(isset($_POST['recibo']) ? $_POST['recibo'] : 0);
		$vuelto = floatval(isset($_POST['vuelto']) ? $_POST['vuelto'] : 0);

		// Insertar serie
		$sql_s="INSERT INTO serie (idserie, tipocomp, serie, correlativo) VALUES ('".$idserie_s."','".$tico."','".$serie_p."','".$correlativo_p."')";
		if (!$obj->ejecutar($sql_s)) {
			throw new Exception("Error al registrar serie");
		}

		// Generar nombre XML
		$nombrexml = ($tico == '00') ? 'NULL' : 'R-'.$ruc.'-'.$tico.'-'.$serie_p.'-'.$correlativo_p.'.XML';

		// Guardar venta
		$sql_v="INSERT INTO venta (idventa, idconf, tipocomp, idcliente, idusuario, idserie, fecha_emision, op_gravadas, op_exoneradas, op_inafectas, igv, total, feestado, fecodigoerror, femensajesunat, nombrexml, xmlbase64, cdrbase64, efectivo, vuelto, tire, estado, formadepago, numope)
				VALUES ('".$idventa."','1','".$tico."','".$idcliente."','".$idusuario."','".$idserie_s."','".$fecha."','".$op_gravadas."','".$op_exoneradas."','".$op_inafectas."','".$igv."','".$total."',null,null,null,'".$nombrexml."',null,null,'".$efectivo."','".$vuelto."','noenviado','no_enviado','".$forma."','".$numope."')";
		if (!$obj->ejecutar($sql_v)) {
			throw new Exception("Error al registrar venta");
		}

		// Guardar detalle de venta
		$it = 0;
		$data_carrito = $obj->consultar("SELECT * FROM carrito WHERE session_id='".$usu_safe."'");
		foreach((array)$data_carrito as $row){
			$it++;
			$cod = intval($row['idproducto']);
			$cant = floatval($row['cantidad']);
			$v_u = floatval($row['valor_unitario']);
			$p_u = floatval($row['precio_unitario']);
			$igv_d = floatval($row['igv']);
			$v_t = floatval($row['valor_total']);
			$imp = floatval($row['importe_total']);

			$sql_dv="INSERT INTO detalleventa (idventa, item, idproducto, cantidad, valor_unitario, precio_unitario, igv, porcentaje_igv, valor_total, importe_total)
					VALUES ('".$idventa."','".$it."','".$cod."','".$cant."','".$v_u."','".$p_u."','".$igv_d."','".$impuesto."','".$v_t."','".$imp."')";
			if (!$obj->ejecutar($sql_dv)) {
				throw new Exception("Error al registrar detalle de venta");
			}
			
			// Actualizar stock
			$up="UPDATE productos SET stock = stock - ".$cant." WHERE idproducto='".$cod."' AND stock >= ".$cant;
			if (!$obj->ejecutar($up)) {
				throw new Exception("Error al actualizar stock del producto ID: ".$cod);
			}
		}

		// Vaciar carrito
		$sql_del="DELETE FROM carrito WHERE session_id='".$usu_safe."'";
		$obj->ejecutar($sql_del);
		
		// Confirmar transacción
		$obj->commit();
		
		echo "VENTA REALIZADA";
		echo "<script>window.open('../reportes/ticket.php?idventa=".$idventa."','_blank')</script>";
		
	} catch (Exception $e) {
		// Revertir transacción en caso de error
		$obj->rollback();
		error_log("Error en venta: " . $e->getMessage());
		echo "Error al procesar la venta: " . $e->getMessage();
	}
}
?>
