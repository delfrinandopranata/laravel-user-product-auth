-- MySQL dump 10.13  Distrib 9.0.1, for macos15.0 (arm64)
--
-- Host: localhost    Database: project_management
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2024_10_12_110628_create_projects_table',1),(3,'2024_10_12_115539_create_timesheets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_user`
--

DROP TABLE IF EXISTS `project_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_user_project_id_foreign` (`project_id`),
  KEY `project_user_user_id_foreign` (`user_id`),
  CONSTRAINT `project_user_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_user`
--

LOCK TABLES `project_user` WRITE;
/*!40000 ALTER TABLE `project_user` DISABLE KEYS */;
INSERT INTO `project_user` VALUES (1,12,1,'2024-10-12 07:42:10','2024-10-12 07:42:10');
/*!40000 ALTER TABLE `project_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('planned','in_progress','completed','on_hold') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'planned',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Initial Project','Engineering','2024-01-01','2024-12-31','in_progress','2024-10-12 07:40:22','2024-10-12 07:40:22'),(2,'Rogahn, Sporer and Oberbrunner','Marketing','2015-06-16','1975-09-16','on_hold','2024-10-12 07:40:22','2024-10-12 07:40:22'),(3,'VonRueden Ltd','Finance','2023-10-13','2003-07-20','on_hold','2024-10-12 07:40:22','2024-10-12 07:40:22'),(4,'Nitzsche-Corwin','Marketing','1996-11-18','1993-10-28','on_hold','2024-10-12 07:40:22','2024-10-12 07:40:22'),(5,'Wiegand, Hammes and Rosenbaum','Finance','1981-01-30','1999-05-09','in_progress','2024-10-12 07:40:22','2024-10-12 07:40:22'),(6,'Tromp, Hickle and Pfeffer','HR','2015-07-06','2002-11-15','planned','2024-10-12 07:40:22','2024-10-12 07:40:22'),(7,'Pacocha-Lockman','IT','2007-09-09','2013-06-02','completed','2024-10-12 07:40:22','2024-10-12 07:40:22'),(8,'Spinka, Durgan and Hauck','HR','1970-08-02','2016-01-08','in_progress','2024-10-12 07:40:22','2024-10-12 07:40:22'),(9,'Herzog-Waelchi','HR','1981-03-16','2014-03-12','on_hold','2024-10-12 07:40:22','2024-10-12 07:40:22'),(10,'Carroll, Cole and Hilpert','HR','2023-01-30','1984-06-04','completed','2024-10-12 07:40:22','2024-10-12 07:40:22'),(11,'Hand and Sons','HR','1991-10-30','2008-09-07','completed','2024-10-12 07:40:22','2024-10-12 07:40:22'),(12,'New Project','IT','2024-01-01','2024-12-31','in_progress','2024-10-12 07:42:10','2024-10-12 07:42:10');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `timesheets`
--

DROP TABLE IF EXISTS `timesheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `timesheets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `task_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `hours` decimal(5,2) NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `project_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timesheets_user_id_foreign` (`user_id`),
  KEY `timesheets_project_id_foreign` (`project_id`),
  CONSTRAINT `timesheets_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `timesheets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `timesheets`
--

LOCK TABLES `timesheets` WRITE;
/*!40000 ALTER TABLE `timesheets` DISABLE KEYS */;
INSERT INTO `timesheets` VALUES (1,'Initial Task','2024-01-01',8.00,1,1,'2024-10-12 07:40:22','2024-10-12 07:40:22');
/*!40000 ALTER TABLE `timesheets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female','other') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Delfrinando','Pranata','1990-01-01','male','delfrinando@gmail.com',NULL,'$2y$10$8BloDZLccAytzNmFDFxcauGJk0StTZI7HZpSaaiPUD1SjHku9N2Le',NULL,'2024-10-12 07:40:22','2024-10-12 07:40:22'),(2,'Milford','Reilly','2018-07-24','female','lafayette.koch@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Vpm8oT0QP2','2024-10-12 07:40:22','2024-10-12 07:40:22'),(3,'Luther','Lakin','2009-07-27','female','colin65@example.org','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','FPGTdw57tF','2024-10-12 07:40:22','2024-10-12 07:40:22'),(4,'Lisa','Welch','1973-12-07','male','liam33@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','LxO8ruFDBS','2024-10-12 07:40:22','2024-10-12 07:40:22'),(5,'Dayana','Borer','2016-03-26','female','aiyana.kunde@example.org','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','REqlM6h6tX','2024-10-12 07:40:22','2024-10-12 07:40:22'),(6,'Rebecca','Zemlak','2013-09-13','male','nadia28@example.net','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','m2vGbqAEqw','2024-10-12 07:40:22','2024-10-12 07:40:22'),(7,'George','Predovic','1992-08-20','female','johnathon34@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','jzboc1Kt7y','2024-10-12 07:40:22','2024-10-12 07:40:22'),(8,'Danika','Kuhic','1972-04-19','male','rice.henry@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','QivGmOWwfn','2024-10-12 07:40:22','2024-10-12 07:40:22'),(9,'Liliana','Stamm','2003-06-16','male','fstiedemann@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ylQaSXX4ic','2024-10-12 07:40:22','2024-10-12 07:40:22'),(10,'Trenton','Nikolaus','1993-12-14','male','wadams@example.net','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','CBhGNgrT0L','2024-10-12 07:40:22','2024-10-12 07:40:22'),(11,'Lexi','Fay','1977-03-05','female','bernhard.fern@example.net','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bitptwCkbd','2024-10-12 07:40:22','2024-10-12 07:40:22'),(12,'German','Harber','2004-03-05','male','bella90@example.org','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bxIyixnNaf','2024-10-12 07:40:22','2024-10-12 07:40:22'),(13,'Stan','Gottlieb','1971-11-18','male','dwyman@example.org','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','Nwjj1g8sca','2024-10-12 07:40:22','2024-10-12 07:40:22'),(14,'Dameon','Boyer','1997-08-15','female','mason.collier@example.org','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','uWlDsdaiaY','2024-10-12 07:40:22','2024-10-12 07:40:22'),(15,'Linnea','Bechtelar','2011-03-19','female','tito15@example.net','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','wz8AfY9AUA','2024-10-12 07:40:22','2024-10-12 07:40:22'),(16,'Lonny','Beatty','1996-04-25','male','ubahringer@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','GOn0n9Xba0','2024-10-12 07:40:22','2024-10-12 07:40:22'),(17,'Demarco','Gusikowski','1987-04-09','male','dspinka@example.net','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','yiH27CcZqW','2024-10-12 07:40:22','2024-10-12 07:40:22'),(18,'Jesse','Stark','1994-10-28','female','gregorio.okon@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','5HPkDRPwoW','2024-10-12 07:40:22','2024-10-12 07:40:22'),(19,'Jonathon','Waters','2024-02-12','female','rylee26@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','84z4VWSqs3','2024-10-12 07:40:22','2024-10-12 07:40:22'),(20,'Daniella','Lakin','2012-08-28','female','lkoch@example.org','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','bc0n5gIEL8','2024-10-12 07:40:22','2024-10-12 07:40:22'),(21,'Kaden','Raynor','2000-06-04','male','irosenbaum@example.com','2024-10-12 07:40:22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','ZLoLFCjmi2','2024-10-12 07:40:22','2024-10-12 07:40:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-12 17:49:23
