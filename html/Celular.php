<h4 style="text-align: center;"><?php echo $NomDep; ?></h4>
<h5 style="text-align: center;">CELULAR</h5>

<div class="row">
  	<div class="col s12 m6 offset-m3 l4">
    	<div role="form" onkeypress="return scriptChecadas(event)">
          	<div>
	            <label for="fcH">Fecha</label>
	            <input id="fcH" type="text" value="<?php echo date("d/m/Y"); ?>" style="margin-left: 76px; width: 142px; font-size: 1rem; height: 1.5rem;">
	            <br/>
	            <label for="tiponom">Horario</label>
	            <input id="Hrs" type="number" min="1" name="Hrs" value="1" style="margin-left: 68px; width: 142px; font-size: 1rem; height: 1.5rem;">
	            <br/>
                <label for="Dep">Departamento</label>
                <input id="Dep" type="text" name="Dep" value="<?php echo $centro; ?>" style="margin-left: 24px; width: 142px; font-size: 1rem; height: 1.5rem;">
                <br/>
	            <div class="boton col s12 center-align" style="margin-top: 20px; margin-bottom: 50px;">
	                <input class="btn" type="submit" value="BUSCAR" onclick="Celular()" id="btnT"/>
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
<script src="js/procesos/Celular.js" charset="utf-8"></script>
