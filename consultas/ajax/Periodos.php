<?php
$periodo = $_POST['periodo'];
$TN = $_POST['TN'];
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$fecha1 = "";
$fecha2 = "";
$fecha3 = "";
$fecha4 = "";
if($PC <= 24){
	$_fechas = periodo($periodo, $TN);
	list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $_fechas);
}


if($TN == 1 || $PC > 24)
{
	$_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1',
                          CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2'
                   FROM Periodos
                   WHERE tiponom = 1
                   AND periodo = $PC-1
                   AND ayo_operacion = $ayoA
                   AND empresa = $IDEmpresa ;";
  $_resultados = $objBDSQL->consultaBD($_queryFechas);
  if($_resultados['error'] == 1)
  {
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$_queryFechas.PHP_EOL);
    fclose($file);
    $resultV['error'] = 1;
    echo json_encode($resultV);
    /////////////////////////////
    $objBDSQL->cerrarBD();
    $objBDSQL2->cerrarBD();

    exit();
  }
  $_datos = $objBDSQL->obtenResult();

  $fecha1 = $_datos['FECHA1'];
  $fecha2 = $_datos['FECHA2'];
  $objBDSQL->liberarC();

  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA3',
                          CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA4'
                   FROM Periodos
                   WHERE tiponom = 1
                   AND periodo = $PC
                   AND ayo_operacion = $ayoA
                   AND empresa = $IDEmpresa ;";
  $_resultados = $objBDSQL->consultaBD($_queryFechas);
  if($_resultados['error'] == 1)
  {
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$_queryFechas.PHP_EOL);
    fclose($file);
    $resultV['error'] = 1;
    echo json_encode($resultV);
    /////////////////////////////
    $objBDSQL->cerrarBD();
    $objBDSQL2->cerrarBD();

    exit();
  }
  $_datos = $objBDSQL->obtenResult();

  $fecha3 = $_datos['FECHA3'];
  $fecha4 = $_datos['FECHA4'];
  $objBDSQL->liberarC();
}
if(empty($fecha1)){
	$fecha1 = '05/08/1993';
}
if(empty($fecha2)){
	$fecha2 = '05/08/1993';
}
if(empty($fecha3)){
	$fecha3 = '05/08/1993';
}
if(empty($fecha4)){
	$fecha4 = '05/08/1993';
}

if(empty($fecha3)){
    echo "Error";
}else {

    $fechas = array(
      "fecha1" => $fecha1,
      "fecha2" => $fecha2,
      "fecha3" => $fecha3,
      "fecha4" => $fecha4
    );

    echo json_encode($fechas);

    try {
      $objBDSQL->cerrarBD();
    } catch (Exception $e) {
      echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
    }
}


?>
