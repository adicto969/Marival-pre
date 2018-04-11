<?php
require_once('librerias/pdf/fpdf.php');
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$ArchivoTxt = fopen("datos/Factor_Ausen.txt", "r");
$FactorAu = fgets($ArchivoTxt);

$bd1 = new ConexionM();
$bd1->__constructM();

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$Nresul = $_POST['Nresul'];
$Ncabecera = $_POST['Ncabecera'];
$fecha1 = $_POST['f1'];
$fecha2 = $_POST['f2'];
$fecha3 = $_POST['f3'];
$fecha4 = $_POST['f4'];
$Cabecera1 = array($_POST['CabeceraD']);
$Cabecera2 = array($_POST['Cabecera']);
$periodo = $_POST['periodo'];
$NomDep = $_POST["NomDep"];
$tipoNom = $_POST["tipoNom"];
$Carpeta = "quincenal";

list($dia, $mes, $ayo) = explode('/', $fecha1);
list($diaB, $mesB, $ayoB) = explode('/', $fecha2);
list($diaC, $mesC, $ayoC) = explode('/', $fecha3);
list($diaD, $mesD, $ayoD) = explode('/', $fecha4);
$fecha1 = $ayo.$mes.$dia;
$fecha2 = $ayoB.$mesB.$diaB;
$fecha3 = $ayoC.$mesC.$diaC;
$fecha4 = $ayoD.$mesD.$diaD;

if($DepOsub == 1){
  $SQLT = "[dbo].[reporte_checadas_excel_ctro]
            '".$fecha1."',
            '".$fecha2."',
            '".$centro."',
            '".$supervisor."',
            '".$IDEmpresa."',
            '".$tipoNom."',
            'LEFT (L.centro, ".$MascaraEm.") = LEFT (''".$centro."'', ".$MascaraEm.")',
            '1',
            '1',
            '1',
            '',
            '',
            ''";

    $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $SQLT = "[dbo].[reporte_checadas_excel_ctro]
          '".$fecha1."',
          '".$fecha2."',
          '".$centro."',
          '".$supervisor."',
          '".$IDEmpresa."',
          '".$tipoNom."',
          'L.centro = ''".$centro."''',
          '0',
          '1',
          '1',
          '',
          '',
          ''";

    $ComSql2 = "Centro = '".$centro."'";
}


if($tipoNom == 1){
  $Carpeta = "semanal";
}

$pagina = 0;
class PDF extends FPDF
{

  function tabla($sql, $objBDSQL, $Nresul, $NombreEmp, $RFC, $RegisEmp, $periodo, $f1, $f2, $f3, $f4, $cabecera1, $cabecera2, $NomDep, $Ncabecera, $abcd, $tipoNom, $numCol, $IDEmpresa, $centro, $bd1, $objBDSQL2)
  {
    $this->SetFillColor(0, 145, 234);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);
    $sumaTiempoExtra=0;
    $SHORAS = 0;
    $SMINUTOS = 0;
    ################################CABECERA DEL PDF#######################################

    $this->Cell(258, 10, $NombreEmp, 0, 0, 'C', false);
    $this->Ln(15);

    $this->SetFont('Arial', '', 10);

    $this->Cell(30, 5, 'RFC ');
    $this->Cell(50, 5, $RFC);
    $this->Ln();

    $this->Cell(30, 5, 'REG. PAT ');
    $this->Cell(50, 5, $RegisEmp);
    $this->Cell(100, 5, $NomDep, 0, 0, 'C', false);
    $this->Ln(10);

    $this->Cell(50, 5, 'PERIODO DE CORTE: '.$periodo, 0, 0, 'L', false);
    $this->Cell(50, 5, 'PERIODO DE PAGO', 0, 0, 'L', false);
    $this->Ln();

    $f1AD = substr($f1, 6, 2);
    $f1BM = substr($f1, 4, 2);
    $f1CA = substr($f1, 0, 4);
    $f1 = $f1AD."/".$f1BM."/".$f1CA;

