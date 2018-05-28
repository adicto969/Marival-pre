<?php
//ConseptosExt
$BDM = new ConexionM();
$BDM->__constructM();
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$arrayConExt = array();
$cabExtCon = "<thead><tr>";
if($PC <= 24){
	$fechas = periodo($PC);
	list($fecha1,$fecha2,$fecha3,$fecha4) = explode(',', $fechas);
}

if($TN == 1 || $PC > 24){
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

if($DepOsub == 1){
  $querySQL = "[dbo].[reporte_checadas_excel_ctro]
            '".$fecha1."',
            '".$fecha2."',
            '".$centro."',
            '".$supervisor."',
            '".$IDEmpresa."',
            '".$TN."',
            'LEFT (Llaves.centro, ".$MascaraEm.") = LEFT (''".$centro."'', ".$MascaraEm.")',
            '1'";

    $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $querySQL = "[dbo].[reporte_checadas_excel_ctro]
            '".$fecha1."',
            '".$fecha2."',
            '".$centro."',
            '".$supervisor."',
            '".$IDEmpresa."',
            '".$TN."',
            'Llaves.centro = ''".$centro."''',
            '0'";

    $ComSql2 = "Centro = '".$centro."'";
}
$consultaCa = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'conseptoextra'";
$reultadoo = $objBDSQL->consultaBD($consultaCa);
//$row =  $objBDSQL->obtenResult();
while($datos = $objBDSQL->obtenResult()){
    if($datos['COLUMN_NAME'] != "ID" && $datos['COLUMN_NAME'] != "Periodo" && $datos['COLUMN_NAME'] != "IDEmpresa" && $datos['COLUMN_NAME'] != "Centro"){
        if( $datos['COLUMN_NAME'] != "Codigo"){
            $arrayConExt[] = $datos['COLUMN_NAME'];
            $cabExtCon .= '<th>'.$datos['COLUMN_NAME'].'<i class="close material-icons" style="display: contents; color: red; cursor: pointer;" title="Eliminar" onclick="eliminarColumna(\''.$datos['COLUMN_NAME'].'\')">close</i></th>';
        }else {
          $cabExtCon .= '<th>'.$datos['COLUMN_NAME'].'</th>';
        }
    }
}
$cabExtCon .= "</tr></thead>";
$cabExtCon .= "<tbody>";
$objBDSQL->liberarC();

$objBDSQL->consultaBD($querySQL);
while ( $row = $objBDSQL->obtenResult() )
{
  $cabExtCon .= "<tr>";
  $cabExtCon .= "<td>".$row['codigo']."</td>";

  foreach ($arrayConExt as $valor) {
    $ccS = "SELECT ".$valor." FROM conseptoextra WHERE Codigo = '".$row['codigo']."' AND Periodo = '$PC' AND IDEmpresa = '$IDEmpresa' AND ".$ComSql2.";";
    echo $ccS;
    $objBDSQL2->consultaBD2($ccS);
    $datose = $objBDSQL2->obtenResult2();
    if(!empty($datose[$valor])){
        $cabExtCon .= '<td><input type="text" id="'.$row['codigo'].$valor.'" value="'.$datose[$valor].'" onkeyup="InserConExt(\''.$row['codigo'].'\', \''.$valor.'\', \''.$row['codigo'].$valor.'\')" ></td>';
    }else {
        $cabExtCon .= '<td><input type="text" id="'.$row['codigo'].$valor.'" onkeyup="InserConExt(\''.$row['codigo'].'\', \''.$valor.'\', \''.$row['codigo'].$valor.'\')" ></td>';
    }
    $objBDSQL2->liberarC2();
  }
  $cabExtCon .= "</tr>";
}
$cabExtCon .= "</tbody>";
echo $cabExtCon;
echo '<input type="hidden" value="1" id="OCV" >';
$objBDSQL->liberarC();
$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();

?>
