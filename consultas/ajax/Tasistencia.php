<?php
 set_time_limit(6000);
//////////////// VARIABLES ///////////////
$_periodo = $_POST['periodo'];
$_tipoNom = $_POST['tipoNom'];
$diasAnteO = false;

$resultV = array();
$resultV['TotalRegistros'] = 0;
$resultV['paginas'] = 0;
$resultV['error'] = 0;
$resultV['contenido'] = '';
$resultV['NumeroResultado'] = 0;

$pagina = $_POST['pagina'];
$cantidadXpagina = $_POST['cantidadXpagina'];
$ordernar = $_POST["order"];
$busqueda = "";
$busquedaV = "";
$sumaDias = 0;
$textExtraPro = "";

if(isset($_POST['buscar'])){
  if(!empty($_POST['buscar'])){
    $busqueda = "AND (E.codigo LIKE ''%".$_POST['buscar']."%''";
    $busqueda .= " OR E.ap_paterno LIKE ''%".$_POST['buscar']."%''";
    $busqueda .= " OR E.ap_materno LIKE ''%".$_POST['buscar']."%''";
    $busqueda .= " OR E.nombre LIKE ''%".$_POST['buscar']."%'')";
    $busquedaV = $_POST['buscar'];
  }
}

if(isset($_POST['obtenDiasAnt'])){
	if(!empty($_POST['obtenDiasAnt']) && $_POST['obtenDiasAnt'] == 'true'){
	    $diasAnteO = true;
	}
}

if($cantidadXpagina == "TODO"){
  $cantidadXpagina = 1;
}else {
  $textExtraPro = "WHERE ROW_NUM BETWEEN (".$pagina." - 1) * ".$cantidadXpagina." + 1 AND (".$pagina." - 1) * ".$cantidadXpagina." + ".$cantidadXpagina;
}

$_permisoT = $_SESSION["Permiso"];
$_dias = array('', 'LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB', 'DOM');
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$BDM = new ConexionM();
$BDM->__constructM();
$_HTML = "";
$_BTNS = '';
$_nResultados = 1;

$_cabecera = "<tr>";
$_cabeceraD = "<tr><th></th><th></th><th></th><th></th>";
$_cabeceraD = '<tr>
<th colspan="4" id="CdMas" style="background-color: white;
border-top: 1px solid transparent; border-left: 1px solid transparent;"></th>';
$_cuerpo = "";
$_Fecha0 = "";
$_FechaPar = "";
$_DiaNumero = "";
$_FechaND = "";
$_FechaCol = "";
$_date = "";
$_FechaNDQ = "";
$_queryDatos = "";
$_NumColumnas = 0;
$_NumResultado = 0;
$_tmp_E_valor = "";
$_valorC = "";
$_colorF = "";
$_arrayCabeceraD = "";
$_arrayCabeceraF = "";
$_PPPA = explode('|', "0|0");
$_PPPAempleado = explode('|', "0|0");
$_PDOM_DLabora = explode('|', "0|0");
/////////////////////////////////////////
/////////////// PERIODOS ///////////////
if($_periodo <= 24){
	$_fechas = periodo($_periodo, $_tipoNom);
	list($_fecha1, $_fecha2, $_fecha3, $_fecha4) = explode(',', $_fechas);
}

if($_tipoNom == 1 || $_periodo > 24)
{
  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1',
                          CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2'
                   FROM Periodos
                   WHERE tiponom = 1
                   AND periodo = $_periodo-1
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

  $_fecha1 = $_datos['FECHA1'];
  $_fecha2 = $_datos['FECHA2'];
  $objBDSQL->liberarC();

  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA3',
                          CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA4'
                   FROM Periodos
                   WHERE tiponom = 1
                   AND periodo = $_periodo
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

  $_fecha3 = $_datos['FECHA3'];
  $_fecha4 = $_datos['FECHA4'];
  $objBDSQL->liberarC();
}
if(empty($_fecha1)){
  $_fecha1 = "05/08/1993";
}
if(empty($_fecha2)){
  $_fecha2 = "05/08/1993";
}
if(empty($_fecha3)){
  $_fecha3 = "05/08/1993";
}
if(empty($_fecha4)){
  $_fecha4 = "05/08/1993";
}
///////////////CONSULTA GENERAL ////////
list($_dia, $_mes, $_ayo) = explode('/', $_fecha1);
list($_diaB, $_mesB, $_ayoB) = explode('/', $_fecha2);
list($_diaC, $_mesC, $_ayoC) = explode('/', $_fecha3);

