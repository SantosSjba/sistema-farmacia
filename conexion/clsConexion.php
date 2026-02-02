<?php
/**
 * Clase de conexión a la base de datos
 * Sistema de Farmacia/Botica
 */
class clsConexion
{
	private $con;
	
	function __construct()
	{
		try {
			// Cargar configuración desde archivo externo (más seguro)
			$config_file = __DIR__ . '/db_config.php';
			if (file_exists($config_file)) {
				$config = include($config_file);
				$host = $config['host'];
				$db_name = $config['db_name'];
				$user = $config['user'];
				$pass = $config['pass'];
			} else {
				// Configuración por defecto (CAMBIAR EN PRODUCCIÓN)
				$host = "195.250.27.211";
				$db_name = "factosys_boticajl";
				$user = "factosys_boticajl";
				$pass = "boticajl2025";
			}
			
			// Conexión a la base de datos
			$this->con = mysqli_connect($host, $user, $pass, $db_name);
			
			if (!$this->con) {
				error_log("Error de conexión a la BD: " . mysqli_connect_error());
				die("Error de conexión a la base de datos. Contacte al administrador.");
			}
			
			$this->con->set_charset("utf8");
			date_default_timezone_set("America/Lima");
			
		} catch (Exception $ex) {
			error_log("Excepción en conexión: " . $ex->getMessage());
			throw $ex;
		}
	}
	
	/**
	 * Ejecutar consulta SELECT y retornar resultados
	 */
	function consultar($sql)
	{
		$res = mysqli_query($this->con, $sql);
		if (!$res) {
			error_log("Error en consulta SQL: " . mysqli_error($this->con) . " - Query: " . substr($sql, 0, 200));
			return NULL;
		}
		$data = NULL;
		while ($fila = mysqli_fetch_assoc($res)) {
			$data[] = $fila;
		}
		return $data;
	}
	
	/**
	 * Ejecutar consulta INSERT, UPDATE, DELETE
	 */
	function ejecutar($sql)
	{
		$result = mysqli_query($this->con, $sql);
		if (!$result) {
			error_log("Error en ejecución SQL: " . mysqli_error($this->con) . " - Query: " . substr($sql, 0, 200));
			return false;
		}
		return mysqli_affected_rows($this->con) >= 0;
	}

	/**
	 * Escapar string para prevenir SQL Injection
	 */
	public function real_escape_string($string)
	{
		if ($string === null) {
			return '';
		}
		return $this->con->real_escape_string($string);
	}

	/**
	 * Obtener el último ID insertado
	 */
	public function insert_id()
	{
		return mysqli_insert_id($this->con);
	}
	
	/**
	 * Preparar consulta (prepared statements)
	 */
	public function prepare($query)
	{
		return $this->con->prepare($query);
	}
	
	/**
	 * Iniciar transacción
	 */
	public function begin_transaction()
	{
		return $this->con->begin_transaction();
	}
	
	/**
	 * Confirmar transacción
	 */
	public function commit()
	{
		return $this->con->commit();
	}
	
	/**
	 * Revertir transacción
	 */
	public function rollback()
	{
		return $this->con->rollback();
	}
	
	/**
	 * Obtener último error
	 */
	public function error()
	{
		return mysqli_error($this->con);
	}
	
	/**
	 * Cerrar conexión
	 */
	public function close()
	{
		if ($this->con) {
			mysqli_close($this->con);
		}
	}
	
	/**
	 * Destructor - cerrar conexión automáticamente
	 */
	function __destruct()
	{
		$this->close();
	}
}
?>