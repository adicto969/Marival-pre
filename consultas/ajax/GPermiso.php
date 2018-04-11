<?php

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$Periodo = $_POST["periodo"];
$Tn = $_POST["TN"];
$codigo = $_POST["codigo"];
$numr = "";
$centroE = $centro;
$resultV = array();
$resultV['error'] = 0;
$resultV['codigoError'] = "";

if($Periodo <= 24){
$_fechas = periodo($Periodo, $Tn);
list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $_fechas);
}

if($Periodo > 24 || $Tn == 1){
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
		/////////////////////////////
    $resultV['codigoError'] = '<h1>Error al consultar las Fechas</h1>';
		$objBDSQL->cerrarBD();

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
    $resultV['codigoError'] = '<h1>Error al consultar las Fechas</h1>';
		/////////////////////////////
		$objBDSQL->cerrarBD();
  }
  $_datos = $objBDSQL->obtenResult();

  $fecha3 = $_datos['FECHA3'];
  $fecha4 = $_datos['FECHA4'];

  $objBDSQL->liberarC();
}

if($DepOsub == 1)
{
	$ComSql = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
	$ComSql = "Centro = '".$centro."'";
}

$fechaSuma = "";
$ff = str_replace('/', '-', $fecha1);
list($fOd, $fOm, $fOY) = explode('/', $fecha3);
$ffO = $fOY."/".$fOm."/".$fOd;
$ffO = str_replace('/', '-', $fecha3);

$ConsultaConfirm = "SELECT LTRIM(RTRIM(centro)) AS centro, codigo
                    FROM Llaves
                    WHERE codigo = '".$codigo."'
                    AND tiponom = ".$Tn."
                    AND empresa = ".$IDEmpresa."";

$consulta = $objBDSQL->consultaBD($ConsultaConfirm);
if($consulta['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$ConsultaConfirm.PHP_EOL);
  fclose($file);
  $resultV['error'] = 1;
  echo json_encode($resultV);
  /////////////////////////////
  $objBDSQL->cerrarBD();
  exit();
}
$codigoConfirm = $objBDSQL->obtenResult();
if(!empty($codigoConfirm)){
  $centroE = $codigoConfirm['centro'];
}

$objBDSQL->liberarC();
if(empty($codigoConfirm['codigo'])){
  $resultV['codigoError'] = "El empleado $codigoConfirm no exite con los datos ingresados";
  $resultV['error'] = 1;
  echo json_encode($resultV);
  $objBDSQL->cerrarBD();
  exit();
}else {
  for ($i=0; $i <= 40; $i++) {
  	if($fechaSuma != $fecha2){
  		$fechaSuma = date("d/m/Y", strtotime($ff." +".$i." day"));
      $ff2 = str_replace('/', '-', $fechaSuma);

      $fechaSO = date("d/m/Y", strtotime($ffO." +".$i." day"));

  		$nombre = "fecha".$ff2;
      if(isset($_POST[$nombre])){
        if(!empty($_POST[$nombre])){

          $queryM = "SELECT valor
                     FROM datosanti
                     WHERE codigo = '".$codigo."'
                     AND nombre = '".$ff2."'
                     AND periodoP = '".$Periodo."'
                     AND tipoN = '".$Tn."'
                     AND IDEmpresa = '".$IDEmpresa."'
                     AND ".$ComSql.";";

          $numr = $objBDSQL->obtenfilas($queryM);
          if($numr['error'] == 1){
            $file = fopen("log/log".date("d-m-Y").".txt", "a");
        		fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
        		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numr['SQLSTATE'].PHP_EOL);
        		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numr['CODIGO'].PHP_EOL);
        		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numr['MENSAJE'].PHP_EOL);
        		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$queryM.PHP_EOL);
        		fclose($file);
            $resultV['error'] = 1;
            echo json_encode($resultV);
        		/////////////////////////////
        		$objBDSQL->cerrarBD();
            exit();
          }

          #######################################
          ######  VERIFICAR RELCH_REGISTRO  #####
          #######################################
          list($diaRe, $mesRe, $ayoRe) = explode('/', $fechaSuma);
          $fechaRel = $ayoRe.$mesRe.$diaRe;
          $queryRelch = "SELECT codigo FROM relch_registro
                				 WHERE codigo = '$codigo'
                				 AND empresa = '$IDEmpresa'
                				 AND periodo = '$Periodo'
                				 AND fecha = '$fechaRel'
                				 AND tiponom = '$Tn'
                				 AND checada <> '00:00:00'
                				 AND (EoS = 'E' OR EoS = '1')
                				 AND ".$ComSql;
          #######################################
          $resultR = $objBDSQL->obtenfilas($queryRelch);
          if($resultR['error'] == 1){
            $file = fopen("log/log".date("d-m-Y").".txt", "a");
        		fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
        		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultR['SQLSTATE'].PHP_EOL);
        		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultR['CODIGO'].PHP_EOL);
        		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultR['MENSAJE'].PHP_EOL);
        		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$queryRelch.PHP_EOL);
        		fclose($file);
            $resultV['error'] = 1;
            echo json_encode($resultV);
        		/////////////////////////////
        		$objBDSQL->cerrarBD();
            exit();
          }

          if($resultR['cantidad'] <= 0){
            if($numr['cantidad'] <= 0){
                if(strtoupper($_POST[$nombre]) == "PG"){
                  $Minsert = "INSERT INTO datosanti VALUES ('".$codigo."', '".$ff2."', '".$fechaSO."', '".strtoupper($_POST[$nombre])."', '".$Periodo."', '".$Tn."', '".$IDEmpresa."', '".$centroE."', 0, 0, 0);";
                }else {
                  $Minsert = "INSERT INTO datosanti VALUES ('".$codigo."', '".$ff2."', '".$fechaSO."', '".strtoupper($_POST[$nombre])."', '".$Periodo."', '".$Tn."', '".$IDEmpresa."', '".$centroE."', 1, 1, 1);";
                }

                $consulta = $objBDSQL->consultaBD($Minsert);
                if($consulta['error'] == 1){
                  $file = fopen("log/log".date("d-m-Y").".txt", "a");
                  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
                  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
                  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
                  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
                  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$Minsert.PHP_EOL);
                  fclose($file);
                  $resultV['error'] = 1;
                  echo json_encode($resultV);
                  /////////////////////////////
                  $objBDSQL->cerrarBD();
                  exit();
                }

            }else{

                $Minsert = "UPDATE datosanti SET valor = '".strtoupper($_POST[$nombre])."' WHERE codigo = '".$codigo."' and nombre = '".$ff2."' and periodoP = '".$Periodo."' and tipoN = '".$Tn."' and IDEmpresa = '".$IDEmpresa."' and Centro = '".$centroE."';";
                $consulta = $objBDSQL->consultaBD($Minsert);
                if($consulta['error'] == 1){
                  $file = fopen("log/log".date("d-m-Y").".txt", "a");
                  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
                  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['SQLSTATE'].PHP_EOL);
                  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['CODIGO'].PHP_EOL);
                  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$consulta['MENSAJE'].PHP_EOL);
                  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$Minsert.PHP_EOL);
                  fclose($file);
                  $resultV['error'] = 1;
                  echo json_encode($resultV);
                  /////////////////////////////
                  $objBDSQL->cerrarBD();
                  exit();
                }
            }
          }

        }
      }
  	}
  }
}
echo json_encode($resultV);
$objBDSQL->cerrarBD();
?>
