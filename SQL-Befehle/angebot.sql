DROP TABLE IF EXISTS `angebot`;

CREATE TABLE `angebot` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `bild` varchar(50) NOT NULL DEFAULT '',
  `preis` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO angebot (id,  name, bild, preis)
VALUES
(1, 'Margherita','Res/Pizza_Margherita.png', 5),
(2, 'Salami','Res/Pizza_Salami.png', 6),
(3, 'Prosciutto','Res/Pizza_Prosciutto.png', 7);

