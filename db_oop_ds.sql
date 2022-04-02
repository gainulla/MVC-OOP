-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 02 2022 г., 16:36
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
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `passwordResetHash` varchar(64) DEFAULT NULL,
  `passwordResetExpiresAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `passwordHash`, `passwordResetHash`, `passwordResetExpiresAt`) VALUES
(1, 'dale', 'dale@mail.io', '$2y$10$12snaaY5w/50Su1B3mDCa.C0qrkUkmoXSvW.rt3S/SU32ddolhTge', 'f04b916d5ae0fd91bd35b10df3661d60cc2702ee2871c211b8d659bbe9c0b811', '2022-04-02 14:32:23'),
(2, 'kate', 'kate@mail.io', '$2y$10$t2eixxylA1EHxusCY6QEJ.9ltb746MdL9aDVllL6B/BK3BSHF7uQG', NULL, NULL),
(3, 'jack', 'jack@mail.io', '$2y$10$aer22X1dAxPpB2Pul0V5dOcGCGPoss6R1hUq6NYCdekl37H0Jsl1G', 'e2076640a19df246cb7b421177775eb042d9acc65ed3daa347937ee548934ec1', '2022-03-25 14:54:02');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
