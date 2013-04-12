-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 12 Avril 2013 à 23:09
-- Version du serveur: 5.5.20
-- Version de PHP: 5.3.10

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `IDH` int(255) NOT NULL AUTO_INCREMENT,
  `nameH` varchar(255) NOT NULL,
  `Date` datetime NOT NULL,
  PRIMARY KEY (`IDH`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`IDU`, `nameU`, `typeU`, `password`, `admin`) VALUES
(1, 'Connecthome', 'adult', 'connecthome', 1);

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
('ZiBASE0052eb', '192.168.137.36', 'e396697d9c');

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
