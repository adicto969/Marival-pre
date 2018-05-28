$(document).ready(function() {
  Extra();
});

function cambiarPeriodo(){
  var conexion, variables, responder, resultado, Periodo, tn;
  Periodo = document.getElementById('periodo').value;
  tn = document.getElementById('tiponom').value;
  if(Periodo != ''){
      variables = 'periodo='+Periodo+'&TN='+tn;
      conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      conexion.onreadystatechange = function() {
        if(conexion.readyState == 4 && conexion.status == 200){
          if(conexion.responseText == 'Error'){
            document.getElementById('estado_consulta_ajax').innerHTML = '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No hay fecha de este periodo !</h6></div>';

          } else {

            var fechaJSON = JSON.parse(conexion.responseText);

            document.getElementById('fchI').value = fechaJSON.fecha1;
            document.getElementById('fchF').value = fechaJSON.fecha2;
            document.getElementById('fchP_I').value = fechaJSON.fecha3;
            document.getElementById('fchP_F').value = fechaJSON.fecha4;
            document.getElementById('btnT').disabled  = false;
          }
        }else if(conexion.readyState != 4){
          document.getElementById('btnT').disabled  = true;
        }
      }
      conexion.open('POST', 'ajax.php?modo=periodo', true);
      conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      conexion.send(variables);
    }else {
      document.getElementById('estado_consulta_ajax').innerHTML = '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Todos los datos deben estar llenos !</h6></div>';
    }
}

function Extra() {
  cambiarPeriodo();
  var conexion, variables, responder, resultado, Periodo, fecha1, fecha2, tipoNom;
  fecha1 = document.getElementById('fchI').value;
  fecha2 = document.getElementById('fchF').value;
  Periodo = document.getElementById('periodo').value;
  tipoNom = document.getElementById('tiponom').value;
  if(fecha1 != '' && fecha2 != '' && Periodo != '' && tipoNom != ''){
      variables = 'periodo='+Periodo+'&fecha1='+fecha1+'&fecha2='+fecha2+'&tipoNom='+tipoNom;
      conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      conexion.onreadystatechange = function() {
        if(conexion.readyState == 4 && conexion.status == 200){
          if(conexion.responseText == 1){

          } else {
            if(conexion.responseText == '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>'){
              document.getElementById('pie').style.position = 'absolute';
            }else {
              document.getElementById('pie').style.position = 'inherit';
            }
            document.getElementById('estado_consulta_ajax').innerHTML = conexion.responseText;

            var Dimensiones = AHD();
            console.log(Dimensiones[0]);
            console.log(Dimensiones[0]+' '+Dimensiones[1]+' '+Dimensiones[2]+' '+Dimensiones[3]);

            if(Dimensiones[3] > Dimensiones[1]){
              $('#pie').css("position", "inherit");
            }else {
              $('#pie').css("position", "absolute");
            }
          }
        }else if(conexion.readyState != 4){
          resultado = '<div class="progress">';
          resultado += '<div class="indeterminate"></div>';
          resultado += '</div>';
          document.getElementById('estado_consulta_ajax').innerHTML = resultado;
        }
      }
      conexion.open('POST', 'ajax.php?modo=TExtra', true);
      conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      conexion.send(variables);
    }else {
      document.getElementById('estado_consulta_ajax').innerHTML = '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Todos los datos deben estar llenos !</h6></div>';
    }
}


function GTiempoExtra() {
  var conexion, variables, responder, resultado, Periodo, fecha1, fecha2, tipoNom;
  fecha1 = document.getElementById('fchI').value;
  fecha2 = document.getElementById('fchF').value;
  Periodo = document.getElementById('periodo').value;
  tipoNom = document.getElementById('tiponom').value;
  if(fecha1 != '' && fecha2 != '' && Periodo != '' && tipoNom != ''){
      variables = $('#frmTextra').serialize();
      variables += 'periodo='+Periodo+'&fecha1='+fecha1+'&fecha2='+fecha2+'&tipoNom='+tipoNom;
      conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      conexion.onreadystatechange = function() {
        if(conexion.readyState == 4 && conexion.status == 200){
          if(conexion.responseText == true){
            document.getElementById('textCargado').innerHTML = "ARCHIVOS GENERADOS CORRECTAMENTE";

            setTimeout(function(){
              $('#modal1').modal('close');
              document.getElementById('textCargado').innerHTML = "Procesando...";
              $('#btnGenerar').blur();
              //location.reload();
            }, 1500);
          } else {
            document.getElementById('textCargado').innerHTML = conexion.responseText;

            /*setTimeout(function(){
              $('#modal1').modal('close');
              //location.reload();
            }, 2000);*/
          }
        }else if(conexion.readyState != 4){
          document.getElementById('textCargado').innerHTML = "Procesando...";
          $('#modal1').modal('open');
        }
      }
      conexion.open('POST', 'ajax.php?modo=GtpoExtra', true);
      conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      conexion.send(variables);
    }else {
      document.getElementById('estado_consulta_ajax').innerHTML = '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Todos los datos deben estar llenos !</h6></div>';
    }
}

function AgFrente(event, valor, fecha, cantidad, codigo){
  var string = $("#"+event.target.id).val();
  var periodo = $("#periodo").val();
  var Tn = $("#tiponom").val();
  console.log(string);
  $.ajax({
    method: 'POST',
    url: 'ajax.php?modo=GuardarTE',
    data: "Frente=1&codigo="+codigo+"&fecha="+fecha+"&Pe="+periodo+"&Tn="+Tn+"&valor="+string
  }).done(function(datos){
    console.log(datos);
  });

}

function SumarTiempos(event, valor, fecha, cantidad, codigo){
  var cantidadS = 0;
  var totalSuma = 0;
  var string = "";
  var periodo = $("#periodo").val();
  var Tn = $("#tiponom").val();

  for(var s = 1; s <= cantidad; s++){
    if(isNaN(parseInt($("#"+codigo+''+s).val()))){

    }else {
      totalSuma += parseFloat($("#"+codigo+''+s).val());
    }
  }

  $("#totalSuma"+codigo).html(totalSuma.toString());
  string = $("#"+event.target.id).val();
  string = string.replace(/[qwertyuioplkjhgfdsazxcvbnm]/gi, "");
  $("#"+event.target.id).val(string);

  $.ajax({
    method: 'POST',
    url: 'ajax.php?modo=GuardarTE',
    data: "codigo="+codigo+"&fecha="+fecha+"&Pe="+periodo+"&Tn="+Tn+"&valor="+parseFloat($("#"+event.target.id).val())
  }).done(function(datos){
    console.log(datos);
  });
}


function GenerarExcel(){
  var fecha1 = document.getElementById('fchI').value;
  var fecha2 = document.getElementById('fchF').value;
  $.ajax({
    method: 'POST',
    url: 'ajax.php?modo=GenerarExcel',
    data: "tipo=tiempoextra&"+"fecha1="+fecha1+"&fecha2="+fecha2,
    beforeSend: function(){
      $('#textCargado').html("Procesando...");
      $('#modal1').modal('open');
    }
  }).done(function(datosC){
    console.log(datosC);
    if(datosC == '\ufeff1'){
        $('#textCargado').html("ARCHIVO GENERADO");
    }else{
        $('#textCargado').html("ERROR AL GENERAR EL ARCHIVO");
    }
  }).fail(function(retorno){
    $('#textCargado').html(retorno);
  }).always(function(){
    setTimeout(function(){
      $('#textCargado').html("Procesando...");
      $('#modal1').modal('close');
    }, 1500);
  });
}
