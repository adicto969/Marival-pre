<?php
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
$_dias = array('', 'LUN', 'MAR', 'MIE', 'JUE', 'VIE', 'SAB', 'DOM');
$tn = $TN;

function truncateFloat($number, $digitos)
{
    $raiz = 10;
    $multiplicador = pow ($raiz,$digitos);
    $resultado = ((int)($number * $multiplicador)) / $multiplicador;
    return number_format($resultado, $digitos);

}
########################################################################################
############################CONFIGURACION EXTRA##########################################
/*$estiloTituloReporte = array(
    'font' => array(
        'name'      => 'Verdana',
        'bold'      => true,
        'italic'    => false,
        'strike'    => false,
        'size' =>16,
        'color'     => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
      'type'  => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array(
            'argb' => 'FF220835')
  ),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_NONE
        )
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'rotation' => 0,
        'wrap' => TRUE
    )
);

$estiloTituloColumnas = array(
    'font' => array(
        'name'  => 'Arial',
        'bold'  => true,
        'color' => array(
            'rgb' => 'FFFFFF'
        )
    ),
    'fill' => array(
        'type'       => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
  'rotation'   => 90,
        'startcolor' => array(
            'rgb' => 'c47cf2'
        ),
        'endcolor' => array(
            'argb' => 'FF431a5d'
        )
    ),
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_MEDIUM ,
            'color' => array(
                'rgb' => '143860'
            )
        )
    ),
    'alignment' =>  array(
        'horizontal'=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        'wrap'      => TRUE
    )
);

$estiloInformacion = new PHPExcel_Style();
$estiloInformacion->applyFromArray( array(
    'font' => array(
        'name'  => 'Arial',
        'color' => array(
            'rgb' => '000000'
        )
    ),
    'fill' => array(
  'type'  => PHPExcel_Style_Fill::FILL_SOLID,
  'color' => array(
            'argb' => 'FFd9b7f4')
  ),
    'borders' => array(
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN ,
      'color' => array(
              'rgb' => '3a2a47'
            )
        )
    )
));

$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray($estiloTituloReporte);
$objPHPExcel->getActiveSheet()->getStyle('A3:D3')->applyFromArray($estiloTituloColumnas);
$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A4:D".($i-1));
// Se asigna el nombre a la hoja
$objPHPExcel->getActiveSheet()->setTitle('Alumnos');

// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
$objPHPExcel->setActiveSheetIndex(0);

// Inmovilizar paneles
//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,4);

*/


########################################################################################
############################CREAR ARCHIV EXCEL ########################################
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();
$tipo = $_POST['tipo'];
//$titulo = $_POST['titulo'];


$objPHPExcel = new PHPExcel();
// Leemos un archivo Excel 2007
$objReader = PHPExcel_IOFactory::createReader('Excel5');
// Leemos un archivo Excel 2007
//$objPHPExcel = $objReader->load("plantillaExcel/faltas.xls");
$objPHPExcel->getProperties()->setCreator("APSI")
            ->setLastModifiedBy("APSI")
            ->setTitle("Reporte Excel APSI")
            ->setDescription("Reporte Excel APSI")
            ->setKeywords("Reporte Excel APSI")
            ->setCategory("Reporte Excel");
// Indicamos que se pare en la hoja uno del libro
$objPHPExcel->setActiveSheetIndex(0);

$FILA = 6;


$objPHPExcel->setActiveSheetIndex(0)->mergeCells('D2:K2');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', $NomDep);

$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->getActiveSheet()->getStyle("D2")->getFont()->setBold(true)
                              ->setName('Verdana')
                              ->setSize(18)
                              ->getColor()->setRGB('6F6F6F');

$objPHPExcel->getActiveSheet()->SetCellValue('I3', "Fecha :");
$objPHPExcel->getActiveSheet()->SetCellValue('J3', date("d/m/Y"));


