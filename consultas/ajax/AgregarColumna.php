<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();


$nombre = $_POST["nombre"];
$codigo = $_POST["codigo"];

$Modificacion = "ALTER TABLE conseptoextra ADD ".$nombre."_".$codigo." VARCHAR(10);";

try {
    $objBDSQL->consultaBD($Modificacion);
} catch (Exception $e) {
  echo $e;
}
if(!empty(sqlsrv_errors()[0]['message'])){
  echo sqlsrv_errors()[0]['message'];
}


?>
