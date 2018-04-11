<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$porcentaje = $_POST['Pdf'];
$resultado = "";


$bd1 = new ConexionM();
$bd1->__constructM();
$InsertarCP = "UPDATE config SET POR = '$porcentaje' WHERE IDUser = '".$_SESSION['IDUser']."';";

if($bd1->query($InsertarCP)){

}else {
  echo $bd1->errno. '  '.$bd1->error;
}

$bd1->close();


if($DepOsub == 1)
{
  $ComSql = "LEFT (b.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  $ComSql99 = "LEFT (S.centro, ".$MascaraEm.") = LEFT (b.centro, ".$MascaraEm.")";
}else {
  $ComSql = "b.centro = '".$centro."'";
  $ComSql99 = "S.centro = b.centro";
}

$query = "
        select distinct a.ocupacion,
                a.actividad,
                COUNT(llaves.ocupacion) as Total,
                S.v".$porcentaje." as Num

        from tabulador as a

        inner join Llaves as b on b.empresa = a.empresa and b.ocupacion = a.ocupacion
        inner join empleados as c on c.empresa = b.empresa and c.codigo = b.codigo
        INNER JOIN llaves on llaves.empresa = c.empresa and llaves.codigo = c.codigo
        inner join staff_porcentaje as S on S.empresa = a.empresa and S.ocupacion = b.ocupacion and ".$ComSql99."

        where c.activo = 'S' and
        ".$ComSql."

        group by  a.ocupacion,
                  llaves.ocupacion,
                  S.v".$porcentaje.",
                  a.actividad
    ";

$objBDSQL->obtenfilas($query);

$numCol = $objBDSQL->obtenfilas($query);
if($numCol > 1){
  $resultado = '<table class="striped highlight centered">
                  <thead>
                    <tr>
                        <th style="width: 20px;">N°</th>
                        <th>Puesto</th>
                        <th>AUT</th>
                        <th>ACT</th>
                        <th>DIF</th>
                    </tr>
                  </thead><tbody>';
  $objBDSQL->consultaBD($query);
  while ($row = $objBDSQL->obtenResult()) {
    $resultado .= '<tr>
                    <td>'.$row["ocupacion"].'</td>
                    <td>'.utf8_encode($row["actividad"]).'</td>
                    <td>'.$row["Num"].'</td>
                    <td>'.$row["Total"].'</td>
                    <td>'.$dif=($row["Total"]-$row["Num"]).'</td>
                  </tr>';
  }
  $objBDSQL->liberarC();
  $resultado .= '</tbody></table>';
  echo $resultado;
}else {
  //echo "No se a establecido un staffing";
  echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se a establecido un staffing !</h6></div>';
}
$objBDSQL->cerrarBD();


?>
