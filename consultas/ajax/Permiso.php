<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$complemento = "";
$complemento2 = "";
$Periodo = $_POST['periodo'];
$Tn = $_POST['TN'];

if($DepOsub == 1){
    $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
    $ComSql1 = "LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
    $ComSql2 = "Centro = '".$centro."'";
    $ComSql1 = "L.centro = '".$centro."'";
}
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
		$objBDSQL->cerrarBD();
		$error = '<h1>Error al consultar las Fechas</h1>';
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
		$objBDSQL->cerrarBD();
		$error = '<h1>Error al consultar las Fechas</h1>';
  }
  $_datos = $objBDSQL->obtenResult();

  $fecha3 = $_datos['FECHA3'];
  $fecha4 = $_datos['FECHA4'];

  $objBDSQL->liberarC();
}

echo '
<form id="frmPermiso">
  <div id="ULAuto"></div>
	<table class="responsive-table striped highlight centered">
		<thead>
			<tr>
				<th class="thL">Codigo</th>';

$fechaSuma = "";
$ff = str_replace('/', '-', $fecha1);
for ($i=0; $i <= 40 ; $i++) {
	if($fechaSuma != $fecha2){
		$fechaSuma = date("d/m/Y", strtotime($ff." +".$i." day"));
		echo '<th class="thL">'.$fechaSuma.'</th>';
	}
}


echo'
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
          <input id="cod"  type="number" name="codigo" class="autocomplete" required onkeyup="botonArriba()" style="width: 60px;"/>
        </td>';
        $fechaSuma = "";
        $ff = str_replace('/', '-', $fecha1);
        for ($i=0; $i <= 40; $i++) {
        	if($fechaSuma != $fecha2){
        		$fechaSuma = date("d/m/Y", strtotime($ff." +".$i." day"));
            $ff2 = str_replace('/', '-', $fechaSuma);
        		echo '<td><input type="text" name="fecha'.$ff2.'" pattern="[a-zA-Z]{3}|[a-zA-Z]{2}|[a-zA-Z]{1}" title="solo se permite caracteres especificados en la tabla" onkeyup="javascript:this.value=this.value.toUpperCase();"/></td>';
        	}
        }


echo'
			</tr>
		</tbody>
	</table>
</form>

<button onclick="GenerarPermiso()"  style="margin: 20px;" class="btn">GUARDAR</button>
';

$consultaPermisos = "SELECT codigo, nombre, valor, ID FROM datosanti WHERE $ComSql2 AND IDEmpresa = $IDEmpresa AND tipoN = $Tn AND periodoP = $Periodo";

$numr = $objBDSQL->obtenfilas($consultaPermisos);
if($numr['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
  fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numr['SQLSTATE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numr['CODIGO'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numr['MENSAJE'].PHP_EOL);
  fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaPermisos.PHP_EOL);
  fclose($file);
  /////////////////////////////
  $objBDSQL->cerrarBD();
  exit();
}
if(empty($numr)){
  $numr = 0;
}

$consultaEmpleados = "
SELECT E.codigo, E.nombre + ' ' + E.ap_paterno + ' ' + E.ap_materno AS nombre
FROM empleados AS E
  INNER JOIN Llaves AS L ON L.codigo = E.codigo AND L.empresa = E.empresa
WHERE $ComSql1 AND
  L.empresa = $IDEmpresa AND
  L.tiponom = $Tn
";

if($_SESSION['Permiso'] == 1 && (Autoriza2 == $_SESSION['User'] || Autoriza1 == $_SESSION['User'])){

if(Autoriza2 == $_SESSION['User']){
    $complemento = "<th>Contralor</th>";
}
if(Autoriza1 == $_SESSION['User']){
    $complemento = "<th>Gerente</th>";
}

//$query = $bdM->query($consultaPermisos);
echo '
<ul class="collapsible" data-collapsible="accordion">
  <li>
    <div class="collapsible-header" onclick="pruebaA(\'cod52\')"><span class="new badge" data-badge-caption="Total">'.$numr['cantidad'].'</span><i class="material-icons">mode_edit</i>Permisos</div>
    <div class="collapsible-body" id="cod52">
      <table class="responsive-table highlight centered">
      <thead>
        <tr>
          <th>Codigo</th>
          <th>Nombre</th>
          <th>Fecha</th>
          <th>Insidencia</th>
          '.$complemento.'
        </tr>
      </thead>
      <tbody>
';
//<th>Contralor</th>
$objBDSQL->consultaBD($consultaEmpleados);
while ($row = $objBDSQL->obtenResult()) {
  $consultaPermisos = "SELECT codigo, nombre, valor, ID, Autorizo1, Autorizo2 FROM datosanti WHERE $ComSql2 AND IDEmpresa = $IDEmpresa AND tipoN = $Tn AND periodoP = $Periodo AND codigo = ".$row['codigo'];
  $objBDSQL2->consultaBD2($consultaPermisos);
  while($datos = $objBDSQL2->obtenResult2()){
      $codigo = $datos['codigo'];
      $nombre = $datos['nombre'];
      $valor = $datos['valor'];
      $ID = $datos['ID'];
      $auto1 = $datos['Autorizo1'];
      $auto2 = $datos['Autorizo2'];
      if($auto1 == 0){
        $Che1 = "";
        $AuChe = 1;
      }else {
        $Che1 = 'checked="checked"';
        $AuChe = 2;
      }

      if($auto2 == 0){
        $Che2 = "";
        $AuChe2 = 1;
      }else {
        $Che2 = 'checked="checked"';
        $AuChe2 = 2;
      }

      if(Autoriza2 == $_SESSION['User']){
        $complemento2 = '<td>
                            <p style="padding: .5rem;">
                              <input type="checkbox" class="filled-in" id="'.$ID.'C" '.$Che2.' />
                              <label for="'.$ID.'C" onclick="autorizar2('.$ID.','.$AuChe2.', \'lb'.$ID.'C\', '.$codigo.', \''.substr($nombre, 5).'\')" id="lb'.$ID.'C"></label>
                            </p>
                        </td>';

      }
      if(Autoriza1 == $_SESSION['User']){
          $complemento2 = '<td>
                              <p style="padding: .5rem;">
                                <input type="checkbox" class="filled-in" id="'.$ID.'G" '.$Che1.' />
                                <label for="'.$ID.'G" onclick="autorizar('.$ID.','.$AuChe.', \'lb'.$ID.'G\', '.$codigo.', \''.substr($nombre, 5).'\')" id="lb'.$ID.'G"></label>
                              </p>
                          </td>';
      }

      echo '
        <tr>
          <td class="Aline">'.$codigo.'</td>
          <td class="Aline">'.$row['nombre'].'</td>
          <td class="Aline">'.$nombre.'</td>
          <td class="Aline">'.$valor.'</td>
          '.$complemento2.'
        <tr>
      ';
    }
}

echo '
        </tbody>
      </table>
    </div>
  </li>
</ul>

<br>
<br>
';
}
$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();
?>
