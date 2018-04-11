<?php
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

if($PC <= 24 && $TN != 1){
	$_fechas = periodo($PC, $TN);
	list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $_fechas);
}

if($TN == 1 || $PC > 24)
{
  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1', CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2' FROM Periodos WHERE tiponom = 1 AND periodo = $PC AND ayo_operacion = $ayoA AND empresa = $IDEmpresa ;";

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
$objBDSQL->cerrarBD();
?>
<h4 style="text-align: center;"><?php echo $NomDep; ?></h4>
<p class="center" style="font-size: 18px;"><?php echo strtoupper(utf8_encode($NombreSupervisor)); ?></p>
<h5 style="text-align: center;">DESTAJO</h5>
<div class="row">
  	<div class="col s12 m6 offset-m3 l4" id="parametros">
    	<div role="form" onkeypress="return scriptChecadas(event)">
          	<div>
	            <label for="periodo">PERIODO DE CORTE</label>
	            <input onclick="cambiarPeriodo()" onKeyUp="cambiarPeriodo()" style="width: 142px; margin-left: 22px; font-size: 1rem; height: 1.5rem;" id="periodo" type="number" min="1" name="periodo" value="<?php echo $PC; ?>">
	            <br/>
	            <br/>
	            <label for="tiponom">Tipo de nomina</label>
	            <input id="tiponom" type="number" min="1" max="6" name="tiponom" value="<?php echo $TN; ?>" style="margin-left: 52px; width: 142px; font-size: 1rem; height: 1.5rem;">
	            <br/>
              <label for="Dep">Departamento</label>
              <input id="Dep" type="text" name="Dep" value="<?php echo $centro; ?>" style="margin-left: 57px; width: 142px; font-size: 1rem; height: 1.5rem;">
              <br/>
	            <div class="boton col s12 center-align" style="margin-top: 50px; margin-bottom: 50px;">
	                <input class="btn" type="submit" value="BUSCAR" onclick="REcargoColum()" id="btnT"/>
                  <input class="btn" type="submit" value="Excel" onclick="pruebaExcel()" id="btnE"/>
	            </div>
	            <br/>
	            <br/>
          	</div>
      	</div>
	</div>
</div>

<div class="modal " id="modal1" style="text-align: center; padding-top: 10px;">
  <h4 id="textCargado">Procesando...</h4>
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</div>
<div id="estado_consulta_ajax" style="height: auto;">

</div>

<a class="btn" onclick="GenerarExcel()">EXCEL</a>
<script src="js/procesos/Destajo.js" charset="utf-8"></script>
