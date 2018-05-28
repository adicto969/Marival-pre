var cantidadXpagina = 10;
var pagina = 1;
var ultimaPagina = 1;
var ordenar = 'codigo';
var busqueda = '';

$(document).ready(function() {
  AjusteEmpleados();
});

function AjusteEmpleados(){
  var conexion, resultado, variable;

  $.ajax({
    beforeSend: function() {
      resultado = '<div class="progress">';
      resultado += '<div class="indeterminate"></div>';
      resultado += '</div>';
      $('#estado_consulta_ajax').html(resultado);
    },
    method: 'POST',
    url: 'ajax.php?modo=AjusteEmpleado',
    data: 'cantidadXpagina='+cantidadXpagina+'&pagina='+pagina+'&order='+ordenar+'&buscar='+busqueda
  }).done(function(datos) {
    try {
      var jsonDatos = JSON.parse(datos);
      if(jsonDatos.error == 0){
        $('#estado_consulta_ajax').html(jsonDatos.contenido);
        $('#paginador').html(pagina + " de " + jsonDatos.paginas);
        ultimaPagina = jsonDatos.paginas;
        $('.dropdown-button').dropdown();
        var Dimensiones = AHD();

        if(Dimensiones[3] > Dimensiones[1]){
          $('#pie').css("position", "inherit");
        }else {
          $('#pie').css("position", "absolute");
        }
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

function GajusteEmple() {
  var variables;
  variables = $('#frmAjusEmp').serialize();

  $.ajax({
    beforeSend: function() {
      $('#modal1').modal('open');
    },
    method: 'POST',
    url: 'ajax.php?modo=MajusteEmple',
    data: variables
  }).done(function(datos) {
    try {
      var jsonDatos = JSON.parse(datos);
      if(jsonDatos.error == '-1'){
        $('#textCargado').html("OCURRIO UN ERROR");
        setTimeout(function() {
          $('#modal1').modal('close');
          $('#textCargado').html("Procesando..");
        }, 2500);
      }else {
        $('#textCargado').html("DATOS GUARDADOS<br>EXITO: "+jsonDatos.exito+"<br>ERROR: "+jsonDatos.error);
        setTimeout(function() {
          $('#modal1').modal('close');
          $('#textCargado').html("Procesando..");
          $('#btnAjusEmp').blur();
        }, 2500);
      }
    }catch(e){
      $('#textCargado').html("OCURRIO UN ERROR");
      console.log(e.message);
    }
  });
}

function sig() {
  if(pagina < ultimaPagina){
    pagina++;
  }
  AjusteEmpleados();
}

function ant() {
  if(pagina > 1){
    pagina--;
  }
  AjusteEmpleados();
}

function Mostrarcanti(cantidad) {
  cantidadXpagina = cantidad;
  pagina = 1;
  AjusteEmpleados();
}

function Ordernar(orden){
    ordenar = orden;
    AjusteEmpleados();
}

function busquedaF() {
    pagina = 1;
    busqueda = $('#buscarV').val();
    AjusteEmpleados();
}
