<?php
$bdM = new ConexionM();
$bdM->__constructM();
$IDNoti = $_POST['IDNotifi'];

$Minsert = 'UPDATE notificaciones SET Estatus = 1 WHERE ID = '.$IDNoti.';';
$bdM->query($Minsert);
echo $Minsert;

?>
