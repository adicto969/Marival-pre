<?php

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();
$script = "";


$resultV = array();
$resultV['TotalRegistros'] = 0;
$resultV['paginas'] = 0;
$resultV['error'] = 0;
$resultV['contenido'] = "";
$resultV['NumeroResultado'] = 0;

$pagina = $_POST['pagina'];
$cantidadXpagina = $_POST['cantidadXpagina'];
$ordernar = $_POST["order"];
$busqueda = "";
$busquedaV = "";

if($DepOsub == 1)
{
  $ComSql = "LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  $ComSql2 = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $ComSql = "L.centro = '".$centro."'";
  $ComSql2 = "centro = '".$centro."'";
}

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

$query = "
    SELECT codigo,
           nombre,
           ocupacion,
           actividad,
           horario,
           fechaAnti,
           fechaAlta,
           fechaTer,
           dias,
           TOTAL_REGISTROS,
           CEILING(TOTAL_REGISTROS / ".$cantidadXpagina.".0) AS PAGINA
    FROM (
          SELECT
              ROW_NUMBER() OVER (ORDER BY E.codigo) AS ROW_NUM,
              E.codigo,
              LTRIM ( RTRIM( E.ap_paterno ) )+' '+LTRIM ( RTRIM ( E.ap_materno ) )+' '+LTRIM ( RTRIM ( E.nombre ) ) AS nombre,
              L.ocupacion,
              T.actividad,
              L.horario,
              MAX ( CONVERT (VARCHAR(10), E.fchantigua, 103) ) AS fechaAnti,
              MAX ( CONVERT (VARCHAR(10), C.fchAlta, 103) ) AS fechaAlta,
              MAX ( CONVERT (VARCHAR(10), C.fchterm, 103) ) AS fechaTer,
              SUM(C.dias) AS dias,
              (SELECT
                  COUNT( L.ocupacion )
               FROM empleados AS E
               LEFT JOIN contratos AS C ON C.empresa = E.empresa AND C.codigo = E.codigo
               INNER JOIN Llaves AS L ON L.empresa = E.empresa AND L.codigo = E.codigo
               INNER JOIN tabulador AS T ON T.empresa = L.empresa AND T.ocupacion = L.ocupacion
               WHERE E.activo = 'S' AND
               ".$ComSql." AND L.empresa = '".$IDEmpresa."' AND L.tiponom = '".$TN."'
               ".$busqueda."
              ) AS TOTAL_REGISTROS

          FROM empleados AS E
          LEFT JOIN contratos AS C ON C.empresa = E.empresa AND C.codigo = E.codigo
          INNER JOIN Llaves AS L ON L.empresa = E.empresa AND L.codigo = E.codigo
          INNER JOIN tabulador AS T ON T.empresa = L.empresa AND T.ocupacion = L.ocupacion
          WHERE E.activo = 'S' AND
          ".$ComSql." AND L.empresa = '".$IDEmpresa."' AND L.tiponom = '".$TN."'
          ".$busqueda."
          GROUP BY
             E.codigo,
             E.ap_paterno,
             E.ap_materno,
             E.nombre,
             E.fchantigua,
             L.ocupacion,
             T.actividad,
             L.horario
      ) AS X
  WHERE ROW_NUM BETWEEN (".$pagina." - 1) * ".$cantidadXpagina." + 1 AND (".$pagina." - 1) * ".$cantidadXpagina." + ".$cantidadXpagina."
  ORDER BY ".$ordernar."
";

