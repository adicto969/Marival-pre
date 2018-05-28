<?php
$periodo = $_POST['periodo'];
//$fecha1 = $_POST['fecha1'];
//$fecha2 = $_POST['fecha2'];
$tipoNom = $_POST['tipoNom'];
$divCabeFlotante = '<div id="DCF" style="position: relative; opacity: 0;"> <table class="striped highlight centered"><thead><tr>';
$dias = array('','LUN','MAR','MIE','JUE','VIE','SAB','DOM');
switch ($periodo) {
    case 1:
        $fecha1 = $A[0];
        $fecha2 = $A[1];
        $fecha3 = $A[2];
        $fecha4 = $A[3];
        break;
    case 2:
        $fecha1 = $B[0];
        $fecha2 = $B[1];
        $fecha3 = $B[2];
        $fecha4 = $B[3];
        break;
    case 3:
        $fecha1 = $C[0];
        $fecha2 = $C[1];
        $fecha3 = $C[2];
        $fecha4 = $C[3];
        break;
    case 4:
        $fecha1 = $D[0];
        $fecha2 = $D[1];
        $fecha3 = $D[2];
        $fecha4 = $D[3];
        break;
    case 5:
        $fecha1 = $E[0];
        $fecha2 = $E[1];
        $fecha3 = $E[2];
        $fecha4 = $E[3];
        break;
    case 6:
        $fecha1 = $F[0];
        $fecha2 = $F[1];
        $fecha3 = $F[2];
        $fecha4 = $F[3];
        break;
    case 7:
        $fecha1 = $G[0];
        $fecha2 = $G[1];
        $fecha3 = $G[2];
        $fecha4 = $G[3];
        break;
    case 8:
        $fecha1 = $H[0];
        $fecha2 = $H[1];
        $fecha3 = $H[2];
        $fecha4 = $H[3];
        break;
    case 9:
        $fecha1 = $I[0];
        $fecha2 = $I[1];
        $fecha3 = $I[2];
        $fecha4 = $I[3];
        break;
    case 10:
        $fecha1 = $J[0];
        $fecha2 = $J[1];
        $fecha3 = $J[2];
        $fecha4 = $J[3];
        break;
    case 11:
        $fecha1 = $K[0];
        $fecha2 = $K[1];
        $fecha3 = $K[2];
        $fecha4 = $K[3];
        break;
    case 12:
        $fecha1 = $L[0];
        $fecha2 = $L[1];
        $fecha3 = $L[2];
        $fecha4 = $L[3];
        break;
    case 13:
        $fecha1 = $M[0];
        $fecha2 = $M[1];
        $fecha3 = $M[2];
        $fecha4 = $M[3];
        break;
    case 14:
        $fecha1 = $N[0];
        $fecha2 = $N[1];
        $fecha3 = $N[2];
        $fecha4 = $N[3];
        break;
    case 15:
        $fecha1 = $O[0];
        $fecha2 = $O[1];
        $fecha3 = $O[2];
        $fecha4 = $O[3];
        break;
    case 16:
        $fecha1 = $P[0];
        $fecha2 = $P[1];
        $fecha3 = $P[2];
        $fecha4 = $P[3];
        break;
    case 17:
        $fecha1 = $Q[0];
        $fecha2 = $Q[1];
        $fecha3 = $Q[2];
        $fecha4 = $Q[3];
        break;
    case 18:
        $fecha1 = $R[0];
        $fecha2 = $R[1];
        $fecha3 = $R[2];
        $fecha4 = $R[3];
        break;
    case 19:
        $fecha1 = $S[0];
        $fecha2 = $S[1];
        $fecha3 = $S[2];
        $fecha4 = $S[3];
        break;
    case 20:
        $fecha1 = $T[0];
        $fecha2 = $T[1];
        $fecha3 = $T[2];
        $fecha4 = $T[3];
        break;
    case 21:
        $fecha1 = $U[0];
        $fecha2 = $U[1];
        $fecha3 = $U[2];
        $fecha4 = $U[3];
        break;
    case 22:
        $fecha1 = $V[0];
        $fecha2 = $V[1];
        $fecha3 = $V[2];
        $fecha4 = $V[3];
        break;
    case 23:
        $fecha1 = $W[0];
        $fecha2 = $W[1];
        $fecha3 = $W[2];
        $fecha4 = $W[3];
        break;
    case 24:
        $fecha1 = $X[0];
        $fecha2 = $X[1];
        $fecha3 = $X[2];
        $fecha4 = $X[3];
        break;
}

