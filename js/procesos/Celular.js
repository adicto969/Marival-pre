$(document).ready(function() {
	Celular();
});

$( function() {
	$( "#fcH" ).datepicker();
} );

function Celular(){
	var conexion, variable, respuesta, fcH, Hrs, Dep;

	fcH = document.getElementById('fcH').value;
	Hrs = document.getElementById('Hrs').value;
	Dep = document.getElementById('Dep').value;

	if(fcH != ''){
		if(Hrs != '' || Hrs > 0){
			if(Dep != ''){

				variable = "fcH="+fcH+"&Hrs="+Hrs+"&Dep="+Dep;

				conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				conexion.onreadystatechange = function() {
					if(conexion.readyState == 4 && conexion.status == 200){
						document.getElementById('estado_consulta_ajax').innerHTML = conexion.responseText;

						var Dimensiones = AHD();
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
						if(Dimensiones[2] > 330){
						   	$('#pie').css("position", "inherit");
						}else {
						   	$('#pie').css("position", "absolute");
					  	}
					}
				}
				conexion.open('POST', 'ajax.php?modo=Celular', true);
				conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				conexion.send(variable);

			}else {
				Materialize.toast('Ingrese Un Departamento', 3000);
			}
		}else {
			Materialize.toast('Ingrese Un Horario', 3000);
		}
	}else {
		Materialize.toast('Ingrese Una Fecha', 3000);
	}
}
