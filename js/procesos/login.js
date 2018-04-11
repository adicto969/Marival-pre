function Login(){
  var conexion, variables, responder, resultado, user, pass;
  user = document.getElementById('user_login').value;
  pass = document.getElementById('pass_login').value;
  variables = 'user='+user+'&pass='+pass;
  conexion = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
  conexion.onreadystatechange = function() {
    if(conexion.readyState == 4 && conexion.status == 200){
      if(conexion.responseText == 1){
        window.location="index.php?pagina=Tasistencia.php";
      } else {
        document.getElementById('estado_Login_ajax').innerHTML = conexion.responseText;
      }
    }else if(conexion.readyState != 4){
      resultado = '<div class="progress">';
      resultado += '<div class="indeterminate"></div>';
      resultado += '</div>';
      document.getElementById('estado_Login_ajax').innerHTML = resultado;
    }
  }
  conexion.open('POST', 'ajax.php?modo=login', true);
  conexion.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  conexion.send(variables);
}

function scriptLogin(e){
  if(e.keyCode == 13){
    Login();
  }
}
