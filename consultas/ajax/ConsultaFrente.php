<?php

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$codigo = $_POST['codigo'];
$Tnn = $_POST['tn'];
$valor = $_POST['valor'];
$fecha = $_POST['fecha'];
$Periodo = $_POST['periodo'];

$consulta = "SELECT TOP(5) Codigo, Nombre FROM codigosfrente WHERE (Codigo LIKE '%".$valor."%' OR Nombre LIKE '%".$valor."%')";

$queryS = $objBDSQL->consultaBD($consulta);

if($valor == 'F' || $valor == 'f'){
   echo '
    <div class="chip" style="cursor: pointer;" onclick="GuardarTR('.$codigo.', \''.strtoupper($valor).'\', \''.$fecha.'\', '.$Periodo.', '.$Tnn.', \''.$codigo.$fecha.'\')">
      '.strtoupper($valor).'- FALTA
      <i class="close material-icons">close</i>
    </div>
  ';
}

if($valor == '-n' || $valor == '-N'){
   echo '
    <div class="chip" style="cursor: pointer;" onclick="GuardarTR('.$codigo.', \''.strtoupper($valor).'\', \''.$fecha.'\', '.$Periodo.', '.$Tnn.', \''.$codigo.$fecha.'\')">
      Borrar - Borrar Dato
      <i class="close material-icons">close</i>
    </div>
  ';
}

if($queryS === false){
  $errorS = sqlsrv_errors();
  if(empty($errorS[0]['message'])){
    echo '
      <div class="chip" style="cursor: pointer;">
        No Se Encontraron Frentes
        <i class="close material-icons">close</i>
      </div>
    ';
  }else{
      var_dump($errorS[0]['message']);
  }
  exit();
}

while ($row= $objBDSQL->obtenResult()) {
  echo '
    <div class="chip" style="cursor: pointer;" onclick="GuardarTR('.$codigo.', '.$row['Codigo'].', \''.$fecha.'\', '.$Periodo.', '.$Tnn.', \''.$codigo.$fecha.'\')">
      '.$row['Codigo'].'-'.$row['Nombre'].'
      <i class="close material-icons">close</i>
    </div>
  ';
}

$objBDSQL->liberarC();

try {
  $objBDSQL->cerrarBD();
} catch (Exception $e) {
  echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
}

?>