    $f2AD = substr($f2, 6, 2);
    $f2BM = substr($f2, 4, 2);
    $f2CA = substr($f2, 0, 4);
    $f2 = $f2AD."/".$f2BM."/".$f2CA;

    $f3AD = substr($f3, 6, 2);
    $f3BM = substr($f3, 4, 2);
    $f3CA = substr($f3, 0, 4);
    $f3 = $f3AD."/".$f3BM."/".$f3CA;

    $f4AD = substr($f4, 6, 2);
    $f4BM = substr($f4, 4, 2);
    $f4CA = substr($f4, 0, 4);
    $f4 = $f4AD."/".$f4BM."/".$f4CA;


    $this->Cell(50, 5, 'Fecha Inicial: '.$f1, 0, 0, 'L', false);
    $this->Cell(50, 5, $f3, 0, 0, 'L', false);
    $this->Ln();

    $this->Cell(50, 5, 'Fecha Final: '.$f2, 0, 0, 'L', false);
    $this->Cell(50, 5, $f4, 0, 0, 'L', false);
    $this->Ln(10);

    $this->SetFont('Times', '', 8);
    $this->Cell(60, 6, '');

    foreach ($cabecera1[0] as $Cvalue) {
      $this->Cell(8,6,$Cvalue,1,0,'C');
    }
    /*for($i=0; $i<$Ncabecera-4; $i++){
        $this->Cell(8,6,$cabecera1[0][$i],1,0,'C');
    }*/
    $this->Ln();

    //$this->Cell(10,6,$cabecera2[0][0],1,0,'C', true);
    //$this->Cell(50,6,$cabecera2[0][1],1,0,'C', true);
    //$this->Cell(6,6,$cabecera2[0][3],1,0,'C', true);
    foreach ($cabecera2[0] as $Cvalue2) {
      if($Cvalue2 == 'codigo'){
        $this->Cell(10,6,$Cvalue2,1,0,'L', true);
      }else if($Cvalue2 == 'Nombre'){
        $this->Cell(50,6,$Cvalue2,1,0,'L', true);
      }else if($Cvalue2 == 'Actividad'){

      }else if($Cvalue2 == 'S'){

      }else if($Cvalue2 == 'sale1'){

      }else {
          $this->Cell(8,6,substr($Cvalue2, 0, 5),1,0,'L', true);
      }

    }
    /*for($i=3; $i<$Ncabecera-1; $i++){
        $this->Cell(8,6,$cabecera2[0][$i],1,0,'L', true);
    }*/
    $this->Cell(15, 6, 'T.Extra(11)', 1, 0, 'C', true);
    $this->Cell(15, 6, 'T.Extra(12)', 1, 0, 'C', true);
    $this->Cell(15, 6, 'T.Extra(13)', 1, 0, 'C', true);
    $this->Ln();

    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', '', 8);

    $o = 0;
    $lr = 0;
    $GLOBALS['pagina'] = 1;
    $result = $objBDSQL->consultaBD($sql);
    if($result['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$sql.PHP_EOL);
      fclose($file);
      echo "Error En consulta";
    }
    while ( $row = $objBDSQL->obtenResult() )
    {
      $lr++;
      $o++;

      $this->Cell(10, 6, $row["codigo"], 1, 0, 'C', true);
      $this->Cell(50, 6, utf8_encode($row["Nombre"]), 1, 0, 'L', true);

      $sumaHoras = 0;
      foreach (array_keys($row) as $value) {
        if($value == "codigo" || $value == "Nombre" || $value == "Sueldo" || $value == "Tpo" || $value == "TOTAL_REGISTROS" || $value == "PAGINA"){

        }else {
          $fechaN = str_replace('/', '-', $value);

          $valorC = "";
          $consultaVV = "SELECT Valor FROM TiempoExtra WHERE Codigo = '".$row["codigo"]."' AND Fecha = '$fechaN' AND Periodo = '$periodo' AND Tn = '$tipoNom' AND IDEmpresa = '$IDEmpresa' AND Centro = '$centro';";
          $resultVV = $bd1->query($consultaVV);
          $objBDSQL2->consultaBD2($consultaVV);
          $datosVV = $objBDSQL2->obtenResult2();
          if(!empty($datosVV["Valor"])){
            $valorC = $datosVV["Valor"];
          }
          $sumaHoras += $valorC;
          $this->Cell(8,6,$valorC,1,0,'C',true);
          $objBDSQL2->liberarC2();
        }

      }

      $this->Cell(15, 6, $sumaHoras, 1, 0, 'C', true);
      $this->Cell(15, 6, '', 1, 0, 'C', true);
      $this->Cell(15, 6, '', 1, 0, 'C', true);

      //$this->Cell(35, 6, '', 'LRB', 0, 'L', true);
      $sumaHoras = 0;
      $SMINUTOS = 0;
      $SHORAS = 0;
      $this->Ln();



    }

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

  }

