-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 11 Avril 2013 à 20:33
-- Version du serveur: 5.5.24-log
-- Version de PHP: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `connect_home`
--

-- --------------------------------------------------------

--
-- Structure de la table `actions`
--

CREATE TABLE IF NOT EXISTS `actions` (
  `IDA` int(255) NOT NULL AUTO_INCREMENT,
  `nameA` varchar(255) NOT NULL,
  `descA` varchar(255) NOT NULL,
  `actuator` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `typeA` varchar(255) NOT NULL,
  PRIMARY KEY (`IDA`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `actions`
--

INSERT INTO `actions` (`IDA`, `nameA`, `descA`, `actuator`, `status`, `typeA`) VALUES
(1, 'lampe blanche on', 'desc', 'D1', 1, 'adult'),
(2, 'lampe blanche off', 'desc', 'D1', 0, 'adult'),
(3, 'lampe noire on', 'desc', 'G1', 1, 'adult'),
(4, 'lampe noire off', 'desc', 'G1', 0, 'adult');

-- --------------------------------------------------------

--
-- Structure de la table `actuators`
--

CREATE TABLE IF NOT EXISTS `actuators` (
  `IDE` int(255) NOT NULL AUTO_INCREMENT,
  `nameE` varchar(255) NOT NULL,
  `status` int(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`IDE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `actuators`
--

INSERT INTO `actuators` (`IDE`, `nameE`, `status`, `category`) VALUES
(1, 'Capteur', 0, 'adulte'),
(2, 'Capteur', 0, 'adulte'),
(3, 'Capteur', 0, 'adulte'),
(4, 'Capteur', 0, 'adulte'),
(5, 'Capteur', 0, 'adulte'),
(6, 'Capteur', 0, 'adulte');

-- --------------------------------------------------------

--
-- Structure de la table `api`
--

CREATE TABLE IF NOT EXISTS `api` (
  `idAP` int(255) NOT NULL,
  `NameAP` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contains`
--

CREATE TABLE IF NOT EXISTS `contains` (
  `IDS` int(255) NOT NULL,
  `IDA` int(255) NOT NULL,
  KEY `contains_scenario_fk` (`IDS`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `controllers`
--

CREATE TABLE IF NOT EXISTS `controllers` (
  `IDC` int(255) NOT NULL AUTO_INCREMENT,
  `nameC` varchar(255) NOT NULL,
  `descC` varchar(255) NOT NULL,
  `IDU` int(255) NOT NULL,
  PRIMARY KEY (`IDC`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `controllers`
--

INSERT INTO `controllers` (`IDC`, `nameC`, `descC`, `IDU`) VALUES
(1, 'Kinect', 'Movement controller, do a wave with your hand to start a movement', 2);

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `IDH` int(255) NOT NULL AUTO_INCREMENT,
  `nameH` varchar(255) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`IDH`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `history`
--

INSERT INTO `history` (`IDH`, `nameH`, `Date`) VALUES
(1, 'David', '2013-04-11 09:56:28'),
(2, 'David', '2013-04-11 09:57:13');

-- --------------------------------------------------------

--
-- Structure de la table `movements`
--

CREATE TABLE IF NOT EXISTS `movements` (
  `IDM` int(255) NOT NULL AUTO_INCREMENT,
  `nameM` varchar(255) NOT NULL,
  `descM` varchar(255) NOT NULL,
  `IDC` int(255) NOT NULL,
  PRIMARY KEY (`IDM`,`IDC`),
  KEY `movements_controller_fk` (`IDC`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `movements`
--

INSERT INTO `movements` (`IDM`, `nameM`, `descM`, `IDC`) VALUES
(1, 'Swipe Left', 'Do a swipe to the left', 1),
(2, 'Swipe Right', 'Do a swipe to the right', 1),
(3, 'Push', 'Move your hand to Kinect', 1);

-- --------------------------------------------------------

--
-- Structure de la table `scenarios`
--

CREATE TABLE IF NOT EXISTS `scenarios` (
  `IDS` int(255) NOT NULL AUTO_INCREMENT,
  `nameS` varchar(255) NOT NULL,
  `descS` varchar(255) NOT NULL,
  `IDM` int(255) NOT NULL,
  `IDC` int(255) NOT NULL,
  `IDU` int(255) NOT NULL,
  PRIMARY KEY (`IDS`),
  KEY `scenarios_movement_fk` (`IDM`),
  KEY `scenarios_user_fk` (`IDU`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `IDU` int(255) NOT NULL AUTO_INCREMENT,
  `nameU` varchar(255) NOT NULL,
  `typeU` varchar(255) CHARACTER SET ucs2 NOT NULL,
  `password` varchar(255) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  PRIMARY KEY (`IDU`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`IDU`, `nameU`, `typeU`, `password`, `admin`) VALUES
(2, 'David', 'adult', 'coucou', 1),
(11, 'salut', 'child', 'salut', 0);

-- --------------------------------------------------------

--
-- Structure de la table `zibase`
--

CREATE TABLE IF NOT EXISTS `zibase` (
  `Name` varchar(255) NOT NULL,
  `Ip` varchar(255) NOT NULL,
  `Token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `zibase`
--

INSERT INTO `zibase` (`Name`, `Ip`, `Token`) VALUES
('ZiBASE0052eb', '192.168.137.100', 'e396697d9c');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `contains_scenario_fk` FOREIGN KEY (`IDS`) REFERENCES `scenarios` (`IDS`) ON DELETE CASCADE;

--
-- Contraintes pour la table `movements`
--
ALTER TABLE `movements`
  ADD CONSTRAINT `movements_controller_fk` FOREIGN KEY (`IDC`) REFERENCES `controllers` (`IDC`) ON DELETE CASCADE;

--
-- Contraintes pour la table `scenarios`
--
ALTER TABLE `scenarios`
  ADD CONSTRAINT `scenarios_movement_fk` FOREIGN KEY (`IDM`) REFERENCES `movements` (`IDM`) ON DELETE CASCADE,
  ADD CONSTRAINT `scenarios_user_fk` FOREIGN KEY (`IDU`) REFERENCES `users` (`IDU`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
