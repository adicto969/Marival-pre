var cantidadXpagina = 10;
var pagina = 1;
var ultimaPagina = 1;
var ordenar = 'codigo';
var busqueda = '';

$(document).ready(function(){
  DifStaffin();
  verContratos();
});

var cantidadCH = 0;
var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
var codigos = [];

function DifStaffin(){
  var conexion, variables, Pdf;
  Pdf = $('#PS').val();

  if(Pdf != ""){
    variables = "Pdf="+Pdf;
    conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    conexion.onreadystatechange = function() {
      if(conexion.readyState == 4 && conexion.status == 200){

          document.getElementById('DifStaffin').innerHTML = conexion.responseText;


      }else if(conexion.readyState != 4){
        resultado = '<div class="progress">';
        resultado += '<div class="indeterminate"></div>';
        resultado += '</div>';
        document.getElementById('DifStaffin').innerHTML = resultado;
      }
    }
    conexion.open('POST', 'ajax.php?modo=DifStaffin', true);
    conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    conexion.send(variables);
  }else {
    $('#PS').focus();
  }
}


function verContratos(){
  var conexion, resultado, variable;

  $.ajax({
    beforeSend: function() {
      resultado = '<div class="progress">';
      resultado += '<div class="indeterminate"></div>';
      resultado += '</div>';
      $('#estado_consulta_ajax').html(resultado);
    },
    method: 'POST',
    url: 'ajax.php?modo=verContratos',
    data: 'cantidadXpagina='+cantidadXpagina+'&pagina='+pagina+'&order='+ordenar+'&buscar='+busqueda
  }).done(function(datos){
    try{
      var jsonDatos = JSON.parse(datos.replace("\ufeff", ""));
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
    }catch(ex) {
      console.log(ex.message);
      resultado = '<div class="center">';
      resultado += '<h4>OCURRIO UN ERROR INTENTELO MAS TARDE</h4>';
      resultado += '</div>';
      $('#estado_consulta_ajax').html(resultado);
    }
  });
}

function Gcontratos(){
  $('#Ndiv').remove();
  var conexion, resultado, variables, correo;
  correo = $('#Correo').val();
  variables = $('#frmContratos').serialize();
  variables += "&correo="+correo;
  if(correo != ""){

    $.ajax({
      beforeSend: function() {
        $('#modal1').modal('open');
      },
      method: 'POST',
      url: 'ajax.php?modo=Gcontratos',
      data: variables
    }).done(function(datos) {
      try {
        var jsonDatos = JSON.parse(datos.replace("\ufeff", ""));
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
          }, 3000);
        }
      }catch(e){
        console.log(e.message);
      }
    });
  }else {
    $('#Correo').focus();
  }
}

function EnviarContrato(){
  $('#Ndiv').remove();
  var conexion, resultado, variables, userN, fecha, porC;
  fecha = $('#FH').val();
  porC = $('#PS').val();
  userN = $('#userN').val();
  variables = $('#frmContratos').serialize();
  variables += "&userN="+userN+"&fecha="+fecha+"&porC="+porC;
  if(userN != "" && fecha != "" && porC != ""){
    conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    conexion.onreadystatechange = function() {
      if(conexion.readyState == 4 && conexion.status == 200){
        if(conexion.responseText.replace("\ufeff", "") == "1"){
          document.getElementById('textCargado').innerHTML = "ARCHIVO GENERADO";
          setTimeout(function(){
            $('#modal1').modal('close');
            document.getElementById('textCargado').innerHTML = "Procesando...";
          }, 1500);
        }else {
          document.getElementById('textCargado').innerHTML = conexion.responseText.replace("\ufeff", "");
          setTimeout(function(){
            $('#modal1').modal('close');
            document.getElementById('textCargado').innerHTML = conexion.responseText.replace("\ufeff", "");
          }, 4000);
        }
      }else if(conexion.readyState != 4){
        document.getElementById('textCargado').innerHTML = "Procesando...";
        $('#modal1').modal('open');
      }
    }
    conexion.open('POST', 'ajax.php?modo=EnvContrato', true);
    conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    conexion.send(variables);
  }else {
    if(userN === ""){
      $('#userN').focus();
    }else if(fecha === ""){
      $('#FH').focus();
    }else {
      $('#PS').focus();
      alert("Porsen Vacio");
    }

  }
}

