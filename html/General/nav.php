<?php
//<li><a href="index.php?pagina=CargarChecadas.php" class="waves-effect waves-teal">Cargar Checadas</a></li>
//<li><a href="index.php?pagina=Formatospdf.php" class="waves-effect waves-teal">Imprimir Formatos</a></li>
//<li><a href="index.php?pagina=TiempoExtra.php" class="waves-effect waves-teal">TpoExtra</a></li>
//<li><a href="index.php?pagina=Archivos.php" class="waves-effect waves-teal">ARCHIVOS</a></li>
//<li><a href="index.php?pagina=Destajo.php" class="waves-effect waves-teal">Destajo</a></li>
//<li><a href="index.php?pagina=ConceptoExtra.php" class="waves-effect waves-teal">Concepto Extra</a></li>
//<li><a href="index.php?pagina=Celular.php" class="waves-effect waves-teal">Celular</a></li>
//<li><a href="index.php?pagina=Staffin.php" class="waves-effect waves-teal">Staffin</a></li>

$MenuG = "";
if($_SESSION['Sudo'] == 1)
{
    $MenuG = '
    <ul id="slide-out" class="side-nav">
        <a href="#" data-activates="slide-out" id="btnMenu" style="text-align: center;"><h3 style="text-aling: center; cursor: default;">MENÚ</h3></a>
        <li><a href="index.php?pagina=contrato.php" class="waves-effect waves-teal">Contrato</a></li>
        <li><a href="index.php?pagina=ContratoVencer.php" class="waves-effect waves-teal">Contratos Vencidos</a></li>
        <li><a href="index.php?pagina=RolHorario.php" class="waves-effect waves-teal">ROL</a></li>
        <li><a href="index.php?pagina=AjusteEmpleados.php" class="waves-effect waves-teal">Ajuste Empleado</a></li>
        <li><a href="index.php?pagina=Tasistencia.php" class="waves-effect waves-teal">Tasistencia</a></li>
        <li><a href="index.php?pagina=Permiso.php" class="waves-effect waves-teal">Permisos</a></li>
        <li><a href="index.php?pagina=Retardos.php" class="waves-effect waves-teal">Retardos</a></li>
        <li><a href="index.php?pagina=PDOM.php" class="waves-effect waves-teal">PDOM</a></li>
        <li><a href="index.php?pagina=DLaborados.php" class="waves-effect waves-teal">DLaborados</a></li>
        <li><a href="index.php?pagina=chat.php" class="waves-effect waves-teal">Chat</a></li>
        <li><a href="index.php?pagina=CargarChecadas.php" class="waves-effect waves-teal">Cargar Checadas</a></li>
        <li><a href="index.php?pagina=IncrustarChecadastxt.php" class="waves-effect waves-teal">importar Checadas</a></li>
        <li><a href="index.php?pagina=Cerrar.php" class="waves-effect waves-teal">Salir</a></li>
    </ul>
    ';
}else {

    if($_SESSION["Dep"] == 1){
        $MenuG = '
        <ul id="slide-out" class="side-nav">
            <a href="#" data-activates="slide-out" id="btnMenu" style="text-align: center;"><h3 style="text-aling: center; cursor: default;">MENÚ</h3></a>
            <li><a href="index.php?pagina=RolHorario.php" class="waves-effect waves-teal">ROL</a></li>
            <li><a href="index.php?pagina=AjusteEmpleados.php" class="waves-effect waves-teal">Ajuste Empleado</a></li>
            <li><a href="index.php?pagina=Tasistencia.php" class="waves-effect waves-teal">Tasistencia</a></li>
            <li><a href="index.php?pagina=Permiso.php" class="waves-effect waves-teal">Permisos</a></li>
            <li><a href="index.php?pagina=PDOM.php" class="waves-effect waves-teal">PDOM</a></li>
            <li><a href="index.php?pagina=DLaborados.php" class="waves-effect waves-teal">DLaborados</a></li>
            <li><a href="index.php?pagina=chat.php" class="waves-effect waves-teal">Chat</a></li>
            <li><a href="index.php?pagina=Cerrar.php" class="waves-effect waves-teal">Salir</a></li>
        </ul>';
    }else if($_SESSION["Dep"] == 34){
        $MenuG = '
        <ul id="slide-out" class="side-nav">
            <a href="#" data-activates="slide-out" id="btnMenu" style="text-align: center;"><h3 style="text-aling: center; cursor: default;">MENÚ</h3></a>
            <li><a href="index.php?pagina=RolHorario.php" class="waves-effect waves-teal">ROL</a></li>
            <li><a href="index.php?pagina=Tasistencia.php" class="waves-effect waves-teal">Tasistencia</a></li>
            <li><a href="index.php?pagina=Permiso.php" class="waves-effect waves-teal">Permisos</a></li>
            <li><a href="index.php?pagina=chat.php" class="waves-effect waves-teal">Chat</a></li>
            <li><a href="index.php?pagina=Cerrar.php" class="waves-effect waves-teal">Salir</a></li>
        </ul>';
    }else if($_SESSION["Dep"] == 2){
        $MenuG = '
        <ul id="slide-out" class="side-nav">
            <a href="#" data-activates="slide-out" id="btnMenu" style="text-align: center;"><h3 style="text-aling: center; cursor: default;">MENÚ</h3></a>
            <li><a href="index.php?pagina=contrato.php" class="waves-effect waves-teal">Contrato</a></li>
            <li><a href="index.php?pagina=ContratoVencer.php" class="waves-effect waves-teal">Contratos Vencidos</a></li>
            <li><a href="index.php?pagina=RolHorario.php" class="waves-effect waves-teal">ROL</a></li>
            <li><a href="index.php?pagina=Tasistencia.php" class="waves-effect waves-teal">Tasistencia</a></li>
            <li><a href="index.php?pagina=Permiso.php" class="waves-effect waves-teal">Permisos</a></li>
            <li><a href="index.php?pagina=chat.php" class="waves-effect waves-teal">Chat</a></li>
            <li><a href="index.php?pagina=Cerrar.php" class="waves-effect waves-teal">Salir</a></li>
        </ul>';
    }else if($_SESSION["Dep"] == 3){
        $MenuG = '
        <ul id="slide-out" class="side-nav">
            <a href="#" data-activates="slide-out" id="btnMenu" style="text-align: center;"><h3 style="text-aling: center; cursor: default;">MENÚ</h3></a>
            <li><a href="index.php?pagina=contrato.php" class="waves-effect waves-teal">Contrato</a></li>
            <li><a href="index.php?pagina=ContratoVencer.php" class="waves-effect waves-teal">Contratos Vencidos</a></li>
            <li><a href="index.php?pagina=chat.php" class="waves-effect waves-teal">Chat</a></li>
            <li><a href="index.php?pagina=Cerrar.php" class="waves-effect waves-teal">Salir</a></li>
        </ul>';
    }else if($_SESSION["Dep"] == 4){
        $MenuG = '
        <ul id="slide-out" class="side-nav">
            <a href="#" data-activates="slide-out" id="btnMenu" style="text-align: center;"><h3 style="text-aling: center; cursor: default;">MENÚ</h3></a>
            <li><a href="index.php?pagina=Cerrar.php" class="waves-effect waves-teal">Salir</a></li>
        </ul>';
    }

}


?>
