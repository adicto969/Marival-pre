function GTasistencia(){
    var conexion, variables;

    variables = $("#frmTasis").serialize();

    conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    conexion.onreadystatechange = function() {
      if(conexion.readyState == 4 && conexion.status == 200){
          try {
              var jsonDatos = JSON.parse(conexion.responseText);
              if(jsonDatos.error == 0){
                if(jsonDatos.excel == 1){
                  $('#textCargado').html(jsonDatos.archivo);
                }else {
                    $('#textCargado').html("ARCHIVO GENERADO");
                    setTimeout(function(){
                      $('#modal1').modal('close');
                      document.getElementById('textCargado').innerHTML = "Procesando...";
                      $('#btnGenerar').blur();
                      //location.reload();
                    }, 1500);
                }
              }else {
                  $('#textCargado').html("ERROR AL GENERAR EL ARCHIVO");
              }
          } catch (e) {
            console.log(e);
            $('#textCargado').html("ERROR AL GENERAR EL ARCHIVO");
          }

      }else if(conexion.readyState != 4){
        document.getElementById('textCargado').innerHTML = "Procesando...";
        $('#modal1').modal('open');
      }
    }
    conexion.open('POST', 'ajax.php?modo=GTasistencia', true);
    conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    conexion.send(variables);

}

function ActualizarT() {
  var conexion, variables;
  //$("#frmTasis").on("submit", function(e){
    //e.preventDefault();
    variables = $("#frmTasis").serialize();
    conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    conexion.onreadystatechange = function() {
      if(conexion.readyState == 4 && conexion.status == 200){
        if(conexion.responseText == 1){
          document.getElementById('textCargado').innerHTML = "DATOS ACTUALIZADOS";
          setTimeout(function(){
            $("#modal1").modal('close');
            document.getElementById('textCargado').innerHTML = "Procesando...";
          }, 1500);
        }else {
          document.getElementById('textCargado').innerHTML = conexion.responseText;
          setTimeout(function(){
            $("#modal1").modal('close');
          }, 2000);

        }
      }else if(conexion.readyState != 4){
        document.getElementById('textCargado').innerHTML = "Procesando...";
        $("#modal1").modal('open');
      }
    }
    conexion.open('POST', 'ajax.php?modo=Tguardar', true);
    conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    conexion.send(variables);
  //});
}

function CP(){
  var conexion, variable;
  if($("#pp").val() != ""){
    if($("#pa").val() != ""){

      document.getElementById("hPP").value = document.getElementById("pp").value;
      document.getElementById("hPA").value = document.getElementById("pa").value;

      variable = "PP="+$("#pp").val()+"&PA="+$("#pa").val();
      conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      conexion.onreadystatechange = function(){
        if(conexion.readyState == 4 && conexion.status == 200){
          if(conexion.responseText != 1){
            console.log(conexion.responseText);
          }
        }
      }
      conexion.open('POST', 'ajax.php?modo=CP', true);
      conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      conexion.send(variable);
    }else {
        $("#pa").focus();
    }
  }else {
    $("#pp").focus();
  }
}

function GuardarT(){
  var conexion, variables;
  variables = $("#frmTasis").serialize();
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function() {
    if(conexion.readyState == 4 && conexion.status == 200){
      if(conexion.responseText == 1){
        document.getElementById('textCargado').innerHTML = "DATOS GUARDADOS";
        setTimeout(function(){
          $("#modal1").modal('close');
          document.getElementById('textCargado').innerHTML = "Procesando...";
          $("#btnTGuardar").attr("onclick","ActualizarT()");
          $("#btnTGuardar").html("CORREGIR");
          $('#btnTGuardar').blur();
        }, 1500);
      }else {
        document.getElementById('textCargado').innerHTML = conexion.responseText;
        setTimeout(function(){
          $("#modal1").modal('close');
        }, 2000);

      }
    }else if(conexion.readyState != 4){
      document.getElementById('textCargado').innerHTML = "Procesando...";
      $("#modal1").modal('open');
    }
  }
  conexion.open('POST', 'ajax.php?modo=Tguardar', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variables);

}

function CerrarT(estado){
  var conexion, variables;
  variables = "periodo="+$("#periodo").val()+"&centro="+$("#centro").val()+"&estado="+estado+"&tiponom="+$("#tiponom").val();
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function() {
    if(conexion.readyState == 4 && conexion.status == 200){
      if(conexion.responseText == 3){
        console.log(conexion.responseText);
        if(estado == 1){
          document.getElementById('textCargado').innerHTML = "PERIODO CERRADO";
        }else {
          document.getElementById('textCargado').innerHTML = "PERIODO HABILITADO";
        }
        setTimeout(function(){
          $("#modal1").modal('close');
          document.getElementById('textCargado').innerHTML = "Procesando...";
          Checadas();
        }, 1500);
      }else {
        console.log(conexion.responseText);
        document.getElementById('textCargado').innerHTML = conexion.responseText;
        /*setTimeout(function(){
          $("#modal1").modal('close');
          Checadas();
        }, 2000);*/

      }
    }else if(conexion.readyState != 4){
      document.getElementById('textCargado').innerHTML = "Procesando...";
      $("#modal1").modal('open');
    }
  }
  conexion.open('POST', 'ajax.php?modo=Tcerrar', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variables);
}


function GFaltas(fecha = '0'){

  if(fecha == '0'){
    var conexion, variables;
    var fecha1 = $('#fchI').val();
    var fecha2 = $('#fchF').val();
    variables = "f1="+fecha1+"&f2="+fecha2;

    conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    conexion.onreadystatechange = function() {
      if(conexion.readyState == 4 && conexion.status == 200){
        if(conexion.responseText == true){
          document.getElementById('textCargado').innerHTML = "ARCHIVOS GENERADOS CORRECTAMENTE";

          setTimeout(function(){
            $('#modal1').modal('close');
            document.getElementById('textCargado').innerHTML = "Procesando...";
            $('#btnGenerar').blur();
          }, 1500);

        } else if(conexion.responseText == false){
          document.getElementById('textCargado').innerHTML = "No se encontraron Faltas";
        }else {
          document.getElementById('textCargado').innerHTML = conexion.responseText;
        }
      }else if(conexion.readyState != 4){
        document.getElementById('textCargado').innerHTML = "Procesando...";
        $('#modal1').modal('open');
      }
    }
    conexion.open('POST', 'ajax.php?modo=Gfaltas', true);
    conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    conexion.send(variables);
  }else {

    var conexion, variables;

    variables = "uno=1&fecha="+fecha;

    conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    conexion.onreadystatechange = function() {
      if(conexion.readyState == 4 && conexion.status == 200){
        if(conexion.responseText == true){
          document.getElementById('textCargado').innerHTML = "ARCHIVOS GENERADOS CORRECTAMENTE";

          setTimeout(function(){
            $('#modal1').modal('close');
            document.getElementById('textCargado').innerHTML = "Procesando...";
            $('#btnGenerar').blur();
          }, 1500);

        } else if(conexion.responseText == false){
          document.getElementById('textCargado').innerHTML = "No se encontraron Faltas";
        }else {
          document.getElementById('textCargado').innerHTML = conexion.responseText;
        }
      }else if(conexion.readyState != 4){
        document.getElementById('textCargado').innerHTML = "Procesando...";
        $('#modal1').modal('open');
      }
    }
    conexion.open('POST', 'ajax.php?modo=Gfaltas', true);
    conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    conexion.send(variables);
  }


}
