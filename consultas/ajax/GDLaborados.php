<?php
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$fcH = $_POST['fcH'];
$Dep = $_POST['Dep'];
$Tn = $_POST['Tn'];
$Carpeta = "quincenal";

list($dia, $mes, $ayo) = explode('/', $fcH);
$fcH = $ayo.$mes.$dia;

if($Tn == 1){
	$Carpeta = "semanal";
}

if($DepOsub == 1)
{
	$ComSql = "LEFT (relch_registro.centro, ".$MascaraEm.") = LEFT ('".$Dep."', ".$MascaraEm.")";
}else {
	$ComSql = "relch_registro.centro = '".$Dep."'";
}

$queryD = "SELECT LTRIM ( RTRIM ( nomdepto ) ) AS nomdepto FROM centros WHERE centro = '".$Dep."' AND empresa = '".$IDEmpresa."';";
$NombreD = "";
$objBDSQL->consultaBD($queryD);
$datos = $objBDSQL->obtenResult();
$NombreD = $datos['nomdepto'];
if(empty($NombreD)){
		$NombreD = "GENERAL";
}
$objBDSQL->liberarC();

if($Dep == "TODO" || $Dep == "TODOS" || $Dep == "todo" || $Dep == "todos")
{

	$query = "
		select DISTINCT relch_registro.codigo,
        empleados.ap_paterno+' '+empleados.ap_materno+' '+empleados.nombre AS nombre,
        tabulador.actividad,
        empleados.sueldo,
        convert (varchar(10), relch_registro.fecha, 103) as Fecha,
        relch_registro.num_conc,
        '8' as Horas,
        empleados.sueldo * '2'  as Importe

        from relch_registro

        INNER JOIN empleados on empleados.empresa = relch_registro.empresa and empleados.codigo = relch_registro.codigo
        INNER JOIN Llaves on Llaves.empresa = relch_registro.empresa and Llaves.codigo = relch_registro.codigo
        INNER JOIN tabulador on  tabulador.empresa = Llaves.empresa and  tabulador.ocupacion = Llaves.ocupacion

        where relch_registro.empresa =  '".$IDEmpresa."' and
        empleados.activo = 'S' and
        relch_registro.fecha = '".$fcH."'  and
        relch_registro.num_conc = 10 and
        relch_registro.tiponom = '".$Tn."'
        group by relch_registro.codigo, empleados.ap_paterno, empleados.ap_materno,
			empleados.nombre, tabulador.actividad, empleados.sueldo, relch_registro.fecha,
			relch_registro.num_conc, relch_registro.centro
        order by tabulador.actividad

       ";

}else {

	$query = "

		select DISTINCT relch_registro.codigo,
        empleados.ap_paterno+' '+empleados.ap_materno+' '+empleados.nombre AS nombre,
        tabulador.actividad,
        empleados.sueldo,
        convert (varchar(10), relch_registro.fecha, 103) as Fecha,
        relch_registro.num_conc,
        '8' as Horas,
        empleados.sueldo * '2'  as Importe

        from relch_registro

        INNER JOIN empleados on empleados.empresa = relch_registro.empresa and empleados.codigo = relch_registro.codigo
        INNER JOIN Llaves on Llaves.empresa = relch_registro.empresa and Llaves.codigo = relch_registro.codigo
        INNER JOIN tabulador on  tabulador.empresa = Llaves.empresa and  tabulador.ocupacion = Llaves.ocupacion

        where relch_registro.empresa =  '".$IDEmpresa."' and
        empleados.activo = 'S' and	
        relch_registro.fecha = '".$fcH."'  and
        relch_registro.num_conc = 10 and
        relch_registro.tiponom = '".$Tn."' and
        ".$ComSql."
        group by relch_registro.codigo, empleados.ap_paterno, empleados.ap_materno,
			empleados.nombre, tabulador.actividad, empleados.sueldo, relch_registro.fecha,
			relch_registro.num_conc, relch_registro.centro
        order by relch_registro.codigo asc


	";

}

$objPHPExcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel5');
$objPHPExcel = $objReader->load("plantillaExcel/DLaborado.xls");
$objPHPExcel->setActiveSheetIndex(0);

$FILA = 1;
$lr = 0;

$objBDSQL->consultaBD($query);

while ($row = $objBDSQL->obtenResult())
{
	$lr++;
	$pst = $row["codigo"].$lr;


	if ( isset( $_POST[$pst] ) )
	{
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$FILA, $row["codigo"])
                                  ->SetCellValue('B'.$FILA, $row["num_conc"])
                                  ->SetCellValue('C'.$FILA, $row["sueldo"])
                                  ->SetCellValue('D'.$FILA, $row["Fecha"])
                                  ->SetCellValue('E'.$FILA, $row["Horas"]);
        $FILA++;
	} else {

	}

}

if($NombreD == ""){
	$NombreD = "TODOS";
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\excel\DLaborados('.trim ($NombreD, " \t.").').xls');

echo "1";


?>
