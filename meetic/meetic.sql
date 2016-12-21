-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2016 at 08:10 PM
-- Server version: 5.7.12-0ubuntu1
-- PHP Version: 7.0.4-7ubuntu2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `meetic`
--

-- --------------------------------------------------------

--
-- Table structure for table `favorite`
--

CREATE TABLE `favorite` (
  `id_follower` int(11) NOT NULL,
  `id_following` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `favorite`
--

INSERT INTO `favorite` (`id_follower`, `id_following`) VALUES
(37, 38),
(37, 39);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL,
  `id_from` int(11) NOT NULL,
  `id_to` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message_delete` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id_message`, `id_from`, `id_to`, `content`, `date`, `message_delete`) VALUES
(1, 0, 37, 'Salut comment tu vas mon amis ?', '2016-07-06 13:25:20', 0),
(2, 37, 38, 'WESH ALORS', '2016-07-06 09:25:20', 0),
(3, 38, 37, 'AHAHAHAHAHAHAH', '2016-07-06 13:25:20', 0),
(4, 38, 37, 'je suis un boloss un peu comme clément', '2016-07-06 13:25:20', 0),
(5, 37, 38, 'Bonjour dada j\'aimerai vraiment te pécho', '2016-07-06 14:27:54', 0),
(6, 38, 37, 'Mdrr t\'es qui pour me juger !!', '2016-07-06 14:28:39', 1),
(7, 38, 37, 'Mais stp fait pas la michto ... :(', '2016-07-06 14:55:13', 1),
(8, 37, 37, 'swag swag swag', '2016-07-06 15:30:22', 0),
(9, 37, 38, 'salut ca va dada mdrr ', '2016-07-06 15:32:43', 0),
(12, 37, 40, 'salut ca va ? ALAINCULE', '2016-07-08 14:09:29', 1),
(13, 40, 37, 'mdrr des barres', '2016-07-08 14:20:19', 0),
(14, 37, 40, 'sa', '2016-07-08 14:23:55', 1),
(15, 37, 40, 'Cassage de barres', '2016-07-08 14:24:08', 0),
(16, 37, 38, 'J\'aime bien ton pseudo', '2016-07-08 14:24:31', 0),
(17, 37, 40, 't\'es trop un bg on sort ensemble ? ', '2016-07-08 14:52:47', 0),
(18, 37, 40, 'Salut ca va bb ? ', '2016-07-10 17:08:24', 0),
(19, 37, 40, 'WSH MEC', '2016-07-13 07:46:10', 0),
(20, 37, 40, 'Salut ca va ? ', '2016-07-13 07:46:27', 0),
(21, 37, 37, 'sasa', '2016-07-17 12:25:49', 1),
(22, 37, 37, 'sasa', '2016-07-17 12:26:09', 1),
(23, 37, 37, 'sasa', '2016-07-17 12:28:00', 1),
(24, 37, 37, 'sasa', '2016-07-17 12:29:42', 1),
(25, 37, 37, 'yolo', '2016-07-17 12:30:58', 1),
(26, 37, 37, 'yolo', '2016-07-17 12:32:04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `preference`
--

CREATE TABLE `preference` (
  `id_user` int(11) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `city` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `age` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `preference`
--

INSERT INTO `preference` (`id_user`, `gender`, `city`, `department`, `region`, `country`, `age`) VALUES
(37, 'femme', 'Ssasa', 'sasa', 'sasa', 'sasa', '25-35');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `first_name` varchar(40) NOT NULL,
  `pseudo` varchar(40) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `city` varchar(30) NOT NULL,
  `department` varchar(30) NOT NULL,
  `region` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` char(64) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `last_name`, `first_name`, `pseudo`, `birthday`, `gender`, `city`, `department`, `region`, `country`, `email`, `password`, `active`) VALUES
(37, 'Roos', 'paul', 'SwagMaster', '1997-05-20', 'homme', 'Istres', 'Bouche du rhone', 'paca', 'France', 'paul.roos@epitech.eu', 'f2d81a260dea8a100dd517984e53c56a7523d96942a834b9cdc249bd4e8c7aa9', 1),
(38, 'sasa', 'saosa', 'dada', '1990-02-10', 'femme', 'Ssasa', 'sasa', 'sasa', 'sasa', 'sasa@sasa.fr', 'f2d81a260dea8a100dd517984e53c56a7523d96942a834b9cdc249bd4e8c7aa9', 1),
(39, 'Bon', 'Jean', 'jambon', '1995-10-02', 'homme', 'le kremlin', 'ile de france', 'val de marne', 'France', 'phpmyadmin@sakosa.fr', 'f2d81a260dea8a100dd517984e53c56a7523d96942a834b9cdc249bd4e8c7aa9', 1),
(40, 'Culé', 'Alain', 'Alainculé', '1996-05-20', 'homme', 'Jaurès', 'Paris', 'ile de france', 'France', 'asa@aa.fr', 'f2d81a260dea8a100dd517984e53c56a7523d96942a834b9cdc249bd4e8c7aa9', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
