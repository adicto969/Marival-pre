<?php
//Para hacer una conexion por un puerto especifico
//$serverName = "DESKTOP-2POHOQ5\\JUAN, 1542";
/*$serverName = "DESKTOP-2POHOQ5\\JUAN";
$connectionInfo = array("Database" => "bahia", "UID" => "sa", "PWD"=>"Enterprice9");
$conn = sqlsrv_connect($serverName, $connectionInfo);*/

/**
 * CONEXION A SQL SERVER
 */

function constructS()
{
  if(isset($_SESSION['DB'])){
    $conexionInfo = array("Database" => $_SESSION['DB'], "UID" => S_DB_USER, "PWD" => S_DB_PASS);
  }else {
    $conexionInfo = array("Database" => S_DB_NOMBRE, "UID" => S_DB_USER, "PWD" => S_DB_PASS);
  }

  $conn = sqlsrv_connect(S_DB_SERVER, $conexionInfo);
  if($conn){
    return $conn;
  }else{
    $result = "";
    $result = "Conexion no establecida<br>";
    $result .= die( print_r(sqlsrv_errors(), true));
  }
}


class ConexionS
{
  public function nFilas($conn, $query)
  {
    $parametros = array();
    $opciones = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $result = sqlsrv_query($conn, $query, $parametros, $opciones);
    $numeros = sqlsrv_num_rows($result);

    $resultQ = "";
    if($numeros === false){
      $resultQ = "Error en en la ejecucion";
      $resultQ .= die( print_r(sqlsrv_errors(), true));
      return $resultQ;
    }else {
      return $numeros;
    }
    sqlsrv_free_stmt($result);
  }

  public function nColumnas($conn, $query)
  {
    $result = sqlsrv_query($conn, $query);
    $numeros = sqlsrv_num_fields($result);

    $resultQ = "";
    if($numeros === false){
      $resultQ = "Error en en la ejecucion";
      $resultQ .= die( print_r(sqlsrv_errors(), true));
      return $resultQ;
    }else {
      return $numerosQ;
    }
    sqlsrv_free_stmt($result);
  }
}


/*
* CONEXION MYSQL
*/

class ConexionM extends mysqli
{

  public function __constructM()
  {
    parent::__construct(M_DB_SERVER,M_DB_USER,M_DB_PASS,M_DB_NOMBRE);
    $this->connect_errno ? die('Error en la Conexión a la base de datos') : null;
    $this->set_charset("utf8");
  }

  public function rows($query) {
    return mysqli_num_rows($query);
  }

  public function liberar($query){
    return mysqli_free_result($query);
  }

  public function recorrer($query){
    return mysqli_fetch_array($query);
  }

}


?>
