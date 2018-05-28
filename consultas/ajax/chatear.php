<?php
$bdM = new ConexionM();
$bdM->__constructM();

$Minsert = "INSERT INTO chat VALUES (NULL, ".$_SESSION['IDUser'].", ".$_POST['IDdestino'].", '".$_POST['Mensaje']."', '".date("Y/m/d H:i:s")."');";
echo $Minsert;
echo "<br/>";
if($bdM->query($Minsert)){

}else {
  echo $bdM->errno. '  '.$bdM->error;
}

?>
