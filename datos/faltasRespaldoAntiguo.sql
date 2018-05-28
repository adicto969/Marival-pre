-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-03-2017 a las 15:05:51
-- Versión del servidor: 10.1.19-MariaDB
-- Versión de PHP: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `faltas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ajusteempleado`
--

CREATE TABLE `ajusteempleado` (
  `ID` int(100) NOT NULL,
  `IDEmpleado` int(100) NOT NULL,
  `PDOM` tinyint(1) NOT NULL,
  `DLaborados` tinyint(1) NOT NULL,
  `PA` tinyint(1) NOT NULL,
  `PP` tinyint(1) NOT NULL,
  `centro` varchar(25) NOT NULL,
  `IDEmpresa` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ajusteempleado`
--

INSERT INTO `ajusteempleado` (`ID`, `IDEmpleado`, `PDOM`, `DLaborados`, `PA`, `PP`, `centro`, `IDEmpresa`) VALUES
(1, 20752, 0, 0, 0, 0, '00109', 1),
(2, 20873, 0, 0, 0, 0, '00109', 1),
(3, 2686, 0, 0, 0, 0, '00109', 1),
(4, 8845, 0, 0, 0, 0, '00109', 1),
(5, 21736, 0, 0, 0, 0, '00109', 1),
(6, 112, 0, 0, 0, 0, '00109', 1),
(7, 20518, 0, 0, 0, 0, '00109', 1),
(8, 21697, 0, 0, 0, 0, '00109', 1),
(9, 21839, 0, 0, 0, 0, '00109', 1),
(10, 15225, 0, 0, 0, 0, '00109', 1),
(11, 3078, 0, 0, 0, 0, '00109', 1),
(12, 20434, 0, 0, 0, 0, '00109', 1),
(13, 3259, 0, 0, 0, 0, '00109', 1),
(14, 3050, 0, 0, 0, 0, '00109', 1),
(15, 21532, 0, 0, 0, 0, '00109', 1),
(16, 19183, 0, 0, 0, 0, '00109', 1),
(17, 3359, 0, 0, 0, 0, '00109', 1),
(18, 20322, 0, 0, 0, 0, '00109', 1),
(19, 21790, 0, 0, 0, 0, '00109', 1),
(20, 8092, 0, 0, 0, 0, '00109', 1),
(21, 20635, 0, 0, 0, 0, '00109', 1),
(22, 19190, 0, 0, 0, 0, '00109', 1),
(23, 19203, 0, 0, 0, 0, '00109', 1),
(24, 5960, 0, 0, 0, 0, '00109', 1),
(25, 9201, 0, 0, 0, 0, '00109', 1),
(26, 21732, 0, 0, 0, 0, '00109', 1),
(27, 16630, 0, 0, 0, 0, '00109', 1),
(28, 21152, 0, 0, 0, 0, '00109', 1),
(29, 21667, 0, 0, 0, 0, '00109', 1),
(30, 20495, 0, 0, 0, 0, '00109', 1),
(31, 21365, 0, 0, 0, 0, '00109', 1),
(32, 20864, 0, 0, 0, 0, '00109', 1),
(33, 21080, 0, 0, 0, 0, '00109', 1),
(34, 8748, 0, 0, 0, 0, '00109', 1),
(35, 4294, 0, 0, 0, 0, '00109', 1),
(36, 20982, 0, 0, 0, 0, '00109', 1),
(37, 21738, 0, 0, 0, 0, '00109', 1),
(38, 21354, 0, 0, 0, 0, '00109', 1),
(39, 21682, 0, 0, 0, 0, '00109', 1),
(40, 4871, 0, 0, 0, 0, '00109', 1),
(41, 1184, 0, 0, 0, 0, '00109', 1),
(42, 21266, 0, 0, 0, 0, '00109', 1),
(43, 21653, 0, 0, 0, 0, '00109', 1),
(44, 812, 0, 0, 0, 0, '00109', 1),
(45, 21570, 0, 0, 0, 0, '00109', 1),
(46, 5556, 0, 0, 0, 0, '00109', 1),
(47, 21725, 0, 0, 0, 0, '00109', 1),
(48, 17861, 0, 0, 0, 0, '00109', 1),
(49, 21529, 0, 0, 0, 0, '00109', 1),
(50, 809, 0, 0, 0, 0, '00109', 1),
(51, 20582, 0, 0, 0, 0, '00109', 1),
(52, 15410, 0, 0, 0, 0, '00109', 1),
(53, 17063, 0, 0, 0, 0, '00109', 1),
(54, 43, 1, 1, 1, 1, '00109', 1),
(55, 18367, 0, 0, 0, 0, '00109', 1),
(56, 3529, 0, 0, 0, 0, '00109', 1),
(57, 18562, 0, 0, 0, 0, '00109', 1),
(58, 21702, 0, 0, 0, 0, '00109', 1),
(59, 21801, 0, 0, 0, 0, '00109', 1),
(60, 19739, 0, 0, 0, 0, '00109', 1),
(61, 111244, 0, 0, 0, 0, '00109', 1),
(62, 20888, 0, 0, 0, 0, '00109', 1),
(63, 111134, 0, 0, 0, 0, '00109', 1),
(64, 16929, 0, 0, 0, 0, '00109', 1),
(65, 8855, 0, 0, 0, 0, '00109', 1),
(66, 15886, 0, 0, 0, 0, '00109', 1),
(67, 21403, 0, 0, 0, 0, '00109', 1),
(68, 15735, 0, 0, 0, 0, '00109', 1),
(69, 924, 0, 0, 0, 0, '00109', 1),
(70, 389, 0, 0, 0, 0, '00109', 1),
(71, 21372, 0, 0, 0, 0, '00109', 1),
(72, 9441, 0, 0, 0, 0, '00109', 1),
(73, 3959, 0, 0, 0, 0, '00109', 1),
(74, 21006, 0, 0, 0, 0, '00109', 1),
(75, 2684, 0, 0, 0, 0, '00109', 1),
(76, 18890, 0, 0, 0, 0, '00109', 1),
(77, 3447, 0, 0, 0, 0, '00109', 1),
(78, 18413, 0, 0, 0, 0, '00109', 1),
(79, 19830, 0, 0, 0, 0, '00109', 1),
(80, 7066, 0, 0, 0, 0, '00109', 1),
(81, 20884, 0, 0, 0, 0, '00109', 1),
(82, 17216, 0, 0, 0, 0, '00109', 1),
(83, 17446, 0, 0, 0, 0, '00109', 1),
(84, 20953, 0, 0, 0, 0, '00109', 1),
(85, 20292, 0, 0, 0, 0, '00109', 1),
(86, 609, 0, 0, 0, 0, '00109', 1),
(87, 16640, 0, 0, 0, 0, '00109', 1),
(88, 393, 0, 0, 0, 0, '00109', 1),
(89, 21053, 0, 0, 0, 0, '00109', 1),
(90, 3952, 0, 0, 0, 0, '00109', 1),
(91, 21744, 0, 0, 0, 0, '00109', 1),
(92, 21686, 0, 0, 0, 0, '00109', 1),
(93, 847, 0, 0, 0, 0, '00109', 1),
(94, 21755, 0, 0, 0, 0, '00109', 1),
(95, 18691, 0, 0, 0, 0, '00109', 1),
(96, 21542, 0, 0, 0, 0, '00109', 1),
(97, 78, 1, 0, 0, 0, '00109', 1),
(98, 20896, 0, 0, 0, 0, '00109', 1),
(99, 21735, 0, 0, 0, 0, '00109', 1),
(100, 21226, 0, 0, 0, 0, '00109', 1),
(101, 19233, 0, 0, 0, 0, '00109', 1),
(102, 21836, 0, 0, 0, 0, '00109', 1),
(103, 21569, 0, 0, 0, 0, '00109', 1),
(104, 21377, 0, 0, 0, 0, '00109', 1),
(105, 110465, 0, 0, 0, 0, '00109', 1),
(106, 16423, 0, 0, 0, 0, '00109', 1),
(107, 4478, 0, 0, 0, 0, '00109', 1),
(108, 18358, 0, 0, 0, 0, '00109', 1),
(109, 20593, 0, 0, 0, 0, '00109', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cel`
--

CREATE TABLE `cel` (
  `ID` int(10) NOT NULL,
  `IDEmpleado` int(10) NOT NULL,
  `Modelo` varchar(50) NOT NULL,
  `Empresa` int(10) NOT NULL,
  `Tiponom` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cel`
--

INSERT INTO `cel` (`ID`, `IDEmpleado`, `Modelo`, `Empresa`, `Tiponom`) VALUES
(1, 21271, 'Sony M1', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chat`
--

CREATE TABLE `chat` (
  `ID` int(10) NOT NULL,
  `IDUserDe` int(10) NOT NULL,
  `IDUserPara` int(10) NOT NULL,
  `Mensaje` varchar(10000) NOT NULL,
  `Fecha` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `chat`
--

INSERT INTO `chat` (`ID`, `IDUserDe`, `IDUserPara`, `Mensaje`, `Fecha`) VALUES
(1, 1, 21, 'knsjkdnajksndnasdnkjasdjkn', '2017-02-20 10:50:17.282680'),
(2, 21, 1, 'asdjnasdjknjkasdn kjasndkjnaskd kjasndkjnasd kjasdn nasdkkja sd', '2017-02-20 10:53:25.680532'),
(3, 1, 21, 'asd asdjkbjasd asdbasd asjdv asdjhbasd jashdb ajsbd ajhsbd', '2017-02-21 08:12:19.376399'),
(4, 1, 21, 'asdasd asdasd', '2017-02-20 14:52:28.000000'),
(5, 1, 21, 'HOLA MUNDO', '2017-02-20 14:53:02.000000'),
(6, 1, 21, '', '2017-02-21 11:33:29.000000'),
(7, 1, 21, 'hola mundo', '2017-02-21 11:44:46.000000'),
(8, 1, 21, 'probando mensajes', '2017-02-21 11:46:12.000000'),
(9, 21, 22, 'hola prueba2', '2017-02-21 11:48:09.000000'),
(10, 22, 21, 'hola prueba1', '2017-02-21 11:49:43.000000'),
(11, 21, 22, 'como estas ', '2017-02-21 11:50:25.000000'),
(12, 22, 21, 'bien y tu ', '2017-02-21 11:50:40.000000'),
(13, 21, 22, 'tendrás el reporte que te encargue', '2017-02-21 12:29:40.000000'),
(14, 22, 21, 'no aun no me han autorizado la firma ', '2017-02-21 12:30:05.000000'),
(15, 21, 22, 'ok entonces espero tu respuesta', '2017-02-21 12:30:45.000000'),
(16, 22, 21, 'si yo te abiso ', '2017-02-21 12:31:00.000000'),
(17, 21, 22, 'ok', '2017-02-21 12:31:12.000000'),
(18, 21, 22, 'sobre el otro documentos tendrás algo', '2017-02-21 12:38:15.000000'),
(19, 22, 21, 'no aun no ', '2017-02-21 12:38:54.000000'),
(20, 22, 21, 'prueba de fecha', '2017-02-21 13:08:03.000000'),
(21, 22, 21, 'prueba de un texto extenso para verificar la forma del div y tomar encuenta las caracteristicas dada', '2017-02-21 13:09:13.000000'),
(22, 22, 21, 'Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras, al contrario de usar textos como por ejemplo "Contenido aquí, contenido aquí". Estos textos hacen parecerlo un español que se puede leer. Muchos paquetes de autoedición y editores de páginas web usan el Lorem Ipsum como su texto por defecto, y al hacer una búsqueda de "Lorem Ipsum" va a dar por resultado muchos sitios web que usan este texto si se encuentran en estado de desarrollo. Muchas versiones han evolucionado a través de los años, algunas veces por accidente, otras veces a propósito (por ejemplo insertándole humor y cosas por el estilo).', '2017-02-21 13:21:36.000000'),
(23, 21, 22, 'ok', '2017-02-21 13:23:58.000000'),
(24, 21, 22, 'hola', '2017-02-21 14:18:04.000000'),
(25, 22, 21, 'que paso?', '2017-02-21 14:20:19.000000'),
(26, 21, 22, 'confirmacion', '2017-02-21 14:27:57.000000'),
(27, 21, 22, 'hola', '2017-02-21 14:29:32.000000'),
(28, 22, 21, 'hola', '2017-02-21 14:30:00.000000'),
(29, 22, 21, 'hola como estas', '2017-02-21 14:43:11.000000'),
(30, 21, 22, 'asd', '2017-02-21 14:44:05.000000'),
(31, 21, 22, 'a', '2017-02-21 14:44:16.000000'),
(32, 22, 21, 'hola', '2017-02-21 14:45:44.000000'),
(33, 22, 21, 'hola', '2017-02-21 14:45:50.000000'),
(34, 21, 22, 'hola', '2017-02-21 15:05:13.000000'),
(35, 21, 22, 'hola', '2017-02-21 15:10:22.000000'),
(36, 22, 21, 'hola', '2017-02-21 19:21:10.000000'),
(37, 21, 22, 'hola', '2017-02-22 08:18:35.000000'),
(38, 21, 22, 'hhh', '2017-02-22 08:26:11.000000'),
(39, 21, 22, 'hola', '2017-02-22 08:27:06.000000'),
(40, 22, 21, 'hola', '2017-02-22 08:29:58.000000'),
(41, 22, 21, 'hola', '2017-02-22 08:37:01.000000'),
(42, 22, 21, 'como estas', '2017-02-22 08:37:13.000000'),
(43, 21, 22, 'muy bien y tu ', '2017-02-22 08:37:48.000000'),
(44, 22, 21, 'excelente ', '2017-02-22 08:38:10.000000'),
(45, 22, 21, 'tendras el reporte?', '2017-02-22 08:41:31.000000'),
(46, 21, 22, 'no aun no', '2017-02-22 08:43:09.000000'),
(47, 21, 22, 'yo te aviso cuando lo tenga', '2017-02-22 08:44:50.000000'),
(48, 22, 21, 'ok la mensajeria ya quedo ', '2017-02-22 08:45:18.000000'),
(49, 22, 21, 'un poco lenta pero ya quedo ', '2017-02-22 08:45:43.000000'),
(50, 21, 22, 'ok', '2017-02-22 08:51:09.000000'),
(51, 21, 22, 'juan', '2017-02-22 08:52:36.000000'),
(52, 22, 21, 'que paso', '2017-02-22 08:53:11.000000'),
(53, 22, 21, 'hola', '2017-02-22 08:53:34.000000'),
(54, 21, 22, 'no ya no', '2017-02-22 08:53:53.000000'),
(55, 22, 21, 'ok', '2017-02-22 08:54:38.000000'),
(56, 21, 22, 'lol', '2017-02-22 09:00:12.000000'),
(57, 22, 21, 'contrato 48538591', '2017-02-22 09:02:02.000000'),
(58, 21, 22, 'hola', '2017-02-25 18:09:39.000000'),
(59, 1, 21, 's', '2017-03-06 16:02:19.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `config`
--

CREATE TABLE `config` (
  `ID` int(10) NOT NULL,
  `server` varchar(30) NOT NULL,
  `IDEmpresa` int(10) NOT NULL,
  `centro` varchar(25) NOT NULL,
  `DB` varchar(20) NOT NULL,
  `UserDB` varchar(20) NOT NULL,
  `PassDB` varchar(20) NOT NULL,
  `IDUser` int(10) NOT NULL,
  `PC` int(2) NOT NULL,
  `TN` int(2) NOT NULL,
  `PP` int(10) NOT NULL,
  `PA` int(10) NOT NULL,
  `POR` int(5) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `DoS` int(2) NOT NULL,
  `FactorA` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `config`
--

INSERT INTO `config` (`ID`, `server`, `IDEmpresa`, `centro`, `DB`, `UserDB`, `PassDB`, `IDUser`, `PC`, `TN`, `PP`, `PA`, `POR`, `correo`, `DoS`, `FactorA`) VALUES
(1, '127.0.0.1', 1, '827040611000', 'bahia', 'sa', 'Enterprice9', 1, 11, 3, 40, 29, 35, 'rl.juan666@gmail.com', 1, 1),
(18, 'ADICTO969\\JUAN', 2, '611001', 'holy', 'sa', 'Enterprice9', 21, 3, 4, 1, 1, 10, '', 0, 1.1667),
(19, 'HAHAHA\\JUAN', 2, '611001', 'holy', 'sa', 'Enterprice9', 22, 11, 4, 1, 1, 5, '', 0, 1.1667),
(20, 'DESKTOP-2POHOQ5\\JUAN', 1, '66600', 'bahia', 'sa', 'Enterprice9', 23, 1, 1, 1, 1, 5, '', 0, 0),
(21, 'DESKTOP-2POHOQ5\\JUAN', 1, '0111', 'bahia', 'sa', 'Enterprice9', 24, 1, 1, 1, 1, 5, '', 0, 0),
(22, '1', 1, '611101101', '0', '0', '0', 25, 1, 3, 1, 1, 0, '', 0, 1),
(23, '0', 1, '611101101', '0', '0', '0', 25, 1, 3, 1, 1, 5, '', 1, 1),
(24, '0', 1, '827040611000', 'DB', 'USERDB', 'PASS', 1, 11, 3, 1, 1, 1, '', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contrato`
--

CREATE TABLE `contrato` (
  `ID` int(10) NOT NULL,
  `IDEmpleado` int(10) NOT NULL,
  `Observacion` varchar(100) NOT NULL,
  `Contrato` varchar(10) NOT NULL,
  `IDEmpresa` int(10) NOT NULL,
  `centro` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `contrato`
--

INSERT INTO `contrato` (`ID`, `IDEmpleado`, `Observacion`, `Contrato`, `IDEmpresa`, `centro`) VALUES
(1, 53, 'asdjabskjd', 'SI', 1, '00103'),
(2, 2854, 'b', 'NO', 1, '00103'),
(3, 3376, 'asdadhasdb', 'SI', 1, '00103'),
(4, 3401, 'd', 'NO', 1, '00103'),
(5, 3803, 'ahjsvdjhavshdjv', 'SI', 1, '00103'),
(6, 9495, 'f', 'NO', 1, '00103'),
(7, 18777, 'hasdjvahsvdjhvashd', 'SI', 1, '00103'),
(8, 43, '', 'vacio', 1, '00109'),
(9, 78, '', 'vacio', 1, '00109'),
(10, 112, '', 'vacio', 1, '00109'),
(11, 389, '', 'vacio', 1, '00109'),
(12, 393, '', 'vacio', 1, '00109'),
(13, 609, '', 'vacio', 1, '00109'),
(14, 809, '', 'vacio', 1, '00109'),
(15, 812, '', 'vacio', 1, '00109'),
(16, 847, '', 'vacio', 1, '00109'),
(17, 924, '', 'vacio', 1, '00109'),
(18, 1184, '', 'vacio', 1, '00109'),
(19, 2684, '', 'vacio', 1, '00109'),
(20, 2686, '', 'vacio', 1, '00109'),
(21, 3050, '', 'vacio', 1, '00109'),
(22, 3078, '', 'vacio', 1, '00109'),
(23, 3259, '', 'vacio', 1, '00109'),
(24, 3359, '', 'vacio', 1, '00109'),
(25, 3447, '', 'vacio', 1, '00109'),
(26, 3529, '', 'vacio', 1, '00109'),
(27, 3952, '', 'vacio', 1, '00109'),
(28, 3959, '', 'vacio', 1, '00109'),
(29, 4294, '', 'vacio', 1, '00109'),
(30, 4478, '', 'vacio', 1, '00109'),
(31, 4871, '', 'vacio', 1, '00109'),
(32, 5556, '', 'vacio', 1, '00109'),
(33, 5960, '', 'vacio', 1, '00109'),
(34, 7066, '', 'vacio', 1, '00109'),
(35, 8092, '', 'vacio', 1, '00109'),
(36, 8748, '', 'vacio', 1, '00109'),
(37, 8845, '', 'vacio', 1, '00109'),
(38, 8855, '', 'vacio', 1, '00109'),
(39, 9201, '', 'vacio', 1, '00109'),
(40, 9441, '', 'vacio', 1, '00109'),
(41, 15225, '', 'vacio', 1, '00109'),
(42, 15410, '', 'vacio', 1, '00109'),
(43, 15735, '', 'vacio', 1, '00109'),
(44, 15886, '', 'vacio', 1, '00109'),
(45, 16423, '', 'vacio', 1, '00109'),
(46, 16630, '', 'vacio', 1, '00109'),
(47, 16640, '', 'vacio', 1, '00109'),
(48, 16929, '', 'vacio', 1, '00109'),
(49, 17063, '', 'vacio', 1, '00109'),
(50, 17216, '', 'vacio', 1, '00109'),
(51, 17446, '', 'vacio', 1, '00109'),
(52, 17861, '', 'vacio', 1, '00109'),
(53, 18358, '', 'vacio', 1, '00109'),
(54, 18367, '', 'vacio', 1, '00109'),
(55, 18413, '', 'vacio', 1, '00109'),
(56, 18562, '', 'vacio', 1, '00109'),
(57, 18691, '', 'vacio', 1, '00109'),
(58, 18890, '', 'vacio', 1, '00109'),
(59, 19183, '', 'vacio', 1, '00109'),
(60, 19190, '', 'vacio', 1, '00109'),
(61, 19203, '', 'vacio', 1, '00109'),
(62, 19233, '', 'vacio', 1, '00109'),
(63, 19739, '', 'vacio', 1, '00109'),
(64, 19830, '', 'vacio', 1, '00109'),
(65, 20292, '', 'vacio', 1, '00109'),
(66, 20322, '', 'vacio', 1, '00109'),
(67, 20434, '', 'vacio', 1, '00109'),
(68, 20495, '', 'vacio', 1, '00109'),
(69, 20518, '', 'vacio', 1, '00109'),
(70, 20582, '', 'vacio', 1, '00109'),
(71, 20593, '', 'vacio', 1, '00109'),
(72, 20635, '', 'vacio', 1, '00109'),
(73, 20752, '', 'vacio', 1, '00109'),
(74, 20864, '', 'vacio', 1, '00109'),
(75, 20873, '', 'vacio', 1, '00109'),
(76, 20884, '', 'vacio', 1, '00109'),
(77, 20888, '', 'vacio', 1, '00109'),
(78, 20896, '', 'vacio', 1, '00109'),
(79, 20953, '', 'vacio', 1, '00109'),
(80, 20982, '', 'vacio', 1, '00109'),
(81, 21006, '', 'vacio', 1, '00109'),
(82, 21053, '', 'vacio', 1, '00109'),
(83, 21080, '', 'vacio', 1, '00109'),
(84, 21152, '', 'vacio', 1, '00109'),
(85, 21226, '', 'vacio', 1, '00109'),
(86, 21266, '', 'vacio', 1, '00109'),
(87, 21354, '', 'vacio', 1, '00109'),
(88, 21365, '', 'vacio', 1, '00109'),
(89, 21372, '', 'vacio', 1, '00109'),
(90, 21377, '', 'vacio', 1, '00109'),
(91, 21403, '', 'vacio', 1, '00109'),
(92, 21529, '', 'vacio', 1, '00109'),
(93, 21532, '', 'vacio', 1, '00109'),
(94, 21542, '', 'vacio', 1, '00109'),
(95, 21569, '', 'vacio', 1, '00109'),
(96, 21570, '', 'vacio', 1, '00109'),
(97, 21653, '', 'vacio', 1, '00109'),
(98, 21667, '', 'vacio', 1, '00109'),
(99, 21682, '', 'vacio', 1, '00109'),
(100, 21686, '', 'vacio', 1, '00109'),
(101, 21697, '', 'vacio', 1, '00109'),
(102, 21702, '', 'vacio', 1, '00109'),
(103, 21725, '', 'vacio', 1, '00109'),
(104, 21732, '', 'vacio', 1, '00109'),
(105, 21735, '', 'vacio', 1, '00109'),
(106, 21736, '', 'vacio', 1, '00109'),
(107, 21738, '', 'vacio', 1, '00109'),
(108, 21744, '', 'vacio', 1, '00109'),
(109, 21755, '', 'vacio', 1, '00109'),
(110, 21790, '', 'vacio', 1, '00109'),
(111, 21801, '', 'vacio', 1, '00109'),
(112, 21836, '', 'vacio', 1, '00109'),
(113, 21839, '', 'vacio', 1, '00109'),
(114, 110465, '', 'vacio', 1, '00109'),
(115, 111134, '', 'vacio', 1, '00109'),
(116, 111244, '', 'vacio', 1, '00109'),
(117, 3921, 'asd', 'SI', 1, '30600'),
(118, 17946, 'asdasdasd', 'NO', 1, '30600'),
(119, 18548, 'asdasd asd asd', 'SI', 1, '30600'),
(120, 20214, 'a', 'NO', 1, '30600'),
(121, 20369, 'asdasd', 'SI', 1, '30600'),
(122, 20806, 'asdasd ad', 'NO', 1, '30600'),
(123, 110305, 'asda sda d', 'SI', 1, '30600'),
(124, 110597, 'asdas d', 'vacio', 1, '30600'),
(125, 110811, '', 'vacio', 1, '30600'),
(126, 110869, '', 'vacio', 1, '30600'),
(127, 111025, '', 'vacio', 1, '30600'),
(128, 111237, '', 'SI', 1, '30600'),
(129, 111624, '', 'NO', 1, '30600'),
(130, 111989, '', 'SI', 1, '30600'),
(131, 111998, '', 'NO', 1, '30600'),
(132, 112047, '', 'SI', 1, '30600'),
(133, 112142, '', 'NO', 1, '30600'),
(134, 112146, '', 'SI', 1, '30600'),
(135, 112361, 'asd asd asd', 'NO', 1, '30600'),
(136, 112501, '', 'SI', 1, '30600'),
(137, 112525, '', 'NO', 1, '30600'),
(138, 112540, '', 'SI', 1, '30600'),
(139, 112595, '', 'NO', 1, '30600'),
(140, 112632, '', 'SI', 1, '30600'),
(141, 112663, 'asd asd asd', 'NO', 1, '30600'),
(142, 112729, 'asd adad asd ad', 'SI', 1, '30600'),
(143, 1050, 'a', 'SI', 1, '827040210400'),
(144, 1052, '', 'vacio', 1, '827040210400'),
(145, 1060, '', 'vacio', 1, '827040210400'),
(146, 1239, '', 'vacio', 1, '827040210400'),
(147, 1388, '', 'vacio', 1, '827040210400'),
(148, 1440, '', 'vacio', 1, '827040210400'),
(149, 1520, '', 'vacio', 1, '827040210400'),
(150, 1522, '', 'vacio', 1, '827040210400'),
(151, 1523, '', 'vacio', 1, '827040210400'),
(152, 1531, '', 'vacio', 1, '827040210400'),
(153, 1547, '', 'vacio', 1, '827040210400'),
(154, 2001, '', 'vacio', 1, '827040210400'),
(155, 2007, '', 'vacio', 1, '827040210400'),
(156, 2010, '', 'vacio', 1, '827040210400'),
(157, 2012, '', 'vacio', 1, '827040210400'),
(158, 2013, '', 'vacio', 1, '827040210400'),
(159, 2014, '', 'vacio', 1, '827040210400'),
(160, 2016, '', 'vacio', 1, '827040210400'),
(161, 2057, '', 'vacio', 1, '827040210400'),
(162, 2062, '', 'vacio', 1, '827040210400'),
(163, 2067, '', 'vacio', 1, '827040210400'),
(164, 2074, '', 'vacio', 1, '827040210400'),
(165, 2075, '', 'vacio', 1, '827040210400'),
(166, 2086, '', 'vacio', 1, '827040210400'),
(167, 2088, '', 'vacio', 1, '827040210400'),
(168, 2093, '', 'vacio', 1, '827040210400'),
(169, 2097, '', 'vacio', 1, '827040210400'),
(170, 2118, '', 'vacio', 1, '827040210400'),
(171, 2123, '', 'vacio', 1, '827040210400'),
(172, 2149, '', 'vacio', 1, '827040210400'),
(173, 2167, '', 'vacio', 1, '827040210400'),
(174, 2168, '', 'vacio', 1, '827040210400'),
(175, 2177, '', 'vacio', 1, '827040210400'),
(176, 2179, '', 'vacio', 1, '827040210400'),
(177, 2182, '', 'vacio', 1, '827040210400'),
(178, 2191, '', 'vacio', 1, '827040210400'),
(179, 2197, '', 'vacio', 1, '827040210400'),
(180, 3068, '', 'vacio', 1, '827040210400'),
(181, 3328, '', 'vacio', 1, '827040210400'),
(182, 3596, '', 'vacio', 1, '827040210400'),
(183, 3666, '', 'vacio', 1, '827040210400'),
(184, 3778, '', 'vacio', 1, '827040210400'),
(185, 3786, '', 'vacio', 1, '827040210400'),
(186, 5040, '', 'vacio', 1, '827040210400'),
(187, 5374, '', 'vacio', 1, '827040210400'),
(188, 5382, '', 'vacio', 1, '827040210400'),
(189, 6096, '', 'vacio', 1, '827040210400'),
(190, 6124, '', 'vacio', 1, '827040210400'),
(191, 6125, '', 'vacio', 1, '827040210400'),
(192, 6144, '', 'vacio', 1, '827040210400'),
(193, 6150, '', 'vacio', 1, '827040210400'),
(194, 6151, '', 'vacio', 1, '827040210400'),
(195, 6153, '', 'vacio', 1, '827040210400'),
(196, 6155, '', 'vacio', 1, '827040210400'),
(197, 6157, '', 'vacio', 1, '827040210400'),
(198, 6158, '', 'vacio', 1, '827040210400'),
(199, 6160, '', 'vacio', 1, '827040210400'),
(200, 6164, '', 'vacio', 1, '827040210400'),
(201, 6226, '', 'vacio', 1, '827040210400'),
(202, 6240, '', 'vacio', 1, '827040210400'),
(203, 6246, '', 'vacio', 1, '827040210400'),
(204, 6272, '', 'vacio', 1, '827040210400'),
(205, 6299, '', 'vacio', 1, '827040210400'),
(206, 6305, '', 'vacio', 1, '827040210400'),
(207, 6307, '', 'vacio', 1, '827040210400'),
(208, 6309, '', 'vacio', 1, '827040210400'),
(209, 6311, '', 'vacio', 1, '827040210400'),
(210, 6312, '', 'vacio', 1, '827040210400'),
(211, 6313, '', 'vacio', 1, '827040210400'),
(212, 6316, '', 'vacio', 1, '827040210400'),
(213, 6318, '', 'vacio', 1, '827040210400'),
(214, 6328, '', 'vacio', 1, '827040210400'),
(215, 6362, '', 'vacio', 1, '827040210400'),
(216, 6363, '', 'vacio', 1, '827040210400'),
(217, 6366, '', 'vacio', 1, '827040210400'),
(218, 6372, '', 'vacio', 1, '827040210400'),
(219, 6376, '', 'vacio', 1, '827040210400'),
(220, 6386, '', 'vacio', 1, '827040210400'),
(221, 6389, '', 'vacio', 1, '827040210400'),
(222, 6394, '', 'vacio', 1, '827040210400'),
(223, 6395, '', 'vacio', 1, '827040210400'),
(224, 6397, '', 'vacio', 1, '827040210400'),
(225, 6398, '', 'vacio', 1, '827040210400'),
(226, 6400, '', 'vacio', 1, '827040210400'),
(227, 6435, '', 'vacio', 1, '827040210400'),
(228, 6453, '', 'vacio', 1, '827040210400'),
(229, 6460, '', 'vacio', 1, '827040210400'),
(230, 6462, '', 'vacio', 1, '827040210400'),
(231, 6472, '', 'vacio', 1, '827040210400'),
(232, 6487, '', 'vacio', 1, '827040210400'),
(233, 6500, '', 'vacio', 1, '827040210400'),
(234, 6524, '', 'vacio', 1, '827040210400'),
(235, 6531, '', 'vacio', 1, '827040210400'),
(236, 6536, '', 'vacio', 1, '827040210400'),
(237, 6545, '', 'vacio', 1, '827040210400'),
(238, 6581, '', 'vacio', 1, '827040210400'),
(239, 6604, '', 'vacio', 1, '827040210400'),
(240, 6606, '', 'vacio', 1, '827040210400'),
(241, 6616, '', 'vacio', 1, '827040210400'),
(242, 6617, '', 'vacio', 1, '827040210400'),
(243, 6619, '', 'vacio', 1, '827040210400'),
(244, 6620, '', 'vacio', 1, '827040210400'),
(245, 6621, '', 'vacio', 1, '827040210400'),
(246, 6623, '', 'vacio', 1, '827040210400'),
(247, 6637, '', 'vacio', 1, '827040210400'),
(248, 6638, '', 'vacio', 1, '827040210400'),
(249, 6648, '', 'vacio', 1, '827040210400'),
(250, 6651, '', 'vacio', 1, '827040210400'),
(251, 6665, '', 'vacio', 1, '827040210400'),
(252, 8137, '', 'vacio', 1, '827040210400'),
(253, 8228, '', 'vacio', 1, '827040210400'),
(254, 8256, '', 'vacio', 1, '827040210400'),
(255, 8268, '', 'vacio', 1, '827040210400'),
(256, 8383, '', 'vacio', 1, '827040210400'),
(257, 8466, '', 'vacio', 1, '827040210400'),
(258, 8472, '', 'vacio', 1, '827040210400'),
(259, 8640, '', 'vacio', 1, '827040210400'),
(260, 8641, '', 'vacio', 1, '827040210400'),
(261, 9115, '', 'vacio', 1, '827040210400'),
(262, 9137, '', 'vacio', 1, '827040210400'),
(263, 9270, '', 'vacio', 1, '827040210400'),
(264, 9337, '', 'vacio', 1, '827040210400'),
(265, 9346, '', 'vacio', 1, '827040210400'),
(266, 9459, '', 'vacio', 1, '827040210400'),
(267, 9808, '', 'vacio', 1, '827040210400'),
(268, 9813, '', 'vacio', 1, '827040210400'),
(269, 10032, '', 'vacio', 1, '827040210400'),
(270, 10036, '', 'vacio', 1, '827040210400'),
(271, 10038, '', 'NO', 1, '827040210400'),
(272, 10039, '', 'SI', 1, '827040210400'),
(273, 10040, '', 'NO', 1, '827040210400'),
(274, 10050, '', 'vacio', 1, '827040210400');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos`
--

CREATE TABLE `datos` (
  `ID` int(30) NOT NULL,
  `codigo` int(30) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `valor` varchar(2) NOT NULL,
  `periodoP` int(5) NOT NULL,
  `tipoN` int(5) NOT NULL,
  `IDEmpresa` int(10) NOT NULL,
  `Centro` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datos`
--

INSERT INTO `datos` (`ID`, `codigo`, `nombre`, `valor`, `periodoP`, `tipoN`, `IDEmpresa`, `Centro`) VALUES
(1, 43, 'fecha4306-03-2016', 'F', 11, 1, 1, '00109'),
(2, 78, 'fecha7803-03-2016', 'G', 11, 1, 1, '00109'),
(3, 112, 'fecha11206-03-2016', 'F', 11, 1, 1, '00109'),
(4, 389, 'fecha38906-03-2016', 'J', 11, 1, 1, '00109'),
(5, 20369, 'fecha2036903-03-2016', 'F', 11, 1, 1, '30600'),
(6, 112361, 'fecha11236105-03-2016', 'G', 11, 1, 1, '30600'),
(7, 112501, 'fecha11250105-03-2016', 'G', 11, 1, 1, '30600'),
(8, 112540, 'fecha11254006-03-2016', 'H', 11, 1, 1, '30600'),
(43, 1326, 'fecha132615-10-2016', 'F', 20, 3, 1, '827040110900'),
(44, 1326, 'fecha132616-10-2016', 'F', 20, 3, 1, '827040110900'),
(45, 1326, 'fecha132622-10-2016', 'F', 20, 3, 1, '827040110900'),
(46, 1452, 'fecha145215-10-2016', 'F', 20, 3, 1, '827040110900'),
(47, 1452, 'fecha145216-10-2016', 'F', 20, 3, 1, '827040110900'),
(48, 1452, 'fecha145222-10-2016', 'F', 20, 3, 1, '827040110900'),
(49, 2034, 'fecha203414-10-2016', 'F', 20, 3, 1, '827040110903'),
(50, 633, 'fecha63317-01-2016', 'F', 3, 4, 2, '611001'),
(51, 8352, 'fecha835219-01-2016', 'F', 3, 4, 2, '611001');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosanti`
--

CREATE TABLE `datosanti` (
  `ID` int(30) NOT NULL,
  `codigo` int(30) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `valor` varchar(2) NOT NULL,
  `periodoP` int(5) NOT NULL,
  `tipoN` int(5) NOT NULL,
  `IDEmpresa` int(10) NOT NULL,
  `Centro` varchar(20) NOT NULL,
  `Autorizo1` int(2) NOT NULL,
  `Autorizo2` int(2) NOT NULL,
  `Autorizo3` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datosanti`
--

INSERT INTO `datosanti` (`ID`, `codigo`, `nombre`, `valor`, `periodoP`, `tipoN`, `IDEmpresa`, `Centro`, `Autorizo1`, `Autorizo2`, `Autorizo3`) VALUES
(1, 8729, 'fecha01-03-2016', 'F', 11, 1, 1, '30100', 1, 1, 0),
(2, 8720, 'fecha29-02-2016', 'D', 11, 1, 1, '30100', 0, 0, 0),
(3, 633, 'fecha31-01-2016', 'G', 3, 4, 2, '611001', 1, 1, 0),
(4, 633, 'fecha27-01-2016', 'F', 3, 4, 2, '611001', 1, 0, 0),
(5, 633, 'fecha01-02-2016', 'F', 3, 4, 2, '611001', 1, 0, 0),
(6, 633, 'fecha02-02-2016', 'V', 3, 4, 2, '611001', 1, 0, 0),
(7, 633, 'fecha03-02-2016', 'S', 3, 4, 2, '611001', 1, 0, 0),
(8, 633, 'fecha04-02-2016', 'T', 3, 4, 2, '611001', 1, 0, 0),
(9, 11, 'fecha27-01-2016', 'F', 3, 4, 2, '611001', 1, 0, 0),
(10, 11, 'fecha29-01-2016', 'F', 3, 4, 2, '611001', 1, 0, 0),
(11, 11, 'fecha31-01-2016', 'F', 3, 4, 2, '611001', 1, 0, 0),
(12, 11, 'fecha01-02-2016', 'V', 3, 4, 2, '611001', 1, 1, 0),
(13, 11, 'fecha02-02-2016', 'V', 3, 4, 2, '611001', 1, 1, 0),
(14, 5098, 'fecha26-01-2016', 'V', 3, 4, 2, '611001', 0, 0, 0),
(15, 5098, 'fecha27-01-2016', 'V', 3, 4, 2, '611001', 0, 0, 0),
(16, 1450, 'fecha31-01-2016', 'V', 3, 4, 2, '611001', 1, 0, 0),
(17, 1450, 'fecha01-02-2016', 'V', 3, 4, 2, '611001', 0, 0, 0),
(18, 1450, 'fecha02-02-2016', 'V', 3, 4, 2, '611001', 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premio`
--

CREATE TABLE `premio` (
  `ID` int(100) NOT NULL,
  `codigo` int(20) NOT NULL,
  `PP` float DEFAULT NULL,
  `PA` float DEFAULT NULL,
  `TN` int(10) NOT NULL,
  `Periodo` int(10) NOT NULL,
  `Centro` varchar(20) NOT NULL,
  `IDEmpresa` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `premio`
--

INSERT INTO `premio` (`ID`, `codigo`, `PP`, `PA`, `TN`, `Periodo`, `Centro`, `IDEmpresa`) VALUES
(1, 78, 20, 10, 1, 11, '00109', 1),
(2, 112, 30, 10, 1, 11, '00109', 1),
(3, 389, 25, 0, 1, 11, '00109', 1),
(4, 112361, 410, 0, 1, 11, '30600', 1),
(5, 112501, 51, 0, 1, 11, '30600', 1),
(6, 112540, 52, 0, 1, 11, '30600', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `retardo`
--

CREATE TABLE `retardo` (
  `ID` int(10) NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `fecha` varchar(10) NOT NULL,
  `valor` varchar(10) NOT NULL,
  `TN` int(5) NOT NULL,
  `Dep` varchar(10) NOT NULL,
  `periodo` int(10) NOT NULL,
  `IDEmpresa` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `retardo`
--

INSERT INTO `retardo` (`ID`, `codigo`, `fecha`, `valor`, `TN`, `Dep`, `periodo`, `IDEmpresa`) VALUES
(1, '8499', '21-04-2016', 'R', 4, '631000', 8, 2),
(2, '8505', '23-04-2016', 'R', 4, '631000', 8, 2),
(3, '8505', '25-04-2016', 'R', 4, '631000', 8, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `staffing`
--

CREATE TABLE `staffing` (
  `ID` int(10) NOT NULL,
  `IDEmpresa` int(10) NOT NULL,
  `centro` varchar(25) NOT NULL,
  `ocupacion` int(10) NOT NULL,
  `v5` int(10) NOT NULL,
  `v10` int(10) NOT NULL,
  `v15` int(10) NOT NULL,
  `v20` int(10) NOT NULL,
  `v25` int(10) NOT NULL,
  `v30` int(10) NOT NULL,
  `v35` int(10) NOT NULL,
  `v40` int(10) NOT NULL,
  `v45` int(10) NOT NULL,
  `v50` int(10) NOT NULL,
  `v55` int(10) NOT NULL,
  `v60` int(10) NOT NULL,
  `v65` int(10) NOT NULL,
  `v70` int(10) NOT NULL,
  `v75` int(10) NOT NULL,
  `v80` int(10) NOT NULL,
  `v85` int(10) NOT NULL,
  `v90` int(10) NOT NULL,
  `v95` int(10) NOT NULL,
  `v100` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `staffing`
--

INSERT INTO `staffing` (`ID`, `IDEmpresa`, `centro`, `ocupacion`, `v5`, `v10`, `v15`, `v20`, `v25`, `v30`, `v35`, `v40`, `v45`, `v50`, `v55`, `v60`, `v65`, `v70`, `v75`, `v80`, `v85`, `v90`, `v95`, `v100`) VALUES
(1, 1, '00109', 20, 10, 10, 0, 0, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 1, '00109', 50, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 1, '00109', 51, 50, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(4, 1, '00109', 52, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 1, '00109', 53, 15, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 1, '00109', 132, 16, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 1, '00109', 148, 20, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 1, '00109', 149, 30, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(9, 1, '00109', 425, 25, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(10, 1, '00109', 452, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 2, '611001', 5, 2, 2, 3, 4, 5, 10, 10, 10, 10, 10, 20, 30, 30, 30, 30, 40, 40, 40, 40, 45),
(12, 2, '611001', 33, 1, 2, 3, 4, 5, 10, 10, 10, 10, 10, 20, 30, 30, 30, 30, 40, 40, 40, 40, 45),
(13, 2, '611001', 88, 1, 2, 3, 4, 5, 10, 10, 10, 10, 10, 20, 30, 30, 30, 30, 40, 40, 40, 40, 45),
(14, 2, '611001', 95, 1, 2, 3, 4, 5, 10, 10, 10, 10, 10, 20, 30, 30, 30, 30, 40, 40, 40, 40, 45),
(15, 2, '611001', 166, 1, 2, 3, 4, 5, 10, 10, 10, 10, 10, 20, 30, 30, 30, 30, 40, 40, 40, 40, 45),
(16, 2, '611001', 172, 1, 2, 3, 4, 5, 10, 10, 10, 10, 10, 20, 30, 30, 30, 30, 40, 40, 40, 40, 45),
(17, 2, '611001', 178, 1, 2, 3, 4, 5, 10, 10, 10, 10, 10, 20, 30, 30, 30, 30, 40, 40, 40, 40, 45),
(18, 2, '611001', 191, 1, 2, 3, 4, 5, 10, 10, 10, 10, 10, 20, 30, 30, 30, 30, 40, 40, 40, 40, 45),
(19, 2, '651000', 33, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(20, 2, '651000', 103, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 2, '651000', 116, 10, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(10) NOT NULL,
  `User` varchar(30) NOT NULL,
  `Pass` varchar(30) NOT NULL,
  `Permiso` int(1) NOT NULL,
  `Dep` int(2) NOT NULL,
  `sudo` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `User`, `Pass`, `Permiso`, `Dep`, `sudo`) VALUES
(1, 'sudo', 'sudosu', 1, 1234, 1),
(21, 'prueba1', '0102030405', 1, 1234, 1),
(22, 'prueba2', '0102030405', 0, 2, 0),
(23, 'hu', '1', 0, 2, 0),
(24, 's', '1', 0, 2, 0),
(25, 'juan', '0101', 0, 1, 0),
(26, 'jj', 'jj', 0, 1, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ajusteempleado`
--
ALTER TABLE `ajusteempleado`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `cel`
--
ALTER TABLE `cel`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `contrato`
--
ALTER TABLE `contrato`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `datos`
--
ALTER TABLE `datos`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `datosanti`
--
ALTER TABLE `datosanti`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `premio`
--
ALTER TABLE `premio`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `retardo`
--
ALTER TABLE `retardo`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `staffing`
--
ALTER TABLE `staffing`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ajusteempleado`
--
ALTER TABLE `ajusteempleado`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;
--
-- AUTO_INCREMENT de la tabla `cel`
--
ALTER TABLE `cel`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `chat`
--
ALTER TABLE `chat`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT de la tabla `config`
--
ALTER TABLE `config`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT de la tabla `contrato`
--
ALTER TABLE `contrato`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;
--
-- AUTO_INCREMENT de la tabla `datos`
--
ALTER TABLE `datos`
  MODIFY `ID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT de la tabla `datosanti`
--
ALTER TABLE `datosanti`
  MODIFY `ID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT de la tabla `premio`
--
ALTER TABLE `premio`
  MODIFY `ID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `retardo`
--
ALTER TABLE `retardo`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `staffing`
--
ALTER TABLE `staffing`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