  function Header()
  {
    $this->SetFillColor(0, 145, 234);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', '', 8);
    $Nresul = $_POST['Nresul'];
    if($GLOBALS['pagina'] == 1 && $Nresul > 20){
      $cabecera = array($_POST['CabeceraD']);
      $cabeceraD = array($_POST['Cabecera']);
      $Ncap = $_POST['Ncabecera'];

      $this->Cell(60, 6, '');

      for($i=0; $i<$Ncap-4; $i++){
          $this->Cell(8,6,$cabecera[0][$i],1,0,'C');
      }
      $this->Ln();
      $this->Cell(10, 6, $cabeceraD[0][0], 1, 0, 'C', true);
      $this->Cell(50, 6, $cabeceraD[0][1], 1, 0, 'C', true);
      //$this->Cell(6, 6, $cabeceraD[0][3], 1, 0, 'C', true);
      for($i=2; $i<$Ncap-2; $i++){
          $this->Cell(8,6,substr($cabeceraD[0][$i], 0, 5),1,0,'C', true);
      }
      $this->Cell(15, 6, 'T.Extra(11)', 1, 0, 'C', true);
      $this->Cell(15, 6, 'T.Extra(12)', 1, 0, 'C', true);
      $this->Cell(15, 6, 'T.Extra(13)', 1, 0, 'C', true);
      $this->Ln();

    }

  }

  function Footer(){
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0, 10, 'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
  }
}

