<?php
require_once('librerias/pdf/fpdf.php');

class PDF extends FPDF
{

  function tablaVence($NombreEmp, $nombre, $codigo, $nombreDep, $actividad, $DiasAcumulados, $FechaDTer)
  {
    $this->SetFillColor(108, 236, 69);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);

    ////////////////////// CABECERA DEL DOCUMENTO /////////////////////////////
    $this->Cell(196, 10, $NombreEmp, 0, 0, 'C');
    $this->Ln(10);

    $this->SetFont('Arial', 'B', 10);

    //$this->Cell(10, 6, '', 0, 0, 'C', false);
    $this->Cell(196, 10, 'AVISO DE VENCIMIENTO DE CONTRATO', 0, 0, 'C', false);
    $this->Ln(10);

    $this->SetFont('Arial', '', 10);
    //$this->Cell(10, 6, '', 0, 0, 'C', false);
    $this->Cell(17, 5, 'NOMBRE:', 0, 0, 'L');

    $this->Cell(81, 5, $nombre, 0, 0, 'L');
    $this->Cell(20, 5, 'NUMERO:', 0, 0, 'L');
    $this->Cell(78, 5, $codigo, 0, 0, 'L');
    $this->Ln();

    $this->Cell(32, 5, 'DEPARTAMENTO:', 0, 0, 'L');
    $this->Cell(66, 5, $nombreDep, 0, 0, 'L');
    $this->Cell(20, 5, 'PUESTO:', 0, 0, 'L');
    $this->Cell(78, 5, $actividad, 0, 0, 'L');
    $this->Ln();

    $this->Cell(36, 5, 'DIAS ACUMULADOS:', 0, 0, 'L');
    $this->Cell(62, 5, $DiasAcumulados, 0, 0, 'L');
    $this->Cell(48, 5, 'VENCIMIENTO CONTRATO:', 0, 0, 'L');
    $this->Cell(50, 5, $FechaDTer, 0, 0, 'L');
    $this->Ln(10);

    $this->Cell(98, 5, 'EVALUACION DEL COLABORADOR:', 0, 0, 'L');
    $this->Cell(98, 5, 'OBSERVACIONES:', 0, 0, 'L');
    $this->Ln();

