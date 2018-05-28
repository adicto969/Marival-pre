<?php


if(empty($_POST["fecha"])){
    $fecha = date("d/m/Y");
}else{
    $fecha = $_POST["fecha"];
}

if(empty($_POST["tiponom"])){
    $tiponom = 1;
}else{
    $tiponom = $_POST["tiponom"];
}

if(empty($_POST["horario"])){
    $horario = 1;
}else{
    $horario = $_POST["horario"];
}

/*if ($conn){
    $sqlH = "SELECT relch_registro.checada

	FROM Empleados
	   INNER JOIN Llaves ON Llaves.Codigo = Empleados.Codigo AND Llaves.Empresa = Empleados.Empresa
	   INNER JOIN relch_registro on relch_registro.codigo = Empleados.Codigo
	   INNER JOIN Tabulador ON Tabulador.Ocupacion = Llaves.Ocupacion AND Tabulador.Empresa = Llaves.Empresa

	WHERE  Empleados.Activo = 'S' and
	   relch_registro.fecha = '".$fecha."' and
       relch_registro.checada > '00:00:00' and
       relch_registro.horario = '".$horario."'

     ORDER BY checada DESC
     ";
    $rsH = odbc_exec( $conn, $sqlH );
    $HoraFinal = odbc_result($rsH, "checada");
    odbc_close( $conn );
}else{
    echo "error con la BD";
}
*/
        echo date("H:i:s")."<br>";
        $horaACT = date("H:i:s");
        $nuevafecha = strtotime ( '-5 second' , strtotime ( $horaACT ) ) ;
        $nuevafecha = date("H:i:s", $nuevafecha);

    // Se define la consulta que va a ejecutarse
    $sql = "
    SELECT empleados.codigo, ap_paterno+' '+ap_materno+' '+nombre AS Nombre,
        Tabulador.Actividad, convert(VARCHAR(10), relch_registro.fecha, 103) fecha, relch_registro.checada

	FROM Empleados
	   INNER JOIN Llaves ON Llaves.Codigo = Empleados.Codigo AND Llaves.Empresa = Empleados.Empresa
	   INNER JOIN relch_registro on relch_registro.codigo = Empleados.Codigo
	   INNER JOIN Tabulador ON Tabulador.Ocupacion = Llaves.Ocupacion AND Tabulador.Empresa = Llaves.Empresa

	WHERE  Empleados.Activo = 'S' and
	   relch_registro.fecha = '".$fecha."' and
     relch_registro.checada BETWEEN '".$nuevafecha."' and '".date("H:i:s")."'
     and (relch_registro.EoS = 'S' or relch_registro.EoS = '2')

    ORDER BY checada DESC
    ";

    echo $sql;


    //and relch_registro.horario = '".$horario."'

    echo '
     <!DOCTYPE html>
        <html>
        <head>

        <meta charset="utf-8">
        <link href="jquery/jquery-ui.css" rel="stylesheet">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <style>


        table {
            width:100%;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: center;
        }
        table#t01 tr:nth-child(even) {
            background-color: #eee;
        }
        table#t01 tr:nth-child(odd) {
           background-color:#fff;
        }
        table#t01 th {
            background-color: black;
            color: white;
        }


        table#t01 tr:hover{
            background-color: rgba(162, 236, 135, 0.24);
            color: black;

        }

        .btnF{
            padding: 19px 54px;
            margin: 30px;
            background-color: rgb(254, 154, 46);
            border: medium none;
            font-stretch: semi-expanded;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
        }

        table input{
            width: 34px;
            height: 17px;
            font-size: 18px;
            border: 1px solid red;
        }

        input:invalid {

        border: 1px solid red;
        background-color: #fcd284;
        }

        h1{
            text-align: center;
        }

        .left td{
            text-align: left;
        }

        h2{
            text-align: center;
        }

        .btnIMP {
            width: auto;
            height: auto;
            background-color: rgb(21, 213, 236);
            color: black;
            padding: 8px;
            font: arial;
            font-family: arial;
            font-weight: bold;
            cursor: pointer;

        }

        </style>
        <meta http-equiv="refresh" content="2" />
        </head>
        <body>
        <h2>Checadas</h2>
        <br/>
        <form action="consultaChecadas.php" method="POST">
            <label for="fchP_F">Fecha </label>
            <input id="datepicker2" type="text" value="'.$fecha.'" name="fecha" style="margin-left: 113px; width: 142px;">
            </br>
            </br>
            <!--<label for="horario">Horario</label>
            <input id="horario" type="number" nim="1" max="6" name="horario" value="'.$horario.'" style="margin-left: 104px; width: 142px;">-->
            </br>
            <!--<input type="submit" class="btnF" value="BUSCAR">-->
            <br/>
            <br/>
        </form>

        ';


    $sql2 = $sql;

