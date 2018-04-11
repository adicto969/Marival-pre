<?php
$bdM = new ConexionM();
$bdM->__constructM();
$NomUser = $_POST['NomUser'];

$sql = $bdM->query("SELECT User FROM usuarios WHERE User LIKE '".$NomUser."%' AND User != 'sudo' LIMIT 5;");

while($datos = $bdM->recorrer($sql)){
  $UserU = $datos[0];
  echo '
  <div class="chip" style="cursor: pointer;" onclick="agregartap(\''.$UserU.'\')">
      '.$UserU.'
      <i class="close material-icons">close</i>
  </div>
  ';
}

/*$consulta = "SELECT IDUserDe, Mensaje, fecha FROM chat WHERE (IDUserDe = $IDUser OR IDUserDe = $IDdestino) AND (IDUserPara = $IDdestino OR IDUserPara = $IDUser) ORDER BY Fecha  LIMIT 100;";


$query = $bdM->query($consulta);

if(!empty($IDdestino)){
  while($datos = $bdM->recorrer($query)){*/



?>
