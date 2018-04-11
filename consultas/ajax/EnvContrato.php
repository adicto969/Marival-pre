<?php
require_once('librerias/pdf/fpdf.php');
$pagina = 0;
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$bdM = new ConexionM();
$bdM->__constructM();
$fecha = $_POST['fecha'];
$Carpeta = "quincenal";
$correo = $_POST["userN"];
$porcentaje = $_POST['porC'];

if($DepOsub == 1){
  $compSql = "LEFT (llaves.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  $compSql2 = "LEFT (b.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  $ComSql3 = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $compSql = "llaves.centro = '".$centro."'";
  $compSql2 = "b.centro = '".$centro."'";
  $ComSql3 = "centro = '".$centro."'";
}


$queryS1 = "
            select all (empleados.codigo),
            ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) AS 'nombre',
            llaves.ocupacion,
            tabulador.actividad,
            llaves.horario,
            MAx (convert(varchar(10),empleados.fchantigua,103)) AS 'fechaAnti',
            max(convert(varchar(10),contratos.fchAlta ,103)) AS 'fechaAlta',
            max(convert(varchar(10),contratos.fchterm ,103)) AS 'fechaTer',
            SUM(contratos.dias) AS 'dias'

            from empleados

            LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
            INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
            INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion



            where empleados.activo = 'S' AND
            ".$compSql." and llaves.empresa = '".$IDEmpresa."'

            group by  empleados.codigo,
                  empleados.ap_paterno,
                  empleados.ap_materno,
                  empleados.nombre,
                  empleados.fchantigua,
                  llaves.ocupacion,
                  tabulador.actividad,
                  llaves.horario
        ";

$queryS2 = "    select distinct a.ocupacion,
                    a.actividad,
                    COUNT(llaves.ocupacion) as Total,
                    S.v".$porcentaje." as Num

                from tabulador as a

                    inner join Llaves as b on b.empresa = a.empresa and b.ocupacion = a.ocupacion
                    inner join empleados as c on c.empresa = b.empresa and c.codigo = b.codigo
                    INNER JOIN llaves on llaves.empresa = c.empresa and llaves.codigo = c.codigo
                    inner join staff_porcentaje as S on S.empresa = a.empresa and S.ocupacion = b.ocupacion and S.centro = b.centro

                where c.activo = 'S' and
                    ".$compSql2."

                group by  a.ocupacion,
                    llaves.ocupacion,
                    S.v".$porcentaje.",
                    a.actividad
            ";


if($TN == 1){
  $Carpeta = "semanal";
}

$Minsert = "UPDATE config SET correo = '".$correo."' WHERE IDUser = '".$_SESSION['IDUser']."'";
$bdM->query($Minsert);

class PDF extends FPDF
{

  function tabla($objBDSQL, $objBDSQL2, $queryS1, $queryS2, $porcentaje, $fecha, $NombreEmp, $RegisEmp, $RFC, $NomDep, $ComSql3, $IDEmpresa)
  {

    $this->SetFillColor(0, 145, 234);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);

    ////////////////////// CABECERA DEL DOCUMENTO /////////////////////////////
    $this->Cell(258, 10, $NombreEmp, 0, 0, 'C', false);
    $this->Ln(8);
    $this->SetFont('Arial', 'B', 12);
    $this->Cell(258, 10, $NomDep, 0, 0, 'C', false);
    $this->Ln(15);

