<?php
$Mupdate = "";
$Select = "";
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();
$bdM = new ConexionM();
$bdM->__constructM();

$result = array();
$result['error'] = 0;
$result['exito'] = 0;

if($DepOsub == 1)
{
  $ComSql = "LEFT (llaves.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  $ComSql2 = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $ComSql = "llaves.centro = '".$centro."'";
  $ComSql2 = "centro = '".$centro."'";
}

$query = "
        select all (empleados.codigo),
        ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) ,
        llaves.ocupacion,
        tabulador.actividad,
        llaves.horario,
        MAx (convert(varchar(10),empleados.fchantigua,103)),
        max(convert(varchar(10),contratos.fchAlta ,103)) ,
        max(convert(varchar(10),contratos.fchterm ,103)) ,
        SUM(contratos.dias)

        from empleados

        LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
        INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
        INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion

        where empleados.activo = 'S' AND
          ".$ComSql." and llaves.empresa = '".$IDEmpresa."'

        group by  empleados.codigo,
              empleados.ap_paterno,
              empleados.ap_materno,
              empleados.nombre,
              empleados.fchantigua,
              llaves.ocupacion,
              tabulador.actividad,
              llaves.horario
    ";

$resultCon = $objBDSQL->consultaBD($query);

if($resultCon['error'] == 1){
	$file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$query.PHP_EOL);
	fclose($file);
	$result['error'] = -1;
	echo json_encode($result);
	/////////////////////////////
	$objBDSQL->cerrarBD();
	$objBDSQL2->cerrarBD();

	exit();
}

while ($row = $objBDSQL->obtenResult()) {

  $name = $row['codigo'];
  $option = "NC".$row["codigo"];

  if(isset($_POST[$name])) {
    $consulta = "IF EXISTS(
                      SELECT ID FROM contrato WHERE IDEmpleado = '".$row["codigo"]."' AND IDEmpresa = '".$IDEmpresa."' AND ".$ComSql2.")
                 BEGIN ";
                 if(empty($_POST[$option])){
                   $consulta .= "UPDATE contrato SET IDEmpleado = '".$row["codigo"]."', Observacion = '".$_POST[$name]."', Contrato = 'vacio', IDEmpresa = ".$IDEmpresa.", centro = '".$centro."' WHERE IDEmpleado = '".$row["codigo"]."' AND IDEmpresa = '".$IDEmpresa."' AND centro = '".$centro."'";
                 }else {
                   $consulta .= "UPDATE contrato SET IDEmpleado = '".$row["codigo"]."', Observacion = '".$_POST[$name]."', Contrato = '".$_POST[$option]."', IDEmpresa = ".$IDEmpresa.", centro = '".$centro."' WHERE IDEmpleado = '".$row["codigo"]."' AND IDEmpresa = '".$IDEmpresa."' AND centro = '".$centro."'";
                 }
                $consulta .= " END
                ELSE
                BEGIN ";
                if(empty($_POST[$option])){
                  $consulta .= "INSERT INTO contrato VALUES ('".$row["codigo"]."', '".$_POST[$name]."', 'vacio', ".$IDEmpresa.", '".$centro."')";
                }else {
                  $consulta .= "INSERT INTO contrato VALUES ('".$row["codigo"]."', '".$_POST[$name]."', '".$_POST[$option]."', ".$IDEmpresa.", '".$centro."')";
                }
                $consulta .= " END";
    $resultCon2 = $objBDSQL2->consultaBD2($consulta);
    if($resultCon2['error'] == 1){
      $file = fopen("log/log".date("d-m-Y").".txt", "a");
      fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon2['SQLSTATE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon2['CODIGO'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultCon2['MENSAJE'].PHP_EOL);
      fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consulta);
      fclose($file);
      $result['error']++;
    }else {
      $result['exito']++;
    }

    //echo $consulta."<br><br><br><br><br><br><br><br><br>";
  }

}

$Minsert = "UPDATE config SET correo = '".$_POST["correo"]."' WHERE IDUser = '".$_SESSION['IDUser']."'";
$bdM->query($Minsert);
$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();

echo json_encode($result);

?>
