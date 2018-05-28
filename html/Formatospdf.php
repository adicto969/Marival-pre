<h4 style="text-align: center;"><?php echo $NomDep; ?></h4>
<h5 style="text-align: center;">FROMATOS</h5>
<div class="center" style="margin: 30px 0 30px 0;">
    <button  name="button" onclick="VGformatos()" class="btn Formatos">VENCIMIENTO</button>
    <button  name="button" onclick="SGformatos()" class="btn Formatos">SALIDA</button>
    <button  name="button" onclick="LGformatos()" class="btn Formatos">LIBERACION</button>
</div>

<div class="modal " id="modal1" style="text-align: center; padding-top: 10px;">
  <h4 id="textCargado">Procesando...</h4>
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</div>
<div id="estado_consulta_ajax" style="height: auto;">

</div>
<script src="js/procesos/Fotmatospdf.js" charset="utf-8"></script>