if($tipo == "destajo"){

  $tn = $_POST['TN'];
  $Dep = $_POST['Dep'];

  $querySQL1 = "select L.codigo AS Codigo,
                      E.nombre + ' '+E.ap_paterno + ' '+E.ap_materno AS Nombre,
                      E.sueldo,";
  $querySQL2 = "";
  if($DepOsub == 1){
    if($supervisor == 0){
      if($Dep == 'todos' || $Dep == 'TODOS' || $Dep == 'todo' || $Dep == 'TODO'){
	       $querySQL3 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                   WHERE L.empresa = ".$IDEmpresa." AND
            			 L.tiponom = '".$tn."' AND
            			 E.activo = 'S'";
      }else {
	       $querySQL3 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                   WHERE L.empresa = ".$IDEmpresa." AND
            			 LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$Dep."', ".$MascaraEm.") AND
            			 L.tiponom = '".$tn."' AND
            			 E.activo = 'S'";
      }

    }else {

      if($Dep == 'todos' || $Dep == 'TODOS' || $Dep == 'todo' || $Dep == 'TODO'){
	      $querySQL3 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                   WHERE L.empresa = ".$IDEmpresa." AND
                   L.supervisor = '".$supervisor."' AND
                   L.tiponom = '".$tn."' AND
                   E.activo = 'S'";
      }else {
	      $querySQL3 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                   WHERE L.empresa = ".$IDEmpresa." AND
                   LEFT (L.centro, ".$MascaraEm.") = LEFT ('".$Dep."', ".$MascaraEm.") AND
                   L.supervisor = '".$supervisor."' AND
                   L.tiponom = '".$tn."' AND
                   E.activo = 'S'";
      }
    }
      if($Dep == 'todos' || $Dep == 'TODOS' || $Dep == 'todo' || $Dep == 'TODO'){
	       $ComSql2 = "";
      }else {
	       $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$Dep."', ".$MascaraEm.")";
      }

  }else {
    if($supervisor == 0){
      if($Dep == 'todos' || $Dep == 'TODOS' || $Dep == 'todo' || $Dep == 'TODO'){
	       $querySQL3 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                   WHERE L.empresa = ".$IDEmpresa." AND
            			 L.tiponom = '".$tn."' AND
                   E.activo = 'S'";
      }else {
	       $querySQL3 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                   WHERE L.empresa = ".$IDEmpresa." AND
            			 L.centro = '".$Dep."' AND
            			 L.tiponom = '".$tn."' AND
                   E.activo = 'S'";
      }

    }else {
      if($Dep == 'todos' || $Dep == 'TODOS' || $Dep == 'todo' || $Dep == 'TODO'){
	       $querySQL3 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                   WHERE L.empresa = ".$IDEmpresa." AND
                   L.supervisor = '".$supervisor."' AND
                   L.tiponom = '".$tn."' AND
                   E.activo = 'S'
                   ";
      }else {

	       $querySQL3 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN destajo AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."'

                   WHERE L.empresa = ".$IDEmpresa." AND
                   L.centro = '".$Dep."' AND
                   L.supervisor = '".$supervisor."' AND
                   L.tiponom = '".$tn."' AND
                   E.activo = 'S'
                   ";
      }
    }

    if($Dep == 'todos' || $Dep == 'TODOS' || $Dep == 'todo' || $Dep == 'TODO'){
	  $ComSql2 = "";
    }else {
    	  $ComSql2 = "Centro = '".$Dep."'";
    }

  }

  $consultaCa = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'destajo'";
  $reultadoo = $objBDSQL->consultaBD($consultaCa);


  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, "Codigo");
  $objPHPExcel->getActiveSheet()->SetCellValue('B'.$FILA, "Nombre");
  $objPHPExcel->getActiveSheet()->SetCellValue('C'.$FILA, "Sueldo");
  $letra = 'D';
  while($datos = $objBDSQL->obtenResult()){
    if($datos['COLUMN_NAME'] != "ID" && $datos['COLUMN_NAME'] != "Codigo" && $datos['COLUMN_NAME'] != "Periodo" && $datos['COLUMN_NAME'] != "IDEmpresa" && $datos['COLUMN_NAME'] != "Centro" && $datos['COLUMN_NAME'] != "fecha" ){
      $arrayConExt[] = $datos['COLUMN_NAME'];
      if($datos['COLUMN_NAME'] == "CONCEPTO_1" || $datos['COLUMN_NAME'] == 'CONCEPTO_2' || $datos['COLUMN_NAME'] == 'CONCEPTO_3'){
      	$objPHPExcel->getActiveSheet()->SetCellValue($letra.$FILA, "FRENTE");
      }else {
    	$objPHPExcel->getActiveSheet()->SetCellValue($letra.$FILA, $datos['COLUMN_NAME']);
      }

      $querySQL2 .= "D.".$datos['COLUMN_NAME'].",";
      $letra++;
    }
  }
  $FILA++;
  $querySQL2 = substr($querySQL2, 0, -1);
  $objBDSQL->liberarC();
  $objBDSQL->consultaBD($querySQL1.$querySQL2.$querySQL3);

  while ($row = $objBDSQL->obtenResult()) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row['Codigo']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$FILA, $row['Nombre']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$FILA, $row['sueldo']);
    $letra = 'D';
    foreach ($arrayConExt as $value) {
        $objPHPExcel->getActiveSheet()->SetCellValue($letra.$FILA, $row[$value]);
        $letra++;
    }
    $FILA++;
  }

}else if($tipo == "tasistencia"){
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  list($_dia, $_mes, $_ayo) = explode('/', $fecha1);
  list($_diaB, $_mesB, $_ayoB) = explode('/', $fecha2);

  $fecha1 = $_ayo.$_mes.$_dia;
  $fecha2 = $_ayoB.$_mesB.$_diaB;
  if($DepOsub == 1)
  {
    $queryGeneral = "
    [dbo].[reporte_checadas_excel_ctro]
    '".$fecha1."',
    '".$fecha2."',
    '".$centro."',
    '".$supervisor."',
    '".$IDEmpresa."',
    '".$TN."',
    'LEFT (L.centro, 10) = LEFT (''".$centro."'', ".$MascaraEm.")',
    '1',
    '1',
    '10',
    '',
    '',
    '".$ordernar."'
    ";
    $ComSql = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  }else {
    $queryGeneral = "
    [dbo].[reporte_checadas_excel_ctro]
    '".$fecha1."',
    '".$fecha2."',
    '".$centro."',
    '".$supervisor."',
    '".$IDEmpresa."',
    '".$TN."',
    'L.centro = ''".$centro."''',
    '0',
    '1',
    '10',
    '',
    '',
    ''";
    $ComSql = "Centro = '".$centro."'";
  }

  $Nresultados = 1;
  $letraAun = 'A';
  $FILA = 7;
  $objBDSQL->consultaBD($queryGeneral);
  while ($row=$objBDSQL->obtenResult()) {
    $letraAun2 = 'A';
    foreach ($row as $key => $value) {
        if($Nresultados == 1){
          $objPHPExcel->getActiveSheet()->SetCellValue($letraAun.'6', $key);
          $letraAun++;
        }

        $tmp_valorC = "";
        $_FechaCol = str_replace("/", "-", $key);
        $_FechaPar = date('Y-m-d', strtotime($_FechaCol));
        $_DiaNumero = date('N', strtotime($_FechaPar));
        if($_DiaNumero == 1){
            $_FechaNDQ = $_dias[6];
        }else {
            $_FechaNDQ = $_dias[$_DiaNumero-1];
        }

        $_queryDatos = "
          SELECT
            (SELECT TOP(1) valor FROM datos WHERE codigo = '".$row['codigo']."' AND nombre = '".str_replace("/", "-", $key)."' and periodoP = '".$PC."' and tipoN = '".$TN."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql.") AS 'B',
            (SELECT TOP(1) valor FROM datosanti WHERE codigo = '".$row['codigo']."' AND nombre = 'fecha".str_replace("/", "-", $key)."' and periodoP = '".$PC."' and tipoN = '".$TN."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql." and Autorizo1 = 1) AS 'C'
        ";

        $consultaMedi = $objBDSQL2->consultaBD2($_queryDatos);
        if($consultaMedi === false){
          die(print_r(sqlsrv_errors(), true));
          exit();
        }else {
          $row2 = $objBDSQL2->obtenResult2();
          $objBDSQL2->liberarC2();
        }
        $valorC = "";
        if(!empty($row2['B'])){
          if($row2['B'] == '-n' || $row2['B'] == '-N'){

          }else {
            $valorC = $row2['B'];
          }
        }

        if(!empty($row2['C'])){
          if($row2['C'] == '-n' || $row2['C'] == '-N'){

          }else {
            $valorC = $row2['C'];
          }
        }
        if($key == 'codigo' || $key == 'Nombre' || $key == 'Sueldo' || $key == 'Tpo'){
            $objPHPExcel->getActiveSheet()->SetCellValue($letraAun2.$FILA, $value);
        }else {
            $objPHPExcel->getActiveSheet()->SetCellValue($letraAun2.$FILA, $valorC);
        }

        $letraAun2++;
    }
    $Nresultados++;
    $FILA++;
  }

}else if($tipo == "contrato"){

  if($DepOsub == 1)
  {
    $ComSql = "LEFT (llaves.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
    $ComSql2 = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  }else {
    $ComSql = "llaves.centro = '".$centro."'";
    $ComSql2 = "centro = '".$centro."'";
  }

  if($supervisor == 0){
    $query = "
    select all (empleados.codigo) AS 'codigo',
        ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS 'nombre',
    	  llaves.ocupacion AS 'ocupacion',
    	  tabulador.actividad AS 'actividad',
    	  llaves.horario AS 'horario',
        MAx (convert(varchar(10),empleados.fchantigua,103)) AS 'fechaAnti',
        max(convert(varchar(10),contratos.fchAlta ,103)) AS 'fechaAlta',
        max(convert(varchar(10),contratos.fchterm ,103)) AS 'fechaTer',
        SUM(contratos.dias) AS 'dias',
        C.Observacion,
        C.Contrato

        from empleados

        LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
        INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
        INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion
        LEFT JOIN contrato AS C on C.IDEmpleado = empleados.codigo AND C.IDEmpresa = Llaves.empresa AND C.centro = Llaves.centro

        where empleados.activo = 'S' AND
        ".$ComSql." and llaves.empresa = '".$IDEmpresa."'

        group by  empleados.codigo,
              empleados.ap_paterno,
              empleados.ap_materno,
              empleados.nombre,
              empleados.fchantigua,
              llaves.ocupacion,
              tabulador.actividad,
              llaves.horario,
              C.Observacion,
              C.Contrato
    ";
  }else {
    $query = "
    select all (empleados.codigo) AS 'codigo',
        ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS 'nombre',
        llaves.ocupacion AS 'ocupacion',
        tabulador.actividad AS 'actividad',
        llaves.horario AS 'horario',
        MAx (convert(varchar(10),empleados.fchantigua,103)) AS 'fechaAnti',
        max(convert(varchar(10),contratos.fchAlta ,103)) AS 'fechaAlta',
        max(convert(varchar(10),contratos.fchterm ,103)) AS 'fechaTer',
        SUM(contratos.dias) AS 'dias',
        C.Observacion,
        C.Contrato

        from empleados

        LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
        INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
        INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion
        LEFT JOIN contrato AS C on C.IDEmpleado = empleados.codigo AND C.IDEmpresa = Llaves.empresa AND C.centro = Llaves.centro

        where empleados.activo = 'S' AND
        ".$ComSql." and llaves.empresa = '".$IDEmpresa."'

        group by  empleados.codigo,
              empleados.ap_paterno,
              empleados.ap_materno,
              empleados.nombre,
              empleados.fchantigua,
              llaves.ocupacion,
              tabulador.actividad,
              llaves.horario,
              C.Observacion,
              C.Contrato
    ";
  }

$numCol = $objBDSQL->obtenfilas($query);
if($numCol >= 1){

  $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, "Codigo")
                                ->SetCellValue('B'.$FILA, "Nombre")
                                ->SetCellValue('C'.$FILA, "Ocupacion")
                                ->SetCellValue('D'.$FILA, "Actividad")
                                ->SetCellValue('E'.$FILA, "Horario")
                                ->SetCellValue('F'.$FILA, "Antigüedad")
                                ->SetCellValue('G'.$FILA, "Inicio de Contrato")
                                ->SetCellValue('H'.$FILA, "Termino de Contrato")
                                ->SetCellValue('I'.$FILA, "Dias")
                                ->SetCellValue('J'.$FILA, "Observacion")
                                ->SetCellValue('K'.$FILA, "Contrato");
  $FILA++;
  $objBDSQL->consultaBD($query);

  while ($row = $objBDSQL->obtenResult()) {
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row['codigo'])
                                  ->SetCellValue('B'.$FILA, $row['nombre'])
                                  ->SetCellValue('C'.$FILA, $row['ocupacion'])
                                  ->SetCellValue('D'.$FILA, $row['actividad'])
                                  ->SetCellValue('E'.$FILA, $row['horario'])
                                  ->SetCellValue('F'.$FILA, $row['fechaAnti'])
                                  ->SetCellValue('G'.$FILA, $row['fechaAlta'])
                                  ->SetCellValue('H'.$FILA, $row['fechaTer'])
                                  ->SetCellValue('I'.$FILA, $row['dias'])
                                  ->SetCellValue('J'.$FILA, $row['Observacion'])
                                  ->SetCellValue('K'.$FILA, $row['Contrato'] == 'vacio' ? '' : $row['Contrato']);
    $FILA++;
  }



}

}else if($tipo == "retardos"){

  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  list($_dia, $_mes, $_ayo) = explode('/', $fecha1);
  list($_diaB, $_mesB, $_ayoB) = explode('/', $fecha2);

  $fecha1 = $_ayo.$_mes.$_dia;
  $fecha2 = $_ayoB.$_mesB.$_diaB;

  if($DepOsub == 1)
  {
    $query = "[dbo].[proc_retardos]
            '".$fecha1."',
            '".$fecha2."',
            '".$centro."',
            '0',
            '".$IDEmpresa."',
            '".$TN."',
            'E',
            'min',
            '1'";
    $ComSql = "LEFT (Dep, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  }else {
    $query = "[dbo].[proc_retardos]
            '".$fecha1."',
            '".$fecha2."',
            '".$centro."',
            '0',
            '".$IDEmpresa."',
            '".$TN."',
            'E',
            'min',
            '0'";
    $ComSql = "Dep = '".$centro."'";
  }

  $objBDSQL->consultaBD($query);
  $naumentar = 1;
  $letraAun = 'A';
  $FILA = 7;
  while ($row = $objBDSQL->obtenResult()) {
    $letraAun2 = 'A';
    foreach ($row as $key => $value) {
      if($naumentar == 1){
        $objPHPExcel->getActiveSheet()->SetCellValue($letraAun.'6', $key);
        $letraAun++;
      }
      $fechaTitulo = str_replace("/", "-", $key);
      $sql1 = "SELECT TOP(1) valor FROM retardo WHERE codigo ='".$row["codigo"]."' AND fecha = '".$fechaTitulo."' AND TN = '".$TN."' AND periodo = '".$PC."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql.";";
      $objBDSQL2->consultaBD2($sql1);
      $valorS = $objBDSQL2->obtenResult2();
      $valorC = "";
      if(empty($valorS['valor']) && !empty($value)){
        $valorC = "R";
      }else {
        $valorC = $valorS['valor'];
      }
      if($key == 'codigo' || $key == 'Nombre' || $key == 'sueldo' || $key == 'Tpo'){
         $objPHPExcel->getActiveSheet()->SetCellValue($letraAun2.$FILA, str_replace('.', ':', $value));
      }else {
          $objPHPExcel->getActiveSheet()->SetCellValue($letraAun2.$FILA, str_replace('.', ':', $value.' '.$valorC));
      }

      $letraAun2++;
    }
    $FILA++;
    $naumentar++;
  }

}else if($tipo == "pdom"){
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];
  $Dep = $_POST['Dep'];

  list($dia, $mes, $ayo) = explode('/', $fecha1);
  list($diaB, $mesB, $ayoB) = explode('/', $fecha2);
  $fecha1 = $ayo.$mes.$dia;
  $fecha2 = $ayoB.$mesB.$diaB;

  if($TN == 1){
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

  if($supervisor == 0){
    $conQueri = "";
  }else {
    //$conQueri = "Llaves.supervisor = '".$supervisor."' and";
    $conQueri = "";
  }

  if($Dep == "TODOS" || $Dep == "TODO" || $Dep == "todos" || $Dep == "todo"){


  	$query = "
          select relch_registro.codigo AS CODIGO,
          empleados.ap_paterno+' '+empleados.ap_materno+' '+empleados.nombre AS NOMBRE,
          tabulador.actividad AS ACTIVIDAD,
          CONVERT(varchar(10), relch_registro.fecha, 103) AS FECHA,
          relch_registro.num_conc AS NUM_CONC,
          empleados.sueldo * '.25' as PDOM,
          A.PDOM AS APDOM

          from relch_registro

          INNER JOIN empleados on empleados.empresa = relch_registro.empresa and empleados.codigo = relch_registro.codigo
          INNER JOIN Llaves on Llaves.empresa = relch_registro.empresa and Llaves.codigo = relch_registro.codigo
          INNER JOIN tabulador on  tabulador.empresa = Llaves.empresa and  tabulador.ocupacion = Llaves.ocupacion
          LEFT JOIN ajusteempleado AS A ON A.IDEmpleado = relch_registro.codigo AND A.centro = relch_registro.centro AND IDEmpresa = relch_registro.empresa

          where relch_registro.empresa = '".$IDEmpresa."' and
          empleados.activo = 'S' and
  	      ".$conQueri."
          ".$comSql."
          relch_registro.num_conc = 9 and
          relch_registro.tiponom = '".$TN."'
          order by relch_registro.centro
          ";

  }else {

  	$query = "
          select relch_registro.codigo AS CODIGO,
          empleados.ap_paterno+' '+empleados.ap_materno+' '+empleados.nombre AS NOMBRE,
          tabulador.actividad AS ACTIVIDAD,
          CONVERT(varchar(10), relch_registro.fecha, 103) AS FECHA,
          relch_registro.num_conc AS NUM_CONC,
          empleados.sueldo * '.25' as PDOM,
          A.PDOM AS APDOM

          from relch_registro

          INNER JOIN empleados on empleados.empresa = relch_registro.empresa and empleados.codigo = relch_registro.codigo
          INNER JOIN Llaves on Llaves.empresa = relch_registro.empresa and Llaves.codigo = relch_registro.codigo
          INNER JOIN tabulador on  tabulador.empresa = Llaves.empresa and  tabulador.ocupacion = Llaves.ocupacion
          LEFT JOIN ajusteempleado AS A ON A.IDEmpleado = relch_registro.codigo AND A.centro = relch_registro.centro AND IDEmpresa = relch_registro.empresa

          where relch_registro.empresa = '".$IDEmpresa."' and
          empleados.activo = 'S' and
  	      ".$conQueri."
          ".$comSql."
          relch_registro.num_conc = 9 and
          relch_registro.tiponom = '".$TN."' and
          ".$ComSql2."
          order by relch_registro.codigo asc
          ";

  }

  $objPHPExcel->getActiveSheet()->SetCellValue('A6', "CODIGO")
                                ->SetCellValue('B6', "NOMBRE")
                                ->SetCellValue('C6', "ACTIVIDAD")
                                ->SetCellValue('D6', "FECHA")
                                ->SetCellValue('E6', "NUM_CONC")
                                ->SetCellValue('F6', "PDOM");
  $objBDSQL->consultaBD($query);
  $FILA = 7;
  while ($row = $objBDSQL->obtenResult()) {
      if($row['APDOM'] == 1){

      }else {
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["CODIGO"])
                                      ->SetCellValue('B'.$FILA, utf8_encode($row["NOMBRE"]))
                                      ->SetCellValue('C'.$FILA, $row["ACTIVIDAD"])
                                      ->SetCellValue('D'.$FILA, $row["FECHA"])
                                      ->SetCellValue('E'.$FILA, $row["NUM_CONC"])
                                      ->SetCellValue('F'.$FILA, truncateFloat($row["PDOM"], 2));
        $FILA++;
      }
  }


}else if($tipo == "tiempoextra"){
  $fecha1 = $_POST['fecha1'];
  $fecha2 = $_POST['fecha2'];

  list($dia, $mes, $ayo) = explode('/', $fecha1);
  list($diaB, $mesB, $ayoB) = explode('/', $fecha2);
  $fecha1 = $ayo.$mes.$dia;
  $fecha2 = $ayoB.$mesB.$diaB;

  if($DepOsub == 1){
    $querySQL = "[dbo].[reporte_checadas_excel_ctro]
              '".$fecha1."',
              '".$fecha2."',
              '".$centro."',
              '0',
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
              '0',
              '".$IDEmpresa."',
              '".$TN."',
              'Llaves.centro = ''".$centro."''',
              '0'";

      $ComSql2 = "Centro = '".$centro."'";
  }

  $objBDSQL->consultaBD($querySQL);
  $contador = 1;
  $FILA = 7;
  $letra = 'A';

  while ($row = $objBDSQL->obtenResult()) {
    $letra2 = 'A';
    foreach ($row as $key => $value) {
      if($contador == 1){
          if($key != 'Sueldo' && $key != 'Tpo'){
	    if($key == 'codigo' && $key == 'Nombre'){
		      $objPHPExcel->getActiveSheet()->SetCellValue($letra."6", $key);
	    }else {
		      $objPHPExcel->getActiveSheet()->SetCellValue($letra."6", $key);
	    }
            $letra++;
          }
      }
      $valorC = "";
      $valorCF = "";
      $date = str_replace('/', '-', $key);
      $fechaN = $date;
      $consultaVV = "SELECT Valor, Frente FROM TiempoExtra WHERE Codigo = '".$row["codigo"]."' AND Fecha = '$fechaN' AND Periodo = '$PC' AND Tn = '$TN' AND IDEmpresa = '$IDEmpresa' AND $ComSql2;";

      $objBDSQL2->consultaBD2($consultaVV);
      $datosvv = $objBDSQL2->obtenResult2();

     if(!empty($datosvv["Valor"])){
        $valorC = $datosvv["Valor"];
      }

      if(!empty($datosvv["Frente"])){
        $valorCF = $datosvv["Frente"];
      }

      if($key != 'Sueldo' && $key != 'Tpo') {
        if($key == 'codigo' || $key == 'Nombre'){
          $objPHPExcel->getActiveSheet()->SetCellValue($letra2.$FILA, $value);
        }else {
           $objPHPExcel->getActiveSheet()->SetCellValue($letra2.$FILA, ($valorCF != "") ? $valorC." - ".$valorCF : $valorC);
					 //->SetCellValue($letra2.$FILA+1, $valorCF);
        }
        $letra2++;
      }
    }
    $FILA++;
    $contador++;
  }

}else if($tipo == "ConceptoExtra"){

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

      $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  }else {
    if($supervisor == 0){
      $querySQL2 = "
                   from Llaves AS L
                   INNER JOIN empleados AS E ON E.codigo = L.codigo AND E.empresa = L.empresa
                   LEFT JOIN JExtras AS D ON D.Codigo = L.codigo AND D.IDEmpresa = L.empresa AND D.Centro = L.centro AND D.fecha = '".date("Y")."' AND D.Periodo = '".$PC."'

                   WHERE L.empresa = ".$IDEmpresa." AND
            			 L.centro = '".$centro."' AND
            			 L.tiponom = '".$TN."' AND
                   E.activo = 'S'";
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

      $ComSql2 = "Centro = '".$centro."'";
  }
  $contador = 1;
  $FILA = 7;
  $letra = 'A';


  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D5:E5');
  $objPHPExcel->getActiveSheet()->SetCellValue('D5', 'BONOS');

  $objPHPExcel->getActiveSheet()->getStyle('D5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F5:G5');
  $objPHPExcel->getActiveSheet()->SetCellValue('F5', 'OTROS PAGOS');

  $objPHPExcel->getActiveSheet()->getStyle('F5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

  $objPHPExcel->setActiveSheetIndex(0)->mergeCells('H5:I5');
  $objPHPExcel->getActiveSheet()->SetCellValue('H5', 'OTROS DESCUENTOS');

  $objPHPExcel->getActiveSheet()->getStyle('H5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

  $objPHPExcel->getActiveSheet()->SetCellValue('A6', 'Codigo')
                                ->SetCellValue('B6', 'Nombre')
                                ->SetCellValue('C6', 'Sueldo')
                                ->SetCellValue('D6', 'IMPORTE')
                                ->SetCellValue('E6', 'FRENTE')
                                ->SetCellValue('F6', 'IMPORTE')
                                ->SetCellValue('G6', 'FRENTE')
                                ->SetCellValue('H6', 'IMPORTE')
                                ->SetCellValue('I6', 'FRENTE');

  $objBDSQL->consultaBD($querySQL1.$querySQL2);
  while ( $row = $objBDSQL->obtenResult() )
  {
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row['Codigo'])
                                  ->SetCellValue('B'.$FILA, $row['Nombre'])
                                  ->SetCellValue('C'.$FILA, $row['sueldo'])
                                  ->SetCellValue('D'.$FILA, $row['IMPORTE_B'])
                                  ->SetCellValue('E'.$FILA, $row['FRENTE_B'])
                                  ->SetCellValue('F'.$FILA, $row['IMPORTE_OP'])
                                  ->SetCellValue('G'.$FILA, $row['FRENTE_OP'])
                                  ->SetCellValue('H'.$FILA, $row['IMPORTE_OD'])
                                  ->SetCellValue('I'.$FILA, $row['FRENTE_OD']);
    $FILA++;
    $letra++;
  }

}

/*$objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, "cabecera1")
                              ->SetCellValue('B'.$FILA, "cabecera2")
                              ->SetCellValue('C'.$FILA, "cabecera3")
                              ->SetCellValue('D'.$FILA, "cabecera4")
                              ->SetCellValue('E'.$FILA, "cabecera5")
                              ->SetCellValue('F'.$FILA, "cabecera6");*/

//Guardamos el archivo en formato Excel 2007
//Si queremos trabajar con Excel 2003, basta cambiar el 'Excel2007' por 'Excel5' y el nombre del archivo de salida cambiar su formato por '.xls'

$objBDSQL->liberarC();
$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();
for($i = 'A'; $i <= 'W'; $i++){
    $objPHPExcel->setActiveSheetIndex(0)->getColumnDimension($i)->setAutoSize(TRUE);
}
$Carpeta = "quincenal";

if($tn == 1){
	$Carpeta = "semanal";
}
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\pantalla-'.$tipo.'.xls');
echo "1";

?>
