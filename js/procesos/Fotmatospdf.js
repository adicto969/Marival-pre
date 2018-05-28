$(document).ready(function(){
  verFormatos();
});

var cantidadCH = 0;
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var codigos = [];


function verFormatos(){
  var conexion, resultado, variable;
  variable = "valor=X"
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function() {
    if(conexion.readyState == 4 && conexion.status == 200){
      document.getElementById('estado_consulta_ajax').innerHTML = conexion.responseText;

      var Dimensiones = AHD();
      console.log(Dimensiones[3]+' + '+Dimensiones[1]);
      if(Dimensiones[3] > Dimensiones[1]){
        $('#pie').css("position", "inherit");
      }else {
        $('#pie').css("position", "absolute");
      }


    }else if(conexion.readyState != 4){
      resultado = '<div class="progress">';
      resultado += '<div class="indeterminate"></div>';
      resultado += '</div>';
      document.getElementById('estado_consulta_ajax').innerHTML = resultado;
    }
  }
  conexion.open('POST', 'ajax.php?modo=verFormatos', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variable);
}

function masChe(codigo) {
  cantidadCH++;
  codigos.push(codigo);
  console.log(cantidadCH);
  console.log(codigos);
}

function menChe(codigo) {
  cantidadCH--;
  var index = codigos.indexOf(codigo);
  if(index > -1){
    codigos.splice(index, 1);
  }
  console.log(cantidadCH);
  console.log(codigos);
}

function VGformatos(){
  $('#Ndiv').remove();
  var conexion, variables, fH;
  fH=new Date();
  if(cantidadCH > 0){

    variables = "modo=V&cantidadEmp="+cantidadCH+"&codigos[]="+codigos;
    conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    conexion.onreadystatechange = function() {
      if(conexion.readyState == 4 && conexion.status == 200){
        if(conexion.responseText == 1){
          document.getElementById('textCargado').innerHTML = "ARCHIVOS GENERADOS";
          setTimeout(function(){
            document.getElementById('textCargado').innerHTML = "Procesando...";
            $('#modal1').modal('close');
          }, 1500);
        }else {
          document.getElementById('textCargado').innerHTML = conexion.responseText;
          setTimeout(function(){
          document.getElementById('textCargado').innerHTML = "Procesando...";
          $('#modal1').modal('close');
          }, 2000);

        }
      }else if(conexion.readyState != 4){
        document.getElementById('textCargado').innerHTML = "Procesando...";
        $('#modal1').modal('open');
      }
    }
    conexion.open('POST', 'ajax.php?modo=ImpFotmatos', true);
    conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    conexion.send(variables);

  }else {
    var $toastContent = $('<span>Tienes que seleccionar por lo menos a un trabajador!</span>');
    Materialize.toast($toastContent, 3000);
  }
}

function SGformatos(){
  $('#Ndiv').remove();
  var fechaS, jefe, fH, conexion, variables;

  fH=new Date();

  if(cantidadCH > 0){
    fechaS = prompt("Ingrese Fecha de Salida", fH.getDate() + " de " + meses[fH.getMonth()] + " del " + fH.getFullYear());
    if(fechaS == undefined){

    }else {
      if(fechaS == ""){
        fechaS = prompt("Ingrese Fecha de Salida");
      }else {
          jefe = prompt("Nombre del Jefe Inmediato");
          if(jefe == undefined){

          }else {
            if(jefe == ""){
              jefe = prompt("Nombre del Jefe Inmediato");
            }else {

              variables = "modo=S&cantidadEmp="+cantidadCH+"&codigos[]="+codigos+"&jefe="+jefe+"&FS="+fechaS;
              conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
              conexion.onreadystatechange = function() {
                if(conexion.readyState == 4 && conexion.status == 200){
                  if(conexion.responseText == 1){
                    document.getElementById('textCargado').innerHTML = "ARCHIVOS GENERADOS";
                    setTimeout(function(){
                      document.getElementById('textCargado').innerHTML = "Procesando...";
                      $('#modal1').modal('close');
                    }, 1500);
                  }else {
                    document.getElementById('textCargado').innerHTML = conexion.responseText;
                    setTimeout(function(){
                      document.getElementById('textCargado').innerHTML = "Procesando...";
                      $('#modal1').modal('close');
                    }, 2000);

                  }
                }else if(conexion.readyState != 4){
                  document.getElementById('textCargado').innerHTML = "Procesando...";
                  $('#modal1').modal('open');
                }
              }
              conexion.open('POST', 'ajax.php?modo=ImpFotmatos', true);
              conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
              conexion.send(variables);
            }
          }

      }
    }

  }else {
    var $toastContent = $('<span>Tienes que seleccionar por lo menos a un trabajador!</span>');
    Materialize.toast($toastContent, 3000);
  }

}

