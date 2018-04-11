<?php
require_once('librerias/pdf/fpdf.php');
$cantidad = $_POST["cantidad"];

$resultV = array();
$resultV['error'] = 0;
$resultV['exito'] = 0;


$Carpeta = "quincenal";
if($TN == 1){
  $Carpeta = "semanal";
}

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
 if($DepOsub == 1)
 {
   $querySQL = "[dbo].[roldehorarioEmp]
               '".$IDEmpresa."',
               '".$centro."',
               '1'";

  $ComSql = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
 }else {
   $querySQL = "[dbo].[roldehorarioEmp]
               '".$IDEmpresa."',
               '".$centro."',
               '0'";
  $ComSql = "centro = '".$centro."'";
 }



 for($m=1; $m<=$cantidad; $m++){
   $Minsert = "UPDATE Llaves SET horario = '".$_POST["inp".$m]."' WHERE codigo = '".$_POST["c".$m]."' AND empresa = '".$IDEmpresa."' AND ".$ComSql.";";
   $resultC = $objBDSQL->consultaBD($Minsert);
   if($resultC['error'] == 1){
     $file = fopen("log/log".date("d-m-Y").".txt", "a");
   	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
   	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['SQLSTATE'].PHP_EOL);
   	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['CODIGO'].PHP_EOL);
   	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['MENSAJE'].PHP_EOL);
   	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$Minsert.PHP_EOL);
   	fclose($file);
   	$resultV['error']++;
   }else {
     $resultV['exito']++;
   }
 }

 $pagina = 0;
 class PDF extends FPDF{
   function tabla($querySQL, $NombreEmp, $objBDSQL, $NomDep){

    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);

    ////////////////////// CABECERA DEL DOCUMENTO /////////////////////////////
    $this->Cell(256, 10, $NombreEmp, 0, 0, 'C', false);
    $this->Ln(10);
    $this->Cell(256, 10, $NomDep, 0, 0, 'C', false);
    $this->Ln(10);

    $this->SetFont('Arial', '', 10);

    //$this->Cell(10, 6, '', 0, 0, 'C', false);
    $this->Cell(256, 10, 'DEL '.$_POST['Dia'].' AL '.$_POST['Dia2'].' DE '.$_POST['Mes'].' DEL '.$_POST['Ayo'], 0, 0, 'C', false);
    $this->Ln(10);

    $this->Ln(20);

    $GLOBALS['pagina'] = 1;
    $this->SetFillColor(0, 145, 234);
    $this->SetTextColor(255, 255, 255);
    $this->SetFont('Times', '', 8);
    $this->Cell(10, 6, 'Codigo', 'LTR', 0, 'C', true);
    $this->Cell(60, 6, 'Nombre', 'LTR', 0, 'C', true);
    $this->Cell(60, 6, 'Descripcion', 1, 0, 'C', true);
    $this->Cell(18, 6, 'LUNES', 1, 0, 'C', true);
    $this->Cell(18, 6, 'MARTES', 1, 0, 'C', true);
    $this->Cell(18, 6, 'MIERCOLES', 1, 0, 'C', true);
    $this->Cell(18, 6, 'JUEVES', 1, 0, 'C', true);
    $this->Cell(18, 6, 'VIERNES', 1, 0, 'C', true);
    $this->Cell(18, 6, 'SABADO', 1, 0, 'C', true);
    $this->Cell(18, 6, 'DOMINGO', 1, 0, 'C', true);
    $this->Ln();

    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', '', 8);
    $objBDSQL->consultaBD($querySQL);
    while ( $row = $objBDSQL->obtenResult() )
     {

         if(empty($row["codigo"])){
             $this->Cell(10, 6, '', 1, 0, 'C', false);
         }else{
             $this->Cell(10, 6, $row["codigo"], 1, 0, 'C', false);
         }

         if(empty($row["nomE"])){
             $this->Cell(60, 6, '', 1, 0, 'L', false);
         }else{
             $this->Cell(60, 6, utf8_decode($row["nomE"]), 1, 0, 'L', false);
         }
         $this->SetFillColor(255, 255, 255);
         if(empty($row["Nombre"])){
             $this->Cell(60, 6, '', 1, 0, 'L', true);
         }else{
             $this->Cell(60, 6, utf8_decode($row["Nombre"]), 1, 0, 'L', true);
         }

         $this->SetFillColor(249, 255, 0);
         $this->SetTextColor(0);

         if($row["LUN"] == "DESCANSO"){
             $this->Cell(18, 6, utf8_decode($row["LUN"]), 1, 0, 'C', true);
         }else{
             $this->Cell(18, 6, utf8_decode($row["LUN"]), 1, 0, 'C', false);
         }

         if($row["MAR"] == "DESCANSO"){
             $this->Cell(18, 6, utf8_decode($row["MAR"]), 1, 0, 'C', true);
         }else{
             $this->Cell(18, 6, utf8_decode($row["MAR"]), 1, 0, 'C', false);
         }
         if($row["MIE"] == "DESCANSO"){
             $this->Cell(18, 6, utf8_decode($row["MIE"]), 1, 0, 'C', true);
         }else{
             $this->Cell(18, 6, utf8_decode($row["MIE"]), 1, 0, 'C', false);
         }
         if($row["JUE"] == "DESCANSO"){
             $this->Cell(18, 6, utf8_decode($row["JUE"]), 1, 0, 'C', true);
         }else{
             $this->Cell(18, 6, utf8_decode($row["JUE"]), 1, 0, 'C', false);
         }
         if($row["VIE"] == "DESCANSO"){
             $this->Cell(18, 6, utf8_decode($row["VIE"]), 1, 0, 'C', true);
         }else{
             $this->Cell(18, 6, utf8_decode($row["VIE"]), 1, 0, 'C', false);
         }
         if($row["SAB"] == "DESCANSO"){
             $this->Cell(18, 6, utf8_decode($row["SAB"]), 1, 0, 'C', true);
         }else{
             $this->Cell(18, 6, utf8_decode($row["SAB"]), 1, 0, 'C', false);
         }
         if($row["DOM"] == "DESCANSO"){
             $this->Cell(18, 6, utf8_decode($row["DOM"]), 1, 0, 'C', true);
         }else{
             $this->Cell(18, 6, utf8_decode($row["DOM"]), 1, 0, 'C', false);
         }
         $this->Ln();
     }
     $objBDSQL->liberarC();
     $this->SetFillColor(255, 255, 255);

   }

   function Header(){
     if($GLOBALS['pagina'] == 1 ){

        $this->SetFillColor(0, 145, 234);
        $this->SetTextColor(255);

        $this->Cell(10, 6, 'Codigo', 'LTR', 0, 'C', true);
        $this->Cell(60, 6, 'Nombre', 'LTR', 0, 'C', true);
        $this->Cell(60, 6, 'Descripcion', 1, 0, 'C', true);
        $this->Cell(18, 6, 'LUNES', 1, 0, 'C', true);
        $this->Cell(18, 6, 'MARTES', 1, 0, 'C', true);
        $this->Cell(18, 6, 'MIERCOLES', 1, 0, 'C', true);
        $this->Cell(18, 6, 'JUEVES', 1, 0, 'C', true);
        $this->Cell(18, 6, 'VIERNES', 1, 0, 'C', true);
        $this->Cell(18, 6, 'SABADO', 1, 0, 'C', true);
        $this->Cell(18, 6, 'DOMINGO', 1, 0, 'C', true);
        $this->Ln();
        $this->SetFillColor(255, 255, 255 );
        $this->SetTextColor(0);

        parent::Header();
    }
   }

   function footer(){
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
   }

 }

$pdf = new PDF('L', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 8);
$pdf->AddPage();
$pdf->tabla($querySQL, $NombreEmpresa, $objBDSQL, $NomDep);
$pdf->Output('F', Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\ROL('.trim ($NomDep, " \t.").').pdf', true);
//'F', $unidad.'Faltas'.date("d-m-Y-s").'.pdf', true
echo json_encode($resultV);
$objBDSQL->cerrarBD();
?>
