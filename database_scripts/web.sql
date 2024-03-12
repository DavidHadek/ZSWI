-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pon 11. bře 2024, 20:33
-- Verze serveru: 10.4.28-MariaDB
-- Verze PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `web`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `class`
--

CREATE TABLE `class` (
  `id_class` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `id_teacher` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `info`
--

CREATE TABLE `info` (
  `id_info` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `id_class` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `message`
--

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  `id_student_task` int(11) DEFAULT NULL,
  `is_student` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `student_in_class`
--

CREATE TABLE `student_in_class` (
  `id_student_in_class` int(11) NOT NULL,
  `id_class` int(11) DEFAULT NULL,
  `id_student` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `student_task`
--

CREATE TABLE `student_task` (
  `id_student_task` int(11) NOT NULL,
  `id_student_in_class` int(11) DEFAULT NULL,
  `id_task` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `task`
--

CREATE TABLE `task` (
  `id_task` int(11) NOT NULL,
  `id_class` int(11) DEFAULT NULL,
  `instructions` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `evaluation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `login` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`id_class`),
  ADD KEY `id_teacher` (`id_teacher`);

--
-- Indexy pro tabulku `info`
--
ALTER TABLE `info`
  ADD PRIMARY KEY (`id_info`),
  ADD KEY `id_class` (`id_class`);

--
-- Indexy pro tabulku `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_student_task` (`id_student_task`);

--
-- Indexy pro tabulku `student_in_class`
--
ALTER TABLE `student_in_class`
  ADD PRIMARY KEY (`id_student_in_class`),
  ADD KEY `id_student` (`id_student`),
  ADD KEY `id_class` (`id_class`);

--
-- Indexy pro tabulku `student_task`
--
ALTER TABLE `student_task`
  ADD PRIMARY KEY (`id_student_task`),
  ADD KEY `id_student_in_class` (`id_student_in_class`),
  ADD KEY `id_task` (`id_task`);

--
-- Indexy pro tabulku `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `id_class` (`id_class`);

--
-- Indexy pro tabulku `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `class`
--
ALTER TABLE `class`
  MODIFY `id_class` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `info`
--
ALTER TABLE `info`
  MODIFY `id_info` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `student_in_class`
--
ALTER TABLE `student_in_class`
  MODIFY `id_student_in_class` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `student_task`
--
ALTER TABLE `student_task`
  MODIFY `id_student_task` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `task`
--
ALTER TABLE `task`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