function seleccion(ID) {
  if($('#'+ID).hasClass('hover')){
      menChe(ID);
      $('#'+ID).removeClass('hover');
      $('#'+ID).css({'background-color':''});
  }else {
      masChe(ID);
      $('#'+ID).addClass('hover');
      $('#'+ID).css({'background-color':'rgba(255, 137, 5, 0.6)'});
  }
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

//////////////////////////GENERAR FORMATOS////////////////////////////////

function VGformatos(){
  $('#Ndiv').remove();
  var conexion, variables, fH;
  fH=new Date();
  if(cantidadCH > 0){

    variables = "modo=V&cantidadEmp="+cantidadCH+"&codigos[]="+codigos;

    $.ajax({
      method: 'POST',
      url: 'ajax.php?modo=ImpFotmatos',
      data: variables,
      beforeSend: function() {
        $('#textCargado').html("Procesando...");
        $('#modal1').modal('open');
      }
    }).done(function(retorno) {
      $('#textCargado').html("ARCHIVOS GENERADOS");
    }).fail(function(retorno){
      $('#textCargado').html(retorno);
    }).always(function() {
      setTimeout(function(){
        $('#textCargado').html("Procesando...");
        $('#modal1').modal('close');
      }, 1500);
    });

  }else {
      $('#Ndiv').remove();
      var codigo;
      codigo = prompt("Ingrese Codigo de Empleado");
      if(codigo == undefined){

      }else {

        $.ajax({
          method: 'POST',
          url: 'ajax.php?modo=ImpFotmatos',
          data: "cantidadEmp=0&codigos=0&modo=venceC&codigo="+codigo,
          beforeSend: function() {
            $('#textCargado').html("Procesando...");
            $('#modal1').modal('open');
          }
        }).done(function(retorno) {
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
        }).fail(function(retorno){
          $('#textCargado').html(retorno);
        }).always(function() {
          //$('#textCargado').html("Procesando...");
          //$('#modal1').modal('close');
        });
      }
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

              $.ajax({
                method: 'POST',
                url: 'ajax.php?modo=ImpFotmatos',
                data: variables,
                beforeSend: function() {
                  $('#textCargado').html("Procesando...");
                  $('#modal1').modal('open');
                }
              }).done(function(retorno) {
                $('#textCargado').html("ARCHIVOS GENERADOS");
              }).fail(function(retorno){
                $('#textCargado').html(retorno);
              }).always(function() {
                setTimeout(function(){
                  $('#textCargado').html("Procesando...");
                  $('#modal1').modal('close');
                }, 1500);
              });

            }
          }

      }
    }

  }else {

    var fH, FechaS, JefeIM, codigo, variables, Ndiv;
    fH = new Date();

    codigo = prompt("Ingrese Codigo de Trabajador");
    FechaS = prompt("Ingrese Fecha de salida", fH.getDate() + " de " + meses[fH.getMonth()] + " del " + fH.getFullYear());
    JefeIM = prompt("Nombre del Jefe Inmediato");
    if(codigo == undefined){
      var $toastContent = $('<span>Tiene que ingresar un codigo de trabajador!</span>');
      Materialize.toast($toastContent, 3000);
    }else {
      if(FechaS == undefined){
        var $toastContent = $('<span>Tienes que ingresar una fecha!</span>');
        Materialize.toast($toastContent, 3000);
      }else {
        if(JefeIM == undefined){
          var $toastContent = $('<span>Tiene que ingresar un jefe!</span>');
          Materialize.toast($toastContent, 3000);
        }else{
          if (FechaS != "" && JefeIM != "" && codigo != "") {

            variables = "cantidadEmp=0&codigos=0&modo=salida&codigo="+codigo+"&FS="+FechaS+"&jefe="+JefeIM;
            $.ajax({
              method: 'POST',
              url: 'ajax.php?modo=ImpFotmatos',
              data: variables,
              beforeSend: function() {
                $('#textCargado').html("Procesando...");
                $('#modal1').modal('open');
              }
            }).done(function(retorno) {
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
            }).fail(function(retorno){
              $('#textCargado').html(retorno);
            }).always(function() {
              //$('#textCargado').html("Procesando...");
              //$('#modal1').modal('close');
            });

          }else {

          }
        }
      }
    }
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
        $.ajax({
          method: 'POST',
          url: 'ajax.php?modo=ImpFotmatos',
          data: variables,
          beforeSend: function() {
            $('#textCargado').html("Procesando...");
            $('#modal1').modal('open');
          }
        }).done(function(retorno) {
          $('#textCargado').html("ARCHIVOS GENERADOS");
        }).fail(function(retorno){
          $('#textCargado').html(retorno);
        }).always(function() {
          setTimeout(function(){
            $('#textCargado').html("Procesando...");
            $('#modal1').modal('close');
          }, 1500);
        });
      }
    }

  }else {
    $('#Ndiv').remove();
      var FechaB, fH, codigo, variables, Ndiv;
      fH = new Date();
      codigo = prompt("Ingrese un codigo de trabajador");
      FechaB = prompt("Ingrese Fecha de Baja", fH.getDate() + " de " + meses[fH.getMonth()] + " del " + fH.getFullYear());
      if(codigo == undefined){
        var $toastContent = $('<span>Tiene que ingresar codigo de trabajador!</span>');
        Materialize.toast($toastContent, 3000);
      }else {
        if(FechaB == undefined){
          var $toastContent = $('<span>Tiene que ingresar una fecha de baja!</span>');
          Materialize.toast($toastContent, 3000);
        }else {
          if (FechaB != "") {
            variables = "cantidadEmp=0&codigos=0&modo=liberacion&codigo="+codigo+"&FechaB="+FechaB;

            $.ajax({
              method: 'POST',
              url: 'ajax.php?modo=ImpFotmatos',
              data: variables,
              beforeSend: function() {
                $('#textCargado').html("Procesando...");
                $('#modal1').modal('open');
              }
            }).done(function(retorno) {
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
            }).fail(function(retorno){
              $('#textCargado').html(retorno);
            }).always(function() {
              //$('#textCargado').html("Procesando...");
              //$('#modal1').modal('close');
            });

          }else {

          }
        }
      }

  }

}

