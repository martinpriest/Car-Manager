--
-- Zrzut danych tabeli `notification_types`
--

INSERT INTO `notification_types` (`id`, `name`) VALUES
(1, 'Przeglad rejestracyjny'),
(2, 'Oplata ubezpieczenia'),
(3, 'Wymiana kol na letnie'),
(4, 'Wymiana kol na zimowe'),
(5, 'Wymiana oleju');

--
-- Zrzut danych tabeli `petrol_types`
--

INSERT INTO `petrol_types` (`id`, `name`) VALUES
(1, 'LPG'),
(2, 'Pb 95'),
(3, 'Pb 98'),
(4, 'ON'),
(5, 'ON-EKO');

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

--
-- Dane do tabeli `file`
--
INSERT INTO `file` (`name`, `extension`, `filepath`, `mimetype`) VALUES
('default-user-avatar.jpeg', 'jpeg', 'default-images', 'image/jpeg'),
('default-car-avatar.jpeg', 'jpeg', 'default-images', 'image/jpeg');