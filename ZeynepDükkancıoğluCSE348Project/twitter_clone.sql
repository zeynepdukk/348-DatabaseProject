-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 01, 2023 at 10:56 PM


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `follows` (
  `follow_id` int NOT NULL,
  `user_id` int NOT NULL,
  `following_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tweets`
--

CREATE TABLE `tweets` (
  `tweet_id` int NOT NULL,
  `user_id` int NOT NULL,
  `tweet_content` varchar(255) NOT NULL,
  `tweet_created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_register_date` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `follows`
  ADD PRIMARY KEY (`follow_id`);


ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tweet_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);


ALTER TABLE `follows`
  MODIFY `follow_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;


ALTER TABLE `tweets`
  MODIFY `tweet_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;


ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