$_fecha1 = $_ayo.$_mes.$_dia;
$_fecha2 = $_ayoB.$_mesB.$_diaB;

############FORMATO PARA AUMENTAR FECHA #############
$fechAumen = $_ayoC."/".$_mesC."/".$_diaC;
#####################################################
///////////////INCRUSTRAR CHECADAS//////////
$Jcodigos = file_get_contents("datos/empleados.json");
$datosJSON = json_decode($Jcodigos, true);
$contarJSON = count($datosJSON["empleados"]);
$dateInc = $_ayo.'/'.$_mes.'/'.$_dia;

$varificarIns = true;
for($j = 0; $j <= $contarJSON - 1; $j++){
  if($datosJSON["empleados"][$j]["estado"] == 1){
    $randon = rand(0, 15);
    $hora = strtotime($datosJSON["empleados"][$j]["hora"]);
    $horaParse = (date('H:i:s', $hora));
    $hora2 = strtotime($datosJSON["empleados"][$j]["hora2"]);
    $hora2Parse = (date('H:i:s', $hora2));
    //RECORRER DOS FECHAS
    for($i=0; $i<=31; $i++){
      $fechaS = date("d/m/Y", strtotime($dateInc." + ".$i." day"));
      list($dia, $mes, $ayo) = explode('/', $fechaS);
      $fConsulta = $ayo.$mes.$dia;
      $fComp = explode('/', $fechaS);
      $FMK = mktime(0,0,0,$fComp[1],$fComp[0],$fComp[2]);
      $FMK2 = mktime(0,0,0,$_mesB, $_diaB, $_ayoB);
      if($FMK <= $FMK2){
        //CONFIRMAR QUE NO EXISTE ENTRADA
        $consultaChecada = "SELECT R.checada
                            FROM relch_registro AS R
                            WHERE R.fecha = '".$fConsulta."'
                            AND R.codigo = ".$datosJSON["empleados"][$j]["codigo"]."
                            AND R.empresa = ".$datosJSON["empleados"][$j]["empresa"]."
                            AND R.checada <> '00:00:00'
                            AND (R.EoS = '1' OR R.EoS = 'E' OR R.EoS IS NULL);";

        $_resultados = $objBDSQL->consultaBD($consultaChecada);
        if($_resultados === false)
        {
            die(print_r(sqlsrv_errors(), true));
            break;
        }else {
            $objBDSQL->liberarC();
            $_datos = $objBDSQL->obtenResult();
            if(empty($_datos)){
              $fechaInst = date("Ymd", $FMK);
              $fchora = strtotime('+'.rand(0, 15).' minute', strtotime($horaParse));
              $horainsert = date('H:s:i', $fchora);
              $checadaEntrada = "ObtenRelojDatosEmps ".$datosJSON["empleados"][$j]["empresa"].", ".$datosJSON["empleados"][$j]["codigo"].", '".$fechaInst."', '".$horainsert."', 'N', ' ', ' '";
              try {
                $insertChecada = $objBDSQL->consultaBD($checadaEntrada);
                if($insertChecada){
                  $file = fopen("datos/insertSS.txt", "w");
                  fwrite($file, 1);
                  fclose($file);
                }else {
                  $verificacion = false;
                }
              }catch(Exception $e){
                var_dump($e->getMessage());
              }
              //$objBDSQL->liberarC();
            }
        }

        ////////////////////CONFIRMAR QUE NO EXISTE UNA SALIDA
        $consultaChecada0 = "SELECT R.checada
                            FROM relch_registro AS R
                            WHERE R.fecha = '".$fConsulta."'
                            AND R.codigo = ".$datosJSON["empleados"][$j]["codigo"]."
                            AND R.empresa = ".$datosJSON["empleados"][$j]["empresa"]."
                            AND R.checada <> '00:00:00'
                            AND (R.EoS = '2' OR R.EoS = 'S' OR R.EoS IS NULL);";
        $_resultados = $objBDSQL->consultaBD($consultaChecada);
        if($_resultados === false)
        {
            die(print_r(sqlsrv_errors(), true));
            break;
        }else {
            $objBDSQL->liberarC();
            $_datos = $objBDSQL->obtenResult();
            if(empty($_datos)){
              $fechaInst = date("Ymd", $FMK2);
              $fchora = strtotime('+'.rand(0, 15).' minute', strtotime($hora2Parse));
              $horainsert = date('H:s:i', $fchora);
              $checadaEntrada = "ObtenRelojDatosEmps ".$datosJSON["empleados"][$j]["empresa"].", ".$datosJSON["empleados"][$j]["codigo"].", '".$fechaInst."', '".$horainsert."', 'N', ' ', ' '";
              try {
                $insertChecada = $objBDSQL->consultaBD($checadaEntrada);
                if($insertChecada){
                  $file = fopen("datos/insertSS.txt", "w");
                  fwrite($file, 1);
                  fclose($file);
                }else {
                  $verificacion = false;
                }
              }catch(Exception $e){
                var_dump($e->getMessage());
              }
              //$objBDSQL->liberarC();
            }
        }

      }
    }
  }
}

