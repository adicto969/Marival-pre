<?php
$Periodo = $_POST['periodo'];
$tipoNom = $_POST['tipoNom'];
$divCabeFlotante = '<div id="DCF" style="position: relative; opacity: 0;"> <table class="striped highlight centered"><thead><tr>';

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

if($Periodo <= 24){
$_fechas = periodo($Periodo, $tipoNom);
list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $_fechas);
}
if($Periodo > 24 || $tipoNom == 1){
  $objBDSQL = new ConexionSRV();
  $objBDSQL->conectarBD();

  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1',
                          CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2'
                   FROM Periodos
                   WHERE tiponom = 1
                   AND periodo = $Periodo-1
                   AND ayo_operacion = ".$_SESSION['AYO_ACTUAL']."
                   AND empresa = ".$IDEmpresa.";";

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
    $objBDSQL->cerrarBD();
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
                   AND ayo_operacion = ".$_SESSION['AYO_ACTUAL']."
                   AND empresa = ".$IDEmpresa.";";

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
    $objBDSQL->cerrarBD();
    exit();
  }
  $_datos = $objBDSQL->obtenResult();

  $fecha3 = $_datos['FECHA3'];
  $fecha4 = $_datos['FECHA4'];
  $objBDSQL->liberarC();

  $objBDSQL->cerrarBD();
  return $fecha1.",".$fecha2.",".$fecha3.",".$fecha4;
}


$bd1 = new ConexionM();
$bd1->__constructM();
$InsertarPT = "UPDATE config SET PC = '$Periodo', TN = '$tipoNom' WHERE IDUser = '".$_SESSION['IDUser']."';";


#Consulta SQL PARA OBTENER LA CABERCERA

list($dia, $mes, $ayo) = explode('/', $fecha1);
list($diaB, $mesB, $ayoB) = explode('/', $fecha2);

$fecha1 = $ayo.$mes.$dia;
$fecha2 = $ayoB.$mesB.$diaB;

if($DepOsub == 1){
  $querySQL = "[dbo].[reporte_checadas_excel_ctro]
            '".$fecha1."',
            '".$fecha2."',
            '".$centro."',
            '0',
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
  $querySQL = "[dbo].[reporte_checadas_excel_ctro]
            '".$fecha1."',
            '".$fecha2."',
            '".$centro."',
            '0',
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

///////Sacar el tiempo extra
$DteStart = new DateTime('20:19:20');//Este dato se toma de relch_registro de la columna checada
$DteEnd = new DateTime('17:30:00'); //Este dato se toma de la tabla detalle_horarios de la columna sale1

$DteDiff = $DteStart->diff($DteEnd);
//print $DteDiff->format("%H:%i:%S");
///////////


$numCol = $objBDSQL->obtenfilas($querySQL);
if($numCol['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$querySQL.PHP_EOL);
  fclose($file);
  /////////////////////////////
}

if($numCol['cantidad'] > 0){

  ################################################################################
  ######################INSERTAR DATOS NUEVOS TIPONOM y PERIODO###################
  if($bd1->query($InsertarPT)){

  }else {
    echo $bd1->errno. '  '.$bd1->error;
  }

  #################################################################################

  $permisoT = $_SESSION["Permiso"];
  $BTNT = '<button id="btnTGuardar" class="waves-effect waves-light btn" style="margin: 20px;" style="margin: 20px;" onclick="GTiempoExtra()">GENERAR</button>';

  if($permisoT == 1){
    $BTNT = '<button name="generar" id="btnGenerar" class="waves-effect waves-light btn" onclick="GTiempoExtra()" style="margin: 20px;">GENERAR</button>';
  }

  echo '<form method="POST" id="frmTextra">
        <table id="t01" class="responsive-table striped highlight centered" >
        <thead id="Thfija">
        <tr>
        <th colspan="2" id="CdMas" style="background-color: white;
      border-top: 1px solid transparent; border-left: 1px solid transparent;"></th>';

  $primeraC = "";
  $segundaC = "";
  $hiddenC = "";
  $hiddenC2 = "";
  $lr = 0;
  $sumaTiempoExtra = 0;
  $SHORAS = 0;
  $SMINUTOS = 0;
  $datosG = "";
  $conta = 0;
  $objBDSQL->consultaBD($querySQL);
  while($row = $objBDSQL->obtenResult()){
    $lr++;
    $datosG .= '<tr><td class="Aline">'.$row["codigo"].'</td>
          <td class="Aline">'.utf8_encode($row["Nombre"]).'</td>
          ';
    $sumaHoras = 0;
    $primeraC = "";
    $segundaC = "";
    $hiddenC = "";
    $hiddenC2 = "";
    $divCabeFlotante = "";
    $conta = 0;
    foreach (array_keys($row) as  $value) {
      $conta++;
      if($value == "codigo" || $value == "Nombre" || $value == "Sueldo" || $value == "Tpo" || $value == "TOTAL_REGISTROS" || $value == "PAGINA"){

      }else {
        $date = $value;
        $date = str_replace('/', '-', $date);
        $Fecha0 = date('Y-m-d', strtotime($date));
        $dias = array('','LUN','MAR','MIE','JUE','VIE','SAB','DOM');
        $fecha = $dias[date('N', strtotime($Fecha0))];

        $primeraC .= '<th id="CdMas" style="background-color: #00b0ff; border-right: 2px solid black;">'.$fecha.'</th>';
        $hiddenC .= '<input type = "hidden" name="CabeceraD[]" value="'.$fecha.'">';

        $fechaN = $date;
        $valorC = "";
        $valorCF = "";
        $consultaVV = "SELECT Valor, Centro FROM TiempoExtra WHERE Codigo = '".$row["codigo"]."' AND Fecha = '$fechaN' AND Periodo = '$Periodo' AND Tn = '$tipoNom' AND IDEmpresa = '$IDEmpresa' AND Centro = '$centro';";
        $resultC = $objBDSQL2->consultaBD2($consultaVV);
        if($resultC['error'] == 1){
          $file = fopen("log/log".date("d-m-Y").".txt", "a");
          fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
          fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['SQLSTATE'].PHP_EOL);
          fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['CODIGO'].PHP_EOL);
          fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['MENSAJE'].PHP_EOL);
          fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaVV.PHP_EOL);
          fclose($file);
          echo "Ocurrio un error ";
          exit();
        }
        $datosvv = $objBDSQL2->obtenResult2();
        if(!empty($datosvv["Valor"])){
          $valorC = $datosvv["Valor"];
        }

	if(!empty($datosvv["Frente"])){
	  $valorCF = $datosvv["Frente"];
        }

        $sumaHoras += $valorC;
        $datosG .= '<td style="height: 74px;">';
        $datosG .= '<input type="text" style="width:48%; margin-right: 2%;" id="'.$row["codigo"].$conta.'" onkeyup="SumarTiempos(event, this.value, \''.$fechaN.'\', '.count($row).', \''.$row["codigo"].'\')" value="'.$valorC.'">';
        $datosG .= '<input type="text" style="width:48%;" id="'.$row["codigo"].$conta.'frente" onkeyup="AgFrente(event, this.value, \''.$fechaN.'\', '.count($row).', \''.$row["codigo"].'\')" value="'.$valorCF.'" placeholder="Frente" title="Ingrese Frente">';
        $datosG .= '</td>';

      }
      if($value == "Tpo" || $value == "Sueldo" || $value == "TOTAL_REGISTROS" || $value == "PAGINA"){

      }else {
        $divCabeFlotante .= '<th class="Aline" id="thAnchoA'.$conta.'">'.$value.'</th>';
        $segundaC .= '<th class="Aline" id="thAnchoB'.$conta.'">'.$value.'</th>';
        $hiddenC2 .= '<input type = "hidden" name="Cabecera[]" value="'.$value.'">';
      }
    }
    $datosG .= '<td id="totalSuma'.$row["codigo"].'">'.$sumaHoras.'</td>';
    $datosG .= '<td></td>';
    $datosG .= '<td></td>';
    $datosG .= '</tr>';
  }
  echo $primeraC;
  echo '<th colspan="3" id="CdMas" style="background-color: white;
