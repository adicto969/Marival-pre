<?php
require_once('librerias/pdf/fpdf.php');
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');

ini_set('display_errors', FALSE);
ini_set('display_startup_errors', FALSE);
error_reporting(E_ALL);

$FactorAu = $FactorA;

$Nresul = $_POST['Nresul'];
$Ncabecera = $_POST['Ncabecera'];
$fecha1 = $_POST['f1'];
$fecha2 = $_POST['f2'];
$fecha3 = $_POST['f3'];
$fecha4 = $_POST['f4'];
$Cabecera1 = array($_POST['CabeceraD']);
$Cabecera2 = array($_POST['Cabecera']);
$periodo = $_POST['periodo'];
$tipoNom = $_POST["tipoNom"];
$Carpeta = "quincenal";

$resultV = array();
$resultV['error'] = 0;
$resultV['archivo'] = "-";
$resultV['excel'] = 0;


$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$bdM = new ConexionM();
$bdM->__constructM();

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
          'LEFT (L.centro, 10) = LEFT (''".$centro."'', ".$MascaraEm.")',
          '1',
          '1',
          '10',
          '',
          '',
          '".$ordernar."'
          ";

    $LCentro = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
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
          '10',
          '',
          '',
          ''";

    $LCentro = "Centro = '".$centro."'";
}



if($tipoNom == 1){
  $Carpeta = "semanal";
}

$pagina = 0;
class PDF extends FPDF
{

  function tabla($sql, $conSql, $Nresul, $NombreEmp, $RFC, $RegisEmp, $periodo, $f1, $f2, $f3, $f4, $cabecera1, $cabecera2, $NomDep, $Ncabecera, $TNom, $IDEmpresa, $LCentro, $bdM, $conSql2)
  {
    $this->SetFillColor(0, 145, 234);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);

    ################################CABECERA DEL PDF#######################################

    $this->Cell(258, 10, $NombreEmp, 0, 0, 'C', false);
    $this->Ln(15);

    $this->SetFont('Arial', '', 10);

    $this->Cell(30, 5, 'RFC ');
    $this->Cell(50, 5, $RFC);
    $this->SetFillColor(30, 185, 59);
    $this->Cell(120, 5, '');//////////////cuadro de colores
    $this->Cell(10, 5, '', 1, 0, 'C', true);//////////////cuadro de colores
    $this->Cell(30, 5, 'Descanso L.', 0, 0, 'R', false);//////////////cuadro de colores
    $this->SetFillColor(0, 145, 234);
    $this->Ln();

    $this->Cell(30, 5, 'REG. PAT ');
    $this->Cell(50, 5, $RegisEmp);
    $this->Cell(100, 5, $NomDep, 0, 0, 'C', false);
    $this->SetFillColor(204, 168, 0);
    $this->Cell(20, 5, ''); //////////////cuadro de colores
    $this->Cell(10, 5, '', 1, 0, 'C', true);//////////////cuadro de colores
    $this->Cell(30, 5, 'Doble T.', 0, 0, 'R', false);//////////////cuadro de colores
    $this->Ln();
    $this->SetFillColor(136, 136, 237);
    $this->Cell(200, 5, '');//////////////cuadro de colores
    $this->Cell(10, 5, '', 1, 0, 'C', true);//////////////cuadro de colores
    $this->Cell(30, 5, 'DT y DL', 0, 0, 'R', false);//////////////cuadro de colores
    $this->SetFillColor(0, 145, 234);
    $this->Ln(5);

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
    $this->Cell(66, 6, '');

    for($i=0; $i<$Ncabecera; $i++){

        $this->Cell(9,6,$cabecera1[0][$i],1,0,'C');
    }
    $this->Ln();

    $this->Cell(10,6,$cabecera2[0][0],1,0,'C', true);
    $this->Cell(50,6,$cabecera2[0][1],1,0,'C', true);
    $this->Cell(6,6,$cabecera2[0][3],1,0,'C', true);
    for($i=4; $i<$Ncabecera+4; $i++){
        $this->Cell(9,6,substr($cabecera2[0][$i], 0, 5),1,0,'C', true);
    }
    $this->Cell(10, 6, 'PP', 1, 0, 'C', true);
    $this->Cell(10, 6, 'PA', 1, 0, 'C', true);
    $this->Cell(30, 6, 'FIRMA', 1, 0, 'C', true);
    $this->Ln();

    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', '', 8);

