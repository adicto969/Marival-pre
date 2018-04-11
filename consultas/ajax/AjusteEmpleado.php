<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();
$bdM = new ConexionM();
$bdM->__constructM();

$result = array();
$result['TotalRegistros'] = 0;
$result['paginas'] = 0;
$result['error'] = 0;
$result['contenido'] = "";
$result['NumeroResultado'] = 0;

$cantidadXpagina = $_POST['cantidadXpagina'];
$pagina = $_POST['pagina'];
$ordenar = $_POST['order'];

$BTN = '<button class="btn" id="btnAjusEmp" onclick="GajusteEmple()" style="margin: 20px;">GUARDAR</button>';

if($DepOsub == 1)
{
	$complementoSql = "LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
	$ComSql2 = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
	$complementoSql = "L.centro = '".$centro."'";
	$ComSql2 = "centro = '".$centro."'";
}

$busqueda = "";
$busqueda2 = "";
$busquedaV = "";
if(isset($_POST['buscar'])){
	if(!empty($_POST['buscar'])){
		$busqueda = "AND (E.codigo LIKE '%".$_POST['buscar']."%'";
		$busqueda .= " OR E.ap_paterno LIKE '%".$_POST['buscar']."%'";
		$busqueda .= " OR E.ap_materno LIKE '%".$_POST['buscar']."%'";
		$busqueda .= " OR E.nombre LIKE '%".$_POST['buscar']."%'";
		$busqueda .= " OR T.actividad LIKE '%".$_POST['buscar']."%')";
		$busquedaV = $_POST['buscar'];
	}
}

$queryS = "
SELECT codigo, nombre, actividad, TOTAL_REGISTROS,
			 CEILING(TOTAL_REGISTROS / ".$cantidadXpagina.".0) AS PAGINA
FROM (
			SELECT
				ROW_NUMBER() OVER (ORDER BY E.codigo) AS ROW_NUM,
				E.codigo, E.ap_paterno+' '+E.ap_materno+' '+E.nombre AS nombre,
				T.actividad,
				(SELECT COUNT(E.codigo)
				 FROM empleados AS E
				 INNER JOIN Llaves AS L ON L.codigo = E.codigo AND L.empresa = E.empresa
				 INNER JOIN tabulador AS T ON T.ocupacion = L.ocupacion AND T.empresa = L.empresa
				 WHERE ".$complementoSql." AND L.empresa = '".$IDEmpresa."' AND E.activo = 'S'
				 AND L.tiponom = '".$TN."'
				 ".$busqueda."
				) AS TOTAL_REGISTROS
			FROM empleados AS E
			INNER JOIN Llaves AS L ON L.codigo = E.codigo AND L.empresa = E.empresa
			INNER JOIN tabulador AS T ON T.ocupacion = L.ocupacion AND T.empresa = L.empresa
			WHERE ".$complementoSql." AND L.empresa = '".$IDEmpresa."' AND E.activo = 'S'
			AND L.tiponom = '".$TN."'
			".$busqueda."
	) AS X
WHERE ROW_NUM BETWEEN (".$pagina." - 1) * ".$cantidadXpagina." + 1 AND (".$pagina." - 1) * ".$cantidadXpagina." + ".$cantidadXpagina."
ORDER BY ".$ordenar."
";

$numCol = $objBDSQL->obtenfilas($queryS);
if($numCol['error'] == 1){
	$file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$queryS.PHP_EOL);
	fclose($file);
	$result['error'] = 1;
	echo json_encode($result);
	/////////////////////////////
	$objBDSQL->cerrarBD();
	$objBDSQL2->cerrarBD();

	exit();
}

