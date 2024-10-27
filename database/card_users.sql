-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 04:34 AM
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
-- Database: `card_users`
--

-- --------------------------------------------------------

--
-- Table structure for table `users_dusi`
--

CREATE TABLE `users_dusi` (
  `sno` int(11) NOT NULL,
  `name_title` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `date` date DEFAULT NULL,
  `identification` varchar(20) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `id_card` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_dusi`
--

INSERT INTO `users_dusi` (`sno`, `name_title`, `name`, `surname`, `birthday`, `date`, `identification`, `sex`, `id_card`) VALUES
(68, 'นางสาว', 'ภักดี', 'รักษาดี', '2024-10-01', NULL, '1234567891231', 'หญิง', '00000001'),
(69, 'เด็กชาย', 'ใส่ใจ', 'รักษาดี', '2024-10-02', NULL, '1234567891233', 'ชาย', '00000003'),
(70, 'นาย', 'ดุสิต', 'รักษาดี', '2024-10-04', NULL, '1234567891230', 'ชาย', '00000000'),
(71, 'นางสาว', 'สุขภาพ', 'รักษาดี', '2024-10-07', NULL, '1234567891234', 'หญิง', '00000004'),
(72, 'เด็กหญิง', 'สุภาพ', 'รักษาดี', '2024-10-16', NULL, '1234567891232', 'หญิง', '00000002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users_dusi`
--
ALTER TABLE `users_dusi`
  ADD PRIMARY KEY (`sno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users_dusi`
--
ALTER TABLE `users_dusi`
  MODIFY `sno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
