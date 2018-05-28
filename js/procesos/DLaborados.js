$(document).ready(function() {
	DLaborados();
});

$( function() {
	$( "#fch" ).datepicker();
} );

function DLaborados() {
	var conexion, variables, fecha, Tn, Dep, resultado;
	fecha = document.getElementById('fch').value;
	Tn = document.getElementById('tiponom').value;
	Dep = document.getElementById('Dep').value;

	if(fecha != ''){
		if(Tn != '' && Tn > 0 && Tn <= 6){
			if(Dep != ''){

				variables = "fcH="+fecha+"&Tn="+Tn+"&Dep="+Dep;
				conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				conexion.onreadystatechange = function(){
					if(conexion.readyState == 4 && conexion.status == 200){
						document.getElementById('estado_consulta_ajax').innerHTML = conexion.responseText;
						var Dimensiones = AHD();

						if(Dimensiones[3] > Dimensiones[1]){
						   	$('#pie').css("position", "inherit");
						}else {
						   	$('#pie').css("position", "absolute");
					  	}
					}else if(conexion.readyState != 4) {
						resultado = '<div class="progress">';
			            resultado += '<div class="indeterminate"></div>';
			            resultado += '</div>';
			            document.getElementById('estado_consulta_ajax').innerHTML = resultado;

			            var Dimensiones = AHD();

						if(Dimensiones[2] > 330){
					    	$('#pie').css("position", "inherit");
					  	}else {
					    	$('#pie').css("position", "absolute");
				  		}
					}
				}
				conexion.open('POST', 'ajax.php?modo=DLaborados', true);
				conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				conexion.send(variables);

			}else {
				Materialize.toast('Ingrese Un Departamento', 3000);
			}
		}else {
			Materialize.toast('Ingrese Un Tipo De Nomina', 3000);
		}
	}else {
		Materialize.toast('Ingrese Una Fecha', 3000);
	}
}

function GDLaborados() {
	var conexion, variables, fcH, Tn, Dep;

	fcH = document.getElementById('fch').value;
	Tn = document.getElementById('tiponom').value;
	Dep = document.getElementById('Dep').value;

	if(fcH != ''){
		if(Tn != '' && Tn > 0 && Tn <= 6){
			if(Dep != ''){

				variables = $('#frmDLaborados').serialize();
				variables += "&fcH="+fcH+"&Tn="+Tn+"&Dep="+Dep;
				conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveObject('Microsoft.XMLHTTP');
				conexion.onreadystatechange = function(){
					if(conexion.readyState == 4 && conexion.status == 200)
					{
						if(conexion.responseText == 1){
							document.getElementById('textCargado').innerHTML = "ARCHIVO GENERADO";

							setTimeout(function() {
								$('#modal1').modal('close');
								document.getElementById('textCargado').innerHTML = "Procesando...";
							}, 1500);
						}else {
							document.getElementById('textCargado').innerHTML = conexion.responseText;
							setTimeout(function() {
								$('#modal1').modal('close');
								document.getElementById('textCargado').innerHTML = "Procesando...";
							}, 2500);
						}


					}else if(conexion.readyState != 4)
					{
						$('#modal1').modal('open');
					}
				}
				conexion.open('POST', 'ajax.php?modo=GDLaborados', true);
				conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				conexion.send(variables);

			}else {
				Materialize.toast('Ingrese Un Departamento', 3000);
			}
		}else {
			Materialize.toast('Ingrese Un Tipo De Nomina', 3000);
		}
	}else {
		Materialize.toast('Ingrese Una Fecha', 3000);
	}
}
