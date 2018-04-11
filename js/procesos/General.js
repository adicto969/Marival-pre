var myWidth = 0, myHeight = 0, altoDiv, IDEmpresaX;
IDEmpresaX = $('#IDEmpConfig').val();

$('#btnMenu').on('click', function(e) {
   $('.button-collapse').sideNav('hide');
   e.preventDefault();
});

$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });

  var Dimensiones = AHD();

  if(Dimensiones[3] > Dimensiones[1]){
    $('#pie').css("position", "inherit");
  }else {
    $('#pie').css("position", "absolute");
  }

  $( ".Calendario" ).datepicker();

  $('.scrollspy').scrollSpy();
  notificaciones();
});

$("form").on("submit", function(e){
  e.preventDefault();
});

$(".button-menu2").sideNav();
$(".modal").modal();

//////////////////////////THEAD  FIJA/////////////////////////////

window.onscroll = function() {myFunction()};

function myFunction() {
  var Dimensiones = AHD();
  if(Dimensiones[0] > 1024){
    var altura = $('form').offset();
    var alturaD = $('#Dpp').offset();
    $('#DCF').css("display", "block");

    //var altura = document.getElementById('frmTasis').offsetTop;
      //Thfija

      altoDiv =  $('#t01').height();
      $('#DCF').css('opacity', '1');
      document.getElementById('DCF').style.top = '-'+altoDiv+'px';

      if ( document.body.scrollTop > altura.top ){
        var thancho1 = $('#thAnchoB1').width();
        var thancho2 = $('#thAnchoB2').width();
        var thancho3 = $('#thAnchoB3').width();
        var thancho4 = $('#thAnchoB4').width();
        var thaU1 = $('#thAUPP').width();
        var thaU2 = $('#thAUPA').width();
        var thaU3 = $('#thAFI').width();
        $('#thAnchoA1').css("width", (thancho1+10));
        $('#thAnchoA2').css("width", (thancho2+10));
        $('#thAnchoA3').css("width", (thancho3+10));
        $('#thAnchoA4').css("width", (thancho4+10));
        $('#thAUPP1').css("width", (thaU1+10));
        $('#thAUPA1').css("width", (thaU2+10));
        $('#thAFI').css("width", (thaU3+10));
        document.getElementById('Thfija').style.top = (document.body.scrollTop-altura.top) + 'px';
        document.getElementById('DCF').style.top = '-'+(altoDiv-document.body.scrollTop+altura.top) + 'px';

      }

      if(document.body.scrollTop == 0 || document.body.scrollTop == altura.top || altura.top > document.body.scrollTop)
      {
        document.getElementById('Thfija').style.top = '0px';
        $('#DCF').css('opacity', '0');
      }


      if ( document.body.scrollTop > alturaD.top ){
        document.getElementById('Dpp').style.top = (document.body.scrollTop-alturaD.top) + 'px';
      }

      if(document.body.scrollTop == 0 || document.body.scrollTop == alturaD.top || alturaD.top > document.body.scrollTop)
      {
        document.getElementById('Dpp').style.top = '0px';
      }

  }else {
      $('#DCF').css("display", "none");
  }

}

$(window).resize(function() {

  var Dimensiones = AHD();

  if(Dimensiones[3] > Dimensiones[1]){
    $('#pie').css("position", "inherit");

  }else {
    $('#pie').css("position", "absolute");

  }

});

