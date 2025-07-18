-- MySQL dump 10.13  Distrib 9.3.0, for Win64 (x86_64)
--
-- Host: gondola.proxy.rlwy.net    Database: edumall
-- ------------------------------------------------------
-- Server version	9.3.0

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
-- Table structure for table `carts`
--

DROP TABLE IF EXISTS `carts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `labs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carts`
--

LOCK TABLES `carts` WRITE;
/*!40000 ALTER TABLE `carts` DISABLE KEYS */;
INSERT INTO `carts` VALUES (1,6,4,1,'2025-07-14 13:52:51','2025-07-14 13:52:51'),(2,7,4,2,'2025-07-16 10:10:42','2025-07-16 10:10:42');
/*!40000 ALTER TABLE `carts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `computer_labs`
--

DROP TABLE IF EXISTS `computer_labs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `computer_labs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('Desktops','routers','cameras','printers','repair') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` enum('new','old') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `computer_labs`
--

LOCK TABLES `computer_labs` WRITE;
/*!40000 ALTER TABLE `computer_labs` DISABLE KEYS */;
/*!40000 ALTER TABLE `computer_labs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `events` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('sound','tents') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` enum('new','old') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `furniture`
--

DROP TABLE IF EXISTS `furniture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `furniture` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('office','classroom') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` enum('new','old') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `furniture`
--

LOCK TABLES `furniture` WRITE;
/*!40000 ALTER TABLE `furniture` DISABLE KEYS */;
/*!40000 ALTER TABLE `furniture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `holidays` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('soccer','music') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` enum('new','old') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `labs`
--

DROP TABLE IF EXISTS `labs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `labs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('apparatus','specimen','chemical') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rating` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` enum('new','old') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `purchaseType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `labs`
--

