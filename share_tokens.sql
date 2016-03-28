SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `share_tokens`;

CREATE TABLE `share_tokens` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

insert into `share_tokens` values('1','1c7e368ddaa244a58a7c1b53a3024fd55cc604cd','2015-09-21 15:40:41'),
 ('2','1c7e368ddaa244a58a7c1b53a3024fd55cc604cd','2015-09-21 15:41:03'),
 ('3','26160149161ef0bc6306dcf2dc62a7e7d28fbcd5','2015-09-21 15:49:25');

SET FOREIGN_KEY_CHECKS = 1;