if($varificarIns == false){
  $resultV['contenido'] .= "<script >alert ('ERROR - Verifica los parametros de los empleados(cargarChecadas)');</script>";
}
///////////////////////////////////////////

if($DepOsub == 1)
{
  $queryGeneral = "
  [dbo].[reporte_checadas_excel_ctro]
  '".$_fecha1."',
  '".$_fecha2."',
  '".$centro."',
  '".$supervisor."',
  '".$IDEmpresa."',
  '".$_tipoNom."',
  'LEFT (L.centro, 10) = LEFT (''".$centro."'', ".$MascaraEm.")',
  '1',
  '".$pagina."',
  '".$cantidadXpagina."',
  '".$busqueda."',
  '".$textExtraPro."',
  '".$ordernar."'
  ";
  $ComSql = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $queryGeneral = "
  [dbo].[reporte_checadas_excel_ctro]
  '".$_fecha1."',
  '".$_fecha2."',
  '".$centro."',
  '".$supervisor."',
  '".$IDEmpresa."',
  '".$_tipoNom."',
  'L.centro = ''".$centro."''',
  '0',
  '".$pagina."',
  '".$cantidadXpagina."',
  '".$busqueda."',
  '".$textExtraPro."',
  '".$ordernar."'";
  $ComSql = "Centro = '".$centro."'";
}
/////////////Periodo y TipoNomina/////////
$_UPDATEPYT = "UPDATE config SET PC = $_periodo, TN = $_tipoNom WHERE IDUser = '".$_SESSION['IDUser']."';";
try{
  if($BDM->query($_UPDATEPYT)){

  }else {
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
  	fwrite($file, ":::::::::::::::::::::::ERROR MQL:::::::::::::::::::::::".PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - ERROR: '.$BDM->errno.PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - ERROR: '.$BDM->error.PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
  	fclose($file);
  	$resultV['error'] = 1;
  	echo json_encode($resultV);
  	/////////////////////////////
  	exit();
  }
}catch (\Exception $e){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::TRY CATCH(Tasistencia.php LINEA 283):::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - ERROR: '.$e.PHP_EOL);
  fclose($file);
  $resultV['error'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  exit();
}


//////////ACTUALIZAR FRENTES ////////////////

if(date($_fecha1) >= date("Ymd")){
    $SELECTJUEVES = "SELECT Codigo, JUE FROM relacionempfrente";
    $queryJueves = $objBDSQL->consultaBD($SELECTJUEVES);

    if($queryJueves['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
    	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJueves['SQLSTATE'].PHP_EOL);
    	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJueves['CODIGO'].PHP_EOL);
    	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$queryJueves['MENSAJE'].PHP_EOL);
    	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$SELECTJUEVES.PHP_EOL);
    	fclose($file);
    	$resultV['error'] = 1;
    	echo json_encode($resultV);
    	/////////////////////////////
    	$objBDSQL->cerrarBD();
    	$objBDSQL2->cerrarBD();

    	exit();
    }

    while ($row = $objBDSQL->obtenResult()) {
      $codigoJue = $row["Codigo"];
      $Juev = ltrim(rtrim($row["JUE"]));
      $UPDATEFRENTES = "UPDATE relacionempfrente SET LUN = '".$Juev."', MAR = '".$Juev."', MIE = '".$Juev."', VIE = '".$Juev."', SAB = '".$Juev."', DOM = '".$Juev."' WHERE Codigo = '".$codigoJue."';";
      $resultK = $objBDSQL->consultaBD($UPDATEFRENTES);

      if($resultK['error'] == 1){
        $file = fopen("log/log".date("d-m-Y").".txt", "a");
      	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultK['SQLSTATE'].PHP_EOL);
      	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultK['CODIGO'].PHP_EOL);
      	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultK['MENSAJE'].PHP_EOL);
      	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$UPDATEFRENTES.PHP_EOL);
      	fclose($file);
      	$resultV['error'] = 1;
      	echo json_encode($resultV);
      	/////////////////////////////
      	$objBDSQL->cerrarBD();
      	$objBDSQL2->cerrarBD();

      	exit();
      }
    }
}

