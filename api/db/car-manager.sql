-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 29 Kwi 2020, 22:20
-- Wersja serwera: 10.1.38-MariaDB
-- Wersja PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `car-manager`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `file`
--

CREATE TABLE `file` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(128) NOT NULL,
  `extension` varchar(8) NOT NULL,
  `filePath` varchar(128) NOT NULL,
  `mimetype` varchar(128) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `idAvatarFile` int(11) DEFAULT 2,
  `login` varchar(32) NOT NULL,
  `password` varchar(61) NOT NULL,
  `email` varchar(64) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`idAvatarFile`) REFERENCES `file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `car_group`
--

CREATE TABLE `car_group` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `name` varchar(32) NOT NULL DEFAULT "Default car group",
  `menuPosition` int(11) NOT NULL DEFAULT 1,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`idUser`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `car`
--

CREATE TABLE `car` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `idCarGroup` int(11) NOT NULL,
  `idAvatarFile` int(11) DEFAULT 1,
  `isPublic` boolean DEFAULT 0,
  `name` varchar(64) NOT NULL,
  `mark` varchar(128) NOT NULL,
  `model` varchar(128) NOT NULL,
  `year` smallint(6) NOT NULL DEFAULT 2020,
  `hexColor` varchar(6) NOT NULL,
  `engineMileage` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `purchaseDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
  FOREIGN KEY (`idCarGroup`) REFERENCES `car_group` (`id`),
  FOREIGN KEY (`idAvatarFile`) REFERENCES `file` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cost_types`
--

CREATE TABLE `cost_types` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
--
-- Struktura tabeli dla tabeli `cost_history`
--

CREATE TABLE `cost_history` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCostType` int(11) DEFAULT NULL,
  `idCar` int(11) NOT NULL,
  `factureImagePath` varchar(64) NOT NULL,
  `amount` float NOT NULL,
  `currency` varchar(32) NOT NULL,
  `exchangeRate` float NOT NULL,
  `description` varchar(512) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`idUser`) REFERENCES `user` (`id`),
  FOREIGN KEY (`idCostType`) REFERENCES `cost_types` (`id`),
  FOREIGN KEY (`idCar`) REFERENCES `car` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;




-- --------------------------------------------------------
CREATE TABLE `address` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `lat` float NOT NULL,
  `lng` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


--
-- Struktura tabeli dla tabeli `localization_history`
--

CREATE TABLE `localization_history` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `idStartAddress` int(11) NOT NULL,
  `idEndAddress` int(11) NOT NULL,
  `distance` int(11) NOT NULL,
  `description` varchar(128) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`idUser`) REFERENCES user(`id`),
  FOREIGN KEY(`idCar`) REFERENCES car(`id`),
  FOREIGN KEY(`idStartAddress`) REFERENCES `address` (`id`),
  FOREIGN KEY(`idEndAddress`) REFERENCES `address` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notification_types`
--

CREATE TABLE `notification_types` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
--
-- Struktura tabeli dla tabeli `notification`
--

CREATE TABLE `notification` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `idNotificationType` int(11) DEFAULT NULL,
  `description` varchar(1024) NOT NULL,
  `notificationDate` date NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`idUser`) REFERENCES user(`id`),
  FOREIGN KEY(`idCar`) REFERENCES car(`id`),
  FOREIGN KEY(`idNotificationType`) REFERENCES notification_types(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `petrol_types`
--

CREATE TABLE `petrol_types` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `repair_history`
--

CREATE TABLE `repair_history` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `description` varchar(512) NOT NULL,
  `idFacture` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`idUser`) REFERENCES user(`id`),
  FOREIGN KEY(`idCar`) REFERENCES car(`id`),
  FOREIGN KEY(`idFacture`) REFERENCES cost_history(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tank_history`
--

CREATE TABLE `tank_history` (
  `id` int(11) AUTO_INCREMENT NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `idPetrolType` int(11) DEFAULT NULL,
  `amount` float NOT NULL,
  `idFacture` int(11) DEFAULT NULL,
  `petrolStation` varchar(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY(`idUser`) REFERENCES user(`id`),
  FOREIGN KEY(`idCar`) REFERENCES car(`id`),
  FOREIGN KEY(`idFacture`) REFERENCES cost_history(`id`),
  FOREIGN KEY(`idPetrolType`) REFERENCES petrol_types(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
