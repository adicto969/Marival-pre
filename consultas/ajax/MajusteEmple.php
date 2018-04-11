<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$result = array();
$result['error'] = 0;
$result['exito'] = 0;


if($DepOsub == 1)
{
	$ComSql = "LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
	$ComSql = "L.centro = '".$centro."'";
}

$query = "
SELECT E.codigo
FROM empleados AS E
INNER JOIN Llaves AS L ON L.codigo = E.codigo AND L.empresa = E.empresa
INNER JOIN tabulador AS T ON  T.ocupacion = L.ocupacion AND T.empresa = L.empresa
WHERE  ".$ComSql." AND L.empresa = '".$IDEmpresa."' AND E.activo = 'S'
";

$resultCon = $objBDSQL->consultaBD($query);

if($resultCon['error'] == 1){
	$file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
	fclose($file);
	$result['error'] = -1;
	echo json_encode($result);
	/////////////////////////////
	$objBDSQL->cerrarBD();
	$objBDSQL2->cerrarBD();

	exit();
}

while($row = $objBDSQL->obtenResult()){

	$nombreA = $row["codigo"];
	if(!empty($_POST[$nombreA])){

		$array = array($_POST[$nombreA]);

		if(empty($array[0][0])){
			$A1 = 0;
		}else {
			$A1 = $array[0][0];
		}

		if(empty($array[0][1])){
			$A2 = 0;
		}else {
			$A2 = $array[0][1];
		}

		if(empty($array[0][2])){
			$A3 = 0;
		}else {
			$A3 = $array[0][2];
		}

		if(empty($array[0][3])){
			$A4 = 0;
		}else {
			$A4 = $array[0][3];
		}

		$consulta = "IF EXISTS(
											SELECT ID FROM ajusteempleado WHERE IDEmpleado = ".$nombreA." AND centro = '".$centro."' AND IDEmpresa = ".$IDEmpresa.")
									BEGIN
										UPDATE ajusteempleado SET PDOM = '".$A1."', DLaborados = '".$A2."', PA = '".$A3."', PP = '".$A4."', centro = '".$centro."' WHERE IDEmpleado = '".$nombreA."' AND centro = '".$centro."' AND IDEmpresa = ".$IDEmpresa."
									END
									ELSE
									BEGIN
										INSERT INTO ajusteempleado values ('".$nombreA."', '".$A1."', '".$A2."', '".$A3."', '".$A4."', '".$centro."', ".$IDEmpresa." )
									END";

		$resultCon2 = $objBDSQL2->consultaBD2($consulta);

		if($resultCon2['error'] == 1){
			$file = fopen("log/log".date("d-m-Y").".txt", "a");
			fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon2['SQLSTATE'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon2['CODIGO'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon2['MENSAJE'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
			fclose($file);
			$result['error']++;
		}else {
			$result['exito']++;
		}
	}

}
echo json_encode($result);

$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();

?>
