-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 26 Kwi 2020, 17:49
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
-- Struktura tabeli dla tabeli `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `mark` varchar(128) NOT NULL,
  `model` varchar(128) NOT NULL,
  `color` varchar(6) NOT NULL,
  `engineMileage` int(11) NOT NULL,
  `imgPath` varchar(64) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `purchaseDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cost_history`
--

CREATE TABLE `cost_history` (
  `id` int(11) NOT NULL,
  `idCostType` int(11) DEFAULT NULL,
  `idCar` int(11) NOT NULL,
  `factureImagePath` varchar(64) NOT NULL,
  `amount` float NOT NULL,
  `currency` varchar(32) NOT NULL,
  `exchangeRate` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cost_types`
--

CREATE TABLE `cost_types` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cost_types`
--

INSERT INTO `cost_types` (`id`, `name`) VALUES
(1, 'Naprawy'),
(2, 'Tankowanie'),
(3, 'Czyszczenie'),
(4, 'Akcesoria'),
(5, 'Płatności'),
(6, 'Inne'),
(7, 'Kupno samochodu');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `localization_history`
--

CREATE TABLE `localization_history` (
  `id` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `startLocalizationLink` varchar(1024) NOT NULL,
  `endLocalizationLink` varchar(1024) NOT NULL,
  `startLocalizationName` varchar(64) NOT NULL,
  `endLocalizationName` varchar(64) NOT NULL,
  `distance` int(11) NOT NULL,
  `description` varchar(128) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `idNotificationType` int(11) DEFAULT NULL,
  `description` varchar(1024) NOT NULL,
  `notificationDate` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `notification_types`
--

CREATE TABLE `notification_types` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `notification_types`
--

INSERT INTO `notification_types` (`id`, `name`) VALUES
(1, 'Przeglad rejestracyjny'),
(2, 'Oplata ubezpieczenia'),
(3, 'Wymiana kol na letnie'),
(4, 'Wymiana kol na zimowe'),
(5, 'Wymiana oleju');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `petrol_types`
--

CREATE TABLE `petrol_types` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `petrol_types`
--

INSERT INTO `petrol_types` (`id`, `name`) VALUES
(1, 'LPG'),
(2, 'Pb 95'),
(3, 'Pb 98'),
(4, 'ON'),
(5, 'ON-EKO');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `repair_history`
--

CREATE TABLE `repair_history` (
  `id` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `description` int(11) NOT NULL,
  `idFacture` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tank_history`
--

CREATE TABLE `tank_history` (
  `id` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `idPetrolType` int(11) DEFAULT NULL,
  `amount` float NOT NULL,
  `idFacture` int(11) DEFAULT NULL,
  `petrolStation` varchar(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(61) NOT NULL,
  `email` varchar(64) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeksy dla tabeli `cost_history`
--
ALTER TABLE `cost_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCostType` (`idCostType`),
  ADD KEY `idCar` (`idCar`);

--
-- Indeksy dla tabeli `cost_types`
--
ALTER TABLE `cost_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `localization_history`
--
ALTER TABLE `localization_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCar` (`idCar`) USING BTREE;

--
-- Indeksy dla tabeli `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCar` (`idCar`),
  ADD KEY `idNotificationType` (`idNotificationType`),
  ADD KEY `idUser` (`idUser`);

--
-- Indeksy dla tabeli `notification_types`
--
ALTER TABLE `notification_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `petrol_types`
--
ALTER TABLE `petrol_types`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `repair_history`
--
ALTER TABLE `repair_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCar` (`idCar`),
  ADD KEY `idFacture` (`idFacture`);

--
-- Indeksy dla tabeli `tank_history`
--
ALTER TABLE `tank_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPetrolType` (`idPetrolType`) USING BTREE,
  ADD KEY `idCar` (`idCar`),
  ADD KEY `idFacture` (`idFacture`) USING BTREE;

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `cost_history`
--
ALTER TABLE `cost_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `cost_types`
--
ALTER TABLE `cost_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `localization_history`
--
ALTER TABLE `localization_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `notification_types`
--
ALTER TABLE `notification_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `petrol_types`
--
ALTER TABLE `petrol_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `repair_history`
--
ALTER TABLE `repair_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `tank_history`
--
ALTER TABLE `tank_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `car`
--
ALTER TABLE `car`
  ADD CONSTRAINT `car_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `user` (`id`);

--
-- Ograniczenia dla tabeli `cost_history`
--
ALTER TABLE `cost_history`
  ADD CONSTRAINT `cost_history_ibfk_1` FOREIGN KEY (`idCostType`) REFERENCES `cost_types` (`id`);

--
-- Ograniczenia dla tabeli `localization_history`
--
ALTER TABLE `localization_history`
  ADD CONSTRAINT `localization_history_ibfk_1` FOREIGN KEY (`idCar`) REFERENCES `car` (`id`);

--
-- Ograniczenia dla tabeli `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`idNotificationType`) REFERENCES `notification_types` (`id`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`idCar`) REFERENCES `car` (`id`);

--
-- Ograniczenia dla tabeli `repair_history`
--
ALTER TABLE `repair_history`
  ADD CONSTRAINT `repair_history_ibfk_1` FOREIGN KEY (`idCar`) REFERENCES `car` (`id`),
  ADD CONSTRAINT `repair_history_ibfk_2` FOREIGN KEY (`idFacture`) REFERENCES `cost_history` (`id`);

--
-- Ograniczenia dla tabeli `tank_history`
--
ALTER TABLE `tank_history`
  ADD CONSTRAINT `tank_history_ibfk_1` FOREIGN KEY (`idPetrolType`) REFERENCES `petrol_types` (`id`),
  ADD CONSTRAINT `tank_history_ibfk_2` FOREIGN KEY (`idCar`) REFERENCES `car` (`id`),
  ADD CONSTRAINT `tank_history_ibfk_3` FOREIGN KEY (`idFacture`) REFERENCES `cost_history` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
