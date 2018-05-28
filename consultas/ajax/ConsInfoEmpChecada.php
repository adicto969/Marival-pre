<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$codigo = $_POST['codigo'];

$consulta = "SELECT TOP(5) L.empresa AS empresa,
               L.codigo AS codigo,
               E.nombre + ' ' + E.ap_paterno + ' ' + E.ap_materno AS nombre,
               D.entra1 AS entra1,
               D.sale1 AS sale1
            FROM Llaves AS L
            INNER JOIN detalle_horarios AS D ON D.horario = L.horario AND D.empresa = L.empresa
            INNER JOIN empleados AS E ON L.codigo = E.codigo
            WHERE L.codigo LIKE '".$codigo."%'
            AND (D.dia_Semana = 1 AND D.entra1 <> '')
            AND E.activo = 'S'
";

$rs = $objBDSQL->consultaBD($consulta);
if($rs['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$_queryFechas.PHP_EOL);
  fclose($file);
  /////////////////////////////
  echo '
  <div class="chip" style="cursor: pointer;">
      Ocurrio un Error
      <i class="close material-icons">close</i>
  </div>
  ';
  $objBDSQL->cerrarBD();
  exit();
}

while ($datos = $objBDSQL->obtenResult()) {
  echo '
  <div class="chip" style="cursor: pointer;" onclick="agregartap('.$datos["codigo"].', '.$datos["empresa"].', \''.$datos["entra1"].'\', \''.$datos["sale1"].'\')">
      '.$datos["nombre"].'
      <i class="close material-icons">close</i>
  </div>
  ';
}

?>
