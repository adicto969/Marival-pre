<?php
$periodo = $PC;
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
if($periodo <= 24){
$_fechas = periodo($periodo, $TN);
list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $_fechas);
}
if($TN == 1 || $periodo > 24){
  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1', CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2' FROM Periodos WHERE tiponom = 1 AND periodo = $periodo AND ayo_operacion = $ayoA AND empresa = $IDEmpresa ;";
  $_resultados = $objBDSQL->consultaBD($_queryFechas);
  if($_resultados === false)
  {
      die(print_r(sqlsrv_errors(), true));
      exit();
  }else {
      $_datos = $objBDSQL->obtenResult();
  }
  $fecha1 = $_datos['FECHA1'];
  $fecha2 = $_datos['FECHA2'];
  $fecha3 = $_datos['FECHA1'];
  $fecha4 = $_datos['FECHA2'];
  $objBDSQL->liberarC();

}
?>
<h4 style="text-align: center;"><?php echo $NomDep; ?></h4>
<h5 style="text-align: center;">ROL DE HORARIO</h5>
<div>
  <center>
    <?php
      $numMESS = substr($fecha2, 3, 2);
      if($numMESS < 9){
        $numMESS = substr($fecha2, 4, 1);
      }
      $ayoF = substr($fecha2, 6, 4);
      $mesF = substr($fecha2, 3, 2);
      $diaF = substr($fecha2, 0, 2);

    ?>
      <p>DEL <input style="width: 64px; background-color: white; text-align: center;" id="Dia" type="number" min="1" max="31" value="<?php echo substr($fecha1, 0, 2);?>" /> AL <input style="width: 64px; background-color: white; text-align: center;" id="Dia2" type="number" min="1" max="31" value="<?php echo substr($fecha2, 0, 2); ?>" /> DE
      <select style="width: auto;" id="Mes">
        <option value="<?php echo $MESES[$numMESS];?>"><?php echo $MESES[$numMESS];?></option>
        <option value="<?php $diamas = date($ayoF."/".$mesF."/".$diaF); echo $MESES[date("n", strtotime($diamas." + 1 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 1 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 2 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 2 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 3 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 3 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 4 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 4 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 5 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 5 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 6 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 6 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 7 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 7 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 8 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 8 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 9 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 9 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 10 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 10 month"))]; ?></option>
        <option value="<?php echo $MESES[date("n", strtotime($diamas." + 11 month"))]; ?>"><?php echo $MESES[date("n", strtotime($diamas." + 11 month"))]; ?></option>
      </select>
      DEL
      <input style="width: 64px; background-color: white; text-align: center;" id="Ayo" type="number" value="<?php echo $ayoA;?>" />
      </p>
  </center>
</div>
<div class="modal " id="modal1" style="text-align: center; padding-top: 10px;">
  <h4 id="textCargado">Procesando...</h4>
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</div>
<div id="estado_consulta_ajax">

</div>
<script src="js/procesos/Rol.js"></script>
