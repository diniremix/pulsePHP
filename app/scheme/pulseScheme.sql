/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla pulsephp.log
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `logged_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(50) CHARACTER SET latin1 COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `FK_log_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla pulsephp.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  PRIMARY KEY (`permission_id`),
  UNIQUE KEY `uniq_perm` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla pulsephp.persons
CREATE TABLE IF NOT EXISTS `persons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `identification` varchar(30) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `lastname` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `avatar` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `dir` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `tel` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `twitter` varchar(30) COLLATE latin1_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `twitter` (`twitter`),
  UNIQUE KEY `identification` (`identification`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla pulsephp.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `added_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `uniq_name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla pulsephp.role_permissions
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_permission_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) unsigned NOT NULL,
  `permission_id` int(11) unsigned NOT NULL,
  `added_on` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`role_permission_id`),
  KEY `fk_role` (`role_id`) USING BTREE,
  KEY `fk_permission` (`permission_id`) USING BTREE,
  CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para tabla pulsephp.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para vista pulsephp.userinfo
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `userinfo` (
	`userid` INT(11) UNSIGNED NOT NULL,
	`person` VARCHAR(101) NOT NULL COLLATE 'utf8_spanish_ci',
	`username` VARCHAR(32) NOT NULL COLLATE 'latin1_swedish_ci',
	`dir` VARCHAR(50) NULL COLLATE 'utf8_spanish_ci',
	`email` VARCHAR(50) NOT NULL COLLATE 'utf8_spanish_ci',
	`rol` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`status` VARCHAR(20) NOT NULL COLLATE 'latin1_general_ci',
	`status_id` INT(11) UNSIGNED NOT NULL
) ENGINE=MyISAM;


-- Volcando estructura para tabla pulsephp.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) unsigned DEFAULT NULL,
  `person_id` int(11) unsigned DEFAULT NULL,
  `status_id` int(11) unsigned DEFAULT '1',
  `password_hash` varchar(128) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `api_key` (`api_key`),
  UNIQUE KEY `password_hash` (`password_hash`),
  KEY `fk_role` (`role_id`) USING BTREE,
  KEY `person_id` (`person_id`) USING BTREE,
  KEY `status_id` (`status_id`) USING BTREE,
  CONSTRAINT `FK_users_status` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `persons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- La exportación de datos fue deseleccionada.


-- Volcando estructura para vista pulsephp.view_role_permissions
-- Creando tabla temporal para superar errores de dependencia de VIEW
CREATE TABLE `view_role_permissions` (
	`role_id` INT(11) UNSIGNED NOT NULL,
	`role` VARCHAR(255) NOT NULL COLLATE 'utf8_general_ci',
	`permission_id` INT(11) UNSIGNED NOT NULL,
	`permission` VARCHAR(32) NOT NULL COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


-- Volcando estructura para vista pulsephp.userinfo
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `userinfo`;
CREATE VIEW `userinfo` AS SELECT u.id as userid, concat(p.name,' ', p.lastname) as person, u.username, 
p.dir as dir, p.email, r.name as rol, e.type as status, e.id as status_id

FROM `persons` p,`users` u, `roles` r, status e

where u.role_id= r.role_id
and u.person_id= p.id
and u.status_id = e.id ;


-- Volcando estructura para vista pulsephp.view_role_permissions
-- Eliminando tabla temporal y crear estructura final de VIEW
DROP TABLE IF EXISTS `view_role_permissions`;
CREATE VIEW `view_role_permissions` AS SELECT r.role_id, r.name as role,  rp.permission_id, p.name as permission  
FROM `role_permissions` rp, `roles` r, `permissions` p
WHERE rp.role_id =r.role_id AND rp.permission_id = p.permission_id ;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
