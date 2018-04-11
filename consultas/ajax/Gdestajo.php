<?php
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();


$objPHPExcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("plantillaExcel/PDOM.xls");
$objPHPExcel->setActiveSheetIndex(0);
$Tn = $_POST['TN'];
$Centro = $_POST['centro'];

$Dep = "";
$Carpeta = "quincenal";

if($Tn == 1){
	$Carpeta = "semanal";
}

$querySQL1 = "select L.codigo AS Codigo,
                    E.nombre + ' '+E.ap_paterno + ' '+E.ap_materno AS Nombre,
                    E.sueldo,";
$querySQL2 = "";
if($DepOsub == 1){
  if($supervisor == 0){
    if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){
	    $querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND          			 
          			 L.tiponom = '".$Tn."' AND
          			 E.activo = 'S'";
    }else {
	    $querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
          			 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.") AND
          			 L.tiponom = '".$Tn."' AND
          			 E.activo = 'S'";
    }

  }else {
    if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO') {
	$querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
                 L.supervisor = '".$supervisor."' AND
                 L.tiponom = '".$Tn."' AND
                 E.activo = 'S'";
    }else {
	$querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
                 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.") AND
                 L.supervisor = '".$supervisor."' AND
                 L.tiponom = '".$Tn."' AND
                 E.activo = 'S'";
    }
    
  }

    
  if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){
	  $ComSql2 = "";
  }else {
	  $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  }

}else {
  if($supervisor == 0){
    if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){
	$querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
          			 L.tiponom = '".$Tn."' AND
                 E.activo = 'S'";
    }else {
	$querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
          			 L.centro = '".$centro."' AND
          			 L.tiponom = '".$Tn."' AND
                 E.activo = 'S'";
    }
    
  }else {
    if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){

	$querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
                 L.supervisor = '".$supervisor."' AND
                 L.tiponom = '".$Tn."' AND
                 E.activo = 'S'
                 ";
    }else {
	$querySQL3 = "
                 from Llaves AS L
                 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                 LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                 WHERE L.empresa = ".$IDEmpresa." AND
                 L.centro = '".$centro."' AND
                 L.supervisor = '".$supervisor."' AND
                 L.tiponom = '".$Tn."' AND
                 E.activo = 'S'
                 ";

    }
    
  }
  if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){
	  $ComSql2 = "";
  }else {
	  $ComSql2 = "Centro = '".$centro."'";
  }

}

$consultaCa = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'destajo'";
$reultadoo = $objBDSQL->consultaBD($consultaCa);
//$row =  $objBDSQL->obtenResult();
$cabExtCon= "";
$cabExtCon .= "<th>Codigo</th>";
$cabExtCon .= "<th>Nombre</th>";
$cabExtCon .= "<th>sueldo</th>";
while($datos = $objBDSQL->obtenResult()){
    if($datos['COLUMN_NAME'] != "ID" && $datos['COLUMN_NAME'] != "Codigo" && $datos['COLUMN_NAME'] != "Periodo" && $datos['COLUMN_NAME'] != "IDEmpresa" && $datos['COLUMN_NAME'] != "Centro" && $datos['COLUMN_NAME'] != "fecha" ){
          $arrayConExt[] = $datos['COLUMN_NAME'];
          $querySQL2 .= "D.".$datos['COLUMN_NAME'].",";
          $cabExtCon .= '<th>'.$datos['COLUMN_NAME'].'<i class="close material-icons" style="display: contents; color: red; cursor: pointer;" title="Eliminar" onclick="eliminarColumna(\''.$datos['COLUMN_NAME'].'\')">close</i></th>';
    }
}
$objBDSQL->liberarC();
$querySQL2 = substr($querySQL2, 0, -1);
$objBDSQL->consultaBD($querySQL1.$querySQL2.$querySQL3);
$FILA = 2;
$lr = 0;

while ( $row = $objBDSQL->obtenResult() )
{
  $lr++;
  $paso = 'F';
  $paso2 = 'F';
  if(!empty($row["CONCEPTO_1"]) && !empty($row["IMPORTE_1"])){
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["Codigo"])
                                  ->SetCellValue('B'.$FILA, 40)
                                  ->SetCellValue('C'.$FILA, $row["IMPORTE_1"]);
    $paso = 'V';
    $FILA++;
  }
  if(!empty($row["CONCEPTO_2"]) && !empty($row["IMPORTE_2"])){
    if($paso == 'V'){
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.($FILA), $row["Codigo"])
                                    ->SetCellValue('B'.($FILA), 40)
                                    ->SetCellValue('C'.($FILA), $row["IMPORTE_2"]);
      $FILA++;
    }else {
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.($FILA), $row["Codigo"])
                                    ->SetCellValue('B'.($FILA), 40)
                                    ->SetCellValue('C'.($FILA), $row["IMPORTE_2"]);
      $FILA++;
    }

    $paso2 = 'V';
  }

  if(!empty($row["CONCEPTO_3"]) && !empty($row["IMPORTE_3"])){
    if($paso2 == 'V'){
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.($FILA), $row["Codigo"])
                                    ->SetCellValue('B'.($FILA), 40)
                                    ->SetCellValue('C'.($FILA), $row["IMPORTE_3"]);
      $FILA++;
    }else {
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.($FILA), $row["Codigo"])
                                    ->SetCellValue('B'.($FILA), 40)
                                    ->SetCellValue('C'.($FILA), $row["IMPORTE_3"]);
      $FILA++;
    }

  }

  //$FILA = $FILA+3;

  /*foreach ($arrayConExt as $valor) {
    //$cabExtCon .= "<td>".$row[$valor]."</td>";
    if(!empty($row[$valor])){
        $cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].$valor.'" value="'.$row[$valor].'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \''.$valor.'\', \''.$row['Codigo'].$valor.'\')" ></td>';
    }else {
        $cabExtCon .= '<td><input type="text" id="'.$row['Codigo'].$valor.'" onkeyup="InserConExt(\''.$row['Codigo'].'\', \''.$valor.'\', \''.$row['Codigo'].$valor.'\')" ></td>';
    }
  }*/
}
$objBDSQL->liberarC();
$objBDSQL->cerrarBD();

$NombreD="";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\DESTAJO('.trim ($NombreD, " \t.").').xls');

echo "1";
//echo Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\DESTAJO('.trim ($NombreD, " \t.").').xls';

?>
