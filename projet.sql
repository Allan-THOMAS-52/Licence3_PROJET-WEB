-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 15 mars 2024 à 22:33
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `forum`
--

DROP TABLE IF EXISTS `forum`;
CREATE TABLE IF NOT EXISTS `forum` (
  `id_forum` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) NOT NULL,
  PRIMARY KEY (`id_forum`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `forum`
--

INSERT INTO `forum` (`id_forum`, `titre`) VALUES
(1, 'Général'),
(2, 'Informatique');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int NOT NULL AUTO_INCREMENT,
  `id_forum` int NOT NULL,
  `id_utilisateur` int NOT NULL,
  `contenu` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id_message`),
  KEY `FK_Discussion` (`id_forum`),
  KEY `FK_Utilisateur` (`id_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id_message`, `id_forum`, `id_utilisateur`, `contenu`, `date`) VALUES
(28, 1, 0, '13', '2024-03-13 17:42:32'),
(2, 1, 0, 'BOnjour\r\n', '0000-00-00 00:00:00'),
(3, 1, 0, 'k\r\n', '0000-00-00 00:00:00'),
(5, 1, 0, 'abc', '0000-00-00 00:00:00'),
(6, 1, 0, 'd', '0000-00-00 00:00:00'),
(7, 1, 0, 'd', '0000-00-00 00:00:00'),
(8, 1, 3, 'test', '2024-03-10 19:04:56'),
(9, 1, 3, 'test', '2024-03-10 19:05:00'),
(10, 1, 3, 'test', '2024-03-10 19:07:43'),
(11, 1, 3, '', '2024-03-10 19:07:53'),
(12, 1, 3, 'd', '2024-03-10 19:07:58'),
(13, 1, 1, 'A', '2024-03-10 19:08:42'),
(14, 1, 1, 'D', '2024-03-10 19:08:50'),
(15, 1, 1, '', '2024-03-10 19:35:02'),
(16, 1, 1, 'test', '2024-03-10 19:39:32'),
(17, 1, 1, '$utilisateur_id\r\n$utilisateur_id', '2024-03-10 19:39:50'),
(18, 1, 1, '$id_utilisateur', '2024-03-10 19:39:59'),
(20, 2, 1, '', '2024-03-10 19:41:46'),
(22, 1, 1, 'PROBLEME: Le nom d\'utilisateur est toujours celui du dernier connecté (sur des pages différentes) ', '2024-03-10 19:51:46'),
(23, 1, 1, '\'', '2024-03-10 20:14:34'),
(24, 2, 1, '\' \" $ ', '2024-03-10 20:14:50');


-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Numero` varchar(10) NOT NULL,
  `MDP` varchar(50) NOT NULL,
  `Type` enum('Etudiant','Professeur') NOT NULL,
  `theme` enum('noir','blanc') NOT NULL DEFAULT 'blanc',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--


INSERT INTO `utilisateur` (`id`, `Nom`, `Prenom`, `Numero`, `MDP`, `Type`, `theme`) VALUES
(165489, 'THOMAS', 'Allan', '31415', 'mdp', 'Etudiant', 'blanc'),
(5, 'admin', 'admin', '1', 'admin', 'Professeur', 'noir'),
(6, 'Dumont', 'Jean', '1', 'prof', 'Professeur', 'blanc'),
(13, 'STIZ', 'Romain', '1', 'A', 'Etudiant', 'noir');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
