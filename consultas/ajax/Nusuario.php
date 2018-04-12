<?php
$user = $_POST['user'];
$pass = $_POST['pass'];
$Spass = $_POST['Spass'];
$NEmpresa = $_POST['NEmpresa'];
$CDepto = $_POST['CDepto'];
$ADMIN = $_POST['admin'];
$AREA = $_POST['Area'];
$IDUser = "";
$bd1 = new ConexionM();
$bd1->__constructM();
$sql1 = $bd1->query("SELECT Permiso FROM usuarios WHERE Pass = '$Spass' and Permiso = 1 LIMIT 1;");
if($bd1->rows($sql1) > 0){
  $sql2 = $bd1->query("SELECT User FROM usuarios WHERE User = '$user' LIMIT 1;");
  if($bd1->rows($sql2) > 0){
    echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">El Usurio '.$user.' ya existe !</h6></div>';
  } else {
    $Insertar = "INSERT INTO usuarios VALUES (NULL, '$user', '$pass', '$ADMIN', '$AREA', 0);";
    if($bd1->query($Insertar)){
        $selectID = $bd1->query("SELECT ID FROM usuarios WHERE User = '$user' LIMIT 1;");
        $datosID = $bd1->recorrer($selectID);
        $IDUser = $datosID[0];
        $Server = str_replace("\\", "\\\\", S_DB_SERVER);
        $insertarConfig = "INSERT INTO config VALUES (NULL, '$Server', '$NEmpresa', '$CDepto', '".S_DB_NOMBRE."', '".S_DB_USER."', '".S_DB_PASS."', '$IDUser',1, 1, 1, 1, 5, '', 0, 0, 0);";
        if($bd1->query($insertarConfig)){
          echo "1";
          $bd1->close();
        }else {
            echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Erro al agregar la configuracion del usuario '.$user.'. ('.$bd1->error.')</h6></div>';            echo $insertarConfig;
        }
    }else {
      echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">Erro al agregar el usuario '.$user.'. ('.$bd1->error.')</h6></div>';
    }
  }
}else {
  echo '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">La Contraseña de Super Usuario no es correcta !</h6></div>';
}
?>
