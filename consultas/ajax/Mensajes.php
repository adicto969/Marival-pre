<?php
$bdM = new ConexionM();
$bdM->__constructM();
$IDUser = $_SESSION['IDUser'];
$IDdestino = $_POST['UserChat'];

$consulta = "SELECT IDUserDe, Mensaje, fecha FROM chat WHERE (IDUserDe = $IDUser OR IDUserDe = $IDdestino) AND (IDUserPara = $IDdestino OR IDUserPara = $IDUser) ORDER BY Fecha  LIMIT 100;";


$query = $bdM->query($consulta);

if(!empty($IDdestino)){
  while($datos = $bdM->recorrer($query)){
      $IDUserDe = $datos[0];
      $Mensaje = $datos[1];
      $fecha = $datos[2];
      $fechaM = new DateTime($fecha);
      if($IDUserDe == $IDUser){
        echo '
          <div class="col s12 right-align">
            <p class="chip" style="border-radius: 16px 25px 0px 16px; background-color: #76b4f2; color: white; line-height: 20px; padding: 3px 18px;">
              '.$Mensaje.'
              <span style="font-size: 11px">'.$fechaM->format('d/m/Y H:i:s').'</span>
            </p>
          </div>
        ';
      }else {
        echo '
          <div class="col s12 left-align" >
            <p class="chip" style="border-radius: 25px 16px 16px 1px; line-height: 20px; padding: 3px 18px;">
              '.$Mensaje.'
              <span style="font-size: 11px">'.$fechaM->format('d/m/Y H:i:s').'</span>
            </p>
          </div>
        ';
      }

  }
}else {
  echo "Seleccione un usuario";
}
echo "<br/>";

$bdM->close();



?>
