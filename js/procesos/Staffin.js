$(document).ready(function() {
	Staffin();
});


function Staffin() {
	var conexion, variable, resultado;
	variable = 'X=x';

	conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	conexion.onreadystatechange = function() {
		if(conexion.readyState == 4 && conexion.status == 200)
		{
			document.getElementById('estado_consulta_ajax').innerHTML = conexion.responseText;
			var Dimensiones = AHD();
			if(Dimensiones[3] > Dimensiones[1]){
			   	$('#pie').css("position", "inherit");
			}else {
			   	$('#pie').css("position", "absolute");
		  	}
		}else if(conexion.readyState != 4)
		{
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

	conexion.open('POST', 'ajax.php?modo=Staffin', true);
	conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	conexion.send(variable);

}


function GStaffin() {
	var conexion, variables;
	variables = $('#frmStaf').serialize();
	variables += "&modo=Guardar";

	conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	conexion.onreadystatechange = function() {
		if(conexion.readyState == 4 && conexion.status == 200)
		{
			if(conexion.responseText == 1){
				document.getElementById('textCargado').innerHTML = "STAFFING GUARDADO";
				$("#btnStaf").attr("onclick","AStaffin()");
				$("#btnStaf").html("ACTUALIZAR");
				$('#btnStaf').blur();
				setTimeout(function () {
					document.getElementById('textCargado').innerHTML = "Procesando...";
					$('#modal1').modal('close');
				}, 1500);
			}else {
				document.getElementById('textCargado').innerHTML = conexion.responseText;
				setTimeout(function () {
					document.getElementById('textCargado').innerHTML = "Procesando...";
					$('#modal1').modal('close');
				}, 2500);
			}

		}else if(conexion != 4){
			$('#modal1').modal('open');
		}
	}
	conexion.open('POST', 'ajax.php?modo=Cstaffin', true);
	conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	conexion.send(variables);
}


function AStaffin() {
	var conexion, variables;
	variables = $('#frmStaf').serialize();
	variables += "&modo=Actualizar";

	conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
	conexion.onreadystatechange = function() {
		if(conexion.readyState == 4 && conexion.status == 200)
		{
			if(conexion.responseText == 1){
				document.getElementById('textCargado').innerHTML = "STAFFING ACTUALIZADO";
				setTimeout(function () {
					document.getElementById('textCargado').innerHTML = "Procesando...";
					$('#modal1').modal('close');
				}, 1500);
			}else {
				document.getElementById('textCargado').innerHTML = conexion.responseText;
				/*setTimeout(function () {
					document.getElementById('textCargado').innerHTML = "Procesando...";
					$('#modal1').modal('close');
				}, 2500);*/
			}

		}else if(conexion != 4){
			$('#modal1').modal('open');
		}
	}
	conexion.open('POST', 'ajax.php?modo=Cstaffin', true);
	conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	conexion.send(variables);
}
