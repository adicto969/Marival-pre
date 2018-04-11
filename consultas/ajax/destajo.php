<?php
//ConseptosExt
$BDM = new ConexionM();
$BDM->__constructM();
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$tnomina = $_POST["TN"];
$arrayConExt = array();
$cabExtCon = "<table><thead><tr>";
if($PC <= 24){
	$fechas = periodo($PC, $tnomina);
	list($fecha1,$fecha2,$fecha3,$fecha4) = explode(',', $fechas);
}

if($tnomina == 1 || $PC > 24){
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
		echo "Error en fechas";
		/////////////////////////////
		$objBDSQL->cerrarBD();

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
		echo "Error en fechas";
		/////////////////////////////
		$objBDSQL->cerrarBD();

		exit();
	}
	$_datos = $objBDSQL->obtenResult();

	$_fecha3 = $_datos['FECHA3'];
	$_fecha4 = $_datos['FECHA4'];
	$objBDSQL->liberarC();
}

list($dia, $mes, $ayo) = explode('/', $fecha1);
list($dia2, $mes2, $ayo2) = explode('/', $fecha2);

$fecha1 = $ayo.$mes.$dia;
$fecha2 = $ayo2.$mes2.$dia2;

$querySQL1 = "select L.codigo AS Codigo,
                    E.nombre + ' '+E.ap_paterno + ' '+E.ap_materno AS Nombre,
                    E.sueldo,";
$querySQL2 = "";
if($DepOsub == 1){
  if($supervisor == 0){
    $querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajos AS D ON D.Codigo = L.codigo AND D.empresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
          			 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.") AND
          			 L.tiponom = '".$tnomina."' AND
          			 E.activo = 'S'";
  }else {
    $querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajos AS D ON D.Codigo = L.codigo AND D.empresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
                 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.") AND
                 L.supervisor = '".$supervisor."' AND
                 L.tiponom = '".$tnomina."' AND
                 E.activo = 'S'";
  }

    $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  if($supervisor == 0){
    $querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajos AS D ON D.Codigo = L.codigo AND D.empresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
          			 L.centro = '".$centro."' AND
          			 L.tiponom = '".$tnomina."' AND
                 E.activo = 'S'";
  }else {
    $querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajos AS D ON D.Codigo = L.codigo AND D.empresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
                 L.centro = '".$centro."' AND
                 L.supervisor = '".$supervisor."' AND
                 L.tiponom = '".$tnomina."' AND
                 E.activo = 'S'
                 ";
  }

    $ComSql2 = "Centro = '".$centro."'";
}
$consultaCa = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'destajos'";
$reultadoo = $objBDSQL->consultaBD($consultaCa);
if($reultadoo['error'] == 1)
{
	$file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$reultadoo['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$reultadoo['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$reultadoo['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaCa.PHP_EOL);
	fclose($file);
	echo "Error al consultar la tabla destajo";
	/////////////////////////////
	$objBDSQL->cerrarBD();

	exit();
}
//$row =  $objBDSQL->obtenResult();
$cabExtCon .= "<th>Codigo</th>";
$cabExtCon .= "<th>Nombre</th>";
$cabExtCon .= "<th>Sueldo</th>";
while($datos = $objBDSQL->obtenResult()){
    if($datos['COLUMN_NAME'] != "ID" && $datos['COLUMN_NAME'] != "Codigo" && $datos['COLUMN_NAME'] != "Periodo" && $datos['COLUMN_NAME'] != "IDEmpresa" && $datos['COLUMN_NAME'] != "Centro" && $datos['COLUMN_NAME'] != "fecha" ){
          $arrayConExt[] = $datos['COLUMN_NAME'];
          $querySQL2 .= "D.".$datos['COLUMN_NAME'].",";
	  if($datos['COLUMN_NAME'] == "CONCEPTO_1" || $datos['COLUMN_NAME'] == 'CONCEPTO_2' || $datos['COLUMN_NAME'] == 'CONCEPTO_3'){
	  	$cabExtCon .= '<th>FRENTE<i class="close material-icons" style="display: contents; color: red; cursor: pointer;" title="Eliminar" onclick="eliminarColumna(\''.$datos['COLUMN_NAME'].'\')">close</i></th>';
  	  }else{
          	$cabExtCon .= '<th>'.$datos['COLUMN_NAME'].'<i class="close material-icons" style="display: contents; color: red; cursor: pointer;" title="Eliminar" onclick="eliminarColumna(\''.$datos['COLUMN_NAME'].'\')">close</i></th>';
	  }
    }
}
$querySQL2 = substr($querySQL2, 0, -1);
$cabExtCon .= "</tr></thead>";
$cabExtCon .= "<tbody>";
$objBDSQL->liberarC();

$reultado = $objBDSQL->consultaBD($querySQL1.$querySQL2.$querySQL3);
if($reultado['error'] == 1)
{
	$file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$reultado['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$reultado['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$reultado['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$querySQL1.$querySQL2.$querySQL3.PHP_EOL);
	fclose($file);
	echo "Error en la consulta Principal";
	/////////////////////////////
	$objBDSQL->cerrarBD();

	exit();
}
while ( $row = $objBDSQL->obtenResult() )
{
  $cabExtCon .= "<tr>";
  $cabExtCon .= "<td>".$row['Codigo']."</td>";
  $cabExtCon .= "<td>".utf8_encode($row['Nombre'])."</td>";
  $cabExtCon .= "<td>".$row['sueldo']."</td>";
  foreach ($arrayConExt as $valor) {
    //$cabExtCon .= "<td>".$row[$valor]."</td>";
    if(!empty($row[$valor])){
        $cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].$valor.'" value="'.$row[$valor].'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \''.$valor.'\', \''.$row['Codigo'].$valor.'\')" ></td>';
    }else {
        $cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].$valor.'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \''.$valor.'\', \''.$row['Codigo'].$valor.'\')" ></td>';
    }
  }
  $cabExtCon .= "</tr>";
}
$cabExtCon .= "</tbody></table>";
echo $cabExtCon;
echo '<input type="hidden" value="1" id="OCV" >';
$objBDSQL->liberarC();
$objBDSQL->cerrarBD();

?>
