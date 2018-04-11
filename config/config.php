<?php

session_start();

//date_default_timezone_set('America/Mazatlan'); //una hora menos
date_default_timezone_set('America/Bahia_Banderas'); //misma hora
//date_default_timezone_set('Etc/GMT+5');//una hora mas
//date_default_timezone_set('America/Mexico_City');

#Constantes de Conexion MYSQL
define('M_DB_SERVER', 'localhost');
define('M_DB_USER', 'root');
define('M_DB_PASS', '');
define('M_DB_NOMBRE', 'faltascabos');

#Constantes de Conexion SQLSERVER
define('S_DB_SERVER', 'DESKTOP-2POHOQ5\\JUAN2017');
define('S_DB_USER', 'sa');
define('S_DB_PASS', 'Enterprice9');
define('S_DB_NOMBRE', 'NUEVA_EMPRESA');

define('Unidad', 'C:\\apsisistemas\\ARCHIVOS\\');
#Constantes de la App
define('HTML_DIR', 'html/');
define('TITULO_PAGINA', 'PRENOMINA');
define('FECHA_MODIFICACION', 'Ultima Actualización : 16/11/2017');
define('URL_PAGINA', 'http://localhost:8080/GitHub/General/PrenominaGeneral/');

define('Autoriza1', 'sudo');
define('Autoriza2', 'Nominas');

define('DepNumOrden', '1');///canto ///1 bahia
define('SupDepNumOrden', '2');

$abcd = array("AA", "AB", "AC", "AD", "AE", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
$MESES = array("", "ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");
$ayoA = 2017;
$formatoFecha = 'Y/m/d';
require_once('consultas/Class.Conexion.php');
require_once('consultas/ConGenerales.php');
require_once('consultas/usuarios/UserLogeado.php');
require_once('periodos.php');

?>
