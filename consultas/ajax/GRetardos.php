<?php
require_once('librerias/pdf/fpdf.php');
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


function contarValores($array)
{
    $repetidos = array();
    $faltasChecadas = array();
    $x = 0;
    foreach($array as $value)
    {
        if(isset($repetidos[$value]))
        {
            // si ya existe, le añadimos uno
            $repetidos[$value]+=1;
            if($repetidos[$value] == 3 || $repetidos[$value] == 6 || $repetidos[$value] == 9 || $repetidos[$value] == 12 || $repetidos[$value] == 15){
              $faltasChecadas[$x]=$value;
              $x++;
            }
        }else {
            // si no existe lo añadimos al array
            $repetidos[$value]=1;
        }
    }
    return $faltasChecadas;
}


function contarValoresArray($array)
{
	$contar=array();
	foreach($array as $value)
	{
		if(isset($contar[$value]))
		{
			// si ya existe, le añadimos uno

			$contar[$value] += 1;

		}else{
			// si no existe lo añadimos al array

			$contar[$value] = 1;
		}
	}
	return $contar;
}




$Tn = $_POST['Tn'];
$Periodo = $_POST['Periodo'];
$Nresult = $_POST['Nresultado'];
$Ncol = $_POST['Ncol'];
$carpeta = "quincenal";
$Cabecera1 = array($_POST['CabeceraD']);
$Cabecera2 = array($_POST['Cabecera']);
$F1 = $_POST['F1'];
$F2 = $_POST['F2'];
$F3 = $_POST['F3'];
$F4 = $_POST['F4'];
$lista = array();
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();
$bd1 = new ConexionM();
$bd1->__constructM();
$_fechas = periodo($Periodo, $Tn);
list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $_fechas);

list($dia, $mes, $ayo) = explode('/', $fecha3);
list($diaB, $mesB, $ayoB) = explode('/', $fecha4);

$fecha3 = $ayo."/".$mes."/".$dia;
$fechaF3 = $ayo."/".$mes."/".$dia;
$fechaF4 = $ayoB."/".$mesB."/".$diaB;


if($Periodo > 24 || $Tn == 1){
  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1',
                          CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2'
                   FROM Periodos
                   WHERE tiponom = 1
                   AND periodo = $Periodo-1
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
    /////////////////////////////
    $resultV['error'] = 1;
    $objBDSQL->cerrarBD();
    $objBDSQL2->cerrarBD();
    echo json_encode($resultV);
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
                   AND periodo = $Periodo
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
    /////////////////////////////
    $resultV['error'] = 1;
    $objBDSQL->cerrarBD();
    $objBDSQL2->cerrarBD();
    echo json_encode($resultV);
    exit();
  }
  $_datos = $objBDSQL->obtenResult();

  $fecha3 = $_datos['FECHA3'];
  $fecha4 = $_datos['FECHA4'];

  $objBDSQL->liberarC();
}

list($dia, $mes, $ayo) = explode('/', $fecha1);
list($diaB, $mesB, $ayoB) = explode('/', $fecha2);
$fecha1 = $ayo.$mes.$dia;
$fecha2 = $ayoB.$mesB.$diaB;

if($DepOsub == 1)
{
  $query = "[dbo].[proc_retardos]
          '".$F1."',
          '".$F2."',
          '".$centro."',
          '0',
          '".$IDEmpresa."',
          '".$Tn."',
          'E',
          'min',
          '1'
  ";
  $ComSql = "LEFT (Dep, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $query = "[dbo].[proc_retardos]
          '".$F1."',
          '".$F2."',
          '".$centro."',
          '0',
          '".$IDEmpresa."',
          '".$Tn."',
          'E',
          'min',
          '0'
  ";
  $ComSql = "Dep = '".$centro."'";
}

if($Tn == 1){
	$carpeta = "semanal";
}

$NombreD = $NomDep;
$empleaTiempoFecha = array();

$OExcel = new PHPExcel();
$OLeer =  PHPExcel_IOFactory::createReader('Excel5');
$OExcel = $OLeer->load("plantillaExcel/faltas.xls");
$OExcel->setActiveSheetIndex(0);

$FILA = 2;

if($Nresult > $Ncol)
{
	$Nresultado = $Nresult;
}else {
	$Nresultado = $Ncol;
}

