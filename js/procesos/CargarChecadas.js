$(document).ready(function() {
	CargarChecadas();
	var Dimensiones = AHD();
  	console.log(Dimensiones[0]+' '+Dimensiones[1]+' '+Dimensiones[2]);

    if(Dimensiones[2] > Dimensiones[0]){
     	$('#pie').css("position", "inherit");
     	console.log("inherit");
  	}else {
    	$('#pie').css("position", "absolute");
    	console.log("absolute");
  	}
});



function CargarChecadas()
{
	$.ajax({
        url: 'datos/empleados.json',
        type: 'POST',
        dataType: 'JSON',
        success: function (data) {
            var  infoJSONN = "<input type='hidden' id='cantidadCC' name='cantidadC' value='"+data['empleados'].length+"'/>";
            infoJSONN += "<thead><tr><th class='Aline'>Codigo</th><th class='Aline'>Empresa</th><th class='Aline'>Entrada</th><th class='Aline'>Salida</th><th class='Aline'>Eliminar</th></tr></thead></tbody>";
            for (var c = 0; c <= data['empleados'].length-1; c++) {
                if(data['empleados'][c].estado == 1){
   	                infoJSONN += "<tr><td class='Aline'>" + data['empleados'][c].codigo;
                    infoJSONN += "</td><td class='Aline'>" + data['empleados'][c].empresa +"</td><td class='Aline'>" + data['empleados'][c].hora +"</td><td class='Aline'>" + data['empleados'][c].hora2 +"</td><td><span class='btn red Nmargen' name='empresa' id='"+data['empleados'][c].codigo+"' onclick='eliminar("+data['empleados'][c].codigo+")'>X</span></td></tr>";
                }
            }
            infoJSONN += "<tr><td><input type='number' size='7' autofocus='autofocus' id='codigo' onkeyup='botonArriba()'></td>";
            infoJSONN += "<td><input type='number' id='empresa' size='7'>";
            infoJSONN += "<td class='Aline2'><input style='margin-bottom: 0px;' type='time' value='08:00:00' id='hora' step='1' size='10' style='width: 157px;'></td>";
						infoJSONN += "<td class='Aline2'><input style='margin-bottom: 0px;' type='time' value='08:00:00' id='hora2' step='1' size='10' style='width: 157px;'>";
            infoJSONN += "</td><td class='Aline'></td></tr></tbody><input type='hidden' name='opcion' value='nuevo'/>";
            $("#Tcodigos").html(infoJSONN);

        }
    });

}

function eliminar(d1){
	var parametrosE = {
	  "cantidadC" : document.getElementById("cantidadCC").value,
	  "opcion" : "modificar",
	  "empresa" : "1",
	  "hora" : "8",
		"hora2" : "8",
	  "codigo" : d1
	} ;
	$.ajax({
	    method: "POST",
	    url: "ajax.php?modo=cargarEmpleados",
	    data: parametrosE
	}).done(function(info){
	    Materialize.toast(info, 3000);
	    CargarChecadas();
	});
};


function Agregar() {
	var variables, codigo, empresa, hora, hora2, h1, h2, m1, m2, s1, s2, h21, h22, m21, m22, s21, s22;

	hora = document.getElementById('hora').value;
	hora2 = document.getElementById('hora2').value;
	codigo = document.getElementById('codigo').value;
	empresa = document.getElementById('empresa').value;

	h1 = hora.charAt(0);
	h2 = hora.charAt(1);
	m1 = hora.charAt(3);
	m2 = hora.charAt(4);
	s1 = hora.charAt(6);
	s2 = hora.charAt(7);

	h21 = hora2.charAt(0);
	h22 = hora2.charAt(1);
	m21 = hora2.charAt(3);
	m22 = hora2.charAt(4);
	s21 = hora2.charAt(6);
	s22 = hora2.charAt(7);

	if(hora.length==8 || hora.length==5){
		if((h1 <= 1 && h2 <= 9 ) || (h1==2 && h2 <= 3))
		{
			if(m1<=5){
				if(s1<=5){
					if(hora2.length == 8 || hora2.length == 5){
						if((h21 <= 1 && h22 <= 9) || (h21 == 2 && h22 <= 3)){
							if(m21 <= 5){
								if(s21 <= 5){
									if(codigo != ''){
										if(empresa != '')
										{

											variables = $('#frmCargarChecadas').serialize();
											if(hora.length == 5){
												variables += "&hora="+hora+":00&hora2="+hora2+":00&codigo="+codigo+"&empresa="+empresa;
											}else {
												variables += "&hora="+hora+"&hora2="+hora2+"&codigo="+codigo+"&empresa="+empresa;
											}

												$.ajax({
														method: "POST",
														url: "ajax.php?modo=cargarEmpleados",
														data: variables
												}).done(function(info){
														Materialize.toast(info, 3000);
														CargarChecadas();
												});

										}else {
											Materialize.toast('Ingrese Una Empresa', 3000);
										}
									}else {
										Materialize.toast('Ingrese Un Codigo De Empleado', 3000);
									}
								}else {
									Materialize.toast('Los Segundos Son Incorrectos', 3000);
								}
							}else {
								Materialize.toast('Los Minutos Son Incorrectos', 3000);
							}
						}else {
							Materialize.toast('La Hora Es Incorrecta', 3000);
						}
					}else {
						Materialize.toast('El Formato De Hora Debe De Ser (HH:MM:SS)', 3000);
					}
				}else {
					Materialize.toast('Los Segundos Son Incorrectos', 3000);
				}
			}else {
				Materialize.toast('Los Minutos Son Incorrectos', 3000);
			}
		}else {
			Materialize.toast('La Hora Es Incorrecta', 3000);
		}
	}else {
		Materialize.toast('El Formato De Hora Debe De Ser (HH:MM:SS)', 3000);
	}
}


function botonArriba() {
	var valor, Tn;
	valor = $("#codigo").val();
	if(valor == ""){
		$("#ULAuto").html(' ');
	}else {
		$.ajax({
			url: 'ajax.php?modo=ConsInfoEmpChecada',
			type: 'POST',
			data: 'codigo='+valor
		}).done(function(respuesta){
			$("#ULAuto").html(respuesta);
		});
	}

}

function agregartap(ID, empresa, entra1, sale1) {
	//$("#cod").val('');
	var h1, h2, m1, m2, h21, h22, m21, m22;

	h1 = entra1.charAt(0);
	h2 = entra1.charAt(1);
	m1 = entra1.charAt(2);
	m2 = entra1.charAt(3);

	h21 = sale1.charAt(0);
	h22 = sale1.charAt(1);
	m21 = sale1.charAt(2);
	m22 = sale1.charAt(3);

	$("#codigo").val(ID);
	$("#empresa").val(empresa);
	$("#hora").val(h1+''+h2+':'+m1+''+m2+':00');
	$("#hora2").val(h21+''+h22+':'+m21+''+m22+':00');
	$("#ULAuto").html('');
}
