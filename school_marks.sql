-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-01-2019 a las 17:02:24
-- Versión del servidor: 5.7.17
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `school marks`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `userid` varchar(25) NOT NULL,
  `subjectid` char(3) NOT NULL,
  `taskname` varchar(25) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `marks` decimal(4,2) DEFAULT NULL,
  `evaluation` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `marks`
--

INSERT INTO `marks` (`id`, `userid`, `subjectid`, `taskname`, `description`, `marks`, `evaluation`) VALUES
(1, 'laura', 'IAW', 'Ejercicios clase', 'qsd', '9.00', '1º Evaluation');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subjects`
--

CREATE TABLE `subjects` (
  `ID` char(3) NOT NULL,
  `Name` varchar(25) DEFAULT NULL,
  `teacher` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `subjects`
--

INSERT INTO `subjects` (`ID`, `Name`, `teacher`) VALUES
('IAW', 'Implantacion de app', 'arigo'),
('ASO', 'Administracion de SO', 'arigo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subjects_users`
--

CREATE TABLE `subjects_users` (
  `user` varchar(25) NOT NULL,
  `subjectid` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `subjects_users`
--

INSERT INTO `subjects_users` (`user`, `subjectid`) VALUES
('arigo', 'ASO'),
('laura', 'ASO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tasktypes`
--

CREATE TABLE `tasktypes` (
  `name` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tasktypes`
--

INSERT INTO `tasktypes` (`name`) VALUES
('Ejercicios clase'),
('Examenes');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user` varchar(25) NOT NULL,
  `firstname` varchar(25) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `type` varchar(10) NOT NULL,
  `phone` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user`, `firstname`, `lastname`, `email`, `password`, `type`, `phone`) VALUES
('laura', 'Laura', 'Olivas Campano', 'laura@example.com', '94745df4bd94de756ea5436584fec066fc7898d5', 'student', 608966055),
('diegor', 'diegor', 'rer', 'email@email.com', '12c6fc06c99a462375eeb3f43dfd832b08ca9e17', 'student', 567890),
('luisa', 'Luis', 'Martin', 'me@example.com', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'student', 1234),
('pacopakito', 'Paco', 'Paquito', 'me@example.com', '988f431b149fce4d08af08839340c98b4cb02c35', 'student', 12345),
('poiuytr', 'Laura', 'Olivas', 'lauraolivas@gmail.com', 'asdfghj', 'teacher', 876389),
('laurita', 'Laura', 'Olivas', 'laura@hola.es', '94745df4bd94de756ea5436584fec066fc7898d5', 'root', 456666),
('arigo', 'asdf', 'asdf', 'asdf@azsdf-', '356a192b7913b04c54574d18c28d46e6395428ab', 'teacher', 12345),
('fghj', 'gh', 'hj', 'hhhh@ghh.hgg', 'gggg', 'student', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `subjects_users`
--
ALTER TABLE `subjects_users`
  ADD PRIMARY KEY (`user`,`subjectid`);

--
-- Indices de la tabla `tasktypes`
--
ALTER TABLE `tasktypes`
  ADD PRIMARY KEY (`name`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
