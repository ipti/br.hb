CREATE TABLE `ferritin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agreed_term` int(11) NOT NULL,
  `rate` float NOT NULL,
  `date` DATE NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ferritina_aluno_has_campanha1_idx` (`agreed_term`),
  CONSTRAINT `fk_ferritin_term` FOREIGN KEY (`agreed_term`) REFERENCES `term` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2129 DEFAULT CHARSET=utf8;