<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <base href="<?php echo URL_PAGINA ?>">
    <title>Prenomina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/materialize.css" type="text/css" media="screen,projection">
    <link rel="stylesheet" type="text/css" href="css/ajustes.css">
    <script src="js/jquery.js" charset="utf-8"></script>
    <script src="js/jquery-uiN.js"></script>
    <script src="js/theadFija.js"></script>
    <link href="js/jquery-ui.css" rel="stylesheet">
    <link href="css/font.css" rel="stylesheet" type="text/css">
    <style>
      input:invalid {
        background-color: #dd2c00;
      }
    </style>
  </head>
  <body>
    <?php echo $MenuG; ?>
    <nav role="navigation">
      <div class="container">
        <div class="nav-wrapper">
            <ul class="left">
                <a href="#" data-activates="slide-out" class="button-menu2"><i class="material-icons" style="font-size: 52px;">menu</i></a>
            </ul>
        <a class="brand-logo hide-on-med-and-down" id="NEmpresa" style="width: 76%; font-size: 1.4rem; text-align: center;"><?php echo $NombreEmpresa; ?></a>
        <ul id="nav-mobile" class="right">
          <li><a class="dropdown-button" data-activates='dropdown1'><i class="material-icons" style="font-size: 30px;" id="alerta">add_alert</i></a></li>
        </ul>
      </div>
      </div>
    </nav>
    <ul id='dropdown1' class='dropdown-content' style="width: 232px;">

    </ul>
