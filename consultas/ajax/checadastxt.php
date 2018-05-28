<?php
require_once('librerias/Classes/PHPExcel.php');
require_once('librerias/Classes/PHPExcel/IOFactory.php');
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();
$objBDSQL2 = new ConexionSRV();
$objBDSQL2->conectarBD();
$NoInsertados = array();
$arcNoinsertaron = "NoInsertaron.txt";
$contarExito = 0;
$contarError = 0;
$extension = substr($_FILES['Archivo']['name'][0], -3);
$error =  $_FILES['Archivo']['error'][0];

if($error == 0){
  if(substr($_FILES['Archivo']['name'][0], 0, 12) == substr($arcNoinsertaron, 0, 12)){
    move_uploaded_file($_FILES['Archivo']['tmp_name'][0], 'img/' . 'NoInsertaron.txt');
    //echo "<script>alert('El archivo es de revicion');</script>";
    $ArchivoTxt0 = fopen("img/NoInsertaron.txt", "r");
    while(!feof($ArchivoTxt0)){
      $linea = fgets($ArchivoTxt0);
      $lnk = explode(",", $linea);

      if(isset($lnk[1])){
        $consulta = "SELECT L.empresa
                     FROM Llaves AS L
                     INNER JOIN empleados AS E ON E.codigo = L.codigo
                     WHERE L.codigo = ".$lnk[1]." AND E.activo = 'S'";

        $resultado = $objBDSQL->consultaBD($consulta);
        $datos = $objBDSQL->obtenResult();
        if(!empty($datos)){
          $NumEmpresa = $datos['empresa'];
          $FLNK = str_replace('-', '', $lnk[2]);
          //$checadaEntrada = "ObtenRelojDatosEmps ".$NumEmpresa.", ".$lnk[1].", ".$FLNK.", ".$lnk[3].", 'N', ' ', ' '";
          $checadaEntrada = "ObtenRelojDatosEmps 2, ".$lnk[1].", ".$FLNK.", ".$lnk[3].", 'N', ' ', ' '";
          try {
            $insertChecada = $objBDSQL2->consultaBD2($checadaEntrada);
            $contarExito++;
          } catch (Exception $e){
            var_dump($e->getMessage());
            $contarError++;
          }

        }else {
          $NoInsertados[$lnk[1].$lnk[2].$lnk[3]] = "ObtenRelojDatosEmps X, ".$lnk[1].", ".$lnk[2].", ".$lnk[3].", N,  ,  ";
          $contarError++;
        }
        $objBDSQL->liberarC();
      }

    }

    echo "SE IMPORTARON ".$contarExito." REGISTROS EXITOSAMENTE";
    echo "<br>";
    if(count($NoInsertados)>0){
      $file = fopen($arcNoinsertaron, "w") or die("Error al abrir el archivo");
      echo "NO SE INPORTARON ALGUNOS REGISTROS(".$contarError.") (cambiar la 'X' por el numero de empresa) <a href='".$arcNoinsertaron."' download='".$arcNoinsertaron."'>Descargar Archivo</a>";
      echo "<br>";

      foreach ($NoInsertados as $Valor) {
        fwrite($file, $Valor.PHP_EOL);
      }
      fclose($file);
    }

  }else {
    if($extension == 'txt'){
      move_uploaded_file($_FILES['Archivo']['tmp_name'][0], 'img/' . 'checadas.txt');
      $ArchivoTxt0 = fopen("img/checadas.txt", "r");

      while(!feof($ArchivoTxt0)){
        $linea = fgets($ArchivoTxt0);
        $ln = trim($linea);
        //echo $ln."<br>";
        //$lnk = explode("\t", $ln); ///ARCHIVO DE AYUNTAMIENTO
        $lnk = explode(",", $ln);
        $array = array();

        for ($i=0; $i < count($lnk); $i++) {
          $array[$i] = $lnk[$i];
        //echo $lnk[$i]."<br>";
        }

        if(isset($array[1]) && isset($array[0])){

          $ln1 = explode(" ", $array[1]);

          $consulta = "SELECT L.empresa
             FROM Llaves AS L
             INNER JOIN empleados AS E ON E.codigo = L.codigo
             WHERE L.codigo = ".$array[0]." AND E.activo = 'S'";

          $resultado = $objBDSQL->consultaBD($consulta);
          $datos = $objBDSQL->obtenResult();
          if(!empty($datos)){
            //$NumEmpresa = $datos['empresa'];
            $FLNK = str_replace('/', '', $ln1[0]);
            //$checadaEntrada = "ObtenRelojDatosEmps ".$NumEmpresa.", ".$array[0].", '".$FLNK."', '".$ln1[1]."', 'N', ' ', ' '";
            $checadaEntrada = "ObtenRelojDatosEmps 2, ".$array[0].", '".$FLNK."', '".$ln1[1]."', 'N', ' ', ' '";
            try {
              $insertChecada = $objBDSQL2->consultaBD2($checadaEntrada);
              $contarExito++;
            } catch (Exception $e){
              var_dump($e->getMessage());
              $contarError++;
            }

          }else {
            $NoInsertados[$array[0].$ln1[0].$ln1[1]] = "ObtenRelojDatosEmps X, ".$array[0].", ".$ln1[0].", ".$ln1[1].", N,  ,  ";
            $contarError++;
          }
          $objBDSQL->liberarC();
        }

      }
      echo "SE IMPORTARON ".$contarExito." REGISTROS EXITOSAMENTE";
      echo "<br>";
      if(count($NoInsertados)>0){
        $file = fopen($arcNoinsertaron, "w") or die("Error al abrir el archivo");
        echo "NO SE INPORTARON ALGUNOS REGISTROS(".$contarError.") (cambiar la 'X' por el numero de empresa) <a href='".$arcNoinsertaron."' download='".$arcNoinsertaron."'>Descargar Archivo</a>";
        echo "<br>";

        foreach ($NoInsertados as $Valor) {
          fwrite($file, $Valor.PHP_EOL);
        }
        fclose($file);
      }
    }else {
      ///EXCEL
      move_uploaded_file($_FILES['Archivo']['tmp_name'][0], 'img/' . 'checadas.xls');
      $objPHPExcel = new PHPExcel();
      $objReader = PHPExcel_IOFactory::createReader('Excel5');
      $objPHPExcel = $objReader->load("img/checadas.xls");
      $sheet = $objPHPExcel->getSheet(0);
      $totalFilas = $sheet->getHighestRow();

      for($FILA = 2; $FILA <= $totalFilas; $FILA++ ){
          $codigo =  $sheet->getCell('A'.$FILA)->getValue();
          $Dfecha =  $sheet->getCell('B'.$FILA)->getValue();
          $dep = $sheet->getCell('C'.$FILA)->getValue();

          $Dfecha = explode(" ", $Dfecha);
          $Dfecha[0] = explode("/", $Dfecha[0]);
		  $mesNum = 00;
		  if($Dfecha[0][1] == 'ene'){
			$mesNum = 01;  
		  }else if($Dfecha[0][1] == 'feb'){
			  $mesNum = 02;
		  }else if($Dfecha[0][1] == 'mar'){
			  $mesNum = 03;
		  }else if($Dfecha[0][1] == 'abr'){
			  $mesNum = 04;
		  }else if($Dfecha[0][1] == 'may'){
			  $mesNum = 05;
		  }else if($Dfecha[0][1] == 'jun'){
			  $mesNum = 06;
		  }else if($Dfecha[0][1] == 'jul'){
			  $mesNum = 07;
		  }else if($Dfecha[0][1] == 'ago'){
			  $mesNum = 08;
		  }else if($Dfecha[0][1] == 'sep'){
			  $mesNum = 09;
		  }else if($Dfecha[0][1] == 'oct'){
			  $mesNum = 10;
		  }else if($Dfecha[0][1] == 'nov'){
			  $mesNum = 11;
		  }else if($Dfecha[0][1] == 'dic'){
			  $mesNum = 12;
		  }
		  
          $Dfecha[0] = $Dfecha[0][2].$mesNum.$Dfecha[0][0];

          $consulta = "SELECT L.empresa
             FROM Llaves AS L
             INNER JOIN empleados AS E ON E.codigo = L.codigo
             WHERE L.codigo = ".$codigo." AND E.activo = 'S'";

          $resultado = $objBDSQL->consultaBD($consulta);
          $datos = $objBDSQL->obtenResult();
          if(!empty($datos)){
            // ObtenRelojDatosEmps @empresa, @codigo, @fecha, @hora, @comedor, @row1, @row2
            $checadaEntrada = "ObtenRelojDatosEmps 2, ".$codigo.", '".$Dfecha[0]."', '".$Dfecha[2].':00'."', 'N', ' ', ' '";
            try {
              $insertChecada = $objBDSQL2->consultaBD2($checadaEntrada);
              $contarExito++;
            } catch (Exception $e){
              var_dump($e->getMessage());
              $contarError++;
            }

          }else {
            $NoInsertados[$codigo.$Dfecha[0].$Dfecha[2]] = "ObtenRelojDatosEmps X, ".$codigo.", ".$Dfecha[0].", ".$Dfecha[2].':00'.", N,  ,  ";
            $contarError++;
          }
          $objBDSQL->liberarC();
      }

      echo "SE IMPORTARON ".$contarExito." REGISTROS EXITOSAMENTE";
      echo "<br>";

      if(count($NoInsertados)>0){
        $file = fopen($arcNoinsertaron, "w") or die("Error al abrir el archivo");

        foreach ($NoInsertados as $Valor) {
          fwrite($file, $Valor.PHP_EOL);
        }
        fclose($file);

        echo "NO SE INPORTARON ALGUNOS REGISTROS(".$contarError.") (cambiar la 'X' por el numero de empresa) <a href='".$arcNoinsertaron."' download='".$arcNoinsertaron."'>Descargar Archivo</a>";
        echo "<br>";
      }

    }
  }

  echo "<br>";
  echo "<br>";
  echo "<br>";

  //echo "<h3 class='center'>El archivos se ha subidos correctamente</h3>";
}else {
  echo "<h3 class='center'>Error al subir el archivo</h3>";
}

try{
  $objBDSQL->cerrarBD();
  $objBDSQL2->cerrarBD();
}catch(Exception $e){
  echo "Error con la BD: ".$e;
}

?>
