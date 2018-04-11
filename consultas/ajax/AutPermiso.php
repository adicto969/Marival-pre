<?php
require_once('ClassImpFormatos.php');

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$Carpeta = "quincenal";

if($TN == 1){
  $Carpeta = "semanal";
}

$ID = $_POST['ID'];
$CodEmp = $_POST['codEmp'];
$fechhh = $_POST['FF'];
if(!empty($_POST['AU'])){
    $AU = $_POST['AU'];
    if($AU == 2){
      $AU = 0;
    }
    $InsertarTNT = "UPDATE datosanti SET Autorizo1 = $AU WHERE ID = $ID ;";
}

if(!empty($_POST['AU2'])){
    $AU2 = $_POST['AU2'];
    if($AU2 == 2){
      $AU2 = 0;
    }
    $InsertarTNT = "UPDATE datosanti SET Autorizo2 = $AU2 WHERE ID = $ID ;";
}

$consulta = $objBDSQL->consultaBD($InsertarTNT);
if($consulta['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$InsertarTNT.PHP_EOL);
  fclose($file);
}else {
    $consultaMs = "SELECT valor FROM datosanti WHERE Autorizo1 = 1 AND Autorizo2 = 1 AND valor = 'PG' AND ID = $ID ;";
    $resultR = $objBDSQL->obtenfilas($consultaMs);
    if($resultR['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultR['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultR['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultR['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaMs.PHP_EOL);
      fclose($file);
    } else {
      if($resultR['cantidad'] >= 1){
        $querySS = "SELECT E.nombre + ' ' + E.ap_paterno + ' ' + E.ap_materno AS Nombre, E.codigo, C.nomdepto
                    FROM empleados AS E
                    INNER JOIN Llaves AS L ON L.codigo = E.codigo
                    INNER JOIN centros AS C ON C.centro = L.centro AND C.empresa = L.empresa
                    WHERE E.codigo = '".$CodEmp."' AND E.empresa = $IDEmpresa;";

        $rs = odbc_exec($bdS, $querySS);
        $resultE = $objBDSQL->consultaBD($querySS);
        if($resultE['error'] == 1){
          $file = fopen("log/log".date("d-m-Y").".txt", "a");
          fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
          fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultE['SQLSTATE'].PHP_EOL);
          fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultE['CODIGO'].PHP_EOL);
          fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultE['MENSAJE'].PHP_EOL);
          fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$querySS.PHP_EOL);
          fclose($file);
        }else {
          $datos = $objBDSQL->obtenResult();
          $pdfImp = new PDF('P', 'mm', 'Letter');
          $pdfImp->AliasNbPages();
          $pdfImp->SetFont('Arial', '', 8);
          $pdfImp->AddPage();
          $pdfImp->tablePermiso($NombreEmpresa, utf8_encode($datos["Nombre"]), $datos["codigo"], utf8_encode($datos["nomdepto"]), $fechhh);
          //$pdfImp->Output('F', Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\PruebaPermiso.pdf');
          $pdfImp->Output('F', "Temp/tempPP.pdf");
          echo "1";
        }
        //$consultaFechas = "SELECT nombre FROM datosanti WHERE Autorizo1 = 1 AND Autorizo2 = 1 AND valor = 'PG' AND codigo = $CodEmp AND ;";


      }
    }
}


?>
