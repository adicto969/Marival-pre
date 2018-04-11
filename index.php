<?php
$MenuG = "";
require_once('config/config.php');

if(isset($_SESSION['IDUser'])){
  require_once("html/General/nav.php");
}

require_once ("html/General/header.php");
UserLogeado();

if(isset($_SESSION['IDUser'])){
  require_once("html/General/nav.php");
  //if($_SESSION['Permiso'] == 1 || $_SESSION['Sudo'] == 1){

    if(isset($_GET['pagina'])){
      if($_GET['pagina'] != 'Cerrar.php'){
        require_once("html/General/Config.php");
      }
    }

  //}
}

if(isset($_GET['pagina'])){
  if(strtolower($_GET['pagina']) == "login.html"){
    require_once('html/General/'.strtolower($_GET['pagina']));
  }else {
    if(strtolower($_GET['pagina']) == "cerrar.php"){
      require_once('consultas/usuarios/'.strtolower($_GET['pagina']));
    }else {
      if(file_exists('html/'.strtolower($_GET['pagina']))){

        if(isset($_SESSION['Sudo'])){
          if($_SESSION['Sudo'] == 1)
          {
              if(strtolower($_GET['pagina']) != "tiempoextra.php"){
                  require_once('html/'.strtolower($_GET['pagina']));
              }else {
                require_once('html/index.php');
              }

          }else {
            if($_SESSION["Dep"] == 1){
              switch (strtolower($_GET['pagina'])) {
                case 'login.html':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'rolhorario.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'ajusteempleados.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'tasistencia.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'permiso.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'pdom.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'dlaborados.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                //case 'tiempoextra.php':
                  //require_once('html/'.strtolower($_GET['pagina']));
                //break;
                case 'celular.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'staffin.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'chat.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'archivos.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'cerrar.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
		            case 'conceptoextra.php':
		              require_once('html/'.strtolower($_GET['pagina']));
		            break;
                default:
                  require_once('html/index.php');
                break;
              }
            }else if($_SESSION["Dep"] == 34){
              switch (strtolower($_GET['pagina'])) {
                case 'login.html':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'rolhorario.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'tasistencia.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'permiso.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'chat.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'archivos.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'cerrar.php.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                default:
                  require_once('html/index.php');
                  break;
              }
            }else if($_SESSION["Dep"] == 2){
              switch (strtolower($_GET['pagina'])) {
                case 'login.html':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'contrato.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
            		case 'destajo.php':
            		  require_once('html/'.strtolower($_GET['pagina']));
            		break;
            		//case 'tiempoextra.php':
            		  //require_once('html/'.strtolower($_GET['pagina']));
            		//break;
                case 'contratovencer.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'rolhorario.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'tasistencia.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'permiso.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'celular.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'chat.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'archivos.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'cerrar.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
            		case 'conceptoextra.php':
            		  require_once('html/'.strtolower($_GET['pagina']));
            		break;
                default:
                  require_once('html/index.php');
                  break;
              }
            }else if($_SESSION["Dep"] == 3){
              switch (strtolower($_GET['pagina'])) {
                case 'login.html':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'contrato.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'formatospdf.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'contratovencer.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'staffin.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'chat.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'archivos.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'cerrar.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                default:
                  require_once('html/index.php');
                break;
              }
            }else if($_SESSION["Dep"] == 4){
              switch (strtolower($_GET['pagina'])) {
                case 'login.html':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'celular.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;
                case 'cerrar.php':
                  require_once('html/'.strtolower($_GET['pagina']));
                break;

                default:
                  require_once('html/index.php');
                break;
              }
            }
          }
        }

      }else {
        require_once('html/General/ErrorHTML.php');
      }
    }
  }
} else {
  require_once('html/index.php');
}

require_once ("html/General/footer.php");
?>