$pdf = new PDF('L', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetTitle('Reporte de Faltas');
$pdf->SetFont('Arial', '', 8);
$pdf->AddPage();
$pdf->tabla($SQLT, $objBDSQL, $Nresul, $NombreEmpresa, $RFC, $RegisEmpresa, $periodo, $fecha1, $fecha2, $fecha3, $fecha4, $Cabecera1, $Cabecera2, $NomDep, $Ncabecera, $abcd, $tipoNom, $Ncabecera, $IDEmpresa, $centro, $bd1, $objBDSQL2);
$pdf->Output('F', Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\TpoExtra('.trim ($NomDep, " \t.").').pdf', true);


########################################################################################
############################CREAR ARCHIV EXCEL ########################################
$objPHPExcel = new PHPExcel();
// Leemos un archivo Excel 2007
$objReader = PHPExcel_IOFactory::createReader('Excel5');
// Leemos un archivo Excel 2007
$objPHPExcel = $objReader->load("plantillaExcel/TpoExtra.xls");
// Indicamos que se pare en la hoja uno del libro
$objPHPExcel->setActiveSheetIndex(0);

$FILA = 2;
$sumaTiempoExtra = 0;
$SMINUTOS = 0;
$SHORAS = 0;
if($Ncabecera > $Nresul){
  $NResultado = $Ncabecera;
}else {
  $NResultado = $Nresul;
}

$o = 0;
$lr = 0;

$f4AD = substr($fecha4, 6, 2);
$f4BM = substr($fecha4, 4, 2);
$f4CA = substr($fecha4, 0, 4);
$fecha4 = $f4AD."/".$f4BM."/".$f4CA;
$objBDSQL->consultaBD($SQLT);
while ( $row = $objBDSQL->obtenResult() )
{
  $lr++;
  $o++;
  $R = 5;

  $CONSULTA = "SELECT Fecha, Valor FROM tiempoextra WHERE Codigo = '".$row["codigo"]."' AND Periodo = '$periodo' AND Tn = '$tipoNom' AND IDEmpresa = '$IDEmpresa' AND ".$ComSql2.";";

  $objBDSQL2->consultaBD2($CONSULTA);

  while($datos = $objBDSQL2->obtenResult2()){
    $SHORAS += $datos["Valor"];
  }
  $objBDSQL2->liberarC2();

  if($SHORAS > 0){
	  if($tipoNom == 1 && $SHORAS > 0){
	    if($SHORAS <= 9){

	      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["codigo"])
                          ->SetCellValue('B'.$FILA, 11)
                          ->SetCellValue('C'.$FILA, (($row["Sueldo"]/8)*2)*$SHORAS)
                          ->SetCellValue('D'.$FILA, $fecha4)
                          ->SetCellValue('E'.$FILA, $SHORAS);
	      $FILA++;

	    }else {

	      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["codigo"])
	                        ->SetCellValue('B'.$FILA, 11)
	                        ->SetCellValue('C'.$FILA, (($row["Sueldo"]/8)*2)*9)
	                        ->SetCellValue('D'.$FILA, $fecha4)
	                        ->SetCellValue('E'.$FILA, 9);
	      $FILA++;
	      $sumaTiempoExtra2 = $SHORAS-9;
	      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["codigo"])
	                        ->SetCellValue('B'.$FILA, 12)
	                        ->SetCellValue('C'.$FILA, (($row["Sueldo"]/8)*2)*$sumaTiempoExtra2)
	                        ->SetCellValue('D'.$FILA, $fecha4)
	                        ->SetCellValue('E'.$FILA, $sumaTiempoExtra2);
	      $FILA++;

	    }
	  }else if($SHORAS > 0 && $tipoNom != 1){
	    if($SHORAS <= 18){
	      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["codigo"])
	                        ->SetCellValue('B'.$FILA, 11)
	                        ->SetCellValue('C'.$FILA, (($row["Sueldo"]/8)*2)*$SHORAS)
	                        ->SetCellValue('D'.$FILA, $fecha4)
	                        ->SetCellValue('E'.$FILA, $SHORAS);
	      $FILA++;
	    }else {
	      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["codigo"])
	                        ->SetCellValue('B'.$FILA, 11)
	                        ->SetCellValue('C'.$FILA, (($row["Sueldo"]/8)*2)*18)
	                        ->SetCellValue('D'.$FILA, $fecha4)
	                        ->SetCellValue('E'.$FILA, 18);
	      $FILA++;
	      $sumaTiempoExtra2 = $SHORAS-18;
	      $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["codigo"])
	                        ->SetCellValue('B'.$FILA, 12)
	                        ->SetCellValue('C'.$FILA, (($row["Sueldo"]/8)*2)*$sumaTiempoExtra2)
	                        ->SetCellValue('D'.$FILA, $fecha4)
	                        ->SetCellValue('E'.$FILA, $sumaTiempoExtra2);
	      $FILA++;
	    }

	  }
    }
    $sumaTiempoExtra = 0;
    $SMINUTOS = 0;
    $SHORAS = 0;
}



//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\TpoExtra('.trim ($NomDep, " \t.").').xls');


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$XLFileType = PHPExcel_IOFactory::identify(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\TpoExtra('.trim ($NomDep, " \t.").').xls');
$objReader = PHPExcel_IOFactory::createReader($XLFileType);
$objReader->setLoadSheetsOnly('Hoja1');
$objPHPExcel = $objReader->load(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\TpoExtra('.trim ($NomDep, " \t.").').xls');

$objWorksheet = $objPHPExcel->setActiveSheetIndexByName('Hoja1');
if($objPHPExcel->getActiveSheet()->getCell('A2')->getFormattedValue() == ""){
  unlink(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\TpoExtra('.trim ($NomDep, " \t.").').xls');
}

try {
  $objBDSQL->cerrarBD();
  $objBDSQL2->cerrarBD();
} catch (Exception $e) {
  echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
}

echo true;

?>
