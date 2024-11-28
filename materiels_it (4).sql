-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 28 nov. 2024 à 11:36
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `materiels_it`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `commande_id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  `materiel_commander` varchar(255) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `etat_actuel` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`commande_id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`commande_id`, `utilisateur_id`, `date_commande`, `materiel_commander`, `quantite`, `etat_actuel`) VALUES
(3, 8, '2024-05-06 17:16:05', 'imprimante', 1, 'Commander'),
(4, 8, '2024-05-06 17:16:10', 'imprimante', 1, 'En attente'),
(5, 9, '2024-05-14 08:42:51', 'imprimande', 1, 'Commander'),
(6, 9, '2024-05-14 08:44:37', 'imprimande', 1, 'Commander'),
(7, 9, '2024-05-14 08:44:43', 'imprimande', 1, 'Commander'),
(8, 9, '2024-05-14 08:45:03', 'imprimande', 1, 'Commander'),
(9, 8, '2024-05-17 15:00:22', 'pc', 2, 'Commander'),
(10, 8, '2024-05-17 15:06:44', 'pc', 2, 'Commander'),
(11, 8, '2024-05-17 22:54:34', 'imprimante', 1, 'Commander'),
(14, 19, '2024-05-21 17:47:38', 'imprimante', 1, 'Delivrer'),
(16, 19, '2024-05-22 11:20:56', 'pc', 1, 'Commander');

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

DROP TABLE IF EXISTS `materiel`;
CREATE TABLE IF NOT EXISTS `materiel` (
  `materiel_id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_number` varchar(255) DEFAULT NULL,
  `type_materiel` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `etat` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`materiel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`materiel_id`, `serial_number`, `type_materiel`, `nom`, `couleur`, `etat`) VALUES
(11, '12', 'canon', 'copie', 'noir', ''),
(16, 'PF43T6HJ', 'lenovo', 'pc', 'gris', ''),
(10, '5', 'Iphone', 'pc', 'blanc', 'bon_etat'),
(18, 'copie', 'lenovo', 'pc', 'gris', 'stock'),
(19, 'copie', 'lenovo', 'pc', 'gris', 'stock'),
(20, 'PF43T6HJ', 'lenovo', 'impr', 'bleu', ''),
(22, 'PF43T6HJ', 'canon', 'imprimant', 'gris', '');

-- --------------------------------------------------------

--
-- Structure de la table `pannes`
--

DROP TABLE IF EXISTS `pannes`;
CREATE TABLE IF NOT EXISTS `pannes` (
  `panne_id` int(11) NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int(11) DEFAULT NULL,
  `materiel_panne` varchar(255) DEFAULT NULL,
  `date_declaration` datetime DEFAULT NULL,
  `etat_actuel` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`panne_id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `pannes`
--

INSERT INTO `pannes` (`panne_id`, `utilisateur_id`, `materiel_panne`, `date_declaration`, `etat_actuel`) VALUES
(12, 8, 'pc', '2024-05-18 06:05:11', 'reparer'),
(13, 8, 'imprimant est en panne\r\n', '2024-05-19 17:03:43', 'Pannes'),
(10, 8, 'imprimant', '2024-05-18 06:02:16', 'panne'),
(11, 8, 'copie', '2024-05-18 06:02:16', 'panne'),
(14, 8, 'imprimant est en panne\r\n', '2024-05-19 17:09:10', 'Pannes'),
(15, 8, 'panne de pc', '2024-05-19 17:09:58', 'Pannes'),
(17, 8, 'panne pc', '2024-05-19 17:11:46', 'Pannes'),
(18, 8, 'kplk', '2024-05-19 17:12:02', 'Pannes'),
(19, 8, 'pc', '2024-05-19 17:39:36', 'Pannes'),
(22, 8, 'pc portable', '2024-05-19 17:55:28', 'Pannes'),
(24, 19, 'pc', '2024-05-21 19:28:22', 'Pannes'),
(25, 19, 'imprimante', '2024-05-21 19:28:32', 'Pannes'),
(26, 19, 'copie', '2024-05-21 19:28:38', 'reparer'),
(28, 19, 'PC', '2024-05-22 11:21:40', 'Pannes');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `utilisateur_id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `type_utilisateur` varchar(255) DEFAULT NULL,
  `genre` varchar(20) DEFAULT NULL,
  `grade` varchar(30) DEFAULT NULL,
  `profession` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`utilisateur_id`, `nom`, `prenom`, `email`, `numero`, `mot_de_passe`, `type_utilisateur`, `genre`, `grade`, `profession`) VALUES
(22, 'Mahamoud', 'Bouraleh', 'moud@gmail.com', '77153498', '$2y$10$iyfzrrqvI62r/8aeIuA3M.are/zS.LY9wkuklYqFNqgpShW/y4u9G', 'utilisateur_it', 'Homme', 'master', 'doyen');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
