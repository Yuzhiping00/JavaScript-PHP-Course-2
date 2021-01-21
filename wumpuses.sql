-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2020 at 06:58 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `000822513`
--

-- --------------------------------------------------------

--
-- Table structure for table `wumpuses`
--

CREATE TABLE `wumpuses` (
  `wumpuse_id` int(11) NOT NULL,
  `wumpuse_row` int(11) NOT NULL,
  `wumpuse_column` int(11) NOT NULL
) ENGINE=InnoDB;

--
-- Dumping data for table `wumpuses`
--

INSERT INTO `wumpuses` (`wumpuse_id`, `wumpuse_row`, `wumpuse_column`) VALUES
(1, 2, 2),
(2, 3, 1),
(3, 4, 2),
(4, 2, 4),
(5, 1, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `wumpuses`
--
ALTER TABLE `wumpuses`
  ADD PRIMARY KEY (`wumpuse_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `wumpuses`
--
ALTER TABLE `wumpuses`
  MODIFY `wumpuse_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