if($TN == 1 || $periodo > 24){
  $ANperiodo = $PC - 1;
  $selectF =  "select convert (varchar (10), inicio, 111), convert (varchar (10), cierre, 111) from Periodos where tiponom = 1 and periodo = '".$PC."' and ayo_operacion = '".$ayoA."'";
  $rsPS2 = odbc_exec( constructS(), $selectF );
  $fecha1A = odbc_result($rsPS2,1);
  $fecha2A = odbc_result($rsPS2,2);

  $sqlPS2 =  "select convert (varchar (10), inicio, 103), convert (varchar (10), cierre, 103) from Periodos where tiponom = 1 and periodo = '".$ANperiodo."' and ayo_operacion = '".$ayoA."'";
  $rsPS2 = odbc_exec( constructS(), $sqlPS2 );
  $fecha1 = odbc_result($rsPS2,1);
  $fecha2 = odbc_result($rsPS2,2);


  $sqlPS3 =  "select convert (varchar (10), inicio, 103), convert (varchar (10), cierre, 103) from Periodos where tiponom = 1 and periodo = '".$periodo."' and ayo_operacion = '".$ayoA."'";
  $rsPS3 = odbc_exec( constructS(), $sqlPS3 );
  $fecha3 = odbc_result($rsPS3,1);
  $fecha4 = odbc_result($rsPS3,2);
}

/////INCRUSTAR CHECADAS

$Jcodigos = file_get_contents("datos/empleados.json");
$datos = json_decode($Jcodigos, true);
$contarJSON = count($datos["empleados"]);

$explodeF1 = explode('/', $fecha1);
$explodeF2 = explode('/', $fecha2);

$date = $explodeF1[2].'/'.$explodeF1[1].'/'.$explodeF1[0];
$fechaFF = $explodeF2[0].'/'.$explodeF2[1].'/'.$explodeF2[2];


