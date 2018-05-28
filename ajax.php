<?php

if($_POST || $_FILES) {

  require_once('config/config.php');

  switch ($_GET['modo']) {
    case 'login':
      require_once('consultas/ajax/Login.php');
    break;
    case 'reg':
      require_once('consultas/ajax/Nusuario.php');
    break;
    case 'Tasistencia':
      require_once('consultas/ajax/Tasistencia.php');
    break;
    case 'periodo':
      require_once('consultas/ajax/Periodos.php');
    break;
    case 'GTasistencia':
      require_once('consultas/ajax/GTasistencia.php');
    break;
    case 'Tactualizar':
      require_once('consultas/ajax/Tactualizar.php');
    break;
    case 'Tguardar':
      require_once('consultas/ajax/Tguardar.php');
    break;
    case 'Tcerrar':
      require_once('consultas/ajax/Tcerrar.php');
    break;
    case 'FA':
      require_once('consultas/ajax/FactorAusentismo.php');
    break;
    case 'CP':
      require_once('consultas/ajax/CP.php');
    break;
    case 'ActRol':
      require_once('consultas/ajax/ActuRol.php');
    break;
    case 'RolHorario':
      require_once('consultas/ajax/RolHorario.php');
    break;
    case 'DifStaffin':
      require_once('consultas/ajax/DifStaffin.php');
    break;
    case 'verContratos':
      require_once('consultas/ajax/VerContratos.php');
    break;
    case 'Gcontratos':
      require_once('consultas/ajax/Gcontratos.php');
    break;
    case 'EnvContrato':
      require_once('consultas/ajax/EnvContrato.php');
    break;
    case 'ImpFotmatos':
      require_once('consultas/ajax/ImpFotmatos.php');
    break;
    case 'verFormatos':
      require_once('consultas/ajax/ConsultaFormatos.php');
    break;
    case 'contratosVence':
      require_once('consultas/ajax/ContratoVencer.php');
    break;
    case 'AjusteEmpleado':
      require_once('consultas/ajax/AjusteEmpleado.php');
    break;
    case 'MajusteEmple':
      require_once('consultas/ajax/MajusteEmple.php');
    break;
    case 'Permiso':
      require_once('consultas/ajax/Permiso.php');
    break;
    case 'GPermiso':
      require_once('consultas/ajax/GPermiso.php');
    break;
    case 'PDOM':
      require_once('consultas/ajax/PDOM.php');
    break;
    case 'GPDOM':
      require_once('consultas/ajax/GPDOM.php');
    break;
    case 'DLaborados':
      require_once('consultas/ajax/DLaborados.php');
    break;
    case 'GDLaborados':
      require_once('consultas/ajax/GDLaborados.php');
    break;
    case 'Staffin':
      require_once('consultas/ajax/Staffin.php');
    break;
    case 'Cstaffin':
      require_once('consultas/ajax/Cstaffin.php');
    break;
    case 'Celular':
      require_once('consultas/ajax/Celular.php');
    break;
    case 'Retardos':
      require_once('consultas/ajax/Retardos.php');
    break;
    case 'GRetardos':
      require_once('consultas/ajax/GRetardos.php');
    break;
    case 'cargarEmpleados':
      require_once('consultas/ajax/cargarEmpleados.php');
    break;
    case 'CambioDep':
      require_once('consultas/ajax/CambioDep.php');
    break;
    case 'notificaciones':
      require_once('consultas/ajax/notificaciones.php');
    break;
    case 'verContactos':
      require_once('consultas/ajax/verContactos.php');
    break;
    case 'TExtra':
      require_once('consultas/ajax/TExtra.php');
    break;
    case 'GtpoExtra':
      require_once('consultas/ajax/GtpoExtra.php');
    break;
    case 'checadastxt':
      require_once('consultas/ajax/checadastxt.php');
    break;
    case 'chatear':
      require_once('consultas/ajax/chatear.php');
    break;
    case 'Mensajes':
      require_once('consultas/ajax/Mensajes.php');
    break;
    case 'AutPermiso':
      require_once('consultas/ajax/AutPermiso.php');
    break;
    case 'AutCompletado':
      require_once('consultas/ajax/AutCompletado.php');
    break;
    case 'ConsInfoEmpChecada':
      require_once('consultas/ajax/ConsInfoEmpChecada.php');
    break;
    case 'camStatus':
      require_once('consultas/ajax/camStatus.php');
    break;
    case 'ConsultaUserMSQL':
      require_once('consultas/ajax/ConsultaUserMSQL.php');
    break;
    case 'DesLaborados':
      require_once('consultas/ajax/DesLaborados.php');
    break;
    case 'DobleTurno':
      require_once('consultas/ajax/DobleTurno.php');
    break;
    case 'ConsultaFrente':
      require_once('consultas/ajax/ConsultaFrente.php');
    break;
    case 'GuardarTR':
      require_once('consultas/ajax/GuardarTR.php');
    break;
    case 'GuardarTE':
      require_once('consultas/ajax/GuardarTE.php');
    break;
    case 'ConseptosExt':
      require_once('consultas/ajax/ConseptosExt.php');
    break;
    case 'InserConExt':
      require_once('consultas/ajax/InserConExt.php');
    break;
    case 'AgregarColumna':
      require_once('consultas/ajax/AgregarColumna.php');
    break;
    case 'EliminarCExtra':
      require_once('consultas/ajax/EliminarCExtra.php');
    break;
    case 'CambioSuper':
      require_once('consultas/ajax/CambioSuper.php');
    break;
    case 'destajo':
      require_once('consultas/ajax/destajo.php');
    break;
    case 'InserDestajo':
      require_once('consultas/ajax/InserDestajo.php');
    break;
    case 'EliminarCExtraD':
      require_once('consultas/ajax/EliminarCExtraD.php');
    break;
    case 'pruebaExcel':
      require_once('consultas/ajax/GenerarExcel.php');
    break;
    case 'Gdestajo':
      require_once('consultas/ajax/Gdestajo.php');
    break;
    case 'GenerarExcel':
      require_once('consultas/ajax/GenerarExcel.php');
    break;
    case 'Gfaltas':
      require_once('consultas/ajax/Gfaltas.php');
    break;
    case 'ConceptoExtra':
      require_once('consultas/ajax/ConceptoExtraA.php');
    break;
    case 'InserConceptoExtra':
      require_once('consultas/ajax/InserConceptoExtra.php');
    break;
    case 'GconceptoExtra':
      require_once('consultas/ajax/GconceptoExtra.php');
    break;
    case 'Gpremio':
      require_once('consultas/ajax/Gpremio.php');
    break;
    case 'ActualR':
      require_once('consultas/ajax/ActualR.php');
    break;
    default:
      header('location: index.php');
    break;
  }

} else {
  header('location: index.php');
}

?>
