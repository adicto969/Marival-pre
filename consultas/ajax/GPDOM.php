<?php
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$bdM = new ConexionM();
$bdM->__constructM();

$Periodo = $_POST['Pc'];
$Tn = $_POST['Tn'];
$Dep = $_POST['Dep'];
$Carpeta = "quincenal";

if($Tn == 1){
	$Carpeta = "semanal";
}


$queryD = "SELECT LTRIM ( RTRIM ( nomdepto ) ) AS nomdepto FROM centros WHERE centro = '".$Dep."' AND empresa = '".$IDEmpresa."';";
$NombreD = "";
$objBDSQL->consultaBD($queryD);
$datos = $objBDSQL->obtenResult();
$NombreD = $datos['nomdepto'];
$objBDSQL->liberarC();
if(empty($NombreD)){
		$NombreD = "GENERAL";
}
if($Periodo <= 24){
$_fechas = periodo($Periodo, $Tn);
list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $_fechas);
}


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

list($dia, $mes, $ayo) = explode('/', $fecha3);
list($diaB, $mesB, $ayoB) = explode('/', $fecha4);

$fecha3 = $ayo."/".$mes."/".$dia;
$fechaF3 = $ayo."/".$mes."/".$dia;
$fechaF4 = $ayoB."/".$mesB."/".$diaB;


list($dia, $mes, $ayo) = explode('/', $fecha1);
list($diaB, $mesB, $ayoB) = explode('/', $fecha2);
$fecha1 = $ayo.$mes.$dia;
$fecha2 = $ayoB.$mesB.$diaB;

/*$fechaC = DateTime::createFromFormat ('d/m/Y', $fecha1);
$fechaA = $fechaC->format('Y-m-d');*/
if($Tn == 1){
  for($i=0; $i<=6; $i++){

      $fecha23 = date("Y-m-d", strtotime($fecha1 ."+ ".$i." days"));

      $dia = date ('l', strtotime($fecha23));

      if ($dia == 'Sunday'){

          $arrayB[] = $fecha23;
      }

  }
}else {
  for($i=0; $i<=14; $i++){

      $fecha23 = date("Y-m-d", strtotime($fecha1 ."+ ".$i." days"));

      $dia = date ('l', strtotime($fecha23));

      if ($dia == 'Sunday'){

          $arrayB[] = $fecha23;
      }

  }
}

$nuD = count($arrayB);



if($nuD == 3){

    $dateA = DateTime::createFromFormat ('Y-m-d', $arrayB[0]);
    $Ffecha1 = $dateA->format('Ymd'); //-----> Cambiar fromato a ("d/m/Y")

    $dateB = DateTime::createFromFormat ('Y-m-d', $arrayB[1]);
    $Ffecha2 = $dateB->format('Ymd'); //-----> Cambiar fromato a ("d/m/Y")

    $dateC = DateTime::createFromFormat ('Y-m-d', $arrayB[2]);
    $Ffecha3 = $dateC->format('Ymd'); //-----> Cambiar fromato a ("d/m/Y")

    if($Ffecha3 > $fecha2){
      $comSql = "relch_registro.fecha in ('".$Ffecha1."','".$Ffecha2."') and";
    }else{
      $comSql = "relch_registro.fecha in ('".$Ffecha1."','".$Ffecha2."','".$Ffecha3."') and";
    }

}
else if($nuD == 2){
    $dateA = DateTime::createFromFormat ('Y-m-d', $arrayB[0]);
    $Ffecha1 = $dateA->format('Ymd'); //-----> Cambiar fromato a ("d/m/Y")

    $dateB = DateTime::createFromFormat ('Y-m-d', $arrayB[1]);
    $Ffecha2 = $dateB->format('Ymd'); //-----> Cambiar fromato a ("d/m/Y")

    $comSql = "relch_registro.fecha in ('".$Ffecha1."','".$Ffecha2."') and";
}else if($nuD == 1){

  $dateA = DateTime::createFromFormat ('Y-m-d', $arrayB[0]);
  $Ffecha1 = $dateA->format('Ymd'); //-----> Cambiar fromato a ("d/m/Y")

  $comSql = "relch_registro.fecha = '".$Ffecha1."' and";

}

if($DepOsub == 1)
{
	$comSql2 = "LEFT (relch_registro.centro, ".$MascaraEm.") = LEFT ('".$Dep."', ".$MascaraEm.")";
}else {
	$comSql2 = "relch_registro.centro = '".$Dep."'";
}


if($Dep == "TODOS" || $Dep == "TODO" || $Dep == "todos" || $Dep == "todo"){

	$query = "
        select relch_registro.codigo AS CODIGO,
        empleados.ap_paterno+' '+empleados.ap_materno+' '+empleados.nombre AS NOMBRE,
        tabulador.actividad AS ACTIVIDAD,
        CONVERT(varchar(10), relch_registro.fecha, 103) AS FECHA,
        relch_registro.num_conc AS NUM_CONC,
        empleados.sueldo * '.25' as PDOM

        from relch_registro

        INNER JOIN empleados on empleados.empresa = relch_registro.empresa and empleados.codigo = relch_registro.codigo
        INNER JOIN Llaves on Llaves.empresa = relch_registro.empresa and Llaves.codigo = relch_registro.codigo
        INNER JOIN tabulador on  tabulador.empresa = Llaves.empresa and  tabulador.ocupacion = Llaves.ocupacion

        where relch_registro.empresa = '".$IDEmpresa."' and
        empleados.activo = 'S' and
        ".$comSql."
        relch_registro.num_conc = 9 and
        relch_registro.tiponom = '".$Tn."'
        order by relch_registro.centro
        ";

}else {

	$query = "
        select relch_registro.codigo AS CODIGO,
        empleados.ap_paterno+' '+empleados.ap_materno+' '+empleados.nombre AS NOMBRE,
        tabulador.actividad AS ACTIVIDAD,
        CONVERT(varchar(10), relch_registro.fecha, 103) AS FECHA,
        relch_registro.num_conc AS NUM_CONC,
        empleados.sueldo * '.25' as PDOM

        from relch_registro

        INNER JOIN empleados on empleados.empresa = relch_registro.empresa and empleados.codigo = relch_registro.codigo
        INNER JOIN Llaves on Llaves.empresa = relch_registro.empresa and Llaves.codigo = relch_registro.codigo
        INNER JOIN tabulador on  tabulador.empresa = Llaves.empresa and  tabulador.ocupacion = Llaves.ocupacion

        where relch_registro.empresa = '".$IDEmpresa."' and
        empleados.activo = 'S' and
        ".$comSql."
        relch_registro.num_conc = 9 and
        relch_registro.tiponom = '".$Tn."' and
        ".$comSql2."
        order by relch_registro.codigo asc
        ";

}


$objPHPExcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("plantillaExcel/PDOM.xls");
$objPHPExcel->setActiveSheetIndex(0);

$FILA = 2;
$lr = 0;
$objBDSQL->consultaBD($query);

while ($row = $objBDSQL->obtenResult())
{
	$lr++;
	$pst = $row["CODIGO"].$lr;


	if ( isset( $_POST[$pst] ) )
	{
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["CODIGO"])
                                      ->SetCellValue('B'.$FILA, $row["NUM_CONC"])
                                      ->SetCellValue('C'.$FILA, $row["PDOM"]);
        $FILA++;
	} else {

	}

}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\PDOM('.trim ($NombreD, " \t.").').xls');

echo "1";

?>
