<?php
#consultas Generales como el nombre de la empresa etc.

#Consulta MYSQLI
if(isset($_SESSION['IDUser'])){
  $bdM = new ConexionM();
  $bdM->__constructM();
  $sql = $bdM->query("SELECT IDEmpresa, centro, DB, UserDB, PassDB, PC, TN, PP, PA, POR, correo, server, DoS, FactorA, supervisor FROM config WHERE IDUser = '".$_SESSION['IDUser']."' LIMIT 1;");
  if($bdM->rows($sql) > 0){
    $datos = $bdM->recorrer($sql);
    $IDEmpresa = $datos[0];
    $centro = $datos[1];
    $DB = $datos[2];
    $UserDB = $datos[3];
    $PassDB = $datos[4];
    $PC = $datos[5];
    $TN = $datos[6];
    $PP = $datos[7];
    $PA = $datos[8];
    $POR = $datos[9];
    $correo = $datos[10];
    $ServerS = $datos[11];
    $DepOsub = $datos[12];
    $FactorA = $datos[13];
    $supervisor = $datos[14];
    $_SESSION['TN'] = $TN;
  }else {
    $error = "NO SE HAN ENCONTRADO DATOS MYSQL(Usuario)";
    echo "<h1 style='text-align:center;'>".$error."<h1>";
    exit();
  }

  $bdM->liberar($sql);
  $bdM->close();

  #Consulta SQL
  $objBDSQL = new ConexionSRV();
  $objBDSQL->conectarBD();
  $query = "SELECT LTRIM ( RTRIM ( nombre_empresa ) ) AS nombre_empresa,
                   LTRIM ( RTRIM ( rfc_empresa ) ) AS rfc_empresa,
                   LTRIM ( RTRIM ( registro_patronal ) ) AS registro_patronal,
                   direccion_empresa,
                   poblacion_empresa

            FROM empresas WHERE empresa = $IDEmpresa;";
  $conResult = $objBDSQL->consultaBD($query);

  if($conResult['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
    fclose($file);
    $error = "ERROR AL CONSULTAR DATOS EMPRESA(CONSULTA GENERAL)";
    echo "<h1 style='text-align:center;'>".$error."<h1>";
    exit();
  }

  $datos = $objBDSQL->obtenResult();
  if(empty($datos)){
    $error = "NO SE ENCONTRARON DATOS DE LA EMPRESA(CONSULTA GENERAL)";
    echo "<h1 style='text-align:center;'>".$error."<h1>";
    exit();
  }else {
    $NombreEmpresa = $datos['nombre_empresa'];
    $RFC = $datos['rfc_empresa'];
    $RegisEmpresa = $datos['registro_patronal'];
    $DirecEmpresa = $datos['direccion_empresa'];
    $PoblacionEmpresa = $datos['poblacion_empresa'];
  }

  $objBDSQL->liberarC();

  $query = "SELECT LTRIM ( RTRIM ( nomdepto ) ) AS nomdepto FROM centros WHERE centro = '$centro' AND empresa = '$IDEmpresa';";
  $NomDep="";
  $conResult = $objBDSQL->consultaBD($query);
  if($conResult['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
    fclose($file);
    $error = "ERROR AL CONSULTAR NOMBRE DEL DEPARTAMENTO(CONSULTA GENERAL)";
    echo "<h1 style='text-align:center;'>".$error."<h1>";
    exit();
  }

  $datos = $objBDSQL->obtenResult();
  if(empty($datos)){
    $error = "NO SE ENCONTRO NOMBRE DEL DEPARTAMENTO (CONSULTA GENERAL)";
    $NomDep = $error;
  }else {
    $NomDep = $datos['nomdepto'];
  }

  $objBDSQL->liberarC();

  $queryVerify = "SELECT charindex(' ', mascara) AS num FROM empresas WHERE empresa = '$IDEmpresa';";
  $query = "SELECT LEN (LEFT (mascara, charindex(' ', mascara) -1)) AS mascara FROM empresas WHERE empresa = '$IDEmpresa';";
  $MascaraEm = "";
  $conVerify = $objBDSQL->consultaBD($queryVerify);
  if($conVerify['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
    fclose($file);
    $error = "ERROR AL CONSULTAR INFORMACION DE LA EMPRESA (CONSULTA GENERAL:LINE-114)";
    echo "<h1 style='text-align:center;'>".$error."<h1>";
    exit();
  }else {
    $datos = $objBDSQL->obtenResult();
    if(empty($datos)){
      $error = "NO SE ENCONTRO LA EMPRESA";
      echo "<h1 style='text-align:center;'>".$error."<h1>";
      exit();
    }else {
      $MascaraEm = $datos['num'];
    }  
    $objBDSQL->liberarC();

    if($MascaraEm > 0){
      $conResult = $objBDSQL->consultaBD($query);
      if($conResult['error'] == 1){
        $file = fopen("log/log".date("d-m-Y").".txt", "a");
        fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
        fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['SQLSTATE'].PHP_EOL);
        fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['CODIGO'].PHP_EOL);
        fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['MENSAJE'].PHP_EOL);
        fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
        fclose($file);
        $error = "ERROR AL CONSULTAR INFORMACION DE LA EMPRESA (CONSULTA GENERAL)";
        echo "<h1 style='text-align:center;'>".$error."<h1>";
        exit();
      }
      $datos = $objBDSQL->obtenResult();
      if(empty($datos)){
        $error = "NO SE ENCONTRO LA EMPRESA";
        echo "<h1 style='text-align:center;'>".$error."<h1>";
      }else {
        $MascaraEm = $datos['mascara'];
      }  
    }      
  }
  $objBDSQL->liberarC();

  $query = "SELECT LTRIM(RTRIM(nombre)) AS nombre FROM supervisores WHERE supervisor = '".$supervisor."' AND empresa = '".$IDEmpresa."'";
  $NombreSupervisor = "";
  $conResult = $objBDSQL->consultaBD($query);
  if($conResult['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
    fclose($file);
    $error = "ERROR AL CONSULTAR INFORMACION DEL SUPERVISOR (CONSULTA GENERAL)";
    echo "<h1 style='text-align:center;'>".$error."<h1>";
    exit();
  }

  $datos = $objBDSQL->obtenResult();
  if($datos == 'NULL'){
    $NombreSupervisor = "Supervisor";
  }else {
    $NombreSupervisor = $datos['nombre'];
  }

  $objBDSQL->liberarC();
  ####################################################

  $queryH = "DECLARE @return_value int
             EXEC    @return_value = [dbo].[roldehorario]
                     @empresa = '$IDEmpresa'
             ";

  $Lun = array();
  $Mar = array();
  $Mie = array();
  $Jue = array();
  $Vie = array();
  $Sab = array();
  $Dom = array();
  $DesHora = array();
  $iDH = 0;

  $conResult = $objBDSQL->consultaBD($queryH);
  if($conResult['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
    fclose($file);
    $error = "ERROR AL CONSULTAR ROL DE HORARIO (CONSULTA GENERAL)";
    echo "<h1 style='text-align:center;'>".$error."<h1>";
    exit();
  }

  while($datos = $objBDSQL->obtenResult()){
    $iDH++;
    $DesHora[$iDH] = $datos["Nombre"];
    $Lun[$iDH] = $datos["LUN"];
    $Mar[$iDH] = $datos["MAR"];
    $Mie[$iDH] = $datos["MIE"];
    $Jue[$iDH] = $datos["JUE"];
    $Vie[$iDH] = $datos["VIE"];
    $Sab[$iDH] = $datos["SAB"];
    $Dom[$iDH] = $datos["DOM"];
  }

  $objBDSQL->liberarC();

  try {
    $objBDSQL->cerrarBD();
  } catch (Exception $e) {
    $error = 'ERROR AL CERRAR LA CONEXION CON SQL SERVER'.$e->getMessage();
    echo "<h1 style='text-align:center;'>".$error."<h1>";
  }
}else {
  $NombreEmpresa = "PRENOMINA";
}

?>