$verificacion = true;
for($j = 0; $j <= $contarJSON - 1; $j++){

    if($datos["empleados"][$j]['estado'] == 1){
        $randon1 = rand(0, 15);

        $hora1 = strtotime($datos["empleados"][$j]["hora"]);
        $horaD1 = (date('H:i:s', $hora1));

        $hora2 = strtotime($datos["empleados"][$j]["hora2"]);
        $horaD2 = (date('H:i:s', $hora2));


        ///RECORRER DOS FECHAS
        for($i=0; $i<=31; $i++){

          $fechaS = date("d/m/Y", strtotime($date." + ".$i." day"));

          list($dia, $mes, $ayo) = explode('/', $fechaS);
          $fconsult = $ayo.$mes.$dia;

          $divFS = explode('/', $fechaS);
          $FSMK = mktime(0,0,0,$divFS[1],$divFS[0],$divFS[2]);

          $divFF = explode('/', $fechaFF);
          $FFMK = mktime(0,0,0,$divFF[1],$divFF[0],$divFF[2]);

          if($FSMK <= $FFMK){

            ///CONFIRMAR QUE NO EXITA ENTRADA
            $consultaChecada = "SELECT R.checada
                                FROM relch_registro AS R
                                WHERE R.fecha = '".$fconsult."'
                                AND R.codigo = ".$datos["empleados"][$j]["codigo"]."
                                AND R.empresa = ".$datos["empleados"][$j]["empresa"]."
                                AND R.checada <> '00:00:00'
                                AND (R.EoS = '1' OR R.EoS = 'E' OR R.EoS IS NULL);";

            $rs = odbc_exec( constructS(), $consultaChecada );

            if( odbc_fetch_row($rs) )
            {
              //echo odbc_result($rs, 1);
            }else {
              $fechainsert = date("Ymd", $FSMK); //FECHA DE INSERCCION
              $fgh = strtotime('+'.rand(0, 15).' minute', strtotime($horaD1));
              $nfg3 = date('H:i:s', $fgh); //HORAR DE INSERCCION
              $checadaEntrada = "ObtenRelojDatosEmps ".$datos["empleados"][$j]["empresa"].", ".$datos["empleados"][$j]["codigo"].", '".$fechainsert."', '".$nfg3."', 'N', ' ', ' '";

              try {

                  $inserSQLS = odbc_exec(constructS(), $checadaEntrada);
                  if($inserSQLS){
                    $file = fopen("datos/inserSS.txt", "w");
                    fwrite($file, 1);
                    fclose($file);
                  }else {
                    $verificacion = false;
                  }

              } catch (Exception $e){
                 var_dump($e->getMessage());
              }
              odbc_close(constructS());
            }

            ////////////CONFIRMAR QUE EXITA UNA SALIDA

            $consultaChecada0 = "SELECT R.checada
                                FROM relch_registro AS R
                                WHERE R.fecha = '".$fconsult."'
                                AND R.codigo = ".$datos["empleados"][$j]["codigo"]."
                                AND R.empresa = ".$datos["empleados"][$j]["empresa"]."
                                AND R.checada <> '00:00:00'
                                AND (R.EoS = '2' OR R.EoS = 'S' OR R.EoS IS NULL);";


            $rs0 = odbc_exec( constructS(), $consultaChecada0 );


            if( odbc_num_rows($rs0) == 1 )
            {
              $fechainsert = date("Ymd", $FSMK); //FECHA DE INSERCCION
              $fgh = strtotime('+'.rand(0, 15).' minute', strtotime($horaD2));
              $noraFD = date('H:i:s', $fgh); //HORAR DE INSERCCION

              $checadaSalida = "ObtenRelojDatosEmps ".$datos["empleados"][$j]["empresa"].", ".$datos["empleados"][$j]["codigo"].", '".$fechainsert."', '".$noraFD."', 'N', ' ', ' '";

              try {
                  $inserSQLS = odbc_exec(constructS(), $checadaSalida);
                  if($inserSQLS){
                    $file = fopen("datos/inserSS.txt", "w");
                    fwrite($file, 1);
                    fclose($file);
                  }else {
                    $verificacion = false;
                  }
              } catch (Exception $e){
                 var_dump($e->getMessage());
              }
              odbc_close(constructS());
            }

          }
        }

    }
}

if($verificacion == false){
  echo "<script >alert ('ERROR - Verifica los parametros de los empleados(cargarChecadas)');</script>";
}


$ArchivoTxt = fopen("datos/Factor_Ausen.txt", "r");
$FactorAu = fgets($ArchivoTxt);

$bd1 = new ConexionM();
$bd1->__constructM();
$InsertarPT = "UPDATE config SET PC = '$periodo' WHERE IDUser = '".$_SESSION['IDUser']."';";
$InsertarTNT = "UPDATE config SET TN = '$tipoNom' WHERE IDUser = '".$_SESSION['IDUser']."';";


#Consulta SQL PARA OBTENER LA CABECERA
$bdSQL = new ConexionS();

list($dia, $mes, $ayo) = explode('/', $fecha1);
list($diaB, $mesB, $ayoB) = explode('/', $fecha2);

$fecha1 = $ayo.$mes.$dia;
$fecha2 = $ayoB.$mesB.$diaB;

if($DepOsub == 1){
  $querySQL = "DECLARE  @return_value int

    EXEC  @return_value = [dbo].[reporte_checadas_excel_ctro]
            @fecha1 = '".$fecha1."',
            @fecha2 = '".$fecha2."',
            @CENTRO = '".$centro."',
            @superv = '0',
            @empresa = '".$IDEmpresa."',
            @tiponom = '".$tipoNom."',
            @StringExtra = 'LEFT (Llaves.centro, ".$MascaraEm.") = LEFT (''".$centro."'', ".$MascaraEm.")',
            @Tp = '1'
    SELECT  'Return Value' = @return_value";

    $ComSql2 = "LEFT (Centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $querySQL = "DECLARE  @return_value int

    EXEC  @return_value = [dbo].[reporte_checadas_excel_ctro]
            @fecha1 = '".$fecha1."',
            @fecha2 = '".$fecha2."',
            @CENTRO = '".$centro."',
            @superv = '0',
            @empresa = '".$IDEmpresa."',
            @tiponom = '".$tipoNom."',
            @StringExtra = 'Llaves.centro = ''".$centro."''',
            @Tp = '0'
    SELECT  'Return Value' = @return_value";

    $ComSql2 = "Centro = '".$centro."'";
}


