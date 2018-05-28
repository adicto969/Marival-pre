<?php
$error = "";
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
if($PC <= 24){
$fechas = periodo($PC, $TN);
list($fecha1, $fecha2, $fecha3, $fecha4) = explode(',', $fechas);
}
if($TN == 1 || $PC > 24)
{
  $_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA1',
													CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA2'
									 FROM Periodos
									 WHERE tiponom = 1
									 AND periodo = $PC-1
									 AND ayo_operacion = $ayoA
									 AND empresa = $IDEmpresa ;";

  $_resultados = $objBDSQL->consultaBD($_queryFechas);
  if($_resultados['error'] == 1)
  {
		$file = fopen("log/log".date("d-m-Y").".txt", "a");
		fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['SQLSTATE'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['CODIGO'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['MENSAJE'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$_queryFechas.PHP_EOL);
		fclose($file);
		/////////////////////////////
		$objBDSQL->cerrarBD();
		$error = '<h1>Error al consultar las Fechas</h1>';
  }
  $_datos = $objBDSQL->obtenResult();

  $fecha1 = $_datos['FECHA1'];
  $fecha2 = $_datos['FECHA2'];
	$objBDSQL->liberarC();

	$_queryFechas = "SELECT CONVERT (VARCHAR (10), inicio, 103) AS 'FECHA3',
													CONVERT (VARCHAR (10), cierre, 103) AS 'FECHA4'
									 FROM Periodos
									 WHERE tiponom = 1
									 AND periodo = $PC
									 AND ayo_operacion = $ayoA
									 AND empresa = $IDEmpresa ;";

  $_resultados = $objBDSQL->consultaBD($_queryFechas);
  if($_resultados['error'] == 1)
  {
		$file = fopen("log/log".date("d-m-Y").".txt", "a");
		fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['SQLSTATE'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['CODIGO'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$_resultados['MENSAJE'].PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$_queryFechas.PHP_EOL);
		fclose($file);
		/////////////////////////////
		$objBDSQL->cerrarBD();
		$error = '<h1>Error al consultar las Fechas</h1>';
  }
  $_datos = $objBDSQL->obtenResult();

  $fecha3 = $_datos['FECHA3'];
  $fecha4 = $_datos['FECHA4'];

  $objBDSQL->liberarC();
}


?>
<h4 style="text-align: center;"><?php echo $NomDep; ?></h4>
<h5 style="text-align: center;">PERMISOS</h5>
<div class="row">
  	<div id="DperC" class="col s12 m6 offset-m3 l4">
    	<div role="form" onkeypress="return scriptChecadas(event)">
          	<div>
	            <label for="periodo">PERIODO DE CORTE</label>
	            <input onclick="cambiarPeriodo()" onKeyUp="cambiarPeriodo()" style="width: 142px; margin-left: 19px; font-size: 1rem; height: 1.5rem;" id="periodo" type="number" min="1" name="periodo" value="<?php echo $PC; ?>">
	            <br/>
	            <br/>
	            <label for="fchI">Fecha Inicial</label>
	            <input id="fchI" type="text" value="<?php echo $fecha1; ?>" style="margin-left: 70px; width: 142px; font-size: 1rem; height: 1.5rem;" disabled>
	            <br/>
	            <label for="fchF">Fecha Final</label>
	            <input id="fchF" type="text" value="<?php echo $fecha2; ?>" style="margin-left: 77px; width: 142px; font-size: 1rem; height: 1.5rem;" disabled>
	            <br/>
	            <p>PERIODO DE PAGO</p>
	            <label for="fchP_I">Fecha Inicial</label>
	            <input id="fchP_I" type="text" value="<?php echo $fecha3; ?>" style="margin-left: 70px; width: 142px; font-size: 1rem; height: 1.5rem;" disabled>
	            <br/>
	            <label for="fchP_F">Fecha Final</label>
	            <input id="fchP_F" type="text" value="<?php echo $fecha4; ?>" style="margin-left: 77px; width: 142px; font-size: 1rem; height: 1.5rem;" disabled>
	            <br/>
	            <label for="tiponom">Tipo de nomina</label>
	            <input id="tiponom" type="number" min="1" max="6" name="tiponom" value="<?php echo $TN; ?>" style="margin-left: 50px; width: 142px; font-size: 1rem; height: 1.5rem;">
	            <br/>
	            <div class="boton col s12 center-align" style="margin-top: 50px; margin-bottom: 50px;">
	                <input class="btn" type="submit" value="BUSCAR" onclick="Permisos()" id="btnT"/>
	            </div>
	            <br/>
	            <br/>
          	</div>
      	</div>
	</div>

  <div id="Stasis" class="row col s12 m6 l4 offset-l4">
          <div id="Stasis1" class="col s12 m6">
              <table class="striped centered">
                <thead>
                  <tr>
                      <th>Codigo</th>
                      <th>Descripcion</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td>F</td>
                      <td>Falta</td>
                  </tr>
                  <tr>
                      <td>P</td>
                      <td>Permiso</td>
                  </tr>
                  <tr>
                      <td>S</td>
                      <td>Castigo</td>
                  </tr>
                  <tr>
                      <td>T</td>
                      <td>P. Tecnico</td>
                  </tr>
                </tbody>
              </table>
          </div>
          <!--/*id="Ncodigos"*/-->
          <div id="Stasis2" class="col s12 m6" >
              <form id="frm1" method="POST">
                  <table id="Tcodigos" class="striped centered">

                  </table>
                  <button id="NcodigosB" name="opcion" value="nuevo" class="waves-effect waves-light btn">Guardar</button>
              </form>
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
  <?php
  if(empty($error)) {
      echo $error;
  }
  ?>
</div>

<?php if(empty($error)) {?>
<script src="js/procesos/Permiso.js" charset="utf-8"></script>
<?php } ?>
