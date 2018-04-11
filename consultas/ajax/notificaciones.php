<?php
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

if(isset($_SESSION['IDUser'])){
  $bdM = new ConexionM();
  $bdM->__constructM();
  $objBDSQL = new ConexionSRV();
  $objBDSQL->conectarBD();
  $alertas = "";
  $fecha1 = "";
  $fecha2 = "";
  $fecha3 = "";
  $fecha4 = "";
  if($PC <= 24){

  $_fechas = periodo($PC, $TN);
  list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $_fechas);
  }
  if($TN == 1 || $PC > 24)
  {
    $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1',
  													CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2'
  									 FROM Periodos
  									 WHERE tiponom = 1
  									 AND periodo = $PC-1
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
    }else {
      $_datos = $objBDSQL->obtenResult();

      $fecha1 = $_datos['FECHA1'];
      $fecha2 = $_datos['FECHA2'];
      $objBDSQL->liberarC();
    }


  	$_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA3',
  													CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA4'
  									 FROM Periodos
  									 WHERE tiponom = 1
  									 AND periodo = $PC
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
    }else {
      $_datos = $objBDSQL->obtenResult();

      $fecha3 = $_datos['FECHA3'];
      $fecha4 = $_datos['FECHA4'];

      $objBDSQL->liberarC();
    }
  }

  if(empty($fecha1)){
      $fecha1 = "05/08/1993";
  }
  if(empty($fecha2)){
    $fecha2 = "05/08/1993";
  }
  if(empty($fecha3)){
    $fecha3 = "05/08/1993";
  }
  if(empty($fecha4)){
    $fecha4 = "05/08/1993";
  }



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

  $sql56 = "SELECT con.codigo, em.ap_paterno+' '+em.ap_materno+' '+em.nombre AS nombre,
                   convert (varchar(10), fchterm, 103) AS fchterm
                   FROM contratos AS con
                   INNER JOIN empleados AS em
                   ON em.codigo = con.codigo
                   WHERE fchterm BETWEEN '".$nuevafecha5612."' AND '".$nuevafecha56."'
                   AND vencido = 'F'
                   AND ".$comSql.";";

  $num1 = 0;
  $resultado = $objBDSQL->consultaBD($sql56);
  if($resultado['error'] == 1)
  {
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$sql56.PHP_EOL);
    fclose($file);
  }else {
    while ($objBDSQL->obtenResult()){
      $num1++;
    }
    $objBDSQL->liberarC();
  }
  /////////////////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////////////////////////////

  //////////////////////////////////////////////////////////////////////////////////////////
  //////////////////////////////verificar contratos vencidos a 1 dia /////////////////////////////////
  $nuevafecha561 = strtotime ( '+1 day' , strtotime ( $fecha56 ) ) ;
  $nuevafecha561 = date ( 'Ymd' , $nuevafecha561 );

  $nuevafecha5612 = strtotime ( '-4 day' , strtotime ( $fecha56 ) ) ;
  $nuevafecha5612 = date ( 'Ymd' , $nuevafecha5612 );

  $sql561 = "SELECT con.codigo, em.ap_paterno+' '+em.ap_materno+' '+em.nombre AS nombre,
                    convert (varchar(10), fchterm, 103) AS fchterm
                    FROM contratos AS con
                    INNER JOIN empleados AS em ON em.codigo = con.codigo
                    WHERE fchterm = '".date("Ymd")."'
                    AND vencido = 'F'
                    AND ".$comSql.";";

  $num2 = 0;
  $resultado = $objBDSQL->consultaBD($sql561);
  if($resultado['error'] == 1)
  {
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
    fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['SQLSTATE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['CODIGO'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['MENSAJE'].PHP_EOL);
    fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$sql561.PHP_EOL);
    fclose($file);
  }else {
    while ($objBDSQL->obtenResult()){
      $num2++;
    }
    $objBDSQL->liberarC();
  }

  if($num1 != 0)
  {
    $alertas .= "<li><a href='index.php?pagina=ContratoVencer.php'>Contratos a Vencer (5 dias)<span class='new badge amber darken-1' data-badge-caption=''>".$num1."</span></a></li>";
  }
  if($num2 != 0)
  {
    $alertas .= "<li><a href='index.php?pagina=ContratoVencer.php'>Contratos vencidos<span class='new badge red' data-badge-caption=''>".$num2."</span></a></li>";
  }


  if($num1>0 || $num2>0){
      $alertas .= '<li class="divider"></li>';
  }

  $consulta = "SELECT Descripcion, Link, ID
               FROM notificaciones
               WHERE IdUserDes = ".$_SESSION['IDUser']."
               AND Estatus = 0
               LIMIT 20;";

  $query = $bdM->query($consulta);

  while($datos = $bdM->recorrer($query)){
      $Descript = $datos[0];
      $Link = $datos[1];
      $IDLink = $datos[2];
      if(empty($Link)){
          $alertas .= "<li><a onclick='camStatus(".$IDLink.")'>".$Descript."</a></li>";
      }else {
        $alertas .= "<li><a href='".$Link."' download='".$Link."' onclick='camStatus(".$IDLink.")'>".$Descript."</a></li>";
      }
  }

  if(Autoriza1 == $_SESSION['User']){
    $consultaPermisos = "SELECT codigo, nombre, valor, ID
                         FROM datosanti
                         WHERE $comSql
                         AND IDEmpresa = $IDEmpresa
                         AND tipoN = $TN
                         AND periodoP = $PC
                         AND Autorizo1 = 0";

    $result = $objBDSQL->obtenfilas($consultaPermisos);
    if($result['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaPermisos.PHP_EOL);
      fclose($file);
    }else {
        $numr = $result['cantidad'];
        if($numr > 0){
          $alertas .= "<li><a href='index.php?pagina=Permiso.php' >Permisos <span class='new badge red' data-badge-caption=''>".$numr."</span></a></li>";
        }
    }

  }else if(Autoriza2 == $_SESSION['User']){
    $consultaPermisos = "SELECT codigo, nombre, valor, ID
                         FROM datosanti
                         WHERE $comSql
                         AND IDEmpresa = $IDEmpresa
                         AND tipoN = $TN
                         AND periodoP = $PC
                         AND Autorizo2 = 0";

    $result = $objBDSQL->obtenfilas($consultaPermisos);
    if($result['error'] == 1){
       $file = fopen("log/log".date("d-m-Y").".txt", "a");
       fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
       fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['SQLSTATE'].PHP_EOL);
       fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['CODIGO'].PHP_EOL);
       fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['MENSAJE'].PHP_EOL);
       fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaPermisos.PHP_EOL);
       fclose($file);
    }else {
       $numr = $result['cantidad'];
       if($numr > 0){
          $alertas .= "<li><a href='index.php?pagina=Permiso.php' >Permisos <span class='new badge red' data-badge-caption=''>".$numr."</span></a></li>";
        }
    }
  }

  ///////////////////////////////////////////////////////////////////////////////
  //////////////////////////////CHECAR EMPLEADOS CON FALTAS MAYOR A 3///////////

  list($dia, $mes, $ayo) = explode('/', $fecha1);
  list($diaB, $mesB, $ayoB) = explode('/', $fecha2);
  $fecha1 = $ayo.$mes.$dia;
  $fecha2 = $ayoB.$mesB.$diaB;

  $consultaFaltas = "SELECT E.empresa,
                    	   E.codigo,
                    	   MAX (E.nombre + ' '+ E.ap_paterno + ' ' + E.ap_materno) AS Nombre,
                    	   MAX (C.nomdepto) AS Centro,
                    	   COUNT(E.codigo) AS Cantidad
                    FROM empleados AS E
                    INNER JOIN relch_registro AS R ON R.codigo = E.codigo
                    INNER JOIN centros AS C ON C.centro = R.centro AND C.empresa = E.empresa
                    WHERE E.activo = 'S' AND
                    	  R.num_conc = 108 AND
                    	  fecha BETWEEN '".$fecha1."' AND '".$fecha2."'
                    GROUP BY E.codigo,E.empresa
                    ORDER BY E.empresa, E.codigo
                    ";

  ########################################################################################
  ############################CREAR ARCHIV EXCEL ########################################
  if($_SESSION['notiExcel'] == 0){
    $objPHPExcel = new PHPExcel();
    // Leemos un archivo Excel 2007
    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
    // Leemos un archivo Excel 2007
    $objPHPExcel = $objReader->load("plantillaExcel/FaltasMas3.xlsx");
    // Indicamos que se pare en la hoja uno del libro
    $objPHPExcel->setActiveSheetIndex(0);

    $FILA = 2;

    $objBDSQL->consultaBD($consultaFaltas);
    while ($row=$objBDSQL->obtenResult())
    {
      if($row["Cantidad"] > 3){
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["empresa"])
                          ->SetCellValue('B'.$FILA, $row["codigo"])
                          ->SetCellValue('C'.$FILA, utf8_encode($row["Nombre"]))
                          ->SetCellValue('D'.$FILA, $row["Centro"])
                          ->SetCellValue('E'.$FILA, $row["Cantidad"]);
        $FILA++;
      }
    }

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    //$objWriter->save(Unidad.'E'.$IDEmpresa.'\Empleados_Ausentes.xls');
    $objWriter->save('Temp/Empleados_Ausentes.xlsx');
    $Empleados_Ausentes = 'Temp/Empleados_Ausentes.xlsx';

    ///VERIFICAR QUE EL EXCEL TIENE DATOS
    $XLFileType = PHPExcel_IOFactory::identify($Empleados_Ausentes);
    $objReader = PHPExcel_IOFactory::createReader($XLFileType);
    $objReader->setLoadSheetsOnly('hoja1');
    $objPHPExcel = $objReader->load($Empleados_Ausentes);

    $objWorksheet = $objPHPExcel->setActiveSheetIndexByName('hoja1');
    if($objPHPExcel->getActiveSheet()->getCell('A2')->getFormattedValue() == ""){
      unlink($Empleados_Ausentes);
    }else {
        $alertas .= "<li><a href='".$Empleados_Ausentes."' download='".$Empleados_Ausentes."'>Empleados Ausentes</a></li>";
    }

    $_SESSION['linkExcelN'] = "<li><a href='".$Empleados_Ausentes."' download='".$Empleados_Ausentes."'>Empleados Ausentes</a></li>";
  }else {
    $alert .= $_SESSION['linkExcelN'];
  }

  try {
    $objBDSQL->cerrarBD();
  } catch (Exception $e) {
    $alertas .= 'ERROR al cerrar la conexion con SQL SERVER'.$e->getMessage()."\n";
  }

  if(empty($alertas)){
    echo "<li><a>vacio</a></li>";
  }else {
    echo $alertas;
  }

}else {
  echo "0";
}


?>
