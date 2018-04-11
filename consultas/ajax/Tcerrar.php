<?php

$periodo = $_POST["periodo"];
$tiponom = $_POST["tiponom"];
$estado = $_POST["estado"];
$realizado = 0;
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$cambiarEstado = "IF EXISTS (SELECT estado FROM estatusPeriodo WHERE periodo = $periodo AND tipoNom = $tiponom AND (estado = 0 OR estado = 1))
	BEGIN UPDATE estatusPeriodo SET estado = $estado WHERE periodo = $periodo AND tipoNom = $tiponom END
ELSE INSERT INTO estatusPeriodo VALUES ($periodo, $tiponom, GETDATE(), $estado)";
try{
  $objBDSQL->consultaBD($cambiarEstado);
  echo 3;
}catch(Exception $e){
  print_r($e);
}
/*
if($DepOsub == 1)
{
  $ComSql = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $ComSql = "Centro = '".$centro."'";
}

$Minsert = "DELETE from datos where periodoP = '".$periodo."' AND IDEmpresa = '".$IDEmpresa."' AND ".$ComSql." ";
$objBDSQL->consultaBD($Minsert);
if(!empty(sqlsrv_errors()[0]['message'])){
  echo sqlsrv_errors()[0]['message'];
}else {
  $realizado = 1;
}
$objBDSQL->liberarC();
$Minsert = "DELETE from datosanti where periodoP = '".$periodo."' AND IDEmpresa = '".$IDEmpresa."' AND ".$ComSql." ";
$objBDSQL->consultaBD($Minsert);
if(!empty(sqlsrv_errors()[0]['message'])){
  echo sqlsrv_errors()[0]['message'];
}else {
  $realizado = $realizado + 1;
}
$objBDSQL->liberarC();

$Minsert = "DELETE from premio where Periodo = '".$periodo."' AND ".$ComSql." and IDEmpresa = '".$IDEmpresa."'";
$objBDSQL->consultaBD($Minsert);
if(!empty(sqlsrv_errors()[0]['message'])){
  echo sqlsrv_errors()[0]['message'];
}else {
  $realizado = $realizado + 1;
}
$objBDSQL->liberarC();

echo $realizado;

///BORRAR ARCHIVOS DEL DIRECTORIO
$files = glob(Unidad."E".$IDEmpresa."\\semanal\\pdf\\*"); // obtiene todos los archivos
foreach($files as $file){
  if(is_file($file)) // si se trata de un archivo
    unlink($file); // lo elimina
}

$files = glob(Unidad."E".$IDEmpresa."\\quincenal\\pdf\\*"); // obtiene todos los archivos
foreach($files as $file){
  if(is_file($file)) // si se trata de un archivo
    unlink($file); // lo elimina
}

$files = glob(Unidad."E".$IDEmpresa."\\semanal\\excel\\*"); // obtiene todos los archivos
foreach($files as $file){
  if(is_file($file)) // si se trata de un archivo
    unlink($file); // lo elimina
}

$files = glob(Unidad."E".$IDEmpresa."\\quincenal\\excel\\*"); // obtiene todos los archivos
foreach($files as $file){
  if(is_file($file)) // si se trata de un archivo
    unlink($file); // lo elimina
}*/

$files = glob("Temp\\*"); // obtiene todos los archivos
foreach($files as $file){
  if(is_file($file)) // si se trata de un archivo
    unlink($file); // lo elimina
}

try {
  $objBDSQL->cerrarBD();
} catch (Exception $e) {
  echo 'ERROR al cerrar la conexion con SQL SERVER', $e;
}


?>
