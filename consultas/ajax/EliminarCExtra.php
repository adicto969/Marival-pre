<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$nombre = $_POST["nombre"];

$Consultas = "ALTER TABLE conseptoextra DROP COLUMN ".$nombre.";";

try {
    $objBDSQL->consultaBD($Consultas);
} catch (Exception $e) {
  echo $e;
}
if(!empty(sqlsrv_errors()[0]['message'])){
  echo sqlsrv_errors()[0]['message'];
}



?>
