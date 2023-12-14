-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Czas generowania: 22 Maj 2023, 14:10
-- Wersja serwera: 10.5.19-MariaDB-10+deb11u2
-- Wersja PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `kamilek777`
--
CREATE DATABASE IF NOT EXISTS `kamilek777` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `kamilek777`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kamilharmonogram`
--

CREATE TABLE `kamilharmonogram` (
  `ID` int(11) NOT NULL,
  `aktywnosc` text NOT NULL,
  `waga` int(11) NOT NULL,
  `jakiedni` text NOT NULL,
  `godziny` text NOT NULL,
  `typ` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `kamilharmonogram`
--

INSERT INTO `kamilharmonogram` (`ID`, `aktywnosc`, `waga`, `jakiedni`, `godziny`, `typ`) VALUES
(1, 'Pianińsko', 2, '1234567', 'm, m, m, m, m, i, i, ', 'piano'),
(2, 'Programowanie0-0CSS', 2, '', '', 'css'),
(3, 'Programowanie0-0JS', 3, '5', 'h, ', 'js'),
(4, 'Programowanie0-0HTML', 2, '5', 'e, ', 'html'),
(5, 'Programowanie0SQL', 2, '', '', 'sql'),
(6, 'Programowanie0-0PHP', 3, '5', 'g, ', 'php'),
(7, 'Ucz0się0Analizy', 2, '12345', 'l, l, l, l, l, ', 'matma'),
(8, 'Ucz0się0Algebry', 2, '12345', 'j, j, k, j, k, ', 'matma'),
(9, 'Ucz0się0chemii', 2, '', '', 'chemia'),
(10, 'Workout0yy', 2, '13467', 'i, i, i, g, g, ', 'siua'),
(11, 'Sprzatnij0dom0idk', 2, '1234567', 'n, n, n, n, n, n, n, ', 'zycie'),
(12, 'Historia', 2, '', '', 'historia'),
(13, 'Programowanie0-0CPP', 2, '5', 'f, ', 'cpp'),
(14, 'Programowanie0-0Python', 2, '5', 'i, ', 'python');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kamilpoziomy`
--

