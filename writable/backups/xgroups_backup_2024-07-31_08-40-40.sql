-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: xgroups
-- ------------------------------------------------------
-- Server version	10.11.6-MariaDB-0+deb12u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `BetsUsers`
--

DROP TABLE IF EXISTS `BetsUsers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BetsUsers` (
  `userID` int(255) NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `new` int(1) DEFAULT 1,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `profilePicture` varchar(100) DEFAULT NULL,
  `aboutMe` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BetsUsers`
--

LOCK TABLES `BetsUsers` WRITE;
/*!40000 ALTER TABLE `BetsUsers` DISABLE KEYS */;
/*!40000 ALTER TABLE `BetsUsers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserAstroInfo`
--

DROP TABLE IF EXISTS `UserAstroInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserAstroInfo` (
  `userID` int(255) NOT NULL,
  `Element` int(1) NOT NULL DEFAULT 1,
  `HS_Hour` varchar(20) DEFAULT NULL,
  `EB_Hour` varchar(20) DEFAULT NULL,
  `EB_Hour_eng` varchar(10) DEFAULT NULL,
  `HS_Day` varchar(20) DEFAULT NULL,
  `EB_Day` varchar(20) DEFAULT NULL,
  `EB_Day_eng` varchar(10) DEFAULT NULL,
  `HS_Month` varchar(20) DEFAULT NULL,
  `EB_Month` varchar(20) DEFAULT NULL,
  `EB_Month_eng` varchar(10) DEFAULT NULL,
  `HS_Year` varchar(20) DEFAULT NULL,
  `EB_Year` varchar(20) DEFAULT NULL,
  `EB_Year_eng` varchar(10) DEFAULT NULL,
  `Season` varchar(20) DEFAULT NULL,
  `kin_tone` varchar(20) DEFAULT NULL,
  `kin_seal` varchar(20) DEFAULT NULL,
  `kin_number` varchar(20) DEFAULT NULL,
  `sun` varchar(20) DEFAULT NULL,
  `ascendant` varchar(20) DEFAULT NULL,
  `moon` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  CONSTRAINT `fk_UserAstroInfo_Users` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserAstroInfo`
--

LOCK TABLES `UserAstroInfo` WRITE;
/*!40000 ALTER TABLE `UserAstroInfo` DISABLE KEYS */;
INSERT INTO `UserAstroInfo` VALUES
(370,5,'yang fire','yang fire','horse','yin metal','yin wood','rabbit','yang metal','yang metal','monkey','yang earth','yang wood','tiger','Early Autumn','planetary','worldBridger','166','Leo 19 34 50','Sco 23 07 47','Ari 18 33 42'),
(386,4,'yang fire','yang fire','horse','yang metal','yang earth','dragon','yang metal','yang fire','horse','yin earth','yin water','pig','Mid Summer','solar','dog','230','Gem 21 15 12','Vir 19 41 22','Lib 20 44 20'),
(1003,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `UserAstroInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserBirthInfo`
--

DROP TABLE IF EXISTS `UserBirthInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserBirthInfo` (
  `userID` int(255) NOT NULL AUTO_INCREMENT,
  `sex` char(1) DEFAULT NULL,
  `month` char(2) DEFAULT NULL,
  `day` char(2) DEFAULT NULL,
  `year` varchar(4) DEFAULT NULL,
  `birthdate` varchar(16) DEFAULT '01/01/2024',
  `hour` char(2) DEFAULT NULL,
  `minute` char(2) DEFAULT NULL,
  `birthtime` varchar(6) DEFAULT NULL,
  `unknownTime` int(1) DEFAULT NULL,
  `timezone` varchar(10) DEFAULT '1',
  `timezone_txt` varchar(30) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `birthCountry` varchar(20) DEFAULT NULL,
  `long_deg` char(3) DEFAULT NULL,
  `long_min` char(2) DEFAULT NULL,
  `ew` char(2) DEFAULT NULL,
  `lat_deg` char(2) DEFAULT NULL,
  `lat_min` char(2) DEFAULT NULL,
  `ns` char(2) DEFAULT NULL,
  `long_secs` varchar(20) DEFAULT NULL,
  `lat_secs` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`userID`),
  CONSTRAINT `fk_UserBirthInfo_Users` FOREIGN KEY (`userID`) REFERENCES `Users` (`userID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1004 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserBirthInfo`
--

LOCK TABLES `UserBirthInfo` WRITE;
/*!40000 ALTER TABLE `UserBirthInfo` DISABLE KEYS */;
INSERT INTO `UserBirthInfo` VALUES
(370,NULL,'08','12','1998','12/08/1998','12','00','12:00',NULL,'1','Europe/Athens','Athens','Greece',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(386,NULL,'06','12','2019','12/06/2019','12','00','12:00',NULL,'1','Europe/Madrid','madrid','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
(1003,NULL,NULL,NULL,NULL,'01/01/2024',NULL,NULL,NULL,NULL,'1',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `UserBirthInfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `update_day_month_year_trigger` BEFORE UPDATE ON `UserBirthInfo` FOR EACH ROW BEGIN
    SET NEW.day = SUBSTRING_INDEX(SUBSTRING_INDEX(NEW.birthDate, '/', 1), '/', -1);
    SET NEW.month = SUBSTRING_INDEX(SUBSTRING_INDEX(NEW.birthDate, '/', 2), '/', -1);
    SET NEW.year = SUBSTRING_INDEX(SUBSTRING_INDEX(NEW.birthDate, '/', 3), '/', -1);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `update_hour_minute_trigger` BEFORE UPDATE ON `UserBirthInfo` FOR EACH ROW BEGIN
    SET NEW.hour = SUBSTRING_INDEX(NEW.birthTime, ':', 1);
    SET NEW.minute = SUBSTRING_INDEX(NEW.birthTime, ':', -1);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `UserChatMessages`
--

DROP TABLE IF EXISTS `UserChatMessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserChatMessages` (
  `messageID` varchar(30) NOT NULL,
  `sender_id` bigint(20) DEFAULT NULL,
  `receiver_id` bigint(20) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` datetime DEFAULT NULL,
  `read_status` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`messageID`),
  KEY `idx_sender` (`sender_id`),
  KEY `idx_receiver` (`receiver_id`),
  KEY `idx_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserChatMessages`
--

LOCK TABLES `UserChatMessages` WRITE;
/*!40000 ALTER TABLE `UserChatMessages` DISABLE KEYS */;
INSERT INTO `UserChatMessages` VALUES
('MID_0370_0381_20240731055541',370,381,'sdaa','2024-07-31 05:55:41',0);
/*!40000 ALTER TABLE `UserChatMessages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserInterests`
--

DROP TABLE IF EXISTS `UserInterests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserInterests` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `interests` longtext NOT NULL DEFAULT '{}',
  `lookingFor` varchar(255) NOT NULL DEFAULT ' ',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=387 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserInterests`
--

LOCK TABLES `UserInterests` WRITE;
/*!40000 ALTER TABLE `UserInterests` DISABLE KEYS */;
INSERT INTO `UserInterests` VALUES
(370,'{}','Women'),
(373,'{}','Men'),
(386,'{}','Women');
/*!40000 ALTER TABLE `UserInterests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserMatches`
--

DROP TABLE IF EXISTS `UserMatches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserMatches` (
  `userA_ID` int(11) NOT NULL,
  `userB_ID` int(11) NOT NULL,
  `matchID` text NOT NULL,
  `Score_Cn` int(11) NOT NULL,
  `Score_My` int(11) NOT NULL,
  `Score_Zd` int(11) NOT NULL,
  `Score_Hd` int(11) NOT NULL,
  `Score_Num` int(11) NOT NULL,
  `Score_Total` int(5) NOT NULL,
  PRIMARY KEY (`matchID`(7)) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserMatches`
--

LOCK TABLES `UserMatches` WRITE;
/*!40000 ALTER TABLE `UserMatches` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserMatches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserProfInfo`
--

DROP TABLE IF EXISTS `UserProfInfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserProfInfo` (
  `userId` int(11) NOT NULL,
  `profession` varchar(20) DEFAULT NULL,
  `position` varchar(20) DEFAULT NULL,
  `sector` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserProfInfo`
--

LOCK TABLES `UserProfInfo` WRITE;
/*!40000 ALTER TABLE `UserProfInfo` DISABLE KEYS */;
INSERT INTO `UserProfInfo` VALUES
(370,'Tennis Player',NULL,NULL),
(386,'Lawyer',NULL,NULL),
(1003,NULL,NULL,NULL);
/*!40000 ALTER TABLE `UserProfInfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `userID` int(255) NOT NULL AUTO_INCREMENT,
  `created_at` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `new` int(1) DEFAULT 1,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `looking` varchar(255) DEFAULT NULL,
  `profilePicture` varchar(100) DEFAULT NULL,
  `aboutMe` text DEFAULT NULL,
  `data_visibility` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=1004 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES
(370,NULL,NULL,0,'stefanos','Tsitsipas@g,com','$2y$10$wFfxvrc5/v4acZE9c16Dye4zBEuisOw7wJDvFtJv14HlTiq6O4KMC','Stefanos','Tsitsipas','Male',NULL,'1719945830_614259e5dd8c452ef591.png','i am great and i love sex and tennis at table','{\"name\":\"1\",\"surname\":\"1\",\"sex\":\"1\",\"bdate\":\"1\",\"city\":null,\"profession\":\"1\",\"aboutMe\":null,\"lookingFor\":\"1\"}'),
(386,NULL,NULL,0,'rajo','rajo@rajo.com','$2y$10$uiSL0vmnP6TiT4p2JzEU/OXcPFkgSEETbB/eAqvGuZFVUNYcTi.Vq','ra','jo','Male',NULL,NULL,'Tell a little bit about yourself','{\"name\":null,\"surname\":null,\"sex\":null,\"bdate\":null,\"city\":null,\"profession\":null,\"aboutMe\":null,\"lookingFor\":null}'),
(387,NULL,NULL,1,'melaniedoutey','doutey@g.com','$2y$10$dXhPFfIWlzRG5TAlumVIC.f9CjHZWPMkBt/0CtQLYYRmZs3.VCX.a',NULL,NULL,NULL,NULL,NULL,NULL,'{}'),
(1003,NULL,NULL,1,'dula','dula@r.com','$2y$10$j9E/6CAx9TrLKDyAheks2ew9yNlqT0CGbRI.D9BZ/JgDnMsWPD5Em',NULL,NULL,NULL,NULL,NULL,NULL,'{}');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `populate_userAstroInfo_userID` AFTER INSERT ON `Users` FOR EACH ROW BEGIN
    INSERT INTO UserAstroInfo (userID) VALUES (NEW.userID);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `populate_userBirthInfo_timeZone` AFTER INSERT ON `Users` FOR EACH ROW BEGIN
    DECLARE userExists INT;

    SELECT COUNT(*) INTO userExists FROM UserBirthInfo WHERE userID = NEW.userID;

    IF userExists = 0 THEN
        INSERT INTO UserBirthInfo (userID, timezone) VALUES (NEW.userID, 1);
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `populate_userProfInfo_userID` AFTER INSERT ON `Users` FOR EACH ROW BEGIN
    INSERT INTO UserProfInfo (userID) VALUES (NEW.userID);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `delete_user_astro_info_trigger` BEFORE DELETE ON `Users` FOR EACH ROW BEGIN
    DELETE FROM UserAstroInfo WHERE userID = OLD.userID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `delete_user_birth_info_trigger` BEFORE DELETE ON `Users` FOR EACH ROW BEGIN
    DELETE FROM UserBirthInfo WHERE userID = OLD.userID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `delete_user_matches_trigger` BEFORE DELETE ON `Users` FOR EACH ROW BEGIN
    DELETE FROM UserMatches WHERE userA_ID = OLD.userID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `delete_user_prof_info_trigger` BEFORE DELETE ON `Users` FOR EACH ROW BEGIN
    DELETE FROM UserProfInfo WHERE userID = OLD.userID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `delete_user_interests_trigger` BEFORE DELETE ON `Users`
 FOR EACH ROW BEGIN
    DELETE FROM UserInterests WHERE userID = OLD.userID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`neo`@`localhost`*/ /*!50003 TRIGGER `delete_user_chat_messages_trigger` BEFORE DELETE ON `Users` FOR EACH ROW BEGIN
    DELETE FROM UserChatMessages WHERE sender_id = OLD.userID;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `Users_backup`
--

DROP TABLE IF EXISTS `Users_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users_backup` (
  `userID` int(255) NOT NULL DEFAULT 0,
  `created_at` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `new` int(1) DEFAULT 1,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `sex` varchar(255) DEFAULT NULL,
  `looking` varchar(255) DEFAULT NULL,
  `profilePicture` varchar(100) DEFAULT NULL,
  `aboutMe` text DEFAULT NULL,
  `data_visibility` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '{}'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users_backup`
--

LOCK TABLES `Users_backup` WRITE;
/*!40000 ALTER TABLE `Users_backup` DISABLE KEYS */;
INSERT INTO `Users_backup` VALUES
(370,NULL,NULL,0,'stefanos','Tsitsipas@g,com','$2y$10$wFfxvrc5/v4acZE9c16Dye4zBEuisOw7wJDvFtJv14HlTiq6O4KMC','timezone','Tsitsipas','Male',NULL,'1719945830_614259e5dd8c452ef591.png','i am great and i love sex and tennis at table','{\"name\":\"1\",\"surname\":\"1\",\"sex\":\"1\",\"bdate\":\"1\",\"city\":\"1\",\"profession\":\"1\",\"aboutMe\":null,\"lookingFor\":\"1\"}'),
(381,NULL,NULL,0,'zorrita','zorri@g.com','$2y$10$GN06J4ZfQdX8meuqCFxWguP1xEPZb/BMv7kx6TuW/NupUf/pziRAK','samantha','fox','Female',NULL,'1716846214_e8ab47c66cf8fef7e366.png','I am superb MILF who loves to eat dick and swallow your cum','{\"name\":\"1\",\"surname\":\"1\",\"sex\":\"1\",\"bdate\":\"1\",\"city\":\"1\",\"profession\":\"1\",\"aboutMe\":null,\"lookingFor\":\"1\"}'),
(386,NULL,NULL,0,'rajo','rajo@rajo.com','$2y$10$uiSL0vmnP6TiT4p2JzEU/OXcPFkgSEETbB/eAqvGuZFVUNYcTi.Vq','ra','jo','Male',NULL,NULL,'Tell a little bit about yourself','{\"name\":null,\"surname\":null,\"sex\":null,\"bdate\":null,\"city\":null,\"profession\":null,\"aboutMe\":null,\"lookingFor\":null}');
/*!40000 ALTER TABLE `Users_backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_scores_eb_eb_scores`
--

DROP TABLE IF EXISTS `match_scores_eb_eb_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_scores_eb_eb_scores` (
  `id` varchar(2) NOT NULL,
  `score` int(11) NOT NULL,
  `compared` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_scores_eb_eb_scores`
--

LOCK TABLES `match_scores_eb_eb_scores` WRITE;
/*!40000 ALTER TABLE `match_scores_eb_eb_scores` DISABLE KEYS */;
INSERT INTO `match_scores_eb_eb_scores` VALUES
('aa',3,0),
('ab',3,0),
('ac',3,0),
('ad',3,0),
('ae',3,0),
('af',3,0),
('ag',3,0),
('ah',3,0),
('ai',3,0),
('aj',3,0),
('ak',3,0),
('al',3,0),
('ba',3,0),
('bb',3,0),
('bc',3,0),
('bd',3,0),
('be',3,0),
('bf',3,0),
('bg',3,0),
('bh',3,0),
('bi',3,0),
('bj',3,0),
('bk',3,0),
('bl',3,0),
('ca',3,0),
('cb',3,0),
('cc',3,0),
('cd',3,0),
('ce',3,0),
('cf',3,0),
('cg',3,0),
('ch',3,0),
('ci',3,0),
('cj',3,0),
('ck',3,0),
('cl',3,0),
('da',3,0),
('db',3,0),
('dc',3,0),
('dd',3,0),
('de',3,0),
('df',3,0),
('dg',3,0),
('dh',3,0),
('di',3,0),
('dj',3,0),
('dk',3,0),
('dl',3,0),
('ea',3,0),
('eb',3,0),
('ec',3,0),
('ed',3,0),
('ee',3,0),
('ef',3,0),
('eg',3,0),
('eh',3,0),
('ei',3,0),
('ej',3,0),
('ek',3,0),
('el',3,0),
('fa',3,0),
('fb',3,0),
('fc',3,0),
('fd',3,0),
('fe',3,0),
('ff',3,0),
('fg',3,0),
('fh',3,0),
('fi',3,0),
('fj',3,0),
('fk',3,0),
('fl',3,0),
('ga',3,0),
('gb',3,0),
('gc',3,0),
('gd',3,0),
('ge',3,0),
('gf',3,0),
('gg',3,0),
('gh',3,0),
('gi',3,0),
('gj',3,0),
('gk',3,0),
('gl',3,0),
('ha',3,0),
('hb',3,0),
('hc',3,0),
('hd',3,0),
('he',3,0),
('hf',3,0),
('hg',3,0),
('hh',3,0),
('hi',3,0),
('hj',3,0),
('hk',3,0),
('hl',3,0),
('ia',3,0),
('ib',3,0),
('ic',3,0),
('id',3,0),
('ie',3,0),
('if',3,0),
('ig',3,0),
('ih',3,0),
('ii',3,0),
('ij',3,0),
('ik',3,0),
('il',3,0),
('ja',3,0),
('jb',3,0),
('jc',3,0),
('jd',3,0),
('je',3,0),
('jf',3,0),
('jg',3,0),
('jh',3,0),
('ji',3,0),
('jj',3,0),
('jk',3,0),
('jl',3,0),
('ka',3,0),
('kb',3,0),
('kc',3,0),
('kd',3,0),
('ke',3,0),
('kf',3,0),
('kg',3,0),
('kh',3,0),
('ki',3,0),
('kj',3,0),
('kk',3,0),
('kl',3,0),
('la',3,0),
('lb',3,0),
('lc',3,0),
('ld',3,0),
('le',3,0),
('lf',3,0),
('lg',3,0),
('lh',3,0),
('li',3,0),
('lj',3,0),
('lk',3,0),
('ll',3,0);
/*!40000 ALTER TABLE `match_scores_eb_eb_scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_scores_eb_eb_weights`
--

DROP TABLE IF EXISTS `match_scores_eb_eb_weights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_scores_eb_eb_weights` (
  `id` varchar(2) NOT NULL,
  `score` int(11) NOT NULL,
  `compared` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_scores_eb_eb_weights`
--

LOCK TABLES `match_scores_eb_eb_weights` WRITE;
/*!40000 ALTER TABLE `match_scores_eb_eb_weights` DISABLE KEYS */;
INSERT INTO `match_scores_eb_eb_weights` VALUES
('hh',3,1),
('hd',3,1),
('hm',3,1),
('hy',3,1),
('dh',3,1),
('dd',3,1),
('dm',3,1),
('dy',3,1),
('mh',3,1),
('md',3,1),
('mm',3,1),
('my',3,1),
('yh',3,1),
('yd',3,1),
('ym',3,1),
('yy',3,1);
/*!40000 ALTER TABLE `match_scores_eb_eb_weights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_scores_hs_hs_scores`
--

DROP TABLE IF EXISTS `match_scores_hs_hs_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_scores_hs_hs_scores` (
  `id` varchar(2) NOT NULL,
  `score` int(11) NOT NULL,
  `compared` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_scores_hs_hs_scores`
--

LOCK TABLES `match_scores_hs_hs_scores` WRITE;
/*!40000 ALTER TABLE `match_scores_hs_hs_scores` DISABLE KEYS */;
INSERT INTO `match_scores_hs_hs_scores` VALUES
('aa',3,1),
('ab',3,0),
('ac',3,0),
('ad',3,0),
('ae',3,0),
('af',3,0),
('ag',3,0),
('ah',3,0),
('ai',3,0),
('aj',3,0),
('ba',3,1),
('bb',3,0),
('bc',3,0),
('bd',3,0),
('be',3,0),
('bf',3,0),
('bg',3,0),
('bh',3,0),
('bi',3,0),
('bj',3,0),
('ca',3,0),
('cb',3,0),
('cc',3,1),
('cd',3,1),
('ce',3,0),
('cf',3,0),
('cg',3,0),
('ch',3,0),
('ci',3,0),
('cj',3,0),
('da',3,0),
('db',3,0),
('dc',3,1),
('dd',3,0),
('de',3,0),
('df',3,0),
('dg',3,0),
('dh',3,0),
('di',3,0),
('dj',3,0),
('ea',3,0),
('eb',3,0),
('ec',3,0),
('ed',3,0),
('ee',3,0),
('ef',3,0),
('eg',3,0),
('eh',3,0),
('ei',3,0),
('ej',3,0),
('fa',3,0),
('fb',3,0),
('fc',3,0),
('fd',3,0),
('fe',3,0),
('ff',3,0),
('fg',3,0),
('fh',3,0),
('fi',3,0),
('fj',3,0),
('ga',3,0),
('gb',3,0),
('gc',3,0),
('gd',3,0),
('ge',3,0),
('gf',3,0),
('gg',3,0),
('gh',3,0),
('gi',3,0),
('gj',3,0),
('ha',3,0),
('hb',3,0),
('hc',3,0),
('hd',3,0),
('he',3,0),
('hf',3,0),
('hg',3,0),
('hh',3,0),
('hi',3,0),
('hj',3,0),
('ia',3,0),
('ib',3,1),
('ic',3,0),
('id',3,0),
('ie',3,0),
('if',3,0),
('ig',3,0),
('ih',3,0),
('ii',3,0),
('ij',3,0),
('ja',3,0),
('jb',3,0),
('jc',3,0),
('jd',3,0),
('je',3,0),
('jf',3,0),
('jg',3,0),
('jh',3,0),
('ji',3,0),
('jj',3,0);
/*!40000 ALTER TABLE `match_scores_hs_hs_scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_scores_hs_hs_weights`
--

DROP TABLE IF EXISTS `match_scores_hs_hs_weights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_scores_hs_hs_weights` (
  `id` varchar(2) NOT NULL,
  `score` int(11) NOT NULL,
  `compared` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_scores_hs_hs_weights`
--

LOCK TABLES `match_scores_hs_hs_weights` WRITE;
/*!40000 ALTER TABLE `match_scores_hs_hs_weights` DISABLE KEYS */;
INSERT INTO `match_scores_hs_hs_weights` VALUES
('hh',3,1),
('hd',3,1),
('hm',3,1),
('hy',3,1),
('dh',3,1),
('dd',3,1),
('dm',3,1),
('dy',3,1),
('mh',3,1),
('md',3,1),
('mm',3,1),
('my',3,1),
('yh',3,1),
('yd',3,1),
('ym',3,1),
('yy',3,1);
/*!40000 ALTER TABLE `match_scores_hs_hs_weights` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_scores_na_na_scores`
--

DROP TABLE IF EXISTS `match_scores_na_na_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_scores_na_na_scores` (
  `id` varchar(2) NOT NULL,
  `score` int(11) NOT NULL,
  `compared` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_scores_na_na_scores`
--

LOCK TABLES `match_scores_na_na_scores` WRITE;
/*!40000 ALTER TABLE `match_scores_na_na_scores` DISABLE KEYS */;
INSERT INTO `match_scores_na_na_scores` VALUES
('aa',3,0),
('ab',3,0),
('ac',3,0),
('ad',3,0),
('ae',3,0),
('af',3,0),
('ag',3,0),
('ah',3,0),
('ai',3,0),
('aj',3,0),
('ak',3,0),
('al',3,0),
('am',3,0),
('an',3,0),
('ao',3,0),
('ap',3,0),
('aq',3,0),
('ar',3,0),
('as',3,0),
('at',3,0),
('au',3,0),
('av',3,0),
('aw',3,0),
('ax',3,0),
('ay',3,0),
('az',3,0),
('ba',3,0),
('bb',3,0),
('bc',3,0),
('bd',3,0),
('be',3,0),
('bf',3,0),
('bg',3,0),
('bh',3,0),
('bi',3,0),
('bj',3,0),
('bk',3,0),
('bl',3,0),
('bm',3,0),
('bn',3,0),
('bo',3,0),
('bp',3,0),
('bq',3,0),
('br',3,0),
('bs',3,0),
('bt',3,0),
('bu',3,0),
('bv',3,0),
('bw',3,0),
('bx',3,0),
('by',3,0),
('bz',3,0),
('ca',3,0),
('cb',3,0),
('cc',3,0),
('cd',3,0),
('ce',3,0),
('cf',3,0),
('cg',3,0),
('ch',3,0),
('ci',3,0),
('cj',3,0),
('ck',3,0),
('cl',3,0),
('cm',3,0),
('cn',3,0),
('co',3,0),
('cp',3,0),
('cq',3,0),
('cr',3,0),
('cs',3,0),
('ct',3,0),
('cu',3,0),
('cv',3,0),
('cw',3,0),
('cx',3,0),
('cy',3,0),
('cz',3,0),
('da',3,0),
('db',3,0),
('dc',3,0),
('dd',3,0),
('de',3,0),
('df',3,0),
('dg',3,0),
('dh',3,0),
('di',3,0),
('dj',3,0),
('dk',3,0),
('dl',3,0),
('dm',3,0),
('dn',3,0),
('do',3,0),
('dp',3,0),
('dq',3,0),
('dr',3,0),
('ds',3,0),
('dt',3,0),
('du',3,0),
('dv',3,0),
('dw',3,0),
('dx',3,0),
('dy',3,0),
('dz',3,0),
('ea',3,0),
('eb',3,0),
('ec',3,0),
('ed',3,0),
('ee',3,0),
('ef',3,0),
('eg',3,0),
('eh',3,0),
('ei',3,0),
('ej',3,0),
('ek',3,0),
('el',3,0),
('em',3,0),
('en',3,0),
('eo',3,0),
('ep',3,0),
('eq',3,0),
('er',3,0),
('es',3,0),
('et',3,0),
('eu',3,0),
('ev',3,0),
('ew',3,0),
('ex',3,0),
('ey',3,0),
('ez',3,0),
('fa',3,0),
('fb',3,0),
('fc',3,0),
('fd',3,0),
('fe',3,0),
('ff',3,0),
('fg',3,0),
('fh',3,0),
('fi',3,0),
('fj',3,0),
('fk',3,0),
('fl',3,0),
('fm',3,0),
('fn',3,0),
('fo',3,0),
('fp',3,0),
('fq',3,0),
('fr',3,0),
('fs',3,0),
('ft',3,0),
('fu',3,0),
('fv',3,0),
('fw',3,0),
('fx',3,0),
('fy',3,0),
('fz',3,0),
('ga',3,0),
('gb',3,0),
('gc',3,0),
('gd',3,0),
('ge',3,0),
('gf',3,0),
('gg',3,0),
('gh',3,0),
('gi',3,0),
('gj',3,0),
('gk',3,0),
('gl',3,0),
('gm',3,0),
('gn',3,0),
('go',3,0),
('gp',3,0),
('gq',3,0),
('gr',3,0),
('gs',3,0),
('gt',3,0),
('gu',3,0),
('gv',3,0),
('gw',3,0),
('gx',3,0),
('gy',3,0),
('gz',3,0),
('ha',3,0),
('hb',3,0),
('hc',3,0),
('hd',3,0),
('he',3,0),
('hf',3,0),
('hg',3,0),
('hh',3,0),
('hi',3,0),
('hj',3,0),
('hk',3,0),
('hl',3,0),
('hm',3,0),
('hn',3,0),
('ho',3,0),
('hp',3,0),
('hq',3,0),
('hr',3,0),
('hs',3,0),
('ht',3,0),
('hu',3,0),
('hv',3,0),
('hw',3,0),
('hx',3,0),
('hy',3,0),
('hz',3,0),
('ia',3,0),
('ib',3,0),
('ic',3,0),
('id',3,0),
('ie',3,0),
('if',3,0),
('ig',3,0),
('ih',3,0),
('ii',3,0),
('ij',3,0),
('ik',3,0),
('il',3,0),
('im',3,0),
('in',3,0),
('io',3,0),
('ip',3,0),
('iq',3,0),
('ir',3,0),
('is',3,0),
('it',3,0),
('iu',3,0),
('iv',3,0),
('iw',3,0),
('ix',3,0),
('iy',3,0),
('iz',3,0),
('ja',3,0),
('jb',3,0),
('jc',3,0),
('jd',3,0),
('je',3,0),
('jf',3,0),
('jg',3,0),
('jh',3,0),
('ji',3,0),
('jj',3,0),
('jk',3,0),
('jl',3,0),
('jm',3,0),
('jn',3,0),
('jo',3,0),
('jp',3,0),
('jq',3,0),
('jr',3,0),
('js',3,0),
('jt',3,0),
('ju',3,0),
('jv',3,0),
('jw',3,0),
('jx',3,0),
('jy',3,0),
('jz',3,0),
('ka',3,0),
('kb',3,0),
('kc',3,0),
('kd',3,0),
('ke',3,0),
('kf',3,0),
('kg',3,0),
('kh',3,0),
('ki',3,0),
('kj',3,0),
('kk',3,0),
('kl',3,0),
('km',3,0),
('kn',3,0),
('ko',3,0),
('kp',3,0),
('kq',3,0),
('kr',3,0),
('ks',3,0),
('kt',3,0),
('ku',3,0),
('kv',3,0),
('kw',3,0),
('kx',3,0),
('ky',3,0),
('kz',3,0),
('la',3,0),
('lb',3,0),
('lc',3,0),
('ld',3,0),
('le',3,0),
('lf',3,0),
('lg',3,0),
('lh',3,0),
('li',3,0),
('lj',3,0),
('lk',3,0),
('ll',3,0),
('lm',3,0),
('ln',3,0),
('lo',3,0),
('lp',3,0),
('lq',3,0),
('lr',3,0),
('ls',3,0),
('lt',3,0),
('lu',3,0),
('lv',3,0),
('lw',3,0),
('lx',3,0),
('ly',3,0),
('lz',3,0),
('ma',3,0),
('mb',3,0),
('mc',3,0),
('md',3,0),
('me',3,0),
('mf',3,0),
('mg',3,0),
('mh',3,0),
('mi',3,0),
('mj',3,0),
('mk',3,0),
('ml',3,0),
('mm',3,0),
('mn',3,0),
('mo',3,0),
('mp',3,0),
('mq',3,0),
('mr',3,0),
('ms',3,0),
('mt',3,0),
('mu',3,0),
('mv',3,0),
('mw',3,0),
('mx',3,0),
('my',3,0),
('mz',3,0),
('na',3,0),
('nb',3,0),
('nc',3,0),
('nd',3,0),
('ne',3,0),
('nf',3,0),
('ng',3,0),
('nh',3,0),
('ni',3,0),
('nj',3,0),
('nk',3,0),
('nl',3,0),
('nm',3,0),
('nn',3,0),
('no',3,0),
('np',3,0),
('nq',3,0),
('nr',3,0),
('ns',3,0),
('nt',3,0),
('nu',3,0),
('nv',3,0),
('nw',3,0),
('nx',3,0),
('ny',3,0),
('nz',3,0),
('oa',3,0),
('ob',3,0),
('oc',3,0),
('od',3,0),
('oe',3,0),
('of',3,0),
('og',3,0),
('oh',3,0),
('oi',3,0),
('oj',3,0),
('ok',3,0),
('ol',3,0),
('om',3,0),
('on',3,0),
('oo',3,0),
('op',3,0),
('oq',3,0),
('or',3,0),
('os',3,0),
('ot',3,0),
('ou',3,0),
('ov',3,0),
('ou',3,0),
('ov',3,0),
('ow',3,0),
('ox',3,0),
('oy',3,0),
('oz',3,0),
('pa',3,0),
('pb',3,0),
('pc',3,0),
('pd',3,0),
('pe',3,0),
('pf',3,0),
('pg',3,0),
('ph',3,0),
('pi',3,0),
('pj',3,0),
('pk',3,0),
('pl',3,0),
('pm',3,0),
('pn',3,0),
('po',3,0),
('pp',3,0),
('pq',3,0),
('pr',3,0),
('ps',3,0),
('pt',3,0),
('pu',3,0),
('pv',3,0),
('pw',3,0),
('px',3,0),
('py',3,0),
('pz',3,0),
('qa',3,0),
('qb',3,0),
('qc',3,0),
('qd',3,0),
('qe',3,0),
('qf',3,0),
('qg',3,0),
('qh',3,0),
('qi',3,0),
('qj',3,0),
('qk',3,0),
('ql',3,0),
('qm',3,0),
('qn',3,0),
('qo',3,0),
('qp',3,0),
('qq',3,0),
('qr',3,0),
('qs',3,0),
('qt',3,0),
('qu',3,0),
('qv',3,0),
('qw',3,0),
('qx',3,0),
('qy',3,0),
('qz',3,0),
('ra',3,0),
('rb',3,0),
('rc',3,0),
('rd',3,0),
('re',3,0),
('rf',3,0),
('rg',3,0),
('rh',3,0),
('ri',3,0),
('rj',3,0),
('rk',3,0),
('rl',3,0),
('rm',3,0),
('rn',3,0),
('ro',3,0),
('rp',3,0),
('rq',3,0),
('rr',3,0),
('rs',3,0),
('rt',3,0),
('ru',3,0),
('rv',3,0),
('rw',3,0),
('rx',3,0),
('ry',3,0),
('rz',3,0),
('sa',3,0),
('sb',3,0),
('sc',3,0),
('sd',3,0),
('se',3,0),
('sf',3,0),
('sg',3,0),
('sh',3,0),
('si',3,0),
('sj',3,0),
('sk',3,0),
('sl',3,0),
('sm',3,0),
('sn',3,0),
('so',3,0),
('sp',3,0),
('sq',3,0),
('sr',3,0),
('ss',3,0),
('st',3,0),
('su',3,0),
('sv',3,0),
('sw',3,0),
('sx',3,0),
('sy',3,0),
('sz',3,0),
('ta',3,0),
('tb',3,0),
('tc',3,0),
('td',3,0),
('te',3,0),
('tf',3,0),
('tg',3,0),
('th',3,0),
('ti',3,0),
('tj',3,0),
('tk',3,0),
('tl',3,0),
('tm',3,0),
('tn',3,0),
('to',3,0),
('tp',3,0),
('tq',3,0),
('tr',3,0),
('ts',3,0),
('tt',3,0),
('tu',3,0),
('tv',3,0),
('tw',3,0),
('tx',3,0),
('ty',3,0),
('tz',3,0),
('ua',3,0),
('ub',3,0),
('uc',3,0),
('ud',3,0),
('ue',3,0),
('uf',3,0),
('ug',3,0),
('uh',3,0),
('ui',3,0),
('uj',3,0),
('uk',3,0),
('ul',3,0),
('um',3,0),
('un',3,0),
('uo',3,0),
('up',3,0),
('uq',3,0),
('ur',3,0),
('us',3,0),
('ut',3,0),
('uu',3,0),
('uv',3,0),
('uw',3,0),
('ux',3,0),
('uy',3,0),
('uz',3,0),
('va',3,0),
('vb',3,0),
('vc',3,0),
('vd',3,0),
('ve',3,0),
('vf',3,0),
('vg',3,0),
('vh',3,0),
('vi',3,0),
('vj',3,0),
('vk',3,0),
('vl',3,0),
('vm',3,0),
('vn',3,0),
('vo',3,0),
('vp',3,0),
('vq',3,0),
('vr',3,0),
('vs',3,0),
('vt',3,0),
('vu',3,0),
('vv',3,0),
('vw',3,0),
('vx',3,0),
('vy',3,0),
('vz',3,0),
('wa',3,0),
('wb',3,0),
('wc',3,0),
('wd',3,0),
('we',3,0),
('wf',3,0),
('wg',3,0),
('wh',3,0),
('wi',3,0),
('wj',3,0),
('wk',3,0),
('wl',3,0),
('wm',3,0),
('wn',3,0),
('wo',3,0),
('wp',3,0),
('wq',3,0),
('wr',3,0),
('ws',3,0),
('wt',3,0),
('wu',3,0),
('wv',3,0),
('ww',3,0),
('wx',3,0),
('wy',3,0),
('wz',3,0),
('xa',3,0),
('xb',3,0),
('xc',3,0),
('xd',3,0),
('xe',3,0),
('xf',3,0),
('xg',3,0),
('xh',3,0),
('xi',3,0),
('xj',3,0),
('xk',3,0),
('xl',3,0),
('xm',3,0),
('xn',3,0),
('xo',3,0),
('xp',3,0),
('xq',3,0),
('xr',3,0),
('xs',3,0),
('xt',3,0),
('xu',3,0),
('xv',3,0),
('xw',3,0),
('xx',3,0),
('xy',3,0),
('xz',3,0),
('ya',3,0),
('yb',3,0),
('yc',3,0),
('yd',3,0),
('ye',3,0),
('yf',3,0),
('yg',3,0),
('yh',3,0),
('yi',3,0),
('yj',3,0),
('yk',3,0),
('yl',3,0),
('ym',3,0),
('yn',3,0),
('yo',3,0),
('yp',3,0),
('yq',3,0),
('yr',3,0),
('ys',3,0),
('yt',3,0),
('yu',3,0),
('yv',3,0),
('yw',3,0),
('yx',3,0),
('yy',3,0),
('yz',3,0),
('za',3,0),
('zb',3,0),
('zc',3,0),
('zd',3,0),
('ze',3,0),
('zf',3,0),
('zg',3,0),
('zh',3,0),
('zi',3,0),
('zj',3,0),
('zk',3,0),
('zl',3,0),
('zm',3,0),
('zn',3,0),
('zo',3,0),
('zp',3,0),
('zq',3,0),
('zr',3,0),
('zs',3,0),
('zt',3,0),
('zu',3,0),
('zv',3,0),
('zw',3,0),
('zx',3,0),
('zy',3,0),
('zz',3,0);
/*!40000 ALTER TABLE `match_scores_na_na_scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_scores_zd_zd_scores`
--

DROP TABLE IF EXISTS `match_scores_zd_zd_scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_scores_zd_zd_scores` (
  `id` varchar(2) NOT NULL,
  `score` int(11) NOT NULL,
  `compared` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_scores_zd_zd_scores`
--

LOCK TABLES `match_scores_zd_zd_scores` WRITE;
/*!40000 ALTER TABLE `match_scores_zd_zd_scores` DISABLE KEYS */;
INSERT INTO `match_scores_zd_zd_scores` VALUES
('aa',3,0),
('ab',3,0),
('ac',3,0),
('ad',3,0),
('ae',3,0),
('af',3,0),
('ag',3,0),
('ah',3,0),
('ai',3,0),
('aj',3,0),
('ak',3,0),
('al',3,0),
('ba',3,0),
('bb',3,0),
('bc',3,0),
('bd',3,0),
('be',3,0),
('bf',3,0),
('bg',3,0),
('bh',3,0),
('bi',3,0),
('bj',3,0),
('bk',3,0),
('bl',3,0),
('ca',3,0),
('cb',3,0),
('cc',3,0),
('cd',3,0),
('ce',3,0),
('cf',3,0),
('cg',3,0),
('ch',3,0),
('ci',3,0),
('cj',3,0),
('ck',3,0),
('cl',3,0),
('da',3,0),
('db',3,0),
('dc',3,0),
('dd',3,0),
('de',3,0),
('df',3,0),
('dg',3,0),
('dh',3,0),
('di',3,0),
('dj',3,0),
('dk',3,0),
('dl',3,0),
('ea',3,0),
('eb',3,0),
('ec',3,0),
('ed',3,0),
('ee',3,0),
('ef',3,0),
('eg',3,0),
('eh',3,0),
('ei',3,0),
('ej',3,0),
('ek',3,0),
('el',3,0),
('fa',3,0),
('fb',3,0),
('fc',3,0),
('fd',3,0),
('fe',3,0),
('ff',3,0),
('fg',3,0),
('fh',3,0),
('fi',3,0),
('fj',3,0),
('fk',3,0),
('fl',3,0),
('ga',3,0),
('gb',3,0),
('gc',3,0),
('gd',3,0),
('ge',3,0),
('gf',3,0),
('gg',3,0),
('gh',3,0),
('gi',3,0),
('gj',3,0),
('gk',3,0),
('gl',3,0),
('ha',3,0),
('hb',3,0),
('hc',3,0),
('hd',3,0),
('he',3,0),
('hf',3,0),
('hg',3,0),
('hh',3,0),
('hi',3,0),
('hj',3,0),
('hk',3,0),
('hl',3,0),
('ia',3,0),
('ib',3,0),
('ic',3,0),
('id',3,0),
('ie',3,0),
('if',3,0),
('ig',3,0),
('ih',3,0),
('ii',3,0),
('ij',3,0),
('ik',3,0),
('il',3,0),
('ja',3,0),
('jb',3,0),
('jc',3,0),
('jd',3,0),
('je',3,0),
('jf',3,0),
('jg',3,0),
('jh',3,0),
('ji',3,0),
('jj',3,0),
('jk',3,0),
('jl',3,0),
('ka',3,0),
('kb',3,0),
('kc',3,0),
('kd',3,0),
('ke',3,0),
('kf',3,0),
('kg',3,0),
('kh',3,0),
('ki',3,0),
('kj',3,0),
('kk',3,0),
('kl',3,0),
('la',3,0),
('lb',3,0),
('lc',3,0),
('ld',3,0),
('le',3,0),
('lf',3,0),
('lg',3,0),
('lh',3,0),
('li',3,0),
('lj',3,0),
('lk',3,0),
('ll',3,0);
/*!40000 ALTER TABLE `match_scores_zd_zd_scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `match_scores_zd_zd_weights`
--

DROP TABLE IF EXISTS `match_scores_zd_zd_weights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `match_scores_zd_zd_weights` (
  `id` varchar(2) NOT NULL,
  `score` int(11) NOT NULL,
  `compared` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `match_scores_zd_zd_weights`
--

LOCK TABLES `match_scores_zd_zd_weights` WRITE;
/*!40000 ALTER TABLE `match_scores_zd_zd_weights` DISABLE KEYS */;
INSERT INTO `match_scores_zd_zd_weights` VALUES
('aa',3,0),
('ab',3,0),
('ac',3,0),
('ba',3,0),
('bb',3,0),
('bc',3,0),
('ca',3,0),
('cb',3,0),
('cc',3,0);
/*!40000 ALTER TABLE `match_scores_zd_zd_weights` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-31 15:40:41
