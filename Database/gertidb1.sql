-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 08, 2025 at 07:16 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gertidb1`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(255) NOT NULL,
  `Book name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `Price` varchar(255) NOT NULL,
  `rating` int(255) NOT NULL,
  `Books_image` varchar(255) DEFAULT NULL,
  `Book_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `Book name`, `description`, `Price`, `rating`, `Books_image`, `Book_name`) VALUES
(4, '', 'A timeless tale of love and loss aboard the ill-fated RMS Titanic. Amidst the grandeur and tragedy, two souls find each other in the face of destiny, passion, and heartbreak. A story that captures the depths of human emotion and the resilience of hope eve', '20', 9, '../images/titanic.jpg', 'Titanic'),
(5, '', 'In a small town where memories fade and secrets linger, a young woman uncovers her family\'s hidden past through letters lost in time. A deeply moving tale of love, loss, and redemption that will touch your soul and remind you that sometimes, the quietest ', '15', 7, '../images/WSP.png', 'Whispers of the forgotten'),
(6, '', 'In the quiet village of Avignon, where lavender fields stretch endlessly under a fading sun, lives Eléa — a young woman caught between grief and discovery. After the sudden loss of her grandmother, she uncovers a box of old letters tucked away in an attic', '20', 7, '../images/the.jpg', 'The Letters We Left Behind');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'Gert', 'gerticalaj1@gmail.com', 'TEST', '2025-10-08 16:16:48');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `purchase_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(150) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `book_id`, `quantity`, `purchase_datetime`, `customer_name`, `customer_email`, `address`) VALUES
(1, 4, 1, '2025-10-06 18:37:24', NULL, NULL, NULL),
(2, 4, 2, '2025-10-06 18:38:08', NULL, NULL, NULL),
(3, 4, 3, '2025-10-06 18:43:06', NULL, NULL, NULL),
(4, 5, 3, '2025-10-06 18:59:02', NULL, NULL, NULL),
(5, 6, 3, '2025-10-08 17:51:49', NULL, NULL, NULL),
(6, 4, 6, '2025-10-08 17:53:57', NULL, NULL, NULL),
(7, 4, 6, '2025-10-08 17:54:24', NULL, NULL, NULL),
(8, 4, 5, '2025-10-08 18:02:01', NULL, NULL, NULL),
(9, 4, 1, '2025-10-08 18:20:35', NULL, NULL, NULL),
(10, 4, 1, '2025-10-08 18:25:08', NULL, NULL, NULL),
(11, 4, 1, '2025-10-08 18:27:05', NULL, NULL, NULL),
(12, 4, 1, '2025-10-08 19:13:21', NULL, NULL, NULL),
(13, 4, 1, '2025-10-08 19:15:42', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `email`, `password`, `is_admin`) VALUES
(2, 'Gerti', 'Calaj', 'gerticalaj1@gmail.com', '$2y$10$AosLT89R4X4Hi5uHMwI.PuVDKallit.ot/4hsa415lMXa.zToZuQm', 1),
(3, 'Gerti', 'Calaj', 'gerticalaj1@gmail.com', '$2y$10$lErhSpuWQcW7JnMwnLaQ4eh9wDPOdF590I4hG5V2BqWESXvrStifS', 1),
(5, 'Dren', 'Gashi', 'drengashi@gmail.com', '$2y$10$7Nke/cTCSbkFX/kr2I.Jo.8tY.D3vN/WBrciTaJxzjqCTgnLH.B5i', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