$num = $objBDSQL->obtenfilas($query);
$objBDSQL->consultaBD($query);
$i = 0;
while($row = $objBDSQL->obtenResult()){
  $empleaTiempoFecha[$row["codigo"]] = "";
  $i++;
  foreach (array_keys($row) as $value) {
    if($value == "codigo" || $value == "Nombre" || $value == "sueldo" || $value == "Tpo"){

    }else {
      if($row["Tpo"] == "E"){
        $fechaTitulo = str_replace("/", "-", $value);
        $nombre = $row["codigo"].$fechaTitulo;
        if(!empty($row[$value])){
          $array = array($_POST[$nombre]);
          if(!empty($array[0][0]))
          {
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

            $ahcef = date("d/m/Y", strtotime($fechaF3." + ".$i." day"));

            $etad = new \DateTime($fechaF4);

            $FG = $etad->format("d/m/Y");
            if($array[0][0] == "R"){
              $empleaTiempoFecha[$array[0][1]] .= $array[0][4]."-".$array[0][5]."-";
              $lista[$nombre] = $row["codigo"];
              $lista[$nombre] .= '-';
              $lista[$nombre] .= $row["sueldo"];
            }
          }

        }
      }
    }
  }
}


//echo count(contarValoresArray($lista));
//print_r($empleaTiempoFecha);
$objBDSQL->liberarC();
$t = 0;
$faltasAcu = array();
$codigosEmpleados = array();
$codigoACU = array();
$almacenado = "";

$objBDSQL->consultaBD($query);

while($row = $objBDSQL->obtenResult()){

    if($row["Tpo"] == "E" ){

      $etad = new \DateTime($fechaF4);

      $FG = $etad->format("d/m/Y");
      $Nomvar = $row["codigo"]."-".$row["sueldo"];
      $codigo = $row["codigo"];
      $sueldo = $row["sueldo"];


      $porciones = explode("-", $empleaTiempoFecha[$codigo]);

      if(isset(contarValoresArray($lista)[$Nomvar])){
        if(contarValoresArray($lista)[$Nomvar] == 1){
          //echo "1 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 2){
          //echo "2 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[3]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[2])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[3]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 3){
          //echo "1 faltas";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 4){
          //echo "1 faltas y 1 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 5){
          //echo "1 faltas y 2 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[3]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[2])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[3]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 6){
          //echo "2 faltas";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 7){
          //echo "2 faltas y 1 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;

          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 8){
          //echo "2 faltas y 2 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[3]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[2])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[3]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 9){
          //echo "3 faltas ";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 10){
          //echo "3 faltas y 1 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 11){
          //echo "3 faltas y 2 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[3]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[2])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[3]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 12){
          //echo "4 faltas";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 13){
          //echo "4 faltas y 1 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 14){
          //echo "4 faltas y 2 R";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[1]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[0])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[1]);
					$FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $codigo)
											 ->SetCellValue('B'.$FILA, 120)
											 ->SetCellValue('C'.$FILA, (($sueldo/(8*60))*($porciones[3]*100)))
											 ->SetCellValue('D'.$FILA, $porciones[2])
											 ->SetCellValue('E'.$FILA, 'R')
											 ->SetCellValue('F'.$FILA, $porciones[3]);
					$FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }else if(contarValoresArray($lista)[$Nomvar] == 15){
          //echo "5 faltas";
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          $OExcel->getActiveSheet()->SetCellValue('A'.$FILA, $array[0][1])
                       ->SetCellValue('B'.$FILA, 108)
                       ->SetCellValue('C'.$FILA, $array[0][3])
                       ->SetCellValue('D'.$FILA, $FG)
                       ->SetCellValue('E'.$FILA, 'F')
                       ->SetCellValue('F'.$FILA, 1);
          $FILA++;
          contarValoresArray($lista)[$Nomvar] = 0;
          unset(contarValoresArray($lista)[$Nomvar]);
        }

      }
      contarValoresArray($lista)[$Nomvar] = 0;
    }
}

$OEscribir = PHPExcel_IOFactory::createWriter($OExcel, 'Excel5');
try {
    $OEscribir->save(Unidad."E".$IDEmpresa."\\".$carpeta.'\excel\Retardos('.trim($NombreD, " \t.").').xls');
} catch (Exception $e){
  if($e->getCode() == 0){
    echo "<br/> El Archivo esta abierto ";
  }

}


