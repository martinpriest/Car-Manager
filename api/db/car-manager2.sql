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
-- Struktura tabeli dla tabeli `car`
--

CREATE TABLE `car` (
  `id` int(11) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `mark` varchar(128) NOT NULL,
  `model` varchar(128) NOT NULL,
  `color` varchar(6) NOT NULL,
  `engineMileage` int(11) NOT NULL,
  `imgPath` varchar(64) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `purchaseDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `car`
--

INSERT INTO `car` (`id`, `idUser`, `name`, `mark`, `model`, `color`, `engineMileage`, `imgPath`, `creationDate`, `purchaseDate`) VALUES
(2, 1, '', 'FOrd', 'Fiesta', 'dedede', 100000, 'ededed', '2020-04-26 06:45:14', '0000-00-00'),
(4, 2, '', 'Seat', 'Ibiza', 'dedede', 123423, 'img/car/car-default.png', '2020-04-26 10:51:44', NULL),
(5, 2, '', 'Seat', 'Ibiza', 'dedede', 123423, 'img/car/car-default.png', '2020-04-26 10:52:22', NULL),
(6, 2, '', 'Seat', 'Ibiza', 'dedede', 123423, 'img/car/car-default.png', '2020-04-26 10:52:32', NULL),
(7, 2, '', 'Seat', 'Ibiza', 'dedede', 123423, 'img/car/car-default.png', '2020-04-26 10:53:06', NULL),
(8, 2, '', 'Seat', 'Ibiza', 'dedede', 123423, 'img/car/car-default.png', '2020-04-26 11:10:52', NULL),
(9, 7, 'Auto1', 'Seat', 'Cordoba', 'aaaaaa', 51200, 'img/car/car-default.png', '2020-04-28 16:27:23', NULL),
(10, 7, 'Kangur', 'Renault', 'Kangoo', 'aaaaaa', 83000, 'img/car/car-default.png', '2020-04-28 16:28:02', NULL),
(11, 7, 'Prywatne', 'Porsche', 'CaymanS', 'aaaaaa', 25000, 'img/car/car-default.png', '2020-04-28 16:29:09', NULL),
(12, 7, 'Sej', 'Fiat', 'Seicento', 'aaaaaa', 150000, 'img/car/car-default.png', '2020-04-28 16:30:17', NULL),
(13, 7, 'Pracownicze', 'Renault', 'Laguna', 'aaaaaa', 125000, 'img/car/car-default.png', '2020-04-28 16:44:19', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cost_history`
--

CREATE TABLE `cost_history` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCostType` int(11) DEFAULT NULL,
  `idCar` int(11) NOT NULL,
  `factureImagePath` varchar(64) NOT NULL,
  `amount` float NOT NULL,
  `currency` varchar(32) NOT NULL,
  `exchangeRate` float NOT NULL,
  `description` varchar(512) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `cost_history`
--

INSERT INTO `cost_history` (`id`, `idUser`, `idCostType`, `idCar`, `factureImagePath`, `amount`, `currency`, `exchangeRate`, `description`, `date`) VALUES
(1, 0, 1, 4, 'path/to/img', 10, 'ZL', 1, '', '0000-00-00 00:00:00'),
(2, 0, 1, 5, 'path/to/img', 10, 'ZL', 1, '', '0000-00-00 00:00:00'),
(3, 0, 1, 2, 'path/to/img', 10, 'ZL', 1, '', '0000-00-00 00:00:00'),
(4, 7, 4, 11, 'img/default.jpg', 13, 'PLN', 1, '', '2020-01-04 23:00:00'),
(5, 7, 4, 11, 'img/default.jpg', 13, 'PLN', 1, '', '2020-01-04 23:00:00'),
(6, 7, 4, 11, 'img/default.jpg', 13, 'PLN', 1, '', '2020-01-04 23:00:00'),
(7, 7, 4, 11, 'img/default.jpg', 13, 'PLN', 1, 'Choinka zapachowa', '2020-01-04 23:00:00'),
(8, 7, 1, 10, 'img/default.jpg', 160, 'PLN', 1, 'Wymiana prawego nadkola', '2020-01-02 23:00:00'),
(9, 7, 1, 10, 'img/default.jpg', 1160, 'PLN', 1, 'Wymiana Sprzegla', '2020-01-02 23:00:00'),
(10, 7, 1, 10, 'img/default.jpg', 160, 'PLN', 1, 'Wymiana prawego nadkola', '2020-01-02 23:00:00'),
(11, 7, 2, 10, 'img/default-facture.jpg', 80, 'PLN', 1, 'Tankowanie szybko', '2020-10-19 22:00:00'),
(12, 7, 2, 10, 'img/default-facture.jpg', 80, 'PLN', 1, 'Tankowanie szybko', '2020-10-19 22:00:00'),
(13, 7, 2, 11, 'img/default-facture.jpg', 80, 'PLN', 1, 'Tankowanie szybko', '2020-10-19 22:00:00'),
(14, 7, 2, 11, 'img/default-facture.jpg', 80, 'PLN', 1, 'Tankowanie szybko', '2020-10-19 22:00:00'),
(15, 7, 2, 10, 'img/default-facture.jpg', 80, 'PLN', 1, 'Tankowanie szybko', '2020-10-19 22:00:00'),
(16, 7, 2, 10, 'img/default-facture.jpg', 80, 'PLN', 1, 'Tankowanie szybko', '2020-10-19 22:00:00'),
(17, 7, 2, 10, 'img/default-facture.jpg', 80, 'PLN', 1, 'Tankowanie szybko', '2020-10-19 22:00:00');

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
  `idUser` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `startLocalizationLink` varchar(1024) NOT NULL,
  `endLocalizationLink` varchar(1024) NOT NULL,
  `startLocalizationName` varchar(64) NOT NULL,
  `endLocalizationName` varchar(64) NOT NULL,
  `distance` int(11) NOT NULL,
  `description` varchar(128) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `localization_history`
--

INSERT INTO `localization_history` (`id`, `idUser`, `idCar`, `startLocalizationLink`, `endLocalizationLink`, `startLocalizationName`, `endLocalizationName`, `distance`, `description`, `date`) VALUES
(1, 7, 10, 'google maps 1', 'google maps 1', 'Kraków', 'Wrocław', 170, 'podroz sluzbowa do Kowalskiego', '2020-04-20'),
(2, 7, 10, 'google maps 1', 'google maps 1', 'Wroclaw', 'Krakow', 180, 'powrot z podrozy sluznbowej', '2020-04-20');

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

--
-- Zrzut danych tabeli `notification`
--

INSERT INTO `notification` (`id`, `idUser`, `idCar`, `idNotificationType`, `description`, `notificationDate`, `status`) VALUES
(2, 2, 4, 1, 'dupa', '2020-04-20', 1),
(3, 2, 4, 1, 'dupa', '2020-04-20', 1),
(4, 7, 10, 3, 'Wazne', '2020-06-01', 1),
(5, 7, 10, 1, 'Zrobic przeglad u Zenka :)', '2020-06-01', 1);

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
  `idUser` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `description` varchar(512) NOT NULL,
  `idFacture` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `repair_history`
--

INSERT INTO `repair_history` (`id`, `idUser`, `idCar`, `description`, `idFacture`, `date`) VALUES
(1, 7, 10, 'Wymiana prawego nadkola', 8, '2020-01-02 23:00:00'),
(2, 7, 10, 'Wymiana Sprzegla', 9, '2020-01-02 23:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tank_history`
--

CREATE TABLE `tank_history` (
  `id` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `idCar` int(11) DEFAULT NULL,
  `idPetrolType` int(11) DEFAULT NULL,
  `amount` float NOT NULL,
  `idFacture` int(11) DEFAULT NULL,
  `petrolStation` varchar(64) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `tank_history`
--

INSERT INTO `tank_history` (`id`, `idUser`, `idCar`, `idPetrolType`, `amount`, `idFacture`, `petrolStation`, `date`) VALUES
(1, 7, 10, 2, 20, 11, 'Orlen', '2020-10-19 22:00:00'),
(2, 7, 10, 2, 20, 12, 'Orlen', '2020-10-19 22:00:00'),
(3, 7, 11, 2, 20, 13, 'Orlen', '2020-10-19 22:00:00'),
(4, 7, 11, 2, 20, 14, 'Orlen', '2020-10-19 22:00:00'),
(5, 7, 10, 2, 20, 15, 'Circle K', '2020-10-19 22:00:00'),
(6, 7, 10, 2, 20, 16, 'Petrol', '2020-10-19 22:00:00'),
(7, 7, 10, 2, 20, 17, 'Orlen', '2020-10-19 22:00:00');

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
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `email`, `creationDate`) VALUES
(1, 'jkis', '$2y$10$u9GSR9lygaEaz4dIy0C0Pum4jmOnPGbp3exQRB.QTUG.huSKbMgbK', 'deded', '2020-04-26 07:04:37'),
(2, 'kolouiya', 'aaaaa', 'mailik', '2020-04-26 07:04:37'),
(4, 'jkis4', '$2y$10$ZRUAoyVOAwS/h5.la8v/7.cKNMapezDaCJ.OoruC4OObatCLHZahC', 'efefwf', '2020-04-26 09:29:24'),
(5, 'login', '$2y$10$8C/tVTqeWJFUnB9M43wJB.imvo1Yniq.31CWHwb4K9UX8HlU/UKQ2', 'jkis', '2020-04-26 09:55:32'),
(6, 'jkis2', '$2y$10$qsPsTIuXuuWMUCAflPS.9eTIWXUzBLLgZL8ItPNoo4FYByIE2tQ8m', 'efdefwf', '2020-04-26 10:00:04'),
(7, 'user1', '$2y$10$yGh486RicefIfPqgO4PAEeUmvvIivX4zpoj5iShMo5is0tX8FCWya', 'user1@mail.pl', '2020-04-28 14:26:14'),
(8, 'user2', '$2y$10$EJx7cXXejir07nlzXUhxBOJJt/36VCw7ApuPpCh/H7gYYZJeYDLcW', 'user2@mail.pl', '2020-04-28 14:26:44');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `cost_history`
--
ALTER TABLE `cost_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `cost_types`
--
ALTER TABLE `cost_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `localization_history`
--
ALTER TABLE `localization_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `tank_history`
--
ALTER TABLE `tank_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
