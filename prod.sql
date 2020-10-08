-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 03 2020 г., 01:00
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `prod`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `value`) VALUES
(1, 'Женщины', 'female'),
(2, 'Мужчины', 'male'),
(3, 'Дети', 'children'),
(4, 'Аксессуары', 'access');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `title`, `description`) VALUES
(1, 'Администратор', 'Администратор может заходить в административный интерфейс, видеть список заказов и управлять товарами'),
(2, 'Оператор', 'Оператор может заходить в административный интерфейс и видеть список заказов');

-- --------------------------------------------------------

--
-- Структура таблицы `groups_users`
--

CREATE TABLE `groups_users` (
  `users_id` int NOT NULL,
  `groups_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Дамп данных таблицы `groups_users`
--

INSERT INTO `groups_users` (`users_id`, `groups_id`) VALUES
(1, 1),
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `products_id` int NOT NULL,
  `cost` int NOT NULL,
  `surname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `thirdName` varchar(50) DEFAULT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `delivery` tinyint(1) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `street` varchar(50) DEFAULT NULL,
  `home` varchar(50) DEFAULT NULL,
  `aprt` varchar(50) DEFAULT NULL,
  `pay` varchar(50) NOT NULL,
  `comment` text,
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `products_id`, `cost`, `surname`, `name`, `thirdName`, `phone`, `email`, `delivery`, `city`, `street`, `home`, `aprt`, `pay`, `comment`, `status`) VALUES
(22, 18, 120000, 'Чемакин', 'Андрей', 'Андреевич', '444333222', '111@111', 0, '', '', '', '', 'cash', 'Далеко-далеко за словесными горами, в стране гласных и согласных живут рыбные тексты. Запятых своего океана назад всемогущая! Коварных предупреждал наш пояс запятых несколько? Путь языкового живет по всей, рот предупреждал эта свое маленький.', 1),
(23, 14, 2000, 'Антонова', 'Ольга ', 'Петровна', '777666', '666@4444', 1, 'Архангельск', 'Тимме', '1', '2', 'cash', 'Далеко-далеко за словесными горами, в стране гласных и согласных живут рыбные тексты. Запятых своего океана назад всемогущая! Коварных предупреждал наш пояс запятых несколько? Путь языкового живет по всей, рот предупреждал эта свое маленький.', 0),
(24, 4, 1580, 'Форсова', 'Галина', '', '111222', 'asa@mail', 1, 'Мурманск', 'Арктическая', '45', '3', 'card', 'Далеко-далеко за словесными горами, в стране гласных и согласных живут рыбные тексты. Запятых своего океана назад всемогущая! Коварных предупреждал наш пояс запятых несколько? Путь языкового живет по всей, рот предупреждал эта свое маленький.', 1),
(25, 2, 2999, 'Мамонтова', 'Ангелина', '', '565', '2111@kkjds', 0, '', '', '', '', 'card', '', 0),
(26, 12, 1279, 'Максимов', 'Петр', 'Анатольевич', '344343', 'max@max', 1, 'Архангельск', 'Тимме', '2', '5', 'card', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `price` int NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `img` varchar(255) NOT NULL,
  `novelty` tinyint(1) NOT NULL,
  `sale` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `active`, `img`, `novelty`, `sale`) VALUES
(1, 'Платье зеленое', 2000, 1, '0927-1100x1100.jpg', 1, 0),
(2, 'Шорты джинсовые', 2999, 1, 'product-2.jpg', 1, 1),
(3, 'Часы', 1500, 1, 'product-3.jpg', 1, 0),
(4, 'Брюки полосатые', 1300, 1, 'product-4.jpg', 0, 1),
(5, 'Сумочка', 7890, 1, 'product-5.jpg', 1, 0),
(6, 'Платье со складками', 2999, 1, 'product-6.jpg', 0, 1),
(7, 'Платье со складками', 4999, 1, 'product-7.jpg', 1, 1),
(8, 'Джинсы синие', 2100, 1, 'product-8.jpg', 0, 0),
(9, 'Полуботинки', 6000, 1, 'product-9.jpg', 1, 0),
(10, 'Товар 10', 5000, 1, 'product-3.jpg', 1, 0),
(11, 'Товар 20', 3000, 1, 'product-9.jpg', 0, 0),
(12, 'Товар 30', 999, 1, 'product-4.jpg', 0, 1),
(13, 'Часы ракета', 6000, 1, '420.0004.3.030.jpg', 1, 0),
(14, 'Платье черное', 2000, 1, 'images (1).jpg', 0, 1),
(15, 'Часы 2', 300, 1, '420.0004.3.030.jpg', 0, 0),
(16, 'Часы 3', 5000, 1, '331733.jpg', 1, 0),
(17, 'Туфли', 3400, 1, '8c039448-9fcd-11e9-80cb-000c29b92d631.resize2.jpeg', 0, 0),
(18, 'Товар 5', 120000, 1, 'Без названия.jpg', 1, 0),
(19, 'Товар 6', 50000, 1, '331733.jpg', 1, 0),
(20, 'Синее платье', 8000, 1, 'images.jpg', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products_categories`
--

CREATE TABLE `products_categories` (
  `products_id` int NOT NULL,
  `categories_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Дамп данных таблицы `products_categories`
--

INSERT INTO `products_categories` (`products_id`, `categories_id`) VALUES
(1, 1),
(3, 1),
(4, 1),
(6, 1),
(8, 1),
(9, 1),
(11, 1),
(12, 1),
(14, 1),
(20, 1),
(10, 2),
(13, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(7, 3),
(9, 3),
(11, 3),
(12, 3),
(14, 3),
(3, 4),
(5, 4),
(10, 4),
(13, 4),
(15, 4),
(16, 4),
(18, 4),
(19, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `surname` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `patronymic` varchar(50) CHARACTER SET utf32 COLLATE utf32_general_ci DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `surname`, `name`, `patronymic`, `email`, `password`) VALUES
(1, 'Чемакин', 'Александр', 'Андреевич', 'chem@gmail.com', '$2y$10$KOa39PL0OxSFuFQ32Q0.rOne.AV8j3YqCPjqNdYadM4h.PKScB5d2'),
(2, 'Федоров', 'Петр', NULL, 'fedor@gmail.com', '$2y$10$KOa39PL0OxSFuFQ32Q0.rOne.AV8j3YqCPjqNdYadM4h.PKScB5d2'),
(3, 'Максимов', 'Максим', 'Максимович', 'maksim@gmail.com', '$2y$10$KOa39PL0OxSFuFQ32Q0.rOne.AV8j3YqCPjqNdYadM4h.PKScB5d2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `groups_users`
--
ALTER TABLE `groups_users`
  ADD PRIMARY KEY (`users_id`,`groups_id`),
  ADD KEY `groups_id` (`groups_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_id` (`products_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products_categories`
--
ALTER TABLE `products_categories`
  ADD PRIMARY KEY (`products_id`,`categories_id`),
  ADD KEY `categories_id` (`categories_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`groups_id`) REFERENCES `groups` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `products_categories`
--
ALTER TABLE `products_categories`
  ADD CONSTRAINT `products_categories_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `products_categories_ibfk_2` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
