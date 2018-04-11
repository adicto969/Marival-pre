<?php
$Estado = 0;
$Dep = $_POST['centro'];
$Tipo = $_POST['Tipo'];
$idEmp = $_POST['idEmp'];
/*$file = fopen("datos/DepOsup.txt", "w");
if(fwrite($file, $Tipo)){
  $Estado++;
}
fclose($file);*/
$bd1 = new ConexionM();
$bd1->__constructM();
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

if($Tipo == 9){
  $consulta = "SELECT empresa FROM empresas WHERE empresa = ".$idEmp;
  $conResult = $objBDSQL->consultaBD($consulta);

  if($conResult['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consulta.PHP_EOL);
    fclose($file);
    $Estado = 9;
    exit();
  }
  $datos = $objBDSQL->obtenResult();
  if(empty($datos)){
    $Estado = 0;
    exit();
  }else {
    $InsertarCP = "UPDATE config SET IDEmpresa = '$idEmp' WHERE IDUser = '".$_SESSION['IDUser']."';";

    if($bd1->query($InsertarCP)){
      $Estado = 2;
    }else {
      echo $bd1->errno. '  '.$bd1->error;
    }
  }

}else {

  $InsertarCP = "UPDATE config SET centro = '$Dep', IDEmpresa = '$idEmp', DoS = '$Tipo' WHERE IDUser = '".$_SESSION['IDUser']."';";

  if($bd1->query($InsertarCP)){
    $Estado = 2;
  }else {
    echo $bd1->errno. '  '.$bd1->error;
  }
}


$bd1->close();

echo $Estado;

?>
