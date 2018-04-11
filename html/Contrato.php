<h4 style="text-align: center;"><?php echo $NomDep; ?></h4>
<h5 style="text-align: center;">CONTRATOS</h5>
<div class="row">
  <div class="col s12 l4" id="divContra">
    <label for="RP">Registro Patonal</label>
    <input type="text" id="RP" style="margin-left: 10px;" value="<?php echo $RegisEmpresa; ?>">
    <br/>
    <label for="RFC">R.F.C</label>
    <input type="text" id="RFC" style="margin-left: 81px;" value="<?php echo $RFC; ?>">
    <br/>
    <label for="FH">Fecha</label>
    <input id="FH" type="text" style="margin-left: 75px;" class="Calendario" value="<?php echo date("d/m/Y"); ?>">
    <br/>
    <label for="userN">Usuario</label>
    <input id="userN" style="margin-left: 65px;" onkeyup="VerUser()" type="text" title="Usuario que recibirá el informe." value="<?php echo $correo; ?>">
    <br/>
    <button name="button" onclick="GenerarExcel()" class="btn">EXCEL</button>
    <div id="ULAuto"></div>
    <br/>
  </div>

  <div class="col s12 l4 center" style="margin: 30px 0 30px 0;">
      <button  name="button" onclick="VGformatos()" class="btn Formatos">VENCIMIENTO</button>
      <button  name="button" onclick="SGformatos()" class="btn Formatos">SALIDA</button>
      <button  name="button" onclick="LGformatos()" class="btn Formatos">LIBERACION</button>
  </div>

  <div class="col s12 l4 " id="Porcen">
    <label for="PS">Porcentaje</label>
    <input type="number" onclick="DifStaffin()" onkeyup="DifStaffin()" id="PS" style="margin-left: 10px;" min="5" max="100" step="5" value="<?php echo $POR; ?>">
    <div id="DifStaffin">

    </div>
    <button class="waves-effect waves-light btn" onclick="DifStaffin()" style="margin: 10px;">CALCULAR</button>
  </div>
</div>
<div class="modal " id="modal1" style="text-align: center; padding-top: 10px;">
  <h4 id="textCargado">Procesando...</h4>
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</div>
<div id="estado_consulta_ajax">

</div>
<?php

$objBDSQL = new ConexionSRV();
$objBDSQL->conectarBD();

$script = "";
if($DepOsub == 1)
{
  $ComSql = "LEFT (llaves.centro, ".$MascaraEm.") = LEFT('".$centro."', ".$MascaraEm.")";
}else {
  $ComSql = "llaves.centro = '".$centro."'";
}

$query = "
    select all (empleados.codigo),
    ltrim (empleados.ap_paterno)+' '+ltrim (empleados.ap_materno)+' '+ltrim (empleados.nombre) ,
	  llaves.ocupacion,
	  tabulador.actividad,
	  llaves.horario,
    MAx (convert(varchar(10),empleados.fchantigua,103)),
    max(convert(varchar(10),contratos.fchAlta ,103)) ,
    max(convert(varchar(10),contratos.fchterm ,103)) ,
    SUM(contratos.dias)

    from empleados

    LEFT  join contratos  on contratos.empresa = empleados.empresa and contratos.codigo = empleados.codigo
    INNER JOIN llaves on llaves.empresa = empleados.empresa and llaves.codigo = empleados.codigo
    INNER JOIN tabulador on tabulador.empresa = llaves.empresa and tabulador.ocupacion = llaves.ocupacion

    where empleados.activo = 'S' AND
          ".$ComSql." and llaves.empresa = '".$IDEmpresa."'

    group by  empleados.codigo,
          empleados.ap_paterno,
          empleados.ap_materno,
          empleados.nombre,
          empleados.fchantigua,
          llaves.ocupacion,
          tabulador.actividad,
          llaves.horario
    ";

$numer = $objBDSQL->obtenfilas($query);
if($numer > 1){
  $objBDSQL->consultaBD($query);

  while ( $row = $objBDSQL->obtenResult() )
  {
    $script .= '
      function quitar'.$row["codigo"].'() {
        document.getElementById("A'.$row["codigo"].'").checked = false;
        document.getElementById("B'.$row["codigo"].'").checked = false;
      }';
  }
}
$objBDSQL->liberarC();
$objBDSQL->cerrarBD();
echo '<script type="text/javascript">
  '.$script.'
</script>';

?>
<script src="js/procesos/Contratos.js"></script>
