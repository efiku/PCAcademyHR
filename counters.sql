-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 18 Lut 2015, 21:08
-- Wersja serwera: 5.5.38-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `counters`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ELECTRICITY_METER_READS`
--

CREATE TABLE IF NOT EXISTS `ELECTRICITY_METER_READS` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `READ` decimal(10,2) NOT NULL,
  `DATE` date NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Zrzut danych tabeli `ELECTRICITY_METER_READS`
--

INSERT INTO `ELECTRICITY_METER_READS` (`ID`, `READ`, `DATE`) VALUES
(1, 0.00, '2014-01-01'),
(2, 149.90, '2014-01-30'),
(3, 222.22, '2014-02-15'),
(4, 340.10, '2014-03-03'),
(5, 552.99, '2014-04-15'),
(6, 670.04, '2014-05-10'),
(7, 920.24, '2014-07-01'),
(8, 1000.01, '2014-07-15'),
(9, 1060.40, '2014-08-14'),
(10, 1129.50, '2014-09-02'),
(11, 1290.87, '2014-10-02'),
(12, 1460.16, '2014-11-05'),
(13, 1626.44, '2014-12-01'),
(14, 1818.18, '2014-12-31');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
