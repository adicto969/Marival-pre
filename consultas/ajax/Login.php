<?php
if(!empty($_POST['user']) and !empty($_POST['pass'])){
  $bd = new ConexionM();
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $bd->__constructM();
  $sql = $bd->query("SELECT User, Permiso, ID, sudo, Dep FROM usuarios WHERE User = '$user' AND Pass = '$pass' LIMIT 1;");
  if($bd->rows($sql) > 0){
    $datos = $bd->recorrer($sql);
    $_SESSION['User'] = $datos[0];
    $_SESSION['Permiso'] = $datos[1];
    $_SESSION['IDUser'] = $datos[2];
    $_SESSION['Sudo'] = $datos[3];
    $_SESSION['Dep'] = $datos[4];
    $_SESSION['AYO_ACTUAL'] = $ayoA;
    $_SESSION['notiExcel'] = 0;
    $_SESSION['linkExcelN'] = "";
    $_SESSION['TN'] = 0;

    $file = fopen("log/log".date("d-m-Y").".txt", "a");
		fwrite($file, ":::::::::::::::::::::::LOGIN:::::::::::::::::::::::".PHP_EOL);
		fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - SE HA LOGEADO EL USUARIO: '.$user.PHP_EOL);
		fclose($file);

    $sql = $bd->query("SELECT DB, IDEmpresa FROM config WHERE IDUser = '$datos[2]' LIMIT 1;");
    if($bd->rows($sql) > 0){
      $datos = $bd->recorrer($sql);
      $_SESSION['DB'] = $datos[0];
      $_SESSION['ID_EMPRESA'] = $datos[1];
      $IDEmpresaC = $datos[1];
    }

    $carpetaE = Unidad."E".$IDEmpresaC;
    if(!file_exists($carpetaE)){
      mkdir($carpetaE, 0777, true);
    }

    $carpetaQ = Unidad."E".$IDEmpresaC.'\quincenal';
    if(!file_exists($carpetaQ)){
      mkdir($carpetaQ, 0777, true);
    }

    $carpetapdf = Unidad."E".$IDEmpresaC.'\quincenal\pdf';
    if (!file_exists($carpetapdf)) {
        mkdir($carpetapdf, 0777, true);
    }

    $carpetaQxls = Unidad."E".$IDEmpresaC.'\quincenal\excel';
    if (!file_exists($carpetaQxls)) {
        mkdir($carpetaQxls, 0777, true);
    }

    $carpetaS = Unidad."E".$IDEmpresaC.'\semanal';
    if (!file_exists($carpetaS)) {
        mkdir($carpetaS, 0777, true);
    }

    $carpetaSpdf = Unidad."E".$IDEmpresaC.'\semanal\pdf';
    if (!file_exists($carpetaSpdf)) {
        mkdir($carpetaSpdf, 0777, true);
    }

    $carpetaSxls = Unidad."E".$IDEmpresaC.'\semanal\excel';
    if (!file_exists($carpetaSxls)) {
        mkdir($carpetaSxls, 0777, true);
    }

    echo 1;
  }else {
    echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Las credenciales son incorrectas !</h6></div>';
  }
  $bd->liberar($sql);
  $bd->close();
}else {
  echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Todos los datos deben estar llenos !</h6></div>';
}

?>
