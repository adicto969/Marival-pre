<?php
//ConseptosExt
$BDM = new ConexionM();
$BDM->__constructM();
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$tnomina = $_POST["TN"];
$arrayConExt = array();
$cabExtCon = "<table>
							<thead>
							<tr>
								<th colspan='3'></th>
								<th colspan='2' class='center' style='border-left: 1px solid;'>BONOS</th>
								<th colspan='2' class='center' style='border-left: 1px solid;'>OTROS PAGOS</th>
								<th colspan='2' class='center' style='border-left: 1px solid; border-right: 1px solid;'>OTROS DESCUENTOS</th>
							</tr>
							<tr>";
if($PC <= 24){
	$fechas = periodo($PC);
	list($fecha1,$fecha2,$fecha3,$fecha4) = explode(',', $fechas);
}

if($tnomina == 1 || $PC > 24){
  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1', CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2' FROM Periodos WHERE tiponom = 1 AND periodo = $PC AND ayo_operacion = $ayoA AND empresa = $IDEmpresa ;";
  $_resultados = $objBDSQL->consultaBD($_queryFechas);
  if($_resultados === false)
  {
      die(print_r(sqlsrv_errors(), true));
      exit();
  }else {
      $_datos = $objBDSQL->obtenResult();
  }
  $fecha1 = $_datos['FECHA1'];
  $fecha2 = $_datos['FECHA1'];
  $objBDSQL->liberarC();
}

list($dia, $mes, $ayo) = explode('/', $fecha1);
list($dia2, $mes2, $ayo2) = explode('/', $fecha2);

$fecha1 = $ayo.$mes.$dia;
$fecha2 = $ayo2.$mes2.$dia2;

$querySQL1 = "SELECT L.codigo AS Codigo,
										 E.nombre + ' '+E.ap_paterno + ' '+E.ap_materno AS Nombre,
										 E.sueldo,
										 IMPORTE_B,
										 FRENTE_B,
										 IMPORTE_OP,
										 FRENTE_OP,
										 IMPORTE_OD,
										 FRENTE_OD";
$querySQL2 = "";
if($DepOsub == 1){
  if($supervisor == 0){
    $querySQL2 = "
                 FROM Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

                 WHERE L.empresa = ".$IDEmpresa." AND
          			 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.") AND
          			 L.tiponom = '".$tnomina."' AND
          			 E.activo = 'S'";
  }else {
    $querySQL2 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

                 WHERE L.empresa = ".$IDEmpresa." AND
                 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.") AND
                 L.supervisor = '".$supervisor."' AND
                 L.tiponom = '".$tnomina."' AND
                 E.activo = 'S'";
  }

    $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  if($supervisor == 0){
    $querySQL2 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

                 WHERE L.empresa = ".$IDEmpresa." AND
          			 L.centro = '".$centro."' AND
          			 L.tiponom = '".$tnomina."' AND
                 E.activo = 'S'";
  }else {
    $querySQL2 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

                 WHERE L.empresa = ".$IDEmpresa." AND
                 L.centro = '".$centro."' AND
                 L.supervisor = '".$supervisor."' AND
                 L.tiponom = '".$tnomina."' AND
                 E.activo = 'S'
                 ";
  }

    $ComSql2 = "Centro = '".$centro."'";
}
//$row =  $objBDSQL->obtenResult();
$cabExtCon .= "<th>Codigo</th>";
$cabExtCon .= "<th>Nombre</th>";
$cabExtCon .= "<th>Sueldo</th>";
$cabExtCon .= "<th class='center'>IMPORTE</th>";
$cabExtCon .= "<th class='center'>FRENTE</th>";
$cabExtCon .= "<th class='center'>IMPORTE</th>";
$cabExtCon .= "<th class='center'>FRENTE</th>";
$cabExtCon .= "<th class='center'>IMPORTE</th>";
$cabExtCon .= "<th class='center'>FRENTE</th>";

$cabExtCon .= "</tr></thead>";
$cabExtCon .= "<tbody>";

$objBDSQL->consultaBD($querySQL1.$querySQL2);
while ( $row = $objBDSQL->obtenResult() )
{
  $cabExtCon .= "<tr>";
  $cabExtCon .= "<td>".$row['Codigo']."</td>";
  $cabExtCon .= "<td>".utf8_encode($row['Nombre'])."</td>";
  $cabExtCon .= "<td>".$row['sueldo']."</td>";

  if(!empty($row['IMPORTE_B'])){
      $cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'IMPORTE_B" value="'.$row['IMPORTE_B'].'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'IMPORTE_B\', \''.$row['Codigo'].'IMPORTE_B\')" ></td>';
  }else {
      $cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'IMPORTE_B" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'IMPORTE_B\', \''.$row['Codigo'].'IMPORTE_B\')" ></td>';
  }

	if(!empty($row['FRENTE_B'])){
      $cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'FRENTE_B" value="'.$row['FRENTE_B'].'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'FRENTE_B\', \''.$row['Codigo'].'FRENTE_B\')" ></td>';
  }else {
      $cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'FRENTE_B" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'FRENTE_B\', \''.$row['Codigo'].'FRENTE_B\')" ></td>';
  }

	if(!empty($row['IMPORTE_OP'])){
			$cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'IMPORTE_OP" value="'.$row['IMPORTE_OP'].'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'IMPORTE_OP\', \''.$row['Codigo'].'IMPORTE_OP\')" ></td>';
	}else {
			$cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'IMPORTE_OP" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'IMPORTE_OP\', \''.$row['Codigo'].'IMPORTE_OP\')" ></td>';
	}

	if(!empty($row['FRENTE_OP'])){
			$cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'FRENTE_OP" value="'.$row['FRENTE_OP'].'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'FRENTE_OP\', \''.$row['Codigo'].'FRENTE_OP\')" ></td>';
	}else {
			$cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'FRENTE_OP" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'FRENTE_OP\', \''.$row['Codigo'].'FRENTE_OP\')" ></td>';
	}

	if(!empty($row['IMPORTE_OD'])){
			$cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'IMPORTE_OD" value="'.$row['IMPORTE_OD'].'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'IMPORTE_OD\', \''.$row['Codigo'].'IMPORTE_OD\')" ></td>';
	}else {
			$cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'IMPORTE_OD" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'IMPORTE_OD\', \''.$row['Codigo'].'IMPORTE_OD\')" ></td>';
	}

	if(!empty($row['FRENTE_OD'])){
			$cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'FRENTE_OD" value="'.$row['FRENTE_OD'].'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'FRENTE_OD\', \''.$row['Codigo'].'FRENTE_OD\')" ></td>';
	}else {
			$cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].'FRENTE_OD" onkeyup="InserConExt(\''.$row['Codigo'].'\', \'FRENTE_OD\', \''.$row['Codigo'].'FRENTE_OD\')" ></td>';
	}


  $cabExtCon .= "</tr>";
}
$cabExtCon .= "</tbody></table>";
echo $cabExtCon;
echo '<input type="hidden" value="1" id="OCV" >';
$objBDSQL->liberarC();
$objBDSQL->cerrarBD();

?>