function LGformatos(){
  $('#Ndiv').remove();
  var conexion, variables, fH, fechaBaja;
  fH = new Date();

  if(cantidadCH > 0){
    fechaBaja = prompt("Ingrese Fecha de Baja", fH.getDate() + " de " + meses[fH.getMonth()] + " del " + fH.getFullYear());
    if(fechaBaja == undefined){

    }else {
      if(fechaBaja == ""){
        fechaBaja = prompt("Ingrese Fecha de Baja", fH.getDate() + " de " + meses[fH.getMonth()] + " del " + fH.getFullYear());
      }else {
        variables = "modo=L&cantidadEmp="+cantidadCH+"&codigos[]="+codigos+"&fechaBaja="+fechaBaja;
        conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        conexion.onreadystatechange = function() {
          if(conexion.readyState == 4 && conexion.status == 200){
            if(conexion.responseText == 1){
              document.getElementById('textCargado').innerHTML = "ARCHIVOS GENERADOS";
              setTimeout(function(){
                document.getElementById('textCargado').innerHTML = "Procesando...";
                $('#modal1').modal('close');
              }, 1500);
            }else {
              document.getElementById('textCargado').innerHTML = conexion.responseText;
              setTimeout(function(){
                document.getElementById('textCargado').innerHTML = "Procesando...";
                $('#modal1').modal('close');
              }, 2000);

            }
          }else if(conexion.readyState != 4){
            document.getElementById('textCargado').innerHTML = "Procesando...";
            $('#modal1').modal('open');
          }
        }
        conexion.open('POST', 'ajax.php?modo=ImpFotmatos', true);
        conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        conexion.send(variables);

      }
    }

  }else {
    var $toastContent = $('<span>Tienes que seleccionar por lo menos a un trabajador!</span>');
    Materialize.toast($toastContent, 3000);
  }

}

function salida(codigo) {
  $('#Ndiv').remove();
    var fH, FechaS, JefeIM, conexion, variables, Ndiv;
    fH = new Date();

    FechaS = prompt("Ingrese Fecha de salida", fH.getDate() + " de " + meses[fH.getMonth()] + " del " + fH.getFullYear());
    JefeIM = prompt("Nombre del Jefe Inmediato");
    if(FechaS == undefined){

    }else {
      if(JefeIM == undefined){

      }else{
        if (FechaS != "" && JefeIM != "") {

          variables = "cantidadEmp=0&codigos=0&modo=salida&codigo="+codigo+"&FS="+FechaS+"&jefe="+JefeIM;
          conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
          conexion.onreadystatechange = function(){
            if(conexion.readyState == 4 && conexion.status == 200){
              Ndiv = document.createElement("embed");
              $('#Ndiv').remove();
              Ndiv.id="Ndiv";
              Ndiv.width="100%";
              Ndiv.height="500px";
              Ndiv.scrolling="no";
              Ndiv.frameborder="0px";
              //Ndiv.data="Temp/temp.pdf"
              Ndiv.src="Temp/temp.pdf";
              Ndiv.type="application/pdf";
              document.getElementById('modal1').appendChild(Ndiv);
              console.log(conexion.responseText);
              document.getElementById('textCargado').innerHTML = "";
            }else if(conexion.readyState != 4){
              document.getElementById('textCargado').innerHTML = "Procesando...";
              $('#modal1').modal('open');
            }
          }
          conexion.open('POST', 'ajax.php?modo=ImpFotmatos', true);
          conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          conexion.send(variables);
        }else {

        }
      }

    }

}

function liberacion(codigo) {
  $('#Ndiv').remove();
    var FechaB, fH, conexion, variables, Ndiv;
    fH = new Date();
    FechaB = prompt("Ingrese Fecha de Baja", fH.getDate() + " de " + meses[fH.getMonth()] + " del " + fH.getFullYear());
    if(FechaB == undefined){

    }else {
      if (FechaB != "") {
        variables = "cantidadEmp=0&codigos=0&modo=liberacion&codigo="+codigo+"&FechaB="+FechaB;
        conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        conexion.onreadystatechange = function () {
          if(conexion.readyState == 4 && conexion.status == 200){
            Ndiv = document.createElement("embed");
            $('#Ndiv').remove();
            Ndiv.id="Ndiv";
            Ndiv.width="100%";
            Ndiv.height="500px";
            Ndiv.scrolling="no";
            Ndiv.frameborder="0px";
            //Ndiv.data="Temp/temp.pdf"
            Ndiv.src="Temp/temp.pdf";
            Ndiv.type="application/pdf";
            document.getElementById('modal1').appendChild(Ndiv);
            document.getElementById('textCargado').innerHTML = "";
          }else if(conexion.readyState != 4){
            document.getElementById('textCargado').innerHTML = "Procesando...";
            $('#modal1').modal('open');
          }
        }
        conexion.open('POST', 'ajax.php?modo=ImpFotmatos', true);
        conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        conexion.send(variables);

      }else {

      }
    }

}

function venceC(codigo) {
  $('#Ndiv').remove();
  var conexion, variables, codigo, fH, Ndiv;
  variables = "cantidadEmp=0&codigos=0&modo=venceC&codigo="+codigo;
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function(){
    if (conexion.readyState == 4 && conexion.status == 200) {
      Ndiv = document.createElement("embed");
      $('#Ndiv').remove();
      Ndiv.id="Ndiv";
      Ndiv.width="100%"; 
      Ndiv.height="500px";
      Ndiv.scrolling="no";
      Ndiv.frameborder="0px";
      //Ndiv.data="Temp/temp.pdf"
      Ndiv.src="Temp/temp.pdf";
      Ndiv.type="application/pdf";
      document.getElementById('modal1').appendChild(Ndiv);
      document.getElementById('textCargado').innerHTML = "";
    }else if(conexion.readyState != 4){
      document.getElementById('textCargado').innerHTML = "Procesando...";
      $('#modal1').modal('open');
    }
  }
  conexion.open('POST', 'ajax.php?modo=ImpFotmatos', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variables);
}
