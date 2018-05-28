$(document).ready(function() {
  verContratos();
});

function verContratos(){
  var Dimensiones = AHD();
  var conexion, resultado, variable, ancho;
  ancho = Dimensiones[0];
  variable = "valor="+ancho;

  $.ajax({
    beforeSend: function() {
      resultado = '<div class="progress">';
      resultado += '<div class="indeterminate"></div>';
      resultado += '</div>';
      $('#estado_consulta_ajax').html(resultado);
    },
    method: 'POST',
    url: 'ajax.php?modo=contratosVence',
    data: variable
  }).done(function(datos) {
    try {
      var jsonDatos = JSON.parse(datos);
      if(jsonDatos.error == '1'){
        $('#estado_consulta_ajax').html("<div style='width: 100%' class='deep-orange accent-4'><h6 class='center-align' style='padding-top: 5px; padding-bottom: 5px; color: white;'>Ocurrio un error !</h6></div>");
      }else {
        $('#estado_consulta_ajax').html(jsonDatos.contenido);
        var Dimensiones = AHD();
        console.log(Dimensiones[2]);
        if(Dimensiones[3] > Dimensiones[1]){
          $('#pie').css("position", "inherit");
        }else {
          $('#pie').css("position", "absolute");
        }
      }
    }catch(e) {
      $('#estado_consulta_ajax').html("<div style='width: 100%' class='deep-orange accent-4'><h6 class='center-align' style='padding-top: 5px; padding-bottom: 5px; color: white;'>Ocurrio un error !</h6></div>");
      console.log(e.message);
    }
  });
}
