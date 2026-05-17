-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2026 at 06:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vinyl_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `vinyls`
--

CREATE TABLE `vinyls` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 25.00,
  `stock` int(11) NOT NULL DEFAULT 10,
  `image_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(50) DEFAULT 'EP',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vinyls`
--

INSERT INTO `vinyls` (`id`, `title`, `artist`, `genre`, `price`, `stock`, `image_url`, `description`, `type`, `updated_at`, `updated_by`, `uploaded_by`) VALUES
(1, 'Waiting on Mongo', 'Waiting on Mongo', 'soul', 25.00, 10, 'img/img1.jpg', 'Great Music', 'EP', '2026-05-18 00:11:06', NULL, NULL),
(2, 'Fly Me to the Moon (NP)', 'Bobby Womack', 'soul', 25.00, 10, 'img/img2.jpg', NULL, 'NP', '2026-05-18 00:11:06', NULL, NULL),
(3, 'Aladdin Soundtrack', 'Walt Disney Studios Motion Pictures', 'Musical', 120.00, 10, 'img/img12.jpg', NULL, 'EP', '2026-05-18 00:20:44', NULL, NULL),
(4, '1989', 'Taylor Swift', 'pop', 120.00, 10, 'img/img10.jpg', NULL, 'EP', '2026-05-18 00:20:44', NULL, NULL),
(5, 'Viva la Vida', 'Coldplay', 'soul musical pop', 25.00, 10, 'img/img3.jpg', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL),
(6, 'Parachutes', 'Coldplay', 'soul pop', 25.00, 10, 'img/img4.jpg', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL),
(7, 'Can\'t help falling in love (NP)', 'Elvis Presley', 'soul pop', 25.00, 10, 'img/img5.jpg', NULL, 'NP', '2026-05-18 00:11:06', NULL, NULL),
(8, 'Wicked Soundtrack', 'Universal Music', 'musical', 155.00, 10, 'img/img7.jpg', NULL, 'EP', '2026-05-18 00:21:53', NULL, NULL),
(9, 'Sweet Child of Mine', 'Guns n Roses', 'rock', 25.00, 10, 'img/img6.jpg', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL),
(10, 'Brown Sugar (NP)', 'D\'Angelo Music', 'soul rock', 25.00, 10, 'img/img8.jpg', NULL, 'NP', '2026-05-18 00:11:06', NULL, NULL),
(11, 'What makes you beautiful (NP)', 'One Direction', 'soul pop', 155.00, 10, 'img/img9.jpg', NULL, 'NP', '2026-05-18 00:21:53', NULL, NULL),
(12, 'Those 2 Windows', 'Alec Benjamin', 'pop', 25.00, 10, 'img/img11.jpg', NULL, 'NP', '2026-05-18 00:11:06', NULL, NULL),
(13, 'Cinderella', 'Walt Disney Studios Motion Pictures', 'musical', 25.00, 10, 'img/img13.jpg', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL),
(14, 'Nocturnes', 'Chopin', 'classical', 120.00, 10, 'img/img14.jpg', NULL, 'EP', '2026-05-18 00:20:44', NULL, NULL),
(15, 'Star Wars Soundtrack', 'Lucasfilms', 'classical musical', 25.00, 10, 'img/img15.jpg', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL),
(16, 'Swan Lake', 'Tchaikovsky', 'classical', 25.00, 10, 'img/img16.jpg', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL),
(17, 'Hard Skool', 'Guns N Roses', 'rock', 25.00, 10, 'img/img17.jpg', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL),
(18, 'test', 'Artist', 'Genre', 25.00, 10, 'img/vinyl_688aa294c9a808.84101195.png', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL),
(19, 'Eternal Sunshine', 'Ariana Grande', 'Pop', 25.00, 10, 'img/vinyl_688b6c78bb4d62.61317480.jpeg', NULL, 'EP', '2026-05-18 00:11:06', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vinyls`
--
ALTER TABLE `vinyls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_updated_by` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vinyls`
--
ALTER TABLE `vinyls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