    $o = 0;
    $lr = 0;


    $consulTR = $conSql->consultaBD($sql);
    if($consulTR['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
    	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulTR['SQLSTATE'].PHP_EOL);
    	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulTR['CODIGO'].PHP_EOL);
    	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulTR['MENSAJE'].PHP_EOL);
    	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$sql.PHP_EOL);
    	fclose($file);
      $resultV['error'] = 1;
      echo json_encode($resultV);
    	/////////////////////////////
    	$conSql->cerrarBD();
    	exit();
    }

    $GLOBALS['pagina'] = 1;

    while ($row=$conSql->obtenResult())
    {
      $lr++;
      $o++;
      $this->Cell(10, 6, $row["codigo"], 1, 0, 'C', true);
      $this->Cell(50, 6, utf8_encode($row["Nombre"]), 1, 0, 'L', true);
      $this->Cell(6, 6, $row["Tpo"], 1, 0, 'C', true);
      foreach (array_keys($row) as $value) {
        if($value == 'codigo' ||	$value == 'Nombre' ||	$value == 'Sueldo' ||	$value == 'Tpo' || $value == 'PAGINA' || $value == 'TOTAL_REGISTROS'){
          //if($value != 'Sueldo'){

          //}
        }else {
          $fechaTitulo = str_replace("/", "-", $value);
          $CONSULTAM = "SELECT
                      (SELECT TOP(1) valor FROM datos WHERE codigo = '".$row['codigo']."' AND nombre = '".$fechaTitulo."' AND periodoP = '".$periodo."' AND tipoN = '".$TNom."' AND IDEmpresa = '".$IDEmpresa."' AND ".$LCentro.") AS 'A',
                      (SELECT TOP(1) valor FROM datosanti WHERE codigo = '".$row['codigo']."' AND nombre = '".$fechaTitulo."' AND periodoP = '".$periodo."' AND tipoN = '".$TNom."' AND IDEmpresa = '".$IDEmpresa."' AND ".$LCentro." AND Autorizo1 = 1) AS 'B',
                      (SELECT TOP(1) codigo FROM deslaborado WHERE fecha = '".$fechaTitulo."' AND periodo = '".$periodo."' AND tipoN = '".$TNom."' AND IDEmpresa = '".$IDEmpresa."' AND codigo = '".$row['codigo']."' AND valor = 1 AND ".$LCentro.") AS 'C',
                      (SELECT TOP(1) codigo FROM dobturno WHERE fecha = '".$fechaTitulo."' AND periodo = '".$periodo."' AND tipoN = '".$TNom."' AND IDEmpresa = '".$IDEmpresa."' AND codigo = '".$row['codigo']."' AND valor = 1 AND ".$LCentro.") AS 'D'";

          $consultMedi = $conSql2->consultaBD2($CONSULTAM);
          if($consultMedi['error'] == 1){
            $file = fopen("log/log".date("d-m-Y").".txt", "a");
          	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
          	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consultMedi['SQLSTATE'].PHP_EOL);
          	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consultMedi['CODIGO'].PHP_EOL);
          	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consultMedi['MENSAJE'].PHP_EOL);
          	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$CONSULTAM.PHP_EOL);
          	fclose($file);
            $resultV['error'] = 1;
            echo json_encode($resultV);
          	/////////////////////////////
          	$conSql->cerrarBD();
          	exit();
          }

          $row2=$conSql2->obtenResult2();
          $conSql2->liberarC2();

          $DesLBD = 0;
          $DobTT = 0;
          $datos = "";
          if(!empty($row2['A'])){
            $datos = $row2['A'];
          }
          if(!empty($row2['B'])){
            $datos = $row2['B'];
          }
          if(!empty($row2['C'])){
            $DesLBD = 1;
          }
          if(!empty($row2['D'])){
            $DobTT = 1;
          }

          if($DesLBD == 1 && $DobTT == 1){
            $this->SetFillColor(136, 136, 237);
          }else if($DesLBD == 1){
            $this->SetFillColor(30, 185, 59);
          }else if($DobTT == 1){
            $this->SetFillColor(204, 168, 0);
          }
          if(empty($row[$value])){
              $this->Cell(9, 6, $datos, 1, 0, 'C', true);
          }else {
            $this->Cell(9, 6, substr($row[$value], 0, 5), 1, 0, 'C', true);
          }

          $this->SetFillColor(255, 255, 255);

        }
      }

      if($row['Tpo'] == "E"){
        if(empty($_POST["pp".$row['codigo']])){
          $this->Cell(10, 6, '', 'LTR', 0, 'L', true);
        }else {
          $this->Cell(10, 6, $_POST["pp".$row['codigo']], 'LTR', 0, 'L', true);
        }

        if(empty($_POST["pa".$row['codigo']])){
          $this->Cell(10, 6, '', 'LTR', 0, 'L', true);
        }else {
          $this->Cell(10, 6, $_POST["pa".$row['codigo']], 'LTR', 0, 'L', true);
        }
        $this->Cell(30, 6, '', 'LTR', 0, 'L', true);
        $this->Ln();
      }else {
        $this->Cell(10, 6, '', 'LRB', 0, 'L', true);
        $this->Cell(10, 6, '', 'LRB', 0, 'L', true);
        $this->Cell(30, 6, '', 'LRB', 0, 'L', true);
        $this->Ln();
      }

    }
    $conSql->liberarC();
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

      $this->Cell(66, 6, '');

      for($i=0; $i<$Ncap; $i++){
          $this->Cell(9,6,$cabecera[0][$i],1,0,'C');
      }
      $this->Ln();
      $this->Cell(10, 6, $cabeceraD[0][0], 1, 0, 'C', true);
      $this->Cell(50, 6, $cabeceraD[0][1], 1, 0, 'C', true);
      $this->Cell(6, 6, $cabeceraD[0][3], 1, 0, 'C', true);
      for($i=4; $i<$Ncap+4; $i++){
          $this->Cell(9,6,substr($cabeceraD[0][$i], 0, 5),1,0,'C', true);
      }
      $this->Cell(10, 6, 'PP', 1, 0, 'C', true);
      $this->Cell(10, 6, 'PA', 1, 0, 'C', true);
      $this->Cell(30, 6, 'FIRMA', 1, 0, 'C', true);
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
$pdf->tabla($SQLT, $objBDSQL, $Nresul, $NombreEmpresa, $RFC, $RegisEmpresa, $periodo, $fecha1, $fecha2, $fecha3, $fecha4, $Cabecera1, $Cabecera2, $NomDep, $Ncabecera, $tipoNom, $IDEmpresa, $LCentro, $bdM, $objBDSQL2);
$pdf->Output('F', Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\Prenomina('.trim ($NomDep, " \t.").').pdf', true);


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

if($Ncabecera > $Nresul){
  $NResultado = $Ncabecera;
}else {
  $NResultado = $Nresul;
}

$queryRTG = $objBDSQL->consultaBD($SQLT);
if($queryRTG['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRTG['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRTG['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRTG['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$SQLT.PHP_EOL);
  fclose($file);
  $resultV['excel'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();

  exit();
}

$o = 0;
$lr = 0;
while ( $row = $objBDSQL->obtenResult() )
{
  if($row['Tpo'] == "E"){

    $CONSULTA = "SELECT fechaO, valor
                 FROM datos
                 WHERE codigo = '".$row['codigo']."'
                 AND periodoP = '$periodo'
                 AND tipoN = '$tipoNom'
                 AND IDEmpresa = '$IDEmpresa'
                 AND ".$LCentro.";";

    $queryRT = $objBDSQL2->consultaBD2($CONSULTA);

    if($queryRT['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$CONSULTA.PHP_EOL);
      fclose($file);
      $resultV['excel'] = 1;
      echo json_encode($resultV);
      /////////////////////////////
      $objBDSQL->cerrarBD();

      exit();
    }

    while($datos = $objBDSQL2->obtenResult2()){
      if(strtoupper($datos['valor']) == "F" || strtoupper($datos['valor']) == "P" || strtoupper($datos['valor']) == "S" || strtoupper($datos['valor']) == "T"){
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row['codigo'])
                                      ->SetCellValue('B'.$FILA, 108)
                                      ->SetCellValue('C'.$FILA, ($row['Sueldo'] * $FactorAu))
                                      ->SetCellValue('D'.$FILA, $datos['fechaO'])
                                      ->SetCellValue('E'.$FILA, $datos['valor'])
                                      ->SetCellValue('F'.$FILA, 1);
        $FILA++;
      }
      $R++;
    }
    $objBDSQL2->liberarC2();

    $CONSULTA = " SELECT codigo, fechaO, valor FROM datosanti AS A
									 WHERE
                   A.codigo = '".$row['codigo']."'
									 AND A.IDEmpresa = '$IDEmpresa'
									 AND A.tipoN = '$tipoNom'
									 AND A.periodoP = '$periodo'
									 AND ".$LCentro."
									 AND NOT EXISTS (SELECT codigo, fechaO, valor
													   FROM datos AS D
													   WHERE A.codigo = D.codigo
													   AND A.fechaO = D.fechaO
													   AND A.IDEmpresa = D.IDEmpresa
													   AND A.periodoP = D.periodoP
													   AND A.Centro = D.Centro)";

   $queryRT = $objBDSQL2->consultaBD2($CONSULTA);

   if($queryRT['error'] == 1){
     $file = fopen("log/log".date("d-m-Y").".txt", "a");
     fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
     fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['SQLSTATE'].PHP_EOL);
     fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['CODIGO'].PHP_EOL);
     fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['MENSAJE'].PHP_EOL);
     fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$CONSULTA.PHP_EOL);
     fclose($file);
     $resultV['excel'] = 1;
     echo json_encode($resultV);
     /////////////////////////////
     $objBDSQL->cerrarBD();

     exit();
   }

   while($datos = $objBDSQL2->obtenResult2()){
     if(strtoupper($datos['valor']) == "F" || strtoupper($datos['valor']) == "P" || strtoupper($datos['valor']) == "S" || strtoupper($datos['valor']) == "T"){
       $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row['codigo'])
                                     ->SetCellValue('B'.$FILA, 108)
                                     ->SetCellValue('C'.$FILA, ($row['Sueldo'] * $FactorAu))
                                     ->SetCellValue('D'.$FILA, $datos['fechaO'])
                                     ->SetCellValue('E'.$FILA, $datos['valor'])
                                     ->SetCellValue('F'.$FILA, 1);
       $FILA++;
     }
   }


  }
}
$objBDSQL->liberarC();
//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'
try {
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\falta('.trim ($NomDep, " \t.").').xls');
} catch (Exception $e) {
  $resultV['excel'] = 1;
  $resultV['archivo'] = "Error al crear el archivo de faltas, Verifique que no este abierto";
  echo json_encode($resultV);
  exit();
}



