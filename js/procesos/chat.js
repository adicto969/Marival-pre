$(document).ready(function () {
  usuarios();
});


function usuarios() {
  var conexion, variable;
  variable = "valor=Z";
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function() {
    if(conexion.readyState == 4 && conexion.status == 200){
      document.getElementById('contactos').innerHTML = conexion.responseText;
      var Dimensiones = AHD();

      if(Dimensiones[3] > Dimensiones[1]){
        $('#pie').css("position", "inherit");
      }else {
        $('#pie').css("position", "absolute");
      }
    }else if(conexion.readyState != 4){
      resultado = '<div class="progress">';
      resultado += '<div class="indeterminate"></div>';
      resultado += '</div>';
      document.getElementById('contactos').innerHTML = resultado;
    }
  }
  conexion.open('POST', 'ajax.php?modo=verContactos', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variable);
}

function chatear(){
  var conexion, variable;
  variable = "Mensaje="+$('#msgChat').val();
  variable += "&IDdestino="+$('#destinoUser').val();
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function() {
    if(conexion.readyState == 4 && conexion.status == 200){
      Mensajes();
    }else if(conexion.readyState != 4){

    }
  }
  conexion.open('POST', 'ajax.php?modo=chatear', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variable);
  $('#msgChat').val('');
  $('#msgChat').focus();
}


function userID(ID, Nombre) {
  $('#destinoUser').val(ID);
  $('#cabeceraChat').html(Nombre);
}

function Mensajes() {
  var conexion, variable, contar;
  variable = "UserChat="+$('#destinoUser').val();
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function() {
    if(conexion.readyState == 4 && conexion.status == 200){
      $('#cuerpoChat').html(conexion.responseText);
    }else if(conexion.readyState != 4){

    }
  }
  conexion.open('POST', 'ajax.php?modo=Mensajes', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variable);
}

$('#cuerpoChat').scroll(function(){
  console.log('scrollTop '+$('#cuerpoChat').scrollTop());
  //console.log($('#cuerpoChat').height());
  //console.log($('#cuerpoChat').innerHeight());
  console.log('scrollHeight '+document.getElementById('cuerpoChat').scrollHeight);

  //para obtener el alto del scroll se resta el scrollHeight - el alto del div(350)
});

setInterval(function () {
  Mensajes();
}, 1000);

setInterval(function () {
  if($('#cuerpoChat').scrollTop() > (document.getElementById('cuerpoChat').scrollHeight-450)){
    $("#cuerpoChat").animate({ scrollTop: $('#cuerpoChat')[0].scrollHeight}, 1000);
  }
}, 2000);
