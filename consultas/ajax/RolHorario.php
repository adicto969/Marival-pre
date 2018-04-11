<?php

$ihidden = "";
$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$resultV = array();
$resultV['TotalRegistros'] = 0;
$resultV['paginas'] = 0;
$resultV['error'] = 0;
$resultV['contenido'] = "";
$resultV['NumeroResultado'] = 0;
$resultV['query'] = "";

$pagina = $_POST['pagina'];
$cantidadXpagina = $_POST['cantidadXpagina'];
$ordernar = $_POST["order"];
$busqueda = "";
$busquedaV = "";

if(isset($_POST['buscar'])){
  if(!empty($_POST['buscar'])){
    $busqueda = "AND (E.codigo LIKE '%".$_POST['buscar']."%'";
    $busqueda .= " OR E.ap_paterno LIKE '%".$_POST['buscar']."%'";
    $busqueda .= " OR E.ap_materno LIKE '%".$_POST['buscar']."%'";
    $busqueda .= " OR E.nombre LIKE '%".$_POST['buscar']."%')";
    $busquedaV = $_POST['buscar'];
  }
}

if($DepOsub == 1)
{
  $complemento = "LEFT (l.centro, ".$MascaraEm.") = LEFT ('".$centro."', ".$MascaraEm.")";
  $querySQL = "[dbo].[roldehorarioEmp]
              '".$IDEmpresa."',
              '".$centro."',
              '1'";

}else {
  $complemento = "l.centro = '".$centro."'";
  $querySQL = "[dbo].[roldehorarioEmp]
              '".$IDEmpresa."',
              '".$centro."',
              '0'";

}
if($cantidadXpagina == 'TODO'){
  $complementoF = "";
  $cantidadXpagina = 1;
}else {
  $complementoF = "WHERE ROW_NUM BETWEEN (".$pagina." - 1) * ".$cantidadXpagina." + 1 AND (".$pagina." - 1) * ".$cantidadXpagina." + ".$cantidadXpagina;
}


$querySQL = "
SELECT
  codigo,
  nomE,
  Horario,
  Nombre,
  LUN,
  MAR,
  MIE,
  JUE,
  VIE,
  SAB,
  DOM,
  TOTAL_REGISTROS,
  CEILING(TOTAL_REGISTROS / ".$cantidadXpagina.".0) AS PAGINA
FROM (
  SELECT
    ROW_NUMBER() OVER (ORDER BY codigo) AS ROW_NUM,
    codigo,
    nomE,
    Horario,
    Nombre,
    [LUN],
    [MAR],
    [MIE],
    [JUE],
    [VIE],
    [SAB],
    [DOM],
    TOTAL_REGISTROS
  FROM
    ( SELECT
        E.codigo,
        E.ap_paterno+' '+E.ap_materno+' '+E.nombre AS nomE,
        l.horario,
        k.nombre,
        x.nombre_dia,
        (CASE WHEN entra1 = '' THEN 'DESCANSO' ELSE x.entra1 +' A '+ x.sale1 END) AS Hora,
        (
          SELECT COUNT(E.codigo)
          FROM empleados AS E
          INNER JOIN Llaves AS l ON l.codigo = E.codigo AND l.empresa = E.empresa

          WHERE  ".$complemento." AND l.empresa = '".$IDEmpresa."' AND E.activo= 'S'
          ".$busqueda."
        ) AS TOTAL_REGISTROS

    FROM empleados AS E
    INNER JOIN Llaves AS l ON l.codigo = E.codigo AND l.empresa = E.empresa
    LEFT JOIN horarios_catalogo AS k ON k.horario = l.horario AND k.empresa = l.empresa
    LEFT JOIN detalle_horarios AS x ON x.horario = k.horario AND l.empresa = k.empresa

    WHERE  ".$complemento." AND l.empresa = '".$IDEmpresa."' AND E.activo= 'S'
    ".$busqueda."

  ) x
    pivot
  (
    min(Hora)
    for nombre_dia in ([LUN], [MAR], [MIE], [JUE], [VIE], [SAB], [DOM])
  )q

) AS X
".$complementoF."
ORDER BY ".$ordernar."
";

