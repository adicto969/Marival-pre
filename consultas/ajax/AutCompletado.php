<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$codigo = $_POST['codigo'];
$Tnn = $_POST['Tn'];

if($DepOsub == 1)
{
	$ComSql = "L.centro IN (".$centro.")";
}else {
	$ComSql = "L.centro IN (".$centro.")";
}

$consulta = "SELECT TOP 5 E.codigo, E.nombre + ' ' + E.ap_paterno + ' ' + E.ap_materno AS nombre
FROM empleados AS E
INNER JOIN Llaves AS L ON L.codigo = E.codigo AND L.empresa = E.empresa
WHERE E.codigo LIKE '".$codigo."%' AND L.empresa = $IDEmpresa AND L.tiponom = $Tnn AND $ComSql;
";

$objBDSQL->consultaBD($consulta);

while ($row = $objBDSQL->obtenResult()) {
  echo '
  <div class="chip" style="cursor: pointer;" onclick="agregartap('.$row["codigo"].')">
      '.$row["nombre"].'
      <i class="close material-icons">close</i>
  </div>
  ';
}



?>
