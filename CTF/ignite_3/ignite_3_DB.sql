CREATE DATABASE `adminDB`;
CREATE DATABASE `gameDB`; 
CREATE DATABASE `publicDB`;

USE `adminDB`;
CREATE TABLE `dbusers` (
	`username` char(10) NOT NULL,
	`password` char(100) NOT NULL,
	`role` char(30) NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `linuxusers` (
	`username` char(10) NOT NULL,
	`password` char(100) NOT NULL,
	`role` char(15) NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `gameusers` (
	`username` char(10) NOT NULL,
	`password` char(100) NOT NULL,
	`level` int NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

USE `gameDB`;
CREATE TABLE `dbusers` (
	`username` char(10) NOT NULL,
	`role` char(15) NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `linuxusers` (
	`username` char(10) NOT NULL,
	`role` char(15) NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `gameusers` (
	`username` char(10) NOT NULL,
	`level` int NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

USE `publicDB`;
CREATE TABLE `dbusers` (
	`username` char(10) NOT NULL,
	`role` char(15) NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `linuxusers` (
	`username` char(10) NOT NULL,
	`role` char(15) NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `gameusers` (
	`username` char(10) NOT NULL,
	`level` int NOT NULL,
	PRIMARY KEY (`username`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;

USE `adminDB`;
INSERT INTO `dbusers` VALUES ('admin', 'adminPAssWOrd', 'DB_admin');
INSERT INTO `dbusers` VALUES ('JY', 'jyPAssWOrd', 'DB_user');
INSERT INTO `dbusers` VALUES ('MJ', 'mjPAssWOrd', 'DB_user');
INSERT INTO `dbusers` VALUES ('JH', 'jhPAssWOrd', 'DB_user');
INSERT INTO `dbusers` VALUES ('JiH', 'jihPAssWOrd', 'DB_user');
INSERT INTO `dbusers` VALUES ('public', 'public', 'DB_public_user');

INSERT INTO `linuxusers` VALUES ('admin', CONCAT('$dynamic_0$', MD5('publications')), 'linux_admin');
INSERT INTO `linuxusers` VALUES ('JY', CONCAT('$dynamic_0$', MD5('technology')), 'linux_user');
INSERT INTO `linuxusers` VALUES ('MJ', CONCAT('$dynamic_0$', MD5('calendar')), 'linux_user');
INSERT INTO `linuxusers` VALUES ('JH', CONCAT('$dynamic_0$', MD5('stories')), 'linux_user');
INSERT INTO `linuxusers` VALUES ('JiH', CONCAT('$dynamic_0$', MD5('photos')), 'linux_user');

INSERT INTO `gameusers` VALUES ('admin', '1234', 999);
INSERT INTO `gameusers` VALUES ('JY', '1234', 100);
INSERT INTO `gameusers` VALUES ('MJ', '1234', 100);
INSERT INTO `gameusers` VALUES ('JH', '1234', 100);
INSERT INTO `gameusers` VALUES ('JiH', '1234', 100);

USE `gameDB`;
INSERT INTO `dbusers` VALUES ('admin', 'DB_admin');
INSERT INTO `dbusers` VALUES ('JY', 'DB_user');
INSERT INTO `dbusers` VALUES ('MJ', 'DB_user');
INSERT INTO `dbusers` VALUES ('JH', 'DB_user');
INSERT INTO `dbusers` VALUES ('JiH', 'DB_user');
INSERT INTO `dbusers` VALUES ('public', 'DB_public_user');

INSERT INTO `linuxusers` VALUES ('admin', 'linux_admin');
INSERT INTO `linuxusers` VALUES ('JY', 'linux_user');
INSERT INTO `linuxusers` VALUES ('MJ', 'linux_user');
INSERT INTO `linuxusers` VALUES ('JH', 'linux_user');
INSERT INTO `linuxusers` VALUES ('JiH', 'linux_user');

INSERT INTO `gameusers` VALUES ('admin', 999);
INSERT INTO `gameusers` VALUES ('JY', 100);
INSERT INTO `gameusers` VALUES ('MJ', 100);
INSERT INTO `gameusers` VALUES ('JH', 100);
INSERT INTO `gameusers` VALUES ('JiH', 100);

USE `publicDB`;
INSERT INTO `dbusers` VALUES ('JY', 'DB_user');
INSERT INTO `dbusers` VALUES ('MJ', 'DB_user');
INSERT INTO `dbusers` VALUES ('JH', 'DB_user');
INSERT INTO `dbusers` VALUES ('JiH', 'DB_user');
INSERT INTO `dbusers` VALUES ('public', 'DB_public_user');

INSERT INTO `linuxusers` VALUES ('JY', 'linux_user');
INSERT INTO `linuxusers` VALUES ('MJ', 'linux_user');
INSERT INTO `linuxusers` VALUES ('JH', 'linux_user');
INSERT INTO `linuxusers` VALUES ('JiH', 'linux_user');

INSERT INTO `gameusers` VALUES ('JY', 100);
INSERT INTO `gameusers` VALUES ('MJ', 100);
INSERT INTO `gameusers` VALUES ('JH', 100);
INSERT INTO `gameusers` VALUES ('JiH', 100);

CREATE USER 'admin'@'localhost' IDENTIFIED BY 'adminPAssWOrd';
CREATE USER 'JY'@'localhost' IDENTIFIED BY 'jyPAssWOrd';
CREATE USER 'MJ'@'localhost' IDENTIFIED BY 'mjPAssWOrd';
CREATE USER 'JH'@'localhost' IDENTIFIED BY 'jhPAssWOrd';
CREATE USER 'JiH'@'localhost' IDENTIFIED BY 'jihPAssWOrd';
CREATE USER 'public'@'localhost' IDENTIFIED BY 'public';

GRANT ALL PRIVILEGES ON adminDB.linuxusers TO 'admin'@'localhost';
GRANT ALL PRIVILEGES ON adminDB.gameusers TO 'admin'@'localhost';

GRANT ALL PRIVILEGES ON gameDB.* TO 'admin'@'localhost';
GRANT ALL PRIVILEGES ON gameDB.* TO 'JY'@'localhost';
GRANT ALL PRIVILEGES ON gameDB.* TO 'MJ'@'localhost';
GRANT ALL PRIVILEGES ON gameDB.* TO 'JH'@'localhost';
GRANT ALL PRIVILEGES ON gameDB.* TO 'JiH'@'localhost';

GRANT ALL PRIVILEGES ON publicDB.* TO 'admin'@'localhost';
GRANT ALL PRIVILEGES ON publicDB.* TO 'JY'@'localhost';
GRANT ALL PRIVILEGES ON publicDB.* TO 'MJ'@'localhost';
GRANT ALL PRIVILEGES ON publicDB.* TO 'JH'@'localhost';
GRANT ALL PRIVILEGES ON publicDB.* TO 'JiH'@'localhost';
GRANT ALL PRIVILEGES ON publicDB.* TO 'public'@'localhost';

FLUSH PRIVILEGES;