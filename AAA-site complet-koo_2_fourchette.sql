-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le : Mar 06 Mai 2023 à 05:22
-- Version du serveur: 8.2.1
-- Version de PHP: 8.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `koo_2_fourchette`
--
-- DROP DATABASE `koo_2_fourchette`;
CREATE DATABASE IF NOT EXISTS `koo_2_fourchette` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `koo_2_fourchette`;
-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `idCategorie` smallint(6) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`idCategorie`, `nom`) VALUES
(1, 'viande'),
(2, 'lÃ©gume'),
(3, 'poisson'),
(4, 'fruit');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE IF NOT EXISTS `membres` (
  `idMembre` int(11) NOT NULL AUTO_INCREMENT,
  `gravatar` varchar(100) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `statut` varchar(20) NOT NULL,
  `prenom` varchar(50) NOT NULL,+.
  
  `nom` varchar(50) NOT NULL,
  `dateCrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idMembre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`idMembre`, `gravatar`, `login`, `password`, `statut`, `prenom`, `nom`, `dateCrea`) VALUES
(1, 'natha.png', 'natha', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'nathalie', 'Martin', '2023-05-06 02:15:57'),
(2, 'sylvie.png', 'syl92', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'sylvie', 'Dubois', '2023-05-06 02:15:57'),
(3, 'lucie.png', 'luce18', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'lucie', 'Mantis', '2023-05-06 02:18:13'),
(4, 'laurence.png', 'laulie', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'laurence', 'Expert', '2023-05-06 02:18:13'),
(5, 'annie.png', 'ann75', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'annie', 'Frennic', '2023-05-06 02:20:33'),
(6, 'laure.png', 'lolo', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'laure', 'Astien', '2023-05-06 02:20:33'),
(7, 'didier.png', 'did93', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'didier', 'Eleg', '2023-05-06 02:22:18'),
(8, 'manu.png', 'man', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'manu', 'Bientre', '2023-05-06 02:22:18'),
(9, 'michel.png', 'mimiche', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'michel', 'Maluran', '2023-05-06 02:24:09'),
(10, 'lydia.png', 'lili', '0b9c2625dc21ef05f6ad4ddf47c5f203837aa32c', 'membre', 'lydia', 'Mantour', '2023-05-06 02:24:09');

-- --------------------------------------------------------

--
-- Structure de la table `recettes`
--

CREATE TABLE IF NOT EXISTS `recettes` (
  `idRecette` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(250) NOT NULL,
  `chapo` text NOT NULL,
  `img` varchar(50) NOT NULL,
  `preparation` text NOT NULL,
  `ingredient` text NOT NULL,
  `membre` int(11) NOT NULL,
  `couleur` varchar(30) NOT NULL,
  `dateCrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `categorie` int(11) NOT NULL,
  `tempsCuisson` varchar(50) NOT NULL,
  `tempsPreparation` varchar(50) NOT NULL,
  `difficulte` varchar(50) NOT NULL,
  `prix` varchar(50) NOT NULL,
  PRIMARY KEY (`idRecette`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Contenu de la table `recettes`
--

INSERT INTO `recettes` (`idRecette`, `titre`, `chapo`, `img`, `preparation`, `ingredient`, `membre`, `couleur`, `dateCrea`, `categorie`, `tempsCuisson`, `tempsPreparation`, `difficulte`, `prix`) VALUES
(2, 'Carottes glacÃ©es Ã  l''orange', 'Vous ne connaissiez pas le mariage de la carotte et de l''orange ? Alors permettez-nous de vous donner l''eau Ã  la bouche avec cette recette de carottes glacÃ©es, acidulÃ©es et lÃ©gÃ¨rement sucrÃ©es qui donnera du peps Ã  votre repas du jour !', 'carottes-glacees-orange.jpg', '<ol>\r\n<li>1\r\nCoupez les carottes en rondelles de 3 mm. Faites sauter les carottes doucement, 2 Ã  3 minutes dans une sauteuse au beurre.</li>\r\n<li>2\r\nDÃ©glacez avec un mÃ©lange de jus d''orange et d''eau. Recouvrez Ã  ras. Ajoutez le cumin, le sucre, sel et poivre. Laissez mijoter jusqu''Ã  absorption du jus et glaÃ§age des rondelles.</li>\r\n<ol>', '<ul>\r\n<li>1 kg de carottes</li>\r\n<li>Â½ l d''eau</li>\r\n<li>2 pincÃ©es de sucre</li>\r\n<li>Â½ jus d''orange</li>\r\n<li>1 pincÃ©e de cumin</li>\r\n<li>beurre</li>\r\n<li>sel, poivre</li>\r\n</ul>', 1, 'fushia', '2023-05-06 03:20:12', 2, '10 min', '15 min', 'Facile', 'Pas cher'),
(3, 'Penne aux petits lÃ©gumes', 'Qu''on se le dise, cette recette convient aux petits comme aux plus grands ! En accompagnant les pÃ¢tes de bons lÃ©gumes nouveaux, de quelques bÃ¢tonnets de jambon mais aussi d''une sauce fondante au parmesan, vous allez crÃ©er le coup de cÅ“ur !', 'penne-aux-petits-legumes.jpg', '<ol>\r\n<li>1\r\nÃ‰pluchez les carottes et coupez-les en bÃ¢tonnets. Coupez le jambon en bÃ¢tonnets Ã©galement. Ã‰cossez les petits pois.\r\n<li>2\r\nPortez 2 l d''eau salÃ©e Ã  Ã©bullition, ajoutez le bouillon et faites cuire les lÃ©gumes pendant 10 min. Ã‰gouttez-les. RÃ©servez 10 cl d''eau de cuisson. Salez et faites cuire les pÃ¢tes dans le bouillon restant aprÃ¨s l''avoir allongÃ© d''eau. Ã‰gouttez bien et mÃ©langez avec les lÃ©gumes.</li>\r\n<li>3\r\nChauffez l''eau de cuisson rÃ©servÃ©e. Ajoutez en fouettant le beurre coupÃ© en petits morceaux et le parmesan. Versez cette sauce sur les pÃ¢tes. MÃ©langez et servez.\r\n</li>\r\n<ol>', '<ul>\r\n<li>400 g de pÃ¢tes (type pennes)</li>\r\n<li>1 cube de bouillon de volaille</li>\r\n<li>50 g de parmesan rÃ¢pÃ©</li>\r\n<li>2 carottes</li>\r\n<li>150 g de petits pois nouveaux (des surgelÃ©s conviennent aussi)</li>\r\n<li>400 g de jambon</li>\r\n<li>100 g de beurre</li>\r\n<li>sel, poivre</li>\r\n</ul>', 2, 'bleuClair', '2023-05-06 03:21:46', 2, '10 min', '15 min', 'Facile', 'Pas cher'),
(4, 'Risotto de poulet aux carottes', 'Ce risotto est la douceur incarnÃ©e. Avec son bon goÃ»t de carottes et de navets, il met Ã  l''honneur les lÃ©gumes de printemps ! Ajoutez quelques morceaux de poulet pour un plat complet que vos gourmands vont souvent rÃ©clamer !', 'risotto-poulet-carottes.jpg', '<ol>\r\n<li>1\r\nCoupez le poulet en petits morceaux et faites-les revenir dans une poÃªle chauffÃ©e et huilÃ©e.\r\n</li>\r\n<li>\r\n2\r\nPendant ce temps, pelez l''oignon, puis coupez-le en petits morceaux.\r\n</li>\r\n<li>\r\n3\r\nÃ‰pluchez les carottes et taillez-les en cubes ainsi que les navets.\r\n</li>\r\n<li>\r\n4\r\nIncorporez l''oignon Ã©mincÃ©, les navets et les carottes au poulet dorÃ©, puis faites-les sauter pour que les oignons soient transparents.\r\n</li>\r\n<li>\r\n5\r\nVersez dans la poÃªle 1 litre d''eau pour recouvrir le poulet, rÃ©duisez les cubes de bouillons en miettes puis ajoutez-les Ã  la prÃ©paration.\r\n</li>\r\n<li>\r\n6\r\nSalez, poivrez, remuez le tout et laissez frÃ©mir tout en goÃ»tant le bouillon de volaille de temps en temps.\r\n</li>\r\n<li>\r\n7\r\nMettez le riz dans un plat Ã  gratiner et versez-y ensuite, le bouillon avec les carottes, les navets et les oignons sautÃ©s. Ainsi que le poulet.\r\n</li>\r\n<li>\r\n8\r\nEnfournez le tout Ã  th. 7(210Â°C) et laissez cuire le temps indiquÃ© sur l''emballage du riz.\r\n</li>\r\n<li>\r\n9\r\nRemuez rÃ©guliÃ¨rement pour Ã©viter que votre prÃ©paration brÃ»le et retirez dÃ¨s que le riz sera cuit.\r\n</li>\r\n<ol>', '<ul>\r\n<li>300 g de riz</li>\r\n<li>3 filets de poulet</li>\r\n<li>4 carottes nouvelles</li>\r\n<li>2 navets nouveaux</li>\r\n<li>1 oignon</li>\r\n<li>3 cubes de bouillon de volaille</li>\r\n<li>huile</li>\r\n<li>eau</li>\r\n<li>sel, poivre</li>\r\n</ul>', 3, 'vertClair', '2023-05-06 02:40:39', 1, '30 min', '15 min', 'Facile', 'Pas cher'),
(5, 'Pain de viande aux lÃ©gumes', 'Cette recette de pain de viande est complÃ¨te ! En plus d''y trouver de la viande hachÃ©e, vous ne pourrez qu''apprÃ©cier les morceaux de carottes et de poivrons qui mettront du soleil dans votre assiette ! C''est original et c''est surtout un dÃ©lice, alors lancez-vous !', 'pain-viande-legume.jpg', '<ol>\r\n<li>1\r\nPrÃ©chauffez votre four th.6 (180Â°C).\r\n</li>\r\n<li>\r\n2\r\nLavez les carottes et coupez-les en cubes.\r\n</li>\r\n<li>\r\n3\r\nLavez et coupez le poivron en cubes.\r\n</li>\r\n<li>\r\n4\r\nPelez et Ã©mincez finement les oignons et ail.\r\n</li>\r\n<li>\r\n5\r\nHachez finement les herbes.\r\n</li>\r\n<li>\r\n6\r\nDans une casserole, faites chauffer du beurre et faites revenir les carottes et le poivron.\r\n</li>\r\n<li>\r\n7\r\nDans un plat ajoutez la viande hachÃ©e et ajoutez les fines herbes.\r\n</li>\r\n<li>\r\n8\r\nÃ‰gouttez les lÃ©gumes et incorporez-les Ã  la viande.\r\n</li>\r\n<li>\r\n9\r\nMalaxez et faites un petit pain avec la viande.\r\n</li>\r\n<li>\r\n10\r\nPlacez le pain dans un plat huilÃ©.\r\n</li>\r\n<li>\r\n11\r\nEnfournez pendant 40 Ã  45 min.\r\n</li>\r\n<li>\r\n9\r\nRemuez rÃ©guliÃ¨rement pour Ã©viter que votre prÃ©paration brÃ»le et retirez dÃ¨s que le riz sera cuit.\r\n</li>\r\n<ol>', '<ul>\r\n<li>500 g de viande hachÃ©e</li>\r\n<li>1 poivron rouge</li>\r\n<li>2 carottes nouvelles</li>\r\n<li>1 oignon</li>\r\n<li>1 oignon nouveau</li>\r\n<li>3 Ã©clats d''ail</li>\r\n<li>persil, ciboulette, origan, basilic et menthe</li>\r\n<li>poivre</li>\r\n</ul>', 4, 'fushia', '2023-05-06 02:45:43', 1, '45 min', '35 min', 'Facile', 'Pas cher'),
(6, 'Pommes de terre aux herbes', 'Avec les belles journÃ©es qui se profilent, on aurait bien envie de se prÃ©parer des plats simples et dÃ©licieux. Avec une viande grillÃ©e, vous devriez essayer ces pommes de terre aux herbes. LÃ©gÃ¨rement rissolÃ©es, elles sont un avant-goÃ»t d''Ã©tÃ© dans l''assiette.', 'pommes-de-terre-roquefort.jpg', '<ol>\r\n<li>1\r\nFaites chauffer l''huile dans une sauteuse, mettez y les pommes de terres et l''ail et faites dorer lÃ©gÃ¨rement.\r\n</li>\r\n<li>\r\n2\r\nAjoutez le thym, la marjolaine et le laurier et du sel.\r\n</li>\r\n<li>\r\n3\r\nRectifiez Ã©ventuellement l''assaisonnement et servez.\r\n</li>\r\n<ol>', '<ul>\r\n<li>1 kg 500 g de pommes de terre nouvelles</li>\r\n<li>4 gousses d''ail pilÃ©es</li>\r\n<li>2 c. Ã  soupe de thym et de marjolaine frais et finement hachÃ©s</li>\r\n<li>2 feuilles de laurier Ã©miettÃ©es</li>\r\n<li>3 c. Ã  soupe d''huile d''olive</li>\r\n<li>sel</li>\r\n</ul>', 5, 'vertClair', '2023-05-06 03:21:46', 2, '30 min', '15 min', 'Facile', 'Pas cher'),
(7, 'Navarin d''agneau facile', 'Qui dit lÃ©gumes nouveaux pense immÃ©diatement au navarin d''agneau. Ce plat, idÃ©al quelques semaines avant PÃ¢ques, rassemblera toute votre petite famille autour d''un repas gourmand et fondant.  N''hÃ©sitez pas Ã  prÃ©parer votre navarin Ã  l''avance, il n''en sera que meilleur le lendemain !', 'navarin-agneau.jpg', '<ol>\r\n<li>1\r\nDÃ©coupez l''Ã©paule d''agneau en 6 morceaux et collez-le en 6 tranches. Faites chauffer l''huile dans une cocotte de grande taille et ajoutez les morceaux de viande deux par deux pour les faire colorer sans laissez-les roussir. Quand ils sont tous dorÃ©s, Ã©gouttez-les et videz les deux tiers de la graisse fondue.\r\n</li>\r\n<li>\r\n2\r\nRemettez-les dans la cocotte et poudrez-les de sucre, mÃ©langez, puis poudrez de farine et faites chauffer en remuant de 2 Ã  3 minutes pour cuire la farine. Versez le vin et mÃ©langez, salez, poivrez et muscadez. RÃ©glez sur feu modÃ©rÃ©.\r\n</li>\r\n<li>\r\n3\r\nEbouillantez les tomates, puis pelez-les; Ã©pÃ©pinez-les et concassez-les.\r\n</li>\r\n<li>\r\n4\r\nPelez les gousses d''ail et hachez-les. Ajoutez ces ingrÃ©dients dans la cocotte ainsi que le bouquet garni. Le mouillement doit juste recouvrir la viande: ajoutez Ã©ventuellement un peu d''eau. Lorsque l''Ã©bullition est atteinte, couvrez et faites mijoter pendant 45 min environ en Ã©cumant et en dÃ©graissant rÃ©guliÃ¨rement.\r\n</li>\r\n<li>\r\n5\r\nPelez les carottes et les navets. Pelez les petits oignons, Ã´tez les fils des haricots verts, faites chauffer le beurre dans une sauteuse et mettez-y les carottes, les navets et les oignons, puis faites-les revenir en remuant pendant 10 min. Ã‰gouttez-les. Faites cuire les haricots verts Ã  la vapeur pendant 10 min.\r\n</li>\r\n<li>\r\n6\r\nAjoutez carottes, navets, oignons et petits pois dans la cocotte. MÃ©langez et couvrez Ã  nouveau, poursuivez la cuisson doucement pendant 20 min.\r\n</li>\r\n<li>\r\n7\r\nAjoutez enfin les haricots verts 5 min avant de servir et mÃ©langez dÃ©licatement. GoÃ»tez pour rectifier l''assaisonnement. Servez dans la cocotte ou un plat de service creux et bien chaud.\r\n</li>\r\n<ol>', '<ul>\r\n<li>800 g d''Ã©paule d''agneau dÃ©sossÃ©e</li>\r\n<li>800 g de collier d''agneau dÃ©sossÃ©</li>\r\n<li>1 c. Ã  cafÃ© de sucre en poudre</li>\r\n<li>1 c. Ã  soupe de farine</li>\r\n<li>20 cl de vin blanc sec</li>\r\n<li>noix de muscade</li>\r\n<li>2 tomates mÃ»res</li>\r\n<li>2 gousses d''ail</li>\r\n<li>1 bouquet garni</li>\r\n<li>300 g de petites carottes nouvelles</li>\r\n<li>100 g de petits oignons blancs</li>\r\n<li>200 g de petits navets nouveaux</li>\r\n<li>300 g de haricots verts</li>\r\n<li>300 g de petits pois Ã©cossÃ©s</li>\r\n<li>25 g de beurre</li>\r\n<li>2 c. Ã  soupe d''huile</li>\r\n<li>sel, poivre</li>\r\n</ul>', 6, 'bleuClair', '2023-05-06 02:56:12', 1, '1h 30 min', '30 min', 'Facile', 'Abordable'),
(8, 'Lotte aux lÃ©gumes gourmands', 'Les lÃ©gumes et la viande, c''est dÃ©licieux, mais avec du poisson c''est encore mieux. Ici, la lotte est lÃ©gÃ¨rement poÃªlÃ©e et accompagnÃ©e de lÃ©gumes croquants pour lesquels vous ne pourrez que succomber ! Ã‰quilibrÃ©e et gourmande, cette recette est Ã  tomber !', 'lotte-legumes.jpg', '<ol>\r\n<li>1\r\nFaites cuire les navets, les courgettes et les carottes 8 min, dans 1 l d''eau bouillante salÃ©e puis ajoutez les oignons (partagÃ©s en deux) et les petits pois.\r\n</li>\r\n<li>\r\n2\r\nProlongez la cuisson 3 min avant d''Ã©goutter les lÃ©gumes (en rÃ©servant leur eau de cuisson).\r\n</li>\r\n<li>\r\n3\r\nDisposez les dans un plat de cuisson ou vous les mÃªlerez Ã  50 g de beurre, couvrez.\r\n</li>\r\n<li>\r\n4\r\nDans du beurre faites lÃ©gÃ¨rement dorer la lotte coupÃ©e en 8 tranches. Assaisonnez puis rÃ©servez le poisson.\r\n</li>\r\n<li>\r\n5\r\nDÃ©glacez la poÃªle avec 25 cl de jus de cuisson des lÃ©gumes,portez Ã  Ã©bullition incorporez le reste du beurre.\r\n</li>\r\n<li>\r\n6\r\nServez la lotte entourÃ©e de lÃ©gumes et ajoutez quelques tomates sÃ©chÃ©es.\r\n</li>\r\n<li>\r\n7\r\nVous pouvez remplacer la lotte par bien d''autres poissons.\r\n</li>\r\n\r\n<ol>', '<ul>\r\n<li>900 g de lotte</li>\r\n<li>500 g de petits pois Ã  Ã©cosser</li>\r\n<li>8 carottes nouvelles</li>\r\n<li>2 navets nouveaux</li>\r\n<li>250 g de courgettes</li>\r\n<li>4 oignons blancs</li>\r\n<li>3 brins de cerfeuil</li>\r\n<li>quelques tomates sÃ©chÃ©es</li>\r\n<li>100 g de beurre</li>\r\n<li>sel, poivre</li>\r\n\r\n</ul>', 1, 'fushia', '2023-05-06 03:22:06', 3, '30 min', '40 min', 'Facile', 'Pas cher'),
(9, 'CrÃ¨me de petits pois frais', 'Si vous n''aviez pas d''idÃ©e pour le menu de ce soir, le repas est dÃ©sormais tout trouvÃ© ! DÃ©gustez cette crÃ¨me de petits pois et vous vous envolerez pour un voyage dans la douceur et la lÃ©gÃ¨retÃ©. Une expÃ©rience Ã  ne pas manquer !', 'creme-petits-poids.jpg', '<ol>\r\n<li>1\r\nFaÃ®tes dissoudre la tablette de bouillon dans 30 cl d''eau chaude. Fouettez la crÃ¨me liquide trÃ¨s froide en chantilly et rÃ©servez-la au rÃ©frigÃ©rateur.\r\n<li></li>\r\n2\r\nÃ‰cossez les petits pois. Ã‰pluchez et Ã©mincez les oignons. Plongez-les dans 2 l d''eau bouillante avec 2 c. Ã  soupe de gros sel. Laissez bouillir Ã  dÃ©couvert pendant 10 min.\r\n<li></li>\r\n3\r\nEntre temps, prÃ©parez un saladier et des glaÃ§ons.\r\n<li></li>\r\n4\r\nÃ‰gouttez rapidement les lÃ©gumes et plongez-les pendant 5 min dans de l''eau glacÃ©e pour arrÃªter la cuisson. Ã‰gouttez Ã  nouveau. Passez-les au moulin Ã  lÃ©gumes grille fine et recueillez la purÃ©e dans une casserole.\r\n<li></li>\r\n5\r\nAjoutez le bouillon, la crÃ¨me fraÃ®che Ã©paisse et le sucre. Poivrez et portez Ã  Ã©bullition. Ajoutez 3 c. Ã  soupe de crÃ¨me chantilly et fouettez quelques secondes.\r\n<li></li>\r\n6\r\nServez aussitÃ´t. Accompagnez d''un bol de chantilly parsemÃ©e de baies roses.\r\n</li>\r\n\r\n<ol>', '<ul>\r\n<li>1 kg de petits pois en cosse ou 400 g de petits pois Ã©cossÃ©s</li>\r\n<li>1 oignon</li>\r\n<li>1 oignon nouveau</li>\r\n<li>100 g de crÃ¨me fraÃ®che Ã©paisse</li>\r\n<li>15 cl de crÃ¨me liquide</li>\r\n<li>1 tablette de bouillon</li>\r\n<li>1 morceau de sucre</li>\r\n<li>Â¼ c. Ã  cafÃ© de baies roses concassÃ©es</li>\r\n<li>gros sel</li>\r\n<li>sel, poivre</li>\r\n\r\n</ul>', 2, 'vertClair', '2023-05-06 03:21:46', 2, '15 min', '30 min', 'Facile', 'Pas cher'),
(10, 'Girolles Ã  la paysanne', 'Cette recette mÃªle les saveurs d''automne avec les girolles fondantes avec les lÃ©gumes croquants des premiers beaux jours de l''annÃ©e. Servez ce mÃ©lange gourmand avec de la viande de veau et vous verrez, le bonheur sera complet !', 'girolles-paysanne.jpg', '<ol>\r\n<li>1\r\nNettoyez les girolles sans les laver. Laissez-les entiÃ¨res. Pelez les pommes de terre et les carottes.\r\n</li><li>\r\n2\r\nLaissez les premiÃ¨res entiÃ¨res et taillez les secondes en tranches. Faites fondre le beurre dans une cocotte en fonte, placez les tranches de lard et faites-les blondir doucement.\r\n</li><li>\r\n3\r\nAjoutez les pommes de terre, les carottes, le thym, le laurier et la gousse d''ail non pelÃ©e. Faites cuire doucement en remuant de temps en temps, pour que les lÃ©gumes se colorent lÃ©gÃ¨rement et d''une maniÃ¨re uniforme.\r\n</li><li>\r\n4\r\nAjoutez les girolles et couvrir. (Les pommes de terre finiront de cuire en absorbant l''eau rendue par les girolles).\r\n</li><li>\r\n5\r\nPoivrez, mais ne pas salez, Ã  cause du lard. Parsemez le fricot avec le persil et servez directement dans la cocotte.\r\n</li><li>\r\n6\r\nServez aussitÃ´t. Accompagnez d''un bol de chantilly parsemÃ©e de baies roses.\r\n</li>\r\n\r\n<ol>', '<ul>\r\n<li>300 g de girolles</li>\r\n<li>2 tranches de poitrine de lard salÃ©e</li>\r\n<li>400 g de petites pommes de terre nouvelles</li>\r\n<li>12 petites carottes nouvelles</li>\r\n<li>1 petite gousse d''ail</li>\r\n<li>1/2 feuille de laurier</li>\r\n<li>1 brindille de thym</li>\r\n<li>1 c. Ã  soupe de persil plat, hachÃ©</li>\r\n<li>20 g de beurre</li>\r\n<li>sel, poivre</li>\r\n\r\n</ul>', 3, 'bleuClair', '2023-05-06 03:21:46', 2, '15 min', '40 min', 'Facile', 'Pas cher'),
(11, 'Marmelade de carottes', 'Non, vous ne faites pas erreur, la recette que nous vous proposons ici est bien une marmelade de carottes. Pleine de saveurs et de soleil, cette prÃ©paration va Ã©veiller les papilles de vos convives. Essayez-la avec un pÃ¢tÃ© de campagne, vous nous en direz des nouvelles !', 'marmelade-carottes.jpg', '<ol>\r\n<li>1\r\nLavez et pelez les carottes. Faites cuire 1 heure Ã  l''eau bouillante. Ã‰gouttez et faites passer Ã  travers un tamis.\r\n</li><li>\r\n2\r\nFaites cuire 10 min dans la bassine Ã  confiture avec le jus de citron, la gousse de vanille et 15 cl d''eau.\r\n</li><li>\r\n3\r\nAjoutez la purÃ©e de carottes et laissez cuire encore 30 min Ã  feu doux en remuant. Incorporez les amandes, mettez en pots et couvrez aussitÃ´t.\r\n</li>\r\n\r\n<ol>', '<ul>\r\n<li>1 kg de carottes nouvelles</li>\r\n<li>1 kg de sucre cristallisÃ©</li>\r\n<li>le jus d''un citron</li>\r\n<li>1 gousse de vanille</li>\r\n<li>25 g d''amandes effilÃ©es\r\n</li>\r\n\r\n</ul>', 1, 'fushia', '2023-05-06 03:21:46', 2, '1h 40 min', '30 min', 'Facile', 'Pas cher');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
