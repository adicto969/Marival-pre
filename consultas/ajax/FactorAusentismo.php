<?php

$FA = $_POST['FA'];

$bd1 = new ConexionM();
$bd1->__constructM();
$InsertarCP = "UPDATE config SET FactorA = '$FA' WHERE IDUser = '".$_SESSION['IDUser']."';";

if($bd1->query($InsertarCP)){
  echo 1;
}else {
  echo $bd1->errno. '  '.$bd1->error;
}

$bd1->close();

/*
if($_POST['Tn'] == 1){
	$file = fopen("datos/Factor_AusenS.txt", "w");
	if(fwrite($file, $FA)){
	  echo "1";
	}
	fclose($file);
}else {
	$file = fopen("datos/Factor_Ausen.txt", "w");
	if(fwrite($file, $FA)){
	  echo "1";
	}
	fclose($file);
}*/




?>