if($numCol['cantidad'] > 0){

	$result['contenido'] .=  '
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
  </ul>
	<a class="dropdown-button btn" id="down-orden" data-beloworigin="true" data-activates="order" style="float: right; background-color: white; color: black;box-shadow:  none !important;border: 1px solid rgba(0, 0, 0, .2);padding-bottom: 39px;">
    Ordernar
    <i class="large material-icons">arrow_drop_down</i>
  </a>
  <ul id="order" class="dropdown-content" style="min-width: 10px !important;">
    <li><a onclick="Ordernar(\'codigo\')">Codigo</a></li>
    <li><a onclick="Ordernar(\'nombre\')">Nombre</a></li>
    <li><a onclick="Ordernar(\'actividad\')">Actividad</a></li>
  </ul>
	<div class="input-field col s6" style="max-width: 211px;margin-left: 20px;">
    <input id="buscarV" type="text" class="validate" style="width: 164px; padding-top: 5px" value="'.$busquedaV.'">
		<i class="material-icons prefix" onclick="busquedaF()" style="line-height: 39px;text-align: center;border: 1px solid rgba(0, 0, 0, .2);cursor:pointer;">search</i>
  </div>

	<form method="POST" id="frmAjusEmp">
		<table class="responsive-table striped highlight centered">
			<thead style="background-color: #00b0ff;">
				<tr id="CdMas">
					<th colspan="3" style="background-color: white;"></th>
					<th colspan="4" >Omitir Siempre En </th>
				</tr>
				<tr>
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Actividad</th>
					<th class="alTH">PDOM</th>
					<th class="alTH">DLaborados</th>
					<th class="alTH">P.A</th>
					<th class="alTH">P.P</th
				</tr>
			</thead>
			<tbody>';
	$resultado = $objBDSQL->consultaBD($queryS);

	if($resultado['error'] == 1){
		$file = fopen("log/log".date("d-m-Y").".txt", "a");
		fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['SQLSTATE'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['CODIGO'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['MENSAJE'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$queryS.PHP_EOL);
		fclose($file);
		$result['error'] = 1;
		echo json_encode($result);
		/////////////////////////////
		$objBDSQL->cerrarBD();
		$objBDSQL2->cerrarBD();

		exit();
	}

	while ($row = $objBDSQL->obtenResult()){
		$result['NumeroResultado']++;
		$result['TotalRegistros'] = $row["TOTAL_REGISTROS"];
		$result['paginas'] = $row["PAGINA"];
		$result['contenido'] .= '
			<tr>
				<td>'.$row["codigo"].'</td>
				<td>'.utf8_encode($row["nombre"]).'</td>
				<td>'.$row["actividad"].'</td>';

		$consultM = "SELECT PDOM, DLaborados, PA, PP FROM ajusteempleado WHERE IDEmpleado = '".$row["codigo"]."';";

		$c1 = "";
		$c2 = "";
		$c3 = "";
		$c4 = "";
		$resultado = $objBDSQL2->consultaBD2($consultM);

		if($resultado['error'] == 1){
			$file = fopen("log/log".date("d-m-Y").".txt", "a");
			fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['SQLSTATE'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['CODIGO'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['MENSAJE'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$queryS.PHP_EOL);
			fclose($file);
			$result['error'] = 1;
			echo json_encode($result);
			/////////////////////////////
			$objBDSQL->cerrarBD();
			$objBDSQL2->cerrarBD();

			exit();
		}


		while ($valorM = $objBDSQL2->obtenResult2()) {
			if($valorM['PDOM'] == 1){
				$c1 = 'checked="checked"';
			} else {
				$c1 = "";
			}

			if($valorM['DLaborados'] == 1){
				$c2 = 'checked="checked"';
			}else {
				$c2 = "";
			}

			if($valorM['PA'] == 1){
				$c3 = 'checked="checked"';
			}else {
				$c3 = "";
			}

			if($valorM['PP'] == 1){
				$c4 = 'checked="checked"';
			}else {
				$c4 = "";
			}


		}

		$result['contenido'] .= '
				<td><p style="text-align: center;"><input type="checkbox" name="'.$row["codigo"].'[0]" value="1" '.$c1.' id="Q1'.$row["codigo"].'"><label for="Q1'.$row["codigo"].'"></label></p></td>
				<td><p style="text-align: center;"><input type="checkbox" name="'.$row["codigo"].'[1]" value="1" '.$c2.' id="Q2'.$row["codigo"].'"><label for="Q2'.$row["codigo"].'"></label></p></td>
				<td><p style="text-align: center;"><input type="checkbox" name="'.$row["codigo"].'[2]" value="1" '.$c3.' id="Q3'.$row["codigo"].'"><label for="Q3'.$row["codigo"].'"></label></p></td>
				<td><p style="text-align: center;"><input type="checkbox" name="'.$row["codigo"].'[3]" value="1" '.$c4.' id="Q4'.$row["codigo"].'"><label for="Q4'.$row["codigo"].'"></label></p></td>
			</tr>
		';
	}


	$result['contenido'] .='
			</tbody>
		</table>
	</form>
	'.$BTN;

}else {
	//echo "NO SE ENCONTRATON RESULTADOS";
	$result['contenido'] .=  '
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
  </ul>
	<a class="dropdown-button btn" id="down-orden" data-beloworigin="true" data-activates="order" style="float: right; background-color: white; color: black;box-shadow:  none !important;border: 1px solid rgba(0, 0, 0, .2);padding-bottom: 39px;">
    Ordernar
    <i class="large material-icons">arrow_drop_down</i>
  </a>
  <ul id="order" class="dropdown-content" style="min-width: 10px !important;">
    <li><a onclick="Ordernar(\'codigo\')">Codigo</a></li>
    <li><a onclick="Ordernar(\'nombre\')">Nombre</a></li>
    <li><a onclick="Ordernar(\'actividad\')">Actividad</a></li>
  </ul>
	<div class="input-field col s6" style="max-width: 211px;margin-left: 20px;">
    <input id="buscarV" type="text" class="validate" style="width: 164px; padding-top: 5px" value="'.$busquedaV.'">
		<i class="material-icons prefix" onclick="busquedaF()" style="line-height: 39px;text-align: center;border: 1px solid rgba(0, 0, 0, .2);cursor:pointer;">search</i>
  </div>';
	$result['contenido'] .= '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}

echo json_encode($result);

$objBDSQL->liberarC();
$objBDSQL2->liberarC2();
$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();

?>