LOCK TABLES `labs` WRITE;
/*!40000 ALTER TABLE `labs` DISABLE KEYS */;
INSERT INTO `labs` VALUES (3,'Albino Rats','specimen','images/labs/hCrLK4G7LA9GjGwEfJlzNfsgD32i4KlavazKCjJc.jpg','\"[\\\"images\\\\/labs\\\\/kHRThGGfgv3RnnwldxEU0SaYvN9cdOs5iKNeT5Oh.jpg\\\",\\\"images\\\\/labs\\\\/7CbRTBjbsq3KaL2xPMzbTw84PEooNrIcX9SOQ1LE.jpg\\\"]\"','white','5','10000','new','15000','specimen','white albino rats for laboratory experiments','purchase','2025-07-13 03:27:37','2025-07-13 03:27:37'),(4,'Cockroach','specimen','images/labs/uMDips8xwAAhfjUPu2H3raT3H6hYaiGE6mYnzGSF.jpg','\"[\\\"images\\\\/labs\\\\/RRtZgc9fk0aLX7g6EgnBwgkBPu5jjFh6Pt0rOcv2.jpg\\\",\\\"images\\\\/labs\\\\/lHl9VS4XCtZE5UDtSJHCa5tiL8E8bOohbaJ5m4sr.jpg\\\"]\"','any','5','10000','new','10000','specimen','cockroaches for dissection','purchase','2025-07-13 00:36:00','2025-07-13 00:36:00'),(5,'Toads','specimen','images/labs/iUyYiz5MfjDIEF0l3biZq0pca81BWC7oNM1WSYWt.jpg','\"[\\\"images\\\\/labs\\\\/ycLVGnOciYIDKYS0i38ACA4YaANwcYfGsMoRjLKF.jpg\\\"]\"','any','5','10000','new','15000','specimen','Toads for dissection','purchase','2025-07-13 00:37:21','2025-07-13 00:37:21'),(6,'Ammeter(0 - 1.0A)','apparatus','images/labs/hf9k1RNpfaNfXYCMAqr3tK8Pp1mrgPdDC67sfhXN.jpg','\"[\\\"images\\\\/labs\\\\/OhXaMwq0CNk9Encra9jqXRdWRV1ziFhwLAQ5ZlUf.jpg\\\",\\\"images\\\\/labs\\\\/Q6v0Lhc1lXeXATqSYtY1duAVrJobi5MFUxmz3a4I.jpg\\\"]\"','any','5','10000','new','22000','piece','Product Name : Analog Ammeter;Material : Plastic,Metal;Measuring Current Range : DC 0 - 1.0A\r\nAccuracy : Class 2.5;Meter Face Size(Approx) : 7.2 x 6.1cm/ 2.8\" x 2.4\" (L*W);Thread Size : 0.29 x 0.8cm / 0.11\" x 0.31\" (D*L)\r\n0.36 x 0.9cm / 0.14\" x 0.35\" (D*L) : 0.36 x 0.9cm / 0.14\" x 0.35\" (D*L);Overall Depth : 5cm/ 2\"\r\nColor : White, Black,Clear;Weight : 80g\r\nPackage Content : 1 x Analog Ammeter;Fitting Part : Fitting Par','purchase','2025-07-13 00:48:09','2025-07-13 00:48:09'),(7,'Ammeter (0 - 5.0A)','apparatus','images/labs/4wtMahimjyp8ZKS3aXYmfkQ5XO0znnFXRhjaMeSn.jpg','\"[\\\"images\\\\/labs\\\\/lrgfyU2ugqL8kUGPpWlRxNWzEfmHMqPZACuQTOXI.jpg\\\",\\\"images\\\\/labs\\\\/fPDHIG2MoAfyXbFcIO4RdJobG1SiaVayKcc0EWQt.jpg\\\"]\"','white','5','10000','new','18000','piece','AMMETER (0 - 5.0A)','purchase','2025-07-13 00:55:27','2025-07-13 00:55:27'),(8,'BEAKER 250ml PLASTIC','apparatus','images/labs/8DsTXdJMqGgf1ldX8oevYwJNK18flbhWjuSapD9m.jpg','\"[\\\"images\\\\/labs\\\\/vh5vARgWNKMKUzdBcFMIrtkLokKqKeL0Q5fVvis9.jpg\\\",\\\"images\\\\/labs\\\\/0jtZEV82liTUgulyJrDK3rim8BVJL34Xh50p77VX.jpg\\\"]\"','colourless','5','1000','new','4500','Beaker','BEAKER 250ml PLASTIC','purchase','2025-07-13 00:56:57','2025-07-13 00:56:57'),(9,'BEAKER 500ml PLASTIC','apparatus','images/labs/NLxWRrdKd7lQJNOIE5tc4fhNGGDoy9ZKD41YjPTj.jpg','\"[\\\"images\\\\/labs\\\\/GWg4Iho1zErAzTHyaptK5ykdWbTKoXvWAH3nH2aT.jpg\\\",\\\"images\\\\/labs\\\\/0UgX9bk3ALkQAgNzkX7UWjxaaLYeJpxkbSS54m0g.jpg\\\"]\"','colourless','5','1000','new','6000','Beaker','BEAKER 500ml PLASTIC','purchase','2025-07-13 00:58:04','2025-07-13 00:58:04'),(10,'BEAKER 500ml BOROSILICATE GLASS','apparatus','images/labs/s2KgxmFkOxiOoxkxDkLTDMJhkwFlUDCSOtSvcq2I.jpg','\"[\\\"images\\\\/labs\\\\/4WjVVomSItjjpRbaHzlxYsoZnoKKEpuj7LOqRqC1.jpg\\\",\\\"images\\\\/labs\\\\/wEPnMSYM6gW4NAZFQR8qkb8Qep4xqOgRMmJWWQ4X.jpg\\\"]\"','glass','5','1000','new','8000','Beaker','BEAKER 500ml BOROSILICATE GLASS','purchase','2025-07-13 01:00:35','2025-07-13 01:00:35');
/*!40000 ALTER TABLE `labs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libraries`
--

DROP TABLE IF EXISTS `libraries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libraries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('textbook','NewCurriculum') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` enum('new','old') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libraries`
--

LOCK TABLES `libraries` WRITE;
/*!40000 ALTER TABLE `libraries` DISABLE KEYS */;
/*!40000 ALTER TABLE `libraries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_04_13_012519_create_labs_table',1),(4,'2025_04_13_013829_create_libraries_table',1),(5,'2025_04_13_014447_create_stationaries_table',1),(6,'2025_04_13_015404_create_furniture_table',1),(7,'2025_04_13_020045_create_computer_labs_table',1),(8,'2025_04_13_020725_create_sports_table',1),(9,'2025_04_13_021213_create_events_table',1),(10,'2025_04_13_021543_create_holidays_table',1),(11,'2025_06_13_124249_create_oauth_auth_codes_table',1),(12,'2025_06_28_044703_create_oauth_access_tokens_table',1),(13,'2025_06_28_044704_create_oauth_refresh_tokens_table',1),(14,'2025_06_28_044705_create_oauth_clients_table',1),(15,'2025_06_28_044706_create_oauth_device_codes_table',1),(16,'2025_06_28_045453_create_personal_access_tokens_table',1),(17,'2025_07_04_152113_create_carts_table',1),(18,'2025_07_05_062358_create_orders_table',1),(19,'2025_07_05_062359_create_order_items_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_access_tokens_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_auth_codes`
--

DROP TABLE IF EXISTS `oauth_auth_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_auth_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_auth_codes_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_auth_codes`
--

LOCK TABLES `oauth_auth_codes` WRITE;
/*!40000 ALTER TABLE `oauth_auth_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_auth_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_id` bigint unsigned DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect_uris` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `grant_types` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_clients_owner_type_owner_id_index` (`owner_type`,`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_device_codes`
--

DROP TABLE IF EXISTS `oauth_device_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_device_codes` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `client_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_code` char(8) COLLATE utf8mb4_unicode_ci NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `user_approved_at` datetime DEFAULT NULL,
  `last_polled_at` datetime DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `oauth_device_codes_user_code_unique` (`user_code`),
  KEY `oauth_device_codes_user_id_index` (`user_id`),
  KEY `oauth_device_codes_client_id_index` (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_device_codes`
--

LOCK TABLES `oauth_device_codes` WRITE;
/*!40000 ALTER TABLE `oauth_device_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_device_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` char(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `quantity` int NOT NULL,
  `price` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `labs` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `customer_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `delivery_info` json NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `delivery_fee` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',4,'authToken','3f8a3eb70522e7a6b88cf96317cd9e3e62d4ef253976fec4a8415ed00a5f7f3f','[\"*\"]','2025-07-11 23:54:56',NULL,'2025-07-11 23:54:55','2025-07-11 23:54:56'),(2,'App\\Models\\User',5,'authToken','5822b45d25e4a06202bf9878b7b7808fcdb9f3126864e35cf3702e5b579d0a1e','[\"*\"]','2025-07-12 22:09:00',NULL,'2025-07-12 22:08:59','2025-07-12 22:09:00'),(3,'App\\Models\\User',6,'authToken','27c5f1591366fd7e3f443a495becdcd7785ebe303313c63a21cf9febf38c9534','[\"*\"]','2025-07-16 00:04:10',NULL,'2025-07-14 13:52:45','2025-07-16 00:04:10'),(4,'App\\Models\\User',7,'authToken','08381fa5d9d69c9e7e18cf0330a14e782072cabdfef6162e37b5a1e089f09e53','[\"*\"]','2025-07-16 12:57:22',NULL,'2025-07-16 10:05:00','2025-07-16 12:57:22');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('0ay91jm8k84H6OEOP1tUxHEadyBF3fGytNacDhSm',NULL,'100.64.0.4','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0xLaTliY3FnSUszQ2hxd0pMRVRhVEpSV3V1RnNudjdSRnM4MXpWQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2xvZ2luIjt9fQ==',1752565897),('3jPXHjslKD3hpwVL8u9Np1X4wJB03QGUnl6h0CUb',NULL,'100.64.0.5','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXRGd0JBNVVFWWt0Q1pFbmoyUm5LTEhWZGUwUndSckFlZFpSRXdidSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovL2VkdW1hbGwtYWRtaW4udXAucmFpbHdheS5hcHAvaG9tZSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQwOiJodHRwOi8vZWR1bWFsbC1hZG1pbi51cC5yYWlsd2F5LmFwcC9ob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752613607),('7yRikoeMANwR4DKMQ6wXXZIpJHI3PoLKlBlh8ez1',NULL,'100.64.0.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoiSjJVV01lSlNzakJhRnJmc3VIaEl3UEY1Rk44cG16WnE2azZSZ0FJMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752562248),('a1f5nxmdsWuS4mOa42GCNknRSbwbe3bmSWuE9jHe',3,'100.64.0.2','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36','YTo2OntzOjY6Il90b2tlbiI7czo0MDoiY1JmMm5ndjBnQ2hwWUcyV0Z6clBBSkg2V2k3Mm4ybklsVmVpSWdtSCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL0xhYnMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1MjYxMzU5ODt9czo1OiJ0aXRsZSI7czoxNjoiTGFib3JhdG9yeSBJdGVtcyI7fQ==',1752613632),('AWWEBXmpNipy7pZzmZTeYQcoNCLHgGdKGgAP6zgz',NULL,'100.64.0.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiR25QN1hqa0JodDBaUTRkOWk1dmJ0TklBZ0dTeDVOckpNckt2SDFXQyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752645019),('cQhNWQRIyEXrLHkIdWnwAMsZT36WfnSnneE5QDBa',NULL,'100.64.0.6','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiU0czTHpXSlp2SWE0SDZ4UVQ0eUlONFBTVE56Q1JSZlpmZFc0SUYxVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752613627),('eZII0miENyLVrNVwzl93CwVqON1bOGu2EiME5Fvn',NULL,'100.64.0.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNDZTWlRvNjdCZGVHRjI2WVlISnlzajNYM2NkZG1GaERUYUlzaTRuUyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL3NhbmN0dW0vY3NyZi1jb29raWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1752566269),('f5eT5GMVCUkAhjIZoeku9UE8fc2nk85lPV76KBoG',NULL,'100.64.0.4','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1dnUlZySEtBOU56VFQzSENPY0o1WTFVYWRPS3pQN3pLa0cyaW02VSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL3NhbmN0dW0vY3NyZi1jb29raWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1752649499),('GkjQCmiCeyTRH8GGxsdtFmqVeR0gmny7ZB9DaqL2',NULL,'100.64.0.6','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoieXowUjdnU1QyMjhTQzBudmVyc0JxaE1LWDN3Z1lEMmczZ0Fzd01UYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL3NhbmN0dW0vY3NyZi1jb29raWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1752566355),('GL4y0P8kokAgCSmgFhoHekhAQQf4jNu7OETwf4DJ',NULL,'100.64.0.2','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoiNHZNcmJ4S1FSVkc5UEx2bm05ZERSRHlqekRRc1VUZldpSmZiNUp0ZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752562266),('JE5cQZ8wqjVGJWiuMFdc4mSNr2Mjn7UBxDj9MVb9',NULL,'100.64.0.5','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiNlNCMG1yeUp4cTBISVk4NVowN0FxRXFHQkl4dlpXVGlQelhVckxOWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752613639),('notraI1fYplNNV3pqgSFFPubBTx6OuvXtcdlDjGa',3,'100.64.0.4','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiemZtOU5qV1F1cEZwWHVsOG5wOVcwN3dsbWZTSmc4VXI2SmlHM0VPaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2hvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6NDoiYXV0aCI7YToxOntzOjIxOiJwYXNzd29yZF9jb25maXJtZWRfYXQiO2k6MTc1MjU2NjE3NDt9fQ==',1752566174),('REOsqmHz17mCU1QzRjZGxlMhacwccdhIHIVNrIC0',NULL,'100.64.0.2','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)','YTozOntzOjY6Il90b2tlbiI7czo0MDoiTG1nUUdDaWNQcXE1OVUwcVN3WERjOFl4b2NrQzJxQ0JieDVWc0tRaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752613607),('UDVQTqLmpHS7ir3AgFuqsRnCHJGadnnS489eiYOs',NULL,'100.64.0.6','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)','YTo0OntzOjY6Il90b2tlbiI7czo0MDoieW1yOFdDYkdBNG54akx2dzNGSEI2WHVzcjBiWjExNXNocmttOXhzdSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MjoiaHR0cDovL2VkdW1hbGwtYWRtaW4udXAucmFpbHdheS5hcHAvZXZlbnRzIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2V2ZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1752613627),('ujUvJZ8xzNQ1vujhXENKUPitmpIPDw42tNYp2c5E',3,'100.64.0.4','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36 Edg/138.0.0.0','YTo2OntzOjY6Il90b2tlbiI7czo0MDoidGY1ZGtyRnZ6NG9yazRVVmZtWkVyZUdTRktDemVrbDg3MWozMTNIMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDU6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2Rhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7czo0OiJhdXRoIjthOjE6e3M6MjE6InBhc3N3b3JkX2NvbmZpcm1lZF9hdCI7aToxNzUyNTY1MTE2O31zOjU6InRpdGxlIjtzOjk6IkRhc2hib2FyZCI7fQ==',1752565212),('WIlT3xdxS4UzU8CL5HoauvmLAYSOjGTd1jughMEj',NULL,'100.64.0.5','Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNnMxbjRiWmJvdlZOb0VYd0R1VzVoYmt3OFRQcFp5a2luY3lTQVN4WCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovL2VkdW1hbGwtYWRtaW4udXAucmFpbHdheS5hcHAvTGFicyI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQwOiJodHRwOi8vZWR1bWFsbC1hZG1pbi51cC5yYWlsd2F5LmFwcC9MYWJzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752613639),('zHiJxmOYyWSu3brQego3anfpzhKGAfvd6rKqbpRR',NULL,'100.64.0.8','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiekRNMEp5MWEzQ0Zyd044bUlNODV1YWZ0ZmRnY0R4VmlPTnZ4U1F1biI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly9lZHVtYWxsLWFkbWluLnVwLnJhaWx3YXkuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1752583025);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sports`
--

DROP TABLE IF EXISTS `sports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('balls','jerseys','board_games','indoor_games') COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` enum('new','old') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sports`
--

LOCK TABLES `sports` WRITE;
/*!40000 ALTER TABLE `sports` DISABLE KEYS */;
/*!40000 ALTER TABLE `sports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stationaries`
--

DROP TABLE IF EXISTS `stationaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stationaries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'chalk',
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `images` json DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `in_stock` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `condition` enum('new','old') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `price` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stationaries`
--

LOCK TABLES `stationaries` WRITE;
/*!40000 ALTER TABLE `stationaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `stationaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accountType` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'individual',
  `customUserType` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `institution_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `centre_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subcounty` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parish` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `village` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adminName` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customDesignation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adminEmail` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adminPhone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bankAccount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobileMoneyNumber` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paymentMethods` json DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `position` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Kagimu ','JayP','admin',NULL,'kagimujayp01@gmail.com','individual',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','Senior Developer',NULL,'$2y$12$mfB8J.1gFzvAOL8nMZ1Tb.7M4cEKXSC9U6PQpQqVO40zDUsElpUX.',NULL,'2025-07-11 23:19:25','2025-07-11 23:19:25'),(2,'Joseph Prince','Mpoza','admin',NULL,'joseprincempoza@gmail.com ','individual',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','administrator',NULL,'$2y$12$uAaIFVWO91lFV6fS/lAFRub5Zsw7eNNfIkWImE/pE1DpK8aeUQ2xK',NULL,'2025-07-11 23:19:26','2025-07-11 23:19:26'),(3,'David','Mugisha','admin',NULL,'mugishad43@gmail.com ','individual',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'admin','administrator',NULL,'$2y$12$u3EjLbcC87R5u9M3USAUmeDOI2YSL39tYoywVGeS3Mzj1L9YdT/zq',NULL,'2025-07-11 23:19:27','2025-07-11 23:19:27'),(4,'musa','eli','Guardian','0785118569','musa@gmail.com','individual',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'client',NULL,NULL,'$2y$12$Qniw44Fu36bty5el.pcfMOKXN..2PjOAiF8pEEM9Q6Jzgb0rFTcEe',NULL,'2025-07-11 23:54:55','2025-07-11 23:54:55'),(5,'tester','user','Teacher','0745345678','tester@gmail.com','individual',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'client',NULL,NULL,'$2y$12$.q0qz2x1umvCb4olU1JjqeXU40eTFcchuJT9VcDBWKpUtoMZTsmMq',NULL,'2025-07-12 22:08:59','2025-07-12 22:08:59'),(6,'David','Mugisha','Parent','0772113800','fourmillennia@gmail.com','individual',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'client',NULL,NULL,'$2y$12$F5EfVGJZLEbRWpzzigI3N.G/1AMtEergn0uWLrTAWRLLcetP1aCWK',NULL,'2025-07-14 13:52:45','2025-07-14 13:52:45'),(7,'Justus','Ceasar','Teacher','0700111222','justus@gmail.com','individual',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'client',NULL,NULL,'$2y$12$hjDz5fx1hvXKnUmvQfLMVelYO7oLZPP0qhka1bhyF8nV.FBeu7B.y',NULL,'2025-07-16 10:05:00','2025-07-16 10:05:00');
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

-- Dump completed on 2025-07-17  9:34:31
