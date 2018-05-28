<?php

$PA = $_POST['PA'];
$PP = $_POST['PP'];

$bd1 = new ConexionM();
$bd1->__constructM();
$InsertarCP = "UPDATE config SET PP = '$PP', PA = '$PA' WHERE IDUser = '".$_SESSION['IDUser']."';";

if($bd1->query($InsertarCP)){
  echo "1";
}else {
  echo $bd1->errno. '  '.$bd1->error;
}

$bd1->close();

?>
