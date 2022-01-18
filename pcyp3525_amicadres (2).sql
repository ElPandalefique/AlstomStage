-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 18 jan. 2022 à 12:12
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `pcyp3525_amicadres`
--

-- --------------------------------------------------------

--
-- Structure de la table `activite`
--

DROP TABLE IF EXISTS `activite`;
CREATE TABLE IF NOT EXISTS `activite` (
  `ID_ACTIVITE` int(11) NOT NULL AUTO_INCREMENT,
  `ID_DOMAINE` int(11) NOT NULL,
  `ID_LEADER` int(11) DEFAULT NULL,
  `ID_PRESTATAIRE` int(11) DEFAULT NULL,
  `NOM` char(32) DEFAULT NULL,
  `DETAIL` varchar(255) DEFAULT NULL,
  `DATE_CREATION` date DEFAULT NULL,
  `ADRESSE` char(32) DEFAULT NULL,
  `CP` char(32) DEFAULT NULL,
  `VILLE` varchar(40) NOT NULL,
  `AGE_MINIMUM` int(11) DEFAULT '18',
  `FORFAIT` char(1) DEFAULT NULL,
  `TARIF_FORFAIT` float DEFAULT NULL,
  `TARIF_UNIT` float DEFAULT NULL,
  `OUVERT_EXT` tinyint(1) DEFAULT NULL,
  `PRIX_ADULTE` float DEFAULT NULL,
  `PRIX_ENFANT` float DEFAULT NULL,
  `PRIX_ADULTE_EXT` float DEFAULT NULL,
  `PRIX_ENFANT_EXT` float DEFAULT NULL,
  `COUT_ADULTE` float DEFAULT NULL,
  `COUT_ENFANT` float DEFAULT NULL,
  `STATUT` enum('A','V','O','F','T') NOT NULL DEFAULT 'A' COMMENT 'à définir',
  `INDICATION_PARTICIPANT` char(255) DEFAULT NULL,
  `INFO_IMPORTANT_PARTICIPANT` char(255) DEFAULT NULL,
  PRIMARY KEY (`ID_ACTIVITE`),
  KEY `ID_LEAD` (`ID_LEADER`),
  KEY `FK_ACTIVITE_DOMAINE_ACTIVITE` (`ID_DOMAINE`),
  KEY `ID_PRESTATAIRE` (`ID_PRESTATAIRE`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `activite`
--

INSERT INTO `activite` (`ID_ACTIVITE`, `ID_DOMAINE`, `ID_LEADER`, `ID_PRESTATAIRE`, `NOM`, `DETAIL`, `DATE_CREATION`, `ADRESSE`, `CP`, `VILLE`, `AGE_MINIMUM`, `FORFAIT`, `TARIF_FORFAIT`, `TARIF_UNIT`, `OUVERT_EXT`, `PRIX_ADULTE`, `PRIX_ENFANT`, `PRIX_ADULTE_EXT`, `PRIX_ENFANT_EXT`, `COUT_ADULTE`, `COUT_ENFANT`, `STATUT`, `INDICATION_PARTICIPANT`, `INFO_IMPORTANT_PARTICIPANT`) VALUES
(143, 1, 867, 15, 'karting', 'challenge karting', '2021-06-24', 'x', '17', 'le thou', 18, 'U', 0, NULL, 0, 15, 0, 0, 0, 15, 0, 'T', 'pour les fous du volant', ''),
(144, 1, 867, 16, 'Challenge Optimist Adultes', 'Activité très conviviale, totalement ouverte aux débutants. Seule contrainte: bonne humeur et savoir nager (un peu).', '2021-06-28', 'Chemin de la Platere,', '17690', 'Angoulins', 18, 'U', 0, NULL, 1, 7, 0, 12, 0, 10, 0, 'T', 'les gilets sont fournis, éventuellement les combinaisons si besoin', 'prenez un maillot de bain, des chaussures qui ne craignent pas l\'eau, des lunettes de soleil avec un cordon et de la bonne humeur'),
(145, 1, 801, 17, 'Pont transbordeur', 'Visite théatralisée du pont transbordeur', '2021-06-28', 'rue Jacques Demy', '17300', 'Rochefort', 0, 'U', 0, NULL, 0, 5, 5, 0, 0, 10, 6, 'T', 'Rdv à 17h50', ''),
(146, 1, 889, 18, 'Découverte du « Fumoir d’Angouli', 'Au milieu des bassins de claire, au cœur de la zone ostréicole d’Angoulins, venez découvrir et échanger sur l\'artisanat de fumage et nos métiers\r\nDémonstration participative du travail du poisson et des algues.\r\nAprès une présentation de cette méthode, un', '2021-07-14', 'Fumoir, en Face du 67 route de l', '17690', 'Angoulins-sur-Mer', 16, 'U', 0, NULL, 1, 11, 11, 24, 24, 24, 24, 'T', 'En cas de météo défavorable, l’événement sera repoussé au Vendredi 3 Septembre 2021.', 'Evènement en extérieur, prévoir de quoi se couvrir suivant la météo.'),
(147, 1, 844, 15, 'Vol en avion', '30 minutes de vol en avion de plaisance au dessus de la région rochelaise.', '2021-09-09', 'Aérodrome de Rochefort', '17620', 'La Sauzaie', 8, 'U', 0, NULL, 0, 25, 25, 0, 0, 50, 50, 'T', 'Port du masque obligatoire à bord des avions', ''),
(148, 1, 853, 21, 'Soirée Chauves-Souris', 'Venez découvrir les secrets des Chauves-souris !', '2021-09-10', 'Gymnase Alstom - Rue de la Paix', '17440', 'Aytre', 6, 'F', 300, NULL, 0, 10, 10, 0, 0, 0, 0, 'T', 'Rendez-vous à 19h!', ''),
(149, 1, 761, 20, 'Dégustation Epicurienne', 'Dégustation 5 vins et Diner du traiteur  La Petite Epicerie', '2021-09-14', 'Cave Vin Sur Table ZAC de la Val', '17140', 'LAGORD', 18, 'U', 550, NULL, 0, 25, 0, 0, 0, 55, 0, 'F', 'Cave Vin Sur Table en face de Leclerc', ''),
(150, 1, 849, 22, 'Atelier Makis-sushis', 'atelier fabrication et dégustation makis & sushi', '2021-09-17', '3 bis rue des cloutiers', '17000', 'La Rochelle', 18, 'F', 360, NULL, 0, 20, 0, 0, 0, 360, 0, 'T', 'Dégustation sur place ou emportez chez vous votre réalisation', 'Pass-sanitaire + masque - Matériels (tablier, etc) fournis'),
(151, 1, 761, 20, 'Diner Dégustation Pinot Noir', 'Pinot noir de Champagne, Alsace, Bourgogne ...', '2021-10-04', 'Cave Vin Sur Table ZAC de la Val', '17140', 'LAGORD', 18, 'U', 0, NULL, 0, 25, 0, 0, 0, 55, 0, 'T', '', ''),
(152, 1, 660, 25, 'Apéritif dinatoire', 'Cours de cuisine sur la préparation d\'un cocktail et des petits fours l\'accompagnant.\r\nDurée : 3h', '2021-10-11', '9 Rue Lavoirsier', '17440', 'Aytré', 18, 'U', 0, NULL, 0, 25, 25, 0, 0, 53, 53, 'T', 'Dans la zone commerciale d\'Aytré (proche de Castorama). SOYEZ PONCTUELS.', 'Numéro de téléphone de l\'atelier gourmand : 05 46 41 95 48 (mais apriori vous n\'avez aucune raison de les appeler)'),
(153, 1, 660, 25, 'Escape Cook', 'Escape game gourmand en duo adulte / enfant !\r\nDurée : 3h', '2021-10-11', '9 Rue Lavoirsier', '17440', 'Aytré', 6, 'U', 0, NULL, 0, 14, 14, 0, 0, 61, 0, 'T', 'Dans la zone commerciale d\'Aytré (proche de Castorama). SOYEZ PONCTUELS', 'Numéro de tel de l\'Atelier Gourmand : \r\n05 46 41 95 48 (même si a priori vous n\'avez pas à les appeler)'),
(154, 1, 883, 26, 'Couteaux FAROL', 'visite des ateliers avec les couteliers en action ', '2021-10-12', '1 rue de QUEBEC, LA PALLICE', '17000', 'LA ROCHELLE', 18, 'U', 0, NULL, 0, 24, 0, 0, 0, 53, 0, 'T', 'Arrivée à 17H30  précises', ''),
(155, 1, 844, 27, 'Escape-game', 'Une équipe débutante et une équipe confirmée.', '2021-10-12', '114 rue des gonthières', '17000', 'La Rochelle', 16, 'F', 300, NULL, 0, 12, 12, 0, 0, 0, 0, 'T', 'Arrivée à 18h15 pour briefing puis début du jeu à 18h30 pour 1h d\'enquête.', ''),
(156, 1, 844, 28, 'Découverte des champignons', 'Découverte ludique des champignons comestibles et non comestibles. Puis mise en bouche à base de champignons préparés à l\'avance et verre de l\'amitié.', '2021-10-21', 'Forêt de Benon', '17170', 'Benon', 5, 'U', 0, NULL, 0, 5, 5, 0, 0, 5, 5, 'T', 'Prendre des chaussures de marche ou baskets, un imperméable si temps humide. Les enfants sont les bienvenus dès 6ans, pour que l\'expérience soit sympathique pour eux .', 'Lieu sera précisé une fois un repérage fait à quelques jours de la découverte'),
(157, 1, 761, 20, 'Découverte Champagnes', 'Dégustation de Champagnes 3*    et Diner', '2021-10-25', 'Avenue du Fief Rose', '17140', 'LAGORD', 18, 'U', 0, NULL, 0, 32, 0, 0, 0, 70, 0, 'T', 'champagnes dits « haut de gamme » découvrir ce qu’est un blanc de blanc, un blanc de noirs, une cuvée millésimé', 'Pass sanitaire obligatoire'),
(158, 1, 660, 25, 'Accords mets et vins', 'Cours de cuisine (2h) + dégustation de la préparation accompagnée de vins accordés sur place', '2021-11-15', '9 Rue Lavoirsier', '17440', 'Aytré', 18, 'U', 0, NULL, 0, 30, 30, 0, 0, 64, 64, 'T', 'Menu :\r\nPotimarron velouté au parfum de muscade, crémeux au foie gras et éclats de châtaignes\r\nJoues de porc confites au vin moelleux\r\nCafé liégeois gourmand\r\n\r\nDans la zone commerciale d\'Aytré (derrière Castorama).', 'SOYEZ PONCTUELS par respect pour les autres et l\'\'animateur !'),
(159, 1, 788, 29, 'Fabrication savon', 'qu\'est ce que c\'est la saponification à froid ? Puis fabrication de son propre savon, a ramener à la maison ! ', '2021-12-07', 'Auberge de jeunesse - avenue des', '17000', 'La Rochelle', 10, 'U', 220, NULL, 0, 15, 15, 0, 0, 30, 30, 'O', 'vous pouvez ramener un tablier, les gants de protection seront fournis. Ramenez un contenant qui ne se renversera pas pour y couler votre savon (exemple brique de lait, ou boite de pringles!)', ''),
(160, 1, 931, 16, 'UwU', 'UwU', '2022-01-04', 'UwU', '17300', 'UwU', 15, 'U', 0, NULL, 1, 15, 13, 18, 15, 15, 13, 'T', 'UwU', 'UwU'),
(161, 1, 931, 19, 'qsd', 'qsd', '2022-01-05', 'qsd', '15020', 'qsd', 18, 'U', 0, NULL, 1, 51, 0, 51, 0, 51, 0, 'O', '', ''),
(162, 1, 931, 15, 'reazr', 'azer', '2022-01-10', 'azer', 'azer', 'azer', 0, 'U', 0, NULL, 1, 12, 15, 12, 15, 12, 15, 'O', 'azer', 'azer'),
(163, 1, 931, 15, 'test', '', '2022-01-10', 'test', 'test', 'test', 0, 'U', 0, NULL, 1, 14, 16, 14, 16, 14, 16, 'O', '', ''),
(164, 1, 931, 15, 'zytr', '', '2022-01-13', 'ghkl', 'DFQ', 'sqdf', 15, 'U', 0, NULL, 1, NULL, NULL, NULL, NULL, 15, 15, 'A', '', ''),
(165, 1, 931, 15, 'zytr', '', '2022-01-13', 'ghkl', 'DFQ', 'sqdf', 15, 'U', 0, NULL, 1, NULL, NULL, NULL, NULL, 15, 15, 'A', '', ''),
(166, 1, 931, 15, 'zytr', '', '2022-01-13', 'ghkl', 'DFQ', 'sqdf', 15, 'U', 0, NULL, 1, NULL, NULL, NULL, NULL, 15, 15, 'A', '', ''),
(167, 1, 931, 15, 'fgh', '', '2022-01-14', 'fgh', 'fgh', 'fgh', 2, 'U', 0, NULL, 1, NULL, NULL, NULL, NULL, 15, 15, 'A', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

DROP TABLE IF EXISTS `adherent`;
CREATE TABLE IF NOT EXISTS `adherent` (
  `ID_ADHERENT` int(11) NOT NULL AUTO_INCREMENT,
  `MAIL` varchar(255) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `GRADE` enum('A','L','M') NOT NULL DEFAULT 'M',
  `NOM` char(32) DEFAULT NULL,
  `PRENOM` char(32) DEFAULT NULL,
  `GENRE` char(1) DEFAULT NULL,
  `MATRICULE` char(32) DEFAULT NULL,
  `TELEPHONE` char(20) DEFAULT NULL,
  `MEMBRE_ACTIF` tinyint(1) DEFAULT NULL,
  `DATE_ADHESION` date DEFAULT NULL,
  `DATE_DEPART` date DEFAULT NULL,
  PRIMARY KEY (`ID_ADHERENT`),
  UNIQUE KEY `PSEUDO` (`MAIL`),
  KEY `ID_ADH` (`ID_ADHERENT`)
) ENGINE=InnoDB AUTO_INCREMENT=936 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `adherent`
--

INSERT INTO `adherent` (`ID_ADHERENT`, `MAIL`, `PASSWORD`, `GRADE`, `NOM`, `PRENOM`, `GENRE`, `MATRICULE`, `TELEPHONE`, `MEMBRE_ACTIF`, `DATE_ADHESION`, `DATE_DEPART`) VALUES
(27, 'maxime.condaminat@gmail.com', '$2y$10$yWLoQzWjDlqXES8pRQ4Ape.kS3lLO7xrlN10AOzfOdHCBNZ4HojOq', 'A', 'Condaminat', 'Maxime', 'H', '', '', 1, '2021-06-01', NULL),
(28, 'jeremy.pionsfr@gmail.com', '$2y$10$Sr2dpSRLy2ioMPJayoej4OqdyM5qqESztrMHKrMqOMX17e4YLklyy', 'A', 'Pion', 'Jérémy', 'H', '', ':0637463957', 1, '2021-06-01', NULL),
(49, 'jean-christophe.castillo@laposte.net', '$2y$10$hb3dq6/Zi9GnDFu/fY2I4eXR2XgDd7eErU8AVGASdHdeHTD4Xx3My', 'A', 'Jean-christophe', 'Castillo', 'H', '', '', 1, '2021-06-09', NULL),
(658, 'alexandre.adam@alstomgroup.com', '$2y$10$phupmx3L.sJKPF/cD.QZa.cse5l0i269bkFgybpUKzn.lZVDiwwLm', 'M', 'ADAM', 'Alexandre', 'H', '154880', '', 1, '2019-05-24', NULL),
(659, 'pascal.albertus@alstomgroup.com', '$2y$10$uAafguAF43m0vNCAgQx27eR8k9tDP/nQp08dqJy/r7TIVbpsIgGXy', 'M', 'ALBERTUS', 'Pascal', 'H', '136766', '', 1, '0000-00-00', NULL),
(660, 'adrien.albon@alstomgroup.com', '$2y$10$Kn4FubwdA8MXOI8I3tVFHuHuSWOSppQYc3JUoZw12pGwb2mJ/HrNG', 'A', 'ALBON', 'Adrien', 'H', '160272', '', 1, '0000-00-00', NULL),
(661, 'francois.allain@alstomgroup.com', '$2y$10$mx6F3fFbKfbvPhF4z2KrbOyfxbJeV7zjgRTovVpAzQA2aPwjF6./O', 'L', 'ALLAIN', 'Francois', 'H', '10373', '', 1, '0000-00-00', NULL),
(662, 'valerie.andrault@alstomgroup.com', '$2y$10$2odRQ5QAPymv1.0w.v1E3e0qpWjwqbSDhlFhYmim5MezwJHC5hF2u', 'M', 'ANDRAULT', 'Valerie', 'F', '10381', '', 1, '0000-00-00', NULL),
(663, 'david.aubertin@alstomgroup.com', '$2y$10$EZH.TdOf/3750lS5WsSV2OA4QQlArjD2z65PpEnndRCqJ547D.yYu', 'L', 'AUBERTIN', 'David', 'H', '10398', '', 1, '0000-00-00', NULL),
(664, 'patrick.bachoffer@alstomgroup.com', '$2y$10$bZqzQWJRGB2A1NX3S5HJUO4lqRjQHjh9Yd3P9ce4XbrUoFZDJwHG6', 'M', 'BACHOFFER', 'Patrick', 'H', '176917', '', 1, '0000-00-00', NULL),
(665, 'bertrand.baillou@alstomgroup.com', '$2y$10$tsSxanqZwoYdF8gC.u52/O3poNbpngvjE/o8L2y738CunF9fd4Smi', 'M', 'BAILLOU', 'Bertrand', 'H', '305033', '', 1, '2018-06-11', NULL),
(666, 'ludovic.balanche@alstomgroup.com', '$2y$10$8R9r18plKOzWn5VLyGeO/u9yD0tfzKI707d8a0wJ1UcD1CYeCKSfq', 'M', 'BALANCHE', 'Ludovic', 'H', '12125', '', 1, '2013-06-25', NULL),
(667, 'eric.ballot@alstomgroup.com', '$2y$10$kufIQWnFDa6ok4DHlui/9.jW40.594e0jFnzFC4ssHN8vj1969E2e', 'M', 'BALLOT', 'Eric', 'H', '10424', '', 1, '0000-00-00', NULL),
(668, 'cyril.barascud@alstomgroup.com', '$2y$10$AkfSXj43IxAq3hj9usYrOOjWvNXb99DXGqM6epTzHSrEQMk0Z8AOm', 'M', 'BARASCUD', 'Cyril', 'H', '170565', '', 1, '0000-00-00', NULL),
(669, 'philippe.baudonnel@alstomgroup.com', '$2y$10$WF59VA1BS.pB1kMwAs25yetRsenl0U.hT4ktw58UsztT7TLY/Oh6i', 'M', 'BAUDONNEL', 'Philippe', 'H', '262372', '', 1, '2014-07-07', NULL),
(670, 'helene.beauchene@alstomgroup.com', '', 'M', 'BEAUCHENE', 'Hélène', 'F', '10451', ':', 1, '2014-09-08', NULL),
(671, 'christophe.beauseigneur@alstomgroup.com', '$2y$10$GJyE.o6Q78d40O4i.E5J7eJZ9zinCfslL/vEteEBa93NFBl180USi', 'M', 'BEAUSEIGNEUR', 'Christophe', 'H', '156885', '', 1, '0000-00-00', NULL),
(672, 'olivier.beausse@alstomgroup.com', '$2y$10$V/BUec4ZkO/eSf11Thy9KuM2L2prqd5h0a.WNOtNacfu.KB0QyqSC', 'M', 'BEAUSSE', 'Olivier', 'H', '257338', ':0631681365', 1, '0000-00-00', NULL),
(673, 'aurelie.belkacem@alstomgroup.com', '$2y$10$EM5NlI3HpS1XX3H.useBzewUKohLVPMgBsCvCs2aFawAg79QS5w4i', 'M', 'BELKACEM', 'Aurélie', 'F', '11645', ':0660394274', 1, '2019-05-27', NULL),
(674, 'mickael.bellivier@alstomgroup.com', '$2y$10$54BxFxX74YOk/3/5NuGwkO5MeUb17fhhRxMBN2ZJwT9.WkR0ORMny', 'M', 'BELLIVIER', 'Mickael', 'H', '10458', '', 1, '0000-00-00', NULL),
(675, 'fouad.ben-belgacem@alstomgroup.com', '$2y$10$Vepff897HH5dnYD4aduupeZfFf3AqmbHUgqJxFzvINIiSVL54ksXC', 'M', 'BEN-BELGACEM', 'Fouad', 'H', '171463', '', 1, '0000-00-00', NULL),
(676, 'charles-henri.benet@alstomgroup.com', '$2y$10$DneKyqjnZly9k48KepIYYeIA6go8tcrQdM37ogxUVL3rK27jwBKH2', 'M', 'BENET', 'Charles henri', 'H', '181994', '', 1, '0000-00-00', NULL),
(677, 'fabrice.benizeau@alstomgroup.com', '$2y$10$KmKW5po5fxpTBhsjP5YmKe23eYDSvn05Zl7cnFsmDDl5Tlpz/xxPy', 'M', 'BENIZEAU', 'Fabrice', 'H', '142819', '', 1, '0000-00-00', NULL),
(678, 'jean-alexis.benoit@alstomgroup.com', '$2y$10$c.iPUwVkCaoFSeWLYEOoP.egmLNhdkLN5vPsAD7lYTPxevLT7Jtiq', 'M', 'BENOIT', 'Jean-Alexis', 'H', '186802', '', 1, '2017-05-30', NULL),
(679, 'marine.bequin@alstomgroup.com', '$2y$10$Ub5lsWClw5mEHeaWF/AHDOimlRCljTQSNI4EUGzpw5A1qxMcUGOcu', 'M', 'BEQUIN', 'Marine', 'F', '307359', '', 1, '2019-06-10', NULL),
(680, 'damien.berna@alstomgroup.com', '$2y$10$Lb28nT3jRhRw0bbAczLiQ.HCQCqeh5t1yFHBRJhoQRY5sdMkwSuAy', 'M', 'BERNA', 'Damien', 'H', '189796', '', 1, '2013-08-28', NULL),
(681, 'alexandre.bernard@alstomgroup.com', '$2y$10$4KVIL3mmDwB.2UlPiSOTxef8DXwrSq6Qs.89nb2yGgrgyqHfJSshK', 'M', 'BERNARD', 'Alexandre', 'H', '160945', '', 1, '0000-00-00', NULL),
(682, 'eric-g.bernard@alstomgroup.com', '$2y$10$bi11Blm9p9G6ZGMav1zoBeBMmnecfch.GMn8lWE39wJ/e.XC9vBpC', 'M', 'BERNARD', 'Eric', 'H', '155208', '', 1, '0000-00-00', NULL),
(683, 'thierry.bernard@alstomgroup.com', '$2y$10$gCxD8m2cO0e0t1rP4hlsUOz7/jfZCNLlw.Lo6tAzi2wDBhsD88DuW', 'M', 'BERNARD', 'Thierry', 'H', '115208', '', 1, '0000-00-00', NULL),
(684, 'nicolas.bezagu@alstomgroup.com', '$2y$10$e3NA90M.IJgoB4.kkClivexZAHEf5Q3lsQeoaZdMzJuX53qYwM9FS', 'M', 'BEZAGU', 'Nicolas', 'H', '10487', '', 1, '0000-00-00', NULL),
(685, 'florence.bidault@alstomgroup.com', '$2y$10$ei8vwJuePVaXHENlG04C4exdNzeJo47Q.ZB1bbUs0aok7IGtd2oty', 'M', 'BIDAULT', 'Florence', 'F', '170099', '', 1, '0000-00-00', NULL),
(686, 'jacques.bihanpoudec@alstomgroup.com', '$2y$10$uHTTCsi10EkLhCZgImq.vuD.7reiVGEKk8SKmTa0S3CPVVFFnjWMu', 'M', 'BIHAN-POUDEC', 'Jacques', 'H', '10492', '', 1, '0000-00-00', NULL),
(687, 'stephane.bobineau@alstomgroup.com', '$2y$10$mFT0e7wFvpdIESmU/NHzEuF2VS5nZYcjJgfNiOnq1HdVuiimMxRAq', 'M', 'BOBINEAU', 'Stéphane', 'H', '202222', ':0664452414', 1, '0000-00-00', NULL),
(688, 'christophe.bodescot@alstomgroup.com', '$2y$10$QW5su2rEfnDUGtp1HLTniuIeIiwI00p5PKe0R0DXXcEKWvejWPQOK', 'M', 'BODESCOT', 'Christophe', 'H', '10513', '', 1, '2019-02-12', NULL),
(689, 'christian.boneill@alstomgroup.com', '$2y$10$tEWpNMaUrXmkfYp8trUk8.2tc9e.7vUZqEjeRQExuwMhMDzQE.QKy', 'L', 'BONEILL', 'Christian', 'H', '26416', '', 1, '0000-00-00', NULL),
(690, 'christophe.bouchoule@alstomgroup.com', '$2y$10$2Fi7wnaiGQX3v7omZsC.qemxJN4/VDP3dDRL89ADAVvgipKVRtmVW', 'M', 'BOUCHOULE', 'Christophe', 'H', '23132', '', 1, '0000-00-00', NULL),
(691, 'marouane.boudjema@alstomgroup.com', '$2y$10$bHf1ZP1mE6JEOl3da1JFiOOpKj48lAP5m9deTl5dIYVdoAwe3.MJG', 'M', 'BOUDJEMA', 'Marouane', 'H', '437292', '', 1, '2021-03-24', NULL),
(692, 'pascal.bourgoin@alstomgroup.com', '', 'M', 'BOURGOIN', 'Pascal', 'H', '10554', ':', 1, '0000-00-00', NULL),
(693, 'christelle.bourhis@alstomgroup.com', '$2y$10$Buadvi0Np0glaXCVdXGHnu84CGJMezFn8j62Xve5krszATVAUdFRS', 'L', 'BOURHIS', 'Christelle', 'F', '10556', '', 1, '0000-00-00', NULL),
(694, 'thomas.bradu@alstomgroup.com', '$2y$10$N2Ml0elA81UOIXJEgigSwehjaPURrOcp/N2f1hDOnA6F182EP00e6', 'M', 'BRADU', 'Thomas', 'H', '177468', '', 1, '0000-00-00', NULL),
(695, 'matthias.brand@alstomgroup.com', '$2y$10$FxXp3DnjJx1IPAhWQP1/.eBkGVCoCo8L/zFc7QRFMn7ITs01M0Ix6', 'M', 'BRAND', 'Matthias', 'H', '10568', ':+33607473085', 1, '0000-00-00', NULL),
(696, 'jean-michel.breneol@alstomgroup.com', '$2y$10$pi5vnU46ugRbFbNOeOlRMuf1L2ay0ma0BAvZWx45keteHjQZlRAHu', 'L', 'BRENEOL', 'Jean-Michel', 'H', '134155', ':0608877099', 1, '0000-00-00', NULL),
(697, 'herve.brescia@alstomgroup.com', '$2y$10$SZ/CvwcTy0rhg1oxyk7sbOxSNTsgB3SbZrmVFe4u9Ek1OouvcZRyy', 'M', 'BRESCIA', 'Herve', 'H', '10574', '', 1, '0000-00-00', NULL),
(698, 'florent.brisou@alstomgroup.com', '$2y$10$LHfJLK5LwaPkYHC5rzeIO.MHuxN5P2l37/.MdrlH8UwSLNSawWQz6', 'L', 'BRISOU', 'Florent', 'H', '10584', ':0674895077', 1, '0000-00-00', NULL),
(699, 'dorota.brossard@alstomgroup.com', '$2y$10$zh2FLfAwTeTA50hnGYMAV.mI1SCrdV7SV0Hc9kqTiX/qbbcuoYmwy', 'M', 'BROSSARD', 'Dorota', 'F', '10586', '', 1, '2019-02-12', NULL),
(700, 'guillaume.buffeteau@alstomgroup.com', '$2y$10$oy9oodYLXDOYhuEYfhifrOysF4khYlEIhQhAc59mJgx4Pb4VKmQv2', 'M', 'BUFFETEAU', 'Guillaume', 'H', '254448', '', 1, '0000-00-00', NULL),
(701, 'gregory.burte@alstomgroup.com', '', 'M', 'BURTE', 'Grégory', 'H', '433206', ':', 0, '2020-10-15', NULL),
(702, 'eric.cachenaud@alstomgroup.com', '$2y$10$Ykc9cGy3PWL2fsF4PodPweqyG4UvBMkaa.ekqUwhGSZUG68bMGuvq', 'M', 'CACHENAUD', 'Eric', 'H', '112423', ':+33687763503', 1, '0000-00-00', NULL),
(703, 'bertrand.caillaud@alstomgroup.com', '', 'M', 'CAILLAUD', 'Bertrand', 'H', '20040', ':', 0, '0000-00-00', NULL),
(704, 'jean-bernard.camps@alstomgroup.com', '$2y$10$JrWyWsc/vMKSrruCGo9WNepexYKCUV87y1LV/MxZaP6MRP.TP3dG6', 'L', 'CAMPS', 'Jean-Bernard', 'H', '144148', ':+33763329872', 1, '2013-07-24', NULL),
(705, 'emmanuelle.cannella@alstomgroup.com', '$2y$10$xvqojTbZOo5QZxss7cfzAeOaC5Miby.Sl7sARg3x/92hUoqnahXmS', 'M', 'CANNELLA', 'Emmanuelle', 'F', '203526', '', 1, '0000-00-00', NULL),
(706, 'christian.cassard@alstomgroup.com', '$2y$10$PpiDuQT4KEI9BHTtDH2./up59xnF7LW2N8JhJFqyQc19UdhgKiGu.', 'M', 'CASSARD', 'Christian', 'H', '10617', '', 1, '2015-01-27', NULL),
(707, 'helene.castola@alstomgroup.com', '$2y$10$eMMtshMmGeMHJ5VpiLedG.uS6wbidV/8nuUSKvuTJcGV0V6VR4Eu6', 'M', 'CASTOLA', 'Helene', 'F', '10618', '', 1, '0000-00-00', NULL),
(708, 'remy.cazaux@alstomgroup.com', '$2y$10$bUF9KvtVXYQi6slJojEF4uF6UnAi2iyo0dUEXc2gATn/CNYN49aJq', 'M', 'CAZAUX', 'Remy', 'H', '10621', '', 1, '0000-00-00', NULL),
(709, 'anne.chanh@alstomgroup.com', '$2y$10$UZ.Up5ywmqvcHZZW2yBwaut3Pc.SgZQGI135HjPl3/zgWxUIVP716', 'M', 'CHANH-LEGRAND', 'Anne', 'F', '188367', '', 1, '0000-00-00', NULL),
(710, 'bruno.chatellier@alstomgroup.com', '$2y$10$hQ7cgbXzguxBILCrmFzR3eJvK84r79TMr9Pg4mzvbBAyY.QCSYqfK', 'M', 'CHATELLIER', 'Bruno', 'H', '10646', '', 1, '0000-00-00', NULL),
(711, 'eric.combeau@alstomgroup.com', '$2y$10$lHXmFa7BgX2AYSpf9q66oe/aj51JoJNs8vX4sIGjLlFkxgtwlFZim', 'M', 'COMBEAU', 'Eric', 'H', '10685', '', 1, '0000-00-00', NULL),
(712, 'pascal.coqueron@alstomgroup.com', '$2y$10$5hYzRdF6XROhxjrgpQepseXhP2GcYs58R/rEEgqt.3ZMbHxeUwoRS', 'M', 'COQUERON', 'Pascal', 'H', '10687', '', 1, '0000-00-00', NULL),
(713, 'regis.cornette@alstomgroup.com', '$2y$10$CnHFWAiaQUpKbIDdoW4FjeNEyYX0/.GQPHfIn1iVWmiYdCVArP9kW', 'L', 'CORNETTE', 'Regis', 'H', '10692', '', 1, '0000-00-00', NULL),
(714, 'briac.correc@alstomgroup.com', '$2y$10$RHI2O0rtOEV8ULdGRvveku5Qhsz.1qWnosbfS8Q1RqC2CwPNNBPQa', 'M', 'CORREC', 'Briac', 'H', '136670', ':0620057874', 1, '0000-00-00', NULL),
(715, 'jean-noel.couturier@alstomgroup.com', '$2y$10$k8dA.EKmM5qbdb0M8Jm0tuv9FsThQx3fwA82wnFtPlm2Q5DDU3BAq', 'M', 'COUTURIER', 'Jean-noel', 'H', '10714', '', 1, '0000-00-00', NULL),
(716, 'matthieu.couty@alstomgroup.com', '$2y$10$ykZCoZKyN60LEoa7smieyeqBk7FPx2eOy4mrs3CtbqnTnJKuDKUGi', 'L', 'COUTY', 'Matthieu', 'H', '189261', ':', 1, '2017-10-11', NULL),
(717, 'charles.cresp@alstomgroup.com', '$2y$10$xCF/yGzkj59SE5ph9Jrpie59xzFD7jBNPZQEfB3RDxLWM5uKjzLpu', 'M', 'CRESP', 'Charles', 'H', '149261', '', 1, '0000-00-00', NULL),
(718, 'sebastien.crespel@alstomgroup.com', '$2y$10$n5arDdVBR8Orael8AmFQB.zKiVGnlTQZEppSR3wsDsg0saJpRZLuO', 'M', 'CRESPEL', 'Sebastien', 'H', '5146', ':06.20.30.12.66', 1, '0000-00-00', NULL),
(719, 'stephane.crespin@alstomgroup.com', '$2y$10$TKypUUWYfD14LqD8eJNe2e60BDhW6BFQYv.8y5l4ZPqWJCs5DQ6OC', 'M', 'CRESPIN', 'Stephane', 'H', '10717', '', 1, '0000-00-00', NULL),
(720, 'nathalie.cuny@alstomgroup.com', '$2y$10$9HkrX.Piru6I2AsKEHnAe.D.4qMPAnJveSF2C5MwgDTl8mK1.CYzm', 'M', 'CUNY', 'Nathalie', 'F', '10719', '', 1, '0000-00-00', NULL),
(721, 'julien.delorme@alstomgroup.com', '$2y$10$yqerWmui85D6ghmizIcTVujisRBcG9Eix/YXKf5wAZ.a2.mqnLL/O', 'M', 'DELORME', 'Julien', 'H', '186058', '', 1, '0000-00-00', NULL),
(722, 'alain.delpierre@alstomgroup.com', '$2y$10$MP7ykvoTmcYfcOt1rLX5h.ZesfwjBGnho3yszLMCO.EP3.k4IvTOi', 'M', 'DELPIERRE', 'Alain', 'H', '200918', '', 1, '2013-08-23', NULL),
(723, 'francis.demarquilly@alstomgroup.com', '$2y$10$7zQlvQ9TsBpYPCugeqvLS.FTQTVg9fuNcSAonyKAZA/6OkwGGk8eK', 'M', 'DEMARQUILLY', 'Francis', 'H', '10744', '', 1, '0000-00-00', NULL),
(724, 'vincent.de-pierrepont@alstomgroup.com', '$2y$10$6ahHfacxA4D9Z118MUMwOuCYcRWEbP6.VBSG/5Oi43NK75xMOuHsW', 'M', 'DE-PIERREPONT', 'Vincent', 'H', '10751', '', 1, '0000-00-00', NULL),
(725, 'olivier-d.deshayes@alstomgroup.com', '$2y$10$6.EcEOQEgkzRDBQpIU7xp.McpmQuf/kuvEWmX7WGuzDrnK0EOnvLK', 'M', 'DESHAYES', 'Olivier', 'H', '199062', ':0607987155', 1, '0000-00-00', NULL),
(726, 'enguerrand.d-espalungue@alstomgroup.com', '$2y$10$jeIwCvs2fdcUbJyfa2.lnu2SHU3tw/KqxZdkeaQ/qhNltFiURJEDa', 'M', 'D-ESPALUNGUE', 'Enguerrand', 'H', '30139', '', 1, '2020-01-07', NULL),
(727, 'antonio.dias@alstomgroup.com', '$2y$10$Qq523L8hbtBmXIxdj8qLNOCtCYQZXDIs.SC2TJrXZ8buWBPlNhxie', 'M', 'DIAS-PEREIRA', 'Antonio', 'H', '246587', '', 1, '2020-11-04', NULL),
(728, 'huu-thi.do@alstomgroup.com', '$2y$10$mxT.Ky4ApAKyMRbdvNrX0u5JgBG9TjP65oNTRv6MjROYWeCMVcpxS', 'M', 'DO', 'Huu-thi', 'H', '150223', '', 1, '0000-00-00', NULL),
(729, 'patrick.duban@alstomgroup.com', '$2y$10$LUtwEGgObzAMm4b3npff..ISALl6vc8SQK29WKM8m3Mw28t4mZdoq', 'L', 'DUBAN', 'Patrick', 'H', '157156', '', 1, '2014-07-09', NULL),
(730, 'sarra.el-atmani@alstomgroup.com', '$2y$10$YKw59qerUNBOoRwPHepc6.TD8rRQKsf.N4HMUadTeeAHjTY4SFQQi', 'M', 'EL ATMANI', 'Sarra', 'F', '305450', '', 1, '2018-01-29', NULL),
(731, 'mickael.elie@alstomgroup.com', '$2y$10$F6WPVTwhw5BB/Uiu5qWye.SlNZAwC/n0phU2DQHbm.V8f8Exohe3i', 'M', 'ELIE', 'Mickael', 'H', '157705', ':0682413429', 1, '0000-00-00', NULL),
(732, 'eric.esteve@alstomgroup.com', '$2y$10$pk7SHs0x7lzim51Io8eIK.116AjFu/w2ugWxFeJ3o2ZkeezNFrg2i', 'M', 'ESTEVE', 'Eric', 'H', '10808', ':0608741809', 1, '0000-00-00', NULL),
(733, 'patrick.evennou@alstomgroup.com', '$2y$10$4bAHwR/01N6lVRfMOzy9MeN/4SMjE6FfYPMOkWSSTkse.pOptnHeG', 'M', 'EVENNOU', 'Patrick', 'H', '10814', '', 1, '0000-00-00', NULL),
(734, 'jean-marc.fabre@alstomgroup.com', '$2y$10$7ApaEwnE20wjuzmYPTMn.ukappzeGTOqnGU6FVfS.d3Q3jnopP3iu', 'M', 'FABRE', 'Jean-marc', 'H', '10815', '', 1, '0000-00-00', NULL),
(735, 'nicolas.falguieres@alstomgroup.com', '$2y$10$tBXvvtURt.13IqX5fbsuW.2Tm5jxCMFEt3pFZrL8HOHpq6p63f546', 'M', 'FALGUIERES', 'Nicolas', 'H', '136805', '', 1, '0000-00-00', NULL),
(736, 'franck.fantaccino@alstomgroup.com', '$2y$10$Zt6LXmlYVkt.r46LWgUn6.9tHgm3pRx9qlApWX7CyM7L46KMeXEZ2', 'M', 'FANTACCINO', 'Franck', 'H', '307121', '', 1, '2019-05-23', NULL),
(737, 'emmanuel.faucon@alstomgroup.com', '$2y$10$ex7znTqarnO3bRmjvc8jSOHVsTWKJmBBJPa7xdjzJrijjNzx0IGK2', 'M', 'FAUCON', 'Emmanuel', 'H', '187395', '', 1, '2019-05-27', NULL),
(738, 'francois.favard@alstomgroup.com', '$2y$10$KjaW9UG3SjhsMfBdCIcNWuancZB.u4P15xgaktjIVTnVJrx8YkddK', 'M', 'FAVARD', 'Francois', 'H', '10824', '', 1, '0000-00-00', NULL),
(739, 'manuel.fleury@alstomgroup.com', '$2y$10$U.eVzSQ7tD///L7VAojGNOvpJ3XEgoOeYIcwJZKvM9OCUKalYWEAe', 'M', 'FLEURY', 'Manuel', 'H', '10845', '', 1, '0000-00-00', NULL),
(740, 'david.fourneau@alstomgroup.com', '$2y$10$7tagw1B247Pj8yX6ijgFAeVOSsk3g7cBEQs01wJdmhDQVOkUiKCZq', 'M', 'FOURNEAU', 'David', 'H', '174836', '', 1, '2014-05-20', NULL),
(741, 'tanja.bruneteau-fritschi@alstomgroup.com', '$2y$10$bRQIWOGuGige.OaG9L0BO.nwp0oqr8wKz13ut4IS/uH7RgNEk8JZu', 'M', 'FRITSCHI', 'Tanja', 'F', '10591', '', 1, '0000-00-00', NULL),
(742, 'denis.fusil@alstomgroup.com', '$2y$10$UA.KoQXlhUwHLHIuRIZSZOFNgn0XINHq7z6BJIZ2uA2QjKyYlcCJm', 'M', 'FUSIL', 'Denis', 'H', '10870', '', 1, '0000-00-00', NULL),
(743, 'stephane.gabucci@alstomgroup.com', '$2y$10$VgGQp4mr3tBp5dBvuh416.FC7OkeCx2/tWaMuX9PB73BnazqIv2EC', 'M', 'GABUCCI', 'Stéphane', 'H', '177892', '', 1, '2014-05-04', NULL),
(744, 'vincent.gardais@alstomgroup.com', '$2y$10$tHAIyEWzcnktd6hAO0Giw.OybiGskvOzTYsFrPqIgtQGiRCnlkDw2', 'M', 'GARDAIS', 'Vincent', 'H', '307324', '', 1, '2019-09-05', NULL),
(745, 'frederic.gauthier@alstomgroup.com', '$2y$10$eSC.Dh7.DRkUvT1pQtcSfege.u/yeYggX9Uls/9vjXroMKR2RW8ze', 'M', 'GAUTHIER', 'Frédéric', 'H', '10888', '', 1, '0000-00-00', NULL),
(746, 'marc.gendret@alstomgroup.com', '$2y$10$/ICe8KTIz1WGyqCdXzzgHuDYFc7YgnMfFsHOcWH0pczpZV/c7xJae', 'M', 'GENDRET', 'Marc', 'H', '10902', '', 1, '0000-00-00', NULL),
(747, 'guillaume.gerber@alstomgroup.com', '$2y$10$hRFhclKNWSOkW6xNjvbLW.W.u44Zch44TkzjN46jwaMhKfrIMZVRS', 'L', 'GERBER', 'Guillaume', 'H', '185788', ':0608730284', 1, '0000-00-00', NULL),
(748, 'antoine-tls.germain@alstomgroup.com', '$2y$10$wKsuD5/1qkpQwtnHDcnB6eC3Vf7AwddeYOApLwYA703wohrZUFkv6', 'M', 'GERMAIN', 'Antoine', 'H', '148377', '', 1, '0000-00-00', NULL),
(749, 'simon.giros@alstomgroup.com', '$2y$10$sUsJ4QXSJrKQ/skjEJBoEubVik8vvEmH8RmSW7QnHnPDTCU16A7xq', 'M', 'GIROS', 'Simon', 'H', '306020', '', 1, '0000-00-00', NULL),
(750, 'antoine.glumineau@alstomgroup.com', '', 'M', 'GLUMINEAU', 'Antoine', 'H', '261546', ':', 1, '2014-05-26', NULL),
(751, 'valerie.gonzalez@alstomgroup.com', '$2y$10$hdg0BPCUSQu4ZUn8DmhhEuHjbA9wa0lmpeMp/HHCS9Mamr0rrpvk6', 'M', 'GONZALEZ', 'Valérie', 'F', '10935', '', 1, '2019-12-02', NULL),
(752, 'alain.grandjean@alstomgroup.com', '$2y$10$0iAU78zWP/Hq4h1SkISAcufQHeXEWyjcBTKvLB8Uf2pe54zKp6QeG', 'M', 'GRANDJEAN', 'Alain', 'H', '10943', '', 1, '0000-00-00', NULL),
(753, 'isabelle.gregam@alstomgroup.com', '$2y$10$IkMMos04f5bnyq5tMXeGO.5CQI9s9jXg2w9kdpbt92YdQFPEhD0L.', 'M', 'GREGAM', 'Isabelle', 'F', '10947', '', 1, '0000-00-00', NULL),
(754, 'david.grenouillet@alstomgroup.com', '$2y$10$pH8bolEuoRBYPy2hWxRE5.2YELEN3Y4xtuEmYhZRNAKA3OgjHu3bW', 'M', 'GRENOUILLET', 'David', 'H', '135552', '', 1, '0000-00-00', NULL),
(755, 'thibault.gruson@alstomgroup.com', '$2y$10$aSL5KLSXbkml7nUYPrxWEuL0GLRr06Tv/j8UjeMz6LTPp2sDg7gry', 'M', 'GRUSON', 'Thibault', 'H', '471653', '', 1, '2021-06-01', NULL),
(756, 'laetitia.guerin@alstomgroup.com', '$2y$10$cXj9Z6m9CxqFe11/XcE9pusbQTZgZ0alflQQDL61q1rtWJ9bdP4eO', 'A', 'GUERIN', 'Laetitia', 'F', '147359', '', 1, '0000-00-00', NULL),
(757, 'gilles.guilbon@alstomgroup.com', '$2y$10$1VB/hyFMenGoi5hpyypp2eKPmoYu.YwI3LH88ry/U9W6gbAnFodjm', 'M', 'GUILBON', 'Gilles', 'H', '10967', ':+33681582125', 1, '0000-00-00', NULL),
(758, 'isabelle.guilloteau@alstomgroup.com', '$2y$10$jSD1d0X.QmK.qF4HlJqyHOMuUy4qrHoKxmpdmBSbaEPDu1y/R7siq', 'M', 'GUILLOTEAU', 'Isabelle', 'F', '26353', '', 1, '0000-00-00', NULL),
(759, 'bruno.hamon@alstomgroup.com', '$2y$10$mN5xdLjHLQ.8r27Jgvju2.cGXURE/tKVdDE7rFdThn.u.22FqgTwe', 'M', 'HAMON', 'Bruno', 'H', '10984', ':+33680912253', 1, '0000-00-00', NULL),
(760, 'patrice.haraut@alstomgroup.com', '$2y$10$3aqTcQl7Si5EUGGNhzKEQuBaU018SlG147pYnDOMkxfwd8NmMWTR6', 'M', 'HARAUT', 'Patrice', 'H', '10990', '', 1, '0000-00-00', NULL),
(761, 'didier.hays@alstomgroup.com', '$2y$10$F6RiUtCCnKQbBy99OlvbSOqfOno7hk2S.dVtsnmy/xV1ExyKOqkg.', 'L', 'HAYS', 'Didier', 'H', '10991', '', 1, '0000-00-00', NULL),
(762, 'vincent.hubert@alstomgroup.com', '$2y$10$shnBSHQXYlMhYm52eOeEoe6bksjO3pzPhvphRUUG4Py2Gl4zA0.o2', 'M', 'HUBERT', 'Vincent', 'H', '254654', '', 1, '0000-00-00', NULL),
(763, 'thierry.humblet@alstomgroup.com', '$2y$10$UDgih8AlNg7kFFPUBH4MxebPmDUwatap0PHIj8EY9.y2Z/d1z3GbS', 'M', 'HUMBLET', 'Thierry', 'H', '241868', ':07-62-93-14-09', 1, '0000-00-00', NULL),
(764, 'sylvie.jeunehomme@alstomgroup.com', '', 'M', 'JEUNEHomme', 'Sylvie', 'F', '11028', ':', 1, '0000-00-00', NULL),
(765, 'francois.jouannault@alstomgroup.com', '$2y$10$dXkVDocK5cA/heZmX/HKD.2lRDfarByjNNh.0zhvqWxcjZmkX0CJ2', 'M', 'JOUANNAULT', 'Francois', 'H', '11033', '', 1, '0000-00-00', NULL),
(766, 'pascal.joulin@alstomgroup.com', '$2y$10$CTAQgJIhimneh829eFcQ8.DOSsiGMR3s0yM/qSc1PDn/BNAlhPTSm', 'M', 'JOULIN', 'Pascal', 'H', '193557', '', 1, '0000-00-00', NULL),
(767, 'anne-cecile.jourdan@alstomgroup.com', '$2y$10$k3a5FLSU6i1DEHwyCkPj3..e2imnwKa7PwWzexR7GiZTzRmjJXeeS', 'M', 'JOURDAN', 'Anne-Cécile', 'F', '438075', '', 1, '2021-03-26', NULL),
(768, 'sabine.jouy@alstomgroup.com', '$2y$10$tfr/lucvU7cJkDNpE4W.SeB2muILx273Nyn1PiQRXzHx8ba7c1Cay', 'M', 'JOUY', 'Sabine', 'F', '11041', '', 1, '0000-00-00', NULL),
(769, 'cedric.juin@alstomgroup.com', '$2y$10$a3nWbM1XmF0OokBiD/h35uR.Q48EOnxYAVHguEJQdwCkDTESUq6wm', 'M', 'JUIN', 'Cedric', 'H', '261544', '', 1, '0000-00-00', NULL),
(770, 'arman.karimi@alstomgroup.com', '$2y$10$F4PKu9KaCbsLf9RsZYBpqO9Rtiexb/i2woVaydTdxCT4kWPD4axES', 'M', 'KARIMI', 'Arman', 'H', '305613', '', 1, '2019-11-29', NULL),
(771, 'patrice.kergadallan@alstomgroup.com', '$2y$10$xQhKKkevT7cj/mkUOMOxSu/wEud0/FrMK3fCGuNqPmrRtRJEP7c4m', 'M', 'KERGADALLAN', 'Patrice', 'H', '11052', ':0687763512', 1, '0000-00-00', NULL),
(772, 'guilaine.kolb@alstomgroup.com', '$2y$10$ZwYER7aVcxTSJO82vCpmHeNW9hkbIGdnpQI3Ws.Oif6ReU3C.Jr8.', 'M', 'KOLB', 'Guilaine', 'F', '158454', '', 1, '2020-06-16', NULL),
(773, 'damien.labasque@alstomgroup.com', '$2y$10$2X2V/95mSkGsu.bPiDWaQ.5TnXd0HGQqiCOaoJWxOSxOhnxHWhvJm', 'M', 'LABASQUE', 'Damien', 'H', '142619', '', 1, '0000-00-00', NULL),
(774, 'cedric.lacroix@alstomgroup.com', '$2y$10$Msobec5WLlXd85cwasxaiO3/7GOO4XkHaoDhwwB0/3IR/HhfBSgc2', 'M', 'LACROIX', 'Cedric', 'H', '156896', '', 1, '2020-02-18', NULL),
(775, 'cecile.lagneau@alstomgroup.com', '$2y$10$HIidVRWtckqF.Mmi/k0WFelYRSrMQf5zz2yKnI2d30DG5zINtVyRm', 'M', 'LAGNEAU', 'Cécile', 'F', '11064', ':06 82 58 91 75', 1, '2018-05-15', NULL),
(776, 'mathieu.lallemand@alstomgroup.com', '$2y$10$hFH3qaIfUXrMyc6f/wtPreUsrwAT6pk3c1iFZF49q1WaE7x156bh6', 'A', 'LALLEMAND', 'Mathieu', 'H', '181087', ':0663351024', 1, '0000-00-00', NULL),
(777, 'ludovic.lamirand@alstomgroup.com', '$2y$10$KostokudnV8edzMWAzuhnuYehKBqTeFS8unfe1yu9c0mhEXYfLdR2', 'M', 'LAMIRAND', 'Ludovic', 'H', '11069', '', 1, '0000-00-00', NULL),
(778, 'anthony.lancelot@alstomgroup.com', '$2y$10$JRP6cKyDY9p1dE2D4CeagOVaVusA3blCAPKYIc/YpRoqiueMvAH5.', 'M', 'LANCELOT', 'Anthony', 'H', '301654', '', 1, '0000-00-00', NULL),
(779, 'philippe.landemard@alstomgroup.com', '$2y$10$HFleHQSkPvw2ntrhbADDXOocqgDn7/SSLWACeUuixEOiepjvE53E6', 'M', 'LANDEMARD', 'Philippe', 'H', '433387', '', 1, '2020-10-23', NULL),
(780, 'alexandre.latour@alstomgroup.com', '$2y$10$R5SqRzI8FIB8oTH7XLonzeyx7K7W.UBqklNQbVvOkDg57aLW/LHMa', 'M', 'LATOUR', 'Alexandre', 'H', '11082', '', 1, '0000-00-00', NULL),
(781, 'cedric.laurencon@alstomgroup.com', '$2y$10$ddSQgOUVNpVB4ZDhM961UuSfCgcmymbdmBrzqtmEgLruAyvNFIRLa', 'M', 'LAURENCON', 'Cedric', 'H', '11084', '', 1, '0000-00-00', NULL),
(782, 'pierre-yves.lavaud@alstomgroup.com', '$2y$10$TX.bQJdXhlIpInaRymXEyu6BDSHcHXfe1vEz3QZaU3DF5j3N4m7eG', 'M', 'LAVAUD', 'Pierre-Yves', 'H', '11088', '', 1, '2013-06-25', NULL),
(783, 'pierre.lecaer@alstomgroup.com', '$2y$10$FENkL/P0UVDTw5at6yxS0.scIn9gLsdAiHl2I1yn7dRn.X0wTm9T6', 'M', 'LE CAER', 'Pierre', 'H', '11095', '', 1, '0000-00-00', NULL),
(784, 'ludovic.le-roux@alstomgroup.com', '$2y$10$.RYPmFzYkFpzn2mwI8/okur6OztKzkQAlkJDg2wOz/Fg1bXJf60ze', 'M', 'LE ROUX', 'Ludovic', 'H', '42377', '', 1, '0000-00-00', NULL),
(785, 'frederic.le-breton@alstomgroup.com', '$2y$10$OWhDsgnQIGY14hc6PqJCMusyLS.XGAYwOCufTwSqcPa0iOxmML7w.', 'M', 'LE-BRETON', 'Frederic', 'H', '11092', '', 1, '0000-00-00', NULL),
(786, 'flavie.lechelle@alstomgroup.com', '$2y$10$JTHukEXeENLOguP13DpEKuA39v.0LyU.Zc/5qtnHWp78tENA0sTre', 'M', 'LECHELLE', 'Flavie', 'F', '308272', ':0645739752', 1, '2020-01-01', NULL),
(787, 'franck.lecommandoux@alstomgroup.com', '$2y$10$wA2VAdZLDusW3IBJFelIduTNAUKyIzX2jFiRdlh6GlytXktLbbSFS', 'A', 'LECOMMANDOUX', 'Franck', 'H', '254835', ':0669557560', 1, '0000-00-00', NULL),
(788, 'pauline.ledoux@alstomgroup.com', '$2y$10$522CG.qkGFs9dKsuJHN58.rjlrNyLfBxwIdBzBIqDpUOoY.NzTI7e', 'A', 'LEDOUX', 'Pauline', 'F', '193085', '0761735772', 1, '0000-00-00', NULL),
(789, 'herve.lefebvre@alstomgroup.com', '$2y$10$jxefr7gj4FNQ03PEGNxCruenWVk1PU7FEP/KGsfd/ByxOC4JMt1yq', 'M', 'LEFEBVRE', 'Herve', 'H', '148376', '', 1, '0000-00-00', NULL),
(790, 'sylvain.le-gal@alstomgroup.com', '$2y$10$miK/KZGvwlMa/JHywlfvD.L47btQwjrVl0RUt3c0JKtN4B5XbppbC', 'M', 'LE-GAL', 'Sylvain', 'H', '434048', '', 1, '2020-09-28', NULL),
(791, 'guillaume.legrand@alstomgroup.com', '$2y$10$Zf3IZ803jC4085VsSJzSCuJTCjr3BXTWElvyglNARpsAWHBGgKIn.', 'M', 'LEGRAND', 'Guillaume', 'H', '187106', '', 1, '0000-00-00', NULL),
(792, 'guillaume.le-guyader@alstomgroup.com', '$2y$10$K4yjohH7E/tDaBe9NpIHce9Q4rrs5YInvijyF4RxYpECfJJzWFPCe', 'M', 'LE-GUYADER', 'Guillaume', 'H', '102166', '', 1, '0000-00-00', NULL),
(793, 'christine.leignel@alstomgroup.com', '$2y$10$rLoSCl9QSbOKlS3QP5pnR.c8HdaQoS2fROVb5iL//sA4lgb2szjL6', 'M', 'LEIGNEL', 'Christine', 'F', '12578', '', 1, '0000-00-00', NULL),
(794, 'francois.lenci@alstomgroup.com', '$2y$10$8wk91OyxP2CD9aZ4nE2pT.x04OdicfLqYfEFlLe.cbHUVKBx1iJdO', 'M', 'LENCI', 'Francois', 'H', '27589', '', 1, '0000-00-00', NULL),
(795, 'valentin.leneutre@alstomgroup.com', '$2y$10$7TdhC9Ghg4BtWiWSN/EQyO9mcyBs6ZMwv/E8bF5LpVUJ/saEE/lfW', 'M', 'LENEUTRE', 'Valentin', 'H', '429129', '', 1, '2020-02-28', NULL),
(796, 'guillaume.lheritier@alstomgroup.com', '$2y$10$snFb/BVQwgw5clyOsEHCcuyQuQJmGf/Uhz2e6X7r/G4DFgDnbDMN2', 'M', 'LHERITIER', 'Guillaume', 'H', '173441', '', 1, '0000-00-00', NULL),
(797, 'arnaud.livenais@alstomgroup.com', '$2y$10$N7psC1Ye8A6SW3z7FUBwJOCl9zebdE2/SE4e8.oPE3SLAcaBSQ/8S', 'M', 'LIVENAIS', 'Arnaud', 'H', '178556', '', 1, '0000-00-00', NULL),
(798, 'pierre-andre.loze@alstomgroup.com', '$2y$10$urSA3mu23FluD68yWKI7gevQUjvTDrI9D/g06oFS1VYGFVbw7p01e', 'M', 'LOZE', 'Pierre-andre', 'H', '11152', '', 1, '0000-00-00', NULL),
(799, 'jean-louis.lugol@alstomgroup.com', '$2y$10$wzF/xIIlw3l9wYaQoW6TSusYAzoCC336HezbdLXCfSKW3QSAw4ckq', 'L', 'LUGOL', 'Jean-Louis', 'H', '11156', '', 1, '0000-00-00', NULL),
(800, 'jean-francois.maes@alstomgroup.com', '$2y$10$0dwB5ktLWgr5jPehgbqdIuhNgiqykxEsWYBAbarsvn2gqY49cDOUG', 'M', 'MAES', 'Jean-François', 'H', '11168', '', 1, '2013-09-02', NULL),
(801, 'pierre.malet@alstomgroup.com', '$2y$10$smFlBPpKN1vHA9mjpBefPesuYJsNP9LvFertFGOdhkdOFZZrI1YYS', 'L', 'MALET', 'Pierre', 'H', '186596', '', 1, '0000-00-00', NULL),
(802, 'sebastien.manceau@alstomgroup.com', '$2y$10$F50i0rcKsPmdf0rea5Kejer59mYO.CDBKExAzO.3S0X01Hx5EfTDq', 'M', 'MANCEAU', 'Sebastien', 'H', '262376', '', 1, '2013-06-25', NULL),
(803, 'thierry.manderscheid@alstomgroup.com', '$2y$10$K4oOmI5HBhAQ8al19lnGHuPqiw2lX65KAI/Oky.iOJ.QTMxsv4Zxi', 'M', 'MANDERSCHEID', 'Thierry', 'H', '186844', '', 1, '0000-00-00', NULL),
(804, 'jean-christophe.marconnot@alstomgroup.com', '$2y$10$IvZlYGvGqg2aZw.A5vfqDOYYK5EdP/1Xa13S.oNBUJU6g185cqRN.', 'M', 'MARCONNOT', 'Jean-christophe', 'H', '11186', '', 1, '0000-00-00', NULL),
(805, 'philippe.maree@alstomgroup.com', '$2y$10$oBsrYGuh4ESvXqgrCCb.uueDKEQb.kruHN6eUYtHtU/k3XLVBJh3e', 'M', 'MAREE', 'Philippe', 'H', '40331', '', 1, '2020-09-07', NULL),
(806, 'eric.marqueteau@alstomgroup.com', '$2y$10$0M.bFbObxntHwO1ZSlIyiem.B/8ycsMOCK86DGYb0IL8upP6kQfHW', 'M', 'MARQUETEAU', 'Eric', 'H', '11199', '', 1, '0000-00-00', NULL),
(807, 'angelique.martin@alstomgroup.com', '$2y$10$LuXHyPg9S1uu5.dUgybU8evNwdjlJhOp8ZMYfoMUJNbxMb/.os8.S', 'M', 'MARTIN', 'Angelique', 'F', '90308', ':', 1, '0000-00-00', NULL),
(808, 'jerome.martin@alstomgroup.com', '$2y$10$Fosds4UNWleylC8FHxy//enMoV8plncb4tIzUaKIVp4Crf3NO9HUS', 'M', 'MARTIN', 'Jérome', 'H', '97442', '', 1, '2020-08-25', NULL),
(809, 'franck.mauguillet@alstomgroup.com', '$2y$10$8phyO.lmiAIhpCqSdBAl0.68tZQ37ROSAVNlPgoyoNzpyBhgPUW6q', 'M', 'MAUGUILLET', 'Franck', 'H', '11215', '', 1, '2015-02-23', NULL),
(810, 'raphael.menager@alstomgroup.com', '$2y$10$queJeAtPdrVoLlcwK9rEgejXcdw9kjFmb18NIUI7/FRflFYqKdUwW', 'L', 'MENAGER', 'Raphaël', 'H', '254445', '', 1, '0000-00-00', NULL),
(811, 'luis.frederico@alstomgroup.com', '$2y$10$2eBjb2aczjenqSUACJm4Ce7spzdYlmB9aSiBnbN7bKsyXTgfiM89.', 'M', 'MENDES FREDERICO', 'Luis manuel', 'H', '158254', '', 1, '0000-00-00', NULL),
(812, 'didier.menu@alstomgroup.com', '$2y$10$e1JaQf/XOFIfDsrLhHpfvu5j0Hd07UPlcD.HzyyptnHB.uNE..IwC', 'M', 'MENU', 'Didier', 'H', '244346', '', 1, '0000-00-00', NULL),
(813, 'emmanuelle.meyer@alstomgroup.com', '$2y$10$QyEtydCLUegelrebd3Tsle6.Z25ORADCvn.65gi9NEFdLYMktHZFK', 'M', 'MEYER', 'Emmanuelle', 'F', '11403', '', 1, '0000-00-00', NULL),
(814, 'gregoire.miguaise@alstomgroup.com', '$2y$10$LsW8S4y5IHFpAGFpnya4C.cSiYH1uJbrGLOFkV4daTgrKGGtRVIca', 'M', 'Miguaise', 'Grégoire', 'H', '172709', '', 1, '0000-00-00', NULL),
(815, 'florence.mille@alstomgroup.com', '$2y$10$D6GcG2Rw6b6O4UWb8OVLLOgQUFXf1t594v7Dn.EGIpfsUFXfdTnVe', 'M', 'MILLE', 'Florence', 'F', '171464', '', 1, '0000-00-00', NULL),
(816, 'emmanuel.mitaine@alstomgroup.com', '$2y$10$n.pRVA4SP2Bqu6h/xb3m8.zfkXPRHurTCq/TMcftqw4GFWtCNSZ5C', 'M', 'MITAINE', 'Emmanuel', 'H', '152164', '', 1, '0000-00-00', NULL),
(817, 'vladimir.modylevskiy@alstomgroup.com', '$2y$10$9e7KoAVWxl9geBweXj.B1.xgE11qMjsODqOy0AP8VUd0b5nRs53BG', 'M', 'MODYLEVSKII', 'Vladimir', 'H', '11403', '', 0, '2013-07-11', '2021-07-09'),
(818, 'bernard.montaut@alstomgroup.com', '$2y$10$pz0BAintkQs7QJfacekLauNsZWa7EfKLOHlmiL9/1K9rfw1bJEVeq', 'M', 'MONTAUT', 'Bernard', 'H', '42378', '', 1, '0000-00-00', NULL),
(819, 'patrick.morand@alstomgroup.com', '$2y$10$V292QljYRNhzBCPUhVZo7ObtRx3b9PqJuzwdek4YkHsiXEkm6EdWG', 'M', 'MORAND', 'Patrick', 'H', '11272', '', 1, '0000-00-00', NULL),
(820, 'gwenael.moreau@alstomgroup.com', '$2y$10$CWwZ06t13hseCyMU0thmVeG4gzXUUnk5bIz3wp4Deq9VtP.F13O86', 'M', 'MOREAU', 'Gwenael', 'H', '20213', '', 1, '0000-00-00', NULL),
(821, 'sebastien.moreau@alstomgroup.com', '$2y$10$nmgMjLLhhbsYFo/jhgYnTuBAwynuy15CLgfE9lvawaFIu.KH96x2u', 'M', 'MOREAU', 'Sebastien', 'H', '193753', '', 1, '0000-00-00', NULL),
(822, 'regis.mussaud@alstomgroup.com', '$2y$10$TyCeaU9LvLMjtRJGlGN/DuCEyGW6weGTt/9FQPsun3uBIZ.E6RELq', 'M', 'MUSSAUD', 'Régis', 'H', '11292', '', 1, '2019-05-23', NULL),
(823, 'sebastien.musset@alstomgroup.com', '$2y$10$cIOwHrt6RoeWYsNGaBp/reJof/gmEmrSyQCltTDr0OG5EX2PvqBw2', 'M', 'MUSSET', 'Sébastien', 'H', '142112', ':+33681169027', 1, '0000-00-00', NULL),
(824, 'hoang.nguyenduc@alstomgroup.com', '$2y$10$BveV5L.MnRiwtwrWbHMYIe9Gai/0e2q8eVTtkd6GOUe/3l91EF.EC', 'M', 'NGUYEN DUC', 'Hoang', 'H', '438073', '', 1, '2021-03-31', NULL),
(825, 'guillaume.nicolas@alstomgroup.com', '$2y$10$ZgV4Ih38.0o4Hc0qSxyXwOVSKuL50ZYl9YgGZzo6rut9onuChTCty', 'M', 'NICOLAS', 'Guillaume', 'H', '252107', '', 1, '2014-01-21', NULL),
(826, 'yann.olu@alstomgroup.com', '$2y$10$uVf2CBtxOk.k14X4g0FPp.ti9Se7fYcCOfVZ2v8BSnVPJXbJyOSE.', 'M', 'OLU', 'Yann', 'H', '11312', '', 1, '0000-00-00', NULL),
(827, 'christophe.pailler@alstomgroup.com', '$2y$10$d/B7CgKIkiIWVJD1qfpWCOqOMyqBBs14UDz5qanGae4dXESyf2N6i', 'M', 'PAILLER', 'Christophe', 'H', '11320', ':0666450127', 1, '0000-00-00', NULL),
(828, 'antoine.pain@alstomgroup.com', '$2y$10$ye58NBAx6k8gbVnp7OcdUe/YVrDHJwQMRHQ2eOg/Qir5/vtfecuQG', 'M', 'PAIN', 'Antoine', 'H', '11322', '', 1, '0000-00-00', NULL),
(829, 'frederic.pajaud@alstomgroup.com', '$2y$10$k.y8/jldp1t1b9YilKbac.jbdcxfP1N2NzQc/aDz6lffDeTDJiqJ6', 'M', 'PAJAUD', 'Frederic', 'H', '11326', '', 1, '0000-00-00', NULL),
(830, 'fabrice.pallas@alstomgroup.com', '$2y$10$ylHOQAczXYy42vcpeEHYn.pwvI2/tPtrwGHLuABrN15jF83sP9Bc.', 'M', 'PALLAS', 'Fabrice', 'H', '11329', '', 1, '0000-00-00', NULL),
(831, 'cathia.pallavicini@alstomgroup.com', '$2y$10$uyqO0DUGZ97NwfmAK3efcOXTkdCsgrt8Ag7DPZu6WX8YcEyI46BTW', 'L', 'PALLAVICINI', 'Cathia', 'F', '149052', ':0660983163', 1, '0000-00-00', NULL),
(832, 'nicolas.pavarino@alstomgroup.com', '$2y$10$LzmDkRzZBUJlmqbdg/Vr3eFxAowsCte3Zf03T0gcUU7WsHpXLoQNm', 'M', 'PAVARINO', 'Nicolas', 'H', '11339', '', 1, '0000-00-00', NULL),
(833, 'nicolas.pech@alstomgroup.com', '$2y$10$I0TY4q0f/r6h5o0RZFLe9uB65leSU8mokO4LWXP/ihbrrhMZqrPJu', 'M', 'PECH', 'Nicolas', 'H', '163093', '', 1, '0000-00-00', NULL),
(834, 'yann.pennetier@alstomgroup.com', '$2y$10$2j9ODmbwl4P.OY35vyzNFuhKoYuBsJ0xg8cM.3XwEtYIlpmJAxNwe', 'L', 'PENNETIER', 'Yann', 'H', '186060', ':0666450256', 1, '0000-00-00', NULL),
(835, 'daniel.pezzo@alstomgroup.com', '$2y$10$CKw/14zvE9tmLV2PHCJpQ.3jPkjO1N6nS8e1zT3s4o/jy409CKY6S', 'M', 'PEZZO', 'Daniel', 'H', '128874', '', 1, '0000-00-00', NULL),
(836, 'pascal.philippe@alstomgroup.com', '$2y$10$Mb/64AXhmEb2LUggupcgAuzuyOjsPzpLFNjV9V857z/xsCjv7CZnK', 'M', 'PHILIPPE', 'Pascal', 'H', '11360', '', 1, '0000-00-00', NULL),
(837, 'stephane.philipponneau@alstomgroup.com', '$2y$10$yOmkwHXl/m1DBLgSD430u.7wyci/xAjxsSz43JIDTjWnwg3OOpgTW', 'M', 'PHILIPPONNEAU', 'Stephane', 'H', '11361', '', 1, '0000-00-00', NULL),
(838, 'laurent.piat@alstomgroup.com', '$2y$10$8vukPwejHCftes/IfwpuZ.VH9Jw3xuo9eaOPzs9teZm16SVSIO7Ce', 'M', 'PIAT', 'Laurent', 'H', '163202', '', 1, '0000-00-00', NULL),
(839, 'dorine.pilorge@alstomgroup.com', '$2y$10$oP8meE7SF03.iS78R2tn/OY2fCbuzgigaEJ2IxO1o6fliAkWJHVQa', 'M', 'PILORGE', 'Dorine', 'F', '141742', '', 1, '0000-00-00', NULL),
(840, 'ambrosiana.piras@alstomgroup.com', '$2y$10$TLKATLUAMb6M2VmzdHRSmeq6FoJiUQnGnzV8OvRQQ5ueTPqh72S02', 'L', 'PIRAS-BIGOT', 'Ambrosiana', 'F', '237951', '', 1, '0000-00-00', NULL),
(841, 'rui-manuel.pires@alstomgroup.com', '$2y$10$/w3ClXeA8KsWsz3lX1o0P./w4AgV8O/pxTlS6HIymszUgPoKkFYKi', 'M', 'PIRES', 'Rui-Manuel', 'H', '180534', '', 1, '0000-00-00', NULL),
(842, 'thibault.pitrou@alstomgroup.com', '$2y$10$1TE0JVZx.rNnmCZ0307LjeQJlt2VXOvs6XJJU3rSmSNRqB6z1feoa', 'M', 'PITROU', 'Thibault', 'H', '189793', '', 1, '0000-00-00', NULL),
(843, 'eric.planchot@alstomgroup.com', '$2y$10$aco3xtQHQYoMTWgAb6ExNekqZRc32Fh/32zMf2IHHrbKZ6tlnJ7Ae', 'M', 'PLANCHOT', 'Eric', 'H', '139745', '', 1, '0000-00-00', NULL),
(844, 'arnaud.pourty@alstomgroup.com', '$2y$10$xooQZhvS0bnFCKW/.4/XaOlYpgv0Sa5gNSCwjrBxvrcNs2BZdSI9q', 'A', 'POURTY', 'Arnaud', 'H', '288048', '0762111307', 1, '2019-02-12', NULL),
(845, 'germain.prunier@alstomgroup.com', '$2y$10$QqsgOPHaJ0r1HOkx.yg7H.5oO04pJWgc/JThoPzKbExsp347qwEnW', 'M', 'PRUNIER', 'Germain', 'H', '160801', '', 1, '0000-00-00', NULL),
(846, 'alexandre.raguenes@alstomgroup.com', '$2y$10$86lxMpIuYnCTTmH3oBSoIeWAuEPz4sjTqIaNPh.iuTEQJglbjPsMa', 'M', 'RAGUENES', 'Alexandre', 'H', '437973', '', 1, '2021-05-06', NULL),
(847, 'loic.reinert@alstomgroup.com', '$2y$10$GtkqYHLiRR6XdHmfl0SmbeX7xCGP9M/uKOLA.OmaUjteKUs7tcO7.', 'M', 'REINERT', 'Loic', 'H', '12530', '', 1, '0000-00-00', NULL),
(848, 'matthieu.renie@alstomgroup.com', '$2y$10$MRGkrd5g3gSqJvBsK9BcweWOtWLc7hi2ifq4P86kEZs5X26/MEOQG', 'M', 'RENIE', 'Matthieu', 'H', '141821', '', 1, '0000-00-00', NULL),
(849, 'sandrine.renimel@alstomgroup.com', '$2y$10$N1iX9JypyrZ7tl2.jWMkXO2KnlTzIOdWKlV7n1vpNemr0GE3O3cpe', 'A', 'RENIMEL', 'Sandrine', 'F', '245169', ':0630297137', 1, '2013-06-25', NULL),
(850, 'guillaume.reux@alstomgroup.com', '$2y$10$s3DGDCUSx2f/uqBB5Mx9WutqUYcHvuCrJOOCEa1I4jTwcxY0RES6i', 'M', 'REUX', 'Guillaume', 'H', '179790', '', 0, '0000-00-00', '2021-07-09'),
(851, 'clement.richard@alstomgroup.com', '$2y$10$aAAjh5evwyLnOC2P6GyHB.fa3FfZow48c5BGm55m8vP/eaSDVlToG', 'M', 'RICHARD', 'Clement', 'H', '11458', '', 1, '0000-00-00', NULL),
(852, 'regis.riffaud@alstomgroup.com', '$2y$10$JkBqAWa1XABjjZqfjwuLD.fowUUUnNz6M5eslvzRGLq9BnuB1oKsm', 'M', 'RIFFAUD', 'Régis', 'H', '11461', '', 1, '2017-04-26', NULL),
(853, 'roland.riviere@alstomgroup.com', '$2y$10$0/ZEC2hGi3dtF4VKHEmZyOnbBtUuteftKvcJ1rOxiib1ecdKbip2C', 'L', 'RIVIERE', 'Roland', 'H', '171459', '', 1, '0000-00-00', NULL),
(854, 'kevin.robert@alstomgroup.com', '$2y$10$dbezrOxQqNPHF4UWuw.tT.R8spfLMCEF1wmEbfLjbNg8XhQAfYhwC', 'M', 'ROBERT', 'Kévin', 'H', '253411', '', 1, '0000-00-00', NULL),
(855, 'jean-marc.roche@alstomgroup.com', '$2y$10$hIluSgv/wydTNI6RM6IDlOiDUN1PowiEQxNK1Kzm2lco9OYlZf0Di', 'M', 'ROCHE', 'Jean-marc', 'H', '11473', '', 1, '0000-00-00', NULL),
(856, 'frederic.rouan@alstomgroup.com', '$2y$10$hVMxCg0ZO7dEp0FfVl8tvephMrARKu.MLp9Uj3r.XpbTWp5yQs2ai', 'M', 'ROUAN', 'Frederic', 'H', '128868', '', 1, '0000-00-00', NULL),
(857, 'julie.rouchaud@alstomgroup.com', '$2y$10$3N.k8xOOQ0A4nBvi.ltkee/k/uzUoxTgRnsAgMN/MTK7paAarz.k6', 'L', 'ROUCHAUD', 'Julie', 'F', '308289', ':', 1, '2020-06-08', NULL),
(858, 'florence.rougeau@alstomgroup.com', '$2y$10$kDe2GscOLL3JxXmFVfPhReDT2beWd/vTK4qU6liDPhviSnWcEn3om', 'M', 'ROUGEAU', 'Florence', 'F', '142234', '', 1, '2017-05-30', NULL),
(859, 'nicolas.roussely@alstomgroup.com', '$2y$10$Cfrz3dkUOfUnO4/RQBxMI.UU6HCP6shYYmLziv1SKyRWCOnZOc1si', 'L', 'ROUSSELY', 'Nicolas', 'H', '133933', '', 1, '0000-00-00', NULL),
(860, 'olivier.roux@alstomgroup.com', '$2y$10$GSWmmQUPaDCiEPQTYH0qQuzQ5OgCPiaelein/mSOgc5tw8UwT5HeS', 'M', 'ROUX', 'Olivier', 'H', '11491', ':0667180029', 1, '2018-09-10', NULL),
(861, 'nicolas.rufflart@alstomgroup.com', '$2y$10$OmEeAESA22Bs/.dPlriuFOp6FEMAcdcNxxhw1J.AasQJK5IKYZrKW', 'M', 'RUFFLART', 'Nicolas', 'H', '259819', '', 1, '2013-08-28', NULL),
(862, 'sebastien.saby@alstomgroup.com', '$2y$10$evaFND8QT4IjeM6lxIM/c.9pcGDyvxdns8emh4gcvsntwL46l5nrW', 'M', 'SABY', 'Sébastien', 'H', '305564', '', 1, '2018-07-10', NULL),
(863, 'lucile.sander@alstomgroup.com', '$2y$10$MQN2lnFXrj/AoRmAnAxk1.0Wy8HCSf4Lj0W.k3NYrI/6GmGba/14.', 'M', 'SANDER', 'Lucile', 'F', '172969', '', 1, '0000-00-00', NULL),
(864, 'amine.saoutarrih@alstomgroup.com', '$2y$10$pNkG.B3QHGnK/R36LQdSO.pdv8SVfmArIVutteL5G1THxKtrBvxp6', 'M', 'SAOUTARRIH', 'Amine', 'H', '306868', '', 1, '2019-06-07', NULL),
(865, 'yassir.saoutarrih@alstomgroup.com', '$2y$10$ohmHtbqDtM1IUHQTeAbBquQvgT9zjRRI2UdKZ9SJRiiAyRYFKK0iy', 'M', 'SAOUTARRIH', 'Yassir', 'H', '429332', '', 1, '2021-06-01', NULL),
(866, 'jerome.sarraille@alstomgroup.com', '$2y$10$ZmptNF9zL2uARN0vOndnKe/riEVE7hEVbptP40pwKJ/dAeRcQtno2', 'M', 'SARRAILLE', 'Jerome', 'H', '11514', '', 1, '0000-00-00', NULL),
(867, 'christophe.sarti@alstomgroup.com', '$2y$10$ljPteI/UVdHxwMR2haDtE.El/MhXnaojnkrDQ7CQ3WEsTNknNOr1G', 'A', 'SARTI', 'Christophe', 'H', '145010', ':0678794292', 1, '0000-00-00', NULL),
(868, 'arnaud.schoenzetter@alstomgroup.com', '$2y$10$plsOoeO6J930UhC8fxuKluWYqN3rp4iCo/y6eaEomLlf1rTqFUrqi', 'A', 'SCHOENZETTER', 'Arnaud', 'H', '242270', ':', 1, '2021-05-19', NULL),
(869, 'luigi.segu@alstomgroup.com', '$2y$10$a/B5biph76f7XOYi5AWWx.A7m9ebhTQS8ya613Kpo1Ac0/vHXO9tS', 'M', 'SEGU', 'Luigi', 'H', '11525', '', 1, '0000-00-00', NULL),
(870, 'olivier.servajean@alstomgroup.com', '$2y$10$Tun80sKrfLzvG1.DBpj2fuTeL9U18SNWmX4D1xcnjsq9IwUqFGMLO', 'M', 'SITBON', 'Franck', 'H', '35431', '', 1, '0000-00-00', NULL),
(871, 'philippe.soulat@alstomgroup.com', '$2y$10$pEWyVcj.CoXSq0NzoCNXIesoQGuabBmvSJstW6S2.EVAz3XZRnInu', 'M', 'SOULAT', 'Philippe', 'H', '135901', ':0671606863', 1, '0000-00-00', NULL),
(872, 'annie.stegre@alstomgroup.com', '$2y$10$.KHykU8IAS75uK4B.WEyTO44QvbMJt8/.WB8kVLKwS0uwnpDD8W5u', 'L', 'STEGRE', 'Annie', 'F', '11550', '', 1, '0000-00-00', NULL),
(873, 'sebastien.taillandier@alstomgroup.com', '$2y$10$xAKdHQk0igp5Dy9tcQkCT.2XN.H/IXRSEOB8faY68KEAx80WNsNoy', 'A', 'TAILLANDIER', 'Sebastien', 'H', '178203', '', 1, '0000-00-00', NULL),
(874, 'frederic.taveneau@alstomgroup.com', '$2y$10$I1Mr3hl2TTXIqo82MeTNJurqoIdzr8LpX8AMDjhrFP7lFyH.6LnXS', 'M', 'TAVENEAU', 'Frederic', 'H', '145980', '', 1, '0000-00-00', NULL),
(875, 'tony.tesseron@alstomgroup.com', '$2y$10$vhEBgxEO0rUpcvrFVYOufOb0QiWaR3d4.pPKmkvuFLal9dWZmOu/a', 'M', 'TESSERON', 'Tony', 'H', '169191', '', 1, '2015-01-01', NULL),
(876, 'laurent-andre.thomas@alstomgroup.com', '$2y$10$OQDfF.uUyfpk9T0SkvZvb.vGLmqK5XNohokePn3SancVq5Hzd6Fd.', 'L', 'THOMAS', 'Laurent', 'H', '178555', '', 1, '0000-00-00', NULL),
(877, 'philippe.thorel@alstomgroup.com', '$2y$10$wOs.yU9Ijxjr3JkVj/kbTOEmGw9pcor.96RLpxLPr.6aS3rvL8Z/S', 'M', 'THOREL', 'Philippe', 'H', '11581', '', 1, '0000-00-00', NULL),
(878, 'bruno.turelle@alstomgroup.com', '$2y$10$5VWcHw5Snp7/wPwhbimIBumYytv61mWd1SR8HxKo1KnKNHAZAP0Wy', 'M', 'TURELLE', 'Bruno', 'H', '11602', '', 1, '0000-00-00', NULL),
(879, 'laurent.vagner@alstomgroup.com', '$2y$10$Rl9Qh47GHN9Dg6SiLPRfCuHrzcJC/Is8L/JXeXyRUke0EdzhpFv9S', 'M', 'VAGNER', 'Laurent', 'H', '242509', '', 1, '2018-09-19', NULL),
(880, 'dominique.vaillant@alstomgroup.com', '$2y$10$rxrMHv25QvRSs5HtO0ZwP.3NIW2FuPJx4ulxfsB0g/lFc.UXQcbRy', 'M', 'VAILLANT', 'Dominique', 'H', '11607', '', 1, '0000-00-00', NULL),
(881, 'cedric.vandrot@alstomgroup.com', '$2y$10$MGcMBBxm.//GvqaSd7DZKu8Eh50NglJs3.7hGPaGqsFB40DHlq7ky', 'L', 'VANDROT', 'Cedric', 'H', '200096', ':0665252990', 1, '0000-00-00', NULL),
(882, 'francoise.vannier@alstomgroup.com', '$2y$10$UfiONB6zcuecH/c2/zfULefjC91s.eg52v5BZDMV28W.2nYOaHqjy', 'M', 'VANNIER', 'Francoise', 'F', '11611', '', 1, '0000-00-00', NULL),
(883, 'jean-pierre.vanucci@alstomgroup.com', '$2y$10$wcPKyIF8iImLy0wLRKqQVOprHC5GWAbynhzDQtGkF7W0CpWusshhu', 'L', 'VANUCCI', 'Jean-pierre', 'H', '11612', ':0607429801', 1, '0000-00-00', NULL),
(884, 'etienne.varin@alstomgroup.com', '$2y$10$V7.wBe7Yg7welse2UGE.WujcI4slSDcxdE3ox0bEE68ZC3hsEhtE6', 'M', 'VARIN', 'Etienne', 'H', '151729', ':0661728265', 1, '0000-00-00', NULL),
(885, 'gautier.vennin@alstomgroup.com', '$2y$10$ENjQBQGpp/.TShQMOWmZXO926/L1PbDXOj9fDCf5VQSF840rfgs3.', 'M', 'VENNIN', 'Gautier', 'H', '164784', '', 1, '0000-00-00', NULL),
(886, 'philippe.venturi@alstomgroup.com', '$2y$10$ETFyL13mbAuhErsWzBPGneHW3MoOPtAatsU8i1ec9dUO/nhwjl0pK', 'M', 'VENTURI', 'Philippe', 'H', '11618', '', 1, '0000-00-00', NULL),
(887, 'thomas.vergnault@alstomgroup.com', '$2y$10$J8qsIPDcs221QCx1WBOwc.TES0B0usn2t8rsTbp.6VHx2ppQpxd/a', 'M', 'VERGNAULT', 'Thomas', 'H', '186845', '', 1, '0000-00-00', NULL),
(888, 'franck.vergoni@alstomgroup.com', '$2y$10$yCsnD32CV71UiSBDCXu.X.r/ocCJ4pTGHVyNcoS3QJ26B6qcBOpPi', 'A', 'VERGONI', 'Franck', 'H', '683', ':0682595667', 1, '0000-00-00', NULL),
(889, 'laurent.vesque@alstomgroup.com', '$2y$10$Jr6OGsJr2vQuwMkfx7baU.cKJR7Pxpg.PjBImSZhnNPLIJuFynjGy', 'L', 'VESQUE', 'Laurent', 'H', '133923', '', 1, '0000-00-00', NULL),
(890, 'jerome.viat@alstomgroup.com', '$2y$10$hXV8CWFsVrrr3eFOD4o75OUHOtzP6FVF34B8fhje6Xr3K0roh6c8i', 'L', 'VIAT', 'Jérome', 'H', '212934', '', 1, '0000-00-00', NULL),
(891, 'samuel.videira@alstomgroup.com', '$2y$10$zbh2232LOn5.b5h2cbyYJueeiMxnmx/VUMEIqMXbR9stROncgr5X.', 'M', 'VIDEIRA', 'Samuel', 'H', '157997', '', 1, '0000-00-00', NULL),
(892, 'sara.vigliocco@alstomgroup.com', '$2y$10$5UHdNSkl1UDFLyLSrYsOUO2I9QPZwqzcFk5lZfIwm2UAP9R9S2RR6', 'M', 'VIGLIOCCO', 'Sara', 'F', '145464', '', 1, '2017-05-23', NULL),
(893, 'florence.villain@alstomgroup.com', '$2y$10$O/QhU1PGP1jIGWhHEYLND.w52KxsVOpbT3KmsvNZr3V.Y4ARR/UPy', 'L', 'VILLAIN', 'Florence', 'F', '11072', '', 1, '0000-00-00', NULL),
(894, 'sebastien-youness.zanary@alstomgroup.com', '$2y$10$Qw977piVB8PvM3gBh6qbzeuhUBU8v4VPK7ECkyh179cIkH97SLjqO', 'M', 'ZANARY', 'Sebastien-Youness', 'H', '171456', '', 1, '0000-00-00', NULL),
(902, 'karim.bello@alstomgroup.com', '', 'M', 'BELLO', 'Karim', 'H', '436642', ':', 1, '2021-07-09', NULL),
(903, 'vincent.betton@alstomgroup.com', '', 'M', 'BETTON', 'Vincent', 'H', '423825', ':', 1, '2021-07-09', NULL),
(904, 'aline.champagnac@alstomgroup.com', '', 'M', 'CHAMPAGNAC', 'Aline', 'F', '475167', ':', 1, '2021-07-09', NULL),
(905, 'quentin.de-la-motte-rouge@alstomgroup.com', '$2y$10$geKxmSjzpSalbd5eFJeouOykR2w3PNtLOZa/MiQovmCNTC2X5BTSS', 'M', 'DE-LA-MOTTE-ROUGE', 'Quentin', 'H', '472715', ':', 1, '2021-07-09', NULL),
(906, 'denis.emorine@alstomgroup.com', '$2y$10$JUc3c6rimeqfytQhiHVQZO0DiW1VPjT0240P38zKEmeeC11m56Hgy', 'M', 'EMORINE', 'Denis', 'H', '266685', ':', 1, '2021-07-09', NULL),
(908, 'helene.kouyoumontzakis@alstomgroup.com', '$2y$10$4BwiaxZuXwJcJgqK5x6cxu0HttFAhDnudMUHqdfhRlPredpaxZ/ka', 'M', 'KOUYOUMONTZAKIS', 'Helene', 'F', '267799', ':', 1, '2021-07-09', NULL),
(910, 'erwan.le-dren@alstomgroup.com', '', 'M', 'LE DREN', 'Erwan', 'H', '421706', ':', 1, '2021-07-09', NULL),
(911, 'amel.nait-djoudi@alstomgroup.com', '', 'M', 'NAIT-DJOUDI', 'Amel', 'F', '432668', ':', 1, '2021-07-09', NULL),
(913, 'francois.sourbadere@alstomgroup.com', '', 'M', 'SOURBADERE', 'Francois', 'H', '194806', ':', 1, '2021-07-09', NULL),
(914, 'nicolas.volps@alstomgroup.com', '$2y$10$qKABG7xPADT6RM2TVQXPPO7d0qdHoth6rBs6mOFGdLl8aHNX0U2lu', 'M', 'VOLPS', 'Nicolas', 'H', '180531', ':', 1, '2021-07-09', NULL),
(915, 'matthias.rouch@alstomgroup.com', '$2y$10$no3BK5m3hIXKWoMGZ6OtT.72kgWd8fao5F2cGQrs/vEkiwtTFqspa', 'M', 'ROUCH', 'matthias', 'H', '437778', ':', 1, '2021-07-19', NULL),
(916, 'michael.elan@alstomgroup.com', '$2y$10$EXGXKtNXhRM8DeGLTgh0deBhbkJG.7mzYl70FK6z6nDohtIUm3bNq', 'M', 'ELAN', 'Michael', 'H', '10802', ':+33 677057320', 1, '2021-09-01', NULL),
(918, 'sibylle.dupouy@alstomgroup.com', '$2y$10$A/akF3b321ddrZxkXQhC3OgVgvxR0MSY1QIuYKTYHJZHQec/NVrJC', 'M', 'DUPOUY', 'Sibylle', 'F', '', ':', 1, '2021-09-01', NULL),
(920, 'aurelie.betizeau@alstomgroup.com', '$2y$10$0hVhb5un04GryO3rsdYXxeoaOXYfakAHZ48VOu./zI6RSvWccHGle', 'M', 'BETIZEAU', 'Aurélie', 'F', '183037', '', 1, '2021-09-10', NULL),
(921, 'pascal.l-hotelier@alstomgroup.com', '$2y$10$eb8TywAro4gv53RGVfErVe6JZl1BHfmT0ijcm6JLcdmcz808ab2z.', 'M', 'LHOTELIER', 'Pascal', 'H', '431864', ':0661573699', 1, '2021-09-10', NULL),
(922, 'guillaume.desportes@alstomgroup.com', '$2y$10$jrzF5kpwqKieHhIsQl2y/.gEeW8UdaYjVou7kdV17HMnU.ilGN54.', 'M', 'DESPORTES', 'Guillaume', 'H', '20062', '', 1, '2021-09-20', NULL),
(924, 'nicolas.courtiade@alstomgroup.com', '$2y$10$bnpe46.efmcZuGrFBOsgZejMlqrVFMNrG0cdIOc93WxBblnJe5whO', 'M', 'COURTIADE', 'Nicolas', 'H', '454711', '', 1, '2021-09-21', NULL),
(925, 'cathel.mulotti@alstomgroup.com', '$2y$10$w4YMtIr4VmaMV.soe7HMpOzaQ.X0R0yVPHfv4/E2OUeChxJwyJl5G', 'M', 'MULOTTI', 'Cathel', 'F', '412741', ':0662120841', 1, '2021-09-21', NULL),
(926, 'charly.barre@alstomgroup.com', '$2y$10$gm9T/qdLsscU4o7idEMvoOc/NCFZ9zCDMrJ9K2.BVh/IjYF5c8pWy', 'M', 'BARRE', 'Charly', 'H', '436942', '', 1, '2021-09-21', NULL),
(927, 'antoine.watrin@alstomgroup.com', '$2y$10$28Uhrdkr5UPVLAPGHtc0ieXVlkdct46tE7Jb5W/1GWZlsE1zYEXgy', 'M', 'WATRIN', 'Antoine', 'H', '413623', '', 1, '2021-09-21', NULL),
(928, 'samir.oufary@alstomgroup.com', '$2y$10$3xeLutfjV/5o9GSq/lGMC.M9UzVni0gvJtcMZpdBbRPGg03gMH1zq', 'M', 'OUFARY', ' Samir', 'H', '433470', '', 1, '2021-10-27', NULL),
(929, 'dominique.moreau@alstomgroup.com', '$2y$10$6uyzQ/qJjrzfZ79KgKL2cOJCI9KGi1KITElaBIhrDzMYFYRFHsmB2', 'M', 'MOREAU', 'Dominique', 'H', '443250', '', 1, '2021-11-03', NULL),
(930, 'jessica.siegel-tiel@alstomgroup.com', '$2y$10$L7HoQWsbEZNqAyHzUTu8Iuip0riG/gjLLAiQftwrHnBmD0zLobBYS', 'M', 'SIEGEL', 'Jessica', 'F', '482356', '', 1, '2021-12-17', NULL),
(931, 'moretti.remi17@gmail.com', '$2y$10$9zf./KzTVWCxzyD/kQXqdOLQ8NKRUTwLJdFngjd0XInb5e6B25azm', 'A', 'moretti', 'remi', 'H', '', ':', 1, '2021-12-20', NULL),
(932, 'aze@gmail.com', '$2y$10$KpHRa/BfaivZHJwAqPUHKeOiX2HS49Jdsz7/JR9Wb4/VaPQUcvrHm', 'M', 'aze', 'aze', 'F', 'aze', 'aze', 1, '2022-01-10', NULL),
(933, 'zer@gmail.com', '$2y$10$/eCXkb8bTKG45Obo0yt2W.D/rqV1moxK8L3xvBF9NTHgqKdU6Vvla', 'M', 'zer', 'zer', 'H', 'zer', 'zer', 1, '2022-01-11', NULL),
(934, 'ert@gmail.com', '$2y$10$MdKoSzi/kkz2g.hvoz0pSeuLX8qKjk/mCNMEuX7eE8w/CIGpdY.PG', 'M', 'ert', 'ert', 'H', 'ert', 'ert', 1, '2022-01-11', NULL),
(935, 'rty@gmail.com', '$2y$10$SxRNjUuGOQwAnSYu7.yyk.Xw.lSaIbQPO/wh5himnkNDclrlUT2GO', 'M', 'rty', 'rty', 'H', 'rty', 'rty', 1, '2022-01-14', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `creneau`
--

DROP TABLE IF EXISTS `creneau`;
CREATE TABLE IF NOT EXISTS `creneau` (
  `ID_ACTIVITE` int(11) NOT NULL,
  `NUM_CRENEAU` int(11) NOT NULL,
  `DATE_CRENEAU` date NOT NULL,
  `HEURE_CRENEAU` time NOT NULL,
  `EFFECTIF_CRENEAU` int(11) NOT NULL,
  `STATUT` enum('A','V','O','F','T','S') NOT NULL DEFAULT 'A',
  `COMMENTAIRE` varchar(255) NOT NULL,
  `DATE_PAIEMENT` date DEFAULT NULL,
  PRIMARY KEY (`ID_ACTIVITE`,`NUM_CRENEAU`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `creneau`
--

INSERT INTO `creneau` (`ID_ACTIVITE`, `NUM_CRENEAU`, `DATE_CRENEAU`, `HEURE_CRENEAU`, `EFFECTIF_CRENEAU`, `STATUT`, `COMMENTAIRE`, `DATE_PAIEMENT`) VALUES
(144, 1, '2021-07-22', '18:15:00', 24, 'T', '', '2021-07-16'),
(145, 1, '2021-08-26', '17:50:00', 15, 'T', '', '2021-07-23'),
(146, 1, '2021-08-27', '18:30:00', 15, 'T', '', '2021-08-20'),
(147, 1, '2021-09-25', '14:30:00', 10, 'T', '', '2021-09-21'),
(148, 1, '2021-10-01', '18:00:00', 20, 'T', '', '2021-09-24'),
(149, 1, '2021-10-22', '19:30:00', 10, 'T', '', '0000-00-00'),
(150, 1, '2021-10-15', '18:00:00', 8, 'T', '', '2021-10-05'),
(150, 2, '2021-11-20', '10:00:00', 8, 'T', '', '2021-11-05'),
(151, 1, '2021-11-19', '19:30:20', 9, 'T', '', '0000-00-00'),
(152, 1, '2021-12-10', '18:00:00', 20, 'T', '', '2021-11-19'),
(153, 1, '2021-12-03', '18:00:00', 20, 'S', 'pas assez de participants', '2021-11-12'),
(154, 1, '2021-11-18', '17:30:00', 20, 'T', '', '2021-11-10'),
(155, 1, '2021-11-23', '18:15:00', 12, 'T', '', '2021-11-15'),
(156, 1, '2021-11-21', '10:00:00', 20, 'T', '', '2021-11-05'),
(158, 1, '2021-12-03', '18:00:00', 20, 'T', '', '2021-11-26'),
(159, 1, '2022-01-20', '20:00:00', 10, 'O', '', '2022-01-13'),
(160, 1, '2022-01-11', '12:30:01', 13, 'S', '', '2022-01-04'),
(160, 4, '2022-01-03', '12:30:00', 45, 'T', '', '2022-01-07'),
(161, 1, '2022-01-13', '11:55:00', 12, 'O', '', '2022-01-20'),
(162, 1, '2022-01-04', '14:57:00', 2, 'O', '', '2022-01-11'),
(163, 2, '2022-01-12', '19:07:00', 2, 'O', '', '2022-01-20'),
(163, 3, '2022-01-21', '16:30:00', 2, 'O', '', '2022-01-22'),
(167, 1, '2022-01-20', '19:06:00', 1, 'A', '', '2022-01-26');

-- --------------------------------------------------------

--
-- Structure de la table `domaine_activite`
--

DROP TABLE IF EXISTS `domaine_activite`;
CREATE TABLE IF NOT EXISTS `domaine_activite` (
  `ID_DOMAINE` int(11) NOT NULL,
  `LIBELLE` char(32) DEFAULT NULL,
  PRIMARY KEY (`ID_DOMAINE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `domaine_activite`
--

INSERT INTO `domaine_activite` (`ID_DOMAINE`, `LIBELLE`) VALUES
(1, 'CULTUREL'),
(2, 'AQUATIQUE');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

DROP TABLE IF EXISTS `inscription`;
CREATE TABLE IF NOT EXISTS `inscription` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ADHERENT` int(11) NOT NULL,
  `AUTO_PARTICIPATION` int(1) NOT NULL,
  `ID_INVITE` int(11) DEFAULT NULL,
  `ID_ACTIVITE` int(11) NOT NULL,
  `CRENEAU` int(11) NOT NULL,
  `DATE_INSCRIPTION` datetime NOT NULL,
  `DATE_PAIEMENT` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `MONTANT` float NOT NULL,
  `DATE_DESINSCRIPTION` datetime DEFAULT NULL,
  `PAYE` int(1) NOT NULL DEFAULT '0',
  `ATTENTE` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `ID_ACTIVITE` (`ID_ACTIVITE`),
  KEY `ID_ADHERENT` (`ID_ADHERENT`),
  KEY `ID_INVITE` (`ID_INVITE`),
  KEY `CRENEAU` (`CRENEAU`)
) ENGINE=InnoDB AUTO_INCREMENT=379 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `inscription`
--

INSERT INTO `inscription` (`ID`, `ID_ADHERENT`, `AUTO_PARTICIPATION`, `ID_INVITE`, `ID_ACTIVITE`, `CRENEAU`, `DATE_INSCRIPTION`, `DATE_PAIEMENT`, `MONTANT`, `DATE_DESINSCRIPTION`, `PAYE`, `ATTENTE`) VALUES
(150, 787, 1, NULL, 144, 1, '2021-07-08 00:00:00', '2021-07-23 00:00:00', 7, NULL, 1, 0),
(153, 849, 1, NULL, 146, 1, '2021-07-15 00:00:00', '2022-01-14 00:00:00', 22, NULL, 0, 0),
(154, 788, 1, NULL, 146, 1, '2021-07-15 00:00:00', '2022-01-14 00:00:00', 22, NULL, 0, 0),
(155, 732, 1, NULL, 146, 1, '2021-07-16 00:00:00', '2022-01-14 00:00:00', 11, NULL, 0, 0),
(156, 720, 1, NULL, 146, 1, '2021-07-16 00:00:00', '2022-01-14 00:00:00', 11, NULL, 0, 0),
(157, 673, 1, NULL, 146, 1, '2021-07-16 00:00:00', '2022-01-14 00:00:00', 11, NULL, 0, 0),
(158, 737, 1, NULL, 146, 1, '2021-07-16 00:00:00', '2022-01-14 00:00:00', 11, NULL, 0, 0),
(159, 788, 1, NULL, 144, 1, '2021-07-16 00:00:00', '2021-07-23 00:00:00', 7, NULL, 1, 0),
(160, 786, 1, NULL, 145, 1, '2021-07-16 00:00:00', '2021-08-24 00:00:00', 10, NULL, 1, 0),
(161, 786, 1, NULL, 146, 1, '2021-07-16 00:00:00', '2022-01-14 00:00:00', 22, NULL, 0, 0),
(162, 732, 1, NULL, 145, 1, '2021-07-16 00:00:00', '2022-01-14 00:00:00', 5, NULL, 0, 0),
(163, 720, 1, NULL, 145, 1, '2021-07-16 00:00:00', '2022-01-14 00:00:00', 5, NULL, 0, 0),
(166, 871, 1, NULL, 146, 1, '2021-07-16 00:00:00', '2022-01-14 00:00:00', 11, NULL, 0, 0),
(168, 867, 1, NULL, 144, 1, '2021-07-16 00:00:00', '2021-07-23 00:00:00', 7, NULL, 1, 0),
(169, 857, 1, NULL, 144, 1, '2021-07-16 00:00:00', '2021-07-23 00:00:00', 19, NULL, 1, 0),
(170, 906, 1, NULL, 144, 1, '2021-07-16 00:00:00', '2021-07-19 00:00:00', 7, NULL, 1, 0),
(171, 698, 1, NULL, 145, 1, '2021-07-17 00:00:00', '2022-01-14 00:00:00', 10, NULL, 0, 0),
(172, 844, 1, NULL, 144, 1, '2021-07-19 00:00:00', '2021-07-23 00:00:00', 7, NULL, 1, 0),
(173, 915, 1, NULL, 144, 1, '2021-07-19 00:00:00', '2021-07-23 00:00:00', 7, NULL, 1, 0),
(175, 868, 1, NULL, 146, 1, '2021-07-20 00:00:00', '2022-01-14 00:00:00', 11, NULL, 0, 0),
(176, 702, 1, NULL, 146, 1, '2021-07-20 00:00:00', '2022-01-14 00:00:00', 33, NULL, 0, 0),
(177, 801, 1, NULL, 145, 1, '2021-08-19 00:00:00', '2022-01-14 00:00:00', 5, NULL, 0, 0),
(178, 888, 1, NULL, 147, 1, '2021-09-10 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(179, 857, 1, NULL, 147, 1, '2021-09-10 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(180, 844, 1, NULL, 147, 1, '2021-09-10 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(181, 868, 1, NULL, 147, 1, '2021-09-10 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(182, 736, 1, NULL, 147, 1, '2021-09-11 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(183, 787, 0, NULL, 147, 1, '2021-09-14 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(185, 696, 1, NULL, 149, 1, '2021-09-17 00:00:00', '2021-10-21 00:00:00', 25, NULL, 1, 0),
(186, 699, 1, NULL, 150, 1, '2021-09-17 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(187, 699, 1, NULL, 149, 1, '2021-09-17 00:00:00', '2021-10-21 00:00:00', 50, NULL, 1, 0),
(188, 871, 1, NULL, 149, 1, '2021-09-17 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(189, 702, 1, NULL, 149, 1, '2021-09-17 00:00:00', '2021-10-21 00:00:00', 25, NULL, 1, 0),
(190, 859, 1, NULL, 149, 1, '2021-09-17 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(191, 884, 0, NULL, 150, 1, '2021-09-17 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(192, 807, 1, NULL, 149, 1, '2021-09-17 00:00:00', '2021-10-04 00:00:00', 25, NULL, 1, 0),
(193, 786, 1, NULL, 150, 1, '2021-09-17 00:00:00', '2021-09-27 00:00:00', 20, NULL, 1, 0),
(194, 849, 1, NULL, 149, 1, '2021-09-17 00:00:00', '2021-10-21 00:00:00', 50, NULL, 1, 0),
(195, 883, 1, NULL, 149, 1, '2021-09-17 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(196, 679, 1, NULL, 148, 1, '2021-09-17 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(197, 763, 1, NULL, 150, 1, '2021-09-17 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(198, 851, 1, NULL, 150, 1, '2021-09-17 00:00:00', '2021-09-27 00:00:00', 20, NULL, 1, 0),
(199, 707, 1, NULL, 148, 1, '2021-09-18 00:00:00', '2022-01-14 00:00:00', 20, NULL, 0, 0),
(200, 878, 1, NULL, 148, 1, '2021-09-18 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(201, 849, 1, NULL, 150, 1, '2021-09-20 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(202, 753, 1, NULL, 150, 1, '2021-09-20 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(203, 853, 1, NULL, 148, 1, '2021-09-20 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(204, 866, 0, NULL, 148, 1, '2021-09-21 00:00:00', '2022-01-14 00:00:00', 20, NULL, 0, 0),
(205, 718, 0, NULL, 150, 2, '2021-09-24 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(206, 867, 0, NULL, 150, 2, '2021-09-24 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(207, 840, 1, NULL, 150, 2, '2021-09-24 00:00:00', '2021-10-01 00:00:00', 20, NULL, 1, 0),
(208, 831, 1, NULL, 150, 2, '2021-09-24 00:00:00', '2021-10-01 00:00:00', 20, NULL, 1, 0),
(209, 871, 1, NULL, 150, 2, '2021-09-24 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(210, 810, 1, NULL, 150, 2, '2021-09-24 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(212, 805, 1, NULL, 150, 2, '2021-09-24 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(214, 739, 0, NULL, 150, 2, '2021-09-28 00:00:00', '2021-11-17 00:00:00', 20, NULL, 1, 0),
(217, 867, 1, NULL, 155, 1, '2021-10-14 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(218, 851, 1, NULL, 151, 1, '2021-10-14 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(219, 718, 1, NULL, 151, 1, '2021-10-14 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(221, 844, 1, NULL, 155, 1, '2021-10-14 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(222, 771, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2021-11-15 00:00:00', 24, NULL, 1, 0),
(223, 883, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(224, 696, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(225, 868, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2021-11-05 00:00:00', 24, NULL, 1, 0),
(226, 873, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(227, 687, 1, NULL, 151, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(229, 881, 1, NULL, 151, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(230, 881, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(231, 871, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(232, 776, 1, NULL, 151, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(233, 776, 1, NULL, 155, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 12, NULL, 0, 0),
(235, 698, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2021-11-15 00:00:00', 24, NULL, 1, 0),
(236, 709, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 48, NULL, 0, 0),
(237, 716, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2021-11-05 00:00:00', 24, NULL, 1, 0),
(238, 893, 1, NULL, 155, 1, '2021-10-15 00:00:00', '2022-01-14 00:00:00', 12, NULL, 0, 0),
(239, 893, 1, NULL, 154, 1, '2021-10-15 00:00:00', '2021-11-15 00:00:00', 24, NULL, 1, 0),
(240, 867, 1, NULL, 154, 1, '2021-10-17 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(241, 788, 1, NULL, 155, 1, '2021-10-18 00:00:00', '2022-01-14 00:00:00', 12, NULL, 0, 0),
(242, 763, 1, NULL, 154, 1, '2021-10-19 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(244, 787, 1, NULL, 154, 1, '2021-10-20 00:00:00', '2021-11-04 00:00:00', 24, NULL, 1, 0),
(245, 776, 1, NULL, 154, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(247, 720, 1, NULL, 152, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(248, 720, 1, NULL, 156, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 5, NULL, 0, 0),
(249, 732, 1, NULL, 156, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 5, NULL, 0, 0),
(250, 770, 1, NULL, 156, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 5, NULL, 0, 0),
(251, 925, 1, NULL, 156, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 10, NULL, 0, 0),
(253, 736, 1, NULL, 154, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(254, 685, 1, NULL, 153, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 28, NULL, 0, 0),
(255, 813, 1, NULL, 152, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(256, 883, 1, NULL, 156, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 5, NULL, 0, 0),
(257, 801, 1, NULL, 153, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 28, NULL, 0, 0),
(258, 788, 1, NULL, 152, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(259, 696, 1, NULL, 152, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(260, 734, 1, NULL, 152, 1, '2021-10-21 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(261, 834, 1, NULL, 156, 1, '2021-10-22 00:00:00', '2022-01-14 00:00:00', 20, NULL, 0, 0),
(262, 915, 1, NULL, 155, 1, '2021-10-22 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(263, 663, 1, NULL, 155, 1, '2021-10-22 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(264, 924, 1, NULL, 152, 1, '2021-10-22 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(265, 661, 1, NULL, 152, 1, '2021-10-22 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(266, 873, 1, NULL, 152, 1, '2021-10-25 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(267, 914, 1, NULL, 153, 1, '2021-10-26 00:00:00', '2022-01-14 00:00:00', 14, NULL, 0, 0),
(268, 914, 1, NULL, 152, 1, '2021-10-26 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(269, 660, 1, NULL, 152, 1, '2021-10-26 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(270, 776, 1, NULL, 156, 1, '2021-10-26 00:00:00', '2022-01-14 00:00:00', 15, NULL, 0, 0),
(271, 867, 1, NULL, 152, 1, '2021-10-28 00:00:00', '2022-01-14 00:00:00', 50, NULL, 0, 0),
(272, 920, 0, NULL, 156, 0, '2021-10-29 00:00:00', '2022-01-14 00:00:00', 0, NULL, 0, 0),
(273, 844, 1, NULL, 156, 1, '2021-10-29 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(274, 681, 1, NULL, 152, 1, '2021-11-03 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(275, 894, 1, NULL, 153, 1, '2021-11-03 00:00:00', '2022-01-14 00:00:00', 28, NULL, 0, 0),
(276, 894, 1, NULL, 156, 1, '2021-11-03 00:00:00', '2022-01-14 00:00:00', 10, NULL, 0, 0),
(277, 770, 1, NULL, 152, 1, '2021-11-03 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(278, 699, 1, NULL, 154, 1, '2021-11-04 00:00:00', '2021-11-15 00:00:00', 24, NULL, 1, 0),
(279, 756, 1, NULL, 152, 1, '2021-11-08 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(280, 893, 1, NULL, 152, 1, '2021-11-09 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(281, 906, 1, NULL, 152, 1, '2021-11-10 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(282, 883, 1, NULL, 158, 1, '2021-11-17 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(283, 849, 1, NULL, 158, 1, '2021-11-17 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(284, 906, 1, NULL, 154, 1, '2021-11-17 00:00:00', '2022-01-14 00:00:00', 24, NULL, 0, 0),
(285, 761, 1, NULL, 151, 1, '2021-11-19 00:00:00', '2022-01-14 00:00:00', 25, NULL, 0, 0),
(286, 720, 1, NULL, 158, 1, '2021-11-22 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(287, 770, 1, NULL, 158, 1, '2021-11-22 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(288, 761, 1, NULL, 157, 1, '2021-11-23 00:00:00', '2022-01-14 00:00:00', 32, NULL, 0, 0),
(289, 699, 1, NULL, 157, 1, '2021-11-23 00:00:00', '2022-01-14 00:00:00', 64, NULL, 0, 0),
(290, 707, 1, NULL, 157, 1, '2021-11-23 00:00:00', '2022-01-14 00:00:00', 32, NULL, 0, 0),
(291, 878, 1, NULL, 157, 1, '2021-11-23 00:00:00', '2022-01-14 00:00:00', 32, NULL, 0, 0),
(292, 821, 1, NULL, 158, 1, '2021-11-24 00:00:00', '2022-01-14 00:00:00', 60, NULL, 0, 0),
(294, 695, 1, NULL, 158, 1, '2021-11-24 00:00:00', '2021-11-29 00:00:00', 30, NULL, 1, 0),
(295, 881, 1, NULL, 158, 1, '2021-11-24 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(296, 688, 1, NULL, 157, 1, '2021-11-26 00:00:00', '2022-01-14 00:00:00', 64, NULL, 0, 0),
(297, 849, 0, NULL, 157, 1, '2021-11-26 00:00:00', '2022-01-14 00:00:00', 32, NULL, 0, 0),
(298, 696, 1, NULL, 157, 1, '2021-11-29 00:00:00', '2022-01-14 00:00:00', 32, NULL, 0, 0),
(299, 681, 1, NULL, 158, 1, '2021-11-30 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(300, 867, 0, NULL, 158, 1, '2021-11-30 00:00:00', '2022-01-14 00:00:00', 30, NULL, 0, 0),
(301, 787, 0, NULL, 159, 1, '2021-12-14 00:00:00', '2022-01-14 00:00:00', 15, NULL, 0, 0),
(302, 894, 0, NULL, 159, 1, '2021-12-15 00:00:00', '2022-01-14 00:00:00', 15, NULL, 0, 0),
(304, 931, 1, NULL, 160, 1, '2022-01-06 00:00:00', '2022-01-06 00:00:00', 28, NULL, 1, 0),
(305, 931, 1, NULL, 159, 1, '2022-01-10 00:00:00', NULL, 30, NULL, 0, 0),
(306, 931, 1, NULL, 161, 1, '2022-01-10 00:00:00', '2022-01-10 00:00:00', 102, NULL, 1, 0),
(307, 932, 1, NULL, 161, 1, '2022-01-10 00:00:00', '2022-01-10 00:00:00', 51, NULL, 1, 0),
(309, 932, 1, NULL, 160, 1, '2022-01-10 00:00:00', NULL, 15, NULL, 0, 0),
(310, 931, 1, NULL, 162, 1, '2022-01-10 00:00:00', NULL, 27, NULL, 0, 0),
(378, 931, 1, NULL, 163, 3, '2022-01-17 13:12:26', '2022-01-17 14:14:04', 14, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `invite`
--

DROP TABLE IF EXISTS `invite`;
CREATE TABLE IF NOT EXISTS `invite` (
  `ID_PERS_EXTERIEUR` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ADHERENT` int(11) NOT NULL,
  `NOM` char(32) DEFAULT NULL,
  `PRENOM` char(32) DEFAULT NULL,
  `STATUT` char(7) NOT NULL,
  `DATE_NAISSANCE` date DEFAULT NULL,
  `TELEPHONE` char(20) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`ID_PERS_EXTERIEUR`),
  KEY `I_FK_PERSONNE_EXTERIEUR_ADHERENT` (`ID_ADHERENT`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `invite`
--

INSERT INTO `invite` (`ID_PERS_EXTERIEUR`, `ID_ADHERENT`, `NOM`, `PRENOM`, `STATUT`, `DATE_NAISSANCE`, `TELEPHONE`) VALUES
(38, 867, 'SARTI', 'Sophie', 'FAMILLE', '1971-01-23', '686767103'),
(39, 801, 'Malet', 'Sandrine', 'FAMILLE', '1976-05-08', ':0623412369'),
(40, 731, 'Dutein', 'Alexandra', 'FAMILLE', '1975-11-18', ''),
(41, 731, 'Elie', 'Quentin', 'FAMILLE', '2013-02-25', ''),
(42, 687, 'Bobineau', 'Sophie', 'FAMILLE', '1976-08-19', '603312273'),
(43, 687, 'Bobineau', 'Chloe', 'FAMILLE', '2008-01-12', '664452414'),
(44, 687, 'Bobineau', 'ariane', 'FAMILLE', '2010-05-28', '664452414'),
(45, 687, 'Bobineau', 'clemence', 'FAMILLE', '2013-12-19', '664452414'),
(46, 734, 'FABRE', 'valerie', 'FAMILLE', '0000-00-00', '782919277'),
(47, 824, 'STEBLIN', 'PERRINE', 'FAMILLE', '1989-03-25', ''),
(48, 757, 'guilbon', 'chantal', 'FAMILLE', '1965-08-20', ''),
(49, 849, 'RENIMEL', 'Vincent', 'FAMILLE', '1970-01-06', '699925543'),
(50, 788, 'Latouche', 'Julien', 'FAMILLE', '1989-07-25', ''),
(51, 849, 'RENIMEL', 'Thomas', 'FAMILLE', '2005-10-11', '630297137'),
(52, 849, 'RENIMEL', 'Pierre', 'FAMILLE', '2002-08-08', '630297137'),
(53, 729, 'Delattre', 'Nathalie', 'FAMILLE', '1981-02-22', ':0608970289'),
(54, 718, 'REVILLON', 'Bélinda', 'FAMILLE', '1973-09-09', '06.20.30.12.66'),
(55, 718, 'CRESPEL', 'Mailys', 'FAMILLE', '2001-07-30', '06.20.30.12.66'),
(56, 718, 'CRESPEL', 'Maxence', 'FAMILLE', '2003-02-15', '06.20.30.12.66'),
(57, 868, 'SCHOENZETTER', 'Sara', 'FAMILLE', '2017-05-26', ''),
(58, 868, 'SCHOENZETTER', 'Adam', 'FAMILLE', '2019-03-21', ''),
(59, 868, 'SCHOENZETTER', 'Lamya', 'FAMILLE', '1984-12-23', ''),
(60, 786, 'SAVARY', 'Rémi', 'FAMILLE', '1983-05-13', '661775982'),
(61, 786, 'SAVARY', 'Raphaël', 'FAMILLE', '2011-09-02', '645739752'),
(62, 786, 'SAVARY', 'Arthur', 'FAMILLE', '2013-11-20', '645739752'),
(63, 771, 'KERGADALLAN', 'Aline', 'FAMILLE', '1963-02-18', '668947827'),
(64, 672, 'BEAUSSE', 'Johanne', 'FAMILLE', '1968-03-02', ''),
(65, 672, 'BEAUSSE', 'Adèkle', 'FAMILLE', '2002-02-25', ''),
(66, 672, 'BEAUSSE', 'Julia', 'FAMILLE', '2005-01-05', ''),
(69, 871, 'SOULAT', 'Mathis', 'FAMILLE', '2004-08-30', '669006453'),
(70, 871, 'SOULAT', 'Marius', 'FAMILLE', '2007-04-01', '775262153'),
(72, 857, 'SIEGEL', 'JESSICA', 'EXTERNE', '1987-01-23', ':'),
(73, 698, 'BRISOU', 'Christelle', 'FAMILLE', '1968-02-25', '614426869'),
(74, 698, 'BRISOU', 'Elise', 'FAMILLE', '2000-10-23', ''),
(75, 698, 'BRISOU', 'Malo', 'FAMILLE', '2003-09-29', ''),
(76, 763, 'Cabus', 'Laurence', 'FAMILLE', '1968-03-16', ''),
(77, 763, 'Humblet', 'Maëlle', 'FAMILLE', '1996-11-19', ''),
(78, 763, 'Humblet', 'Solenn', 'FAMILLE', '1999-06-12', ''),
(79, 844, 'Charruau', 'Joséphine', 'FAMILLE', '1991-05-01', ''),
(80, 702, 'CACHENAUD', 'Laurence', 'FAMILLE', '1971-06-09', ''),
(81, 702, 'CACHENAUD', 'Mathilde', 'FAMILLE', '2003-12-13', ''),
(83, 714, 'CORREC', 'Arthur', 'FAMILLE', '2010-12-24', ''),
(84, 714, 'CORREC', 'Maïlis', 'FAMILLE', '2012-12-11', ''),
(86, 878, 'TURELLE', 'Romain', 'FAMILLE', '2005-07-14', ''),
(87, 878, 'TURELLE', 'Anaïs', 'FAMILLE', '2010-01-05', ''),
(88, 707, 'VADROT CASTOLA', 'Alexis', 'FAMILLE', '2002-01-11', ''),
(89, 707, 'VADROT CASTOLA', 'Tristan', 'FAMILLE', '2004-10-27', ''),
(90, 888, 'SADYS', 'SYLVIE', 'FAMILLE', '1970-12-21', ''),
(92, 736, 'FANTACCINO', 'Aloys', 'FAMILLE', '2012-11-29', '663926242'),
(93, 787, 'MUSI', 'PAULINE', 'FAMILLE', '0000-00-00', '663805504'),
(94, 699, 'BROSSARD', 'NICOLAS', 'FAMILLE', '1973-01-08', '33787138016'),
(95, 699, 'BROSSARD', 'IGOR', 'FAMILLE', '2005-02-24', '33787138016'),
(96, 699, 'BROSSARD', 'KACPER', 'FAMILLE', '2002-01-07', '33787138016'),
(97, 859, 'Vouillon', 'Florence', 'FAMILLE', '1973-06-24', ''),
(98, 859, 'Roussely', 'Manon', 'FAMILLE', '2009-07-23', ''),
(99, 859, 'Roussely', 'Tom', 'FAMILLE', '2011-06-17', ''),
(100, 884, 'varin', 'laurence', 'FAMILLE', '1968-11-06', '669449927'),
(101, 884, 'varin', 'damien', 'FAMILLE', '2000-02-03', ''),
(102, 884, 'varin', 'clémence', 'FAMILLE', '2001-09-26', ''),
(103, 696, 'BECHERAS', 'Elodie', 'FAMILLE', '1979-05-20', '607826931'),
(104, 696, 'BRENEOL', 'Sarah', 'FAMILLE', '2014-11-17', ''),
(105, 696, 'BRENEOL', 'Thomas', 'FAMILLE', '2016-03-20', ''),
(106, 786, 'LE NOAN', 'Marine', 'EXTERNE', '1977-05-06', '645739752'),
(107, 679, 'BEQUIN', 'ARTHUR', 'FAMILLE', '2011-09-02', '678482226'),
(108, 679, 'BEQUIN', 'Célie', 'FAMILLE', '0000-00-00', '678482226'),
(109, 875, 'LAUDIGNON', 'Celine', 'FAMILLE', '1983-01-23', ''),
(110, 853, 'RIVIERE', 'Aude', 'FAMILLE', '1983-01-01', '623390790'),
(111, 853, 'RIVIERE', 'Elsa', 'FAMILLE', '2014-01-01', ''),
(112, 834, 'PENNETIER', 'MARYLISE', 'FAMILLE', '1983-06-27', ''),
(113, 834, 'PENNETIER', 'LOU', 'FAMILLE', '2012-04-22', ''),
(114, 834, 'PENNETIER', 'MILA', 'FAMILLE', '2015-08-17', ''),
(115, 925, 'Poux', 'Adrien', 'FAMILLE', '1992-04-29', ':662120841'),
(116, 925, 'Poux', 'Ethan', 'FAMILLE', '2019-03-07', '662120841'),
(118, 866, 'sophie', 'sarraillé-magné', 'FAMILLE', '1977-03-04', '630095937'),
(119, 866, 'sarraillé', 'juliette', 'FAMILLE', '2009-08-08', ''),
(120, 739, 'FLEURY', 'Sylvie', 'FAMILLE', '1971-08-23', '603921215'),
(121, 739, 'FLEURY', 'Nicolas', 'FAMILLE', '2005-12-09', ''),
(122, 921, 'L\'HOTELIER', 'Nathan', 'FAMILLE', '2015-10-17', ''),
(123, 921, 'DESTOMBES', 'Cécile', 'FAMILLE', '1980-12-08', ''),
(124, 725, 'deshayes', 'joelle', 'FAMILLE', '1971-11-22', ''),
(125, 725, 'deshayes', 'emeline', 'FAMILLE', '2011-05-09', ''),
(126, 725, 'deshayes', 'olivier', 'FAMILLE', '2013-07-10', ''),
(127, 840, 'BIGOT', 'Stephane', 'FAMILLE', '1975-06-12', '651367260'),
(128, 831, 'GARCIA', 'Stéphane', 'FAMILLE', '1974-02-21', '660983163'),
(129, 831, 'GARCIA', 'IBAN', 'FAMILLE', '2007-01-13', '660983163'),
(130, 860, 'Pensivy', 'Vanessa', 'FAMILLE', '1974-05-20', '667180029'),
(131, 810, 'MENAGER', 'MELANIE', 'FAMILLE', '1985-04-20', '698327587'),
(132, 678, 'Benoit-Leblanc', 'Angelique', 'FAMILLE', '1981-12-19', ''),
(133, 678, 'Benoit-Leblanc', 'Pauline', 'FAMILLE', '2015-12-21', ':'),
(134, 751, 'LAGNEAU', 'Cécile', 'EXTERNE', '1973-03-31', '682589175'),
(135, 881, 'Vandrot', 'Myriam', 'FAMILLE', '1978-08-22', ':0626314595'),
(136, 709, 'LEGRAND', 'Xavier', 'FAMILLE', '1974-03-07', ':0611148207'),
(137, 779, 'POITTEVIN', 'ISABELLE', 'FAMILLE', '1964-04-08', '667150108'),
(138, 920, 'DULUARD', 'SIMON', 'FAMILLE', '1981-02-06', '674036141'),
(140, 920, 'Duluard Bétizeau', 'Léonie', 'FAMILLE', '2020-01-03', ':'),
(141, 685, 'KONDYRA', 'Sandro', 'FAMILLE', '2011-02-22', ''),
(142, 685, 'KONDYRA', 'Julian', 'FAMILLE', '2016-02-28', ''),
(143, 685, 'KONDYRA', 'Emmanuel', 'FAMILLE', '1977-02-08', ''),
(144, 813, 'MEYER', 'Patrick', 'FAMILLE', '1967-05-19', '625417494'),
(145, 801, 'Malet', 'Camille', 'FAMILLE', '2008-11-06', ''),
(147, 663, 'JULIANNE-ROSE', 'AUBERTIN', 'FAMILLE', '2007-04-25', ''),
(148, 663, 'Aubertin', 'Oscar', 'FAMILLE', '2005-05-11', ''),
(149, 663, 'Goutard', 'Céline', 'FAMILLE', '1981-05-31', ''),
(150, 915, 'LE MILLOUR', 'Gladys', 'FAMILLE', '1991-01-17', ':0689549017'),
(151, 924, 'Courtiade', 'Marion', 'FAMILLE', '1986-04-07', ''),
(152, 661, 'ALLAIN', 'Claudine', 'FAMILLE', '1959-09-03', '617686793'),
(153, 776, 'Canton', 'Audrey', 'FAMILLE', '1981-01-30', '687155801'),
(154, 776, 'Lallemand', 'Bastien', 'FAMILLE', '2015-09-21', ''),
(155, 776, 'Lallemand', 'Zoé', 'FAMILLE', '2017-11-29', ''),
(157, 920, 'Duluard Bétizeau', 'Jeanne', 'FAMILLE', '2016-10-07', ''),
(158, 844, 'BETIZEAU', 'Aurélie', 'FAMILLE', '2000-01-01', ''),
(159, 844, 'BETIZEAU', 'Simon', 'FAMILLE', '2000-01-01', ''),
(160, 844, 'BETIZEAU', 'Jeanne', 'FAMILLE', '2000-01-01', ''),
(161, 894, 'ZANARY', 'Sarah', 'FAMILLE', '1980-01-20', ':0686921803'),
(162, 894, 'ZANARY', 'RITA', 'FAMILLE', '2015-05-23', ':0675094680'),
(163, 888, 'VERGONI', 'Emmy', 'FAMILLE', '2002-01-27', ''),
(164, 756, 'Nedau', 'Alex', 'FAMILLE', '1976-09-10', ''),
(165, 916, 'ELAN', 'VANIDA', 'FAMILLE', '1970-08-10', '33677057320'),
(166, 840, 'BIGOT', 'AMBROSIANA', 'FAMILLE', '1979-02-10', ''),
(167, 821, 'MOREAU', 'Virginie', 'FAMILLE', '1978-11-08', ''),
(168, 881, 'Vandrot', 'Tom', 'FAMILLE', '2003-05-15', ':'),
(169, 881, 'Vandrot', 'Tom', 'FAMILLE', '2003-05-15', ''),
(170, 688, 'BODESCOT', 'KATIA', 'FAMILLE', '1972-08-29', ''),
(171, 761, 'BIETRY', 'ELEONORE', 'FAMILLE', '1970-02-19', '615042966'),
(172, 931, 'Dez', 'AZE', 'FAMILLE', '2006-07-20', ''),
(173, 931, 'azeaze', 'azeaze', 'EXTERNE', '1992-01-09', ':654564812'),
(174, 931, 'aze', 'aze', 'FAMILLE', '2022-01-12', 'aze'),
(175, 934, 'oiu', 'oiu', 'FAMILLE', '1997-02-04', ':oiu'),
(176, 934, 'ghj', 'ghj', 'FAMILLE', '2000-02-09', ':ghj'),
(177, 932, 'aze2', 'aze2', 'FAMILLE', '1995-06-13', 'aze2'),
(178, 933, 'zer2', 'zer2', 'FAMILLE', '2000-01-20', 'zerzer');

-- --------------------------------------------------------

--
-- Structure de la table `liste_attente`
--

DROP TABLE IF EXISTS `liste_attente`;
CREATE TABLE IF NOT EXISTS `liste_attente` (
  `id_activite` int(11) NOT NULL,
  `creneau` int(11) NOT NULL,
  `id_adherent` int(11) NOT NULL,
  `date_inscription` datetime DEFAULT NULL,
  PRIMARY KEY (`id_activite`,`creneau`,`id_adherent`),
  KEY `fk_attente_creneau` (`creneau`),
  KEY `fk_attente_adherent` (`id_adherent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `liste_invites`
--

DROP TABLE IF EXISTS `liste_invites`;
CREATE TABLE IF NOT EXISTS `liste_invites` (
  `ID_INSCRIPTION` int(11) NOT NULL,
  `ID_INVITE` int(11) NOT NULL,
  PRIMARY KEY (`ID_INSCRIPTION`,`ID_INVITE`),
  KEY `ID_INVITE` (`ID_INVITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `liste_invites`
--

INSERT INTO `liste_invites` (`ID_INSCRIPTION`, `ID_INVITE`) VALUES
(206, 38),
(217, 38),
(271, 38),
(300, 38),
(153, 49),
(194, 49),
(297, 49),
(154, 50),
(205, 54),
(219, 54),
(181, 59),
(160, 60),
(161, 60),
(169, 72),
(171, 73),
(180, 79),
(221, 79),
(273, 79),
(176, 80),
(176, 81),
(200, 86),
(200, 87),
(199, 89),
(178, 90),
(182, 92),
(183, 93),
(301, 93),
(187, 94),
(289, 94),
(191, 100),
(259, 103),
(196, 107),
(196, 108),
(203, 110),
(203, 111),
(261, 112),
(261, 113),
(261, 114),
(251, 115),
(204, 118),
(204, 119),
(214, 120),
(229, 135),
(236, 136),
(254, 141),
(255, 144),
(257, 145),
(263, 149),
(262, 150),
(264, 151),
(270, 153),
(270, 154),
(273, 158),
(273, 159),
(273, 160),
(275, 161),
(302, 161),
(276, 162),
(292, 167),
(296, 170),
(304, 172),
(305, 172),
(310, 172),
(306, 173);

-- --------------------------------------------------------

--
-- Structure de la table `liste_option`
--

DROP TABLE IF EXISTS `liste_option`;
CREATE TABLE IF NOT EXISTS `liste_option` (
  `ID_INSCRIPTION` int(11) NOT NULL,
  `ID_OPTION` int(11) NOT NULL,
  `QTE_OPTION` int(11) NOT NULL,
  PRIMARY KEY (`ID_INSCRIPTION`,`ID_OPTION`),
  KEY `ID_OPTION` (`ID_OPTION`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `option_act`
--

DROP TABLE IF EXISTS `option_act`;
CREATE TABLE IF NOT EXISTS `option_act` (
  `ID_OPTION` int(11) NOT NULL AUTO_INCREMENT,
  `ID_ACTIVITE` int(11) NOT NULL,
  `LIBELLE` char(32) DEFAULT NULL,
  `PRIX` float DEFAULT NULL,
  PRIMARY KEY (`ID_OPTION`),
  KEY `IND_ACT` (`ID_ACTIVITE`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `prestataire`
--

DROP TABLE IF EXISTS `prestataire`;
CREATE TABLE IF NOT EXISTS `prestataire` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NOM` varchar(45) NOT NULL,
  `MAIL` varchar(45) NOT NULL,
  `TEL` varchar(45) NOT NULL,
  `ADRESSE` varchar(45) NOT NULL,
  `CP` varchar(5) NOT NULL,
  `VILLE` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `tel_UNIQUE` (`TEL`),
  UNIQUE KEY `mail_UNIQUE` (`MAIL`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `prestataire`
--

INSERT INTO `prestataire` (`ID`, `NOM`, `MAIL`, `TEL`, `ADRESSE`, `CP`, `VILLE`) VALUES
(15, 'Aunis Karting', 'kartouest@wanadoo.fr', ':05 46 00 41 70', 'ZI DU FIEF GIRARD 17290 LE THOU', '17290', 'le thou'),
(16, 'Centre Nautique d\'Angoulins', 'cnangoulins@gmail.com', ':05 46 56 89 73 ', 'Chemin de la Platere,', '17690', 'Angoulins '),
(17, 'Pont transbordeur', '', ':', '', '17300', 'Rochefort'),
(18, 'Fumoir d\'angoulins', 'claire@fumoir-angoulins.fr', ':06.52.22.55.62', 'Marais du Chay', '17690', 'Angoulins-sur-Mer'),
(19, 'aérodrome Rochefort', 'na', ':05 46 83 05 20', ' La Sauzaie', '17620', 'Saint-Agnant'),
(20, 'VIN SUR TABLE', 'cstlagord@gmail.com', ':0546671998', 'ZAC DE LA VALLEE - avenue du Fief Rose', '17140', 'LAGORD'),
(21, 'Nature environnement 17', 'n.environnement17@wanadoo.fr', ':05 46 41 39 04', '2 av. Saint Pierre', '17700', 'Surgères'),
(22, 'Atelier a la Carte', 'info@atelieralacarte.com', ':06 52 57 52 27', '3 bis Rue des Cloutiers ', '17000', 'La Rochelle'),
(25, 'L\'ATELIER GOURMAND', 'larochelle@atelier-gourmand.fr', ':0679361598', '9 rue Lavoisier', '17440', 'AYTRE'),
(26, 'Farol', 'delphine@farol.fr', ':0546505305', '1 rue Québec', '17000', 'La Rochelle'),
(27, 'Escape Yourself', 'larochelle@escapeyourself.fr', ':05 16 85 37 93', '114 rue des Gonthières', '17000', 'La Rochelle'),
(28, 'Anne-Marie Champi', 'anne-marie.pourty@orange.fr', ':0607615811', '153 rue des Romans', '49400', 'Saumur'),
(29, 'Savonnerie En bullant', 'savonenbullant@gmail.com', ':07.68.52.30.65', '11 rue Paul Bert ', '17300', 'Rochefort');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `activite`
--
ALTER TABLE `activite`
  ADD CONSTRAINT `ACTIVITE_ibfk_1` FOREIGN KEY (`ID_PRESTATAIRE`) REFERENCES `prestataire` (`ID`),
  ADD CONSTRAINT `ACTIVITE_ibfk_2` FOREIGN KEY (`ID_LEADER`) REFERENCES `adherent` (`ID_ADHERENT`),
  ADD CONSTRAINT `FK_ACTIVITE_DOMAINE_ACTIVITE` FOREIGN KEY (`ID_DOMAINE`) REFERENCES `domaine_activite` (`ID_DOMAINE`);

--
-- Contraintes pour la table `creneau`
--
ALTER TABLE `creneau`
  ADD CONSTRAINT `CRENEAU_ibfk_1` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE;

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `INSCRIPTION_ibfk_1` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`) ON DELETE CASCADE,
  ADD CONSTRAINT `INSCRIPTION_ibfk_2` FOREIGN KEY (`ID_ADHERENT`) REFERENCES `adherent` (`ID_ADHERENT`),
  ADD CONSTRAINT `INSCRIPTION_ibfk_3` FOREIGN KEY (`ID_INVITE`) REFERENCES `liste_invites` (`ID_INVITE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `invite`
--
ALTER TABLE `invite`
  ADD CONSTRAINT `INVITE_ibfk_1` FOREIGN KEY (`ID_ADHERENT`) REFERENCES `adherent` (`ID_ADHERENT`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `liste_invites`
--
ALTER TABLE `liste_invites`
  ADD CONSTRAINT `LISTE_INVITES_ibfk_1` FOREIGN KEY (`ID_INSCRIPTION`) REFERENCES `inscription` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `LISTE_INVITES_ibfk_2` FOREIGN KEY (`ID_INVITE`) REFERENCES `invite` (`ID_PERS_EXTERIEUR`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `liste_option`
--
ALTER TABLE `liste_option`
  ADD CONSTRAINT `LISTE_OPTION_ibfk_1` FOREIGN KEY (`ID_INSCRIPTION`) REFERENCES `inscription` (`ID`),
  ADD CONSTRAINT `LISTE_OPTION_ibfk_2` FOREIGN KEY (`ID_OPTION`) REFERENCES `option_act` (`ID_OPTION`);

--
-- Contraintes pour la table `option_act`
--
ALTER TABLE `option_act`
  ADD CONSTRAINT `OPTION_ACT_ibfk_1` FOREIGN KEY (`ID_ACTIVITE`) REFERENCES `activite` (`ID_ACTIVITE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
