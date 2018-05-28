<?php
if(empty($_POST["codigo"]))
{
	echo "No Ha Ingresado Un Codigo De Empleado \n";
	break;
}

if(empty($_POST["empresa"]))
{
	echo "No Ha Ingresado Un Codigo De Empleado \n";
	break;
}

if(empty($_POST["hora"]))
{
	echo "No Ha Ingresado Un Horario";
	break;
}


$code = $_POST["codigo"];
$desc = $_POST["empresa"];
$cantidadC = $_POST["cantidadC"];
$opcion = $_POST["opcion"];
$hora = $_POST["hora"];
$hora2 = $_POST["hora2"];

 $Jcodigos = file_get_contents("datos/empleados.json");
 $datos = json_decode($Jcodigos, true);


  switch ($opcion){
      case 'modificar':
          modificar($code, $cantidadC, $datos);
          break;

      case 'nuevo':
          nuevo($code, $desc, $cantidadC, $datos, $hora, $hora2);
          break;
  }


  function modificar($code, $cantidadC, $datos){

      for($j = 0; $j <= $cantidadC-1; $j++){
          if($datos["empleados"][$j]['codigo'] == $code && $datos["empleados"][$j]["estado"] == 1){

              $datos["empleados"][$j]["estado"] = 0;
              $fh = fopen("datos/empleados.json", 'w') or die("error al abrir el archivo");
              fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));
              fclose($fh);
              echo "Empleado Eliminado";
          }
      }
  }


  function nuevo($code, $desc, $cantidadC, $datos, $hora, $hora2){

      $datos["empleados"][$cantidadC]["codigo"] = $code;
      $fh = fopen("datos/empleados.json", 'w') or die("error al abrir el archivo");
      fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

      $datos["empleados"][$cantidadC]["empresa"] = $desc;
      $fh = fopen("datos/empleados.json", 'w') or die("error al abrir el archivo");
      fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

      $datos["empleados"][$cantidadC]["estado"] = 1;
      $fh = fopen("datos/empleados.json", 'w') or die("error al abrir el archivo");
      fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

      $datos["empleados"][$cantidadC]["hora"] = $hora;
      $fh = fopen("datos/empleados.json", 'w') or die("error al abrir el archivo");
      fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

			$datos["empleados"][$cantidadC]["hora2"] = $hora2;
      $fh = fopen("datos/empleados.json", 'w') or die("error al abrir el archivo");
      fwrite($fh, json_encode($datos, JSON_UNESCAPED_UNICODE));

      fclose($fh);
      echo "Empleado Agregado";
  }


?>
