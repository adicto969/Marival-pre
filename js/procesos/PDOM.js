$(document).ready(function() {
	PDOM();
});


function PDOM(){

	var conexion, variables, resultado, Pc, Tn, Dep;
	Pc = document.getElementById('periodo').value;
	Tn = document.getElementById('tiponom').value;
	Dep = document.getElementById('Dep').value;

	if(Pc != ''){
		if(Tn != ''){
			if(Dep != ''){

				variables += "&periodo="+Pc+"&Tn="+Tn+"&Dep="+Dep;
				conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				conexion.onreadystatechange = function(){
					if(conexion.readyState == 4 && conexion.status == 200){
						document.getElementById('estado_consulta_ajax').innerHTML = conexion.responseText;

						var Dimensiones = AHD();
						console.log(Dimensiones);
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

			            var Dimensiones = AHD();

						if(Dimensiones[3] > Dimensiones[1]){
					    	$('#pie').css("position", "inherit");
					  	}else {
					    	$('#pie').css("position", "absolute");
				  		}
					}
				}

				conexion.open('POST', 'ajax.php?modo=PDOM', true);
				conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				conexion.send(variables);

			}else {
				Materialize.toast('Ingrese Un Departamento', 3000);
			}
		}else {
			Materialize.toast('Ingrese Un Tipo De Nomina', 3000);
		}
	}else {
		Materialize.toast('Ingrese Un Periodo', 3000);
	}
}

function GPDOM() {
	var conexion, variables, resultado, Pc, Tn, Dep;
	Pc = document.getElementById('periodo').value;
	Tn = document.getElementById('tiponom').value;
	Dep = document.getElementById('Dep').value;

	if(Pc != ''){
		if(Tn != ''){
			if(Dep != ''){
				variables = $("#frmPDOM").serialize();
				variables += "&Pc="+Pc+"&Tn="+Tn+"&Dep="+Dep;
				console.log(variables);
				conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				conexion.onreadystatechange = function() {
					if(conexion.readyState == 4 && conexion.status == 200){

						if(conexion.responseText == 1){
							document.getElementById('textCargado').innerHTML = "ARCHIVO GENERADO";
							setTimeout(function() {
								document.getElementById('textCargado').innerHTML = "Procesando...";
        						$('#modal1').modal('close');
							}, 1500);
						}else {
							document.getElementById('textCargado').innerHTML = conexion.responseText;
						}

					}else if(conexion.readyState != 4){
						document.getElementById('textCargado').innerHTML = "Procesando...";
        				$('#modal1').modal('open');
					}
				}

				conexion.open('POST', 'ajax.php?modo=GPDOM', true);
				conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				conexion.send(variables);

			}else {
				Materialize.toast('Ingrese Un Departamento', 3000);
			}
		}else {
			Materialize.toast('Ingrese Un Tipo De Nomina', 3000);
		}
	}else {
		Materialize.toast('Ingrese Un Periodo', 3000);
	}
}

function cambiarPeriodo() {
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


function GenerarExcel(){
  var fecha1 = document.getElementById('fchI').value;
  var fecha2 = document.getElementById('fchF').value;
	var Dep = document.getElementById('Dep').value;
  $.ajax({
    method: 'POST',
    url: 'ajax.php?modo=GenerarExcel',
    data: "tipo=pdom&"+"fecha1="+fecha1+"&fecha2="+fecha2+"&Dep="+Dep,
    beforeSend: function(){
      $('#textCargado').html("Procesando...");
      $('#modal1').modal('open');
    }
  }).done(function(datosC){
    console.log(datosC);
    if(datosC.replace("\ufeff", "") == '1'){
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