$numCol = $objBDSQL->obtenfilas($query);
if($numCol['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
	fclose($file);
	$resultV['error'] = 1;
	echo json_encode($resultV);
	/////////////////////////////
	$objBDSQL->cerrarBD();
	$objBDSQL2->cerrarBD();

	exit();
}

if($numCol['cantidad'] >= 1){
  $resultV['contenido'] .= '
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
        <form method="post" id="frmContratos">
        <input type="hidden" name="Emp9" value="'.$NombreEmpresa.'" />
        <input type="hidden" name="NomDep" value="'.$NomDep.'" />
        <input type="hidden" name="centro" value="'.$centro.'" />
        <input type="hidden" name="TNomina" value="'.$TN.'" />
        <table id="tablaContra" class="responsive-table striped highlight centered" style="border: 1px solid #000080;">
        <thead>
          <tr id="CdMas">
            <th colspan="10" style="background-color: white; border-top: hidden;"></th>
            <th colspan="2" style="text-aling: center; background-color: #0091ea;">Contrato</th>
          </tr>
          <tr style="background-color: #00b0ff; border-top: 1px solid #000">
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Ocupación</th>
            <th>Actividad</th>
            <th>horario</th>
            <th>Antigüedad</th>
            <th>Inicio de Contrato</th>
            <th>Termino de Contrato</th>
            <th>Ds A</th>
            <th class="Line35">Observacion</th>
            <th class="Line45">SI</th>
            <th class="Line45">NO</th>
          </tr>
        </thead>
        <tbody>
      ';


  $resultado = $objBDSQL->consultaBD($query);
  if($resultado['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
  	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['SQLSTATE'].PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['CODIGO'].PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['MENSAJE'].PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
  	fclose($file);
  	$resultV['error'] = 1;
  	echo json_encode($resultV);
  	/////////////////////////////
  	$objBDSQL->cerrarBD();
  	$objBDSQL2->cerrarBD();

  	exit();
  }

  while ( $row = $objBDSQL->obtenResult() )
  {
    $resultV['TotalRegistros'] = $row["TOTAL_REGISTROS"];
    $resultV['paginas'] = $row["PAGINA"];
    $resultV['NumeroResultado']++;

    $resultV['contenido'] .= '
    <tr ondblclick="seleccion('.$row["codigo"].')" id="'.$row["codigo"].'">
    <td>'.$row["codigo"].'</td>
    <td style="text-align: left;">'.utf8_encode($row["nombre"]).'</td>
    <td>'.$row["ocupacion"].'</td>
    <td>'.$row["actividad"].'</td>
    <td>'.$row["horario"].'</td>
    <td>'.$row["fechaAnti"].'</td>
    <td>'.$row["fechaAlta"].'</td>
    <td>'.$row["fechaTer"].'</td>
    <td>'.$row["dias"].'</td>';

    $consultaI = "SELECT Observacion, Contrato FROM contrato WHERE IDEmpleado = '".$row["codigo"]."' AND IDEmpresa = '".$IDEmpresa."' AND ".$ComSql2;

    $valorC = "";
    $valorA = "";
    $valorB = "";
    $result = $objBDSQL2->consultaBD2($consultaI);

    if($result['error'] == 1){
			$file = fopen("log/log".date("d-m-Y").".txt", "a");
			fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['SQLSTATE'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['CODIGO'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['MENSAJE'].PHP_EOL);
			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaI.PHP_EOL);
			fclose($file);
			$resultV['error'] = 1;
			echo json_encode($resultV);
			/////////////////////////////
			$objBDSQL->cerrarBD();
			$objBDSQL2->cerrarBD();

			exit();
		}

    $valorM = $objBDSQL2->obtenResult2();

    if(empty($valorM)){
      $resultV['contenido'] .= '<td><input type="text" name="'.$row["codigo"].'" id="obser" size="100%"></td>
      <td><p><input class="with-gap" type="radio" id="A'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="SI"><label for="A'.$row["codigo"].'"></label></p></td>
      <td ondblclick="quitar'.$row["codigo"].'()"><p><input class="with-gap" type="radio" id="B'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="NO"><label for="B'.$row["codigo"].'"></label></p></td>';

    }else {

      $valorC = "";
      $valorA = "";
      $valorB = "";


      if ($valorM['Observacion'] != ''){
        $valorC = $valorM['Observacion'];

        if($valorM['Contrato'] == "SI"){

          $resultV['contenido'] .= '<td><input type="text" name="'.$row["codigo"].'" id="obser" size="100%" value="'.$valorC.'"></td>
          <td><p><input class="with-gap" type="radio" id="A'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="SI" checked><label for="A'.$row["codigo"].'"></label></p></td>
          <td ondblclick="quitar'.$row["codigo"].'()"><p><input class="with-gap" type="radio" id="B'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="NO"><label for="B'.$row["codigo"].'"></label></p></td> ';

        }

        if($valorM['Contrato'] == "NO"){

          $resultV['contenido'] .= '<td><input type="text" name="'.$row["codigo"].'" id="obser" size="100%" value="'.$valorC.'"></td>
          <td><p><input class="with-gap" type="radio" id="A'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="SI"><label for="A'.$row["codigo"].'"></label></p></td>
          <td ondblclick="quitar'.$row["codigo"].'()"><p><input class="with-gap" type="radio" id="B'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="NO" checked><label for="B'.$row["codigo"].'"></label></p></p></td>';

        }

        if($valorM['Contrato'] == "vacio"){

          $resultV['contenido'] .= '<td><input type="text" name="'.$row["codigo"].'" id="obser" size="100%" value="'.$valorC.'"></td>
          <td><p><input class="with-gap" type="radio" id="A'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="SI"><label for="A'.$row["codigo"].'"></label></p></td>
          <td ondblclick="quitar'.$row["codigo"].'()"><p><input class="with-gap" type="radio" id="B'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="NO"><label for="B'.$row["codigo"].'"></label></p></td>';

        }

      }else {

        $valorC = "";
        if($valorM['Contrato'] == "SI"){

          $resultV['contenido'] .= '<td><input type="text" name="'.$row["codigo"].'" id="obser" size="100%"></td>
          <td><p><input class="with-gap" type="radio" id="A'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="SI" checked><label for="A'.$row["codigo"].'"></label></p></p></td>
          <td ondblclick="quitar'.$row["codigo"].'()"><p><input class="with-gap" type="radio" id="B'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="NO"><label for="B'.$row["codigo"].'"></label></p></p></td>';

        }

        if ($valorM['Contrato'] == "NO"){

          $resultV['contenido'] .= '<td><input type="text" name="'.$row["codigo"].'" id="obser" size="100%"></td>
          <td><p><input class="with-gap" type="radio" id="A'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="SI"><label for="A'.$row["codigo"].'"></label></p></p></td>
          <td ondblclick="quitar'.$row["codigo"].'()"><p><input class="with-gap" type="radio" id="B'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="NO" checked><label for="B'.$row["codigo"].'"></label></p></p></td>';

        }
        if($valorM['Contrato'] == "vacio"){

          $resultV['contenido'] .= '<td><input type="text" name="'.$row["codigo"].'" id="obser" size="100%"></td>
          <td><p><input class="with-gap" type="radio" id="A'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="SI"><label for="A'.$row["codigo"].'"></label></p></p></td>
          <td ondblclick="quitar'.$row["codigo"].'()"><p><input class="with-gap" type="radio" id="B'.$row["codigo"].'" name="NC'.$row["codigo"].'" value="NO"><label for="B'.$row["codigo"].'"></label></p></p></td>';

        }
      }

    }
    $resultV['contenido'] .= '</tr>';
  }

  $resultV['contenido'] .= '
  </tbody>
  </table>
  <input type="hidden" name="Centro" value="'.$centro.'">
  </form>
  <button class="waves-effect waves-light btn" onclick="Gcontratos()" id="btnGuardar">GUARDAR</button>
  <button class="waves-effect waves-light btn" onclick="EnviarContrato()" id="btnEnviar" >GENERAR</button>';
}else {
  $resultV['contenido'] .= '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}
echo json_encode($resultV);

$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();
?>
