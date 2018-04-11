<?php
$fecha1="";
$fecha2="";
$fecha3="";
$fecha4="";

switch ($PC) {
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

/*$date20 = new DateTime($fecha3);
$fecha31 =  $date20->format('Ymd');
$date21 = new DateTime($fecha4);
$fecha32 =  $date21->format('Ymd');*/
$bdS = constructS();
$resultado = "";


if($DepOsub == 1)
{
	$ComSql = "LEFT (b.centro, ".$MascaraEm.") = LEFT ('".$centro."', $MascaraEm)";
}else {
	$ComSql = "b.centro = '".$centro."'";
}


$query = "
SELECT a.codigo,
   LTRIM (a.nombre)+' '+LTRIM(a.ap_paterno)+' '+LTRIM(a.ap_materno) as Nombre,
   b.nomdepto ,
   c.actividad,
   convert (varchar(10), e.campo_07, 103) as Fch_antiguedad,
   max(convert (varchar(10), e.fch_mov, 103)) as fch_baja

from empleados as a

INNER Join Llaves as d on d.empresa = a.empresa  and d.codigo = a.codigo
INNER JOIN centros as b on b.empresa = d.empresa and b.centro = d.centro
INNER JOIN tabulador as c on c.empresa = d.empresa and c.ocupacion = d.ocupacion
left join avisos_imss as e on e.empresa = a.empresa and e.codigo = a.codigo

where a.activo = 'S' and
  e.mov = 'B' and
  e.ayo_operacion = ".$ayoA." and
  e.empresa = '".$IDEmpresa."' and
  d.supervisor = '".$supervisor."' and
  ".$ComSql."

Group by a.codigo,
     a.nombre,
     a.ap_paterno,
     a.ap_materno,
     b.nomdepto,
     c.actividad,
     a.fchantigua,
     e.fch_mov,
     e.campo_07
";
//e.fch_mov BETWEEN '".$fecha31."'  and '".$fecha32."' and
$bdSQL = new ConexionS();

$numCol = count($bdSQL->recorrer($query));
if($numCol > 1){
  $rs = odbc_exec($bdS, $query);

  $resultado .= '
  <div rol="form" id="frmFormatos">
  <table class="responsive-table striped highlight centered">
    <thead>
      <tr>
        <th>'.odbc_field_name($rs, 1).'</th>
        <th>'.odbc_field_name($rs, 2).'</th>
        <th>'.odbc_field_name($rs, 3).'</th>
        <th>'.odbc_field_name($rs, 4).'</th>
        <th>'.odbc_field_name($rs, 5).'</th>
        <th>'.odbc_field_name($rs, 6).'</th>
        <th class="Cultimo">Vencimiento</th>
        <th class="Cultimo">Salida</th>
        <th class="Cultimo">Liberacion</th>
        <th class="Cultimo">Seleccionar</th>
      </tr>
    </thead>
    <tbody>';

  $lr = 0;
  while (odbc_fetch_row($rs)) {
    $lr++;
    $resultado .= '
    <tr>
      <td>'.odbc_result($rs,"codigo").'</td>
      <td>'.utf8_encode(odbc_result($rs,"Nombre")).'</td>
      <td>'.odbc_result($rs,"nomdepto").'</td>
      <td>'.odbc_result($rs,"actividad").'</td>
      <td>'.odbc_result($rs,"Fch_antiguedad").'</td>
      <td>'.odbc_result($rs,"fch_baja").'</td>
      <td><button class="btn mnone" name="VenceContrato" value="'.odbc_result($rs,"CODIGO").'" onclick="venceC('.odbc_result($rs,"CODIGO").')">imprimir</button>
      <td id="salida"><button class="btn mnone" name="EntrevistaSalida" value="'.odbc_result($rs,"CODIGO").'" onclick="salida('.odbc_result($rs,"CODIGO").')">Imprimir</button>
      <td><button class="btn mnone" name="HojaLiberacion" value="'.odbc_result($rs,"CODIGO").'" onclick="liberacion('.odbc_result($rs,"CODIGO").')">Imprimir</button>
      <td>
        <p id="pF" style="text-align: center;">
          <input type="checkbox" id="c'.$lr.'"  onClick="if(this.checked){masChe('.odbc_result($rs,"codigo").')} else{menChe('.odbc_result($rs,"codigo").')}" />
          <label for="c'.$lr.'"></label>
        </p>
      </td>
    </tr>';
  }

  $resultado .= '
      </tbody>
    </table>
  </div>
  ';

  echo $resultado;
}else{
  //echo "NO SE ENCONTRARON RESULTADOS";
  echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}

?>
