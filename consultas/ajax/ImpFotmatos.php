<?php
require_once('ClassImpFormatos.php');
$modo = $_POST['modo'];
$cEmp = $_POST['cantidadEmp'];
$codigos = $_POST['codigos'];
$Carpeta = "quincenal";
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$CodEm = explode(",", $codigos[0]);

if($TN == 1){
  $Carpeta = "semanal";
}

if($modo == "S"){
  $FS = $_POST['FS'];
  $jefe = $_POST['jefe'];
  for($x = 1; $x <= $cEmp; $x++){

    $query = "
       select all (empleados.codigo),
               ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS Nombre ,
               llaves.ocupacion,
               tabulador.actividad,
               llaves.horario,
               MAx (convert(varchar(10),empleados.fchantigua,103)) AS FechaAntiguedad,
               max(convert(varchar(10),contratos.fchAlta ,103)) AS FechaAlta,
               max(convert(varchar(11),contratos.fchterm ,113)) AS FechaTerminacion,
               SUM(contratos.dias) AS DiasAcumulados,
              centros.nomdepto

        from empleados

        LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
        INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
        INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion
        INNER JOIN centros on centros.centro = Llaves.centro and Llaves.codigo = empleados.codigo

        where empleados.activo = 'S' AND
              empleados.codigo = '".$CodEm[$x-1]."'

        group by  empleados.codigo,
                  empleados.ap_paterno,
                  empleados.ap_materno,
                  empleados.nombre,
                  empleados.fchantigua,
                  llaves.ocupacion,
                  tabulador.actividad,
                  llaves.horario,
                 centros.nomdepto

                ORDER BY   ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre)
        ";
    $objBDSQL->consultaBD($query);
    $row = $objBDSQL->obtenResult();

    $pdfImp = new PDF('P', 'mm', 'Letter');
    $pdfImp->AliasNbPages();
    $pdfImp->SetFont('Arial', '', 8);
    $pdfImp->AddPage();
    $pdfImp->tablaSalida($NombreEmpresa, $row["Nombre"], $CodEm[$x-1], $row["nomdepto"], $row["actividad"], $FS, $jefe);
    $pdfImp->Output('F', Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\EntrevistaDeSalida('.$row["Nombre"].date("d-m-Y").").pdf");
    $objBDSQL->liberarC();
  }
  $objBDSQL->cerrarBD();
  echo "1";

}else if($modo == "V"){
  for($x = 1; $x <= $cEmp; $x++){
    $query = "
       select all (empleados.codigo),
               ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS Nombre ,
               llaves.ocupacion,
               tabulador.actividad,
               llaves.horario,
               MAx (convert(varchar(10),empleados.fchantigua,103)) AS FechaAntiguedad,
               max(convert(varchar(10),contratos.fchAlta ,103)) AS FechaAlta,
               max(convert(varchar(11),contratos.fchterm ,113)) AS FechaTerminacion,
               SUM(contratos.dias) AS DiasAcumulados,
              centros.nomdepto

        from empleados

        LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
        INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
        INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion
        INNER JOIN centros on centros.centro = Llaves.centro and Llaves.codigo = empleados.codigo

        where empleados.activo = 'S' AND
              empleados.codigo = '".$CodEm[$x-1]."'

        group by  empleados.codigo,
                  empleados.ap_paterno,
                  empleados.ap_materno,
                  empleados.nombre,
                  empleados.fchantigua,
                  llaves.ocupacion,
                  tabulador.actividad,
                  llaves.horario,
                 centros.nomdepto

                ORDER BY   ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre)
        ";
    $objBDSQL->consultaBD($query);
    $row = $objBDSQL->obtenResult();

    $pdfImp = new PDF('P', 'mm', 'Letter');
    $pdfImp->AliasNbPages();
    $pdfImp->SetFont('Arial', '', 8);
    $pdfImp->AddPage();
    $pdfImp->tablaVence($NombreEmpresa, $row["Nombre"], $CodEm[$x-1], $row["nomdepto"], $row["actividad"], $row["DiasAcumulados"], $row["FechaTerminacion"]);
    $pdfImp->Output('F', Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\VencimientoDeContrato('.$row["Nombre"].date("d-m-Y").").pdf");
    $objBDSQL->liberarC();
  }
  $objBDSQL->cerrarBD();
  echo "1";
}else if($modo == "L"){
  $fechaBaja = $_POST['fechaBaja'];
  for($x = 1; $x <= $cEmp; $x++){
    $query = "
       select all (empleados.codigo),
               ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS Nombre ,
               llaves.ocupacion,
               tabulador.actividad,
               llaves.horario,
               MAx (convert(varchar(10),empleados.fchantigua,103)) AS FechaAntiguedad,
               max(convert(varchar(10),contratos.fchAlta ,103)) AS FechaAlta,
               max(convert(varchar(11),contratos.fchterm ,113)) AS FechaTerminacion,
               SUM(contratos.dias) AS DiasAcumulados,
              centros.nomdepto

        from empleados

        LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
        INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
        INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion
        INNER JOIN centros on centros.centro = Llaves.centro and Llaves.codigo = empleados.codigo

        where empleados.activo = 'S' AND
              empleados.codigo = '".$CodEm[$x-1]."'

        group by  empleados.codigo,
                  empleados.ap_paterno,
                  empleados.ap_materno,
                  empleados.nombre,
                  empleados.fchantigua,
                  llaves.ocupacion,
                  tabulador.actividad,
                  llaves.horario,
                 centros.nomdepto

                ORDER BY   ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre)
        ";
    $objBDSQL->consultaBD($query);
    $row = $objBDSQL->obtenResult();

    $pdfImp = new PDF('P', 'mm', 'Letter');
    $pdfImp->AliasNbPages();
    $pdfImp->SetFont('Arial', '', 8);
    $pdfImp->AddPage();
    $pdfImp->tablaLiberacion($NombreEmpresa, $fechaBaja, $CodEm[$x-1], $row["actividad"], $row["Nombre"], $row["nomdepto"]);
    $pdfImp->Output('F', Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\HojaDeLiberacion('.$row["Nombre"].date("d-m-Y").").pdf");
    $objBDSQL->liberarC();
  }
  $objBDSQL->cerrarBD();
  echo "1";
}else if($modo == "salida"){
  $FS = $_POST['FS'];
  $jefe = $_POST['jefe'];
  $codigo = $_POST['codigo'];

  $query = "
     select all (empleados.codigo),
             ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS Nombre ,
             llaves.ocupacion,
             tabulador.actividad,
             llaves.horario,
             MAx (convert(varchar(10),empleados.fchantigua,103)) AS FechaAntiguedad,
             max(convert(varchar(10),contratos.fchAlta ,103)) AS FechaAlta,
             max(convert(varchar(11),contratos.fchterm ,113)) AS FechaTerminacion,
             SUM(contratos.dias) AS DiasAcumulados,
            centros.nomdepto

      from empleados

      LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
      INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
      INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion
      INNER JOIN centros on centros.centro = Llaves.centro and Llaves.codigo = empleados.codigo

      where empleados.activo = 'S' AND
            empleados.codigo = '".$codigo."'

      group by  empleados.codigo,
                empleados.ap_paterno,
                empleados.ap_materno,
                empleados.nombre,
                empleados.fchantigua,
                llaves.ocupacion,
                tabulador.actividad,
                llaves.horario,
               centros.nomdepto

              ORDER BY   ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre)
      ";
  $objBDSQL->consultaBD($query);
  $row = $objBDSQL->obtenResult();

  $pdfImp = new PDF('P', 'mm', 'Letter');
  $pdfImp->AliasNbPages();
  $pdfImp->SetFont('Arial', '', 8);
  $pdfImp->AddPage();
  $pdfImp->tablaSalida($NombreEmpresa, $row["Nombre"], $codigo, $row["nomdepto"], $row["actividad"], $FS, $jefe);
  $pdfImp->Output('F', "Temp/temp.pdf");
  $objBDSQL->liberarC();
  $objBDSQL->cerrarBD();

}else if($modo == "liberacion"){
  $codigo = $_POST['codigo'];
  $fechaBaja = $_POST['FechaB'];
    $query = "
       select all (empleados.codigo),
               ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS Nombre ,
               llaves.ocupacion,
               tabulador.actividad,
               llaves.horario,
               MAx (convert(varchar(10),empleados.fchantigua,103)) AS FechaAntiguedad,
               max(convert(varchar(10),contratos.fchAlta ,103)) AS FechaAlta,
               max(convert(varchar(11),contratos.fchterm ,113)) AS FechaTerminacion,
               SUM(contratos.dias) AS DiasAcumulados,
              centros.nomdepto

        from empleados

        LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
        INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
        INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion
        INNER JOIN centros on centros.centro = Llaves.centro and Llaves.codigo = empleados.codigo

        where empleados.activo = 'S' AND
              empleados.codigo = '".$codigo."'

        group by  empleados.codigo,
                  empleados.ap_paterno,
                  empleados.ap_materno,
                  empleados.nombre,
                  empleados.fchantigua,
                  llaves.ocupacion,
                  tabulador.actividad,
                  llaves.horario,
                 centros.nomdepto

                ORDER BY   ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre)
        ";

    $objBDSQL->consultaBD($query);
    $row = $objBDSQL->obtenResult();

    $pdfImp = new PDF('P', 'mm', 'Letter');
    $pdfImp->AliasNbPages();
    $pdfImp->SetFont('Arial', '', 8);
    $pdfImp->AddPage();
    $pdfImp->tablaLiberacion($NombreEmpresa, $fechaBaja, $codigo, $row["actividad"], $row["Nombre"], $row["nomdepto"]);
    $pdfImp->Output('F', "Temp/temp.pdf");
    $objBDSQL->liberarC();
    $objBDSQL->cerrarBD();
}else if($modo == "venceC"){
  $codigo = $_POST['codigo'];
  $query = "
     select all (empleados.codigo),
             ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS Nombre ,
             llaves.ocupacion,
             tabulador.actividad,
             llaves.horario,
             MAx (convert(varchar(10),empleados.fchantigua,103)) AS FechaAntiguedad,
             max(convert(varchar(10),contratos.fchAlta ,103)) AS FechaAlta,
             max(convert(varchar(11),contratos.fchterm ,113)) AS FechaTerminacion,
             SUM(contratos.dias) AS DiasAcumulados,
            centros.nomdepto

      from empleados

      LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
      INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
      INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion
      INNER JOIN centros on centros.centro = Llaves.centro and Llaves.codigo = empleados.codigo

      where empleados.activo = 'S' AND
            empleados.codigo = '".$codigo."'

      group by  empleados.codigo,
                empleados.ap_paterno,
                empleados.ap_materno,
                empleados.nombre,
                empleados.fchantigua,
                llaves.ocupacion,
                tabulador.actividad,
                llaves.horario,
               centros.nomdepto

              ORDER BY   ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre)
      ";
  $objBDSQL->consultaBD($query);
  $row = $objBDSQL->obtenResult();
  $pdfImp = new PDF('P', 'mm', 'Letter');
  $pdfImp->AliasNbPages();
  $pdfImp->SetFont('Arial', '', 8);
  $pdfImp->AddPage();
  $pdfImp->tablaVence($NombreEmpresa, $row["Nombre"], $codigo, $row["nomdepto"], $row["actividad"], $row["DiasAcumulados"], $row["FechaTerminacion"]);
  $pdfImp->Output('F', "Temp/temp.pdf");
  $objBDSQL->liberarC();
  $objBDSQL->cerrarBD();

}

?>
