function Registro(){
  var conexion, variables, responder, resultado, user, pass, Cpass, Spass, NEmpresa, CDepto, admin, Area;
  user = document.getElementById('user_reg').value;
  pass = document.getElementById('pass_reg').value;
  Cpass = document.getElementById('Cpass_reg').value;
  Spass = document.getElementById('Spass_reg').value;
  NEmpresa = document.getElementById('empresa_reg').value;
  CDepto = document.getElementById('depto_reg').value;

  var ech = document.getElementById('admin_reg').checked ? true : false;
  if(ech)
  {
    admin = 1;
  }else {
    admin = 0;
  }


  var resultado = "ninguno";
  var porN = document.getElementsByName('area');
  for(var i=0; i<porN.length; i++){
    if(porN[i].checked){
      resultado=porN[i].value;
    }

  }
  Area = resultado;

  if(user != '' && pass != '' && Cpass != '' && Spass != '' && NEmpresa != '' && CDepto != ''){

    if(pass == Cpass){
      variables = 'user='+user+'&pass='+pass+'&Spass='+Spass+'&NEmpresa='+NEmpresa+'&CDepto='+CDepto+'&admin='+admin+'&Area='+Area;
      conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      conexion.onreadystatechange = function() {
        if(conexion.readyState == 4 && conexion.status == 200){
          if(conexion.responseText == 1){
            resultado = '<div class="progress">';
            resultado += '<div class="indeterminate"></div>';
            resultado += '</div>';
            document.getElementById('estado_Login_ajax_reg').innerHTML = '<div style="width: 100%" class="light-green accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: black;">El Usuario se agrego correctamente !</h6></div>';
            borrar();
            //redireccionar a una pagina
          } else {
            //document.getElementById('estado_Login_ajax_reg').innerHTML = conexion.responseText;
            //console.log(conexion.responseText);
            document.getElementById('estado_Login_ajax_reg').innerHTML = conexion.responseText;
          }
        }else if(conexion.readyState != 4){
          resultado = '<div class="progress">';
          resultado += '<div class="indeterminate"></div>';
          resultado += '</div>';
          document.getElementById('estado_Login_ajax_reg').innerHTML = resultado;
        }
      }
      conexion.open('POST', 'ajax.php?modo=reg', true);
      conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      conexion.send(variables);

    }else {
      document.getElementById('estado_Login_ajax_reg').innerHTML = '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Las contraseñas no coinciden !</h6></div>';
    }

  }else {
    document.getElementById('estado_Login_ajax_reg').innerHTML = '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Todos los datos deben estar llenos !</h6></div>';
  }
}

function borrar(){
  document.getElementById('user_reg').value = "";
  document.getElementById('pass_reg').value = "";
  document.getElementById('Cpass_reg').value = "";
  document.getElementById('Spass_reg').value = "";
  document.getElementById('empresa_reg').value = "";
  document.getElementById('depto_reg').value = "";
  document.getElementById('admin_reg').checked = false;
}

function scriptLoginReg(e){
  if(e.keyCode == 13){
    Registro();
  }
}
