$(document).ready(function () {
	Retardos();
});

function cambiarPeriodo(){
  var conexion, variables, Periodo, tn;
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

            var fechaJSON = JSON.parse(conexion.responseText.replace("\ufeff", ""));

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


function Retardos() {
	var conexion, variables, Periodo, Tn, resultado;

	Periodo = document.getElementById('periodo').value;
	Tn = document.getElementById('tiponom').value;
	variables = "Pr="+Periodo+"&Tn="+Tn;

	conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	conexion.onreadystatechange = function() {
		if(conexion.readyState == 4 && conexion.status == 200)
		{
			try {
				var jsonDatos = JSON.parse(conexion.responseText.replace("\ufeff", ""));
				if(jsonDatos.error == 0){
					$('#estado_consulta_ajax').html(jsonDatos.contenido);
					var Dimensiones = AHD();

		      if(Dimensiones[3] > Dimensiones[1]){
		          $('#pie').css("position", "inherit");
		      }else {
		          $('#pie').css("position", "absolute");
		      }
				}else {
					$('#estado_consulta_ajax').html("<h3 style='text-align: center;'>OCURRIO UN ERROR</h3>");
				}
			} catch (e) {
				$('#estado_consulta_ajax').html("<h3 style='text-align: center;'>OCURRIO UN ERROR</h3>");
				console.log(e);
			}

		}else if(conexion.readyState != 4){
			resultado = '<div class="progress">';
            resultado += '<div class="indeterminate"></div>';
            resultado += '</div>';
            document.getElementById('pie').style.position = 'absolute';
            document.getElementById('estado_consulta_ajax').innerHTML = resultado;
		}
	}

	conexion.open('POST', 'ajax.php?modo=Retardos', true);
	conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	conexion.send(variables);
}


function GRetardos()
{
  var conexion, variables, Tn, Periodo;

  Tn = document.getElementById('tiponom').value;
  Periodo = document.getElementById('periodo').value;
  variables = $('#frmRetardos').serialize();
  variables += "&Tn="+Tn+"&Periodo="+Periodo;

  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function()
  {
    if(conexion.readyState == 4 && conexion.status == 200)
    {
      if(conexion.responseText.replace("\ufeff", "") == 1)
      {
        document.getElementById('textCargado').innerHTML = "EL ARCHIVO SE HA GENERADO CON EXITO";

        setTimeout(function() {
          $("#modal1").modal('close');
          document.getElementById('textCargado').innerHTML = "Procesando...";
        }, 1500);

      }else {
        document.getElementById('textCargado').innerHTML = conexion.responseText.replace("\ufeff", "");

        /*setTimeout(function() {
          $("#modal1").modal('close');
          document.getElementById('textCargado').innerHTML = "Procesando...";
        }, 2000);*/
      }

    }else if(conexion.readyState != 4)
    {
      document.getElementById('textCargado').innerHTML = "Procesando...";
      $("#modal1").modal('open');
    }

  }
  conexion.open('POST', 'ajax.php?modo=GRetardos', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variables);

}



function GenerarExcel(){
  var fecha1 = document.getElementById('fchI').value;
  var fecha2 = document.getElementById('fchF').value;
  $.ajax({
    method: 'POST',
    url: 'ajax.php?modo=GenerarExcel',
    data: "tipo=retardos&"+"fecha1="+fecha1+"&fecha2="+fecha2,
    beforeSend: function(){
      $('#textCargado').html("Procesando...");
      $('#modal1').modal('open');
    }
  }).done(function(datosC){
    console.log(datosC.replace("\ufeff", ""));
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


function ActualR(codigo, fecha, fechaO) {
	var valor = $('#'+codigo+fecha).val();
	var periodo = $('#periodo').val();
	var Tn = $('#tiponom').val();

	$('#'+codigo+fecha).val(valor.toUpperCase());
  if(valor != ""){
		$.ajax({
			method: 'POST',
			url: 'ajax.php?modo=ActualR',
			data: 'codigo='+codigo+'&fecha='+fecha+'&fechaO='+fechaO+'&valor='+valor+'&tn='+Tn+'&periodo='+periodo
		}).done(function(datos) {
			try {
				var jsonDatos = JSON.parse(datos.replace("\ufeff", ""));
				if(jsonDatos.error == 0){
					$('#'+codigo+fecha).css("background-color", "rgb(78, 212, 78)");
				}else {
					$('#'+codigo+fecha).css("background-color", "rgb(255, 70, 70)");
				}
			} catch (e) {
				$('#'+codigo+fecha).css("background-color", "rgb(255, 70, 70)");
				console.log(e);
			}
		});
	}

}