###################################################################################################################################
##########################################################PP y PA EXCEL############################################################

$objPHPExcel2 = new PHPExcel();
$objReader2 = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel2 = $objReader2->load("plantillaExcel/PP.xls");
$objPHPExcel2->setActiveSheetIndex(0);

$queryJ = $objBDSQL->consultaBD($SQLT);
if($queryJ['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$SQLT.PHP_EOL);
  fclose($file);
  $resultV['excel'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();

  exit();
}

$FILA2 = 2;
while ( $row = $objBDSQL->obtenResult() )
{
    if($row['Tpo'] == "E"){

      $CONSULTA = "SELECT PA, PP
                   FROM premio
                   WHERE codigo = '".$row['codigo']."'
                   AND Periodo = '$periodo'
                   AND TN = '$tipoNom'
                   AND IDEmpresa = '$IDEmpresa'
                   AND ".$LCentro.";";
      $queryRT = $objBDSQL2->consultaBD2($CONSULTA);

      if($queryRT['error'] == 1){
        $file = fopen("log/log".date("d-m-Y").".txt", "a");
        fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
        fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['SQLSTATE'].PHP_EOL);
        fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['CODIGO'].PHP_EOL);
        fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryRT['MENSAJE'].PHP_EOL);
        fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$CONSULTA.PHP_EOL);
        fclose($file);
        $resultV['error'] = 1;
        echo json_encode($resultV);
        /////////////////////////////
        $objBDSQL->cerrarBD();

        exit();
      }

      while($datos = $objBDSQL2->obtenResult2()){
        if(!empty($datos)){
          if($datos['PP'] != "0.00"){
            $objPHPExcel2->getActiveSheet()->SetCellValue('A'.$FILA2, $row['codigo'])
                                            ->SetCellValue('B'.$FILA2, $_POST['pp'])
                                            ->SetCellValue('C'.$FILA2, $datos['PP']);
            $FILA2++;
          }
          if($datos['PA'] != "0.00"){
            $objPHPExcel2->getActiveSheet()->SetCellValue('A'.$FILA2, $row['codigo'])
                                            ->SetCellValue('B'.$FILA2, $_POST['pa'])
                                            ->SetCellValue('C'.$FILA2, $datos['PA']);
            $FILA2++;
          }
        }
      }

      $objBDSQL2->liberarC2();
    }
}
$objBDSQL->liberarC();

