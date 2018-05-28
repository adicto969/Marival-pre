<h4 style="text-align: center;"><?php echo $NomDep; ?></h4>
<h5 style="text-align: center;" id="Lab" onclick="labels(event)">AJUSTE EMPLEADOS</h5>

<div class="modal " id="modal1" style="text-align: center; padding-top: 10px;">
  <h4 id="textCargado">Procesando...</h4>
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</div>
<div id="estado_consulta_ajax" style="height: auto;">

</div>
<script src="js/procesos/AjusteEmpleado.js" charset="utf-8"></script>
