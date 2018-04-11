<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$modo = $_POST["modo"];
$codigo = $_POST["codigo"];
$valor = $_POST["valor"];
$PRio = $_POST["periodo"];
$Ttn = $_POST["tn"];
$centroE = $centro;
$valor = strtoupper($valor);

$resultV = array();
$resultV['error'] = 0;

if($DepOsub == 1){
  $ComSql3 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $ComSql3 = "Centro = '".$centro."'";
}

$consultaD = "SELECT PP, PA
              FROM premio
              WHERE codigo = '$codigo'
              AND Periodo = '$PRio'
              AND TN = '$Ttn'
              AND IDEmpresa = '$IDEmpresa'
              AND $ComSql3;";
$consulta = $objBDSQL->consultaBD($consultaD);
if($consulta['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaD.PHP_EOL);
  fclose($file);
  $resultV['error'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();
  exit();
}

$row = $objBDSQL->obtenResult();
$objBDSQL->liberarC();

/////////////////////////////////////////////////
##############Consultar centro del empleado
$consultaCentro = "SELECT LTRIM(RTRIM(centro)) AS centro
                   FROM Llaves
                   WHERE codigo = '$codigo'
                   AND empresa = '$IDEmpresa'
                   AND tiponom = '$Ttn'";

 $consulta = $objBDSQL->consultaBD($consultaCentro);
 if($consulta['error'] == 1){
   $file = fopen("log/log".date("d-m-Y").".txt", "a");
   fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
   fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
   fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
   fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
   fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaCentro.PHP_EOL);
   fclose($file);
   $resultV['error'] = 1;
   echo json_encode($resultV);
   /////////////////////////////
   $objBDSQL->cerrarBD();
   exit();
 }
 $rowCentro = $objBDSQL->obtenResult();
 if(!empty($rowCentro)){
   $centroE = $rowCentro['centro'];
 }
 $objBDSQL->liberarC();
 ##########################################################



if($modo == "pp"){
  if(!empty($row)){
    $update = "UPDATE premio SET PP = '$valor' WHERE codigo = '$codigo' AND Periodo = '$PRio' AND TN = '$Ttn' AND IDEmpresa = '$IDEmpresa' AND Centro = '$centroE';";
    $consulta = $objBDSQL->consultaBD($update);
    if($consulta['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$update.PHP_EOL);
      fclose($file);
      $resultV['error'] = 1;
      echo json_encode($resultV);
      /////////////////////////////
      $objBDSQL->cerrarBD();
      exit();
    }
  }else {
    $insert = "INSERT INTO premio VALUES ('$codigo', '$valor', '', '$Ttn','$PRio', '$centroE', '$IDEmpresa');";
    $consulta = $objBDSQL->consultaBD($insert);
    if($consulta['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$insert.PHP_EOL);
      fclose($file);
      $resultV['error'] = 1;
      echo json_encode($resultV);
      /////////////////////////////
      $objBDSQL->cerrarBD();
      exit();
    }
  }
}else {
  if(!empty($row)){
    $update = "UPDATE premio SET PA = '$valor' WHERE codigo = '$codigo' AND Periodo = '$PRio' AND TN = '$Ttn' AND IDEmpresa = '$IDEmpresa' AND Centro = '$centroE';";
    $consulta = $objBDSQL->consultaBD($update);
    if($consulta['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$update.PHP_EOL);
      fclose($file);
      $resultV['error'] = 1;
      echo json_encode($resultV);
      /////////////////////////////
      $objBDSQL->cerrarBD();
      exit();
    }
  }else {
    $insert = "INSERT INTO premio VALUES ('$codigo', '', '$valor', '$Ttn','$PRio', '$centroE', '$IDEmpresa');";
    $consulta = $objBDSQL->consultaBD($insert);
    if($consulta['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$insert.PHP_EOL);
      fclose($file);
      $resultV['error'] = 1;
      echo json_encode($resultV);
      /////////////////////////////
      $objBDSQL->cerrarBD();
      exit();
    }
  }
}

try {
  $objBDSQL->cerrarBD();
} catch (Exception $e) {
  $resultV['error'] = 1;
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR BD:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - ERROR al cerrar la conexion con SQL SERVER'.PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$e->getMessage().PHP_EOL);
  fclose($file);
}
echo json_encode($resultV);

?>