$XMLFileType = PHPExcel_IOFactory::identify(Unidad."E".$IDEmpresa."\\".$carpeta.'\excel\Retardos('.trim($NombreD, " \t.").').xls');

$OLeer = PHPExcel_IOFactory::createReader($XMLFileType);
$OLeer->setLoadSheetsOnly('Ausentismos_CapturaMasiva');

$OExcel = $OLeer->load(Unidad."E".$IDEmpresa."\\".$carpeta.'\excel\Retardos('.trim($NombreD, " \t.").').xls');

$objWorksheet = $OExcel->setActiveSheetIndexByName('Ausentismos_CapturaMasiva');
if($OExcel->getActiveSheet()->getCell('A2')->getFormattedValue() == "")
{
	unlink(Unidad."E".$IDEmpresa."\\".$carpeta.'\excel\Retardos('.trim($NombreD, " \t.").').xls');
}

$pagina = 0;
class PDF extends FPDF
{

	function tabla($query, $objBDSQL, $NombreEmp, $RFC, $RegisEmp, $Dep, $Pr, $F1, $F2, $F3, $F4, $Ncol, $cabecera1, $cabecera2, $abcd)
	{

	    $this->SetFillColor(0, 145, 234);
      $this->SetTextColor(0);
      $this->SetDrawColor(0);
      $this->SetLineWidth(.2);
      $this->SetFont('Arial', 'B', 14);

      //////////////////////////////////////CABECERA DEL DOCUMENTO ///////////////////////////////////////

      $this->Cell(258, 10, $NombreEmp, 0, 0, 'C', false);
      $this->Ln(15);

      $this->SetFont('Arial', '', 10);

      $this->Cell(30, 5, 'RFC ');
      $this->Cell(50, 5, $RFC);
      $this->Ln();

      $this->Cell(30, 5, 'REG. PAT');
      $this->Cell(50, 5, $RegisEmp);
      $this->Cell(100, 5, $Dep, 0, 0, 'C', false);
      $this->Ln(10);

      $this->Cell(50, 5, 'PERIODO DE CORTE: '.$Pr, 0, 0, 'L', false);
      $this->Cell(50, 5, 'PERIODO DE PAGO', 0, 0, 'L', false);
      $this->Ln();

      $this->Cell(50, 5, 'Fecha Inicial: '.$F1, 0, 0, 'L', false);
      $this->Cell(50, 5, $F3, 0, 0, 'L', false);
      $this->Ln();

      $this->Cell(50, 5, 'Fecha Final: '.$F2, 0, 0, 'L', false);
      $this->Cell(50, 5, $F4, 0, 0, 'L', false);
      $this->Ln(10);

      $this->SetFont('Times', '', 8);

      $this->Cell(66, 6, '');

      for($i=0; $i<=$Ncol-1; $i++){
        $this->Cell(11,6,$cabecera1[0][$i],1,0,'C');
	    }
	    $this->Ln();

	    $this->Cell(10,6,$cabecera2[0][0],1,0,'C', true);
	    $this->Cell(50,6,$cabecera2[0][1],1,0,'C', true);
	    $this->Cell(6,6,$cabecera2[0][3],1,0,'C', true);
	    for($i=4; $i<=$Ncol+3; $i++){
	        $this->Cell(11,6,$cabecera2[0][$i],1,0,'L', true);
	    }

	    $this->Cell(35, 6, 'FIRMA', 1, 0, 'C', true);
    	$this->Ln();

    	$this->SetFillColor(255, 255, 255);
	    $this->SetTextColor(0);
	    $this->SetDrawColor(0);
	    $this->SetLineWidth(.2);
	    $this->SetFont('Arial', '', 8);

	    $o = 0;
	    $lr = 0;
	    $GLOBALS['pagina'] = 1;
      $objBDSQL->consultaBD($query);
	    while ($row= $objBDSQL->obtenResult())
	    {
	    	$lr++;
	    	$o++;

	    	if(empty($row["codigo"]))
	    	{
	    		$this->Cell(10, 6, '', 1, 0, 'C', true);
	    	}else {
	    		$this->Cell(10, 6, $row["codigo"], 1, 0, 'C', true);
	    	}

	    	if(empty($row["Nombre"]))
	    	{
	    		$this->Cell(50, 6, '', 1, 0, 'C', true);
	    	}else {
	    		$this->Cell(50, 6, utf8_decode($row["Nombre"]), 1, 0, 'L', true);
	    	}

	    	if(empty($row["Tpo"]))
	    	{
	    		$this->Cell(6, 6, '', 1, 0, 'C', true);
	    	}else {
	    		$this->Cell(6, 6, utf8_decode($row["Tpo"]), 1, 0, 'C', true);
	    	}
	    	$R = 5;
        foreach (array_keys($row) as $value) {
          if($value == "codigo" || $value == "Nombre" || $value == "sueldo" || $value == "Tpo"){

          }else {
              if($row[$value]){
                $fechaTitulo = str_replace("/", "-", $value);
                $nombre = $row["codigo"].$fechaTitulo;
                if(isset($_POST[$nombre]))
    	    			{
    	    				$array = array($_POST[$nombre]);
    	    				$hr = str_replace(".", ":", $row[$value]);
    	    				$this->Cell(11, 6, $hr.' '.strtoupper($array[0][0]), 1, 0, 'C', true);
    	    			}

              }else {
                $hr = str_replace(".", ":", $row[$value]);
                $this->Cell(11, 6, $hr, 1, 0, 'L', true);
              }
          }
        }
	    	$this->Cell(35, 6, '', 1, 0, 'C', true);
	    	$this->Ln();
	    }
	}

