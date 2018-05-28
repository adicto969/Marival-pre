$(document).ready(function(){
	Permisos();
});

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

function Permisos() {
	var conexion, variables, Periodo, Tn;

	Periodo = document.getElementById('periodo').value;
	Tn = document.getElementById('tiponom').value;

	if(Periodo != ''){
		if(Tn != ''){

			variables = 'periodo='+Periodo+"&TN="+Tn;
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

				} else if(conexion.readyState != 4){
					resultado = '<div class="progress">';
		            resultado += '<div class="indeterminate"></div>';
		            resultado += '</div>';
		            document.getElementById('estado_consulta_ajax').innerHTML = resultado;
				}
			}
			conexion.open('POST', 'ajax.php?modo=Permiso', true);
			conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			conexion.send(variables);

		}else {
			document.getElementById('estado_consulta_ajax').innerHTML = '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Todos los datos deben estar llenos !</h6></div>';
		}

	}else {
		document.getElementById('estado_consulta_ajax').innerHTML = '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Todos los datos deben estar llenos !</h6></div>';
	}
}

function GenerarPermiso() {
	var conexion, variables, Periodo, Tn, codigo;

	codigo = document.getElementById('cod').value;
	Periodo = document.getElementById('periodo').value;
	Tn = document.getElementById('tiponom').value;

	if(codigo != ''){
		if(Periodo != ''){
			if(Tn != ''){
				variables = $('#frmPermiso').serialize();
				variables += "&periodo="+Periodo+"&TN="+Tn;

				conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
				conexion.onreadystatechange = function(){
					if(conexion.readyState == 4 && conexion.status == 200){
						try {
							var jsonDatos = JSON.parse(conexion.responseText);
							if(jsonDatos.error == 0){
								if(jsonDatos.codigoError == ""){
									Materialize.toast('DATO ACTUALIZADO!', 5000);
								}else {
									$('#textCargado').html(jsonDatos.codigoError);
									$("#modal1").modal('open');
								}
							}else {
								if(jsonDatos.codigoError != ""){
									$('#textCargado').html(jsonDatos.codigoError);
									$("#modal1").modal('open');
								}else {
									$('#textCargado').html("OCURRIO UN ERROR");
									$("#modal1").modal('open');
								}
							}
						} catch (e) {
							$('#textCargado').html("OCURRIO UN ERROR");
							$("#modal1").modal('open');
						}
					}else if(conexion.readyState != 4){
						Materialize.toast('Espere Un Momento...', 1000);
					}
				}
				conexion.open('POST', 'ajax.php?modo=GPermiso', true);
				conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
				conexion.send(variables);

			}else {
				$('#tiponom').focus();
				Materialize.toast('Se Requiere El Tipo De Nomina', 5000);
			}
		}else {
			$('#periodo').focus();
			Materialize.toast('Se Requiere El Periodo', 5000);
		}
	}else {
		$('#cod').focus();
		Materialize.toast('Se Requiere El Codigo Del Empleado', 5000);
	}
}

$(function () {
  $.ajax({
    url: 'codigos.json',
    type: 'POST',
    dataType: 'JSON',
    success: function (data){
      var infojson = "<input type='hidden' name='cantidadC' value='"+data['codigos'].length+"'/><thead><tr><th>Codigos</th><th>Descripcion</th><th></th></tr></thead><tbody>";
      for (var c = 0; c <= data['codigos'].length-1; c++){
				if(data['codigos'][c].estatus == 1){
					infojson += "<tr><td>"+data['codigos'][c].codigo;
	        infojson += "</td><td>"+data['codigos'][c].descripcion+"</td>";
					infojson += '<td><span style="background-color: red;padding: 2px 6px;border-radius: 50%;color: white;cursor: pointer;" onclick="eliminarCo(&#39;'+data['codigos'][c].codigo+'&#39;)">X</span></td></tr>';
				}
      }
      infojson += "<tr><td><input type='text' name='codigo' size='7' pattern='[a-zA-Z]{3}|[a-zA-Z]{2}|[a-zA-Z]{1}'></td><td><input type='text' name='descripcion' size='7'></td><td></td></tr></tbody><input type='hidden' name='opcion' value='nuevo'>";
      $("#Tcodigos").html(infojson);
    }
  });
});

$("#frm1").on("submit", function(e){
  e.preventDefault();
  var frm = $("#frm1").serialize();
  $.ajax({
    method: "POST",
    url: "codigos.php",
    data: frm
  }).done(function(info){
    recargo();
  });

  var recargo = function() {
    $.ajax({
      url: 'codigos.json',
      type: 'POST',
      dataType: 'JSON',
      success: function (data) {
				var infojson = "<input type='hidden' name='cantidadC' value='"+data['codigos'].length+"'/><thead><tr><th>Codigos</th><th>Descripcion</th><th></th></tr></thead><tbody>";
	      for (var c = 0; c <= data['codigos'].length-1; c++){
					if(data['codigos'][c].estatus == 1){
						infojson += "<tr><td>"+data['codigos'][c].codigo;
		        infojson += "</td><td>"+data['codigos'][c].descripcion+"</td>";
						infojson += '<td><span style="background-color: red;padding: 2px 6px;border-radius: 50%;color: white;cursor: pointer;" onclick="eliminarCo(&#39;'+data['codigos'][c].codigo+'&#39;)">X</span></td></tr>';
					}
	      }
	      infojson += "<tr><td><input type='text' name='codigo' size='7' pattern='[a-zA-Z]{3}|[a-zA-Z]{2}|[a-zA-Z]{1}'></td><td><input type='text' name='descripcion' size='7'></td><td></td></tr></tbody><input type='hidden' name='opcion' value='nuevo'>";
	      $("#Tcodigos").html(infojson);
      }
    });
  };
});

