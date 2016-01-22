-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mer 20 Janvier 2016 à 16:55
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
-- Structure de la table `competence`
--

CREATE TABLE IF NOT EXISTS `competence` (
  `idCompetence` int(11) NOT NULL AUTO_INCREMENT,
  `nomCompetence` varchar(250) NOT NULL,
  `idPereCompetence` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCompetence`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Contenu de la table `competence`
--

INSERT INTO `competence` (`idCompetence`, `nomCompetence`, `idPereCompetence`) VALUES
(1, 'Situer son rôle et sa mission au sein d''une organisation pour s''adapter et prendre des initiatives', 28),
(2, 'Identifier le processus de production, de diffusion et de valorisation des savoirs', 28),
(3, 'Respecter les principes d’éthique, de déontologie et de responsabilité environnementale', 28),
(4, 'Travailler en équipe autant qu’en autonomie et responsabilité au service d’un projet', 28),
(5, 'Identifier et situer les champs professionnels potentiellement en relation avec les acquis de la mention ainsi que les parcours possibles pour y accéder', 28),
(6, 'Caractériser et valoriser son identité, ses compétences et son projet professionnel en fonction d’un contexte', 28),
(7, 'Se mettre en recul d’une situation, s’auto évaluer et se remettre en question pour apprendre', 28),
(8, 'Utiliser les outils numériques de référence et les règles de sécurité informatique pour acquérir, traiter, produire et diffuser de l’information ainsi que pour collaborer en interne et en externe', 29),
(9, 'Identifier et sélectionner diverses ressources spécialisées pour documenter un sujet', 29),
(10, 'Analyser et synthétiser des données en vue de leur exploitation', 29),
(11, 'Développer une argumentation avec esprit critique', 29),
(12, 'Se servir aisément des différents registres d’expression écrite et orale de la langue française', 29),
(13, 'Se servir aisément de la compréhension et de l’expression écrites et orales dans au moins une langue vivante étrangère', 29),
(14, 'Identifier le rôle et le champ d’application des sciences pour l’ingénieur dans tous les\r\nsecteurs : milieux naturels, milieux industriels, transports, environnements urbains, etc', 26),
(15, 'Valider un modèle par comparaison de ses prévisions aux résultats expérimentaux et apprécier ses limites de validité', 26),
(16, 'Identifier les principales familles de matériaux et leurs propriétés', 26),
(17, 'Mobiliser les outils mathématiques nécessaires à la modélisation', 26),
(18, 'Mobiliser des concepts en mathématiques, en physique, en chimie, en thermodynamique, afin d’aborder des problèmes spécifiques aux différents domaines industriels', 26),
(19, 'Estimer les ordres de grandeur et manipuler correctement les unités', 26),
(20, 'Intégrer une vision correcte de l’espace et de ses représentations', 26),
(21, 'Isoler un système', 26),
(22, 'Mettre en œuvre des techniques d’algorithmique et de programmation, notamment pour développer des applications simples d’acquisition et de traitements de données', 26),
(23, 'Droit', 27),
(24, 'Économie', 27),
(25, 'Histoire', 27),
(26, 'Sciences pour l''ingénieur\r\n', 27),
(27, 'Disciplinaires', NULL),
(28, 'Préprofessionnelles', NULL),
(29, 'Transversales et linguistiques', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(250) NOT NULL,
  `mdp` varchar(250) NOT NULL,
  PRIMARY KEY (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `validation`
--

CREATE TABLE IF NOT EXISTS `validation` (
  `idUtilisateur` int(11) NOT NULL,
  `IdComptence` int(11) NOT NULL,
  PRIMARY KEY (`IdComptence`,`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
