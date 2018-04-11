<?php

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$Columna = $_POST["columna"];
$codigo = $_POST["codigo"];
$valor = $_POST["valor"];

$CONSULTA = "SELECT Codigo FROM conseptoextra WHERE Codigo = '$codigo' AND Periodo = '$PC' AND IDEmpresa = '$IDEmpresa' AND Centro = '$centro';";
$objBDSQL->consultaBD($CONSULTA);
$row = $objBDSQL->obtenResult();
if(empty($row)){
  $numCc = 1;
  $SnumC = 1;
  $consult = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'conseptoextra'";
  $objBDSQL2->consultaBD2($consult);
  while($row2 = $objBDSQL2->obtenResult2()){
    if($row2['COLUMN_NAME'] != "Codigo" && $row2['COLUMN_NAME'] != "ID" && $row2['COLUMN_NAME'] != "Periodo" && $row2['COLUMN_NAME'] != "IDEmpresa" && $row2['COLUMN_NAME'] != "Centro"){
        if($row2['COLUMN_NAME'] == $Columna){
          $SnumC = $numCc;
        }
        $numCc++;
    }
  }
  $objBDSQL2->liberarC2();

  $complemento = "";
  for ($i=1; $i < $numCc ; $i++) {
    if($SnumC == $i){
        $complemento .= "'$valor',";
    }else {
        $complemento .= "'',";
    }
  }
  $INSERT = "INSERT INTO conseptoextra VALUES('$codigo', '$PC', '$IDEmpresa', '$centro', ".substr($complemento, 0, -1).");";
}else {
  $INSERT = "UPDATE conseptoextra SET ".$Columna." = '$valor' WHERE Codigo = '$codigo' AND Periodo = '$PC' AND IDEmpresa = '$IDEmpresa' AND Centro = '$centro';";
}
echo $INSERT;

$objBDSQL->liberarC();
$objBDSQL->consultaBD($INSERT);
//sqlsrv_errors()[0]['message'];
$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();

?>