try {
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel2, 'Excel5');
  $objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\PP('.trim ($NomDep, " \t.").').xls');

} catch (Exception $e) {
  $resultV['excel'] = 1;
  $resultV['archivo'] = "Error al crear el archivo de PP, Verifique que no este abierto";
  echo json_encode($resultV);
  exit();
}
####################################################################################
#############################GENERAR DESCANSO LABORADO##############################

$objPHPExcel2 = new PHPExcel();
$objReader2 = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel2 = $objReader2->load("plantillaExcel/DLaborado.xls");
$objPHPExcel2->setActiveSheetIndex(0);

$consultaDL = "SELECT codigo, fecha, IDEmpresa FROM deslaborado WHERE periodo = ".$periodo." AND tipoN = ".$tipoNom." AND IDEmpresa = ".$IDEmpresa." AND valor = 1 AND ".$LCentro;
//$query = $bdM->query($consultaDL);
$queryJ = $objBDSQL->consultaBD($consultaDL);
if($queryJ['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaDL.PHP_EOL);
  fclose($file);
  $resultV['excel'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();

  exit();
}
$FILA2 = 1;
while($datosM = $objBDSQL->obtenResult()){

  $querysueldo = "SELECT sueldo
                  FROM empleados
                  WHERE codigo = ".$datosM['codigo']."
                  AND empresa = ".$datosM['IDEmpresa'];
  $Sueldo = "";
  $dat = $objBDSQL2->consultaBD2($querysueldo);
  if($dat['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$dat['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$dat['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$dat['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$querysueldo.PHP_EOL);
    fclose($file);
    $resultV['excel'] = 1;
    echo json_encode($resultV);
    /////////////////////////////
    $objBDSQL->cerrarBD();

    exit();
  }
  $datos = $objBDSQL2->obtenResult2();
  $Sueldo = $datos['sueldo'];
  $objBDSQL2->liberarC2();
  $fcM = str_replace('-', '/', $datosM['fecha']);
  $objPHPExcel2->getActiveSheet()->SetCellValue('A'.$FILA2, $datosM['codigo'])
                                 ->SetCellValue('B'.$FILA2, 10)
                                 ->SetCellValue('C'.$FILA2, $Sueldo)
                                 ->SetCellValue('D'.$FILA2, $fcM)
                                 ->SetCellValue('E'.$FILA2, 8);
  $FILA2++;

}
$objBDSQL->liberarC();

$ConsultaDT = "SELECT codigo,
                      fecha,
                      IDEmpresa
               FROM dobturno
               WHERE periodo = ".$periodo."
               AND tipoN = ".$tipoNom."
               AND IDEmpresa = ".$IDEmpresa."
               AND valor = 1
               AND ".$LCentro;


$queryJ = $objBDSQL->consultaBD($ConsultaDT);
if($queryJ['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJ['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$ConsultaDT.PHP_EOL);
  fclose($file);
  $resultV['excel'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();

  exit();
}
while ($datosM = $objBDSQL->obtenResult()) {
  $querysueldo2 = "SELECT sueldo
                  FROM empleados
                  WHERE codigo = ".$datosM['codigo']."
                  AND empresa = ".$datosM['IDEmpresa'];
  $Sueldo = "";
  $dat = $objBDSQL2->consultaBD2($querysueldo2);
  if($dat['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$dat['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$dat['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$dat['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$querysueldo2.PHP_EOL);
    fclose($file);
    $resultV['excel'] = 1;
    echo json_encode($resultV);
    /////////////////////////////
    $objBDSQL->cerrarBD();

    exit();
  }

  $datos = $objBDSQL2->obtenResult2();
  $Sueldo = $datos['sueldo'];
  $objBDSQL2->liberarC2();
  $fcM = str_replace('-', '/', $datosM['fecha']);
  $objPHPExcel2->getActiveSheet()->SetCellValue('A'.$FILA2, $datosM['codigo'])
                                 ->SetCellValue('B'.$FILA2, 10)
                                 ->SetCellValue('C'.$FILA2, $Sueldo)
                                 ->SetCellValue('D'.$FILA2, $fcM)
                                 ->SetCellValue('E'.$FILA2, 8);
  $FILA2++;
}
$objBDSQL->liberarC();

try {
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel2, 'Excel5');
  $objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\DESCANSOS_LABORADOS('.trim ($NomDep, " \t.").').xls');
} catch (Exception $e) {
  $resultV['excel'] = 1;
  $resultV['archivo'] = "Error al crear el archivo de DESCANSOS LABORADOS, Verifique que no este abierto";
  echo json_encode($resultV);
  exit();
}
###################################################################################
#########################CONCEPTOS EXTRAS##########################################

$objConceptos99 = new PHPExcel();
$objReaderConceptos99 = PHPExcel_IOFactory::createReader('Excel5');
$objConceptos99 = $objReaderConceptos99->load("plantillaExcel/PP.xls");
$objConceptos99->setActiveSheetIndex(0);

$objConceptos = new PHPExcel();
$objReaderConceptos = PHPExcel_IOFactory::createReader('Excel5');
$objConceptos = $objReaderConceptos->load("plantillaExcel/PP.xls");
$objConceptos->setActiveSheetIndex(0);
$FILA2 = 2;
$FILA4 = 2;
/*$sql1 = $bdM->query("DESCRIBE conseptoextra");
$consultaCO = "EXEC sp_columns @table_name = N'conseptoextra'";
$consultaCO2 = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'conseptoextra'";
$objBDSQL->consultaBD($consultaCO);
//Nombre de la columna COLUMN_NAME

  while($datos = $objBDSQL->obtenResult()){
      if($datos['COLUMN_NAME'] != "Codigo" && $datos['COLUMN_NAME'] != "ID" && $datos['COLUMN_NAME'] != "Periodo" && $datos['COLUMN_NAME'] != "IDEmpresa" && $datos['COLUMN_NAME'] != "Centro"){
        $divisor = explode("_", $datos['COLUMN_NAME']);
        $consultaInter = "SELECT Codigo, ".$datos['COLUMN_NAME']." FROM conseptoextra WHERE Periodo = '$periodo' AND ".$LCentro." AND IDEmpresa = '$IDEmpresa' AND ".$datos['COLUMN_NAME']." != '';";
        $objBDSQL2->consultaBD2($consultaInter);
        while($DATTOs = $objBDSQL2->obtenResult2()){
          $divisor = explode("_", $datos['COLUMN_NAME']);
          if($divisor[1] <= 99){
            $objConceptos99->getActiveSheet()->SetCellValue('A'.$FILA2, $DATTOs['Codigo'])
                                           ->SetCellValue('B'.$FILA2, $divisor[1])
                                           ->SetCellValue('C'.$FILA2, $DATTOs[$datos['COLUMN_NAME']]);
            $FILA2++;
          }else if($divisor[1] >= 100 && $divisor[1] <= 199){
            $objConceptos->getActiveSheet()->SetCellValue('A'.$FILA4, $DATTOs['Codigo'])
                                           ->SetCellValue('B'.$FILA4, $divisor[1])
                                           ->SetCellValue('C'.$FILA4, $DATTOs[$datos['COLUMN_NAME']]);
            $FILA4++;
          }

        }
        $objBDSQL2->liberarC2();
      }
  }
$objBDSQL->liberarC();



$objWriter99 = PHPExcel_IOFactory::createWriter($objConceptos99, 'Excel5');
$objWriter99->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\Pagos('.trim ($NomDep, " \t.").').xls');

$objWriterS = PHPExcel_IOFactory::createWriter($objConceptos, 'Excel5');
$objWriterS->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\Descuentos('.trim ($NomDep, " \t.").').xls');
*/

#####################################################################################
##########################VERIFICAR SI LOS ARCHIVOS ESTAN VACIOS ###################

$XLFileType = PHPExcel_IOFactory::identify(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\PP('.trim ($NomDep, " \t.").').xls');
$objReader = PHPExcel_IOFactory::createReader($XLFileType);
$objReader->setLoadSheetsOnly('Hoja1');
$objPHPExcel = $objReader->load(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\PP('.trim ($NomDep, " \t.").').xls');

$objWorksheet = $objPHPExcel->setActiveSheetIndexByName('Hoja1');
if($objPHPExcel->getActiveSheet()->getCell('A2')->getFormattedValue() == ""){
  unlink(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\PP('.trim ($NomDep, " \t.").').xls');
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$XLFileType = PHPExcel_IOFactory::identify(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\falta('.trim ($NomDep, " \t.").').xls');
$objReader = PHPExcel_IOFactory::createReader($XLFileType);
$objReader->setLoadSheetsOnly('Ausentismos_CapturaMasiva');
$objPHPExcel = $objReader->load(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\falta('.trim ($NomDep, " \t.").').xls');

$objWorksheet = $objPHPExcel->setActiveSheetIndexByName('Ausentismos_CapturaMasiva');
if($objPHPExcel->getActiveSheet()->getCell('A2')->getFormattedValue() == ""){
  unlink(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\falta('.trim ($NomDep, " \t.").').xls');
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$XLFileType = PHPExcel_IOFactory::identify(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\DESCANSOS_LABORADOS('.trim ($NomDep, " \t.").').xls');
$objReader = PHPExcel_IOFactory::createReader($XLFileType);
$objReader->setLoadSheetsOnly('Hoja1');
$objPHPExcel = $objReader->load(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\DESCANSOS_LABORADOS('.trim ($NomDep, " \t.").').xls');

$objWorksheet = $objPHPExcel->setActiveSheetIndexByName('Hoja1');
if($objPHPExcel->getActiveSheet()->getCell('A1')->getFormattedValue() == ""){
  unlink(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\DESCANSOS_LABORADOS('.trim ($NomDep, " \t.").').xls');
}
/*
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$XLFileType = PHPExcel_IOFactory::identify(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\Pagos('.trim ($NomDep, " \t.").').xls');
$objReader = PHPExcel_IOFactory::createReader($XLFileType);
$objReader->setLoadSheetsOnly('Hoja1');
$objPHPExcel = $objReader->load(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\Pagos('.trim ($NomDep, " \t.").').xls');

$objWorksheet = $objPHPExcel->setActiveSheetIndexByName('Hoja1');
if($objPHPExcel->getActiveSheet()->getCell('A1')->getFormattedValue() == ""){
  unlink(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\Pagos('.trim ($NomDep, " \t.").').xls');
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$XLFileType = PHPExcel_IOFactory::identify(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\Descuentos('.trim ($NomDep, " \t.").').xls');
$objReader = PHPExcel_IOFactory::createReader($XLFileType);
$objReader->setLoadSheetsOnly('Hoja1');
$objPHPExcel = $objReader->load(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\Descuentos('.trim ($NomDep, " \t.").').xls');

$objWorksheet = $objPHPExcel->setActiveSheetIndexByName('Hoja1');
if($objPHPExcel->getActiveSheet()->getCell('A1')->getFormattedValue() == ""){
  unlink(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\Descuentos('.trim ($NomDep, " \t.").').xls');
}*/


try {
  $objBDSQL->cerrarBD();
  $objBDSQL2->cerrarBD();
} catch (Exception $e) {
  $resultV['excel'] = 1;
  $resultV['archivo'] = 'ERROR al cerrar la conexion con SQL SERVER'.$e->getMessage();
}

  echo json_encode($resultV);

?>
