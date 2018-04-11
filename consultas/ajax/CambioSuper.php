<?php
$Estado = 0;
$supervisor = $_POST['supervisor'];
$Tipo = $_POST['Tipo'];
$idEmp = $_POST['idEmp'];
$bd1 = new ConexionM();
$bd1->__constructM();

$InsertarCP = "UPDATE config SET supervisor = '$supervisor' WHERE IDUser = '".$_SESSION['IDUser']."';";

if($bd1->query($InsertarCP)){
   $Estado = 2;
}else {
   echo $bd1->errno. '  '.$bd1->error;
}



$bd1->close();

echo $Estado;

?>