function pruebaA(ID) {
	if($("#"+ID).is(":visible")){
		$("#"+ID).hide(500);
		//$("#"+ID).css({'display':'none'});
		//$('#pie').css("position", "absolute");

	}else {
		$("#"+ID).show(500);
		//$("#"+ID).css({'display':'block'});
		//$('#pie').css("position", "inherit");
		var Dimensiones = AHD();

		if(Dimensiones[3] > Dimensiones[1]){
			$('#pie').css("position", "inherit");
		}else {
			$('#pie').css("position", "absolute");
		}
	}

}

function autorizar(ID, AU, LBID, CODEMP, FF) {

	$('#Ndiv').remove();

	var NAU = 0;
	$.ajax({
		url: 'ajax.php?modo=AutPermiso',
		type: 'POST',
		data: 'ID='+ID+'&AU='+AU+'&codEmp='+CODEMP+'&FF='+FF,
		success: function(data) {
			//console.log(data);
		}
	}).done(function(retorno) {
		if(retorno == '1'){
			Ndiv = document.createElement("embed");
			$('#Ndiv').remove();
			Ndiv.id="Ndiv";
			Ndiv.width="100%";
			Ndiv.height="500px";
			Ndiv.scrolling="no";
			Ndiv.frameborder="0px";
			Ndiv.src="Temp/tempPP.pdf";
			Ndiv.type="application/pdf";
			document.getElementById('modal1').appendChild(Ndiv);
			document.getElementById('textCargado').innerHTML = "";
			$('#modal1').modal('open');
		}
	});

	if(AU == 1){
		NAU = 2;
	}else {
		NAU = 1;
	}
	$("#"+LBID).attr("onclick", "autorizar("+ID+","+NAU+", '"+LBID+"', "+CODEMP+", '"+FF+"')");
}

function autorizar2(ID, AU, LBID, CODEMP, FF) {
	var NAU = 0;
	$.ajax({
		url: 'ajax.php?modo=AutPermiso',
		type: 'POST',
		data: 'ID='+ID+'&AU2='+AU+'&codEmp='+CODEMP+'&FF='+FF,
		success: function(data) {
			//console.log(data);
		}
	});
	if(AU == 1){
		NAU = 2;
	}else {
		NAU = 1;
	}
	$("#"+LBID).attr("onclick", "autorizar2("+ID+", "+NAU+", '"+LBID+"', "+CODEMP+", '"+FF+"')");
}

function botonArriba() {
	var valor, Tn;
	valor = $("#cod").val();
	Tn = $("#tiponom").val();

	$.ajax({
		url: 'ajax.php?modo=AutCompletado',
		type: 'POST',
		data: 'codigo='+valor+'&Tn='+Tn
	}).done(function(respuesta){
		console.log(respuesta);
		$("#ULAuto").html(respuesta);
	});
}

function agregartap(ID) {
	//$("#cod").val('');
	$("#cod").val(ID);
	$("#ULAuto").html('');
}


function eliminarCo(codigo){
  var modo = "eliminar";
  var descripcion = codigo;
  var cantidad = $('input[name=cantidadC]').val();
  $.ajax({
    method: "POST",
    url: "codigos.php",
    data: "descripcion="+descripcion+"&opcion="+modo+"&cantidadC="+cantidad+"&codigo="+codigo
  }).done(function(info){
    recargo();
  });

  var recargo = function() {
    $.ajax({
      url: 'codigos.json',
      type: 'POST',
      dataType: 'JSON',
      success: function (data) {
        var infodata = "<input type='hidden' name='cantidadC' value='"+data['codigos'].length+"'/><thead><tr><th>Codigos</th><th>Descripcion</th><th></th></tr></thead><tbody>";
        for (var c = 0; c <= data['codigos'].length-1; c++){
          if(data['codigos'][c].estatus == 1){
            infodata += "<tr><td>"+data['codigos'][c].codigo;
            infodata += "</td><td>"+data['codigos'][c].descripcion+"</td>";
            infodata += '<td><span style="background-color: red;padding: 2px 6px;border-radius: 50%;color: white;cursor: pointer;" onclick="eliminarCo(&#39;'+data['codigos'][c].codigo+'&#39;)">X</span></td></tr>';
          }
        }
        infodata += "<tr><td><input type='text' name='codigo' size='7' title='Maximo 3 caracteres' pattern='[a-zA-Z]{3}|[a-zA-Z]{2}|[a-zA-Z]{1}'></td><td><input type='text' name='descripcion' size='7'></td><td></td></tr></tbody><input type='hidden' name='opcion' value='nuevo'/> ";
        $("#Tcodigos").html(infodata);
      }
    });
  };
}
