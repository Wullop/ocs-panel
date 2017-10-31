CREATE TABLE `asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rekening` varchar(50) DEFAULT NULL,
  `bank` varchar(50) DEFAULT NULL,
  `pemilik` varchar(50) DEFAULT NULL,
  `nohp` varchar(50) DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `continent`;

CREATE TABLE `continent` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

LOCK TABLES `continent` WRITE;
/*!40000 ALTER TABLE `continent` DISABLE KEYS */;
INSERT INTO `continent` VALUES (1,'Asia'),(2,'North America'),(3,'Europe'),(4,'South America'),(5,'Africa'),(6,'Oceania');
/*!40000 ALTER TABLE `continent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) DEFAULT NULL,
  `Country` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'Asia','Singapore'),(2,'Asia','Indonesia'),(3,'Asia','Japan'),(4,'Asia','Hongkong'),(5,'Europe','Netherlands'),(6,'Europe','Germani'),(7,'Europe','France'),(8,'Europe','Luxembourg'),(9,'North-America','NY-USA'),(10,'North-America','Canada'),(11,'North-America','LA-USA'),(12,'South-America','NY-USA'),(14,'Africa','Johanesburg'),(15,'Oceania','Australia'),(16,'North-America','Austria');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deposit`
--

DROP TABLE IF EXISTS `deposit`;

CREATE TABLE `deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `jumlah` int(11) DEFAULT NULL,
  `created_at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `server`;

CREATE TABLE `server` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `HostName` varchar(23) DEFAULT NULL,
  `RootPasswd` varchar(25) NOT NULL,
  `MaxUser` int(11) NOT NULL DEFAULT '50',
  `Expired` int(11) NOT NULL DEFAULT '7',
  `ServerName` varchar(20) DEFAULT NULL,
  `Location` varchar(20) DEFAULT NULL,
  `OpenSSH` varchar(20) NOT NULL DEFAULT '22',
  `Dropbear` varchar(20) NOT NULL DEFAULT '443',
  `Price` int(10) DEFAULT '10000',
  `Status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `sshuser`;

CREATE TABLE `sshuser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hostname` varchar(20) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `created_at` date NOT NULL,
  `expired_at` int(11) NOT NULL DEFAULT '30',
  `serverid` int(11) NOT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `userlimit`;
CREATE TABLE `userlimit` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Hostname` varchar(23) DEFAULT NULL,
  `Counter` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT 'default.jpg',
  `saldo` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `is_admin` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_confirmed` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `active` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `website`;

CREATE TABLE `website` (
  `brand` varchar(20) NOT NULL DEFAULT 'YOURWEB',
  `author` varchar(20) NOT NULL,
  `title` text,
  `description` text NOT NULL,
  `keyword` text NOT NULL,
  PRIMARY KEY (`brand`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
