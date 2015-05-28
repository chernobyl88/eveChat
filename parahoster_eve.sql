--
-- Structure de la table `accueil_language`
--

CREATE TABLE IF NOT EXISTS `accueil_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poney` varchar(100) NOT NULL,
  `hypopotame` varchar(111) NOT NULL,
  `hypocampe` varchar(111) NOT NULL,
  `ours` varchar(111) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `adresses`
--

CREATE TABLE IF NOT EXISTS `adresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `entreprise` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `case_postale` varchar(100) NOT NULL,
  `localite` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `adresses`
--

INSERT INTO `adresses` (`id`, `user_id`, `entreprise`, `adresse`, `case_postale`, `localite`) VALUES
(1, 3, 'Parahoster 2', 'Grand Rue 11', '', 'Ici');

-- --------------------------------------------------------

--
-- Structure de la table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `valeur` varchar(100) NOT NULL,
  `clef` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `connexion_log`
--

CREATE TABLE IF NOT EXISTS `connexion_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(50) NOT NULL,
  `ip_adresse` varchar(30) NOT NULL,
  `match_access` tinyint(4) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `date_co` datetime NOT NULL,
  `date_clk` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txt_cst` varchar(150) NOT NULL,
  `def_val` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `groupe_access`
--

CREATE TABLE IF NOT EXISTS `groupe_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `groupe_id` int(11) NOT NULL,
  `admin_lvl` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clef` varchar(100) NOT NULL,
  `lang` varchar(15) NOT NULL,
  `valeur` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clef` (`clef`,`lang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `language`
--

INSERT INTO `language` (`id`, `clef`, `lang`, `valeur`) VALUES
(1, 'TEST_VALUE', 'de-DE', 'une valeur test');

-- --------------------------------------------------------

--
-- Structure de la table `routes`
--

CREATE TABLE IF NOT EXISTS `routes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  `action` varchar(50) NOT NULL,
  `vars` varchar(150) NOT NULL,
  `admin_lvl` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `routes`
--

INSERT INTO `routes` (`id`, `url`, `module`, `action`, `vars`, `admin_lvl`) VALUES
(1, '/', 'Accueil', 'index', '', 0),
(2, '/admin/', 'Admin', 'index', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `routes_def_val`
--

CREATE TABLE IF NOT EXISTS `routes_def_val` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_key` varchar(50) NOT NULL,
  `route_val` varchar(50) NOT NULL,
  `force_val` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `language` char(2) NOT NULL DEFAULT 'fr',
  `email` varchar(150) NOT NULL,
  `inscr_date` datetime NOT NULL,
  `civilite` enum('M.','Mme.','Mlle.') NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `no_tel` varchar(100) NOT NULL,
  `admin` tinyint(4) NOT NULL DEFAULT '0',
  `reference_user` int(11) NOT NULL,
  `prospectus_min_num_id` int(11) NOT NULL,
  `sga_min_num_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `language`, `email`, `inscr_date`, `civilite`, `prenom`, `nom`, `no_tel`, `admin`, `reference_user`, `prospectus_min_num_id`, `sga_min_num_id`) VALUES
(1, 'test', '$2a$07$0ezz1skRWMqCQA4HpPbMbOXh4JICgknT5kIPJeV2k4hZxXbebSrpW', 'fr', 'test@test.test', '2014-04-02 17:01:38', 'M.', 'test', 'test', 'test', 10, -1, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `user_access`
--

CREATE TABLE IF NOT EXISTS `user_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_lvl` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `user_groupe`
--

CREATE TABLE IF NOT EXISTS `user_groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupe_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
