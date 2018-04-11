<?php
//-----------------------------------------------------
//-----------------------------------------------------

/**
 * CONEXION MYSQL
 */

class ConexionM extends mysqli
{
  public $conexionInfo="";

  public $enlace="";
  public $resultado="";
  public $consulta="";


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

//-----------------------------------------------------
//-----------------------------------------------------

/**
 * CONEXION SQL LIBRERIA SRV
 */

class ConexionSRV
{
 public $conexionInfo="";

 public $enlace="";
 public $resultado="";
 public $resultado2="";
 public $consulta="";
 public $consulta2="";

 public function ConexionSRV()
 {   
    $this->conexionInfo = array("Database" => S_DB_NOMBRE, "UID" => S_DB_USER, "PWD" => S_DB_PASS);  
 }

 public function conectarBD()
 {
   $this->enlace = sqlsrv_connect( S_DB_SERVER, $this->conexionInfo);
     if( $this->enlace === false ) {
        die( print_r( sqlsrv_errors(), true));
        exit();
     }
 }

 public function consultaBD($sentenciaSQL)
 {
   $result = array();
   $result['error'] = 0;
   $result['SQLSTATE'] = "";
   $result['CODIGO'] = "";
   $result['MENSAJE'] = "";
   $this->consulta = sqlsrv_query($this->enlace, $sentenciaSQL);
   if($this->consulta === false || empty($this->consulta)) {
     $result['error'] = 1;
     if(($errors = sqlsrv_errors()) != null){
       $result['error'] = 1;
       foreach ($errors as $error) {
         $result['SQLSTATE'] = "SQLSTATE: ".$error['SQLSTATE'];
         $result['CODIGO'] = "CODIGO: ".$error['code'];
         $result['MENSAJE'] = "MENSAJE: ".$error['message'];
       }
     }
   }
   return $result;
 }

 public function consultaBD2($sentenciaSQL){
   $result = array();
   $result['error'] = 0;
   $result['SQLSTATE'] = "";
   $result['CODIGO'] = "";
   $result['MENSAJE'] = "";
   $this->consulta2 = sqlsrv_query($this->enlace, $sentenciaSQL);

   if($this->consulta2 === false || empty($this->consulta2)) {
     $result['error'] = 1;
     if(($errors = sqlsrv_errors()) != null){
       $result['error'] = 1;
       foreach ($errors as $error) {
         $result['SQLSTATE'] = "SQLSTATE: ".$error['SQLSTATE'];
         $result['CODIGO'] = "CODIGO: ".$error['code'];
         $result['MENSAJE'] = "MENSAJE: ".$error['message'];
       }
     }
   }
   return $result;
 }

 public function returnConsulta(){
   return $this->consulta;
 }

 public function returnConsulta2(){
   return $this->consulta2;
 }

 public function obtenResult(){
   $this->resultado=sqlsrv_fetch_array($this->consulta, SQLSRV_FETCH_ASSOC);
   return $this->resultado;
 }

 public function obtenResultNum(){
   $this->resultado=sqlsrv_fetch_array($this->consulta, SQLSRV_FETCH_NUMERIC);
   return $this->resultado;
 }

 public function obtenResult2(){
   $this->resultado2=sqlsrv_fetch_array($this->consulta2, SQLSRV_FETCH_ASSOC);
   return $this->resultado2;
 }

 public function obtenfilas($sentenciaSQL) {
   $param = sqlsrv_query($this->enlace, $sentenciaSQL, array(), array("Scrollable" => "buffered"));
   $result = array();
   $result['cantidad'] = 0;
   $result['error'] = 0;
   $result['SQLSTATE'] = "";
   $result['CODIGO'] = "";
   $result['MENSAJE'] = "";
   if($param === false) {
     $result['error'] = 1;
     if(($errors = sqlsrv_errors()) != null){
       $result['error'] = 1;
       foreach ($errors as $error) {
         $result['SQLSTATE'] = "SQLSTATE: ".$error['SQLSTATE'];
         $result['CODIGO'] = "CODIGO: ".$error['code'];
         $result['MENSAJE'] = "MENSAJE: ".$error['message'];
       }
       return $result;
     }
   }else {
     $this->resultado=sqlsrv_num_rows($param);
     $result['cantidad'] = $this->resultado;
     return $result;
   }
 }

 public function liberarC()
 {
   if(!empty($this->consulta))
      sqlsrv_free_stmt($this->consulta);


 }

 public function liberarC2(){
   if(!empty($this->consulta2))
      sqlsrv_free_stmt($this->consulta2);
 }

 public function cerrarBD()
 {
     sqlsrv_close( $this->enlace );
 }

}

?>
