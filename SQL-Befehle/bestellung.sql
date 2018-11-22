DROP TABLE IF EXISTS `bestellung`;

CREATE TABLE `bestellung` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `adresse` varchar(50) NOT NULL DEFAULT '',
  `zeitpunkt` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

