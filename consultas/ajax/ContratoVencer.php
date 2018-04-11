<?php

$ancho = $_POST['valor'];
$resultV = array();
$resultV['TotalRegistros'] = 0;
$resultV['paginas'] = 0;
$resultV['error'] = 0;
$resultV['contenido'] = "";
$resultV['NumeroResultado'] = 0;


if($ancho <= 495)
{
	$estilo = "col s12";
}else {
	$estilo = "col s4 offset-s4";
}

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

if($DepOsub == 1)
{
	$comSql = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
	$comSql = "centro = '".$centro."'";
}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////verificar contratos vencidos a 5 dia /////////////////////////////////

$fecha56 = date('d-m-Y');
$nuevafecha56 = strtotime ( '+6 day' , strtotime ( $fecha56 ) ) ;
$nuevafecha56 = date ( 'Ymd' , $nuevafecha56 );

$nuevafecha5612 = strtotime ( '+1 day' , strtotime ( $fecha56 ) ) ;
$nuevafecha5612 = date ( 'Ymd' , $nuevafecha5612 );

$sql56 = "SELECT con.codigo, em.ap_paterno+' '+em.ap_materno+' '+em.nombre AS nombre,convert (varchar(10), fchterm, 103) AS fchterm FROM contratos AS con INNER JOIN empleados AS em ON em.codigo = con.codigo WHERE fchterm BETWEEN '".$nuevafecha5612."' AND '".$nuevafecha56."' AND vencido = 'F' AND ".$comSql.";";

$num1 = 0;
$numcolR = $objBDSQL->obtenfilas($sql56);
if($numcolR['error'] == 1){
	$file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numcolR['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numcolR['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numcolR['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$sql56.PHP_EOL);
	fclose($file);
	$resultV['error'] = 1;
	echo json_encode($resultV);
	/////////////////////////////
	$objBDSQL->cerrarBD();

	exit();
}
$num1 = $numcolR['cantidad'];

/////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////verificar contratos vencidos a 1 dia /////////////////////////////////
$nuevafecha561 = strtotime ( '+1 day' , strtotime ( $fecha56 ) ) ;
$nuevafecha561 = date ( 'Ymd' , $nuevafecha561 );

$nuevafecha5612 = strtotime ( '-4 day' , strtotime ( $fecha56 ) ) ;
$nuevafecha5612 = date ( 'Ymd' , $nuevafecha5612 );

$sql561 = "SELECT con.codigo, em.ap_paterno+' '+em.ap_materno+' '+em.nombre AS nombre,convert (varchar(10), fchterm, 103) AS fchterm FROM contratos AS con INNER JOIN empleados AS em ON em.codigo = con.codigo WHERE fchterm = '".date("d-m-Y")."' AND vencido = 'F' AND ".$comSql.";";

$num2 = 0;
$numcolR = $objBDSQL->obtenfilas($sql56);
if($numcolR['error'] == 1){
	$file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numcolR['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numcolR['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numcolR['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$sql56.PHP_EOL);
	fclose($file);
	$resultV['error'] = 1;
	echo json_encode($resultV);
	/////////////////////////////
	$objBDSQL->cerrarBD();

	exit();
}

$num2 = $numcolR['cantidad'];

if($num1 == 0 && $num2 == 0){
	$resultV['contenido'] .= '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}else {
	$resultV['contenido'] .= '<div class="row">';
	$resultV['contenido'] .= "<div class='col s12'><h5 class='center'>Alerta Naranja (entre 5 dias para vencer)</h5>";
	if($num1 > 0){

		$resultV['contenido'] .= '
		<table id="TconV" class="'.$estilo.' striped highlight">
			<thead class="orange">
			<tr>
				<th style="text-align: center;">Codigo</th>
				<th style="text-align: center;">Nombre</th>
				<th style="text-align: center;">Fecha de Terminación</th>
			</tr>
			</thead>
			<tbody>
		';

		$resultado = $objBDSQL->consultaBD($sql56);
		if($resultado['error'] == 1){
	    $file = fopen("log/log".date("d-m-Y").".txt", "a");
	  	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['SQLSTATE'].PHP_EOL);
	  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['CODIGO'].PHP_EOL);
	  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['MENSAJE'].PHP_EOL);
	  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$sql56.PHP_EOL);
	  	fclose($file);
	  	$resultV['error'] = 1;
	  	echo json_encode($resultV);
	  	/////////////////////////////
	  	$objBDSQL->cerrarBD();

	  	exit();
	  }

		while ($row = $objBDSQL->obtenResult())
		{
			$resultV['contenido'] .= '<tr>
	                <td>'.$row["codigo"].'</td>
	                <td>'.utf8_encode($row["nombre"]).'</td>
	                <td style="text-align: center;">'.utf8_encode($row["fchterm"]).'</td>
	              </tr>';
		}
		$objBDSQL->liberarC();
		$resultV['contenido'] .= '
			</tbody>
		</table><br>';
	}else {

		$resultV['contenido'] .= "<p class='center'>No Se Encontraron Resultados</p>";
	}
  $resultV['contenido'] .= "</div>";
	$resultV['contenido'] .= "<div class='col s12'><h5 class='center'>Alerta Roja (a 1 dia o ya vencidos)</h5>";

	if($num2 > 0){
		$resultV['contenido'] .= '
		<table id="TconV2" class="'.$estilo.' striped highlight">
			<thead class="red" style="text-align: center;">
			<tr>
				<th style="text-align: center;">Codigo</th>
				<th style="text-align: center;">Nombre</th>
				<th style="text-align: center;">Fecha de Terminación</th>
			</tr>
			</thead>
			<tbody>
		';

		$resultado = $objBDSQL2->consultaBD($sql561);
		if($resultado['error'] == 1){
	    $file = fopen("log/log".date("d-m-Y").".txt", "a");
	  	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['SQLSTATE'].PHP_EOL);
	  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['CODIGO'].PHP_EOL);
	  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['MENSAJE'].PHP_EOL);
	  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$sql561.PHP_EOL);
	  	fclose($file);
	  	$resultV['error'] = 1;
	  	echo json_encode($resultV);
	  	/////////////////////////////
	  	$objBDSQL->cerrarBD();

	  	exit();
	  }
		while ($row = $objBDSQL->obtenResult())
		{
			$resultV['contenido'] .= '<tr>
	                <td>'.$row["codigo"].'</td>
	                <td>'.utf8_encode($row["nombre"]).'</td>
	                <td style="text-align: center;">'.utf8_encode($row["fchterm"]).'</td>
	              </tr>';
		}
		$objBDSQL->liberarC();
		$resultV['contenido'] .= '
			</tbody>
		</table>';
	}else {

		$resultV['contenido'] .= "<p class='center'>No Se Encontraron Resultados</p>";
	}
	$resultV['contenido'] .= "</div>";
	$resultV['contenido'] .= '</div>';
}
echo json_encode($resultV);
$objBDSQL->cerrarBD();
 ?>
