<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$bdM = new ConexionM();
$bdM->__constructM();

$Periodo = $_POST['periodo'];
$Tn = $_POST['Tn'];
$Dep = $_POST['Dep'];

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
if(empty($fecha1)){
  $fecha1 = "05/08/1993";
}
if(empty($fecha2)){
  $fecha2 = "05/08/1993";
}
if(empty($fecha3)){
  $fecha3 = "05/08/1993";
}
if(empty($fecha4)){
  $fecha4 = "05/08/1993";
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
  $ComSql2 = "LEFT (relch_registro.centro, ".$MascaraEm.") = LEFT ('".$Dep."', ".$MascaraEm.")";
  $ComSql3 = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$Dep."', ".$MascaraEm.")";
}else {
  $ComSql2 = "relch_registro.centro = '".$Dep."'";
  $ComSql3 = "centro = '".$Dep."'";
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
        ".$ComSql2."
        order by relch_registro.codigo asc
        ";

}


$numC = $objBDSQL->obtenfilas($query);

if($numC > 0){

	echo '<form method="POST" id="frmPDOM">
			<table class="responsive-table striped highlight centered">
			<thead>
				<tr>
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Actividad</th>
					<th>Fecha</th>
					<th>Concepto</th>
					<th>PDOM</th>
					<th class="Line45">Seleccion</th>
				</tr>
			</thead>
			<tbody>';

	$lr = 0;
  $objBDSQL->consultaBD($query);
	while ($row = $objBDSQL->obtenResult()) {

		$lr++;

		echo '
			<tr>
				<td>'.$row["CODIGO"].'</td>
				<td>'.utf8_decode($row["NOMBRE"]).'</td>
				<td>'.$row["ACTIVIDAD"].'</td>
				<td>'.$row["FECHA"].'</td>
				<td>'.$row["NUM_CONC"].'</td>
				<td>'.truncateFloat($row["PDOM"], 2).'</td>
		';

		$consultIn = "SELECT PDOM FROM ajusteempleado WHERE IDEmpleado = '".$row["CODIGO"]."' AND ".$ComSql3." AND IDEmpresa = ".$IDEmpresa.";";
    $objBDSQL2->consultaBD2($consultIn);
		$datos = $objBDSQL2->obtenResult2();

		if($datos["PDOM"] == 1){
			$c1 = "";
		}else {
			$c1 = 'checked="checked"';
		}

		echo '
				<td><p style="text-align: center;"><input type="checkbox" name="'.$row["CODIGO"].$lr.'" value="'.$row["CODIGO"].$lr.'" '.$c1.' id="'.$row["CODIGO"].$lr.'"><label for="'.$row["CODIGO"].$lr.'"></label></p></td>
			</tr>
		';

	}

	echo '
			</tbody>
			</table>
		  </form>
		  <button class="btn" onclick="GPDOM()" style="margin: 20px">GENERAR</button>
	';



}else {
	//echo "NO SE ENCONTRARON RESULTADOS";
  echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}

function truncateFloat($number, $digitos)
{
    $raiz = 10;
    $multiplicador = pow ($raiz,$digitos);
    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
    return number_format($resultado, $digitos);

}

?>
