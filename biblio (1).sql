-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 29 avr. 2025 à 22:00
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `biblio`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `type`, `description`) VALUES
(1, 'Mathématiques', 'universitaire', 'Livres sur les mathématiques pures et appliquées'),
(2, 'informatique', '', ''),
(3, 'Economie', '', ''),
(4, 'Biologie', '', ''),
(5, 'Astronomie et Astrophysique', '', ''),
(6, 'Chimie', '', '');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

DROP TABLE IF EXISTS `commentaires`;
CREATE TABLE IF NOT EXISTS `commentaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `livre_id` int NOT NULL,
  `utilisateur_id` int NOT NULL,
  `nom_utilisateur` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `livre_id` (`livre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `favoris`
--

DROP TABLE IF EXISTS `favoris`;
CREATE TABLE IF NOT EXISTS `favoris` (
  `user_id` int NOT NULL,
  `livre_id` int NOT NULL,
  `date_ajout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `note` int NOT NULL,
  KEY `fk_favoris_livre` (`livre_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

DROP TABLE IF EXISTS `livre`;
CREATE TABLE IF NOT EXISTS `livre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `auteur` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_ajout` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `categories_id` int DEFAULT NULL,
  `mots_cles` text NOT NULL,
  `fichier_pdf` varchar(255) NOT NULL,
  `annee_publication` int NOT NULL,
  `nombre_pages` int NOT NULL,
  `status` enum('disponible','attente') NOT NULL,
  `id_utilisateur` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_id` (`categories_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`id`, `titre`, `auteur`, `description`, `image`, `date_ajout`, `categories_id`, `mots_cles`, `fichier_pdf`, `annee_publication`, `nombre_pages`, `status`, `id_utilisateur`) VALUES