CREATE TABLE `kamilpoziomy` (
  `ID` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `typ` text NOT NULL,
  `exp` int(11) NOT NULL,
  `poziom` int(11) NOT NULL,
  `do_nastepnego` int(11) NOT NULL,
  `poczatek` date NOT NULL,
  `klasa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kamilpoziomy`
--

INSERT INTO `kamilpoziomy` (`ID`, `nazwa`, `typ`, `exp`, `poziom`, `do_nastepnego`, `poczatek`, `klasa`) VALUES
(1, 'Programowanie w CSS', 'css', 730, 2, 900, '2023-03-26', 'scisle'),
(2, 'Programowanie w JavaScript', 'js', 610, 4, 1500, '2023-03-26', 'scisle'),
(3, 'Programowanie w HTML', 'html', 840, 3, 1200, '2023-03-26', 'scisle'),
(4, 'Programowanie w SQL', 'sql', 90, 2, 900, '2023-03-26', 'scisle'),
(5, 'Programowanie w PHP', 'php', 1070, 5, 1800, '2023-03-26', 'scisle'),
(6, 'Pianińsko', 'piano', 1080, 5, 1800, '2023-03-26', 'sztuka'),
(7, 'Matma (Algebra + Analiza)', 'matma', 1190, 7, 2400, '2023-03-26', 'scisle'),
(8, 'Chemia', 'chemia', 200, 3, 1200, '2023-03-26', 'scisle'),
(9, 'Skille w życiu', 'zycie', 520, 4, 1500, '2023-03-26', 'zar'),
(10, 'Workout', 'siua', 520, 3, 1200, '2023-04-12', 'zdrowie'),
(11, 'Historia', 'historia', 800, 2, 900, '2023-04-21', 'human'),
(12, 'Umiejętności społeczne', 'spoleczne', 50, 3, 1200, '2023-05-18', 'spol'),
(13, 'Gotowanie', 'gotowansko', 50, 4, 1500, '2023-05-18', 'zar'),
(14, 'Programowanie w CPP', 'cpp', 0, 2, 900, '2023-05-19', 'scisle'),
(15, 'Programowanie w Python', 'python', 0, 2, 900, '2023-05-19', 'scisle'),
(16, 'Książki', 'ksiazki', 100, 5, 1800, '2023-05-19', 'human'),
(17, 'Emocje czy cos', 'emotion', 0, 4, 1500, '2023-05-20', 'zdrowie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kamiltaski`
--

CREATE TABLE `kamiltaski` (
  `ID` int(11) NOT NULL,
  `dynID` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `status` text NOT NULL,
  `waga` int(11) NOT NULL,
  `data` date NOT NULL,
  `typ` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `kamiltaski`
--

INSERT INTO `kamiltaski` (`ID`, `dynID`, `nazwa`, `status`, `waga`, `data`, `typ`) VALUES
(180, 0, 'Moonlight Sonata', 'dokonane', 8, '2023-05-20', 'piano'),
(211, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-05', 'zycie'),
(215, 0, 'Harmonogram + Historia CSS', 'niedokonane', 10, '2023-05-26', 'css'),
(216, 0, 'Naucz się canvas', 'dokonane', 9, '2023-06-02', 'js'),
(217, 0, 'wykonywanie funkcji przy odświeżaniu ', 'dokonane', 5, '2023-05-27', 'php'),
(218, 0, 'Pianińsko 15:00', 'dokonane', 2, '2023-05-06', 'piano'),
(220, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-06', 'zycie'),
(221, 0, 'Historia 19:00', 'dokonane', 2, '2023-05-06', 'historia'),
(222, 0, 'Ogarnij wszystkie wyklady z analizy', 'dokonane', 6, '2023-05-20', 'matma'),
(223, 0, 'Pianińsko 15:00', 'dokonane', 2, '2023-05-07', 'piano'),
(225, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-07', 'zycie'),
(226, 0, 'Historia 19:00', 'dokonane', 2, '2023-05-07', 'historia'),
(227, 0, 'Dodaj uposledzone staty', 'dokonane', 10, '2023-05-28', 'js'),
(228, 0, 'Dobieranie statów do kategorii', 'dokonane', 10, '2023-05-28', 'js'),
(230, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-08', 'matma'),
(231, 0, 'Ucz się Algebry 16:00', 'dokonane', 2, '2023-05-08', 'matma'),
(232, 0, 'Workout yy 15:00', 'dokonane', 2, '2023-05-08', 'siua'),
(233, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-08', 'zycie'),
(236, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-09', 'matma'),
(237, 0, 'Ucz się Algebry 16:00', 'dokonane', 2, '2023-05-09', 'matma'),
(238, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-09', 'zycie'),
(240, 0, 'Pianińsko 19:00', 'dokonane', 2, '2023-05-10', 'piano'),
(241, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-10', 'matma'),
(242, 0, 'Ucz się Algebry 17:00', 'dokonane', 2, '2023-05-10', 'matma'),
(244, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-10', 'zycie'),
(246, 0, 'Pianińsko 19:00', 'dokonane', 2, '2023-05-11', 'piano'),
(247, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-11', 'matma'),
(248, 0, 'Ucz się Algebry 16:00', 'dokonane', 2, '2023-05-11', 'matma'),
(249, 0, 'Workout yy 15:00', 'dokonane', 2, '2023-05-11', 'siua'),
(250, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-11', 'zycie'),
(251, 0, 'Historia 17:00', 'dokonane', 2, '2023-05-11', 'historia'),
(253, 0, 'Programowanie - CSS 10:00', 'dokonane', 2, '2023-05-12', 'css'),
(254, 0, 'Programowanie - JS 14:00', 'dokonane', 3, '2023-05-12', 'js'),
(255, 0, 'Programowanie - HTML 11:00', 'dokonane', 2, '2023-05-12', 'html'),
(256, 0, 'Programowanie SQL 12:00', 'dokonane', 2, '2023-05-12', 'sql'),
(257, 0, 'Programowanie - PHP 13:00', 'dokonane', 3, '2023-05-12', 'php'),
(258, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-12', 'matma'),
(259, 0, 'Ucz się Algebry 17:00', 'dokonane', 2, '2023-05-12', 'matma'),
(260, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-12', 'zycie'),
(261, 0, 'Historia 16:00', 'dokonane', 2, '2023-05-12', 'historia'),
(263, 0, 'Workout yy 13:00', 'dokonane', 2, '2023-05-13', 'siua'),
(264, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-13', 'zycie'),
(265, 0, 'Historia 19:00', 'dokonane', 2, '2023-05-13', 'historia'),
(266, 0, 'Pianińsko 15:00', 'dokonane', 2, '2023-05-14', 'piano'),
(268, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-14', 'zycie'),
(270, 0, 'Pianińsko 19:00', 'dokonane', 2, '2023-05-15', 'piano'),
(271, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-15', 'matma'),
(272, 0, 'Ucz się Algebry 16:00', 'dokonane', 2, '2023-05-15', 'matma'),
(273, 0, 'Workout yy 15:00', 'dokonane', 2, '2023-05-15', 'siua'),
(274, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-15', 'zycie'),
(276, 0, 'Pianińsko 19:00', 'dokonane', 2, '2023-05-16', 'piano'),
(277, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-16', 'matma'),
(278, 0, 'Ucz się Algebry 16:00', 'dokonane', 2, '2023-05-16', 'matma'),
(279, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-16', 'zycie'),
(281, 0, 'Pianińsko 19:00', 'dokonane', 2, '2023-05-17', 'piano'),
(282, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-17', 'matma'),
(283, 0, 'Ucz się Algebry 17:00', 'dokonane', 2, '2023-05-17', 'matma'),
(284, 0, 'Workout yy 15:00', 'dokonane', 2, '2023-05-17', 'siua'),
(285, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-17', 'zycie'),
(287, 0, 'Pianińsko 19:00', 'dokonane', 2, '2023-05-18', 'piano'),
(288, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-18', 'matma'),
(289, 0, 'Ucz się Algebry 16:00', 'dokonane', 2, '2023-05-18', 'matma'),
(290, 0, 'Workout yy 15:00', 'dokonane', 2, '2023-05-18', 'siua'),
(291, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-18', 'zycie'),
(293, 0, 'Pianińsko 19:00', 'niedokonane', 2, '2023-05-19', 'piano'),
(295, 0, 'Programowanie - JS 14:00', 'dokonane', 3, '2023-05-19', 'js'),
(296, 0, 'Programowanie - HTML 11:00', 'dokonane', 2, '2023-05-19', 'html'),
(298, 0, 'Programowanie - PHP 13:00', 'dokonane', 3, '2023-05-19', 'php'),
(299, 0, 'Ucz się Analizy 18:00', 'dokonane', 2, '2023-05-19', 'matma'),
(300, 0, 'Ucz się Algebry 17:00', 'dokonane', 2, '2023-05-19', 'matma'),
(301, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-19', 'zycie'),
(303, 0, 'Pianińsko 15:00', 'dokonane', 2, '2023-05-20', 'piano'),
(304, 0, 'Workout yy 13:00', 'dokonane', 2, '2023-05-20', 'siua'),
(305, 0, 'Sprzatnij dom idk 20:00', 'dokonane', 2, '2023-05-20', 'zycie'),
(306, 0, 'Pianińsko 15:00', 'niedokonane', 2, '2023-05-21', 'piano'),
(307, 0, 'Workout yy 13:00', 'niedokonane', 2, '2023-05-21', 'siua'),
(308, 0, 'Sprzatnij dom idk 20:00', 'niedokonane', 2, '2023-05-21', 'zycie'),
(309, 0, 'Pianińsko 19:00', 'niedokonane', 2, '2023-05-22', 'piano'),
(310, 0, 'Ucz się Analizy 18:00', 'niedokonane', 2, '2023-05-22', 'matma'),
(311, 0, 'Ucz się Algebry 16:00', 'niedokonane', 2, '2023-05-22', 'matma'),
(312, 0, 'Workout yy 15:00', 'niedokonane', 2, '2023-05-22', 'siua'),
(313, 0, 'Sprzatnij dom idk 20:00', 'niedokonane', 2, '2023-05-22', 'zycie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `publicharmonogram`
--

CREATE TABLE `publicharmonogram` (
  `ID` int(11) NOT NULL,
  `aktywnosc` text NOT NULL,
  `waga` int(11) NOT NULL,
  `jakiedni` text NOT NULL,
  `godziny` text NOT NULL,
  `typ` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `publicharmonogram`
--

INSERT INTO `publicharmonogram` (`ID`, `aktywnosc`, `waga`, `jakiedni`, `godziny`, `typ`) VALUES
(1, 'sranie', 7, '1234567', 'f, bf, cdefghij, f, f, f, df, ', 'sranie'),
(2, 'robienie0louda', 6, '1234567', 'f, f, f, f, f, f, f, ', 'sus'),
(3, 'lizanie0czola', 9, '123456', 'e, ej, eijk, ej, e, efgh, ', 'idk'),
(4, '', 6, '', '', 'brak');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `publicpoziomy`
--

CREATE TABLE `publicpoziomy` (
  `ID` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `typ` text NOT NULL,
  `exp` int(11) NOT NULL,
  `poziom` int(11) NOT NULL,
  `do_nastepnego` int(11) NOT NULL,
  `poczatek` date NOT NULL,
  `klasa` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `publicpoziomy`
--

INSERT INTO `publicpoziomy` (`ID`, `nazwa`, `typ`, `exp`, `poziom`, `do_nastepnego`, `poczatek`, `klasa`) VALUES
(1, 'Kamil śmierdzi ', 'idk', 1140, 5, 1800, '2023-03-26', ''),
(2, 'sranie w banie', 'sranie', 2550, 8, 2700, '2023-04-02', ''),
(3, 'amogus amogus', 'sus', 240, 2, 900, '2023-04-02', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `publictaski`
--

CREATE TABLE `publictaski` (
  `ID` int(11) NOT NULL,
  `dynID` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `status` text NOT NULL,
  `waga` int(11) NOT NULL,
  `data` date NOT NULL,
  `typ` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `publictaski`
--

INSERT INTO `publictaski` (`ID`, `dynID`, `nazwa`, `status`, `waga`, `data`, `typ`) VALUES
(119, 0, 'robienie louda 12:00', 'niedokonane', 6, '2023-04-28', 'sus'),
(122, 0, 'robienie louda 12:00', 'dokonane', 6, '2023-04-29', 'sus'),
(123, 0, 'lizanie czola 11:00 - 14:00', 'dokonane', 9, '2023-04-29', 'idk'),
(124, 0, 'fdsfdfs', 'dokonane', 6, '2023-05-03', 'idk');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `strony`
--

CREATE TABLE `strony` (
  `id` int(11) NOT NULL,
  `tekst` text NOT NULL,
  `obraz` text NOT NULL,
  `funkcja` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `strony`
--

INSERT INTO `strony` (`id`, `tekst`, `obraz`, `funkcja`) VALUES
(1, 'Strona główna. <br> Wybierz którąkolwiek z zakładek, aby rozpocząć.', 'img/rogal.png', '0'),
(2, 'Dodawaj i wykonuj przydzielane przez siebie zadania.', '', '2'),
(3, 'Edytuj rozkład godzinowy i dzienny różnych aktywności, aby mogły zostawać dodawane związane z nimi zadania i (opcjonalnie) dostawać o nich powiadomienia.', '', '5'),
(4, 'Modyfikuj i obserwuj swój postęp w określonych dziedzinach.', '', '1'),
(5, 'Przeglądaj całą historie swoich dodawanych i wykonywanych zadań.', '', '4'),
(6, 'Podaj wszystkie dane powiązane z nowym zadaniem.', 'img/amogusdance.gif', '3'),
(7, 'Podaj wszystkie dane powiązane z nową dziedziną zadań.', 'img/amogusdance.gif', '6'),
(8, 'Strona logowania. <br> Wpisz swoje hasło, zarejestruj się albo skorzystaj z publicznego konta.', 'img/rogal.png', '7'),
(9, 'Podaj wszystkie dane powiązane z nowym typem aktywności do harmonogramu.', 'img/amogusdance.gif', '8'),
(10, 'Ustawienia', '', '9'),
(11, 'Autystyczne staty', '', '10');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `ID` int(11) NOT NULL,
  `login` text NOT NULL,
  `haslo` text NOT NULL,
  `discord` text NOT NULL,
  `dni_wolne` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`ID`, `login`, `haslo`, `discord`, `dni_wolne`) VALUES
(1, 'kamil', 'kaczkasraczka', '1092760909337862144', 'X'),
(3, 'public', 'twojastarazapierdalanarowerzepoparterze', '', '');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kamilharmonogram`
--
ALTER TABLE `kamilharmonogram`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `kamilpoziomy`
--
ALTER TABLE `kamilpoziomy`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `kamiltaski`
--
ALTER TABLE `kamiltaski`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `publicharmonogram`
--
ALTER TABLE `publicharmonogram`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `publicpoziomy`
--
ALTER TABLE `publicpoziomy`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `publictaski`
--
ALTER TABLE `publictaski`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `strony`
--
ALTER TABLE `strony`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `kamilharmonogram`
--
ALTER TABLE `kamilharmonogram`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT dla tabeli `kamilpoziomy`
--
ALTER TABLE `kamilpoziomy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `kamiltaski`
--
ALTER TABLE `kamiltaski`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=314;

--
-- AUTO_INCREMENT dla tabeli `publicharmonogram`
--
ALTER TABLE `publicharmonogram`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `publicpoziomy`
--
ALTER TABLE `publicpoziomy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `publictaski`
--
ALTER TABLE `publictaski`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT dla tabeli `strony`
--
ALTER TABLE `strony`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