//    if (!$rs) {
       // exit( "Error en la consulta SQL" );
  //  }else {
        ////////optiene el numero de columnas/////////////////
        $crs = odbc_exec( constructS(), $sql2 );
        $rs2 = odbc_fetch_array( $crs );
        $Ncol = count( $rs2 );
        //////////////////////////////////////////////////////

        if($Ncol == 1){

            echo "No se han encontrado resultados";

        }else {
           odbc_close( $conn );




            $rs = odbc_exec( $conn, $sql );

            echo ' <form action="reporteChecadas.php" method="POST">
                       <input type="hidden" name="fecha" value="'.$fecha.'" />
                       <input type="hidden" name="tiponom" value="'.$tiponom.'" />
                       <DIV ID="seleccion" style="display: none; font-size: 8px"></DIV>
                       <table id="t01">
                       <tr>
                            <th style="border-right: 2px solid white;">Codigo</th>
                            <th style="border-right: 2px solid white;">Nombre</th>
                            <th style="border-right: 2px solid white;">Actividad</th>
                            <th style="border-right: 2px solid white;">Fecha</th>
                            <th style="border-right: 2px solid white;">Checada</th>
                            <th style="border-right: 2px solid white;">Modelo</th>
                            <th style="width:15px;">Celular</th>
                            <th style="width:15px;">Imprimir</th>
                            ';


        $lr = 0;
        while ( odbc_fetch_row($rs) )
        {
            $lr++;
            echo '

                      <tr class="left">
                        <td>'.odbc_result($rs,"codigo").'</td>
                        <td>'.utf8_encode(odbc_result($rs,"Nombre")).'</td>
                        <td>'.odbc_result($rs,"Actividad").'</td>
                        <td>'.odbc_result($rs,"fecha").'</td>
                        <td>'.odbc_result($rs,"checada").'</td>';

                         $resulM = $connM->query("select Modelo from cel where IDEmpleado = '".odbc_result($rs,"codigo")."' and Empresa = '".$IDEmpresa."'");
                             $valorC = "";
                            $checked = "";
                            $botonn = "";
                        while ($valorM = $resulM->fetch_row()){
                            if ($valorM[0]){
                                $valorC = $valorM[0];
                                $checked = 'checked="checked"';
                                $botonn = '<td><div onClick="seleccion'.odbc_result($rs,"codigo").''.$lr.'()" class="btnIMP">Imprimir</div></td>';

                                //echo '<script type="text/javascript">';
                                //echo 'seleccion361();';
                                //echo '</script>';

                                echo '
                                    <script type="text/javascript">
                                    function seleccion361(){
                                            document.getElementById("seleccion").innerHTML = "Codigo: '.date("dmY").''.odbc_result($rs,"codigo").'<p>Nombre: '.odbc_result($rs,"Nombre").'</p>";

                                            var ficha = document.getElementById("seleccion");
                                            var ventimp = window.open(" ", "popimpr");
                                            ventimp.document.write( ficha.innerHTML );
                                            ventimp.document.close();
                                            ventimp.print();
                                            ventimp.close();
                                    }
                                    seleccion361();
                                    </script>

                                ';

                            }else {
                                $valorC = "";
                                $checked = "";
                                $botonn = "";
                                echo '
                                    <script type="text/javascript">
                                    function seleccion361(){
                                           document.getElementById("seleccion").innerHTML = "Codigo: '.date("dmY").''.odbc_result($rs,"codigo").'<p>Nombre: '.odbc_result($rs,"Nombre").'</p>";

                                            var ficha = document.getElementById("seleccion");
                                            var ventimp = window.open(" ", "popimpr");
                                            ventimp.document.write( ficha.innerHTML );
                                            ventimp.document.close();
                                            ventimp.print();
                                            ventimp.close();

                                    }
                                    seleccion361();
                                    </script>

                                ';
                            }

                        }

                        echo '
                        <td>'.$valorC.'</td>
                        <td><input type="checkbox" name="'.odbc_result($rs,"codigo").'"  id="'.odbc_result($rs,"codigo").''.$lr.'" value="SI" '.$checked.'></td>
                        '.$botonn.'
                      </tr>
                        ';


        }

    }
     //odbc_close( $conn );
   // }

    //'.$oculto.'  <--- BOTON
    echo '
    </table>
    </form>
    <script src="jquery/external/jquery/jquery.js"></script>
    <script src="jquery/jquery-ui.js"></script>
    <script type="text/javascript">
    ';
        $rs = odbc_exec( constructS(), $sql );
        $lr = 0;
        while ( odbc_fetch_row($rs) )
        {
            $lr++;
            echo '

                    function seleccion'.odbc_result($rs,"codigo").''.$lr.'(){
                        if(document.getElementById("'.odbc_result($rs,"codigo").''.$lr.'").checked){
                            document.getElementById("seleccion").innerHTML = "Codigo: '.date("dmY").''.odbc_result($rs,"codigo").'<p>Nombre: '.odbc_result($rs,"Nombre").'</p>";

                            var ficha = document.getElementById("seleccion");
                            var ventimp = window.open(" ", "popimpr");
                            ventimp.document.write( ficha.innerHTML );
                            ventimp.document.close();
                            ventimp.print();
                            ventimp.close();

                        }
                    }

                ';


        }

    echo '</script>
    ';

    echo '
    <script>
      $( function() {
        $( "#datepicker" ).datepicker();
      } );
      $( function() {
        $( "#datepicker2" ).datepicker();
      } );
    </script>
     <script>
     $(document).ready(function(){
          function fetch_data()
          {
               $.ajax({
                    url:"select.php",
                    method:"POST",
                    success:function(data){
                         $("#notas").html(data);
                    }
               });
          }
          fetch_data();
      });
 </script>
</body>
</html>
    ';




?>