$numCol = count($bdSQL->recorrer($querySQL));
if($numCol > 1){

  ################################################################################
  ######################INSERTAR DATOS NUEVOS TIPONOM y PERIODO###################
  if($bd1->query($InsertarPT)){

  }else {
    echo $bd1->errno. '  '.$bd1->error;
  }

  if($bd1->query($InsertarTNT)){

  }else {
    echo $bd1->errno. '  '.$bd1->error;
  }
  #################################################################################

  $permisoT = $_SESSION["Permiso"];
  //$BTNT = '<button id="btnTGuardar" class="waves-effect waves-light btn" style="margin: 20px;" style="margin: 20px;" onclick="GuardarT()">GUARDAR</button>';
  $BTNT = '';
  $BLOCKtxt = 'disabled=""';
  if($permisoT == 1){
    $BLOCKtxt = '';
    //$BTNT = '<button id="btnTGuardar" class="waves-effect waves-light btn" style="margin: 20px;" onclick="GuardarT()">Guardar</button> <button name="generar" id="btnGenerar" class="waves-effect waves-light btn" onclick="GTasistencia()" style="margin: 20px;">GENERAR</button> <button name="cierre" class="waves-effect waves-light btn" style="margin: 20px;" onclick="CerrarT()">CIERRE</button>';
    $BTNT = '<button name="generar" id="btnGenerar" class="waves-effect waves-light btn" onclick="GTasistencia()" style="margin: 20px;">GENERAR</button> <button name="cierre" class="waves-effect waves-light btn" style="margin: 20px;" onclick="CerrarT()">CIERRE</button>';
  }


  #################################################################################
  ##################VERIFICAR SI EXISTEN DATOS EN LA TABLA VALORES#################

  $checarValores = $bd1->query("SELECT valor FROM datos WHERE periodoP = '$periodo' AND tipoN = '$tipoNom' and ".$ComSql2.";");
  if($bd1->rows($checarValores) > 0 && $permisoT == 0){
    //$BTNT = '<button id="btnTActualizar" class="waves-effect waves-light btn" onclick="ActualizarT()">CORREGIR</button>';
    $BTNT = '';
  }

  if($bd1->rows($checarValores) > 0 && $permisoT == 1){
    $BTNT = '<button name="generar" id="btnGenerar" class="waves-effect waves-light btn" onclick="GTasistencia()" style="margin: 20px;">GENERAR</button> <button name="cierre" class="waves-effect waves-light btn" style="margin: 20px;" onclick="CerrarT()">CIERRE</button>';
    $BTNT = '<button name="corregir" class="waves-effect waves-light btn" onclick="ActualizarT()" style="margin: 20px;" id="btnTActualizar">CORREGIR</button> <button name="generar" id="btnGenerar" class="waves-effect waves-light btn" onclick="GTasistencia()" style="margin: 20px;">GENERAR</button> <button name="cierre" class="waves-effect waves-light btn" style="margin: 20px;" onclick="CerrarT()">CIERRE</button>';
  }

  #################################################################################
  $rs = odbc_exec(constructS(), $querySQL);

  echo '<form method="POST" id="frmTasis">
        <div id="Sugerencias" style="position: fixed; left: 0; top: -3px; padding-top: 15px; margin-bottom: 0; z-index: 998;"></div>
        <table id="t01" class="responsive-table striped highlight centered" >
        <thead id="Thfija">
        <tr>
        <th colspan="4" id="CdMas" style="background-color: white;
      border-top: 1px solid transparent; border-left: 1px solid transparent;"></th>';
  for($i=5; $i<=$numCol; $i++){
      // ejecutamos la función pasándole la fecha que queremos
    //$date = $bdSQL->cabercera($querySQL, $i);
    $date = odbc_field_name($rs, $i);
    $date = str_replace('/', '-', $date);
    $Fecha0 = date('Y-m-d', strtotime($date));

    $fecha = $dias[date('N', strtotime($Fecha0))];

    echo '<th id="CdMas" style="background-color: #00b0ff; border-right: 2px solid black;">'.$fecha.'</td>';
    echo '<input type = "hidden" name="CabeceraD[]" value="'.$fecha.'">';
  }
  echo '<th colspan="3" id="CdMas" style="background-color: white;
border-top: 1px solid transparent; border-right: 1px solid transparent;"></th></tr>';

  echo '<tr>';
  for ($x = 1; $x <= $numCol; $x++){
    $divCabeFlotante .= '<th class="Aline" id="thAnchoA'.$x.'">'.odbc_field_name($rs, $x).'</th>';
    if($x > 4){
        echo '<th class="Aline AlineF" id="thAnchoB'.$x.'">'.odbc_field_name($rs, $x).'</th>';
    }else {
        echo '<th class="Aline" id="thAnchoB'.$x.'">'.odbc_field_name($rs, $x).'</th>';
    }

    echo '<input type = "hidden" name="Cabecera[]" value="'.odbc_field_name($rs, $x).'">';
  }
  echo '<th class="Aline" id="thAUPP">P.P</th>';
  echo '<th class="Aline" id="thAUPA">P.A</th>';
  echo '<th id="thAFi">Firma</th>';
  echo "</tr></thead><tbody>";

  $divCabeFlotante .= '<th class="Aline" id="thAUPP1">P.P</th>';
  $divCabeFlotante .= '<th class="Aline" id="thAUPA1">P.A</th>';
  $divCabeFlotante .= '<th id="thAFi1">Firma</th>';
  $divCabeFlotante .= "</tr></thead></table></div>";

  #Consulta SQL PARA OBTENER EL CONTENIDO
  $lr = 0;

  while ( odbc_fetch_row( $rs ) )
  {
    $lr++;
    echo '<tr><td class="Aline">'.odbc_result($rs,"codigo").'</td>
          <td class="Aline">'.utf8_encode(odbc_result($rs,"Nombre")).'</td>
          <td class="Aline">'.odbc_result($rs,"Sueldo").'</td>
          <td class="Aline">'.odbc_result($rs,"Tpo").'
          </td>';


    for($m = 5; $m <= $numCol; $m++){

      $valorC = "";
      $colorF = 0;
      $fechaTitulo = str_replace("/", "-", odbc_field_name($rs, $m));

      $sql1 = $bd1->query("SELECT valor FROM datosanti WHERE codigo = '".odbc_result($rs,"codigo")."' AND nombre = 'fecha".$fechaTitulo."' and periodoP = '".$periodo."' and tipoN = '".$tipoNom."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql2." LIMIT 1;");
      if($bd1->rows($sql1) > 0){
        $colorF = 1;
      }


      $sql1 = $bd1->query("SELECT valor FROM datos WHERE codigo = '".odbc_result($rs,"codigo")."' AND nombre = '".$fechaTitulo."' and periodoP = '".$periodo."' and tipoN = '".$tipoNom."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql2." LIMIT 1;");
      if($bd1->rows($sql1) > 0){
        $datos = $bd1->recorrer($sql1);
        $valorC = $datos[0];
      }

      $sql1 = $bd1->query("SELECT valor FROM datosanti WHERE codigo = '".odbc_result($rs,"codigo")."' AND nombre = 'fecha".$fechaTitulo."' and periodoP = '".$periodo."' and tipoN = '".$tipoNom."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql2." and Autorizo1 = 1 LIMIT 1;");
      if($bd1->rows($sql1) > 0){
        $datos = $bd1->recorrer($sql1);
        $valorC = $datos[0];
      }

      $Fecha0J = date('Y-m-d', strtotime($fechaTitulo));
      $DiaNumero = date('N', strtotime($Fecha0J));

      if($DiaNumero == 1){
          $fechaJ = $dias[6];
      }else {
          $fechaJ = $dias[$DiaNumero-1];
      }

      if(empty($valorC)){

        $sql1J = $bd1->query("SELECT ".$fechaJ." FROM relacionempfrente WHERE Codigo = '".odbc_result($rs,"codigo")."' AND ".$ComSql2." AND IDEmpresa = '$IDEmpresa' LIMIT 1;");
        if($bd1->rows($sql1J) > 0){
          $datosJ = $bd1->recorrer($sql1J);
          $valorC = $datosJ[0];
        }
        if(!empty($valorC)){
          $INSERTRELACIONDT = "INSERT INTO datos VALUES (NULL, '".odbc_result($rs,"codigo")."', '$fechaTitulo', '$valorC', '$periodo', '$tipoNom', '$IDEmpresa', '$centro');";

          if($bd1->query($INSERTRELACIONDT)){

          }else {
            echo $bd1->errno. ' '.$bd1->error;
          }
        }

      }

      if(empty(odbc_result($rs,odbc_field_name($rs, $m)))){ // && odbc_result($rs,"Tpo") == "E"

        if(empty($valorC)){
          $valorC = "F";
          $insert = "INSERT INTO datos VALUES (NULL, '".odbc_result($rs,"codigo")."', '$fechaTitulo', 'F', '$periodo', '$tipoNom', '$IDEmpresa', '$centro');";

          if($bd1->query($insert)){

          }else {
            echo $bd1->errno. '  '.$bd1->error;
          }
        }

        echo '<td style="height: 74px;">';
                  //<input type="text" name="fecha'.odbc_result($rs,"codigo").$fechaTitulo.'[]" size="7"  autofocus pattern="[a-zA-Z]{3}|[a-zA-Z]{2}|[a-zA-Z]{1}" title="Solo se permite (F, P, S, T y D)" value="'.$valorC.'" onkeyup="javascript:this.value=this.value.toUpperCase();">
        if($colorF == 1){
            if($permisoT == 1){
                echo '<input type="text" style="background-color: #f57c7c;" id="'.odbc_result($rs,"codigo").$fechaTitulo.'" value="'.$valorC.'" onkeyup="ConsultaFrente('.odbc_result($rs,"codigo").', \''.$fechaTitulo.'\', \''.odbc_result($rs,"codigo").$fechaTitulo.'\')" >';
            }else {
                echo '<input type="text" style="background-color: #f57c7c;" id="'.odbc_result($rs,"codigo").$fechaTitulo.'" value="'.$valorC.'" '.$BLOCKtxt.'>';
            }
        }else {
            if($permisoT == 1){
                echo '<input type="text" id="'.odbc_result($rs,"codigo").$fechaTitulo.'" value="'.$valorC.'" onkeyup="ConsultaFrente('.odbc_result($rs,"codigo").', \''.$fechaTitulo.'\', \''.odbc_result($rs,"codigo").$fechaTitulo.'\')" >';
            }else {
                echo '<input type="text" id="'.odbc_result($rs,"codigo").$fechaTitulo.'" value="'.$valorC.'" '.$BLOCKtxt.' >';
            }
        }
        echo '</td>';

        $sql1 = $bd1->query("SELECT valor FROM datos WHERE codigo = '".odbc_result($rs,"codigo")."' AND nombre = '".$fechaTitulo."' and periodoP = '".$periodo."' and tipoN = '".$tipoNom."' and IDEmpresa = '".$IDEmpresa."' and ".$ComSql2." LIMIT 1;");
        if($bd1->rows($sql1) > 0){
          $datos = $bd1->recorrer($sql1);
          $valorC = $datos[0];
        }


      }else {
        $fechaTitulo = str_replace("/", "-", odbc_field_name($rs, $m));
        $CsValor = "";
        $CsDescansoL = "SELECT valor FROM deslaborado WHERE codigo = ".odbc_result($rs,"codigo")." AND fecha = '".$fechaTitulo."' AND periodo = $periodo AND tipoN = $tipoNom AND IDEmpresa = $IDEmpresa AND ".$ComSql2." LIMIT 1;";

        $sql1 = $bd1->query($CsDescansoL);
        if($bd1->rows($sql1) > 0){
          $datos = $bd1->recorrer($sql1);
          $CsValor = $datos[0];
        }
        if($CsValor == 1){
          echo '<td class="Aline" style="height: 74px;">
          <p style="padding: 0;margin: 0;text-align: center;">
            <input type="checkbox" checked="checked" id="'.odbc_result($rs,"codigo").$fechaTitulo.'DL"   />
            <label for="'.odbc_result($rs,"codigo").$fechaTitulo.'DL" onclick="DLaborados(\''.odbc_result($rs,"codigo").'\', \''.$fechaTitulo.'\', \''.$centro.'\', \''.$periodo.'\', \''.$tipoNom.'\', \''.$IDEmpresa.'\')" title="Descanso Laborado" style="padding: 6px;margin-left: 17px;position: absolute;margin-top: -25px;"></label>
          </p>
          <input type="text" value="'.$valorC.'" id="'.odbc_result($rs,"codigo").$fechaTitulo.'" onkeyup="ConsultaFrente('.odbc_result($rs,"codigo").', \''.$fechaTitulo.'\', \''.odbc_result($rs,"codigo").$fechaTitulo.'\')">
          </td>';
        }else {
          echo '<td class="Aline" style="height: 74px;">
          <p style="padding: 0;margin: 0;text-align: center;">
            <input type="checkbox" id="'.odbc_result($rs,"codigo").$fechaTitulo.'DL"   />
            <label for="'.odbc_result($rs,"codigo").$fechaTitulo.'DL" onclick="DLaborados(\''.odbc_result($rs,"codigo").'\', \''.$fechaTitulo.'\', \''.$centro.'\', \''.$periodo.'\', \''.$tipoNom.'\', \''.$IDEmpresa.'\')" title="Descanso Laborado" style="padding: 6px;margin-left: 17px;position: absolute;margin-top: -25px;"></label>
          </p>
          <input type="text" value="'.$valorC.'" id="'.odbc_result($rs,"codigo").$fechaTitulo.'" onkeyup="ConsultaFrente('.odbc_result($rs,"codigo").', \''.$fechaTitulo.'\', \''.odbc_result($rs,"codigo").$fechaTitulo.'\')">
          </td>';
        }

      }
    }

    if(odbc_result($rs, "Tpo") == "E"){
      $PPC = "";
      $PAC = "";

      $sql1 = $bd1->query("SELECT PP, PA FROM premio WHERE codigo = '".odbc_result($rs,"codigo")."' and Periodo = '".$periodo."' and TN = '".$tipoNom."' and ".$ComSql2." and IDEmpresa = '".$IDEmpresa."' LIMIT 1;");
      $datos = $bd1->recorrer($sql1);
      $PPC = $datos[0];
      $PAC = $datos[1];
      $sql1 = $bd1->query("SELECT PP FROM ajusteempleado WHERE IDEmpleado = '".odbc_result($rs,"codigo")."' and ".$ComSql2." and IDEmpresa = ".$IDEmpresa." LIMIT 1;");

      $datoPP = $bd1->recorrer($sql1);
      if($datoPP[0] == 0){
        if($PPC == 0){
          echo '<td ><input type="number" style="width: 70px;" min="0" name="pp'.odbc_result($rs,"codigo").'" placeholder="P.P" step="0.01" value=""></td>';
        }else {
          echo '<td ><input type="number" style="width: 70px;" min="0" name="pp'.odbc_result($rs,"codigo").'" placeholder="P.P" step="0.01" value="'.$PPC.'"></td>';
        }
      }else {
        echo '<td class="Aline"></td>';
        /*$sql1 = $bd1->query("SELECT PP FROM ajusteempleado WHERE IDEmpleado = '".odbc_result($rs,"codigo")."' and centro = '".$centro."' and IDEmpresa = ".$IDEmpresa." LIMIT 1;");
        if($bd1->rows($sql1) == 1){
          echo '<td >s</td>';
        }else {
          if($PPC == 0){
            echo '<td><input type="number" min="0" name="pp'.odbc_result($rs,"codigo").'" placeholder="P.P" step="0.01" value=""></td>';
          }else {
            echo '<td><input type="number" min="0" name="pp'.odbc_result($rs,"codigo").'" placeholder="P.P" step="0.01" value="'.$PPC.'"></td>';
          }
        }*/
      }

      $sql1 = $bd1->query("SELECT PA FROM ajusteempleado WHERE IDEmpleado = '".odbc_result($rs,"codigo")."' and ".$ComSql2." and IDEmpresa = ".$IDEmpresa." LIMIT 1;");
      $datoPA = $bd1->recorrer($sql1);
      if($datoPA[0] == 0){
        if($PAC == 0){
         echo '<td><input type="number" style="width: 70px;" min="0" name="pa'.odbc_result($rs,"codigo").'" placeholder="P.A" step="0.01" value=""></td>';
        }else {
          echo '<td><input type="number" style="width: 70px;" min="0" name="pa'.odbc_result($rs,"codigo").'" placeholder="P.A" step="0.01" value="'.$PAC.'"></td>';
        }
      }else {
        echo '<td class="Aline"></td>';
        /*$sql1 = $bd1->query("SELECT PA FROM ajusteempleado WHERE IDEmpleado = '".odbc_result($rs,"codigo")."' and centro = '".$centro."' and IDEmpresa = ".$IDEmpresa." LIMIT 1;");
        if($bd1->rows($sql1) == 1){
          echo '<td>t</td>';
        }else {
          if($PAC == 0){
              echo '<td><input type="number" min="0" name="pa'.odbc_result($rs,"codigo").'" placeholder="P.A" step="0.01" value=""></td>';
          }else{
              echo '<td><input type="number" min="0" name="pa'.odbc_result($rs,"codigo").'" placeholder="P.A" step="0.01" value="'.$PAC.'"></td>';
          }
        }*/
      }
    }else {
      echo '<td class="Aline"></td>';
      echo '<td class="Aline"></td>';
    }
    echo '<td ></td>';
    echo '</tr>';

  }

  $Fd = substr($fecha1, 6, 2);
  $Fm = substr($fecha1, 4, 2);
  $Fa = substr($fecha1, 0, 4);

  $F2d = substr($fecha2, 6, 2);
  $F2m = substr($fecha2, 4, 2);
  $F2a = substr($fecha2, 0, 4);

  $fecha1 = $Fd."/".$Fm."/".$Fa;
  $fecha2 = $F2d."/".$F2m."/".$F2a;

  echo '</tbody></table>';
  echo $divCabeFlotante;
  echo '<input type="hidden" name="Nresul" value="'.$lr.'"/>';
  echo '<input type="hidden" name="f1" value="'.$fecha1.'"/>';
  echo '<input type="hidden" name="f2" value="'.$fecha2.'"/>';
  echo '<input type="hidden" name="f3" value="'.$fecha3.'"/>';
  echo '<input type="hidden" name="f4" value="'.$fecha4.'"/>';
  echo '<input type="hidden" name="Ncabecera" value="'.$numCol.'"/>';
  echo '<input type="hidden" name="periodo" value="'.$periodo.'" id="periodo"/>';
  echo '<input type="hidden" name="NomDep" value="'.$NomDep.'"/>';
  echo '<input type="hidden" name="multiplo" value="'.$FactorAu.'"/>';
  echo '<input type="hidden" name="pp" value="'.$PP.'" id="hPP"/>';
  echo '<input type="hidden" name="pa" value="'.$PA.'" id="hPA"/>';
  echo '<input type="hidden" name="tipoNom" value="'.$tipoNom.'"/>';
  echo '<input type="hidden" name="centro" value="'.$centro.'" id="centro"/>';
  echo '</form>';
  echo $BTNT;
  echo '<a class="modal-trigger waves-effect waves-light btn"  onclick="modal()" style="margin: 20px;">Conceptos Extras</a>';

  try {
    odbc_close(constructS());
    $bd1->close();
  } catch (Exception $e) {
    echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
  }
}else {
  if($bd1->query($InsertarPT)){

  }else {
    echo $bd1->errno. '  '.$bd1->error;
  }

  if($bd1->query($InsertarTNT)){

  }else {
    echo $bd1->errno. '  '.$bd1->error;
  }

  try {
    odbc_close( constructS() );
    $bd1->close();
  } catch (Exception $e) {
    echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
  }
  echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}



?>
