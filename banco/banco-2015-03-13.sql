CREATE DATABASE  IF NOT EXISTS `hbdb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `hbdb`;
-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: 192.168.25.209    Database: hbdb
-- ------------------------------------------------------
-- Server version	5.5.40-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(2) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `neighborhood` varchar(30) DEFAULT NULL COMMENT '6',
  `street` varchar(100) DEFAULT NULL,
  `number` varchar(10) DEFAULT NULL,
  `complement` varchar(100) DEFAULT NULL,
  `postal_code` varchar(8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `anatomy`
--

DROP TABLE IF EXISTS `anatomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anatomy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) NOT NULL,
  `weight` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_anatomia_aluno1_idx` (`student`),
  CONSTRAINT `fk_anatomy_student` FOREIGN KEY (`student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign`
--

DROP TABLE IF EXISTS `campaign`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coordinator` int(11) DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `begin` date NOT NULL,
  `end` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_campanha_usuario1_idx` (`coordinator`),
  CONSTRAINT `fk_campaign_person_user` FOREIGN KEY (`coordinator`) REFERENCES `person_user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign_has_driver`
--

DROP TABLE IF EXISTS `campaign_has_driver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign_has_driver` (
  `campaign` int(11) NOT NULL,
  `driver` int(11) NOT NULL,
  PRIMARY KEY (`campaign`,`driver`),
  KEY `fk_campanha_has_Motorista_Motorista1_idx` (`driver`),
  KEY `fk_campanha_has_Motorista_campanha1_idx` (`campaign`),
  CONSTRAINT `fk_campaign_has_driver_person_driver` FOREIGN KEY (`driver`) REFERENCES `person_driver` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_campaign_has_driver_campaign` FOREIGN KEY (`campaign`) REFERENCES `campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `campaign_has_vehicle`
--

DROP TABLE IF EXISTS `campaign_has_vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaign_has_vehicle` (
  `campaign` int(11) NOT NULL,
  `vehicle` int(11) NOT NULL,
  PRIMARY KEY (`campaign`,`vehicle`),
  KEY `fk_campanha_has_veiculo_veiculo1_idx` (`vehicle`),
  KEY `fk_campanha_has_veiculo_campanha1_idx` (`campaign`),
  CONSTRAINT `fk_campaign_has_vehicle_vehicle` FOREIGN KEY (`vehicle`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_campaign_has_vehicle_campaign` FOREIGN KEY (`campaign`) REFERENCES `campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `classroom`
--

DROP TABLE IF EXISTS `classroom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL,
  `school` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `shift` enum('day','morning','afternoon','night') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_turma_escola2_idx` (`school`),
  CONSTRAINT `fk_classroom_school` FOREIGN KEY (`school`) REFERENCES `school` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `classroom_has_event`
--

DROP TABLE IF EXISTS `classroom_has_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classroom_has_event` (
  `classroom` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  `team` int(11) NOT NULL,
  PRIMARY KEY (`classroom`,`event`),
  KEY `fk_turma_has_equipe_equipe1_idx` (`team`),
  KEY `fk_turma_has_equipe_turma1_idx` (`classroom`),
  KEY `fk_turma_has_equipe_evento1_idx` (`event`),
  CONSTRAINT `fk_classroom_has_event_event` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_classroom_has_event_team` FOREIGN KEY (`team`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_classroom_has_event_classroom` FOREIGN KEY (`classroom`) REFERENCES `classroom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `consultation`
--

DROP TABLE IF EXISTS `consultation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `consultation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctor` int(11) DEFAULT NULL,
  `attended` tinyint(1) NOT NULL DEFAULT '0',
  `delivered` tinyint(1) NOT NULL DEFAULT '0',
  `term` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_consulta_medico1_idx` (`doctor`),
  KEY `fk_consultation_term` (`term`),
  CONSTRAINT `fk_consultation_person_doctor` FOREIGN KEY (`doctor`) REFERENCES `person_doctor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_consultation_term` FOREIGN KEY (`term`) REFERENCES `term` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `drives`
--

DROP TABLE IF EXISTS `drives`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drives` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver` int(11) NOT NULL,
  `vehicle` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_Motorista_has_veiculo_veiculo1_idx` (`vehicle`),
  KEY `fk_Motorista_has_veiculo_rota1_idx` (`start`),
  KEY `fk_Motorista_has_veiculo_Motorista1_idx` (`driver`),
  KEY `fk_motorista_has_veiculo_evento1_idx` (`event`),
  CONSTRAINT `fk_drives_person_driver` FOREIGN KEY (`driver`) REFERENCES `person_driver` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_drives_route` FOREIGN KEY (`start`) REFERENCES `route` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_drives_vehicle` FOREIGN KEY (`vehicle`) REFERENCES `vehicle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_drives_event` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enrollment`
--

DROP TABLE IF EXISTS `enrollment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` int(11) NOT NULL,
  `classroom` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_aluno_has_turma_turma1_idx` (`classroom`),
  KEY `fk_aluno_has_turma_aluno1_idx` (`student`),
  CONSTRAINT `fk_enrollment_student` FOREIGN KEY (`student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_enrollment_classroom` FOREIGN KEY (`classroom`) REFERENCES `classroom` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` int(11) NOT NULL,
  `campaign` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `begin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end` timestamp NULL DEFAULT NULL,
  `shift` enum('day','morning','afternoon','night') DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_agenda_Endereco1_idx` (`address`),
  KEY `fk_agenda_campanha1_idx` (`campaign`),
  CONSTRAINT `fk_event_adress` FOREIGN KEY (`address`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_event_campaign` FOREIGN KEY (`campaign`) REFERENCES `campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hemoglobin`
--

DROP TABLE IF EXISTS `hemoglobin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hemoglobin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agreed_term` int(11) NOT NULL,
  `rate` float NOT NULL,
  `sample` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_hemoglobina_aluno_has_campanha1_idx` (`agreed_term`),
  CONSTRAINT `fk_hemoglobin_term` FOREIGN KEY (`agreed_term`) REFERENCES `term` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `kinship`
--

DROP TABLE IF EXISTS `kinship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kinship` (
  `responsible` int(11) NOT NULL,
  `student` int(11) NOT NULL,
  `relation` enum('father','mother','stepmother','stepfather','grandfather','grandmother','aunt','uncle','brother','sister','guardian') NOT NULL,
  PRIMARY KEY (`responsible`,`student`),
  KEY `fk_pessoa_externa_has_aluno_aluno1_idx` (`student`),
  KEY `fk_pessoa_externa_has_aluno_pessoa_externa1_idx` (`responsible`),
  CONSTRAINT `fk_kinship_person_external` FOREIGN KEY (`responsible`) REFERENCES `person_external` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_kinship_student` FOREIGN KEY (`student`) REFERENCES `student` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `team` int(11) NOT NULL,
  `person` int(11) NOT NULL,
  PRIMARY KEY (`team`,`person`),
  KEY `fk_equipe_has_pessoa_pessoa1_idx` (`person`),
  KEY `fk_equipe_has_pessoa_equipe1_idx` (`team`),
  CONSTRAINT `fk_member_person` FOREIGN KEY (`person`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_member_team` FOREIGN KEY (`team`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `document` varchar(11) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `cellphone` varchar(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('medic','driver','principal','admin','coordinator','responsible','agent','expert') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `CPF_UNIQUE` (`document`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_pessoa_Endereco1_idx` (`address`),
  CONSTRAINT `fk_person_address` FOREIGN KEY (`address`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person_doctor`
--

DROP TABLE IF EXISTS `person_doctor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person_doctor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person` int(11) NOT NULL,
  `license` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `CRM_UNIQUE` (`license`),
  KEY `fk_medico_pessoa1_idx` (`person`),
  CONSTRAINT `fk_person_doctor_person` FOREIGN KEY (`person`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person_driver`
--

DROP TABLE IF EXISTS `person_driver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person_driver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person` int(11) NOT NULL,
  `license` varchar(11) NOT NULL,
  `expiration` date NOT NULL,
  `license_class` enum('A','B','C','D','E','AB','AC','AD','AE') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `license_UNIQUE` (`license`),
  KEY `fk_Motorista_pessoa1_idx` (`person`),
  CONSTRAINT `fk_person_driver_person` FOREIGN KEY (`person`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person_external`
--

DROP TABLE IF EXISTS `person_external`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person_external` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` varchar(45) DEFAULT NULL,
  `person` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_pessoa_externa_pessoa1_idx` (`person`),
  CONSTRAINT `fk_person_external_person` FOREIGN KEY (`person`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person_user`
--

DROP TABLE IF EXISTS `person_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person` int(11) NOT NULL,
  `login` varchar(45) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_usuario_pessoa1_idx` (`person`),
  CONSTRAINT `fk_person_user_person` FOREIGN KEY (`person`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `prescription`
--

DROP TABLE IF EXISTS `prescription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescription` (
  `stock` int(11) NOT NULL,
  `consultation` int(11) NOT NULL,
  PRIMARY KEY (`consultation`,`stock`),
  KEY `fk_estoque_has_consulta_consulta1_idx` (`consultation`),
  KEY `fk_prescription_stock` (`stock`),
  CONSTRAINT `fk_prescription_consultation` FOREIGN KEY (`consultation`) REFERENCES `consultation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_prescription_stock` FOREIGN KEY (`stock`) REFERENCES `stock` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `route`
--

DROP TABLE IF EXISTS `route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` int(11) NOT NULL,
  `next` int(11) NOT NULL,
  `team` int(11) NOT NULL,
  `campaign` int(11) NOT NULL,
  `schedule` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `leave` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_rota_Endereco1_idx` (`address`),
  KEY `fk_rota_equipe1_idx` (`team`),
  KEY `fk_rota_rota1_idx` (`next`),
  KEY `fk_rota_campanha1_idx` (`campaign`),
  CONSTRAINT `fk_route_address` FOREIGN KEY (`address`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_route_campaign` FOREIGN KEY (`campaign`) REFERENCES `campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_route_route` FOREIGN KEY (`next`) REFERENCES `route` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_route_team` FOREIGN KEY (`team`) REFERENCES `team` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` varchar(45) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `address` int(11) NOT NULL,
  `principal` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_escola_Endereco1_idx` (`address`),
  KEY `fk_escola_pessoa_externa1_idx` (`principal`),
  CONSTRAINT `fk_school_address` FOREIGN KEY (`address`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_school_person_external` FOREIGN KEY (`principal`) REFERENCES `person_external` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `school_has_event`
--

DROP TABLE IF EXISTS `school_has_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `school_has_event` (
  `school` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  PRIMARY KEY (`school`,`event`),
  KEY `fk_escola_has_evento_evento1_idx` (`event`),
  KEY `fk_escola_has_evento_escola1_idx` (`school`),
  CONSTRAINT `fk_school_has_event_event` FOREIGN KEY (`event`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_school_has_event_school` FOREIGN KEY (`school`) REFERENCES `school` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item` int(11) NOT NULL,
  `campaign` int(11) NOT NULL,
  `person` int(11) NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `date` date NOT NULL,
  `withdrew` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_item_has_campanha_campanha1_idx` (`campaign`),
  KEY `fk_item_has_campanha_item1_idx` (`item`),
  KEY `fk_estoque_pessoa1_idx` (`person`),
  CONSTRAINT `fk_stock_campaign` FOREIGN KEY (`campaign`) REFERENCES `campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_stock_item` FOREIGN KEY (`item`) REFERENCES `item` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_stock_person` FOREIGN KEY (`person`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` varchar(45) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `address` int(11) NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('male','female') NOT NULL,
  `responsible` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_aluno_Endereco1_idx` (`address`),
  CONSTRAINT `fk_student_address` FOREIGN KEY (`address`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `team` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `campaign` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `fk_equipe_campanha1_idx` (`campaign`),
  CONSTRAINT `fk_team_campaign` FOREIGN KEY (`campaign`) REFERENCES `campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `term`
--

DROP TABLE IF EXISTS `term`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment` int(11) NOT NULL,
  `campaign` int(11) DEFAULT NULL,
  `agreed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_aluno_has_campanha_campanha1_idx` (`campaign`),
  KEY `fk_term_enrollment_idx` (`enrollment`),
  CONSTRAINT `fk_term_campaign` FOREIGN KEY (`campaign`) REFERENCES `campaign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_term_enrollment` FOREIGN KEY (`enrollment`) REFERENCES `enrollment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vehicle`
--

DROP TABLE IF EXISTS `vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_class` enum('A','B','C','D','E') NOT NULL,
  `passengers` int(11) NOT NULL,
  `autonomy` int(11) NOT NULL,
  `fuel_capacity` int(11) NOT NULL,
  `license_plate` varchar(7) NOT NULL,
  `maintenance` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `license_plate_UNIQUE` (`license_plate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-13 19:01:52
