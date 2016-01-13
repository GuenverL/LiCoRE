-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 07 Janvier 2016 à 16:26
-- Version du serveur: 5.5.46-0ubuntu0.14.04.2
-- Version de PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `LicoreBdd`
--

-- --------------------------------------------------------

--
-- Structure de la table `CategorieCompetence`
--

CREATE TABLE IF NOT EXISTS `CategorieCompetence` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(250) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `CategorieCompetence`
--

INSERT INTO `CategorieCompetence` (`idCategorie`, `nomCategorie`) VALUES
(1, 'disciplinaires'),
(2, 'préprofessionnelles'),
(3, 'transversales et linguistiques');

-- --------------------------------------------------------

--
-- Structure de la table `Competence`
--

CREATE TABLE IF NOT EXISTS `Competence` (
  `idCompetence` int(11) NOT NULL AUTO_INCREMENT,
  `nomCompetence` varchar(250) NOT NULL,
  `pereCompetence` int(11) DEFAULT NULL,
  `idCategorie` int(11) NOT NULL,
  `idMention` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCompetence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Contenu de la table `Competence`
--

INSERT INTO `Competence` (`idCompetence`, `nomCompetence`, `pereCompetence`, `idCategorie`, `idMention`) VALUES
(1, 'Situer son rôle et sa mission au sein d''une organisation pour s''adapter et prendre des initiatives', NULL, 2, NULL),
(2, 'Identifier le processus de production, de diffusion et de valorisation des savoirs', NULL, 2, NULL),
(3, 'Respecter les principes d’éthique, de déontologie et de responsabilité environnementale', NULL, 2, NULL),
(4, 'Travailler en équipe autant qu’en autonomie et responsabilité au service d’un projet', NULL, 2, NULL),
(5, 'Identifier et situer les champs professionnels potentiellement en relation avec les acquis de la mention ainsi que les parcours possibles pour y accéder', NULL, 2, NULL),
(6, 'Caractériser et valoriser son identité, ses compétences et son projet professionnel en fonction d’un contexte', NULL, 2, NULL),
(7, 'Se mettre en recul d’une situation, s’auto évaluer et se remettre en question pour apprendre', NULL, 2, NULL),
(8, 'Utiliser les outils numériques de référence et les règles de sécurité informatique pour acquérir, traiter, produire et diffuser de l’information ainsi que pour collaborer en interne et en externe', NULL, 3, NULL),
(9, 'Identifier et sélectionner diverses ressources spécialisées pour documenter un sujet', NULL, 3, NULL),
(10, 'Analyser et synthétiser des données en vue de leur exploitation', NULL, 3, NULL),
(11, 'Développer une argumentation avec esprit critique', NULL, 3, NULL),
(12, 'Se servir aisément des différents registres d’expression écrite et orale de la langue française', NULL, 3, NULL),
(13, 'Se servir aisément de la compréhension et de l’expression écrites et orales dans au moins une langue vivante étrangère', NULL, 3, NULL),
(14, 'Identifier le rôle et le champ d’application des sciences pour l’ingénieur dans tous les\r\nsecteurs : milieux naturels, milieux industriels, transports, environnements urbains, etc', NULL, 1, 4),
(15, 'Valider un modèle par comparaison de ses prévisions aux résultats expérimentaux et apprécier ses limites de validité', NULL, 1, 4),
(16, 'Identifier les principales familles de matériaux et leurs propriétés', NULL, 1, 4),
(17, 'Mobiliser les outils mathématiques nécessaires à la modélisation', NULL, 1, 4),
(18, 'Mobiliser des concepts en mathématiques, en physique, en chimie, en thermodynamique, afin d’aborder des problèmes spécifiques aux différents domaines industriels', NULL, 1, 4),
(19, 'Estimer les ordres de grandeur et manipuler correctement les unités', NULL, 1, 4),
(20, 'Intégrer une vision correcte de l’espace et de ses représentations', NULL, 1, 4),
(21, 'Isoler un système', NULL, 1, 4),
(22, 'Mettre en œuvre des techniques d’algorithmique et de programmation, notamment pour développer des applications simples d’acquisition et de traitements de données', NULL, 1, 4);

-- --------------------------------------------------------

--
-- Structure de la table `Mention`
--

CREATE TABLE IF NOT EXISTS `Mention` (
  `idMention` int(11) NOT NULL AUTO_INCREMENT,
  `nomMention` varchar(250) NOT NULL,
  PRIMARY KEY (`idMention`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `Mention`
--

INSERT INTO `Mention` (`idMention`, `nomMention`) VALUES
(1, 'Droit'),
(2, 'Économie'),
(3, 'Histoire'),
(4, 'Sciences pour l''ingénieur');

-- --------------------------------------------------------

--
-- Structure de la table `Validation`
--

CREATE TABLE IF NOT EXISTS `Validation` (
  `idUtilisateur` int(11) NOT NULL,
  `IdComptence` int(11) NOT NULL,
  PRIMARY KEY (`IdComptence`,`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
