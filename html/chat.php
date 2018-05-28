<div class="modal " id="modal1" style="text-align: center; padding-top: 10px;">
  <h4 id="textCargado">Procesando...</h4>
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</div>

<div class="row" style="margin: 2% 2% 28% 2%;">
  <div class="center col s12 m4 offset-m4 l4 offset-l4 z-depth-5" style="padding: 0; margin-bottom: 30px;">
    <div class="col s12 teal accent-3">
      <p id="cabeceraChat">CHAT</p>
    </div>
    <div class="col s12" id="cuerpoChat" style="overflow-y: auto; height: 350px; max-height: 350px;">
      
    </div>
    <div class="col s12" style="padding: 0">
      <div class="row" style="margin: 0">
        <div class="input-field col s12" style="padding: 0; margin: 0;">
          <input class="grey lighten-2 col s9" type="text" id="msgChat" style="margin: 0;">
          <label for="msgChat" >Mensaje</label>
          <button type="button" class="btn waves-effect col s3" onclick="chatear()" style="box-shadow: 0; border-radius: 0; ">Enviar
            <i class="material-icons right">send</i>
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="col s12 m2 offset-m1 l2 offset-l1" style="padding: 0">
    <div class="col s12" style="padding: 0" id="contactos">

    </div>
  </div>
</div>
<input type="hidden" id="destinoUser" value="">
<script src="js/procesos/chat.js" charset="utf-8"></script>
