<?php

$Nresul = $_POST['Nresul'];
$Ncabecera = $_POST['Ncabecera'];
$fecha1 = $_POST['f1'];
$fecha2 = $_POST['f2'];
$fecha3 = $_POST['f3'];
$fecha4 = $_POST['f4'];
$periodo = $_POST['periodo'];
$NomDep = $_POST["NomDep"];
$tipoNom = $_POST["tipoNom"];
$centro = $_POST["centro"];
$Carpeta = "quincenal";

list($dia, $mes, $ayo) = explode('/', $fecha1);
list($diaB, $mesB, $ayoB) = explode('/', $fecha2);

$fecha1 = $ayo.$mes.$dia;
$fecha2 = $ayoB.$mesB.$diaB;

if($DepOsub == 1){
  $SQLT = "DECLARE  @return_value int

    EXEC  @return_value = [dbo].[reporte_checadas_excel_ctro]
            @fecha1 = '".$fecha1."',
            @fecha2 = '".$fecha2."',
            @CENTRO = '".$centro."',
            @superv = '".$supervisor."',
            @empresa = '".$IDEmpresa."',
            @tiponom = '".$tipoNom."',
            @StringExtra = 'LEFT (Llaves.centro, ".$MascaraEm.") = LEFT (''".$centro."'', ".$MascaraEm.")',
            @Tp = '1'
    SELECT  'Return Value' = @return_value";
}else {
  $SQLT = "DECLARE  @return_value int

    EXEC  @return_value = [dbo].[reporte_checadas_excel_ctro]
            @fecha1 = '".$fecha1."',
            @fecha2 = '".$fecha2."',
            @CENTRO = '".$centro."',
            @superv = '".$supervisor."',
            @empresa = '".$IDEmpresa."',
            @tiponom = '".$tipoNom."',
            @StringExtra = 'Llaves.centro = ''".$centro."''',
            @Tp = '0'
    SELECT  'Return Value' = @return_value";
}

if($DepOsub == 1)
{
	$ComSql = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
	$ComSql = "Centro = '".$centro."'";
}

$conS = constructS();
$bd1 = new ConexionM();
$bd1->__constructM();

if($tipoNom == 1){
  $Carpeta = "semanal";
}

$rs = odbc_exec( $conS, $SQLT );

$o = 0;
$lr = 0;
while ( odbc_fetch_row($rs) )
{
  $o++;
  $lr++;

  $PP = "pp".odbc_result($rs, "codigo");
  $PA = "pa".odbc_result($rs, "codigo");

  if(empty($_POST[$PP])){
      $ppv = "";
  }else if (odbc_result($rs,"Tpo") == "E") {
      $ppv = $_POST[$PP];
  }

  if(empty($_POST[$PA])){
      $pav = "";
  }else if (odbc_result($rs,"Tpo") == "E") {
      $pav = $_POST[$PA];
  }

  if(odbc_result($rs, "Tpo") == "E"){
    $ConsulPremio = "SELECT PA FROM premio WHERE codigo ='".odbc_result($rs,"codigo")."'  AND TN = '".$tipoNom."' AND Periodo = '".$periodo."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql."";
    $resulMSP = $bd1->query($ConsulPremio);
    $numr = count($bd1->recorrer($resulMSP));

    if($numr <= 0){
      if(empty($ppv) && empty($pav)){

      }else {
        $Minsert = "INSERT INTO premio VALUES (NULL, '".odbc_result($rs,"codigo")."', '".$ppv."', '".$pav."', '".$tipoNom."', '".$periodo."', '".$centro."', '".$IDEmpresa."');";

        if($bd1->query($Minsert)){

        }else {
          echo $bd1->errno. '  '.$bd1->error;
        }
      }
    }else {
      if(empty($_POST[$PP]) && odbc_result($rs, "Tpo") == "E"){
        $ppv = "";
      }else if($_POST[$PP] && odbc_result($rs, "Tpo") == "E"){
        $ppv = $_POST[$PP];
        $InsertarPT = "UPDATE premio SET PP = '".$ppv."' WHERE TN = '".$tipoNom."' AND Periodo = '".$periodo."' AND Centro =  '".$centro."' AND IDEmpresa = '".$IDEmpresa."' AND codigo = '".odbc_result($rs, "codigo")."';";
        if($bd1->query($InsertarPT)){

        }else {
          echo $bd1->errno. '  '.$bd1->error;
        }
      }

      if(empty($_POST[$PA]) && odbc_result($rs, "Tpo") == "E"){
        $pav = "";
      }else if($_POST[$PA] && odbc_result($rs, "Tpo") == "E"){
        $pav = $_POST[$PA];

        $InsertarPT = "UPDATE premio SET PA = '".$pav."' WHERE TN = '".$tipoNom."' AND Periodo = '".$periodo."' AND Centro =  '".$centro."' AND IDEmpresa = '".$IDEmpresa."' AND codigo = '".odbc_result($rs, "codigo")."';";
        if($bd1->query($InsertarPT)){

        }else {
          echo $bd1->errno. '  '.$bd1->error;
        }
      }
    }
  }
  /*if(odbc_result($rs, "Tpo") == "E"){
      $Minsert = "INSERT INTO premio VALUES (NULL, '".odbc_result($rs,"codigo")."', '".$ppv."', '".$pav."', '".$tipoNom."', '".$periodo."', '".$centro."', '".$IDEmpresa."');";

      if($bd1->query($Minsert)){

      }else {
        echo $bd1->errno. '  '.$bd1->error;
      }

  }*/

  for($j = 5; $j <= $Ncabecera; $j++){
      if(empty(odbc_result($rs,odbc_field_name($rs, $j)))){
        $fechaTitulo = str_replace("/", "-", odbc_field_name($rs, $j));
        $nombre = "fecha".odbc_result($rs,"codigo").$fechaTitulo;
          if(isset($_POST[$nombre]) && odbc_result($rs, "Tpo") == "E"){
              $array = array($_POST[$nombre]);
              $r = $array[0][4];
              if(empty($r)){

              }else {
                $queryM = "SELECT valor FROM datos WHERE codigo = '".odbc_result($rs,"codigo")."' AND nombre = '".$nombre."' AND periodoP = '".$periodo."' AND tipoN = '".$tipoNom."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql.";";
                $resulM = $bd1->query($queryM);
                $numr = count($bd1->recorrer($resulM));

                if($numr <= 0){
                  $Minsert = "INSERT INTO datos VALUES (NULL, '".odbc_result($rs,"codigo")."', '".$nombre."', '".strtoupper($r)."', '".$periodo."', '".$tipoNom."',  '".$IDEmpresa."', '".$centro."');";
                  $bd1->query($Minsert);
                }else{
                  $Minsert = "UPDATE datos SET valor = '".strtoupper($r)."' WHERE codigo = '".odbc_result($rs,"codigo")."' and nombre = '".$nombre."' and periodoP = '".$periodo."' and tipoN = '".$tipoNom."' and IDEmpresa = '".$IDEmpresa."' and Centro = '".$centro."';";
                  $bd1->query($Minsert);
                }

              }

              /*$Minsert = "INSERT INTO datos VALUES (NULL, '".odbc_result($rs,"codigo")."', '".$nombre."', '".strtoupper($r)."', '".$periodo."', '".$tipoNom."',  '".$IDEmpresa."', '".$centro."');";
              if($bd1->query($Minsert)){

              }else {
                echo $bd1->errno. '  '.$bd1->error;
              }*/


          }else {

          }
      }
  }
}

try {
  odbc_close(constructS());
  $bd1->close();
} catch (Exception $e) {
  echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
}
echo "1";
?>