	function Header()
	{
		    $this->SetFillColor(0, 145, 234);
		    $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        $this->SetFont('Arial', '', 8);

        $Nresul = $_POST['Nresultado'];

        if($GLOBALS['pagina'] == 1 && $Nresul > 20)
        {
        	$cabecera = array($_POST['CabeceraD']);
	      	$cabeceraD = array($_POST['Cabecera']);
	      	$Ncap = $_POST['Ncol'];

	        $this->Cell(66, 6, '');

	      	for($i=0; $i<$Ncap; $i++){
	        	$this->Cell(11,6,$cabecera[0][$i],1,0,'C');
	      	}
	      	$this->Ln();
	      	$this->Cell(10, 6, $cabeceraD[0][0], 1, 0, 'C', true);
	      	$this->Cell(50, 6, $cabeceraD[0][1], 1, 0, 'C', true);
	      	$this->Cell(6, 6, $cabeceraD[0][3], 1, 0, 'C', true);
	      	for($i=4; $i<$Ncap+4; $i++){
	            $this->Cell(11,6,$cabeceraD[0][$i],1,0,'L', true);
	      	}

	      	$this->Cell(35, 6, 'FIRMA', 1, 0, 'C', true);
	      	$this->Ln();
        }

	}

	function footer(){

        $this->SetY(-40);
        $this->SetFillColor(108, 236, 69);
        $this->SetTextColor(0);
        $this->SetDrawColor(0);
        $this->SetLineWidth(.2);
        $this->Ln(15);
        $this->Cell(37,6,'',0,0,'C');
        $this->Cell(37,6,'________________________',0,0,'C');
        $this->Cell(37,6,'',0,0,'C');
        $this->Cell(37,6,'________________________',0,0,'C');
        $this->Cell(37,6,'',0,0,'C');
        $this->Cell(37,6,'________________________',0,0,'C');
        $this->Cell(37,6,'',0,0,'C');
        $this->Ln();
        $this->Cell(37,6,'',0,0,'C');
        $this->Cell(37,6,'ELABORO',0,0,'C');
        $this->Cell(37,6,'',0,0,'C');
        $this->Cell(37,6,'REVISO',0,0,'C');
        $this->Cell(37,6,'',0,0,'C');
        $this->Cell(37,6,'AUTORIZO',0,0,'C');
        $this->Cell(37,6,'',0,0,'C');
        $this->Ln();


        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('L', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetTitle('Reporte de Retardos');
$pdf->AddPage();
$pdf->tabla($query, $objBDSQL, $NombreEmpresa, $RFC, $RegisEmpresa, $NombreD, $Periodo, $F1, $F2, $F3, $F4, $Ncol, $Cabecera1, $Cabecera2, $abcd);
$pdf->Output('F', Unidad."E".$IDEmpresa."\\".$carpeta.'\pdf\Retardos('.trim($NombreD, " \t.").').pdf', true);
echo "1";
$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();

?>