border-top: 1px solid transparent; border-right: 1px solid transparent;"></th></tr>';

  echo '<tr>';
  echo $segundaC;
  echo '<th id="thAFi">T.Ext No Integra</th>';
  echo '<th id="thAFi2">T.Ext Integra</th>';
  echo '<th id="thAFi3">T.Ext Triple</th>';
  echo "</tr></thead><tbody>";


  $divCabeFlotante .= '<th id="thAFi1">T.Ext No Integra</th>';
  $divCabeFlotante .= '<th id="thAFi2">T.Ext Integra</th>';
  $divCabeFlotante .= '<th id="thAFi3">T.Ext Triple</th>';
  $divCabeFlotante .= "</tr></thead></table></div>";

  #Consulta SQL PARA OBTENER EL CONTENIDO

  echo $datosG;


  $Fd = substr($fecha1, 6, 2);
  $Fm = substr($fecha1, 4, 2);
  $Fa = substr($fecha1, 0, 4);

  $F2d = substr($fecha2, 6, 2);
  $F2m = substr($fecha2, 4, 2);
  $F2a = substr($fecha2, 0, 4);

  $fecha1 = $Fd."/".$Fm."/".$Fa;
  $fecha2 = $F2d."/".$F2m."/".$F2a;

  echo '</tbody></table>';
  echo '<input type="hidden" name="Nresul" value="'.$numCol['cantidad'].'"/>';
  echo '<input type="hidden" name="f1" value="'.$fecha1.'"/>';
  echo '<input type="hidden" name="f2" value="'.$fecha2.'"/>';
  echo '<input type="hidden" name="f3" value="'.$fecha3.'"/>';
  echo '<input type="hidden" name="f4" value="'.$fecha4.'"/>';
  echo '<input type="hidden" name="Ncabecera" value="'.$conta.'"/>';
  echo '<input type="hidden" name="periodo" value="'.$Periodo.'" id="periodo"/>';
  echo '<input type="hidden" name="NomDep" value="'.$NomDep.'"/>';
  echo '<input type="hidden" name="pp" value="'.$PP.'" id="hPP"/>';
  echo '<input type="hidden" name="pa" value="'.$PA.'" id="hPA"/>';
  echo '<input type="hidden" name="tipoNom" value="'.$tipoNom.'"/>';
  echo '<input type="hidden" name="centro" value="'.$centro.'" id="centro"/>';
  echo $hiddenC;
  echo $hiddenC2;
  echo '</form>';
  echo $BTNT;
  try {
    $objBDSQL->cerrarBD();
    $objBDSQL2->cerrarBD();
    $bd1->close();
  } catch (Exception $e) {
    echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
  }
}else {
  if($bd1->query($InsertarPT)){

  }else {
    echo $bd1->errno. '  '.$bd1->error;
  }

  try {
    $objBDSQL->cerrarBD();
    $objBDSQL2->cerrarBD();
    $bd1->close();
  } catch (Exception $e) {
    echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
  }
  echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}
 ?>
