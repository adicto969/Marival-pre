<?php
require_once('librerias/pdf/fpdf.php');
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$FactorAu = $FactorA;
$Carpeta = "quincenal";
$periodo = $PC;
$tipoNom = $TN;

if(isset($_POST['uno'])){
  $fecha1 = $_POST['fecha'];
  $fecha2 = $_POST['fecha'];

  list($dia, $mes, $ayo) = explode('/', $fecha1);
  list($diaB, $mesB, $ayoB) = explode('/', $fecha2);

  $fecha1 = $ayo.$mes.$dia;
  $fecha2 = $ayoB.$mesB.$diaB;
  if($supervisor == '0'){
     $compleSuper = "";
  }else {
     $compleSuper = "AND L.supervisor = '".$supervisor."'";
  }

  if($DepOsub == 1){
    $SQLT = "SELECT DISTINCT E.codigo, E.sueldo AS 'Sueldo', R.checada
            FROM empleados AS E
            INNER JOIN Llaves AS L ON L.codigo = E.codigo AND L.empresa = E.empresa
            LEFT JOIN relch_registro AS R ON R.fecha = '".$fecha1."' AND R.empresa = '".$IDEmpresa."' AND R.centro = '".$centro."' AND R.checada <> '00:00:00' AND R.codigo = E.codigo
            WHERE
                E.activo = 'S'
                AND E.empresa = '".$IDEmpresa."'
                ".$compleSuper."
                AND L.tiponom = '".$tipoNom."'
                AND L.centro = '".$centro."'
            ORDER BY E.codigo";
    $LCentro = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  }else {
    $SQLT = "SELECT DISTINCT E.codigo, E.sueldo AS 'Sueldo', R.checada
            FROM empleados AS E
            INNER JOIN Llaves AS L ON L.codigo = E.codigo AND L.empresa = E.empresa
            LEFT JOIN relch_registro AS R ON R.fecha = '".$fecha1."' AND R.empresa = '".$IDEmpresa."' AND R.centro = '".$centro."' AND R.checada <> '00:00:00' AND R.codigo = E.codigo
            WHERE
            	  E.activo = 'S'
            	  AND E.empresa = '".$IDEmpresa."'
                  ".$compleSuper."
            	  AND L.tiponom = '".$tipoNom."'
            	  AND LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")
            ORDER BY E.codigo";

    $LCentro = "Centro = '".$centro."'";
  }


}else {

  $fecha1 = $_POST['f1'];
  $fecha2 = $_POST['f2'];

  list($dia, $mes, $ayo) = explode('/', $fecha1);
  list($diaB, $mesB, $ayoB) = explode('/', $fecha2);

  $fecha1 = $ayo.$mes.$dia;
  $fecha2 = $ayoB.$mesB.$diaB;

  if($DepOsub == 1){
    $SQLT = "[dbo].[reporte_checadas_excel_ctro]
              '".$fecha1."',
              '".$fecha2."',
              '".$centro."',
              '".$supervisor."',
              '".$IDEmpresa."',
              '".$tipoNom."',
              'LEFT (Llaves.centro, ".$MascaraEm.") = LEFT (''".$centro."'', ".$MascaraEm.")',
              '1'";

      $LCentro = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  }else {
    $SQLT = "[dbo].[reporte_checadas_excel_ctro]
              '".$fecha1."',
              '".$fecha2."',
              '".$centro."',
              '".$supervisor."',
              '".$IDEmpresa."',
              '".$tipoNom."',
              'Llaves.centro = ''".$centro."''',
              '0'";

      $LCentro = "Centro = '".$centro."'";
  }
}


$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

if($tipoNom == 1){
  $Carpeta = "semanal";
}