$numCol = $objBDSQL->obtenfilas($querySQL);
if($numCol['error'] == 1){
  $file = fopen("log/log".date("d-m-Y").".txt", "a");
	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['SQLSTATE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['CODIGO'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$numCol['MENSAJE'].PHP_EOL);
	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$querySQL.PHP_EOL);
	fclose($file);
	$resultV['error'] = 1;
	echo json_encode($resultV);
	/////////////////////////////
	$objBDSQL->cerrarBD();
	exit();
}

if($numCol['cantidad'] > 0){

  $resultV['contenido'] .= '
  <div style="display:flex;width: auto;float: right;border: 1px solid rgba(0, 0, 0, .2);">
    <div onclick="ant();" style="padding: 10px 13px 0px 13px;border-right: 1px solid rgba(0, 0, 0, 0.2);cursor: pointer;"><i class="material-icons">chevron_left</i></div>
    <div style="padding: 10px 13px 0 13px;" id="paginador">1 de 10</div>
    <div onclick="sig();" style="padding: 10px 13px 0px 13px;border-left: 1px solid rgba(0,0,0,.2);cursor: pointer;"><i class="material-icons">chevron_right</i></div>
  </div>
  <a class="dropdown-button btn" id="down-ver" data-beloworigin="true" data-activates="ver" style="float: right; background-color: white; color: black;box-shadow:  none !important;border: 1px solid rgba(0, 0, 0, .2);padding-bottom: 39px;">
    Ver
    <i class="large material-icons">arrow_drop_down</i>
  </a>
  <ul id="ver" class="dropdown-content" style="min-width: 10px !important;">
    <li><a onclick="Mostrarcanti(20)">20</a></li>
    <li><a onclick="Mostrarcanti(50)">50</a></li>
    <li><a onclick="Mostrarcanti(100)">100</a></li>
    <li><a onclick="Mostrarcanti(300)">300</a></li>
    <li><a onclick="Mostrarcanti(500)">500</a></li>
    <li><a onclick="Mostrarcanti(\'TODO\')">Todos</a></li>
  </ul>
  <a class="dropdown-button btn" id="down-orden" data-beloworigin="true" data-activates="order" style="float: right; background-color: white; color: black;box-shadow:  none !important;border: 1px solid rgba(0, 0, 0, .2);padding-bottom: 39px;">
    Ordernar
    <i class="large material-icons">arrow_drop_down</i>
  </a>
  <ul id="order" class="dropdown-content" style="min-width: 10px !important;">
    <li><a onclick="Ordernar(\'codigo\')">Codigo</a></li>
    <li><a onclick="Ordernar(\'nomE\')">Nombre</a></li>
  </ul>
  <div class="input-field col s6" style="max-width: 211px;margin-left: 20px;">
    <input id="buscarV" type="text" class="validate" style="width: 164px; padding-top: 5px" value="'.$busquedaV.'">
    <i class="material-icons prefix" onclick="busquedaF()" style="line-height: 39px;text-align: center;border: 1px solid rgba(0, 0, 0, .2);cursor:pointer;">search</i>
  </div>

  <form id="frmRol" method="POST">
      <input type="hidden" name="centro" value="'.$centro.'" >
      <table id="tRH" class="responsive-table striped highlight centered" style="border: 1px solid #000080;">
      <thead>
        <tr>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Codigo</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Nombre</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Horario</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Descripcion</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Lunes</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Martes</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Miercoles</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Jueves</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Viernes</th>
             <th style="border-right: 1px solid black; background-color: #0091ea; color: white; border-bottom: 1px solid #696666;">Sabado</th>
             <th style="background-color: #0091ea; color: white;">Domingo</th>
         </tr>
       </thead><tbody>';
  $resultado = $objBDSQL->consultaBD($querySQL);
  if($resultado['error'] == 1){
    $file = fopen("log/log".date("d-m-Y").".txt", "a");
  	fwrite($file, ":::::::::::::::::::::::ERROR SQL:::::::::::::::::::::::".PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['SQLSTATE'].PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['CODIGO'].PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - '.$resultado['MENSAJE'].PHP_EOL);
  	fwrite($file, '['.date('d/m/Y h:i:s A').']'.' - CONSULTA: '.$querySQL.PHP_EOL);
  	fclose($file);
  	$resultV['error'] = 1;
  	echo json_encode($resultV);
  	/////////////////////////////
  	$objBDSQL->cerrarBD();
  	exit();
  }

  $lr = 0;
  while ( $row = $objBDSQL->obtenResult() )
  {
    $lr++;
    $resultV['TotalRegistros'] = $row["TOTAL_REGISTROS"];
    $resultV['paginas'] = $row["PAGINA"];
    if($row["TOTAL_REGISTROS"] == $row["PAGINA"]){
      $resultV['paginas'] = 1;
    }

    $resultV['NumeroResultado']++;

    $ihidden .= '<input type="hidden" name="c'.$lr.'" value="'.$row["codigo"].'">';
    $resultV['contenido'] .= '<tr>
          <td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" >'.$row["codigo"].'</td>
          <td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" >'.utf8_encode($row["nomE"]).'</td>
          <td style="text-align: center; border-left: 1px solid #696666; border-bottom: 1px solid #696666;">
            <div onclick="cambiar'.$lr.'()" class="controlgroup">
              <input style="width: 100%; margin: 0;"  min="1" class="ui-spinner-input" value ="'.$row["Horario"].'" name="inp'.$lr.'" id="'.$lr.'" onclick="cambiar'.$lr.'()">
            </div>
          </td>
          <td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;"  id="des'.$lr.'">'.utf8_encode($row["Nombre"]).'</td>
          ';
          if($row["LUN"] == "DESCANSO"){
              $resultV['contenido'] .= '<td style="background-color: #f9ff00; border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="l'.$lr.'">'.$row["LUN"].'</td>';
          }else {
              $resultV['contenido'] .= '<td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="l'.$lr.'">'.$row["LUN"].'</td>';
          }

          if($row["MAR"] == "DESCANSO"){
              $resultV['contenido'] .= '<td style="background-color: #f9ff00; border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="m'.$lr.'">'.$row["MAR"].'</td>';
          }else {
              $resultV['contenido'] .= '<td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="m'.$lr.'">'.$row["MAR"].'</td>';
          }

          if($row["MIE"] == "DESCANSO"){
              $resultV['contenido'] .= '<td style="background-color: #f9ff00; border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="i'.$lr.'">'.$row["MIE"].'</td>';
          }else {
              $resultV['contenido'] .= '<td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="i'.$lr.'">'.$row["MIE"].'</td>';
          }

          if($row["JUE"] == "DESCANSO"){
              $resultV['contenido'] .= '<td style="background-color: #f9ff00; border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="j'.$lr.'">'.$row["JUE"].'</td>';
          }else {
              $resultV['contenido'] .= '<td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="j'.$lr.'">'.$row["JUE"].'</td>';
          }

          if($row["VIE"] == "DESCANSO"){
              $resultV['contenido'] .= '<td style="background-color: #f9ff00; border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="v'.$lr.'">'.$row["VIE"].'</td>';
          }else {
              $resultV['contenido'] .= '<td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="v'.$lr.'">'.$row["VIE"].'</td>';
          }

          if($row["SAB"] == "DESCANSO"){
              $resultV['contenido'] .= '<td style="background-color: #f9ff00; border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="s'.$lr.'">'.$row["SAB"].'</td>';
          }else {
              $resultV['contenido'] .= '<td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="s'.$lr.'">'.$row["SAB"].'</td>';
          }

          if($row["DOM"] == "DESCANSO"){
              $resultV['contenido'] .= '<td style="background-color: #f9ff00; border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="d'.$lr.'">'.$row["DOM"].'</td>';
          }else {
              $resultV['contenido'] .= '<td style="border-left: 1px solid #696666; border-bottom: 1px solid #696666;" id="d'.$lr.'">'.$row["DOM"].'</td>';
          }

          $resultV['contenido'] .= '</tr>';
    }
  $resultV['contenido'] .= '</tbody></table><input type="hidden" name="cantidad" value="'.$lr.'">'.$ihidden.'</form>';
  $resultV['contenido'] .= '<button class="waves-effect waves-light btn" style="margin: 10px;" onclick="Rol()">GUARDAR</button>';
  $resultV['query'] .= '<script type="text/javascript">';


  for($jh=1; $jh<=$lr; $jh++){

  $resultV['query'] .= 'function cambiar'.$jh.'() {
  var numero;
  numero = document.getElementById("'.$jh.'").value;

  numero = Number(numero);

  switch (numero) {
  ';
  for ($j=1; $j<=$iDH; $j++){


    $resultV['query'] .= '
    case '.$j.':
        document.getElementById("des'.$jh.'").innerHTML = "'.$DesHora[$j].'";
        document.getElementById("l'.$jh.'").innerHTML = "'.$Lun[$j].'";';
        if($Lun[$j] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("l'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("l'.$jh.'").style.background = \'#ffffff\';';
        }

    $resultV['query'] .= 'document.getElementById("m'.$jh.'").innerHTML = "'.$Mar[$j].'";';

        if($Mar[$j] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("m'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("m'.$jh.'").style.background = \'#ffffff\';';
        }

    $resultV['query'] .= 'document.getElementById("i'.$jh.'").innerHTML = "'.$Mie[$j].'";';

        if($Mie[$j] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("i'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("i'.$jh.'").style.background = \'#ffffff\';';
        }

    $resultV['query'] .= 'document.getElementById("j'.$jh.'").innerHTML = "'.$Jue[$j].'";';

        if($Jue[$j] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("j'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("j'.$jh.'").style.background = \'#ffffff\';';
        }
    $resultV['query'] .= 'document.getElementById("v'.$jh.'").innerHTML = "'.$Vie[$j].'";';

        if($Vie[$j] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("v'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("v'.$jh.'").style.background = \'#ffffff\';';
        }
    $resultV['query'] .= 'document.getElementById("s'.$jh.'").innerHTML = "'.$Sab[$j].'";';

        if($Sab[$j] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("s'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("s'.$jh.'").style.background = \'#ffffff\';';
        }

    $resultV['query'] .= 'document.getElementById("d'.$jh.'").innerHTML = "'.$Dom[$j].'";';

        if($Dom[$j] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("d'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("d'.$jh.'").style.background = \'#ffffff\';';
        }

    $resultV['query'] .= ' break;';


    }
    $resultV['query'] .= '
    default: alert ("Horario no valido");
        document.getElementById("des'.$jh.'").innerHTML = "'.$DesHora[1].'";
        document.getElementById("l'.$jh.'").innerHTML = "'.$Lun[1].'";';

        if($Lun[1] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("l'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("l'.$jh.'").style.background = \'#ffffff\';';
        }
        $resultV['query'] .= 'document.getElementById("m'.$jh.'").innerHTML = "'.$Mar[1].'";';

        if($Mar[1] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("m'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("m'.$jh.'").style.background = \'#ffffff\';';
        }

    $resultV['query'] .= 'document.getElementById("i'.$jh.'").innerHTML = "'.$Mie[1].'";';

        if($Mie[1] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("i'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("i'.$jh.'").style.background = \'#ffffff\';';
        }

    $resultV['query'] .= 'document.getElementById("j'.$jh.'").innerHTML = "'.$Jue[1].'";';

        if($Jue[1] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("j'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("j'.$jh.'").style.background = \'#ffffff\';';
        }
    $resultV['query'] .= 'document.getElementById("v'.$jh.'").innerHTML = "'.$Vie[1].'";';

        if($Vie[1] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("v'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("v'.$jh.'").style.background = \'#ffffff\';';
        }
    $resultV['query'] .= 'document.getElementById("s'.$jh.'").innerHTML = "'.$Sab[1].'";';

        if($Sab[1] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("s'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("s'.$jh.'").style.background = \'#ffffff\';';
        }

    $resultV['query'] .= 'document.getElementById("d'.$jh.'").innerHTML = "'.$Dom[1].'";';

        if($Dom[1] == "DESCANSO"){
            $resultV['query'] .= 'document.getElementById("d'.$jh.'").style.background = \'#f9ff00\';';
        }else {
            //echo 'document.getElementById("d'.$jh.'").style.background = \'#ffffff\';';
        }


    $resultV['query'] .= '
    document.getElementById("'.$jh.'").value = "1";
    break;

    }
    };
    ';

  }
  $resultV['query'] .= '</script>';
}else {
    //echo 'No se encontraron resultados';
    $resultV['contenido'] .= '<div style="width: 100%" class="deep-orange accent-4"><h6 class="center-align" style="padding-top: 5px; padding-bottom: 5px; color: white;">No se encotro resultado !</h6></div>';
}
echo json_encode($resultV);
$objBDSQL->cerrarBD();
?>
