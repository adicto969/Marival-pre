<?php

$code = $_POST["codigo"];
$desc = $_POST["descripcion"];
$cantidadC = $_POST["cantidadC"];
$opcion = $_POST["opcion"];


$Jcodigos = file_get_contents("codigos.json");
$datos = json_decode($Jcodigos, true);

switch ($opcion){
    case 'modificar':
        modificar($code, $desc, $cantidadC, $datos);
        break;

    case 'nuevo':
        nuevo($code, $desc, $cantidadC, $datos);
        break;

    case 'eliminar':
        eliminar($code, $desc, $cantidadC, $datos);
        break;

}

function eliminar($code, $desc, $cantidadC, $datos){

    for($j = 0; $j <= $cantidadC; $j++){
        if($datos["codigos"][$j]['codigo'] == $code){

            $datos["codigos"][$j]["estatus"] = 0;
            $fh = fopen("codigos.json", 'w') or die("error al abrir el archivo");
            fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));
            fclose($fh);

        }
    }
}

function modificar($code, $desc, $cantidadC, $datos){

    for($j = 0; $j <= $cantidadC; $j++){
        if($datos["codigos"][$j]['codigo'] == $code){

            $datos["codigos"][$j]["descripcion"] = $desc;
            $fh = fopen("codigos.json", 'w') or die("error al abrir el archivo");
            fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));
            fclose($fh);

        }
    }
}


function nuevo($code, $desc, $cantidadC, $datos){

    $datos["codigos"][$cantidadC]["codigo"] = $code;
    $fh = fopen("codigos.json", 'w') or die("error al abrir el archivo");
    fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

    $datos["codigos"][$cantidadC]["descripcion"] = $desc;
    $fh = fopen("codigos.json", 'w') or die("error al abrir el archivo");
    fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

    $datos["codigos"][$cantidadC]["estatus"] = 1;
    $fh = fopen("codigos.json", 'w') or die("error al abrir el archivo");
    fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

    fclose($fh);
    echo "Bien echo";
}


    /*$Jcodigos = file_get_contents("codigos.json");

    $datos = json_decode($Jcodigos, true);


    if($datos["codigos"][0]['codigo'] == 'F1'){
        $datos["codigos"][8]["codigo"] = 'G';

        $fh = fopen("codigos.json", 'w') or die("error al abrir el archivo");
        fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

        $datos["codigos"][8]["descripcion"] = 'Gastos';

        $fh = fopen("codigos.json", 'w') or die("error al abrir el archivo");
        fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

        fclose($fh);
    }else {
        echo "no es F";
    }

    //data[\'codigos\'][c].codigo



    echo "<br/><br/>";

    $palabras = json_decode($Jcodigos);

    foreach ($palabras as $palabras){
        /*$i = 0;
        print_r($palabras[$i]->codigo);
        $i++;*/
        /*for($a = 0; $a <= count($palabras)-1; $a++){
            print_r($palabras[$a]->codigo." - ".$palabras[$a]->descripcion);
            echo "<br/>";
        }
    }*/


?>