########################################################################################
############################CREAR ARCHIV EXCEL ########################################
$objPHPExcel = new PHPExcel();
// Leemos un archivo Excel 2007
$objReader = PHPExcel_IOFactory::createReader('Excel5');
// Leemos un archivo Excel 2007
$objPHPExcel = $objReader->load("plantillaExcel/faltas.xls");
// Indicamos que se pare en la hoja uno del libro
$objPHPExcel->setActiveSheetIndex(0);

$FILA = 2;

$objBDSQL->consultaBD($SQLT);

$o = 0;
$lr = 0;

if(isset($_POST['uno'])){
  while ( $row = $objBDSQL->obtenResult() )
  {
    $lr++;
    $o++;
    $R = 5;
    $CONSULTA = "SELECT nombre, valor FROM datos WHERE nombre = '".str_replace("/", "-", $_POST['fecha'])."' AND codigo = '".$row['codigo']."' AND periodoP = '".$periodo."' AND tipoN = '".$tipoNom."' AND IDEmpresa = '".$IDEmpresa."' AND ".$LCentro;
    $objBDSQL2->consultaBD2($CONSULTA);
    //echo $CONSULTA."<br>";
    $datos = $objBDSQL2->obtenResult2();
    if(strtoupper($datos['valor']) == "F"){
     $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row['codigo'])
                                    ->SetCellValue('B'.$FILA, 108)
                                    ->SetCellValue('C'.$FILA, ($row['Sueldo'] * $FactorAu))
                                    ->SetCellValue('D'.$FILA, $_POST['fecha'])
                                    ->SetCellValue('E'.$FILA, "F")
                                    ->SetCellValue('F'.$FILA, 1);
     $FILA++;
    }
  }
}else{
  while ( $row = $objBDSQL->obtenResult() )
  {
    $lr++;
    $o++;
    $R = 5;
    foreach ($row as $clave => $valor){
        if($clave == 'codigo' || $clave == 'Nombre' || $clave == 'Sueldo' || $clave == 'Tpo'){

        }else {
		$CONSULTA = "SELECT nombre, valor FROM datos WHERE nombre = '".str_replace("/", "-", $clave)."' AND codigo = '".$row['codigo']."' AND periodoP = '".$periodo."' AND tipoN = '".$tipoNom."' AND IDEmpresa = '".$IDEmpresa."' AND ".$LCentro;
    		$objBDSQL2->consultaBD2($CONSULTA);
    		$datos = $objBDSQL2->obtenResult2();
      		if(strtoupper($datos['valor']) == "F"){
          	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row['codigo'])
                                        ->SetCellValue('B'.$FILA, 108)
                                        ->SetCellValue('C'.$FILA, ($row['Sueldo'] * $FactorAu))
                                        ->SetCellValue('D'.$FILA, str_replace("-", "/", $datos['nombre']))
                                        ->SetCellValue('E'.$FILA, "F")
                                        ->SetCellValue('F'.$FILA, 1);
          	$FILA++;
      		}    	
        }
    }
    
  }
}


$objBDSQL->liberarC();
//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\falta'.$fecha1.'-'.$fecha2.'('.trim ($NomDep, " \t.").').xls');


$XLFileType = PHPExcel_IOFactory::identify(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\falta('.trim ($NomDep, " \t.").').xls');
$objReader = PHPExcel_IOFactory::createReader($XLFileType);
$objReader->setLoadSheetsOnly('Ausentismos_CapturaMasiva');
$objPHPExcel = $objReader->load(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\falta'.$fecha1.'-'.$fecha2.'('.trim ($NomDep, " \t.").').xls');


try {
  $objBDSQL->cerrarBD();
} catch (Exception $e) {
  echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
}

$objWorksheet = $objPHPExcel->setActiveSheetIndexByName('Ausentismos_CapturaMasiva');
if($objPHPExcel->getActiveSheet()->getCell('A2')->getFormattedValue() == ""){
  unlink(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\falta'.$fecha1.'-'.$fecha2.'('.trim ($NomDep, " \t.").').xls');
  echo false;
}else {
  echo true;
}

?>