    //////////////////////////////////////////////////////////////////////////
    ////////////////////// CABECERA DE LA TABLA /////////////////////////////
    $this->SetFont('Arial', '', 8);
    $this->Cell(25, 6, 'Registro Patronal: ', 0, 0, 'L', false);
    $this->Cell(25, 5, $RegisEmp, 0, 0, 'L'. false);
    $this->Ln();
    $this->Cell(25, 6, 'R.F.C: ', 0, 0, 'L', false);
    $this->Cell(25, 5, $RFC, 0, 0, 'L'. false);
    $this->Ln();
    $this->Cell(25, 6, 'fecha: ', 0, 0, 'L', false);
    $this->Cell(25, 5, $fecha, 0, 0, 'L'. false);
    $this->Cell(120, 6, '', 0, 0, 'C', false);
    $this->SetTextColor(255);
    $this->Cell(10, 5, 'No', 1, 0, 'C', true);
    $this->Cell(50, 5, 'Puesto', 1, 0, 'C', true);
    $this->Cell(10, 5, 'AUT', 1, 0, 'C', true);
    $this->Cell(10, 5, 'ACT', 1, 0, 'C', true);
    $this->Cell(10, 5, 'DIF', 1, 0, 'C', true);
    $this->Ln();
    $this->SetTextColor(0);
    $objBDSQL->consultaBD($queryS2);
    while ( $row = $objBDSQL->obtenResult() )
    {
       $this->Cell(170, 6, '', 0, 0, 'C', false);
       $this->Cell(10, 5, $row['ocupacion'], 1, 0, 'C', false);
       $this->Cell(50, 5, utf8_encode($row['actividad']), 1, 0, 'L', false);
       $this->Cell(10, 5, $row['Num'], 1, 0, 'C', false);
       $this->Cell(10, 5, $row['Total'], 1, 0, 'L', false);
       $this->Cell(10, 5, $dif=($row['Total']-$row['Num']), 1, 0, 'C', false);
       $this->Ln();

    }
    $objBDSQL->liberarC();
    $GLOBALS['pagina'] = 1;

    $this->Ln(15);
    /////////////////////////////////////////////////////////////////////
    //////////////////////////////cabecera de la segunda tabla//////////
    $this->SetFillColor(0, 145, 234);
    $this->SetTextColor(255);

    $this->Cell(10, 5, 'Codigo', 1, 0, 'C', true);
    $this->Cell(55, 5, 'Nombre', 1, 0, 'C', true);
    $this->Cell(15, 5, 'Ocupacion', 1, 0, 'C', true);
    $this->Cell(40, 5, 'Actividad', 1, 0, 'C', true);
    $this->Cell(10, 5, 'Horario', 1, 0, 'C', true);
    $this->Cell(20, 5, 'Antiguedad', 1, 0, 'C', true);
    $this->Cell(20, 5, 'Inicio', 1, 0, 'C', true);
    $this->Cell(18, 5, 'Terminacion', 1, 0, 'C', true);
    $this->Cell(10, 5, 'Ds A', 1, 0, 'C', true);
    $this->Cell(50, 5, 'Observacion', 1, 0, 'C', true);
    $this->Cell(12, 5, 'Contrato', 1, 0, 'C', true);
    $this->Ln();
    $this->SetFillColor(255, 255, 255 );
    $this->SetTextColor(0);

    $objBDSQL->consultaBD($queryS1);