function VerUser() {
  var NomUser;
	NomUser = $("#userN").val();

	$.ajax({
		url: 'ajax.php?modo=ConsultaUserMSQL',
		type: 'POST',
		data: 'NomUser='+NomUser
	}).done(function(respuesta){

		$("#ULAuto").html(respuesta);
	});
}

function agregartap(User) {
	$("#userN").val(User);
	$("#ULAuto").html('');
}

function GenerarExcel(){
  $('#Ndiv').remove();
  $.ajax({
    method: 'POST',
    url: 'ajax.php?modo=GenerarExcel',
    data: "tipo=contrato",
    beforeSend: function(){
      $('#textCargado').html("Procesando...");
      $('#modal1').modal('open');
    },
    statusCode: {
      404: function() {
        alert( "page not found" );
      },
      200: function(datosC) {
        if(datosC.replace("\ufeff", "") == '1'){
            $('#textCargado').html("ARCHIVO GENERADO");
        }else{
            $('#textCargado').html("ERROR AL GENERAR EL ARCHIVO");
        }
        setTimeout(function(){
          $('#textCargado').html("Procesando...");
          $('#modal1').modal('close');
        }, 1500);
      }

    }
  }).done(function(datosC){
    console.log(datosC);
    if(datosC.replace("\ufeff", "") == '1'){
        $('#textCargado').html("ARCHIVO GENERADO");
    }else{
        $('#textCargado').html("ERROR AL GENERAR EL ARCHIVO");
    }
  }).fail(function(retorno){
    $('#textCargado').html(retorno.replace("\ufeff", ""));
  }).always(function(){
    setTimeout(function(){
      $('#textCargado').html("Procesando...");
      $('#modal1').modal('close');
    }, 1500);
  });
}


function sig() {
  if(pagina < ultimaPagina){
    pagina++;
  }
  verContratos();
}

function ant() {
  if(pagina > 1){
    pagina--;
  }
  verContratos();
}

function Mostrarcanti(cantidad) {
  cantidadXpagina = cantidad;
  pagina = 1;
  verContratos();
}

function Ordernar(orden){
    ordenar = orden;
    console.log(ordenar);
    verContratos();
}

function busquedaF() {
    pagina = 1;
    busqueda = $('#buscarV').val();
    verContratos();
}
