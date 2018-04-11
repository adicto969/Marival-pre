<?php
/*$fecha2 = '06/03/2017';
$divFF = explode('/', $fecha2);
$FFMK = mktime(0,0,0,$divFF[1],$divFF[0],$divFF[2]);
echo date("d/m/Y", $FFMK);

echo "<br>";
$fgh = strtotime('+'.rand(0, 15).' day', $FFMK);

echo date("d/m/Y", $fgh);*/

?>

<h3 class="center">SELECCIONE EL ARCHIVO DE TEXTO</h3>

<form class="row" id="frmarchivo" method="POST" enctype="multipart/form-data">
  <div class="file-field input-field col s12 m6 offset-m3">
    <div class="btn">
      <span>Archivo</span>
      <input type="file" id="archivotxt" name="Archivo[]">
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text">
    </div>
  </div>
  <div class="col s12 m6 offset-m3">
    <div style="margin: auto;width: 195px;">
      <button  class="btn center" onclick="checadastxt()" style="margin-top: 20px;">Cargar Checadas</button>
    </div>
  </div>

</form>


<div class="modal " id="modal1" style="text-align: center; padding-top: 10px;">
  <h4 id="textCargado">Procesando...</h4>
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</div>
<div id="estado_consulta_ajax" style="height: auto;">

</div>
<script src="js/procesos/checadastxt.js" charset="utf-8"></script>
