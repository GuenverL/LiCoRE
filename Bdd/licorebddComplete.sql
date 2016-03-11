-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 11 Mars 2016 à 14:03
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `licorebdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `acces`
--

CREATE TABLE IF NOT EXISTS `acces` (
  `idRole` int(11) NOT NULL,
  `idPage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `acces`
--

INSERT INTO `acces` (`idRole`, `idPage`) VALUES
(2, 3),
(1, 3),
(1, 2),
(4, 2);

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

CREATE TABLE IF NOT EXISTS `competence` (
  `idCompetence` int(11) NOT NULL AUTO_INCREMENT,
  `nomCompetence` varchar(250) NOT NULL,
  `idPereCompetence` int(11) DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idCompetence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `competence`
--

INSERT INTO `competence` (`idCompetence`, `nomCompetence`, `idPereCompetence`, `visible`) VALUES
(1, 'Situer son rôle et sa mission au sein d''une organisation pour s''adapter et prendre des initiatives', 28, 1),
(2, 'Identifier le processus de production, de diffusion et de valorisation des savoirs', 28, 1),
(3, 'Respecter les principes d’éthique, de déontologie et de responsabilité environnementale', 28, 1),
(4, 'Travailler en équipe autant qu’en autonomie et responsabilité au service d’un projet', 28, 1),
(5, 'Identifier et situer les champs professionnels potentiellement en relation avec les acquis de la mention ainsi que les parcours possibles pour y accéder', 28, 1),
(6, 'Caractériser et valoriser son identité, ses compétences et son projet professionnel en fonction d’un contexte', 28, 1),
(7, 'Se mettre en recul d’une situation, s’auto évaluer et se remettre en question pour apprendre', 28, 1),
(8, 'Utiliser les outils numériques de référence et les règles de sécurité informatique pour acquérir, traiter, produire et diffuser de l’information ainsi que pour collaborer en interne et en externe', 29, 1),
(9, 'Identifier et sélectionner diverses ressources spécialisées pour documenter un sujet', 29, 1),
(10, 'Analyser et synthétiser des données en vue de leur exploitation', 29, 1),
(11, 'Développer une argumentation avec esprit critique', 29, 1),
(12, 'Se servir aisément des différents registres d’expression écrite et orale de la langue française', 29, 1),
(13, 'Se servir aisément de la compréhension et de l’expression écrites et orales dans au moins une langue vivante étrangère', 29, 1),
(14, 'Identifier le rôle et le champ d’application des sciences pour l’ingénieur dans tous les\r\nsecteurs : milieux naturels, milieux industriels, transports, environnements urbains, etc', 26, 1),
(15, 'Valider un modèle par comparaison de ses prévisions aux résultats expérimentaux et apprécier ses limites de validité', 26, 1),
(16, 'Identifier les principales familles de matériaux et leurs propriétés', 26, 1),
(17, 'Mobiliser les outils mathématiques nécessaires à la modélisation', 26, 1),
(18, 'Mobiliser des concepts en mathématiques, en physique, en chimie, en thermodynamique, afin d’aborder des problèmes spécifiques aux différents domaines industriels', 26, 1),
(19, 'Estimer les ordres de grandeur et manipuler correctement les unités', 26, 1),
(20, 'Intégrer une vision correcte de l’espace et de ses représentations', 26, 1),
(21, 'Isoler un système', 26, 1),
(22, 'Mettre en œuvre des techniques d’algorithmique et de programmation, notamment pour développer des applications simples d’acquisition et de traitements de données', 26, 1),
(23, 'Droit', 27, 1),
(24, 'Économie', 27, 1),
(25, 'Histoire', 27, 1),
(26, 'Sciences pour l''ingénieur\r\n', 27, 1),
(27, 'Disciplinaires', NULL, 1),
(28, 'Préprofessionnelles', NULL, 1),
(29, 'Transversales et linguistiques', NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `idPage` int(11) NOT NULL AUTO_INCREMENT,
  `nomPage` varchar(50) NOT NULL,
  PRIMARY KEY (`idPage`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `page`
--

INSERT INTO `page` (`idPage`, `nomPage`) VALUES
(2, 'gestion-competences'),
(3, 'valider-competences-utilisateurs');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `idRole` int(11) NOT NULL AUTO_INCREMENT,
  `nomRole` varchar(50) NOT NULL,
  PRIMARY KEY (`idRole`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `role`
--

INSERT INTO `role` (`idRole`, `nomRole`) VALUES
(1, 'Administrateur'),
(2, 'Tuteur'),
(3, 'Etudiant'),
(4, 'Enseignant concepteur');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `identifiant` varchar(250) NOT NULL,
  `prenom` varchar(250) NOT NULL,
  `nom` varchar(250) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  `idRole` int(11) NOT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `identifiant`, `prenom`, `nom`, `mdp`, `idRole`) VALUES
(2, 'UtilisateurAdmin', 'admin', 'admin', 'test', 1),
(4, 'UtilisateurEtu1', 'prenomEtu1', 'nomEtu1', 'mdpEtu1', 3),
(5, 'UtilisateurEtu2', 'prenomEtu2', 'nomEtu2', 'mdpEtu2', 3),
(6, 'UtilisateurEtu3', 'prenomEtu3', 'nomEtu3', 'mdpEtu3', 3),
(7, 'UtilisateurEtu4', 'prenomEtu4', 'nomEtu4', 'mdpEtu4', 3),
(8, 'UtilisateurEtu5', 'prenomEtu5', 'nomEtu5', 'mdpEtu5', 3),
(9, 'UtilisateurEtu6', 'prenomEtu6', 'nomEtu6', 'mdpEtu6', 3),
(10, 'UtilisateurEtu7', 'prenomEtu7', 'nomEtu7', 'mdpEtu7', 3),
(11, 'UtilisateurEtu8', 'prenomEtu8', 'nomEtu8', 'mdpEtu8', 3),
(12, 'UtilisateurEtu9', 'prenomEtu9', 'nomEtu9', 'mdpEtu9', 3),
(13, 'UtilisateurEtu10', 'prenomEtu10', 'nomEtu10', 'mdpEtu10', 3),
(14, 'UtilisateurEtu11', 'prenomEtu11', 'nomEtu11', 'mdpEtu11', 3),
(15, 'UtilisateurEtu12', 'prenomEtu12', 'nomEtu12', 'mdpEtu12', 3),
(16, 'UtilisateurEtu13', 'prenomEtu13', 'nomEtu13', 'mdpEtu13', 3),
(17, 'UtilisateurEtu14', 'prenomEtu14', 'nomEtu14', 'mdpEtu14', 3),
(18, 'UtilisateurEtu15', 'prenomEtu15', 'nomEtu15', 'mdpEtu15', 3),
(19, 'UtilisateurEtu16', 'prenomEtu16', 'nomEtu16', 'mdpEtu16', 3),
(20, 'UtilisateurEtu17', 'prenomEtu17', 'nomEtu17', 'mdpEtu17', 3),
(21, 'UtilisateurEtu18', 'prenomEtu18', 'nomEtu18', 'mdpEtu18', 3),
(22, 'UtilisateurEtu19', 'prenomEtu19', 'nomEtu19', 'mdpEtu19', 3),
(23, 'UtilisateurEtu20', 'prenomEtu20', 'nomEtu20', 'mdpEtu20', 3),
(24, 'UtilisateurTuteur1', 'prenomTuteur1', 'nomTuteur1', 'mdpTuteur1', 2),
(25, 'UtilisateurTuteur2', 'prenomTuteur2', 'nomTuteur2', 'mdpTuteur2', 2),
(26, 'UtilisateurTuteur3', 'prenomTuteur3', 'nomTuteur3', 'mdpTuteur3', 2),
(27, 'UtilisateurTuteur4', 'prenomTuteur4', 'nomTuteur4', 'mdpTuteur4', 2),
(28, 'UtilisateurTuteur5', 'prenomTuteur5', 'nomTuteur5', 'mdpTuteur5', 2),
(29, 'UtilisateurTuteur6', 'prenomTuteur6', 'nomTuteur6', 'mdpTuteur6', 2),
(30, 'UtilisateurTuteur7', 'prenomTuteur7', 'nomTuteur7', 'mdpTuteur7', 2),
(31, 'UtilisateurTuteur8', 'prenomTuteur8', 'nomTuteur8', 'mdpTuteur8', 2),
(32, 'UtilisateurTuteur9', 'prenomTuteur9', 'nomTuteur9', 'mdpTuteur9', 2),
(33, 'UtilisateurTuteur10', 'prenomTuteur10', 'nomTuteur10', 'mdpTuteur10', 2),
(34, 'UtilisateurTuteur11', 'prenomTuteur11', 'nomTuteur11', 'mdpTuteur11', 2),
(35, 'UtilisateurTuteur12', 'prenomTuteur12', 'nomTuteur12', 'mdpTuteur12', 2),
(36, 'UtilisateurTuteur13', 'prenomTuteur13', 'nomTuteur13', 'mdpTuteur13', 2),
(37, 'UtilisateurTuteur14', 'prenomTuteur14', 'nomTuteur14', 'mdpTuteur14', 2),
(38, 'UtilisateurTuteur15', 'prenomTuteur15', 'nomTuteur15', 'mdpTuteur15', 2),
(39, 'UtilisateurTuteur16', 'prenomTuteur16', 'nomTuteur16', 'mdpTuteur16', 2),
(40, 'UtilisateurTuteur17', 'prenomTuteur17', 'nomTuteur17', 'mdpTuteur17', 2),
(41, 'UtilisateurTuteur18', 'prenomTuteur18', 'nomTuteur18', 'mdpTuteur18', 2),
(42, 'UtilisateurTuteur19', 'prenomTuteur19', 'nomTuteur19', 'mdpTuteur19', 2),
(43, 'UtilisateurTuteur20', 'prenomTuteur20', 'nomTuteur20', 'mdpTuteur20', 2);

-- --------------------------------------------------------

--
-- Structure de la table `validation`
--

CREATE TABLE IF NOT EXISTS `validation` (
  `idUtilisateur` int(11) NOT NULL,
  `idCompetence` int(11) NOT NULL,
  `dateValidation` date NOT NULL,
  `explicationUtilisateur` text,
  `idTuteur` int(11) DEFAULT NULL,
  `explicationTuteur` text,
  PRIMARY KEY (`idCompetence`,`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
