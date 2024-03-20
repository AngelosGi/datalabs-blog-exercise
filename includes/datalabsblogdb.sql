DROP DATABASE IF EXISTS datalabsblogdb;
CREATE DATABASE datalabsblogdb;

USE datalabsblogdb;

DROP TABLE IF EXISTS `comments`;
DROP TABLE IF EXISTS `posts`;
DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$psRT0DegzAMAKDiz8jfwr.UZe0icQ/lQb1Hm9/lAAyLOiiAWeirU2');

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `posts` (`id`, `title`, `content`, `author`, `date`, `image`) VALUES
(1, '1', '1', '1', '2024-01-21 19:41:17', NULL),
(2, 'AAAAAAAAAAAAAAAAAAAAAAAA', 'aasd', 'aasd', '2024-01-21 19:54:30', NULL),
(3, 'asd', 'asd', 'asd', '2024-01-21 20:01:58', NULL),
(4, 'a', 'a', 'a', '2024-01-21 20:02:02', NULL),
(5, 'AS', 'ass', 'aSasASSFDFSDFAGGELOS', '2024-01-21 20:58:47', NULL),
(6, '123', '3211444', '23', '2024-01-21 21:39:48', NULL);

CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `comments` (`id`, `post_id`, `author`, `content`, `date`) VALUES
(1, 1, 'a', 'a', '2024-01-21 19:41:24'),
(2, 4, 'a', 'a', '2024-01-21 20:18:38'),
(3, 4, 'a', 'asd', '2024-01-21 20:24:09'),
(4, 6, 'AS', 'as', '2024-01-21 22:36:10');