////////////BOTONES DE GUARDAR EDITAR GENERAR ETC.//////////////
$consultaEstatus = "SELECT estado FROM estatusPeriodo WHERE periodo = $_periodo AND tipoNom = $_tipoNom";
$bloquear = '';
$resultC = $objBDSQL->consultaBD($consultaEstatus);

if($resultC['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultC['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaEstatus.PHP_EOL);
  fclose($file);
  $resultV['error'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();
  $objBDSQL2->cerrarBD();

  exit();
}

$estadoP = $objBDSQL->obtenResult();
$objBDSQL->liberarC();
if($estadoP['estado'] == 1){
		$bloquear = 'disabled="disabled"';
	$_BTNS = '<button name="generar" id="btnGenerar" class="waves-effect waves-light btn" onclick="GTasistencia()" style="margin: 20px;">GENERAR</button> <button name="cierre" class="waves-effect waves-light btn" style="margin: 20px;" onclick="CerrarT(0)">HABILITAR</button>';
	if($_permisoT == 0){
		$_BTNS = '<button name="generar" id="btnGenerar" class="waves-effect waves-light btn" onclick="GTasistencia()" style="margin: 20px;">GENERAR</button> <button name="cierre" disabled="disabled" class="waves-effect waves-light btn" style="margin: 20px;">HABILITAR</button>';
	}
}else if($estadoP['estado'] == 0 || empty($estadoP['estado'])){
	$_BTNS = '<button name="generar" id="btnGenerar" class="waves-effect waves-light btn" onclick="GTasistencia()" style="margin: 20px;">GENERAR</button> <button name="cierre" class="waves-effect waves-light btn" style="margin: 20px;" onclick="CerrarT(1)">CERRAR</button>';
		$bloquear = '';
}

///////////////////////////////////////////////////////////////

$_HTML = '
      <div style="display:flex;width: auto;float: right;border: 1px solid rgba(0, 0, 0, .2);">
        <div onclick="ant();" style="padding: 10px 13px 0px 13px;border-right: 1px solid rgba(0, 0, 0, 0.2);cursor: pointer;"><i class="material-icons">chevron_left</i></div>
        <div style="padding: 10px 13px 0 13px;" id="paginador">1 de 10</div>
        <div onclick="sig();" style="padding: 10px 13px 0px 13px;border-left: 1px solid rgba(0,0,0,.2);cursor: pointer;"><i class="material-icons">chevron_right</i></div>
      </div>
      <a class="dropdown-button btn" id="down-ver" data-beloworigin="true" data-activates="ver" style="float: right; background-color: white; color: black;box-shadow:  none !important;border: 1px solid rgba(0, 0, 0, .2);padding-bottom: 39px;">
        Ver
        <i class="large material-icons">arrow_drop_down</i>
      </a>
      <ul id="ver" class="dropdown-content" style="min-width: 10px !important;">
        <li><a onclick="Mostrarcanti(20)">20</a></li>
        <li><a onclick="Mostrarcanti(50)">50</a></li>
        <li><a onclick="Mostrarcanti(100)">100</a></li>
        <li><a onclick="Mostrarcanti(300)">300</a></li>
        <li><a onclick="Mostrarcanti(500)">500</a></li>
        <li><a onclick="Mostrarcanti(\'TODO\')">Todos</a></li>
      </ul>
      <div class="input-field col s6" style="max-width: 211px;margin-left: 20px;">
        <input id="buscarV" type="text" class="validate" style="width: 164px; padding-top: 5px" value="'.$busquedaV.'">
        <i class="material-icons prefix" onclick="busquedaF()" style="line-height: 39px;text-align: center;border: 1px solid rgba(0, 0, 0, .2);cursor:pointer;">search</i>
      </div>

      <form method="POST" id="frmTasis">
      <div id="Sugerencias" style="position: fixed; left: 0; top: -3px; padding-top: 15px; margin-bottom: 0; z-index: 998;"></div>
      <table id="t01" class="responsive-table striped highlight centered" >
      <thead id="Thfija">';

$conResult = $objBDSQL->consultaBD($queryGeneral);

if($conResult['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$conResult['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$queryGeneral.PHP_EOL);
  fclose($file);
  $resultV['error'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();
  $objBDSQL2->cerrarBD();

  exit();
}

while ($row=$objBDSQL->obtenResult()) {
  $resultV['TotalRegistros'] = $row["TOTAL_REGISTROS"];
  $resultV['paginas'] = $row["PAGINA"];
  $resultV['NumeroResultado']++;

  $_NumResultado++;
  $_cuerpo .= "<tr>";
    foreach (array_keys($row) as $value) {
      if($_nResultados==1){
        if($value == 'codigo' ||	$value == 'Nombre' ||	$value == 'Sueldo' ||	$value == 'Tpo' || $value == 'TOTAL_REGISTROS' || $value == 'PAGINA'){

        }else {
          $_date = str_ireplace('/', '-', $value);
          $_Fecha0 = date('Y-m-d', strtotime($_date));
          $_FechaND = $_dias[date('N', strtotime($_Fecha0))];
          $_cabeceraD .= "<th><a title='Doble Click para generar faltas de este dia' style='color: black; cursor: pointer;' ondblclick='GFaltas(\"".$value."\")'>".$_FechaND."</a></th>";
          $_NumColumnas++;
          $_arrayCabeceraD .= '<input type = "hidden" name="CabeceraD[]" value="'.$_FechaND.'">';
        }

        if($value == 'TOTAL_REGISTROS' || $value == 'PAGINA'){

        }else {
          $_cabecera .= "<th>".$value."</th>";
          $_arrayCabeceraF .= '<input type = "hidden" name="Cabecera[]" value="'.$value.'">';
        }
      }

      if($value == 'TOTAL_REGISTROS' || $value == 'PAGINA'){

      }else if($value == 'codigo' ||	$value == 'Nombre' ||	$value == 'Sueldo' ||	$value == 'Tpo'){
        $_cuerpo .= "<td>".utf8_encode($row[$value])."</td>";
      }else {
        $tmp_valorC = "";
        $_FechaCol = str_replace("/", "-", $value);
        $_FechaPar = date('Y-m-d', strtotime($_FechaCol));
        $_DiaNumero = date('N', strtotime($_FechaPar));
        if($_DiaNumero == 1){
            $_FechaNDQ = $_dias[6];
        }else {
            $_FechaNDQ = $_dias[$_DiaNumero-1];
        }

        $_queryDatos = "
          SELECT
            (SELECT TOP(1) valor FROM datosanti WHERE codigo = '".$row['codigo']."' AND nombre = '".str_replace("/", "-", $value)."' and periodoP = '".$_periodo."' and tipoN = '".$_tipoNom."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql.") AS 'A',
            (SELECT TOP(1) valor FROM datos WHERE codigo = '".$row['codigo']."' AND nombre = '".str_replace("/", "-", $value)."' and periodoP = '".$_periodo."' and tipoN = '".$_tipoNom."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql.") AS 'B',
            (SELECT TOP(1) valor FROM datosanti WHERE codigo = '".$row['codigo']."' AND nombre = '".str_replace("/", "-", $value)."' and periodoP = '".$_periodo."' and tipoN = '".$_tipoNom."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql." and Autorizo1 = 1) AS 'C',
            (SELECT TOP(1) valor FROM dobTurno WHERE codigo = '".$row['codigo']."' AND fecha = '".str_replace("/", "-", $value)."' and periodo = '".$_periodo."' and tipoN = '".$_tipoNom."' AND IDEmpresa = '".$IDEmpresa."' AND ".$ComSql.") AS 'D',
            (SELECT TOP(1) valor FROM deslaborado WHERE codigo = ".$row['codigo']." AND fecha = '".str_replace("/", "-", $value)."' AND periodo = $_periodo AND tipoN = $_tipoNom AND IDEmpresa = '".$IDEmpresa."' AND ".$ComSql.") AS 'E',
            (SELECT TOP(1) (Convert(varchar(5), PP)+'|'+Convert(varchar(5), PA)) as 'B' FROM premio WHERE codigo = '".$row['codigo']."' and Periodo = '".$_periodo."' and TN = '".$_tipoNom."' and ".$ComSql." and IDEmpresa = '".$IDEmpresa."') AS 'F',
            (SELECT TOP(1) (Convert(varchar(5), PP)+'|'+Convert(varchar(5), PA)) as 'B' FROM ajusteempleado WHERE IDEmpleado = '".$row['codigo']."' and ".$ComSql." and IDEmpresa = '".$IDEmpresa."') AS 'G',
            (SELECT TOP(1) (Convert(varchar(5), PDOM)+'|'+Convert(varchar(5), DLaborados)) as 'B' FROM ajusteempleado WHERE IDEmpleado = '".$row['codigo']."' and ".$ComSql." and IDEmpresa = '".$IDEmpresa."') AS 'H'
        ";
        //(SELECT TOP(1) ".$_FechaNDQ." FROM relacionempfrente WHERE Codigo = '".$row['codigo']."' AND ".$ComSql." AND IDEmpresa = '".$IDEmpresa."') AS 'D',

        $consultaMedi = $objBDSQL2->consultaBD2($_queryDatos);

        if($consultaMedi['error'] == 1){
          $file = fopen("log/log".date("d-m-Y").".txt", "a");
        	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
        	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consultaMedi['SQLSTATE'].PHP_EOL);
        	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consultaMedi['CODIGO'].PHP_EOL);
        	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consultaMedi['MENSAJE'].PHP_EOL);
        	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$_queryDatos.PHP_EOL);
        	fclose($file);
        	$resultV['error'] = 1;
        	echo json_encode($resultV);
        	/////////////////////////////
        	$objBDSQL->cerrarBD();
        	$objBDSQL2->cerrarBD();

        	exit();
        }else {
          $row2=$objBDSQL2->obtenResult2();
          $objBDSQL2->liberarC2();
        }

        ##################################################
        //VERIFICAR LOS DATOS EN LAS TABLAS EXTRAS
        ##################################################
        $_colorF = 0;
        $_valorC = "";
        $_PPPAempleado = explode('|', '0|0');
        $_PPPA = explode('|', '0|0');
        $_PDOM_DLabora = explode('|', '0|0');
        if(!empty($row2['A'])){
          $_colorF = 1;
        }
        if(!empty($row2['B'])){
          if($row2['B'] == '-n' || $row2['B'] == '-N'){

          }else {
              $_valorC = $row2['B'];
          }
        }
        if(!empty($row2['C'])){
          if($row2['C'] == '-n' || $row2['C'] == '-N'){

          }else {
            $_valorC = $row2['C'];
          }
        }
        if(!empty($row2['F'])){
            $_PPPA = explode('|', $row2['F']);
        }
        if(!empty($row2['G'])){
            $_PPPAempleado = explode('|', $row2['G']);
        }

        if(!empty($row2['H'])){
          $_PDOM_DLabora = explode('|', $row2['H']);
        }

        ##################################################
                        ##DATOS EXTRAS##
        ##################################################
        if(empty($row[$value]) && $row['Tpo'] == "E"){
          $_cuerpo .= '<td style="height: 74px;">';
          if($_colorF == 1){
              $_cuerpo .= '<input type="text" name="fecha'.$row['codigo'].$_FechaCol.'[]" '.$bloquear.' style="background-color: #f57c7c;" id="'.$row['codigo'].$_FechaCol.'" value="'.$_valorC.'" onkeyup="GuardarTR('.$row['codigo'].', \''.$_FechaCol.'\', \''.date("d/m/Y", strtotime($fechAumen." + ".$sumaDias." day")).'\')" >';
          }else {
              $_cuerpo .= '<input type="text" name="fecha'.$row['codigo'].$_FechaCol.'[]" '.$bloquear.' id="'.$row['codigo'].$_FechaCol.'" value="'.$_valorC.'" onkeyup="GuardarTR('.$row['codigo'].', \''.$_FechaCol.'\', \''.date("d/m/Y", strtotime($fechAumen." + ".$sumaDias." day")).'\')" >';
          }
          $_cuerpo .= '</td>';
        } else {
          if($row['Tpo'] == "E"){
            if($_PDOM_DLabora[1] == "1"){
              $_cuerpo .= '<td class="Aline" style="height: 74px;">
                            '.$row[$value].'
                          </td>
                         ';
            }else {
              if($row2['E'] == 1){
                $_cuerpo .= '<td class="Aline" style="height: 74px;">
                              <p style="padding: 0; margin: 0; text-align: center;">
                                <input type="checkbox" '.$bloquear.' checked="checked" id="'.$row['codigo'].$_FechaCol.'DL" />
                                <label for="'.$row['codigo'].$_FechaCol.'DL" onclick="DLaborados(\''.$row['codigo'].'\', \''.$_FechaCol.'\', \''.$centro.'\', \''.$_periodo.'\', \''.$_tipoNom.'\', \''.$IDEmpresa.'\')" title="Descanso Laborado" style="padding: 6px; margin-left: 17px; position: absolute; margin-top: -25px;"></label>
                              </p>
                              '.$row[$value].'
                            </td>
                           ';
              }else{
                $_cuerpo .= '<td class="Aline" style="height: 74px;">
                              <p style="padding: 0; margin: 0; text-align: center;">
                                <input type="checkbox" '.$bloquear.' id="'.$row['codigo'].$_FechaCol.'DL" />
                                <label for="'.$row['codigo'].$_FechaCol.'DL" onclick="DLaborados(\''.$row['codigo'].'\', \''.$_FechaCol.'\', \''.$centro.'\', \''.$_periodo.'\', \''.$_tipoNom.'\', \''.$IDEmpresa.'\')" title="Descanso Laborado" style="padding: 6px; margin-left: 17px; position: absolute; margin-top: -25px;"></label>
                              </p>
                              '.$row[$value].'
                            </td>
                           ';
              }
            }
          }else {
            if(empty($row[$value])){
              $_cuerpo .= '<td style="height: 74px;">
                          '.$row[$value].'</td>';
            }else {
              if($_PDOM_DLabora[0] == "1"){
                $_cuerpo .= '<td class="Aline" style="height: 74px;">
                            '.$row[$value].'</td>';
              }else {
                if($row2['D'] == "1"){
                  $_cuerpo .= '<td class="Aline" style="height: 74px;">
                  <p style="padding: 0;margin: 0;text-align: center;">
                    <input type="checkbox" checked="checked" id="'.$row["codigo"].$_FechaCol.'DT"   />
                    <label for="'.$row["codigo"].$_FechaCol.'DT" onclick="DobleTurno(\''.$row["codigo"].'\', \''.$_FechaCol.'\', \''.$centro.'\', \''.$_periodo.'\', \''.$_tipoNom.'\', \''.$IDEmpresa.'\')" title="Doble Turno" style="padding: 6px;margin-left: -41px;position: absolute;margin-top: -25px;"></label>
                  </p>
                  '.$row[$value].'</td>';
                }else {
                  $_cuerpo .= '<td class="Aline" style="height: 74px;">
                  <p style="padding: 0;margin: 0;text-align: center;">
                    <input type="checkbox" id="'.$row["codigo"].$_FechaCol.'DT"   />
                    <label for="'.$row["codigo"].$_FechaCol.'DT" onclick="DobleTurno(\''.$row["codigo"].'\', \''.$_FechaCol.'\', \''.$centro.'\', \''.$_periodo.'\', \''.$_tipoNom.'\', \''.$IDEmpresa.'\')" title="Doble Turno" style="padding: 6px;margin-left: -41px;position: absolute;margin-top: -25px;"></label>
                  </p>
                  '.$row[$value].'</td>';
                }
              }
            }

          }
        }

        $sumaDias++;

      }

    }
    $sumaDias=0;
    if($row['Tpo'] == "E"){
      $tmp_PPC = "";
      $tmp_PAC = "";
      $tmp_APPC = "";
      $tmp_APAC = "";
      if($_PPPAempleado[0] == 0){
        if($_PPPA[0] == 0){
          $_cuerpo .= '<td><input type="number" '.$bloquear.' style="width: 70px;" min="0" id="pp'.$row['codigo'].'" onkeyup="GpremioPP(\''.$row["codigo"].'\')" placeholder="P.P" step="0.01" value=""></td>';
        }else {
          $_cuerpo .= '<td><input type="number" '.$bloquear.' style="width: 70px;" min="0" id="pp'.$row['codigo'].'" onkeyup="GpremioPP(\''.$row["codigo"].'\')" placeholder="P.P" step="0.01" value="'.$_PPPA[0].'"></td>';
        }
      }else {
        $_cuerpo .= '<td class="Aline"></td>';
      }

      if($_PPPAempleado[1] == 0){
        if($_PPPA[1] == 0){
          $_cuerpo .= '<td><input type="number" '.$bloquear.' style="width: 70px; min="0" id="pa'.$row['codigo'].'" onkeyup="GpremioPA(\''.$row["codigo"].'\')" placeholder="P.A" step="0.01" value=""></td>';
        }else {
          $_cuerpo .= '<td><input type="number" '.$bloquear.' style="width: 70px; min="0" id="pa'.$row['codigo'].'" onkeyup="GpremioPA(\''.$row["codigo"].'\')" placeholder="P.A" step="0.01" value="'.$_PPPA[1].'"></td>';
        }
      }else {
        $_cuerpo .= '<td class="Aline"></td>';
      }
    }else {
      $_cuerpo .= '<td class="Aline"></td>';
      $_cuerpo .= '<td class="Aline"></td>';
    }

    $_nResultados++;
    $_cuerpo .= '<td></td></tr>';
}

$_cabecera .= "<th>P.P</th><th>P.A</th><th>Firma</th></tr>";
$_cabeceraD .= "</tr>";

if(strlen($_cabeceraD) == 148){
  $resultV['contenido'] = '<div style="width: 100%;" class="deep-orange accent-4"><h4 class="center-align" style="padding: 10px; color: white;">No se encontraron resultados !</h4></div>';
}else {
  $resultV['contenido'] .= $_HTML.$_cabeceraD.'
  '.$_cabecera.'
  </thead>
  <tbody>
  '.$_cuerpo.'
  </tbody>
  </table>';

  $Fd = substr($_fecha1, 6, 2);
  $Fm = substr($_fecha1, 4, 2);
  $Fa = substr($_fecha1, 0, 4);

  $F2d = substr($_fecha2, 6, 2);
  $F2m = substr($_fecha2, 4, 2);
  $F2a = substr($_fecha2, 0, 4);


  $fecha1 = $Fd."/".$Fm."/".$Fa;
  $fecha2 = $F2d."/".$F2m."/".$F2a;


  $resultV['contenido'] .= '<input type="hidden" name="Nresul" value="'.$_NumResultado.'"/>';
  $resultV['contenido'] .= '<input type="hidden" name="f1" value="'.$fecha1.'"/>';
  $resultV['contenido'] .= '<input type="hidden" name="f2" value="'.$fecha2.'"/>';
  $resultV['contenido'] .= '<input type="hidden" name="f3" value="'.$_fecha3.'"/>';
  $resultV['contenido'] .= '<input type="hidden" name="f4" value="'.$_fecha4.'"/>';
  $resultV['contenido'] .= '<input type="hidden" name="Ncabecera" value="'.$_NumColumnas.'"/>';
  $resultV['contenido'] .= '<input type="hidden" name="periodo" value="'.$_periodo.'" id="periodo"/>';
  $resultV['contenido'] .= '<input type="hidden" name="multiplo" value="'.$FactorA.'"/>';
  $resultV['contenido'] .= '<input type="hidden" name="pp" value="'.$PP.'" id="hPP"/>';
  $resultV['contenido'] .= '<input type="hidden" name="pa" value="'.$PA.'" id="hPA"/>';
  $resultV['contenido'] .= '<input type="hidden" name="tipoNom" value="'.$_tipoNom.'"/>';
  $resultV['contenido'] .= $_arrayCabeceraD;
  $resultV['contenido'] .= $_arrayCabeceraF;
  $resultV['contenido'] .= '</form>';
  $resultV['contenido'] .= $_BTNS;
  //$resultV['contenido'] .= '<a class="modal-trigger waves-effect waves-light btn"  onclick="modal()" style="margin: 20px;">Conceptos Extras</a>';
  //$resultV['contenido'] .= '<a class="modal-trigger waves-effect waves-light btn"  onclick="GFaltas()" style="margin: 20px;">Faltas</a>';
}

try{
  $objBDSQL->liberarC();
  $objBDSQL2->cerrarBD();
  $objBDSQL->cerrarBD();
}catch(Exception $e){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - Error con la BD: '.$e.PHP_EOL);
  fclose($file);
  $resultV['error'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();
  $objBDSQL2->cerrarBD();

  exit();
}

echo json_encode($resultV);

?>
