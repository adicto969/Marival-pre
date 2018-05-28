var cantidadXpagina = 10;
var pagina = 1;
var ultimaPagina = 1;
var ordenar = 'codigo';
var busqueda = '';

$( function() {
    $( ".controlgroup" ).controlgroup()
    $( ".controlgroup-vertical" ).controlgroup({
      "direction": "vertical"
    });
} );


$(document).ready(function(){

  $("form").keypress(function(e){
    if(e.which == 13){
      return false;
    }
  });

  $('#pie').css("position", "inherit");
  verRol();
});

// # verificar en tiempo real cada 1seg.
/*
function notiReal(){
  var noti = $.ajax({
    url : 'notificaciones.php',
    dataType : 'text',
    async : false
  }).responseText;

  document.getElementById('noti').innerHTML = noti;
}

setInterval(notiReal, 1000);
*/

function Rol(){
  var conexion, variables, Dia, Dia2, Mes, Ayo;
  Dia = $('#Dia').val();
  Dia2 = $('#Dia2').val();
  Mes = $('#Mes').val();
  Ayo = $('#Ayo').val();

  if(Dia != "" && Dia2 != "" && Mes != "" && Ayo != ""){
    variables = $("#frmRol").serialize();
    variables += "&Dia="+Dia+"&Dia2="+Dia2+"&Mes="+Mes+"&Ayo="+Ayo;
    $.ajax({
      beforeSend: function() {
        $('#textCargado').html("Procesando...");
        $("#modal1").modal('open');
      },
      method: 'POST',
      url: 'ajax.php?modo=ActRol',
      data: variables
    }).done(function(datos) {
      try{
        var jsonDatos = JSON.parse(datos);
        resultado = '<h4>ROL ACTUALIZADOS</h4>';
        resultado += '<h5>Correctos: '+jsonDatos.exito+'</h5>';
        resultado += '<h5>Errores: '+jsonDatos.error+'</h5>';
        $('#textCargado').html(resultado);

        setTimeout(function(){
          $("#modal1").modal('close');
          $('#textCargado').html("Procesando...");
        }, 2500);
      }catch(e){
        resultado = '<div class="center">';
        resultado += '<h4>OCURRIO UN ERROR INTENTELO MAS TARDE</h4>';
        resultado += '</div>';
        $('#estado_consulta_ajax').html(resultado);
        console.log(e);
      }
    });

  }else {
    if(Dia == ""){
      $('#Dia').focus();
    }else if(Dia2 == ""){
      $('#Dia2').focus();
    }else if(Mes == ""){
      $('#Mes').focus();
    }else {
      $('#Ayo').focus();
    }
  }
}

function verRol() {
    $.ajax({
      beforeSend: function() {
        resultado = '<div class="progress">';
        resultado += '<div class="indeterminate"></div>';
        resultado += '</div>';
        $('#estado_consulta_ajax').html(resultado);
      },
      method: 'POST',
      url: 'ajax.php?modo=RolHorario',
      data: 'cantidadXpagina='+cantidadXpagina+'&pagina='+pagina+'&order='+ordenar+'&buscar='+busqueda
    }).done(function(datos) {
      try {
        var jsonDatos = JSON.parse(datos);
        if(jsonDatos.error == 0){
          $('#estado_consulta_ajax').html(jsonDatos.contenido);

          $(jsonDatos.query).insertAfter('#estado_consulta_ajax');

          $('.dropdown-button').dropdown();
          var Dimensiones = AHD();

          if(Dimensiones[3] > Dimensiones[1]){
            $('#pie').css("position", "inherit");
          }else {
            $('#pie').css("position", "absolute");
          }

          $( ".controlgroup" ).controlgroup()

          $( ".controlgroup-vertical" ).controlgroup({
            "direction": "vertical"
          });

          $('#paginador').html(pagina + " de " + jsonDatos.paginas);
          ultimaPagina = jsonDatos.paginas;
        }else {
          resultado = '<div class="center">';
          resultado += '<h4>OCURRIO UN ERROR INTENTELO MAS TARDE</h4>';
          resultado += '</div>';
          $('#estado_consulta_ajax').html(resultado);
        }
      }catch(e){
        resultado = '<div class="center">';
        resultado += '<h4>OCURRIO UN ERROR INTENTELO MAS TARDE</h4>';
        resultado += '</div>';
        $('#estado_consulta_ajax').html(resultado);
        console.log(e.message);
      }
    });
}

function sig() {
  if(pagina < ultimaPagina){
    pagina++;
  }
  verRol();
}

function ant() {
  if(pagina > 1){
    pagina--;
  }
  verRol();
}

function Mostrarcanti(cantidad) {
  cantidadXpagina = cantidad;
  pagina = 1;
  verRol();
}

function Ordernar(orden){
    ordenar = orden;
    verRol();
}

function busquedaF() {
    pagina = 1;
    busqueda = $('#buscarV').val();
    verRol();
}
