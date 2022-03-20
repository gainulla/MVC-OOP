-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 20 2022 г., 13:44
-- Версия сервера: 10.4.18-MariaDB
-- Версия PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db_oop_ds`
--

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwordHash`) VALUES
(1, 'dale', 'dale@mail.io', '$2y$10$ttHg6eFDOD6up5aP/ERXmeF4LkSJjZhoWrn9tP2T97QgxagEEQBFS'),
(2, 'kate', 'kate@mail.io', '$2y$10$7HwCvZcnOSPynfStuaLU8uqBDwxjQoyOsWWTFZCrTUejeWSom0Vr6'),
(3, 'nick', 'nick@mail.io', '$2y$10$Wz5mwNcH68AoqgZ0iNcmS.EoIacblND9X/BMhwnEecPOwzNrcA/OC'),
(4, 'jane', 'jane@mail.io', '$2y$10$VBvnwT2gHbdwudziCYELwuKEs1CWm/t6oxT76VvvH.V0ZIl.48jzK'),
(7, 'anna', 'anna@mail.io', '$2y$10$HudiQRmzgufCl3BM.IiWEeiEu7dVKNsR2a5wr1DZ2nQOr/MjpLe3W'),
(8, 'gram', 'gram@mail.io', '$2y$10$.WCjW/ImYYSrrb0Zh.VgE.pu1VRNFS/sNDVdcelFg71uj7t4cV0ti'),
(9, 'lora', 'lora@mail.io', '$2y$10$HpKJMb6XVWXPeTyK/5CilO5LWQv2lB31hU8ujs3vp9ypPwlEm0U3a');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
