/*
Navicat MySQL Data Transfer

Source Server         : Localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : dbfotocopie

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2015-04-22 10:26:38
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
  `Corso` int(11) DEFAULT NULL COMMENT 'Corso della classe',
  `Numero alunni` int(11) NOT NULL,
  `Fotocopie rimanenti` int(11) NOT NULL DEFAULT '2000',
  PRIMARY KEY (`ID`),
  KEY `asdsda` (`Corso`),
  CONSTRAINT `asdsda` FOREIGN KEY (`Corso`) REFERENCES `corsi` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of classi
-- ----------------------------
INSERT INTO `classi` VALUES ('1', '1', 'C', '1', '20', '1916');
INSERT INTO `classi` VALUES ('2', '2', 'C', '1', '30', '2000');
INSERT INTO `classi` VALUES ('4', '4', 'C', '1', '30', '1934');

-- ----------------------------
-- Table structure for `corsi`
-- ----------------------------
DROP TABLE IF EXISTS `corsi`;
CREATE TABLE `corsi` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of corsi
-- ----------------------------
INSERT INTO `corsi` VALUES ('1', 'Informatico');
INSERT INTO `corsi` VALUES ('2', 'Meccanico');
INSERT INTO `corsi` VALUES ('3', 'Chimico');

-- ----------------------------
-- Table structure for `insegna`
-- ----------------------------
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of insegna
-- ----------------------------
INSERT INTO `insegna` VALUES ('1', '1', '1');
INSERT INTO `insegna` VALUES ('2', '1', '2');
INSERT INTO `insegna` VALUES ('3', '4', '4');
INSERT INTO `insegna` VALUES ('4', '4', '1');

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
  `Eseguito` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 false, 1 true',
  `Data` date NOT NULL COMMENT 'Data in cui è stata effettuata la prenotazione',
  `Ora` time NOT NULL,
  `DataRichiesta` date NOT NULL COMMENT 'Data per cui vengono richieste le fotocopie, deve essere almeno 3 giorni dopo',
  `FileName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fasd` (`ID_Utente`),
  KEY `dcsdf` (`ID_Classe`),
  CONSTRAINT `dcsdf` FOREIGN KEY (`ID_Classe`) REFERENCES `classi` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fasd` FOREIGN KEY (`ID_Utente`) REFERENCES `utenti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of prenotazioni
-- ----------------------------
INSERT INTO `prenotazioni` VALUES ('1', '1', '2', '0', '0', '0', '0', '2015-03-28', '12:39:12', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('2', '3', '2', '10', '2', '0', '0', '2015-04-07', '18:08:07', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('3', '3', '2', '10', '2', '0', '0', '2015-04-07', '18:10:35', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('4', '3', '2', '10', '2', '0', '0', '2015-04-07', '18:12:17', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('5', '3', '1', '15', '2', '0', '0', '2015-04-07', '18:35:33', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('6', '3', '1', '21', '2', '0', '0', '2015-04-07', '18:37:34', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('7', '3', '2', '15', '2', '0', '0', '2015-04-07', '18:40:43', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('8', '3', '1', '6', '2', '0', '0', '2015-04-07', '18:45:05', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('9', '3', '2', '15', '1', '0', '0', '2015-04-07', '18:47:00', '2015-04-07', null);
INSERT INTO `prenotazioni` VALUES ('10', '3', '4', '15', '2', '0', '0', '2015-04-07', '18:50:28', '2000-12-21', null);
INSERT INTO `prenotazioni` VALUES ('11', '3', '2', '21', '2', '0', '0', '2015-04-07', '18:51:30', '0000-00-00', null);
INSERT INTO `prenotazioni` VALUES ('12', '3', '1', '40', '1', '0', '0', '2015-04-15', '11:57:10', '2015-02-28', '___testo.txt');
INSERT INTO `prenotazioni` VALUES ('13', '3', '1', '40', '1', '0', '0', '2015-04-15', '12:35:03', '2015-04-18', '_____testo.txt');
INSERT INTO `prenotazioni` VALUES ('15', '4', '4', '66', '1', '0', '0', '2015-04-15', '12:42:11', '2015-04-18', '______testo.txt');

-- ----------------------------
-- Table structure for `privilegi`
-- ----------------------------
DROP TABLE IF EXISTS `privilegi`;
CREATE TABLE `privilegi` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Privilegio` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of privilegi
-- ----------------------------
INSERT INTO `privilegi` VALUES ('1', 'Amministratore');
INSERT INTO `privilegi` VALUES ('2', 'Docente');
INSERT INTO `privilegi` VALUES ('3', 'Segreteria');

-- ----------------------------
-- Table structure for `utenti`
-- ----------------------------
DROP TABLE IF EXISTS `utenti`;
CREATE TABLE `utenti` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nome` varchar(255) NOT NULL,
  `Cognome` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL COMMENT 'cognome_nome',
  `E-mail` varchar(255) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Privilegio` int(11) DEFAULT NULL COMMENT '1 amministratore, 2 docenti, 3 segreteria',
  PRIMARY KEY (`ID`),
  KEY `priv` (`Privilegio`),
  CONSTRAINT `priv` FOREIGN KEY (`Privilegio`) REFERENCES `privilegi` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of utenti
-- ----------------------------
INSERT INTO `utenti` VALUES ('1', 'Amministratore', 'Amministratore', 'amm', 'd41d8cd98f00b204e9800998ecf8427e', 'd41d8cd98f00b204e9800998ecf8427e', '1');
INSERT INTO `utenti` VALUES ('2', 'Segreteria', 'Segreteria', 'segreteria', 'segreteria', 'd41d8cd98f00b204e9800998ecf8427e', '3');
INSERT INTO `utenti` VALUES ('3', 'admin', 'admin', 'admin', 'admin@admin.it', 'd41d8cd98f00b204e9800998ecf8427e', '1');
INSERT INTO `utenti` VALUES ('4', 'docente1', 'docente1', 'docente_1', 'docente1', 'd41d8cd98f00b204e9800998ecf8427e', '2');
