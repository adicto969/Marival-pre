<?php

$Jcodigos = file_get_contents("datos/empleados.json");
$datos = json_decode($Jcodigos, true);
$contarJSON = count($datos["empleados"]);

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

  $sqlPS2 =  "select convert (varchar (10), inicio, 103), convert (varchar (10), cierre, 103) from Periodos where tiponom = 1 and periodo = '".$ANperiodo."' and ayo_operacion = '".$ayoA."'";
  $rsPS2 = odbc_exec( constructS(), $sqlPS2 );
  $fecha1 = odbc_result($rsPS2,1);
  $fecha2 = odbc_result($rsPS2,2);

}


$verificacion = true;
for($j = 0; $j <= $contarJSON - 1; $j++){

    if($datos["empleados"][$j]['estado'] == 1){
        $randon1 = rand(0, 15);

        $hgg = strtotime($datos["empleados"][$j]["hora"]);
        $hgg3 = (date('h:i:s', $hgg));


        ///RECORRER DOS FECHAS
        for($i=0; $i<=31; $i++){

          $date = '2017/03/06';
          $fechaFF = '12/03/2017';
          $fechaS = date("d/m/Y", strtotime($date." + ".$i." day"));

          $divFS = explode('/', $fechaS);
          $FSMK = mktime(0,0,0,$divFS[1],$divFS[0],$divFS[2]);

          $divFF = explode('/', $fecha2);
          $FFMK = mktime(0,0,0,$divFF[1],$divFF[0],$divFF[2]);

          if($FSMK <= $FFMK){
            ///CONFIRMAR QUE NO EXITA ENTRADA
            $consultaChecada = "SELECT checada
                                FROM relch_registro AS R
                                INNER JOIN Llaves AS L ON L.codigo = R.codigo AND L.tiponom = R.tiponom AND L.centro = R.centro
                                WHERE fecha = ".$fechaS."
                                AND R.codigo = ".$datos["empleados"][$j]["codigo"]."
                                AND R.empresa = ".$datos["empleados"][$j]["empresa"]."
                                AND R.checada <> '00:00:00'
                                AND (EoS = '1' OR EoS = 'E');";

            $rs = odbc_exec( constructS(), $consultaChecada );

            if( odbc_fetch_row($rs) )
            {
              //echo odbc_result($rs, 1);
            }else {
              $fechainsert = date("Ymd", $FSMK); //FECHA DE INSERCCION
              $fgh = strtotime('+'.rand(0, 15).' minute', strtotime($hgg3));
              $nfg3 = date('h:i:s', $fgh); //HORAR DE INSERCCION
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

            $consultaChecada0 = "SELECT checada
                                FROM relch_registro AS R
                                INNER JOIN Llaves AS L ON L.codigo = R.codigo AND L.tiponom = R.tiponom AND L.centro = R.centro
                                WHERE fecha = ".$fechaS."
                                AND R.codigo = ".$datos["empleados"][$j]["codigo"]."
                                AND R.empresa = ".$datos["empleados"][$j]["empresa"]."
                                AND R.checada <> '00:00:00'
                                AND (EoS = '2' OR EoS = 'S');";

            $rs0 = odbc_exec( constructS(), $consultaChecada0 );

            if( odbc_fetch_row($rs0) )
            {
              //echo odbc_result($rs, 1);
            }else {
              $fechainsert = date("Ymd", $FSMK); //FECHA DE INSERCCION
              $fgh = strtotime('+'.rand(0, 15).' minute', strtotime($hgg3));
              $fgh = strtotime('+8 hour', strtotime($hgg3));
              $nfg3 = date('h:i:s', $fgh); //HORAR DE INSERCCION
              $checadaSalida = "ObtenRelojDatosEmps ".$datos["empleados"][$j]["empresa"].", ".$datos["empleados"][$j]["codigo"].", '".$fechainsert."', '".$nfg3."', 'N', ' ', ' '";

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

?>
