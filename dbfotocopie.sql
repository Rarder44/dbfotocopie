</*
Navicat MySQL Data Transfer

Source Server         : Database computerino
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : dbfotocopie

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-03-28 12:54:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `classi`
-- ----------------------------
DROP TABLE IF EXISTS `classi`;
CREATE TABLE `classi` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Numero classe` int(11) NOT NULL,
  `Sezione` varchar(255) NOT NULL,
  `Numero alunni` int(11) NOT NULL,
  `Fotocopie rimanenti` int(11) NOT NULL DEFAULT '2000',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of classi
-- ----------------------------
INSERT INTO `classi` VALUES ('1', '1', 'C', '20', '2000');
INSERT INTO `classi` VALUES ('2', '2', 'C', '30', '2000');
INSERT INTO `classi` VALUES ('4', '4', 'C', '30', '2000');

-- ----------------------------
-- Table structure for `utenti`
-- ----------------------------
DROP TABLE IF EXISTS `utenti`;
CREATE TABLE `utenti` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(255) NOT NULL,
  `Cognome` varchar(255) NOT NULL,
  `E-mail` varchar(255) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Privilegio` int(11) NOT NULL COMMENT '1 amministratore, 2 docenti, 3 segreteria',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of utenti
-- ----------------------------
INSERT INTO `utenti` VALUES ('1', 'Amministratore', 'Amministratore', 'amm', 'd41d8cd98f00b204e9800998ecf8427e', '1');
INSERT INTO `utenti` VALUES ('2', 'Segreteria', 'Segreteria', 'segreteria', '7215ee9c7d9dc229d2921a40e899ec5f', '3');

-- ----------------------------
-- Table structure for `prenotazioni`
-- ----------------------------
DROP TABLE IF EXISTS `prenotazioni`;
CREATE TABLE `prenotazioni` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Utente` int(11) DEFAULT NULL,
  `ID_Classe` int(11) DEFAULT NULL,
  `Numero fotocopie` int(11) NOT NULL,
  `Formato` int(11) NOT NULL COMMENT '1 A4, 2, A3',
  `Fogli` int(11) NOT NULL COMMENT '1 singoli, 2 fronte/retro',
  `Data` date NOT NULL COMMENT 'Data in cui è stata effettuata la prenotazione',
  `Eseguito` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 false, 1 true',
  `Ora` time DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fasd` (`ID_Utente`),
  KEY `dcsdf` (`ID_Classe`),
  CONSTRAINT `dcsdf` FOREIGN KEY (`ID_Classe`) REFERENCES `classi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fasd` FOREIGN KEY (`ID_Utente`) REFERENCES `utenti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prenotazioni
-- ----------------------------
INSERT INTO `prenotazioni` VALUES ('1', '1', '2', '0', '0', '0', '2015-03-28', '0', '12:39:12');


DROP TABLE IF EXISTS `insegna`;
CREATE TABLE `insegna` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Utente` int(11) NOT NULL COMMENT 'Chiave esterna assegnata agli utenti',
  `ID_Classe` int(11) NOT NULL COMMENT 'Chiave esterna assegnata alle classi',
  PRIMARY KEY (`ID`),
  KEY `z<sdsa` (`ID_Utente`),
  KEY `asdas` (`ID_Classe`),
  CONSTRAINT `asdas` FOREIGN KEY (`ID_Classe`) REFERENCES `classi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `z<sdsa` FOREIGN KEY (`ID_Utente`) REFERENCES `utenti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of insegna
-- ----------------------------
INSERT INTO `insegna` VALUES ('1', '1', '1');
INSERT INTO `insegna` VALUES ('2', '1', '2');
