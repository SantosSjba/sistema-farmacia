<?php
class clsConexion
{
	private $con;
	function __construct()
	{
		try {
			//modificar los datos de la conexion
			$host = "localhost";
			$db_name = "clinaxkk_farmacia";
			$user = "clinaxkk_farmacia";
			$pass = "q63KCE2}$~(&";
			//cadena de conexion
			$this->con = mysqli_connect($host, $user, $pass) or die("erro en la conexion a la bd");
			mysqli_select_db($this->con, $db_name) or die("no se encontro la bd");
			$this->con->set_charset("utf8");
			date_default_timezone_set("America/Lima");
			//echo "conexion exitosa";
		} catch (Exception $ex) {
			throw $ex;
		}
	}
	function consultar($sql)
	{
		//$con = new clsConexion;
		$res = mysqli_query($this->con, $sql);
		$data = NULL;
		while ($fila = mysqli_fetch_assoc($res)) {
			$data[] = $fila;
		}
		return $data;
	}
	function ejecutar($sql)
	{
		mysqli_query($this->con, $sql);
		if (mysqli_affected_rows($this->con) <= 0) {
			//echo "no se pudo realizar lo pedido";
			return false;
		} else {
			return true;
		}
	}

	public function real_escape_string($string)
	{
		return $this->con->real_escape_string($string);
	}

	public function insert_id()
	{
		return mysqli_insert_id($this->con);
	}
	public function prepare($query)
    {
        return $this->con->prepare($query); // Devuelve un objeto `mysqli_stmt`
    }

}
?>