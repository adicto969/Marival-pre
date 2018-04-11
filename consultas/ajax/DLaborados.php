<?php

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();

$bdM = new ConexionM();
$bdM->__constructM();

$Fch = $_POST['fcH'];
$Tn = $_POST['Tn'];
$Dep = $_POST['Dep'];

list($dia, $mes, $ayo) = explode('/', $Fch);
$Fch = $ayo.$mes.$dia;

if($DepOsub == 1)
{
	$ComSql = "LEFT (relch_registro.centro, ".$MascaraEm.") = LEFT ('".$Dep."', ".$MascaraEm.")";
	$ComSql2 = "LEFT (centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
}else {
	$ComSql = "relch_registro.centro = '".$Dep."'";
	$ComSql2 = "centro = '".$centro."'";
}

if($Dep == "todos" || $Dep == "todo" || $Dep == "TODOS" || $Dep == "TODO"){

	$query = "
		select DISTINCT relch_registro.codigo,
        empleados.ap_paterno+' '+empleados.ap_materno+' '+empleados.nombre AS nombre,
        tabulador.actividad,
        empleados.sueldo,
        convert (varchar(10), relch_registro.fecha, 103) as Fecha,
        relch_registro.num_conc,
        '8' as Horas,
        empleados.sueldo * '2'  as Importe

        from relch_registro

        INNER JOIN empleados on empleados.empresa = relch_registro.empresa and empleados.codigo = relch_registro.codigo
        INNER JOIN Llaves on Llaves.empresa = relch_registro.empresa and Llaves.codigo = relch_registro.codigo
        INNER JOIN tabulador on  tabulador.empresa = Llaves.empresa and  tabulador.ocupacion = Llaves.ocupacion

        where relch_registro.empresa =  '".$IDEmpresa."' and
        empleados.activo = 'S' and
        relch_registro.fecha = '".$Fch."'  and
        relch_registro.num_conc = 10 and
        relch_registro.tiponom = '".$Tn."'
        group by relch_registro.codigo, empleados.ap_paterno, empleados.ap_materno,
			empleados.nombre, tabulador.actividad, empleados.sueldo, relch_registro.fecha,
			relch_registro.num_conc, relch_registro.centro
        order by tabulador.actividad

	";
}else {

	$query = "

		select DISTINCT relch_registro.codigo,
        empleados.ap_paterno+' '+empleados.ap_materno+' '+empleados.nombre AS nombre,
        tabulador.actividad,
        empleados.sueldo,
        convert (varchar(10), relch_registro.fecha, 103) as Fecha,
        relch_registro.num_conc,
        '8' as Horas,
        empleados.sueldo * '2'  as Importe

        from relch_registro

        INNER JOIN empleados on empleados.empresa = relch_registro.empresa and empleados.codigo = relch_registro.codigo
        INNER JOIN Llaves on Llaves.empresa = relch_registro.empresa and Llaves.codigo = relch_registro.codigo
        INNER JOIN tabulador on  tabulador.empresa = Llaves.empresa and  tabulador.ocupacion = Llaves.ocupacion

        where relch_registro.empresa =  '".$IDEmpresa."' and
        empleados.activo = 'S' and
        relch_registro.fecha = '".$Fch."'  and
        relch_registro.num_conc = 10 and	
        relch_registro.tiponom = '".$Tn."' and
        ".$ComSql."
        group by relch_registro.codigo, empleados.ap_paterno, empleados.ap_materno,
			empleados.nombre, tabulador.actividad, empleados.sueldo, relch_registro.fecha,
			relch_registro.num_conc, relch_registro.centro
        order by relch_registro.codigo asc


	";

}


$numC = $objBDSQL->obtenfilas($query);

if($numC > 0){

	echo '
		<form id="frmDLaborados">
			<table class="responsive-table striped highlight centered">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Nombre</th>
						<th>Actividad</th>
						<th>Sueldo</th>
						<th>Fecha</th>
						<th>N. Conc</th>
						<th>Horas</th>
						<th>Importe</th>
						<th>Seleccion</th>
					</tr>
				</thead>
				<tbody>';

	$lr = 0;
	$objBDSQL->consultaBD($query);
	while($row = $objBDSQL->obtenResult())
	{
		$lr++;

		echo '
			<tr>
				<td>'.$row["codigo"].'</td>
				<td>'.utf8_decode($row["nombre"]).'</td>
				<td>'.$row["actividad"].'</td>
				<td>'.$row["sueldo"].'</td>
				<td>'.$row["Fecha"].'</td>
				<td>'.$row["num_conc"].'</td>
				<td>'.$row["Horas"].'</td>
				<td>'.$row["Importe"].'</td>
		';

		$consultInt = "SELECT DLaborados FROM ajusteempleado WHERE IDEmpleado = '".$row["codigo"]."' AND ".$ComSql2." AND IDEmpresa = ".$IDEmpresa.";";
		$objBDSQL2->consultaBD2($consultInt);
		$datos = $objBDSQL2->obtenResult2();

		if($datos['DLaborados'] == 1){
			$c1 = "";
		}else {
			$c1 = 'checked="checked"';
		}

		echo '
				<td><p style="text-align: center;"><input type="checkbox" name="'.$row["codigo"].$lr.'" value="'.$row["codigo"].$lr.'" '.$c1.' id="'.$row["codigo"].$lr.'"><label for="'.$row["codigo"].$lr.'"></label></p></td>
			</tr>
		';

	}


	echo '

				</tbody>
			</table>
		</form>
		<button class="btn" style="margin: 20px;" onclick="GDLaborados()">GENERAR</button>
	';



}else {
	//echo "No Se Encontraron Resultados";
	echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}
$objBDSQL->cerrarBD();
$objBDSQL2->cerrarBD();

?>
