-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 10-01-2025 a las 20:29:13
-- Versión del servidor: 5.7.32
-- Versión de PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `s01f7025_peluqueria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Razas`
--

CREATE TABLE `Razas` (
  `Raza` varchar(25) DEFAULT NULL,
  `Id` int(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `Razas`
--

INSERT INTO `Razas` (`Raza`, `Id`) VALUES
('Afgano', 1),
('Airedale Terrier', 2),
('Akita Inu', 3),
('Alano', 4),
('Alaskan Malamute', 5),
('Basset Hound', 6),
('Beagle', 7),
('Bearded Collie', 8),
('Bichon', 9),
('Bloodhound', 10),
('Bobtail', 11),
('Boston Terrier', 12),
('Boxer', 13),
('Boyero de Flandes', 14),
('Braco Alemán', 15),
('Bulldog Francés', 16),
('Bulldog Inglés', 17),
('Bullmastiff', 18),
('Bullterrier', 19),
('Ca de Bestiar', 20),
('Cairn Terrier', 21),
('Caniche', 22),
('Carlino', 23),
('Chihuahua', 24),
('Chino Crestado', 25),
('Chow Chow', 26),
('Cocker Spaniel', 27),
('Dálmata', 28),
('Doberman', 29),
('Dogo Alemán', 30),
('Dogo Argentino', 31),
('Dogo de Burdeos', 32),
('Drahthaar', 33),
('Epagneul Breton', 34),
('Eurasier', 35),
('Fila Brasileño', 36),
('Fox Terrier', 37),
('Galgo Español', 38),
('Galgo Italiano', 39),
('Galgo Ruso', 40),
('Golden Retriever', 41),
('Gos D´atura', 42),
('Irish Wolfhound', 43),
('Jack Russel', 44),
('Kerry Blue', 45),
('Komondor', 46),
('Labrador Retriever', 47),
('Leonberg', 48),
('Lhasa Apso', 49),
('Maltés', 50),
('Mastín del Pirineo', 51),
('Mastín Español', 52),
('Mastín Napolitano', 53),
('Montaña del Pirineo', 54),
('Pachon Navarro', 55),
('Papillon', 56),
('Pastor Alemán', 57),
('Pastor Belga', 58),
('Pastor B. Malinois', 59),
('Pastor de Beauce', 60),
('Pastor de Brie', 61),
('Pequines', 62),
('Perdiguero Burgos', 63),
('Perro de Aguas Español', 64),
('Pinscher Miniatura', 65),
('Podenco Andaluz', 66),
('Podenco Ibicenco', 67),
('Podenco Portugues', 68),
('Pointer', 69),
('Pomerania', 70),
('Presa Canario', 71),
('Puli', 72),
('Rhodesian Ridgebak', 73),
('Rottweiler', 74),
('Rough Collie', 75),
('Sabueso Español', 76),
('Saluki', 77),
('Samoyedo', 78),
('San Bernardo', 79),
('Schnaucer', 80),
('Scottish Terrier', 81),
('Sealyhalm Terrier', 82),
('Setter Gordon', 83),
('Setter Inglés', 84),
('Setter Irlandes', 85),
('Shar Pei', 86),
('Shetland Sheep', 87),
('Shiba Inu', 88),
('Shih Tzu', 89),
('Siberian Husky', 90),
('Smooth Collie', 91),
('Stafford Terrier', 92),
('Teckel', 93),
('Terranova', 94),
('Terrier Ruso', 95),
('Tibetan Terrier', 96),
('Welhs Terrier', 97),
('West Highland T.', 98),
('Wolfspitz', 99),
('Yorkshire Terrier', 100);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Razas`
--
ALTER TABLE `Razas`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Razas`
--
ALTER TABLE `Razas`
  MODIFY `Id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
