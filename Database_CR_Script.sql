-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1:3306
-- Létrehozás ideje: 2026. Ápr 10. 21:17
-- Kiszolgáló verziója: 9.1.0
-- PHP verzió: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `books`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `author`
--

DROP TABLE IF EXISTS `author`;
CREATE TABLE IF NOT EXISTS `author` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb3_hungarian_ci,
  `bio` text COLLATE utf8mb3_hungarian_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `author`
--

INSERT INTO `author` (`id`, `name`, `bio`) VALUES
(1, 'Lengyelfi Edit', NULL),
(2, 'Raven Kennedy', NULL),
(3, 'Chloe Walsh', 'ASd'),
(4, 'Karády Anna', NULL),
(5, 'Rebecca Yarros', NULL);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` bigint NOT NULL,
  `author_id` int DEFAULT NULL,
  `name` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_hungarian_ci,
  `category_id` int DEFAULT NULL,
  `photo` text COLLATE utf8mb3_hungarian_ci,
  `release_year` int DEFAULT NULL,
  `publisher_id` int DEFAULT NULL,
  `description` text COLLATE utf8mb3_hungarian_ci,
  `series_id` int DEFAULT NULL,
  `series_num` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `publisher_id` (`publisher_id`),
  KEY `series_id` (`series_id`),
  KEY `books_ibfk_2` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `books`
--

INSERT INTO `books` (`id`, `author_id`, `name`, `category_id`, `photo`, `release_year`, `publisher_id`, `description`, `series_id`, `series_num`) VALUES
(9789635802999, 5, 'Fourth Wing - Negyedik szárny', 2, 'https://m.media-amazon.com/images/I/81cquiyLW8L._SL1500_.jpg', 2024, 3, 'Lépj a sárkánylovasok képzésére szolgáló katonai iskola falai közé, és ismerd meg ezt az elit.', 3, 3);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb3_hungarian_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Család és szülő'),
(2, 'Életrajzok, visszaemlékezések'),
(3, 'Irodalom'),
(4, 'Képregény'),
(5, 'Lexikon, enciklopédia'),
(6, 'művészet, építészet'),
(7, 'Napjaink, bulvár, politika'),
(8, 'Nyelvkönyv, szótár, idegen nyelvű'),
(9, 'Pénz, gazdaság, üzleti élet'),
(10, 'Tudomány és természet'),
(11, 'Történelem'),
(12, 'Térkép'),
(13, 'Tankönyvek, segédkönyvek'),
(14, 'Gasztronómia'),
(15, 'Fantasy');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `publisher`
--

DROP TABLE IF EXISTS `publisher`;
CREATE TABLE IF NOT EXISTS `publisher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb3_hungarian_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `publisher`
--

INSERT INTO `publisher` (`id`, `name`) VALUES
(1, 'Európa Kiadó'),
(3, 'Rainy Days'),
(4, 'Gamma Kiadó'),
(5, 'Egymás Könyvek'),
(11, 'Móra kiadó');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `series`
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE IF NOT EXISTS `series` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb3_hungarian_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_hungarian_ci;

--
-- A tábla adatainak kiíratása `series`
--

INSERT INTO `series` (`id`, `name`) VALUES
(1, ''),
(2, 'BOYS OF TOMMEN'),
(3, 'AZ ARANYOZOTT FOGOLY'),
(4, 'EGYMÁS KÖNYVEK'),
(5, 'teszt@teszt.tesz'),
(7, 'Sorozat 1');

--
-- Megkötések a kiírt táblákhoz
--

--
-- Megkötések a táblához `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `books_ibfk_3` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `books_ibfk_4` FOREIGN KEY (`series_id`) REFERENCES `series` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