    $this->Cell(98, 5, '', 0, 0, 'L');
    $this->Cell(21, 5, '10', 0, 0, 'C');
    $this->Cell(21, 5, '9', 0, 0, 'C');
    $this->Cell(21, 5, '8', 0, 0, 'C');
    $this->Cell(35, 5, 'NO SUFICIENTE', 0, 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'CONOCIMIENTO DE LAS FUNCIONES DEL PUESTO', 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(35, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'ADAPTACION A ESTANDARES Y PROCEDIMIENTOS', 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(35, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'TRABAJO EN EQUIPO', 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(35, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'ACTITUD Y SERVICIO', 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(35, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'INICIATIVA', 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(35, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'PUNTUALIDAD Y ASISTENCIA', 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(35, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'PRESENTACION PERSONAL', 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(35, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(7);

    $this->Cell(98, 5, utf8_decode('SIRVASE OTORGAR CONTRATO POR: __________ DIAS MÁS'), 0, 0, 'L');
    $this->Ln(6);

    $this->Cell(98, 5, utf8_decode('SIRVASE OTORGAR CONTRATO POR TIEMPO INDETERMINADO __________'), 0, 0, 'L');
    $this->Ln(6);

    $this->Cell(98, 5, utf8_decode('SIRVASE DAR POR TERMINADA LA RELACION LABORAL __________ '), 0, 0, 'L');
    $this->Ln(6);

    $this->Cell(196, 5, utf8_decode('COMENTARIOS ADICIONALES DEL COLABORADOR: ______________________________________________________'), 0, 0, 'L');
    $this->Ln(10);

    $this->SetFont('Arial', 'B', 10);

    $this->Cell(104, 5, utf8_decode('PARA LLENADO EXCLUSIVO DEL JEFE DEPARTAMENTAL '), 0, 0, 'L');
    $this->Cell(12, 5, 'SI', 0, 0, 'C');
    $this->Cell(12, 5, 'SI', 0, 0, 'C');
    $this->Cell(70, 5, 'COMENTARIO', 0, 0, 'C');
    $this->Ln(7);

    $this->SetFont('Arial', '', 10);

    $this->Cell(104, 5, utf8_decode('DEFINA LA MISION DE LA EMPRESA'), 0, 0, 'L');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(70, 5, '__________________________________', 0, 0, 'C');
    $this->Ln(7);

    $this->Cell(104, 5, utf8_decode('DEFINA NUESTRO COMPROMISO'), 0, 0, 'L');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(70, 5, '__________________________________', 0, 0, 'C');
    $this->Ln(7);

    $this->Cell(104, 5, utf8_decode('DEFINA NUESTROS PRINCIPIOS'), 0, 0, 'L');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(70, 5, '__________________________________', 0, 0, 'C');
    $this->Ln(7);

    $this->Cell(104, 5, utf8_decode('MENCIONE NUESTROS VALORES'), 0, 0, 'L');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(70, 5, '__________________________________', 0, 0, 'C');
    $this->Ln(7);

    $this->Cell(104, 5, utf8_decode('MENCIONE NUESTRAS METAS'), 0, 0, 'L');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(70, 5, '__________________________________', 0, 0, 'C');
    $this->Ln(7);

    $this->Cell(104, 5, utf8_decode('MENCIONA NUESTROS ASPECTOS BASICOS DEL SERVICIO'), 0, 0, 'L');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(70, 5, '__________________________________', 0, 0, 'C');
    $this->Ln(7);

    $this->Cell(104, 5, utf8_decode('CUROS DE INDUCCION'), 0, 0, 'L');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(12, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(70, 5, '__________________________________', 0, 0, 'C');
    $this->Ln(15);

    $this->SetFont('Arial', 'B', 8);
    $this->Cell(196, 5, '*Es Importante que en los primeros meses el colaborador defina y conozca los conceptos.');
    $this->Ln(25);

    $this->SetFont('Arial', '', 10);

    $this->Cell(49, 5, '______________________', 0, 0, 'C');
    $this->Cell(49, 5, '______________________', 0, 0, 'C');
    $this->Cell(49, 5, '______________________', 0, 0, 'C');
    $this->Cell(49, 5, '______________________', 0, 0, 'C');
    $this->Ln();

    $this->Cell(49, 5, 'COLABORADOR', 0, 0, 'C');
    $this->Cell(49, 5, 'JEFE DE DEPTO', 0, 0, 'C');
    $this->Cell(49, 5, 'GTE DE AREA', 0, 0, 'C');
    $this->Cell(49, 5, 'GTE RH', 0, 0, 'C');
    $this->Ln(20);

    $this->SetFont('Arial', 'B', 8);
    $this->Cell(196, 5, 'ESTE FORMATO DEBERA SER ENTREGADO AL DEPARTAMENTO DE RECURSOS HUMANOS A MAS TARDAR EL DIA 16 DE JUNIO DE 2016,', 0, 0, 'C');
    $this->Ln();
    $this->Cell(196, 5, 'LES RECORDAMOS QUE EL COLABORADOR NO PUEDE ESTAR LABORANDO SIN CONTRATO.', 0, 0, 'C');

  }

  function tablaSalida($NombreEmp, $nombre, $codigo, $NomDep, $actividad, $FechaSalida, $Jefe)
  {
    $this->SetFillColor(108, 236, 69);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);

    ////////////////////// CABECERA DEL DOCUMENTO /////////////////////////////
    $this->Cell(196, 10, $NombreEmp, 0, 0, 'C');
    $this->Ln(10);

    $this->SetFont('Arial', 'B', 10);

    //$this->Cell(10, 6, '', 0, 0, 'C', false);
    $this->Cell(196, 10, 'ENTREVISTA DE SALIDA', 0, 0, 'C', false);
    $this->Ln(15);

    $this->SetFont('Arial', '', 10);
    //$this->Cell(10, 6, '', 0, 0, 'C', false);
    $this->Cell(17, 5, 'NOMBRE:', 0, 0, 'L');
    $this->Cell(81, 5, $nombre, 0, 0, 'L');
    $this->Cell(20, 5, 'NUMERO:', 0, 0, 'L');
    $this->Cell(78, 5, $codigo, 0, 0, 'L');
    $this->Ln();

    $this->Cell(32, 5, 'DEPARTAMENTO:', 0, 0, 'L');
    $this->Cell(66, 5, $NomDep, 0, 0, 'L');
    $this->Cell(20, 5, 'PUESTO:', 0, 0, 'L');
    $this->Cell(78, 5, $actividad, 0, 0, 'L');
    $this->Ln();

    $this->Cell(36, 5, 'FECHA DE SALIDA:', 0, 0, 'L');
    $this->Cell(62, 5, $FechaSalida, 0, 0, 'L');
    $this->Ln(10);

    $this->Cell(55, 5, 'NOMBRE DEL JEFE INMEDIATO:', 0, 0, 'L');
    $this->Cell(98, 5, $Jefe, 0, 0, 'L');
    $this->Ln(15);

    $this->Cell(119, 5, '', 0, 0, 'L');
    $this->Cell(21, 5, 'BUENO', 0, 0, 'C');
    $this->Cell(21, 5, 'REGULAR', 0, 0, 'C');
    $this->Cell(21, 5, 'MALO', 0, 0, 'C');

    $this->Ln();

    $this->Cell(119, 5, utf8_decode('1.-¿A tu ingreso lo orientacion fue adecuada por parte de tu jefe inmediato?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('2.-¿Como consideras la capacitacion por parte de tu jefe inmediato?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('3.-¿Tuviste oportunidad de aclarar tus dudas e inquietudes?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('4.-¿Tus sugerencias y comentarios fueron escuchados?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('5.-¿Cómo consideras la comunicación en tu departamento?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('6.-¿La relacion con tu Jefe inmediato fue cordial y amistosa?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('7.-¿La relacion con tus compañeros fue cordial y amistosa?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('8.-¿Cómo consideras la organización de trabajo de tu Jefe inmediato?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('9.-¿Sientes que tu trabajo fue valorado?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('10.-¿Cómo consideras el servicio de las rutas de transporte?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('11.-¿Participaste en las actividades deportivas o recreativas que se '), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(119, 5, utf8_decode('organizaron en el hotel y como las consideras?'), 0, 0, 'L');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('12.-¿Cómo consideras la condicion de lockeres y baños?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('13.-¿La comida del Comedor de Colaboradores fue de buena calidad?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('14.-¿expresaste ante tus Jefes las razones por las cuales salias de la'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(119, 5, utf8_decode('compañía?  ¿por que?'), 0, 0, 'L');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('15.-¿Qué opinas de las condiciones de trabajo en general de Sunscape'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(119, 5, utf8_decode('Puerto Vallarta?'), 0, 0, 'L');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('16.-¿Tienes alguna sugerencia, tu opinion es muy importante, ayudanos'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln();

    $this->Cell(119, 5, utf8_decode('a mejorar?'), 0, 0, 'L');
    $this->Ln(8);

    $this->Cell(119, 5, utf8_decode('17.-¿Motivo de tu renuncia?'), 0, 0, 'L');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Cell(21, 5, '( '.'  '.'  '.'  '.' )', 0, 0, 'C');
    $this->Ln(20);

    $this->Cell(196,5, '__________________________________________', 0, 0, 'C');
    $this->Ln();
    $this->Cell(196,5, 'NOMBRE Y FIRMA DEL COLABORADOR', 0, 0, 'C');

  }

  function tablaLiberacion($NombreEmp, $fechaBaja, $codigo, $actividad, $Nombre, $NomDep)
  {
    $this->SetFillColor(108, 236, 69);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);

    ////////////////////// CABECERA DEL DOCUMENTO /////////////////////////////
    $this->Cell(196, 10, $NombreEmp, 'LTR', 0, 'C');
    $this->Ln(10);

    $this->SetFont('Arial', 'B', 10);

    //$this->Cell(10, 6, '', 0, 0, 'C', false);
    $this->Cell(196, 10, 'HOJA DE LIBERACION', 'LR', 0, 'C', false);
    $this->Ln(10);

    $this->SetFont('Arial', '', 10);
    //$this->Cell(10, 6, '', 0, 0, 'C', false);
    $this->Cell(17, 5, '', 'L', 0, 'L');
    $this->Cell(81, 5, '', 0, 0, 'L');
    $this->Cell(30, 5, 'FECHA DE BAJA:', 0, 0, 'L');
    $this->Cell(68, 5, $fechaBaja, 'R', 0, 'L');
    $this->Ln();

    $this->Cell(13, 5, 'CLAVE:', 'L', 0, 'L');
    $this->Cell(85, 5, $codigo, 0, 0, 'L');
    $this->Cell(17, 5, 'PUESTO:', 0, 0, 'L');
    $this->Cell(81, 5, $actividad, 'R', 0, 'L');
    $this->Ln();

    $this->Cell(18, 5, 'NOMBRE:', 'LB', 0, 'L');
    $this->Cell(80, 5, $Nombre, 'B', 0, 'L');
    $this->Cell(15, 5, 'DEPTO:', 'B', 0, 'L');
    $this->Cell(83, 5, $NomDep, 'RB', 0, 'L');
    $this->Ln(10);

    $this->SetFont('Arial', 'B', 10);
    $this->Cell(196, 7, 'JEFE DEPARTAMENTAL', 'LTR', 0, 'L');
    $this->Ln();

    $this->SetFont('Arial', '', 10);
    $this->Cell(98, 6, 'PENDIENTES DE PAGO', 'L', 0, 'L');
    $this->Cell(98, 6, 'HERRAMIENTA / EQUIPO DE TRABAJO', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 6, 'HORAS EXTRAS ______________________________', 'L', 0, 'L');
    $this->Cell(98, 6, '__________________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 6, 'DESCANSOS TRABAJADOS_____________________', 'L', 0, 'L');
    $this->Cell(98, 6, 'OTROS___________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 6, 'OTROS ______________________________________', 'L', 0, 'L');
    $this->Cell(98, 6, 'MANUALES________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(196, 5, '', 'LR', 0, 'C');
    $this->Ln();

    $this->Cell(98, 8, '_____________________________________________', 'L', 0, 'L');
    $this->Cell(98, 8, 'CANTIDAD DESCONTAR $___________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'LB', 0, 'C');
    $this->Cell(98, 5, '', 'RB', 0, 'C');
    $this->Ln(7);

    $this->Cell(196, 3, '', 0, 0, 'C');
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);

    $this->Cell(196, 7, 'CAJA GENERAL / NOMINA', 'LTR', 0, 'L');
    $this->Ln();

    $this->SetFont('Arial', '', 10);

    $this->Cell(98, 6, 'CANTIDAD $ ________________________________', 'L', 0, 'L');
    $this->Cell(98, 6, '___________________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 6, 'CONCEPTO________________________________', 'L', 0, 'L');
    $this->Cell(98, 6, '___________________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(196, 5, '', 'LR', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, '______________________________________', 'L', 0, 'C');
    $this->Cell(98, 5, '______________________________________', 'R', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'LB', 0, 'C');
    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'RB', 0, 'C');
    $this->Ln(7);

    $this->Cell(196, 3, '', 0, 0, 'C');
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);

    $this->Cell(196, 7, 'RECURSOS HUMANOS', 'LTR', 0, 'L');
    $this->Ln();

    $this->SetFont('Arial', '', 10);

    $this->Cell(98, 6, 'GAFETE ___________________________________', 'L', 0, 'L');
    $this->Cell(98, 6, 'PIN________________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 6, 'CREDENCIAL________________________________', 'L', 0, 'L');
    $this->Cell(98, 6, 'LOCKER_____________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(196, 5, '', 'LR', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, '______________________________________', 'L', 0, 'C');
    $this->Cell(98, 5, 'OTROS_________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'LB', 0, 'C');
    $this->Cell(98, 5, '', 'RB', 0, 'C');
    $this->Ln(7);


    $this->Cell(196, 3, '', 0, 0, 'C');
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);

    $this->Cell(196, 7, 'INGRESOS / CREDITO Y COBRANZA', 'LTR', 0, 'L');
    $this->Ln();

    $this->SetFont('Arial', '', 10);

    $this->Cell(196, 6, 'CANTIDAD $ ________________________________', 'LR', 0, 'L');
    $this->Ln();

    $this->Cell(196, 6, 'CONCEPTO________________________________', 'LR', 0, 'L');
    $this->Ln();

    $this->Cell(196, 5, '', 'LR', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, '______________________________________', 'L', 0, 'C');
    $this->Cell(98, 5, '______________________________________', 'R', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'LB', 0, 'C');
    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'RB', 0, 'C');
    $this->Ln(7);

     $this->Cell(196, 3, '', 0, 0, 'C');
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);

    $this->Cell(196, 7, 'ROPERIA', 'LTR', 0, 'L');
    $this->Ln();

    $this->SetFont('Arial', '', 10);

    $this->Cell(196, 6, 'UNIFORMES ________________________________', 'LR', 0, 'L');
    $this->Ln();

    $this->Cell(196, 6, 'COSTO_____________________________________', 'LR', 0, 'L');
    $this->Ln();

    $this->Cell(196, 5, '', 'LR', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, '______________________________________', 'L', 0, 'C');
    $this->Cell(98, 5, '', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'LB', 0, 'C');
    $this->Cell(98, 5, '', 'RB', 0, 'C');
    $this->Ln(7);

     $this->Cell(196, 3, '', 0, 0, 'C');
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);

    $this->Cell(196, 7, 'SEGURIDAD / MANTENIMIENTO', 'LTR', 0, 'L');
    $this->Ln();

    $this->SetFont('Arial', '', 10);

    $this->Cell(196, 6, 'RADIO, LLAVE MAESTRA, OTROS _______________________________________________', 'LR', 0, 'L');
    $this->Ln();

    $this->Cell(196, 5, '', 'LR', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, '______________________________________', 'L', 0, 'C');
    $this->Cell(98, 5, '______________________________________', 'R', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'LB', 0, 'C');
    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'RB', 0, 'C');
    $this->Ln(7);


    $this->Cell(196, 3, '', 0, 0, 'C');
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);

    $this->Cell(196, 7, 'SISTEMAS', 'LTR', 0, 'L');
    $this->Ln();

    $this->SetFont('Arial', '', 10);

    $this->Cell(98, 6, 'EQUIPO ___________________________________', 'L', 0, 'L');
    $this->Cell(98, 6, 'CLAVES____________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 6, 'USUARIOS__________________________________', 'L', 0, 'L');
    $this->Cell(98, 6, 'OTROS______________________________________', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(196, 5, '', 'LR', 0, 'C');
    $this->Ln();

    $this->Cell(98, 5, '______________________________________', 'L', 0, 'C');
    $this->Cell(98, 5, '', 'R', 0, 'L');
    $this->Ln();

    $this->Cell(98, 5, 'NOMBRE Y FIRMA', 'LB', 0, 'C');
    $this->Cell(98, 5, '', 'RB', 0, 'C');
    $this->Ln(7);


    $this->Cell(196, 3, '', 0, 0, 'C');
    $this->Ln(30);

    $this->Cell(196, 5, '______________________________________', 0, 0, 'C');
    $this->Ln();
    $this->Cell(196, 5, 'NOMBRE Y FIRMA DEL COLABORADOR', 0, 0, 'C');
    $this->Ln();
  }

  function tablePermiso($NombreEmp, $Nombre, $codigo, $nomdepto, $fechhh){
    $this->SetFillColor(108, 236, 69);
    $this->SetTextColor(0);
    $this->SetDrawColor(0);
    $this->SetLineWidth(.2);
    $this->SetFont('Arial', 'B', 14);

    ////////////////////// CABECERA DEL DOCUMENTO /////////////////////////////
    $this->Cell(196, 10, $NombreEmp, 0, 0, 'C');
    $this->Ln();

    $this->SetFont('Arial', 'B', 10);

    //$this->Cell(10, 6, '', 0, 0, 'C', false);
    $this->Cell(196, 10, 'SOLICITUD PARA AUSENTARSE DEL TRABAJO', 0, 0, 'C', false);
    $this->Ln(10);

    $this->SetFont('Arial', '', 10);
    $this->Cell(12, 10, 'PARA:');
    $this->Cell(30, 10, 'GERENTE DE RECURSOS HUMANOS');
    $this->Ln();
    $this->Cell(75, 10, 'DE: '.utf8_decode($Nombre));
    $this->Cell(20, 10, 'No. '.$codigo);
    $this->Cell(80, 10, 'DEPARTAMENTO: '.utf8_decode($nomdepto));
    $this->Ln();
    $this->Cell(196, 10, 'POR ESTE CONDUCTO ME PERMITO SOLICITAR PERMISO PARA AUSENTARME LOS DIAS: '.$fechhh);
    $this->Ln();
    $this->Cell(196, 10, '________________________________________________________________________________________');
    $this->Ln();
    $this->Cell(196, 10, '________________________________________________________________________________________');
    $this->Ln(15);
    $this->Cell(196, 10, 'ASUNTO:_________________________________________________________________________________');
    $this->Ln();
    $this->Cell(196, 10, '________________________________________________________________________________________');
    $this->Ln();
    $this->Cell(196, 10, '________________________________________________________________________________________');
    $this->Ln(20);
    $this->Cell(196, 10, 'AUTORIZACIONES', 0, 0, 'C', false);
    $this->Ln(18);
    $this->Cell(65, 10, '_______________________',0, 0, 'C', false);
    $this->Cell(65, 10, '_______________________',0, 0, 'C', false);
    $this->Cell(65, 10, '_______________________',0, 0, 'C', false);
    $this->Ln();
    $this->Cell(65, 10, 'EMPLEADO',0, 0, 'C', false);
    $this->Cell(65, 10, 'JEFE INMEDIATO',0, 0, 'C', false);
    $this->Cell(65, 10, 'RECURSOS HUMANOS',0, 0, 'C', false);
    $this->Ln(15);

    //$this->SetFont('Arial', '', 7);
    $this->Cell(60, 7, '');
    $this->Cell(7, 7, '', 1, 0, 'C', false);
    $this->Cell(30, 7, 'Sin goce de sueldo');
    $this->SetFont('Arial', '', 17);
    $this->Cell(5, 7, '');
    $this->Cell(7, 7, 'X', 1, 0, 'C', false);
    $this->SetFont('Arial', '', 10);
    $this->Cell(30, 7, 'Con goce de sueldo');
    $this->Ln();

  }

  function footer()
  {
    $this->SetY(-15);
    $this->SetFont('Arial', 'I', 8);
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C');
  }

}

?>
