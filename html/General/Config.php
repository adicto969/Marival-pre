<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

if($_SESSION['Permiso'] == 1 || $_SESSION['Sudo'] == 1){
	echo '<div class="fixed-action-btn" style="bottom: 24px; right: 24px;">';
	echo '	<a class="waves-effect waves-light btn-floating btn-large right-align red"><i data-target="modalConfig" class="material-icons prefix">settings</i></a>';
	echo '</div>';

	echo '<div id="modalConfig" class="modal bottom-sheet">';
	echo '	<div class="modal-content">';
	echo '		<div class="row">';
	echo '		<div class="col s12 m4"></div>';
	echo '		<div class="col s12 m4 input-field">';
	echo '		<input type="number" id="IDEmpConfig" placeholder="ID EMPRESA" value="'.$IDEmpresa.'" style="width: 100%;">';
	echo '		<select id="SelectDep">';
	echo '			<option value="0v">DEPARTAMENTOS</option>';

	$query = "SELECT LTRIM ( RTRIM ( centro ) ) AS centro, nomdepto FROM centros WHERE empresa = '".$IDEmpresa."' and defindpto2 = ".DepNumOrden." ORDER BY nomdepto asc;";
	$objBDSQL->consultaBD($query);
	while($datos = $objBDSQL->obtenResult()) {
		if($centro == $datos["centro"]){
				echo '<option value="'.$datos["centro"].'" selected>'.$datos["nomdepto"].'</option>';
		}else {
				echo '<option value="'.$datos["centro"].'">'.$datos["nomdepto"].'</option>';
		}

	}
	$objBDSQL->liberarC();

	echo '		</select>';

	echo '		<select id="SelectSub">';
	echo '		<option value="0v">SUB-DEPARTAMENTOS</option>';

	$query = "SELECT LTRIM ( RTRIM ( centro ) ) AS centro, nomdepto FROM centros WHERE empresa = '".$IDEmpresa."' and defindpto2 <> ".DepNumOrden." ORDER BY nomdepto asc;";
	$objBDSQL->consultaBD($query);

	while($datos = $objBDSQL->obtenResult()) {
		if($centro == $datos["centro"]){
				echo '<option value="'.$datos["centro"].'" selected>'.$datos["nomdepto"].'</option>';
		}else {
				echo '<option value="'.$datos["centro"].'">'.$datos["nomdepto"].'</option>';
		}

	}
	$objBDSQL->liberarC();

	echo '	</select>';
	echo '	<select id="SelectSupervisor">';
	echo '		<option value="0v" disabled="disabled">SUPERVISOR</option>';
	$queryS = "SELECT supervisor, nombre FROM supervisores WHERE empresa = ".$IDEmpresa;
	$objBDSQL->consultaBD($queryS);
	while ($datos = $objBDSQL->obtenResult()) {
		if($datos['supervisor'] == $supervisor){
			echo '<option value="'.$datos['supervisor'].'" selected>'.utf8_encode($datos['nombre']).'</option>';
		}else {
			echo '<option value="'.$datos['supervisor'].'">'.utf8_encode($datos['nombre']).'</option>';
		}
	}
	$objBDSQL->liberarC();
	echo '	</select>';
	echo '	</div>';
	echo '	<div class="col s12 m4"></div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}else {
echo '<div class="fixed-action-btn" style="bottom: 24px; right: 24px;">';
	echo '	<a class="waves-effect waves-light btn-floating btn-large right-align red"><i data-target="modalConfig" class="material-icons prefix">settings</i></a>';
	echo '</div>';

	echo '<div id="modalConfig" class="modal bottom-sheet">';
	echo '	<div class="modal-content">';
	echo '		<div class="row">';
	echo '		<div class="col s12 m4"></div>';
	echo '		<div class="col s12 m4 input-field">';
	echo '		<div style="height: 30px;margin-bottom: 10px;"><label>Seleccione Un Supervisor</label></div>';
	echo '	<select id="SelectSupervisor">';
	echo '		<option value="0v" disabled="disabled">SUPERVISOR</option>';
	$queryS = "SELECT supervisor, nombre FROM supervisores WHERE empresa = ".$IDEmpresa;
	$objBDSQL->consultaBD($queryS);
	while ($datos = $objBDSQL->obtenResult()) {
		if($datos['supervisor'] == $supervisor){
			echo '<option value="'.$datos['supervisor'].'" selected>'.utf8_encode($datos['nombre']).'</option>';
		}else {
			echo '<option value="'.$datos['supervisor'].'">'.utf8_encode($datos['nombre']).'</option>';
		}
	}
	$objBDSQL->liberarC();
	echo '	</select>';
	echo '	</div>';
	echo '	<div class="col s12 m4"></div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
}

try {
  $objBDSQL->cerrarBD();
} catch (Exception $e) {
  echo 'ERROR al cerrar la conexion con SQL SERVER', $e->getMessage(), "\n";
}


?>
