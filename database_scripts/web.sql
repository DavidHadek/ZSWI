-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 02. bře 2024, 20:22
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
-- Struktura tabulky `right`
--

CREATE TABLE `right` (
  `id_right` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
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
  `deadline` datetime DEFAULT NULL,
  `evaluation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `id_right` int(11) DEFAULT NULL
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
-- Indexy pro tabulku `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `id_student_task` (`id_student_task`);

--
-- Indexy pro tabulku `right`
--
ALTER TABLE `right`
  ADD PRIMARY KEY (`id_right`);

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
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_right` (`id_right`);

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `class`
--
ALTER TABLE `class`
  ADD CONSTRAINT `class_ibfk_1` FOREIGN KEY (`id_teacher`) REFERENCES `user` (`id_user`);

--
-- Omezení pro tabulku `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`id_student_task`) REFERENCES `student_task` (`id_student_task`);

--
-- Omezení pro tabulku `student_in_class`
--
ALTER TABLE `student_in_class`
  ADD CONSTRAINT `student_in_class_ibfk_1` FOREIGN KEY (`id_student`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `student_in_class_ibfk_2` FOREIGN KEY (`id_class`) REFERENCES `class` (`id_class`);

--
-- Omezení pro tabulku `student_task`
--
ALTER TABLE `student_task`
  ADD CONSTRAINT `student_task_ibfk_1` FOREIGN KEY (`id_student_in_class`) REFERENCES `student_in_class` (`id_student_in_class`),
  ADD CONSTRAINT `student_task_ibfk_2` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_task`);

--
-- Omezení pro tabulku `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`id_class`) REFERENCES `class` (`id_class`);

--
-- Omezení pro tabulku `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`id_right`) REFERENCES `right` (`id_right`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
