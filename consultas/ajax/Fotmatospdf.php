<?php

$bdS = constructS();
$bdSQL = new ConexionS();

if($DepOsub == 1)
{
  $ComSql = "LEFT (b.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
  $ComSql = "b.centro = '".$centro."'";
}

$sql = "
    SELECT a.codigo,
       LTRIM (a.nombre)+' '+LTRIM(a.ap_paterno)+' '+LTRIM(a.ap_materno) as Nombre,
       b.nomdepto ,
       c.actividad,
       convert (varchar(10), e.campo_07, 103) as Fch_antiguedad,
       max(convert (varchar(10), e.fch_mov, 103)) as fch_baja

from empleados as a

INNER JOIN Llaves as d on d.empresa = a.empresa  and d.codigo = a.codigo
INNER JOIN centros as b on b.empresa = d.empresa and b.centro = d.centro
INNER JOIN tabulador as c on c.empresa = d.empresa and c.ocupacion = d.ocupacion
INNER JOIN avisos_imss as e on e.empresa = a.empresa and e.codigo = a.codigo

where a.activo = 'S' and
      e.mov = 'B' and
      e.ayo_operacion = ".$ayoA." and
      e.mes_operacion = ".date('m')." and
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

echo $sql;

$num = count($bdSQL->recorrer($sql));

if($num > 1){

echo '
<form>
  <table>
    <thead>
      <tr>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Departamento</th>
        <th>Actividad</th>
        <th>Fecha de Antiguedad</th>
        <th>Fecha de Baja</th>
        <th>Vencimiento</th>
        <th>Salida</th>
        <th>Liberacion</th>
        <th>Seleccionar</th>
      </tr>
    </thead>
    <tbody>
';



echo '
    </tbody>
  </table>
</from>
';

}else {
  //echo "No Se Encontraron Resultados";
  echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';


}


?>
