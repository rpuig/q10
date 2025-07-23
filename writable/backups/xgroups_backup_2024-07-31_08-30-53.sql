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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-31 15:30:53