function AHD(){
  if( typeof( window.innerWidth ) == 'number' ) {
    //No-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  altoDiv =  $('#estado_consulta_ajax').height();
  altoBody = $(document).height();
  var datos = new Array(myWidth, myHeight, altoDiv, altoBody);

  return datos;
}



///CAMBIAR DEPARTAMENTO

$('#SelectDep').change(function() {
  var conexion, variable, str, idEmp;
  str = $(this).val();
  idEmp = $('#IDEmpConfig').val();
  if(str == "0v"){
    Materialize.toast('SELECCIONE UN DEPARTAMENTO', 1000);
  }else {
    if(idEmp != "")
    {
      variable = "centro="+str+"&Tipo=1&idEmp="+idEmp;
      conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      conexion.onreadystatechange = function() {
        if(conexion.readyState == 4 && conexion.status == 200){
          if(conexion.responseText == 2){
            Materialize.toast('DEPARTAMENTO MODIFICADO', 1000);
            setTimeout(function(){
              location.reload();
            }, 500);
          }else {
            Materialize.toast('ERROR INTENTELO DE NUEVO'+conexion.responseText, 1000);

          }
        }
      }
      conexion.open('POST', 'ajax.php?modo=CambioDep', true);
      conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      conexion.send(variable);
    }else {
      Materialize.toast('INGRESE UNA EMPRESA', 1000);
      $('#IDEmpConfig').focus();
    }
  }

});

$('#SelectSub').change(function() {
  var conexion, variable, str, idEmp;
  str = $(this).val();
  idEmp = $('#IDEmpConfig').val();
  if(str == "0v"){
    Materialize.toast('SELECCIONE UN SUB-DEPARTAMENTO', 1000);
  }else {
    if(idEmp != ""){
      variable = "centro="+str+"&Tipo=0&idEmp="+idEmp;

      conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      conexion.onreadystatechange = function() {
        if(conexion.readyState == 4 && conexion.status == 200){
          if(conexion.responseText == 2){
            Materialize.toast('DEPARTAMENTO MODIFICADO', 1000);
            setTimeout(function(){
              location.reload();
            }, 500);
          }else {
            Materialize.toast('ERROR INTENTELO DE NUEVO'+conexion.responseText, 1000);

          }
        }
      }
      conexion.open('POST', 'ajax.php?modo=CambioDep', true);
      conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      conexion.send(variable);
    }else {
      Materialize.toast('INGRESE UNA EMPRESA', 1000);
      $('#IDEmpConfig').focus();
    }

  }

});


$('#SelectSupervisor').change(function() {
  var conexion, variable, str, idEmp;
  str = $(this).val();
  idEmp = $('#IDEmpConfig').val();
  if(str == "0v"){
    Materialize.toast('SELECCIONE UN SUPERVISOR', 1000);
  }else {
    if(idEmp != ""){
      variable = "supervisor="+str+"&Tipo=0&idEmp="+idEmp;

      conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      conexion.onreadystatechange = function() {
        if(conexion.readyState == 4 && conexion.status == 200){
          if(conexion.responseText == 2){
            Materialize.toast('SUPERVISOR MODIFICADO', 1000);
            setTimeout(function(){
              location.reload();
            }, 500);
          }else {
            Materialize.toast('ERROR INTENTELO DE NUEVO'+conexion.responseText, 1000);

          }
        }
      }
      conexion.open('POST', 'ajax.php?modo=CambioSuper', true);
      conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      conexion.send(variable);
    }else {
      Materialize.toast('INGRESE UNA EMPRESA', 1000);
      $('#IDEmpConfig').focus();
    }

  }

});


//////////////////////////////////////ALERTAS//////////////////////////////////////////////

function notificaciones() {
  var noti = $.ajax({
    url: 'ajax.php?modo=notificaciones',
    method: 'POST',
    dataType: 'text',
    data: "valor=x",
    async: false
  }).responseText;
  document.getElementById('dropdown1').innerHTML = noti;
  if(noti != "<li><a>vacio</a></li>" && noti != 0){
    $('#alerta').css("color", "yellow");
  }else {

  }
}

function labels(event) {

  var oID = event.target.id;

  var d = document.getElementById(oID);
  var topPS = d.offsetLeft;

  var Of = $('oID').offset();

}



$( "input" ).on( "click", function(e) {

  var Of = $(this).offset();

});


$("input[type=checkbox]").on("click", function() {
  var Of = $(this).offset();


  //document.getElementById('modalConfig').scrollTo(0,30);
});

$("input[type=radio]").on("click", function(e) {
  var Of = $(this).offset();


  //document.getElementById('modalConfig').scrollTo(0,30);
});

$("#IDEmpConfig").keyup(function(e) {

    if(e.which == 13){
      if($(this).val() != "" && $(this).val() > 0){
        var conexion, variables, idEmp;
        idEmp = $(this).val();

          variables = "centro=*&Tipo=9&idEmp="+idEmp;

          conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
          conexion.onreadystatechange = function() {
            if(conexion.readyState == 4 && conexion.status == 200){
              if(conexion.responseText == 2){
                Materialize.toast('ID Empresa Fue Modificado', 1500);
                setTimeout(function(){
                  location.reload();
                }, 500);
              }else if(conexion.responseText == 0){
                Materialize.toast('LA EMPRESA NO EXITE ', 1000);
              }else {
                Materialize.toast('ERROR INTENTELO DE NUEVO '+conexion.responseText, 1000);
              }
            }
          }

          conexion.open('POST', 'ajax.php?modo=CambioDep', true);
          conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          conexion.send(variables);

      }else {
        Materialize.toast('El ID de la empresa no es valido', 1500);
        $('#IDEmpConfig').focus();
      }

    }

});


////Cambiar estatus de las notificaciones
function camStatus(ID) {
  var id = ID;
  $.ajax({
   url: 'ajax.php?modo=camStatus',
   method: 'POST',
   data: "IDNotifi="+id,
 }).done(function() {
   notificaciones();
 });
}
