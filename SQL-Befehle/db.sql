DROP DATABASE  IF EXISTS pizzaservice;
CREATE DATABASE pizzaservice CHARACTER SET utf8 COLLATE utf8_bin;

DROP TABLE IF EXISTS `bestellung` ;
DROP TABLE IF EXISTS `session` ;
DROP TABLE IF EXISTS `angebot` ;
DROP TABLE IF EXISTS `angebot_bestellung` ;

CREATE TABLE `session` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `bestellung` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `session_id` int(11) unsigned NOT NULL,
  `adresse` varchar(50) NOT NULL DEFAULT '',
  `status` int(11) unsigned,
  `zeitpunkt` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `session_id` (`session_id`),
  CONSTRAINT `bestellung_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `session`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `angebot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `bild` varchar(50) NOT NULL DEFAULT '',
  `preis` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `angebot_bestellung` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `angebot_id` int(11) unsigned NOT NULL,
  `bestellung_id` int(11) unsigned NOT NULL,
  `status` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `angebot_id` (`angebot_id`),
  KEY `bestellung_id` (`bestellung_id`),
  CONSTRAINT `angebot_bestellung_ibfk_2` FOREIGN KEY (`bestellung_id`) REFERENCES `bestellung` (`id`),
  CONSTRAINT `angebot_bestellung_ibfk_1` FOREIGN KEY (`angebot_id`) REFERENCES `angebot` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO angebot (id,  name, bild, preis)
VALUES
(1, 'Margherita','Res/Pizza_Margherita.png', 5),
(2, 'Salami','Res/Pizza_Salami.png', 6),
(3, 'Prosciutto','Res/Pizza_Prosciutto.png', 7);