(1, 'Programmation Python', 'Alice Martin', 'Si le livre suit un schéma classique, il aborderait probablement :\r\n\r\nLes bases de Python (syntaxe, types de données, boucles, fonctions).\r\n\r\nLes structures avancées (listes, dictionnaires, compréhensions).\r\n\r\nLa programmation orientée objet (classes, héritage).\r\n\r\nLa gestion des fichiers et modules.\r\n\r\nDes exemples pratiques (scripts, manipulation de données).', 'math1.jfif', '2025-04-25 04:36:27', 1, 'python, programmation', 'IntroProgrammationPython22.pdf', 2023, 400, 'disponible', NULL),
(2, 'Sécurité informatique: principes et méthodes', 'Laurent Bloch, Christophe Wolfhugel', 'Comprendre les menaces informatiques pour les juguler : l\'administrateur et le responsable informatique affrontent une insécurité informatique protéiforme et envahissante, qui menace tant les données que les applications de l\'entreprise virus, attaques par le réseau, tromperie sur, le Web, etc. Bien des outils sont proposés pour y faire face, mais encore faut-il comprendre leur rôle et leur mode opératoire et les replacer dans le cadre d\'une politique de sécurité efficace. On devra pour cela garder en tête les principes qui animent tout système d\'information et chasser de dangereuses idées reçues. Une approche systématique de la sécurité informatique : écrit par le responsable de la sécurité des systèmes d\'information de l\'INSERM, ce livre limpide expose les causes des risques inhérents à tout système informatique - et les moyens de s\'en protéger. S\'adressant aux administrateurs et responsables de systèmes d\'informations comme à leurs interlocuteurs, il offre au professionnel consciencieux des principes clairs et une méthode rigoureuse pour concevoir une véritable politique de sécurité. A qui s\'adresse cet ouvrage ? aux administrateurs de systèmes et de réseaux, mais aussi aux DSI et aux responsables de projets, à tous ceux qui doivent concevoir ou simplement comprendre une politique de sécurité informatique.', 'info1.jfif', '2025-04-28 21:35:39', 2, 'informatique,Sécurité ,méthodes', 'rss1.pdf', 2006, 261, 'disponible', NULL),
(3, 'Les réseaux', 'Guy Pujolle', 'La référence des professionnels et des étudiants en réseaux et télécoms\r\nRéédition au format semi-poche de la 5e édition du classique \"Les Réseaux\" de Guy Pujolle, qui s\'est imposé, avec plus de 90 000 exemplaires vendus, comme la référence en langue française en matière de réseaux et télécoms, aussi bien auprès des professionnels que des étudiants.\r\n\r\nCette 5e édition témoigne des évolutions rapides des technologies et des usages, avec la domination plus forte que jamais d\'IP et d\'Ethernet, les nouvelles générations de réseaux optiques et de réseaux MPLS et GMPLS, révolution de la normalisation et des usages en matière de câblage, la course aux hauts débits dans les réseaux sans fil, avec les évolutions de Wi-Fi, l\'apparition de nouvelles technologies WPAN (UWB/WiMedia, ZigBee) et l\'entrée en scène de la boucle locale hertzienne (WiMaxi, l\'importance de la qualité de service et l\'émergence de la gestion par politique, l\'attention accrue portée à la sécurité, en particulier dans le monde IP et dans l\'univers du sans fil (802.1 1i), etc.', 'info2.jfif', '2025-04-28 21:43:33', 2, 'réseaux', 'rss2.pdf', 2006, 1122, 'disponible', NULL),
(4, 'Informatique et sciences du numérique', 'Gilles Dowek', 'Enfin un véritable manuel d\'informatique pour les lycéens et leurs professeurs !\r\n\r\nLes quatre concepts de machine, d\'information, d\'algorithme et de langage sont au coeur de l\'informatique, et l\'objet de ce cours est de montrer comment ils fonctionnent ensemble. En première partie, nous apprendrons à écrire des programmes, en découvrant les ingrédients qui les constituent : l\'affectation, la séquence et le test, les boucles, les types, les fonctions et les fonctions récursives. Dans la deuxième partie, on verra comment représenter les informations que l\'on veut communiquer, les stocker et les transformer - textes, nombres, images et sons. On apprendra également à structurer et compresser de grandes quantités d\'informations, à les protéger par le chiffrement. On verra ensuite que derrière les informations, il y a toujours des objets matériels : ordinateurs, réseaux, robots, etc., qui font partie de notre quotidien. Enfin, on s\'initiera à des savoir-faire utiles au XXIe siècle : ajouter des nombres exprimés en base deux, dessiner, retrouver une information par dichotomie, trier des informations et parcourir des graphes.', 'info3.jfif', '2025-04-28 21:50:28', 2, 'informatique', 'rss3.pdf', 2013, 312, 'disponible', NULL),
(5, ' Mathématiques Méthodes et exercices ', ' Arnaud Bégyn,Guillaume Connan\r\n', 'Les « Méthodes et Exercices » J’intègre vous proposent une synthèse des méthodes à connaître et, pour chacune, des exercices entièrement corrigés pour vous entraîner.\r\nToutes les méthodes à connaître\r\n• Par thème du programme, les méthodes vous sont présentées avec le détail des étapes.\r\n• Chaque méthode renvoie à plusieurs exercices d’application.\r\nDe nombreux énoncés d’exercices\r\n• Les exercices d’application sont triés par difficulté.\r\n• Ils couvrent l’intégralité du programme de BCPST 2e année.\r\nUn accompagnement pédagogique\r\n• Des indications « pour bien démarrer » vous donnent un coup de pouce si vous avez du mal à résoudre un exercice.\r\n• Tous les exercices sont corrigés avec une rédaction complète.\r\n', 'math2.jpg', '2025-04-28 22:14:49', 1, 'Mathématiques, Méthodes , exercices ', 'mat1.pdf', 2018, 314, 'disponible', NULL),
(6, 'Probabilité ', 'Philippe Barbé, Michel Ledoux', 'Ce livre est destiné à des étudiants de 3e année de licence de mathématiques\r\nayant suivi un cours de base de mesure et intégration, dont les éléments fondamentaux sont toutefois rappelés dans les deux premiers chapitres. Il ne suppose pas une connaissance préalable des notions de probabilités enseignées d’ordinaire dans les deux premières années de licence et habituellement axés sur les probabilités discrètes et les problèmes de combinatoire dont il n’est fait que très peu\r\nétat dans cet ouvrage. Ce livre peut être utilisé comme support d’un cours de\r\nprobabilité de L3, ou d’un premier semestre de master. Cet ouvrage contient en\r\noutre les prérequis nécessaires à l’épreuve écrite de mathématiques générales pour\r\nl’agrégation ainsi que pour les leçons spécialisées. Chaque chapitre est complété\r\npar une série d’exercices destinés à approfondir et à illustrer les éléments de la\r\nthéorie venant d’être introduits.', 'math3.jpg', '2025-04-28 22:28:17', 1, 'Probabilité ,math', 'mat2.pdf', 2018, 254, 'disponible', NULL),
(7, ' Finance d\'entreprise', 'Georges Legros', 'L’analyse financière est une façon de transcrire la réalité économique\r\nde l’entreprise en un langage universel permettant le développement\r\nd’outils de suivi de l’activité.\r\nPour maîtriser ces outils, il importe de définir certains des concepts sur\r\nlesquels se basent les techniques financières.\r\nEn partant de l’activité économique pour aller vers les outils de la finance\r\nd’entreprise, on peut distinguer trois étapes principales : la décomposition\r\ndes flux dans l’entreprise, la transcription de ces flux dans les\r\ndocuments comptables et l’analyse de ces flux.', 'ec1.jpg', '2025-04-28 22:47:39', 3, 'Finance , entreprise', 'ecc.pdf', 2010, 224, 'disponible', NULL),
(8, ' Le lapin, De la biologie à l\'élevage ', 'Thierry Gidenne', '\r\nLe lapin: De la biologie à l\'élevage on amazoncom free shipping\r\nLa cuniculture, ou élevage du lapin, se développe au niveau mondial, particulièrement en Asie, mais aussi en Afrique. Animal de rente (viande, toison, fourrure) ou de compagnie, le lapin fait également l’objet d’un intérêt scientifique croissant, cette espèce étant utilisée comme modèle d’étude dans des disciplines diverses (génétique, physiologie, éthologie, neurosciences, médecine, etc.).\r\n\r\nPremier manuel spécifiquement consacré à la biologie cunicole, cet ouvrage raconte l’histoire du lapin domestique et synthétise les connaissances actuelles. Sont d’abord décrits l’anatomie, la physiologie et la reproduction, puis le comportement, la nutrition, ainsi que les différentes pathologies. Les races et la génétique cunicole sont ensuite présentées.\r\nCet ouvrage apporte également des recommandations concrètes de pratiques d’élevage cunicole, tant pour l’élevage familial que professionnel, ou encore pour le lapin de compagnie. La rédaction a été assurée, dans chaque domaine, par un collège de chercheurs, d’enseignants et de professionnels, dont les compétences et l’expertise sont reconnues.\r\nDestiné aux professionnels comme aux amateurs éclairés, ainsi qu’aux enseignants, étudiants et scientifiques, il permettra aux lecteurs de comprendre comment la biologie de cet animal module les techniques de l’élevage cunicole.\r\n ', 'bio1.PNG', '2025-04-28 22:57:04', 4, 'biologie ,Le lapin', 'bi1.pdf', 2015, 291, 'disponible', NULL),
(9, 'Principes des méthodes d\'analyse biochimique', 'tom', '\r\nCette nouvelle édition entièrement réactualisée et complétée apportera au technicien biochimiste la connaissance des concepts scientifiques qui lui permettront de comprendre les analyses qu\'il pratique et les appareils qu\'il utilise. Complet, ce livre a été écrit par un physicien et deux biochimistes, de façon à recouvrir des aspects physicochimiques et biologiques de l\'analyse biochimique. Simple, il aidera à la préparation aux examens : Baccalauréat technologique F7 et F7\', classe préparatoire TB\', BTS d\'analyse biologique, biochimie et biotechnologie, ainsi qu\'au DUT de biologie appliquée. ', 'bio2.PNG', '2025-04-28 23:08:59', 4, 'biochimique', 'bi2.pdf', 2010, 187, 'disponible', NULL),
(10, 'Initiation à la Cosmologie ', 'Marc Lachièze-Rey', 'A la croisée de l\'astrophysique et de la physique des particules, la cosmologie offre une connaissance de plus en plus riche de l\'Univers et de son origine.\r\nCet ouvrage est volontairement synthétique. A partir de quelques principes de base, il élabore des raisonnements physiques et mathématiques, simples mais rigoureux, qui permettent d\'élaborer des modèles d\'Univers (infini, fini, courbe...) . Cette cinquième édition est une actualisation globale de l\'ouvrage, rendue nécessaire car la cosmologie est un domaine où les découvertes et les interprétations sur les processus d\'organisation de l\'Univers foisonnent.\r\nBiographie de l\'auteur:\r\nDirecteur de recherche au CNRS, laboratoire Astroparticules et Cosmologie, auteur de nombreux ouvrages de vulgarisation.', 'str.jpg', '2025-04-29 00:11:59', 5, 'Astronomie ', 'sc.pdf', 2013, 161, 'disponible', NULL),
(11, 'Energie, électricite et nucléaire', 'Gilbert Naudet, Paul Reuss ', 'Au sein du Commissariat à l’énergie atomique (CEA), l’Institut national des sciences et techniques nucléaires (INSTN) est un établissement d’enseignement supérieur sous la tutelle du ministère de l’Éducation nationale et du ministère de l’Industrie. La mission de l’INSTN est de contribuer à la diffusion des savoir-faire du CEA au travers d’enseignements spécialisés et de formations continues, tant à l’échelon national, qu’aux plans européen et international.\r\nCette mission reste centrée sur le nucléaire, avec notamment l’organisation d’une formation d’ingénieur en « Génie Atomique ». Fort de l’intérêt que porte le CEA au développement de ses collaborations avec les universités et les écoles d’ingénieurs, l’INSTN a développé des liens avec des établissements d’enseignement supérieur aboutissant à l’organisation, en co-habilitation, de plus d’une vingtaine de Masters. À ces formations s’ajoutent les enseignements des disciplines de santé : les spécialisations en médecine nucléaire et en radiopharmacie ainsi qu’une formation destinée aux physiciens d’hôpitaux.\r\nLa formation continue constitue un autre volet important des activités de l’INSTN, lequel s’appuie aussi sur les compétences développées au sein du CEA et chez ses partenaires industriels.', 'che1.jpg', '2025-04-29 00:28:32', 6, 'Energie , électricite ', 'chh1.pdf', 2014, 445, 'disponible', NULL),
(12, ' Mécanique quantique. 2, Développements et applications à basse énergie', 'Claude Aslangul', 'Dans le même état d\'esprit que le premier tome, on y développe le formalisme dans des situations plus complexes, s\'appuyant sur des considérations physiques et expliquant les concepts dans un langage aussi intuitif et accessible que possible. L\'arsenal de mathématiques appliquées nécessaire à la \'maîtrise du sujet est développé au fur et à mesure, belle occasion d\'introduire quelques outils indispensables au physicien, quelle que soit sa spécialité.\r\n\r\nLa première partie s\'appuie notamment sur la notion de symétrie. La théorie du moment cinétique et le champ central sont exposés. L\'introduction du spin est faite sur des bases physiques, conduisant à l\'équation de Dirac et à sa discussion. Les postulats quantiques sont ensuite revisités à la lumière d\'expériences récentes, permettant de revenir sur les étrangetés quantiques (intrication), la décohérence et des applications surprenantes (cryptographie). Après l\'exposé. des principes des méthodes perturbatives et variationnelles, les bases de la quantification du rayonnement sont expliquées. Cette partie se termine par une introduction à la théorie des collisions.\r\n\r\nLa deuxième partie propose quelques applications, délibérément restreintes à la physique de basse énergie, où on s\'efforce de montrer l\'universalité des concepts quantiques dans des champs aussi variés que la physique atomique, la chimie et la physique des solides, des, permettant de mettre en lumière l\'immense pouvoir explicatif et les innombrables succès de la théorie quantique.\r\n', 'sc.jpg', '2025-04-29 00:41:43', 6, 'Mécanique quantique', 'lis.pdf', 2008, 1557, 'disponible', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','user','mod') DEFAULT 'user',
  `date_inscription` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `livre_id` FOREIGN KEY (`livre_id`) REFERENCES `commentaires` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `favoris`
--
ALTER TABLE `favoris`
  ADD CONSTRAINT `fk_favoris_livre` FOREIGN KEY (`livre_id`) REFERENCES `livre` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `categories_id` FOREIGN KEY (`categories_id`) REFERENCES `livre` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
