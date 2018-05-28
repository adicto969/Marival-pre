<?php

$bdM = new ConexionM();
$bdM->__constructM();


echo '
<table class="highlight centered">
  <thead class="teal accent-3">
    <tr>
      <th>Estado</th>
      <th>Contactos</th>
    </tr>
  </thead>
  <tbody>';

$queryM2 = $bdM->query("SELECT User, ID FROM usuarios WHERE User != 'sudo' AND ID != ".$_SESSION['IDUser'].";");

while($datos = $bdM->recorrer($queryM2)){
    $valor = $datos[0];
    echo '
    <tr>
      <td onclick="userID('.$datos[1].', \''.$valor.'\')"><i class="small material-icons" style="color: yellowgreen">perm_identity</i></td>
      <td>'.$valor.'</td>
    </tr>
    ';
}
echo '
  </tbody>
</table>
';

$bdM->close();

?>
