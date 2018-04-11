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

$objPHPExcel2 = new PHPExcel();
$objReader2 = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel2 = $objReader->load("plantillaExcel/PDOM.xls");
$objPHPExcel2->setActiveSheetIndex(0);

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
}
}
}

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
		if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){
			$querySQL2 = "
									 FROM Llaves AS L
									 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
									 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

									 WHERE L.empresa = ".$IDEmpresa." AND
									 L.tiponom = '".$TN."' AND
									 E.activo = 'S'";
		}else {
			$querySQL2 = "
									 FROM Llaves AS L
									 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
									 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

									 WHERE L.empresa = ".$IDEmpresa." AND
									 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.") AND
									 L.tiponom = '".$TN."' AND
									 E.activo = 'S'";
		}
	}else {
		if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){
			$querySQL2 = "
									 from Llaves AS L
									 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
									 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

									 WHERE L.empresa = ".$IDEmpresa." AND
									 L.supervisor = '".$supervisor."' AND
									 L.tiponom = '".$TN."' AND
									 E.activo = 'S'";
		}else {
			$querySQL2 = "
									 from Llaves AS L
									 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
									 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

									 WHERE L.empresa = ".$IDEmpresa." AND
									 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.") AND
									 L.supervisor = '".$supervisor."' AND
									 L.tiponom = '".$TN."' AND
									 E.activo = 'S'";
		}

	}

		$ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
	if($supervisor == 0){
		if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){
			$querySQL2 = "
									 from Llaves AS L
									 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
									 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

									 WHERE L.empresa = ".$IDEmpresa." AND
									 L.tiponom = '".$TN."' AND
									 E.activo = 'S'";
		}else {
			$querySQL2 = "
									 from Llaves AS L
									 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
									 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

									 WHERE L.empresa = ".$IDEmpresa." AND
									 L.centro = '".$centro."' AND
									 L.tiponom = '".$TN."' AND
									 E.activo = 'S'";
		}
	}else {
		if($Centro == 'todos' || $Centro == 'TODOS' || $Centro == 'todo' || $Centro == 'TODO'){
			$querySQL2 = "
									 from Llaves AS L
									 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
									 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

									 WHERE L.empresa = ".$IDEmpresa." AND
									 L.supervisor = '".$supervisor."' AND
									 L.tiponom = '".$TN."' AND
									 E.activo = 'S'
									 ";
		}else {
			$querySQL2 = "
									 from Llaves AS L
									 INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
									 LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

									 WHERE L.empresa = ".$IDEmpresa." AND
									 L.centro = '".$centro."' AND
									 L.supervisor = '".$supervisor."' AND
									 L.tiponom = '".$TN."' AND
									 E.activo = 'S'
									 ";
		}

	}

		$ComSql2 = "Centro = '".$centro."'";
}

$objBDSQL->consultaBD($querySQL1.$querySQL2);
$FILA = 2;
$FILA2 = 2;
$lr = 0;

while ( $row = $objBDSQL->obtenResult() )
{
  $lr++;
  $paso = 'F';
  $paso2 = 'F';
  if(!empty($row["IMPORTE_B"])){
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["Codigo"])
                                  ->SetCellValue('B'.$FILA, 42)
                                  ->SetCellValue('C'.$FILA, $row["IMPORTE_B"]);
    $paso = 'V';
    $FILA++;
  }
  if(!empty($row["IMPORTE_OP"])){
    if($paso == 'V'){
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.($FILA), $row["Codigo"])
                                    ->SetCellValue('B'.($FILA), 41)
                                    ->SetCellValue('C'.($FILA), $row["IMPORTE_OP"]);
      $FILA++;
    }else {
      $objPHPExcel->getActiveSheet()->SetCellValue('A'.($FILA), $row["Codigo"])
                                    ->SetCellValue('B'.($FILA), 41)
                                    ->SetCellValue('C'.($FILA), $row["IMPORTE_OP"]);
      $FILA++;
    }
    $paso2 = 'V';
  }

  if(!empty($row["IMPORTE_OD"])){
      $objPHPExcel2->getActiveSheet()->SetCellValue('A'.($FILA2), $row["Codigo"])
                                    ->SetCellValue('B'.($FILA2), 142)
                                    ->SetCellValue('C'.($FILA2), $row["IMPORTE_OD"]);
      $FILA2++;
  }
}
$objBDSQL->liberarC();
$objBDSQL->cerrarBD();

$NombreD="";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\CodigoExtraPagos('.trim ($NombreD, " \t.").').xls');

$objWriter2 = PHPExcel_IOFactory::createWriter($objPHPExcel2, 'Excel5');
$objWriter2->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\CodigoExtraDescuentos('.trim ($NombreD, " \t.").').xls');

echo "1";
//echo Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\DESTAJO('.trim ($NombreD, " \t.").').xls';

?>
