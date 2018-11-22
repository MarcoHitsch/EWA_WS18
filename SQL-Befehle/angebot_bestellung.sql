DROP TABLE IF EXISTS `angebot_bestellung`;

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

