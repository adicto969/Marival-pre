<?php

$bdM = new ConexionM();
$bdM->__constructM();
$bdS = constructS();

if($_POST["modo"] == 'Guardar'){
    for($ms=1; $ms <= $_POST["canMS"]; $ms++ ){
        $Minsert = "INSERT into staff_porcentaje values ( ".$IDEmpresa.", '".$ms.$_POST["C".$ms]."', 0, '".$centro."', '".$_POST["C".$ms]."', '".$_POST["A5".$ms]."', '".$_POST["A10".$ms]."', '".$_POST["A15".$ms]."', '".$_POST["A20".$ms]."', '".$_POST["A25".$ms]."', '".$_POST["A30".$ms]."', '".$_POST["A35".$ms]."', '".$_POST["A40".$ms]."', '".$_POST["A45".$ms]."', '".$_POST["A50".$ms]."', '".$_POST["A55".$ms]."', '".$_POST["A60".$ms]."', '".$_POST["A65".$ms]."', '".$_POST["A70".$ms]."', '".$_POST["A75".$ms]."', '".$_POST["A80".$ms]."', '".$_POST["A85".$ms]."', '".$_POST["A90".$ms]."', '".$_POST["A95".$ms]."', '".$_POST["A100".$ms]."')";

        $resRH = odbc_exec($bdS, $Minsert);

        $Minsert = "insert into staffing values (NULL, ".$IDEmpresa.", '".$centro."', '".$_POST["C".$ms]."', '".$_POST["A5".$ms]."', '".$_POST["A10".$ms]."', '".$_POST["A15".$ms]."', '".$_POST["A20".$ms]."', '".$_POST["A25".$ms]."', '".$_POST["A30".$ms]."', '".$_POST["A35".$ms]."', '".$_POST["A40".$ms]."', '".$_POST["A45".$ms]."', '".$_POST["A50".$ms]."', '".$_POST["A55".$ms]."', '".$_POST["A60".$ms]."', '".$_POST["A65".$ms]."', '".$_POST["A70".$ms]."', '".$_POST["A75".$ms]."', '".$_POST["A80".$ms]."', '".$_POST["A85".$ms]."', '".$_POST["A90".$ms]."', '".$_POST["A95".$ms]."', '".$_POST["A100".$ms]."')";

        if($bdM->query($Minsert)){

        }else {
          echo $bdM->errno. '  '.$bdM->error;
        }

    }
echo 1;

}else if($_POST["modo"] == 'Actualizar'){
  for($ms=1; $ms <= $_POST["canMS"]; $ms++ ){
       $Minsert = "UPDATE staff_porcentaje set empresa = ".$IDEmpresa.", idStaffing = ".$ms.$_POST["C".$ms].", idgrupo =0, centro = '".$centro."', ocupacion = '".$_POST["C".$ms]."', v5 = '".$_POST["A5".$ms]."', v10 = '".$_POST["A10".$ms]."', v15 = '".$_POST["A15".$ms]."', v20 = '".$_POST["A20".$ms]."', v25 = '".$_POST["A25".$ms]."', v30 = '".$_POST["A30".$ms]."', v35 = '".$_POST["A35".$ms]."', v40 = '".$_POST["A40".$ms]."', v45 = '".$_POST["A45".$ms]."', v50 = '".$_POST["A50".$ms]."', v55 = '".$_POST["A55".$ms]."', v60 = '".$_POST["A60".$ms]."', v65 = '".$_POST["A65".$ms]."', v70 = '".$_POST["A70".$ms]."', v75 = '".$_POST["A75".$ms]."', v80 = '".$_POST["A80".$ms]."', v85 = '".$_POST["A85".$ms]."', v90 = '".$_POST["A90".$ms]."', v95 = '".$_POST["A95".$ms]."', v100 = '".$_POST["A100".$ms]."' where ocupacion = ".$_POST["C".$ms]." and centro = '".$centro."' and empresa = ".$IDEmpresa." ";
       $resRH = odbc_exec($bdS, $Minsert);

       $Minsert = "UPDATE staffing set IDEmpresa = ".$IDEmpresa.", centro = '".$centro."', ocupacion = ".$_POST["C".$ms].", v5 = '".$_POST["A5".$ms]."', v10 = '".$_POST["A10".$ms]."', v15 = '".$_POST["A15".$ms]."', v20 = '".$_POST["A20".$ms]."', v25 = '".$_POST["A25".$ms]."', v30 = '".$_POST["A30".$ms]."', v35 = '".$_POST["A35".$ms]."', v40 = '".$_POST["A40".$ms]."', v45 = '".$_POST["A45".$ms]."', v50 = '".$_POST["A50".$ms]."', v55 = '".$_POST["A55".$ms]."', v60 = '".$_POST["A60".$ms]."', v65 = '".$_POST["A65".$ms]."', v70 = '".$_POST["A70".$ms]."', v75 = '".$_POST["A75".$ms]."', v80 = '".$_POST["A80".$ms]."', v85 = '".$_POST["A85".$ms]."', v90 = '".$_POST["A90".$ms]."', v95 = '".$_POST["A95".$ms]."', v100 = '".$_POST["A100".$ms]."' where ocupacion = ".$_POST["C".$ms]." and centro = '".$centro."' and IDEmpresa = ".$IDEmpresa." ";
       
       if($bdM->query($Minsert)){

       }else {
         echo $bdM->errno. '  '.$bdM->error;
       }
   }
echo 1;

}




 ?>