    while ( $row = $objBDSQL->obtenResult() )
    {
        $this->Cell(10, 5, $row["codigo"], 1, 0, 'C', true);
        $this->Cell(55, 5, utf8_decode($row["nombre"]), 1, 0, 'L', true);
        $this->Cell(15, 5, $row["ocupacion"], 1, 0, 'C', true);
        $this->Cell(40, 5, $row["actividad"], 1, 0, 'L', true);
        $this->Cell(10, 5, $row["horario"], 1, 0, 'C', true);
        $this->Cell(20, 5, $row["fechaAnti"], 1, 0, 'C', true);
        $this->Cell(20, 5, $row["fechaAlta"], 1, 0, 'C', true);
        $this->Cell(18, 5, $row["fechaTer"], 1, 0, 'C', true);
        $this->Cell(10, 5, $row["dias"], 1, 0, 'C', true);

        $name = $row["codigo"];
        $consultaI = "SELECT Observacion, Contrato FROM contrato WHERE IDEmpleado = '".$row["codigo"]."' AND IDEmpresa = '".$IDEmpresa."' AND ".$ComSql3;
        $result = $objBDSQL2->consultaBD2($consultaI);

        if($result['error'] == 1){
    			$file = fopen("log/log".date("d-m-Y").".txt", "a");
    			fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
    			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['SQLSTATE'].PHP_EOL);
    			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['CODIGO'].PHP_EOL);
    			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$result['MENSAJE'].PHP_EOL);
    			fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$consultaI.PHP_EOL);
    			fclose($file);
          echo "Ocurrio un error ";
    			exit();
    		}

        if(isset($_POST[$name])){
          $this->Cell(50, 5, $_POST[$name], 1, 0, 'L', false);

          $option = "NC".$row["codigo"];

          if (empty($_POST[$option])){
              $this->Cell(12, 5, '', 1, 0, 'C', false);
          }else {
            $this->Cell(12, 5, $_POST[$option], 1, 0, 'C', false);
          }

          $this->Ln();
        }else {
          $valorM = $objBDSQL2->obtenResult2();
          if(empty($valorM)){
            $this->Cell(50, 5, '', 1, 0, 'L', false);

            $this->Cell(12, 5, '', 1, 0, 'C', false);

            $this->Ln();
          }else {
            $this->Cell(50, 5, $valorM['Observacion'], 1, 0, 'L', false);

            if($valorM['Contrato'] == "vacio")
              $this->Cell(12, 5, '', 1, 0, 'C', false);
            else
              $this->Cell(12, 5, $valorM['Contrato'], 1, 0, 'C', false);

            $this->Ln();
          }
        }

    }
    $objBDSQL->liberarC();
  }

  function Header()
  {
    if($GLOBALS['pagina'] == 1){
      $this->SetFillColor(0, 145, 234);
      $this->SetTextColor(255);

      $this->Cell(10, 5, 'Codigo', 1, 0, 'C', true);
      $this->Cell(55, 5, 'Nombre', 1, 0, 'L', true);
      $this->Cell(15, 5, 'Ocupacion', 1, 0, 'C', true);
      $this->Cell(40, 5, 'Actividad', 1, 0, 'L', true);
      $this->Cell(10, 5, 'Horario', 1, 0, 'C', true);
      $this->Cell(20, 5, 'Antiguedad', 1, 0, 'C', true);
      $this->Cell(20, 5, 'Inicio', 1, 0, 'C', true);
      $this->Cell(18, 5, 'Terminacion', 1, 0, 'C', true);
      $this->Cell(10, 5, 'Ds A', 1, 0, 'C', true);
      $this->Cell(50, 5, 'Observacion', 1, 0, 'L', true);
      $this->Cell(12, 5, 'Contrato', 1, 0, 'C', true);
      $this->Ln();
      $this->SetFillColor(255, 255, 255 );
      $this->SetTextColor(0);
      //Ensure table header is output
      parent::Header();
    }
  }

  function footer(){
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0, 10, 'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
  }
}

$pdf = new PDF('L', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->SetFont('Arial', '', 8);
$pdf->AddPage();
$pdf->tabla($objBDSQL, $objBDSQL2, $queryS1, $queryS2, $porcentaje, $fecha, $NombreEmpresa, $RegisEmpresa, $RFC, $NomDep, $ComSql3, $IDEmpresa);
$pdf->Output('F', Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\Contratos('.trim ($NomDep, " \t.").').pdf', true);

$NDirectorii = Unidad.'E'.$IDEmpresa.'\\'.$Carpeta.'\pdf\Contratos('.trim ($NomDep, " \t.").').pdf';
$NDirectorF = 'Contratos('.trim ($NomDep, " \t.").').pdf';
$IDUserN = "";
if(file_exists($NDirectorii)){
  if (copy($NDirectorii, 'Temp\\'.$NDirectorF)) {
    $sql = $bdM->query("SELECT ID FROM usuarios WHERE User = '".$correo."' LIMIT 1;");
    if($bdM->rows($sql) > 0){
      $datos = $bdM->recorrer($sql);
      $IDUserN = $datos[0];
    }
    if(!empty($IDUserN)){
      $Minsert = 'INSERT INTO notificaciones VALUES (NULL, '.$_SESSION['IDUser'].', '.$IDUserN.', "Contratos('.trim ($NomDep, " \t.").')", "Temp\\\\'.$NDirectorF.'", 0)';

      $bdM->query($Minsert);
    }

  }
}

echo "1";
?>
