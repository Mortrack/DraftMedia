-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.33-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for draftmedia
CREATE DATABASE IF NOT EXISTS `draftmedia` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `draftmedia`;

-- Dumping structure for table draftmedia.account_registery
CREATE TABLE IF NOT EXISTS `account_registery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privacy_politics` tinyint(4) NOT NULL,
  `activation_code` varchar(510) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- Dumping data for table draftmedia.account_registery: ~23 rows (approximately)
/*!40000 ALTER TABLE `account_registery` DISABLE KEYS */;
INSERT INTO `account_registery` (`id`, `email`, `first_name`, `last_name`, `role`, `password`, `privacy_politics`, `activation_code`, `status`, `created_by`, `created_at`) VALUES
	(1, 'correo@correo.com', 'Cesar', 'Miranda Meza', 'user', 'TFBAo78aMt1UwSPbSJSXCwdfyMuV2G67xNgXrzVgb56aHv0P1tSe5axrSqmSlADWJnNX9XALBTd0gfkol4Ih4w==', 1, '89728$0134!1$F!661212$!1540076786', 'ACTIVE', 'DraftMedia Web API', '2018-10-21 01:06:26'),
	(2, 'correo123@correo.com', 'Cesar', 'Miranda Meza', 'user', '4/9IMNEdFRQm3fKNSMEM+i0DatVfKBwuJwcGEWn+PPSSjUcDMlhbewFhin2STzFPlLo8VSd6+zyE8647+N6gOw==', 1, '51054$3565!2$F!184490$!1540153226', 'ACTIVE', 'DraftMedia Web API', '2018-10-21 22:20:26'),
	(3, 'correo@correo.com', 'Cesar2', 'Miranda Meza2', 'user', 'd5r3My+1Ie1qdhhVGmnot6ESGIjvokGQ3D9ydNKfFeXUFsPvfSXUJ7Xq1h3eZ1tPlZ0gA+cvo/yfS8hmNlmPVQ==', 1, 'correo@correo.comCesar2Miranda Meza2userd5r3My+1Ie1qdhhVGmnot6ESGIjvokGQ3D9ydNKfFeXUFsPvfSXUJ7Xq1h3eZ1tPlZ0gA+cvo/yfS8hmNlmPVQ==11540212502ACTIVEDraftMedia Web API2018-10-22 14:48:22', 'ACTIVE', 'DraftMedia Web API', '2018-10-22 14:48:22'),
	(4, 'correo@correo.com', 'Cesar2', 'Miranda Meza2', 'user', 'wk7eybKkdT2/czPRvgWFe72iluD0wHCNlvYLTa/ytmg9IRrGpdVxNXsr6j3cIDzcCSAVZNKL4Wh4PFo9HytpsQ==', 1, 'correo@correo.comCesar2Miranda Meza2userwk7eybKkdT2/czPRvgWFe72iluD0wHCNlvYLTa/ytmg9IRrGpdVxNXsr6j3cIDzcCSAVZNKL4Wh4PFo9HytpsQ==11540213094ACTIVEDraftMedia Web API2018-10-22 14:58:14', 'ACTIVE', 'DraftMedia Web API', '2018-10-22 14:58:14'),
	(5, 'correo@correo.com', 'Cesar2', 'Miranda Meza2', 'user', 'cAF5QjHq7LoBI8dGbtPji8BwQ8pZZbjjy6MNCi4nTUy1WN02uGbHkxaUgcKP9gZHpiPvlwQc8ksR4ny+YZK3lQ==', 1, 'correo@correo.comCesar2Miranda Meza2usercAF5QjHq7LoBI8dGbtPji8BwQ8pZZbjjy6MNCi4nTUy1WN02uGbHkxaUgcKP9gZHpiPvlwQc8ksR4ny+YZK3lQ==11540213174ACTIVEDraftMedia Web API2018-10-22 14:59:34', 'ACTIVE', 'DraftMedia Web API', '2018-10-22 14:59:34'),
	(6, 'correo@correo.com', 'Cesar2', 'Miranda Meza2', 'user', 'ygv620JKnC1zT7DVhJTQENG60UxKB61j0tgI4g/A8LyKVDlhdmlQd4sQov79DW2wVzO97vXBG6hgYFN4FWxRcQ==', 1, 'correo@correo.comCesar2Miranda Meza2userygv620JKnC1zT7DVhJTQENG60UxKB61j0tgI4g/A8LyKVDlhdmlQd4sQov79DW2wVzO97vXBG6hgYFN4FWxRcQ==11540213240ACTIVEDraftMedia Web API2018-10-22 15:00:40', 'ACTIVE', 'DraftMedia Web API', '2018-10-22 15:00:40'),
	(7, 'correo@correo.com', 'Cesar2', 'Miranda Meza2', 'user', 'BHHYz96HClxPy7COOBwBKJNtJFmYp8sd3GXrW5BDcIztX05//7dZaFzr16HDq2tx51fAQiGQSGLQJH23GRsIvA==', 1, 'correo@correo.comCesar2Miranda Meza2userBHHYz96HClxPy7COOBwBKJNtJFmYp8sd3GXrW5BDcIztX05//7dZaFzr16HDq2tx51fAQiGQSGLQJH23GRsIvA==11540213354ACTIVEDraftMedia Web API2018-10-22 15:02:34', 'ACTIVE', 'DraftMedia Web API', '2018-10-22 15:02:34'),
	(8, 'correo@correo.com', 'Cesar2', 'Miranda Meza2', 'user', 'eIzq7ulkm44/3LlWjNFh6ixhuGSZDyAys3PJfLnGlQ4zOQgulfhmgt8kxxmoSVgRLA+VLluVe6IHjBZb5mAn3g==', 1, 'correo@correo.comCesar2Miranda Meza2usereIzq7ulkm44/3LlWjNFh6ixhuGSZDyAys3PJfLnGlQ4zOQgulfhmgt8kxxmoSVgRLA+VLluVe6IHjBZb5mAn3g==11540213406ACTIVEDraftMedia Web API2018-10-22 15:03:26', 'ACTIVE', 'DraftMedia Web API', '2018-10-22 15:03:26'),
	(9, 'correo@correo.com', 'Cesar2', 'Miranda Meza2', 'user', '94VQfncfAwnFy63SWeUV1wI/dlutkXPEpd4ijP9+gnHOLWjPr71SGxeX7sVaEesXm2f5R4Yy3gDk2gjUaNoFTw==', 1, '40453$1594!9$F!392617$!1540213411', 'ACTIVE', 'DraftMedia Web API', '2018-10-22 15:03:31'),
	(10, 'test@correo.com', 'Test', 'Testeando', 'user', 'HRCfo926ePMLC+I3x3buxI2DTJVY8puS9eV+qAhmYP1/cORrDN3G1VoR9LXS8gm9V4s9GwQj7yt+ew6CFxLQ+A==', 1, '75759$0885!10$F!465660$!1540579069', 'ACTIVE', 'DraftMedia Web API', '2018-10-26 20:37:49'),
	(11, 'test@correo.com', 'Test', 'Testeando', 'user', 'Qasz4P95/tCC4zClc+FspKazh/e+SJwnpDyKaKvWHzLdr1bvgx9BSo8A7qlWdtPzfBDv6bV3xMjamvKxN8wuLg==', 1, '06893$5655!11$F!049810$!1540581502', 'ACTIVE', 'DraftMedia Web API', '2018-10-26 21:18:22'),
	(12, 'tenc@correo.com', 'Tenc', 'Tenten', 'user', 'YlTQ42amME/ViQWz5TBQxKLsfv1CgmRhzjuaXTXZ7ediIVT1noBqhCh1ilIA05R4W7vfz8rJ+9ak8yA0kLJdJA==', 1, 'L+vq5P35yqdCragXo6gsdcPyTbP3jNuI6nVwsAcDoiH20lpWIuhsmatXFAWg9adN', 'ACTIVE', 'DraftMedia Web API', '2018-10-27 11:16:51'),
	(13, 'tenten@correo.com', 'Tenc', 'Tenten', 'user', 'memJDKvke4w2nAihpsbWQljx+t/vrZerDKDo/eko0DcxZGLIFoiIpA7DSKNqbD9ic9OHjga2ZkKjV6gIT2RC5g==', 1, '17120$2551!13$F!602490$!1540632250', 'ACTIVE', 'DraftMedia Web API', '2018-10-27 11:24:10'),
	(14, 'haha@correo.com', 'Haha', 'Hihi', 'user', 'uVRpGORek0rkTgEr2ECWn6MYDs8UYuL13rqddJL5xGceLyFJzl4QVGpzbPrzRKX4XH04ES9l23BOz6UZok7MHg==', 1, '13270$3586!14$F!108023$!1540638240', 'ACTIVE', 'DraftMedia Web API', '2018-10-27 13:04:00'),
	(15, 'testNana@correo.com', 'Nana', 'Meza', 'user', 'RpVfEemz+2vCmRRjluTNK+ZTWMsKK477TtUymGx+clH4uYgEvmVQjOSYh3bJO9eFcwRSFnpZboj4rszpeobt/Q==', 1, '86375$2183!15$F!659225$!1541344445', 'ACTIVE', 'DraftMedia Web API', '2018-11-04 16:14:05'),
	(16, 'correoOscarLopez@correo.com', 'Oscar', 'Lopez', 'user', 'DdSvMh1xhjkSDZRMnqkyzvtLYxt0KZd9jGUidLxjwpYL5MIWZ0R1b8dLBOxH4f9w5O92I+q2SwOfMROD79KtBw==', 1, '88341$3812!16$F!231576$!1541696240', 'ACTIVE', 'DraftMedia Web API', '2018-11-08 17:57:20'),
	(17, 'testTest123@correo.com', 'Testtest123', 'Tt123', 'user', 'PEqm7JUguErgIwnSZJbvh/Eas8Pn/cVgzuvZaGgsCZGGiBEwW7RX5YLQDEfH/5JEAdiqKf7kAIHW9m8i7huctw==', 1, '86721$3825!17$F!384765$!1542379194', 'ACTIVE', 'DraftMedia Web API', '2018-11-16 15:39:54'),
	(18, 'cesar.miranda.meza@uabc.edu.mx', 'Cesar', 'Miranda Meza', 'user', 'rvbKOSuqb2bLdqGYVhMO8MWCyzY6FTHrzPEfZqmjFBVMVcgr3bKckI8Byde2/h1dYw0wJGabcPL7uMEAvBuP7A==', 1, '99735$4746!18$F!924770$!1542633295', 'ACTIVE', 'DraftMedia Web API', '2018-11-19 14:14:55'),
	(19, 'cesar.miranda.meza@uabc.edu.mx', 'Cesar', 'Miranda Meza', 'user', 'M+yr1vSJyXfWU8j59I3GMRYaIq0ml2KXhk8GEPy9ETBtWIiNb2v65/UdAD4O1lDqdv5WzUCTJTSCRTuVYgZD9w==', 1, '05687$7028!19$F!449447$!1542633312', 'ACTIVE', 'DraftMedia Web API', '2018-11-19 14:15:12'),
	(20, 'cesar.miranda.meza@uabc.edu.mx', 'Cesar', 'Miranda Meza', 'user', 'nKO8/RgjxRshzdlVYp0t3okPYdBXv8wilPMD2G7xhQ+DsQWgg41bZy692IxkiQxpf2/uhkVXovDPi3iwCqTlSQ==', 1, '70836$3299!20$F!834625$!1542633910', 'ACTIVE', 'DraftMedia Web API', '2018-11-19 14:25:10'),
	(21, 'cesar.miranda.meza@uabc.edu.mx', 'Cesar', 'Miranda Meza', 'user', 'TOi5Yf9Uj+HyiRVCA02FuWcJRyifyhwVY9ymv+FKUoHGZLMrO18k5x+cB4yGBMICB/Ejs8cOgKV0rgnTMg0K7A==', 1, '05322$2487!21$F!646968$!1542634158', 'ACTIVE', 'DraftMedia Web API', '2018-11-19 14:29:18'),
	(22, 'cesar.miranda.meza@uabc.edu.mx', 'Cesar', 'Miranda Meza', 'user', 'A77AUquUrNZUotio1XtDoPcrIxLeVojDegR4PVq2EnnYFovTcnESnX93h2tHSLD4UEIU4QWB+sPoGvA7V3J1Tw==', 1, '16828$7411!22$F!481695$!1542634187', 'ACTIVE', 'DraftMedia Web API', '2018-11-19 14:29:47'),
	(23, 'cesar.miranda.meza@uabc.edu.mx', 'Cesar', 'Miranda Meza', 'user', 'TpaQq4wHDaIFRkx2XyX+qQU+SOSbma24Pp3BmrQQX4hXeqSLn6papuKqql667sELE1OHdHxSFI3HV9osJfrkkQ==', 1, '62179$4455!23$F!438383$!1542637036', 'ACTIVE', 'DraftMedia Web API', '2018-11-19 15:17:16'),
	(24, 'TestOmar@correo.com', 'Testomar', 'Avilatest', 'user', 'er186LD1wuI6+3PA8ogqU409BYBgXPzp/YuxNaFKUFVcZVnBKWtmXbAweGhWEeHMd+ogASCOqhKI5bVa4nUwXA==', 1, '34175$4436!24$F!688525$!1543158489', 'ACTIVE', 'DraftMedia Web API', '2018-11-25 16:08:09');
/*!40000 ALTER TABLE `account_registery` ENABLE KEYS */;

-- Dumping structure for table draftmedia.company_expenses
CREATE TABLE IF NOT EXISTS `company_expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_provider_id` int(11) NOT NULL,
  `expenses_category_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `description` varchar(510) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_id` (`company_provider_id`),
  KEY `expenses_category_id` (`expenses_category_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.company_expenses: ~0 rows (approximately)
/*!40000 ALTER TABLE `company_expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_expenses` ENABLE KEYS */;

-- Dumping structure for table draftmedia.company_providers
CREATE TABLE IF NOT EXISTS `company_providers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `provider_phone` varchar(255) NOT NULL,
  `provider_address` varchar(510) NOT NULL,
  `provider_website` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.company_providers: ~0 rows (approximately)
/*!40000 ALTER TABLE `company_providers` DISABLE KEYS */;
/*!40000 ALTER TABLE `company_providers` ENABLE KEYS */;

-- Dumping structure for table draftmedia.contact_us
CREATE TABLE IF NOT EXISTS `contact_us` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` varchar(510) NOT NULL,
  `is_attended` tinyint(4) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_by` varchar(11) DEFAULT NULL,
  `modified_by` varchar(11) DEFAULT NULL,
  `deleted_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.contact_us: ~7 rows (approximately)
/*!40000 ALTER TABLE `contact_us` DISABLE KEYS */;
INSERT INTO `contact_us` (`id`, `name`, `email`, `message`, `is_attended`, `status`, `created_by`, `modified_by`, `deleted_by`, `created_at`, `modified_at`, `deleted_at`) VALUES
	(1, 'Cesar', 'cesar@correo.com', 'Holiisss', 1, 'DELETED', '2', '2', 'DraftMedia Server', '2017-11-15 23:37:33', '2018-06-27 18:18:43', '2018-11-27 18:41:26'),
	(2, 'Ramon', 'cesar@correo.com', 'Holiisss222', 1, 'ACTIVE', '2', '2', NULL, '2017-11-15 23:38:52', '2018-11-28 00:24:30', NULL),
	(3, 'Grecia', 'grecia@correo.com', 'Grecia Te Manda Saludos.', 0, 'ACTIVE', '2', NULL, NULL, '2018-01-15 23:39:17', NULL, NULL),
	(4, 'Cesartest', 'CesarTest@correo.com', 'Asdfaefadfwer', 0, 'ACTIVE', '', NULL, NULL, '2018-11-25 00:21:32', NULL, NULL),
	(5, 'Dasda', 'asdada@corre.com', 'Qweqdase', 0, 'ACTIVE', '', NULL, NULL, '2018-11-25 00:33:16', NULL, NULL),
	(6, 'Dfasda', 'dasdasd@corre.com', 'Ewrfwefew', 0, 'ACTIVE', '', NULL, NULL, '2018-11-25 15:09:56', NULL, NULL),
	(7, 'Mario Montoya', 'maquilado@correo.com', 'Hola Me Interesaria Hacer Un Sitio Web De Mi Empre', 0, 'ACTIVE', '2', NULL, NULL, '2018-11-27 18:13:48', NULL, NULL);
/*!40000 ALTER TABLE `contact_us` ENABLE KEYS */;

-- Dumping structure for table draftmedia.dea_language
CREATE TABLE IF NOT EXISTS `dea_language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dea_requests_id` int(11) NOT NULL,
  `spanish` tinyint(4) DEFAULT '0',
  `english` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.dea_language: ~3 rows (approximately)
/*!40000 ALTER TABLE `dea_language` DISABLE KEYS */;
INSERT INTO `dea_language` (`id`, `dea_requests_id`, `spanish`, `english`) VALUES
	(25, 43, 1, 0),
	(26, 44, 1, 0),
	(27, 45, 0, 1),
	(28, 46, 0, 1),
	(29, 49, 1, 0),
	(30, 50, 1, 0);
/*!40000 ALTER TABLE `dea_language` ENABLE KEYS */;

-- Dumping structure for table draftmedia.dea_requests
CREATE TABLE IF NOT EXISTS `dea_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orders_id` int(11) DEFAULT NULL,
  `products_id` int(11) DEFAULT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `know_about_us` varchar(255) NOT NULL,
  `workfield` varchar(255) NOT NULL,
  `terms_and_conditions` tinyint(4) NOT NULL,
  `service_required` varchar(255) NOT NULL,
  `package_required` varchar(255) NOT NULL,
  `service_status` varchar(255) DEFAULT NULL,
  `status` varchar(510) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `opening_paid_at` timestamp NULL DEFAULT NULL,
  `service_active_up_to` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_id` (`orders_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.dea_requests: ~9 rows (approximately)
/*!40000 ALTER TABLE `dea_requests` DISABLE KEYS */;
INSERT INTO `dea_requests` (`id`, `orders_id`, `products_id`, `first_name`, `last_name`, `phone`, `sex`, `company_name`, `country`, `know_about_us`, `workfield`, `terms_and_conditions`, `service_required`, `package_required`, `service_status`, `status`, `created_by`, `modified_by`, `opening_paid_at`, `service_active_up_to`, `created_at`, `modified_at`, `deleted_at`) VALUES
	(43, 52, 2, 'Liviere', 'Miranda Meza', '6641787453', 'female', 'liviland', 'andorra', 'buscador de internet', 'administrativo/financiero/contable', 1, 'dea_webdesign', 'paquete emprendedor', 'Vigente', 'ACTIVE', '2', NULL, '2018-11-08 20:00:17', '2018-12-15 00:00:00', '2018-11-07 17:02:47', NULL, NULL),
	(44, 59, 7, 'Jose Enrique', 'Prieto Medina', '6543212564', 'male', 'tractocamioneta', 'antigua y barbuda', 'buscador de internet', 'asesoria fiscal/auditoria', 1, 'dea_webdesign', 'paquete personal', 'Vigente', 'ACTIVE', '4', NULL, '2018-11-15 18:52:07', '2018-12-14 00:00:00', '2018-09-08 17:46:29', NULL, NULL),
	(45, NULL, 2, 'Jose Enrique', 'Prieto Medina', '6541834861', 'male', 'el torton', 'barbados', 'por recomendacion', 'alimentos/bebidas/tabaco', 1, 'dea_webdesign', 'paquete emprendedor', 'Porfavor, suba los archivos pendientes', 'ACTIVE', '4', NULL, NULL, NULL, '2018-11-08 18:11:17', NULL, NULL),
	(46, 67, 1, 'Grecia Valeria', 'Jaime Portillo', '6643862175', 'female', 'paint-art', 'mexico', 'redes sociales', 'agencias de publicidad', 1, 'dea_webdesign', 'paquete empresarial', 'Vigente', 'ACTIVE', '2', NULL, '2018-11-15 18:46:17', '2018-12-01 00:00:00', '2018-11-09 00:08:08', NULL, NULL),
	(47, NULL, NULL, 'Oscar', 'Willie', '3265987456', 'male', 'willie town', 'mexico', 'buscador de internet', 'aeronautica', 1, 'dea_multimedia', 'paquete personal', 'En Proceso de Revision', 'ACTIVE', '2', NULL, NULL, NULL, '2018-11-15 22:08:25', NULL, NULL),
	(48, NULL, NULL, 'Asdfs', 'Asfjweiomsc', '5416515316', 'female', 'sdfasdf', 'san cristobal y nieves', 'buscador de internet', 'agencias de cambio y bolsa', 1, 'dea_multimedia', 'paquete emprendedor', 'En Proceso de Revision', 'ACTIVE', '2', NULL, NULL, NULL, '2018-11-15 22:39:50', NULL, NULL),
	(50, 58, 7, 'Nana', 'Meza', '6541239874', 'female', '', 'arabia saudita', 'buscador de internet', 'agencias de colocacion', 1, 'dea_webdesign', 'paquete personal', 'Vigente', 'ACTIVE', '2', NULL, '2018-11-20 19:21:36', '2018-12-15 00:00:00', '2018-11-20 19:20:27', NULL, NULL),
	(51, NULL, NULL, 'Adaffasdf', 'Asdgqwacqwe', '1231312312', 'male', '', 'barein', 'buscador de internet', 'comercio exterior', 1, 'dea_planning', 'paquete personal', 'En Proceso de Revision', 'ACTIVE', '2', NULL, NULL, NULL, '2018-11-21 14:16:42', NULL, NULL),
	(52, NULL, NULL, 'Bvberuidfhgert', 'Bsdfweycxvsd', '4545245454', 'female', '', 'afghanistan', 'otro medio de internet', 'agencias de colocacion', 1, 'dea_multimedia', 'paquete personal', 'En Proceso de Revision', 'ACTIVE', '2', NULL, NULL, NULL, '2018-11-21 14:24:54', NULL, NULL);
/*!40000 ALTER TABLE `dea_requests` ENABLE KEYS */;

-- Dumping structure for table draftmedia.dea_webdesign
CREATE TABLE IF NOT EXISTS `dea_webdesign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dea_requests_id` int(11) NOT NULL,
  `dea_language_id` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `website_category` varchar(255) NOT NULL,
  `website_views` int(11) NOT NULL,
  `is_base_colors` tinyint(4) NOT NULL,
  `base_colors_lvl_attch` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) NOT NULL,
  `target_audience` varchar(255) NOT NULL,
  `what_to_transmit` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.dea_webdesign: ~3 rows (approximately)
/*!40000 ALTER TABLE `dea_webdesign` DISABLE KEYS */;
INSERT INTO `dea_webdesign` (`id`, `dea_requests_id`, `dea_language_id`, `project_name`, `website_category`, `website_views`, `is_base_colors`, `base_colors_lvl_attch`, `website_url`, `target_audience`, `what_to_transmit`) VALUES
	(23, 43, 25, 'liviland', 'comercial', 2, 0, '', 'www.miniandlivi.com', 'empresas contables', 'as hfksadf lkjaslkdfj laskjfdlk asfjalskjf askdljflk asjdfklsdfj lskdfj lklk.'),
	(24, 44, 26, 'el camioneton', 'entretenimiento', 1, 0, '', 'www.elcamioneton.com.mx', 'abogados, licenciados y contadores', 'me intesa que la cosa se vea ardiente.'),
	(25, 45, 27, 'el tortoneitorz', 'comercial', 2, 1, 'fuerte', 'www.eltorton.com', 'el pueblo', 'asdfsakd jfklsadjf klsadjf lkasfj aslkfdj sad.'),
	(26, 46, 28, 'paint-art', 'entretenimiento', 1, 0, '', 'www.painart.com', 'sector industrial en general', 'asdfjksal fjsalk fjlksafj askldfj saklfj asklfjlsakdf lk.'),
	(27, 49, 29, 'hahaha', 'promocional', 1, 0, '', 'www.tryiobfkly.com.mx', 'asfawefs', 'safwefasd'),
	(28, 50, 30, 'nanalandia', 'contenido', 1, 0, '', 'www.nana.com', 'mujeres', 'asfsagasdfgasdfgasdf');
/*!40000 ALTER TABLE `dea_webdesign` ENABLE KEYS */;

-- Dumping structure for table draftmedia.dea_webdesign_colors
CREATE TABLE IF NOT EXISTS `dea_webdesign_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dea_webdesign_id` int(11) NOT NULL DEFAULT '0',
  `base_color_code` varchar(50) NOT NULL,
  `base_color_priority` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.dea_webdesign_colors: ~2 rows (approximately)
/*!40000 ALTER TABLE `dea_webdesign_colors` DISABLE KEYS */;
INSERT INTO `dea_webdesign_colors` (`id`, `dea_webdesign_id`, `base_color_code`, `base_color_priority`) VALUES
	(13, 25, '090911', 50),
	(14, 25, 'FF0011', 50);
/*!40000 ALTER TABLE `dea_webdesign_colors` ENABLE KEYS */;

-- Dumping structure for table draftmedia.dea_webdesign_views
CREATE TABLE IF NOT EXISTS `dea_webdesign_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dea_webdesign_id` int(11) NOT NULL DEFAULT '0',
  `type_of_website` varchar(255) NOT NULL,
  `sections_quantity` int(11) NOT NULL DEFAULT '0',
  `is_user_art_concept` tinyint(4) NOT NULL DEFAULT '0',
  `user_art_concept_dir` varchar(255) DEFAULT NULL,
  `is_ext_art_concept` tinyint(4) NOT NULL DEFAULT '0',
  `ext_art_concept_url` varchar(255) DEFAULT NULL,
  `ext_art_concept_exp` varchar(255) DEFAULT NULL,
  `is_user_ani_concept` tinyint(4) NOT NULL DEFAULT '0',
  `user_ani_concept_dir` varchar(255) DEFAULT NULL,
  `is_ext_ani_concept` tinyint(4) NOT NULL DEFAULT '0',
  `ext_ani_concept_url` varchar(255) DEFAULT NULL,
  `ext_ani_concept_exp` varchar(255) DEFAULT NULL,
  `is_other_concept` tinyint(4) NOT NULL DEFAULT '0',
  `other_concept_url` varchar(255) DEFAULT NULL,
  `other_concept_exp` varchar(255) DEFAULT NULL,
  `is_logic_diagram` tinyint(4) NOT NULL DEFAULT '0',
  `logic_diagram_dir` varchar(255) DEFAULT NULL,
  `logic_diagram_exp` varchar(255) DEFAULT NULL,
  `section1_content` varchar(510) DEFAULT NULL,
  `section2_content` varchar(510) DEFAULT NULL,
  `section3_content` varchar(510) DEFAULT NULL,
  `section4_content` varchar(510) DEFAULT NULL,
  `section5_content` varchar(510) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.dea_webdesign_views: ~5 rows (approximately)
/*!40000 ALTER TABLE `dea_webdesign_views` DISABLE KEYS */;
INSERT INTO `dea_webdesign_views` (`id`, `dea_webdesign_id`, `type_of_website`, `sections_quantity`, `is_user_art_concept`, `user_art_concept_dir`, `is_ext_art_concept`, `ext_art_concept_url`, `ext_art_concept_exp`, `is_user_ani_concept`, `user_ani_concept_dir`, `is_ext_ani_concept`, `ext_ani_concept_url`, `ext_ani_concept_exp`, `is_other_concept`, `other_concept_url`, `other_concept_exp`, `is_logic_diagram`, `logic_diagram_dir`, `logic_diagram_exp`, `section1_content`, `section2_content`, `section3_content`, `section4_content`, `section5_content`) VALUES
	(6, 23, 'pagina de inicio', 2, 1, './img/uploads/dea/2/1541676824.png', 1, 'www.asdfasfasd.com', 'sfjklsadjflsakf', 1, './img/uploads/dea/2/1541676790.png', 1, 'www.sadfhsajhfkjasdf.com.mx', 'sadfjaklsfjsalkf', 1, 'www.asdfjasfhaslfk.com.mx', 'skajflsakfjsalkfjsalkf', 1, './img/uploads/dea/2/1541676707.png', 'evolucion de mexico', 'sadfsa kldfjlkasdjf lkasfjasdlkf aslkjflkasjf.', 'safhaslfsafhouiehfeow nvonowhnvjqoiwnv qwerjn wonvvn.', '', '', ''),
	(7, 23, 'pagina para carrito de compras', 1, 1, './img/uploads/dea/2/1541676862.png', 1, 'www.jafkslddklfjasdl.com', 'sfoaskfjoiwqejfvn woifj salkvjlwek jfslkxv.', 0, NULL, 0, '', '', 0, '', '', 1, './img/uploads/dea/2/1541676889.png', 'alimentos 123', 'sjdf lsadfkl sdfjjk asdhfiowe nvkjnqweo nvjkn21341 af sdfjklsdj.', '', '', '', ''),
	(8, 24, 'pagina de inicio', 1, 0, NULL, 0, '', '', 0, NULL, 0, '', '', 0, '', '', 0, NULL, NULL, 'quiero que se vea un camioneton negro.', '', '', '', ''),
	(9, 25, 'pagina de inicio', 2, 1, NULL, 1, 'www.asdjfowiefnlksadfklsa.com', 'sadfjkwioefjs aiofjosiaj fweioj fslkdfj', 1, NULL, 1, 'www.sfjhsjf.com.mx', 'sakjfwieo jsaoifj siadofj askldfjskal djfsdkaljf sadiofjsadkfj sdlkjfd askdf.', 1, 'www.qwerasdfxzcv.com.mx', 'sdf sajfhs afjkl23j r8sfj8 aso3kj4 lksdfj 8sajfklsaf sdf.', 1, NULL, NULL, 'sdadf jksadhf7 sadhf 932 98hsd9 f823h9f sadjklf hsljdkf .', 'ufasjkdf hd98fuh23 uioshdf 89ashrojkewh klsj iosafj sadlk.', '', '', ''),
	(10, 25, 'pagina para carrito de compras', 1, 1, NULL, 0, '', '', 0, NULL, 1, 'www.klasjfklsajfzz.com', 'fasdfweq asr wear sadf asd fasdf sadf asdfsdfas.', 0, '', '', 0, NULL, NULL, ' dkjghsdfjsdahfj ksahdfjksadjkfh sadjkfhsda fjaskfhf32h 9usadjfh 28947h iufh isadfdf.', '', '', '', ''),
	(11, 26, 'pagina de inicio', 1, 1, NULL, 1, 'www.google.com', 'yo estoy mas chida', 1, NULL, 1, 'www.youtube.com', 'yo soy mejor que ellos', 1, 'www.hotmail.com', 'tambien soy mejor que ellos', 1, NULL, NULL, 'afjsakdfj sakdfj klsajdfklsadjfklas jfklaslkf fadsafsa.', '', '', '', ''),
	(12, 27, 'pagina de inicio', 1, 0, NULL, 0, '', '', 0, NULL, 0, '', '', 0, '', '', 1, './img/uploads/dea/2/1542350479.png', 'hdfhddfg', 'ouiouipouiouip', '', '', '', ''),
	(13, 28, 'pagina de inicio', 1, 0, NULL, 0, '', '', 0, NULL, 0, '', '', 0, '', '', 0, NULL, NULL, 'sfasdgasdfahsdfsdaghasg', '', '', '', '');
/*!40000 ALTER TABLE `dea_webdesign_views` ENABLE KEYS */;

-- Dumping structure for table draftmedia.draftmedia_visitors
CREATE TABLE IF NOT EXISTS `draftmedia_visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(4) DEFAULT NULL,
  `user_real_ip_address` varchar(50) NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `operative_system` varchar(50) DEFAULT NULL,
  `device` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.draftmedia_visitors: ~26 rows (approximately)
/*!40000 ALTER TABLE `draftmedia_visitors` DISABLE KEYS */;
INSERT INTO `draftmedia_visitors` (`id`, `user_id`, `user_real_ip_address`, `city`, `region`, `country`, `browser`, `operative_system`, `device`, `brand`, `model`, `last_activity_at`, `created_at`) VALUES
	(1, NULL, '70.42.131.170', '', '', 'United States', 'Internet Explorer', 'Windows', 'desktop', '', '', '2018-10-28 22:00:13', '2018-10-22 11:10:25'),
	(2, 0, '18.237.172.140', 'Boardman', 'Oregon', 'United States', 'Chrome', 'Windows', 'desktop', '', '', '2018-11-23 17:47:17', '2018-10-23 17:47:17'),
	(3, 0, '34.221.161.147', 'Boardman', 'Oregon', 'United States', 'Chrome', 'Windows', 'desktop', '', '', '2018-11-23 18:15:13', '2018-11-23 18:15:13'),
	(7, NULL, '68.6.206.194', 'San Diego', 'California', 'United States', 'Chrome', 'Windows', 'desktop', '', '', '2018-11-24 22:59:58', '2018-11-24 19:59:09'),
	(9, 0, '189.248.168.150', 'Guaymas', 'Sonora', 'Mexico', 'Chrome', 'Windows', 'desktop', '', '', '2018-11-27 06:36:20', '2018-11-27 06:36:20'),
	(11, 0, '65.154.226.109', NULL, NULL, 'United States', 'Internet Explorer', 'Windows', 'desktop', '', '', '2018-11-27 16:44:48', '2018-11-27 16:44:48'),
	(12, 0, '201.137.250.112', 'Mexico City', 'Mexico City', 'Mexico', 'Chrome Mobile', 'Android', 'smartphone', '', '', '2018-11-28 03:20:15', '2018-11-28 03:20:15'),
	(13, 0, '116.118.75.193', 'Ho Chi Minh City', 'Ho Chi Minh', 'Vietnam', 'Chrome Mobile', 'Android', 'smartphone', 'Huawei', 'P20 Pro', '2018-11-28 04:03:18', '2018-11-28 04:03:18'),
	(14, 0, '103.1.31.36', 'Savannakhet', 'Khoueng Savannakhet', 'Laos', 'Chrome Mobile', 'Android', 'smartphone', 'Samsung', 'GALAXY A8', '2018-11-28 04:12:52', '2018-11-28 04:12:52'),
	(15, 0, '82.222.43.164', 'Istanbul', 'Istanbul', 'Turkey', 'Mobile Safari', 'iOS', 'tablet', 'Apple', 'iPad', '2018-11-28 04:47:21', '2018-11-28 04:47:21'),
	(16, NULL, '221.121.39.56', NULL, NULL, 'Vietnam', 'Chrome', 'Windows', 'desktop', '', '', '2018-11-28 06:02:42', '2018-11-28 05:57:54'),
	(17, 0, '186.185.0.121', 'Caracas', 'Distrito Federal', 'Venezuela', 'Chrome Mobile', 'Android', 'smartphone', 'Huawei', 'ATU-LX3', '2018-11-28 06:20:05', '2018-11-28 06:20:05'),
	(18, 2, '187.250.220.251', 'Tijuana', 'Estado de Baja California', 'Mexico', 'Firefox', 'Windows', 'desktop', '', '', '2018-11-29 18:30:00', '2018-11-28 15:16:31'),
	(19, 0, '189.216.99.21', 'Mexico City', 'Mexico City', 'Mexico', 'Mobile Safari', 'iOS', 'smartphone', 'Apple', 'iPhone', '2018-11-29 06:42:54', '2018-11-29 06:42:54'),
	(20, 0, '187.163.57.80', 'Mexico City', 'Mexico City', 'Mexico', 'Mobile Safari', 'iOS', 'smartphone', 'Apple', 'iPhone', '2018-11-29 06:50:11', '2018-11-29 06:50:11'),
	(21, 0, '148.240.193.128', 'Ciudad Juárez', 'Chihuahua', 'Mexico', 'Microsoft Edge', 'Windows', 'desktop', '', '', '2018-11-29 06:50:36', '2018-11-29 06:50:36'),
	(22, 0, '157.37.148.175', 'Jaipur', 'Rajasthan', 'India', 'Firefox Mobile', 'KaiOS', 'smartphone', 'LYF', 'F10Q', '2018-11-29 06:55:15', '2018-11-29 06:55:15'),
	(23, 0, '189.240.103.207', 'Naucalpan', 'Estado de Mexico', 'Mexico', 'MIUI Browser', 'Android', 'smartphone', 'Xiaomi', 'Redmi 3S', '2018-11-29 07:51:41', '2018-11-29 07:51:41'),
	(24, 0, '177.240.54.165', 'Guadalajara', 'Jalisco', 'Mexico', 'Chrome Mobile', 'Android', 'smartphone', 'Hisense', 'F23', '2018-11-29 09:50:49', '2018-11-29 09:50:49'),
	(25, 0, '189.245.118.231', 'Heroica Matamoros', 'Tamaulipas', 'Mexico', 'Microsoft Edge', 'Windows', 'desktop', '', '', '2018-11-29 13:35:08', '2018-11-29 13:35:08'),
	(26, NULL, '189.223.175.68', 'Tecate', 'Estado de Baja California', 'Mexico', '', 'Android', '', '', '', '2018-11-29 14:14:49', '2018-11-29 14:12:54'),
	(27, 0, '200.68.132.64', 'Tijuana', 'Estado de Baja California', 'Mexico', '', 'Android', 'smartphone', 'Samsung', 'GALAXY J7', '2018-11-29 14:23:20', '2018-11-29 14:23:20'),
	(28, 0, '177.226.238.81', 'Puebla City', 'Puebla', 'Mexico', 'Mobile Safari', 'iOS', 'smartphone', 'Apple', 'iPhone', '2018-11-29 18:29:00', '2018-11-29 14:44:33'),
	(29, 0, '189.245.126.50', 'Heroica Matamoros', 'Tamaulipas', 'Mexico', 'Chrome Mobile', 'Android', 'smartphone', 'ZTE', 'Blade Z Max Pro', '2018-11-29 14:46:06', '2018-11-29 14:46:06'),
	(30, 0, '201.175.135.213', 'Mexico City', 'Mexico City', 'Mexico', 'Mobile Safari', 'iOS', 'smartphone', 'Apple', 'iPhone', '2018-11-29 14:46:53', '2018-11-29 14:46:53'),
	(31, 0, '187.189.156.112', 'Mexico City', 'Mexico City', 'Mexico', 'Chrome Mobile', 'Android', 'smartphone', 'Motorola', 'Moto G4', '2018-11-29 18:28:04', '2018-11-29 15:59:04');
/*!40000 ALTER TABLE `draftmedia_visitors` ENABLE KEYS */;

-- Dumping structure for table draftmedia.draftmedia_visits
CREATE TABLE IF NOT EXISTS `draftmedia_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Aboutus_index_anonym_visits` varchar(50) DEFAULT '0',
  `Aboutus_index_auth_visits` varchar(50) DEFAULT '0',
  `Aboutus_index_anonym_time` varchar(50) DEFAULT '0',
  `Aboutus_index_auth_time` varchar(50) DEFAULT '0',
  `CompanyPolitics_privacyPolitics_anonym_visits` varchar(50) DEFAULT '0',
  `CompanyPolitics_privacyPolitics_auth_visits` varchar(50) DEFAULT '0',
  `CompanyPolitics_privacyPolitics_anonym_time` varchar(50) DEFAULT '0',
  `CompanyPolitics_privacyPolitics_auth_time` varchar(50) DEFAULT '0',
  `CompanyPolitics_termsAndConditions_anonym_visits` varchar(50) DEFAULT '0',
  `CompanyPolitics_termsAndConditions_auth_visits` varchar(50) DEFAULT '0',
  `CompanyPolitics_termsAndConditions_anonym_time` varchar(50) DEFAULT '0',
  `CompanyPolitics_termsAndConditions_auth_time` varchar(50) DEFAULT '0',
  `Dea_uploadFiles_anonym_visits` varchar(50) DEFAULT '0',
  `Dea_uploadFiles_auth_visits` varchar(50) DEFAULT '0',
  `Dea_uploadFiles_anonym_time` varchar(50) DEFAULT '0',
  `Dea_uploadFiles_auth_time` varchar(50) DEFAULT '0',
  `Dea_index_anonym_visits` varchar(50) DEFAULT '0',
  `Dea_index_auth_visits` varchar(50) DEFAULT '0',
  `Dea_index_anonym_time` varchar(50) DEFAULT '0',
  `Dea_index_auth_time` varchar(50) DEFAULT '0',
  `Home_index_anonym_visits` varchar(50) DEFAULT '0',
  `Home_index_auth_visits` varchar(50) DEFAULT '0',
  `Home_index_anonym_time` varchar(50) DEFAULT '0',
  `Home_index_auth_time` varchar(50) DEFAULT '0',
  `Login_index_anonym_visits` varchar(50) DEFAULT '0',
  `Login_index_auth_visits` varchar(50) DEFAULT '0',
  `Login_index_anonym_time` varchar(50) DEFAULT '0',
  `Login_index_auth_time` varchar(50) DEFAULT '0',
  `Pricing_index_anonym_visits` varchar(50) DEFAULT '0',
  `Pricing_index_auth_visits` varchar(50) DEFAULT '0',
  `Pricing_index_anonym_time` varchar(50) DEFAULT '0',
  `Pricing_index_auth_time` varchar(50) DEFAULT '0',
  `Register_index_anonym_visits` varchar(50) DEFAULT '0',
  `Register_index_auth_visits` varchar(50) DEFAULT '0',
  `Register_index_anonym_time` varchar(50) DEFAULT '0',
  `Register_index_auth_time` varchar(50) DEFAULT '0',
  `Services_index_anonym_visits` varchar(50) DEFAULT '0',
  `Services_index_auth_visits` varchar(50) DEFAULT '0',
  `Services_index_anonym_time` varchar(50) DEFAULT '0',
  `Services_index_auth_time` varchar(50) DEFAULT '0',
  `UserProfile_index_anonym_visits` varchar(50) DEFAULT '0',
  `UserProfile_index_auth_visits` varchar(50) DEFAULT '0',
  `UserProfile_index_anonym_time` varchar(50) DEFAULT '0',
  `UserProfile_index_auth_time` varchar(50) DEFAULT '0',
  `UserRequests_index_anonym_visits` varchar(50) DEFAULT '0',
  `UserRequests_index_auth_visits` varchar(50) DEFAULT '0',
  `UserRequests_index_anonym_time` varchar(50) DEFAULT '0',
  `UserRequests_index_auth_time` varchar(50) DEFAULT '0',
  `max_users_online` varchar(50) DEFAULT '0',
  `current_users_online` varchar(50) DEFAULT '0',
  `number_of_sessions` varchar(50) DEFAULT '0',
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=865 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.draftmedia_visits: ~75 rows (approximately)
/*!40000 ALTER TABLE `draftmedia_visits` DISABLE KEYS */;
INSERT INTO `draftmedia_visits` (`id`, `Aboutus_index_anonym_visits`, `Aboutus_index_auth_visits`, `Aboutus_index_anonym_time`, `Aboutus_index_auth_time`, `CompanyPolitics_privacyPolitics_anonym_visits`, `CompanyPolitics_privacyPolitics_auth_visits`, `CompanyPolitics_privacyPolitics_anonym_time`, `CompanyPolitics_privacyPolitics_auth_time`, `CompanyPolitics_termsAndConditions_anonym_visits`, `CompanyPolitics_termsAndConditions_auth_visits`, `CompanyPolitics_termsAndConditions_anonym_time`, `CompanyPolitics_termsAndConditions_auth_time`, `Dea_uploadFiles_anonym_visits`, `Dea_uploadFiles_auth_visits`, `Dea_uploadFiles_anonym_time`, `Dea_uploadFiles_auth_time`, `Dea_index_anonym_visits`, `Dea_index_auth_visits`, `Dea_index_anonym_time`, `Dea_index_auth_time`, `Home_index_anonym_visits`, `Home_index_auth_visits`, `Home_index_anonym_time`, `Home_index_auth_time`, `Login_index_anonym_visits`, `Login_index_auth_visits`, `Login_index_anonym_time`, `Login_index_auth_time`, `Pricing_index_anonym_visits`, `Pricing_index_auth_visits`, `Pricing_index_anonym_time`, `Pricing_index_auth_time`, `Register_index_anonym_visits`, `Register_index_auth_visits`, `Register_index_anonym_time`, `Register_index_auth_time`, `Services_index_anonym_visits`, `Services_index_auth_visits`, `Services_index_anonym_time`, `Services_index_auth_time`, `UserProfile_index_anonym_visits`, `UserProfile_index_auth_visits`, `UserProfile_index_anonym_time`, `UserProfile_index_auth_time`, `UserRequests_index_anonym_visits`, `UserRequests_index_auth_visits`, `UserRequests_index_anonym_time`, `UserRequests_index_auth_time`, `max_users_online`, `current_users_online`, `number_of_sessions`, `date`) VALUES
	(1, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '1', '705', '5', '1', '0', '5', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '5', '1', '1', '0', '2018-11-23 16:00:00'),
	(5, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '1840', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '5', '0', '0', '0', '2018-11-23 18:00:00'),
	(6, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '4', '0', '1465', '0', '0', '0', '0', '0', '1', '0', '4605', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-23 20:00:00'),
	(7, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '9', '17', '1100', '2770', '12', '0', '620', '55', '0', '1', '0', '1620', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '2', '0', '2018-11-23 22:00:00'),
	(8, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '1', '1405', '1935', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '2018-11-24 00:00:00'),
	(9, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 02:00:00'),
	(10, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 04:00:00'),
	(11, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 06:00:00'),
	(12, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 08:00:00'),
	(13, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 10:00:00'),
	(14, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 12:00:00'),
	(15, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '5', '0', '4005', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 14:00:00'),
	(16, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '3905', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 16:00:00'),
	(17, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '63', '0', '6460', '0', '0', '0', '0', '0', '2', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 18:00:00'),
	(18, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '45', '28', '4470', '1045', '1', '0', '10', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-24 20:00:00'),
	(19, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '18', '0', '6645', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-24 22:00:00'),
	(20, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '4', '0', '7180', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 00:00:00'),
	(21, '1', '0', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '280', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 02:00:00'),
	(22, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 04:00:00'),
	(23, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 06:00:00'),
	(24, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 08:00:00'),
	(25, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 10:00:00'),
	(26, '8', '0', '600', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0', '25', '0', '0', '0', '0', '0', '4', '0', '395', '0', '0', '0', '0', '0', '6', '0', '210', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 12:00:00'),
	(27, '4', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '3', '0', '20', '0', '11', '0', '3970', '0', '19', '0', '1935', '0', '3', '0', '1100', '0', '4', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 14:00:00'),
	(28, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '5', '3', '0', '5', '5', '0', '0', '0', '0', '5', '0', '610', '0', '0', '0', '0', '0', '0', '17', '0', '1990', '0', '0', '0', '0', '1', '1', '0', '2018-11-25 16:00:00'),
	(29, '0', '0', '0', '0', '0', '4', '0', '75', '0', '5', '0', '555', '0', '9', '0', '860', '0', '3', '0', '1750', '0', '1', '0', '10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1250', '0', '12', '0', '3015', '1', '1', '0', '2018-11-25 18:00:00'),
	(30, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '420', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 20:00:00'),
	(31, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '3185', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-25 22:00:00'),
	(32, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '7', '0', '2710', '1', '7', '5', '1765', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-26 00:00:00'),
	(33, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 02:00:00'),
	(34, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 04:00:00'),
	(35, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 06:00:00'),
	(36, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 08:00:00'),
	(37, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 10:00:00'),
	(38, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 12:00:00'),
	(39, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 14:00:00'),
	(40, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 16:00:00'),
	(41, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 18:00:00'),
	(42, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-26 20:00:00'),
	(43, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-26 22:00:00'),
	(44, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 00:00:00'),
	(45, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 02:00:00'),
	(46, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 04:00:00'),
	(47, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 06:00:00'),
	(48, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 08:00:00'),
	(49, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 10:00:00'),
	(50, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 12:00:00'),
	(51, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '30', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-27 14:00:00'),
	(52, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 16:00:00'),
	(53, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '30', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-27 18:00:00'),
	(54, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 20:00:00'),
	(55, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-27 22:00:00'),
	(56, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-28 00:00:00'),
	(57, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-28 02:00:00'),
	(58, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-28 04:00:00'),
	(59, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-28 06:00:00'),
	(60, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0', '155', '0', '1', '0', '5', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '2018-11-28 08:00:00'),
	(61, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '3', '2', '25', '10', '1', '0', '5', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-28 10:00:00'),
	(62, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '3', '0', '1275', '0', '2', '0', '10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '2018-11-28 12:00:00'),
	(63, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0', '15', '0', '1', '0', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-28 14:00:00'),
	(64, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-28 16:00:00'),
	(65, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-28 18:00:00'),
	(66, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-28 20:00:00'),
	(67, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '6', '0', '760', '0', '3', '0', '5', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '2', '0', '2018-11-28 22:00:00'),
	(68, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 00:00:00'),
	(69, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 02:00:00'),
	(70, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 04:00:00'),
	(71, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 06:00:00'),
	(72, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 08:00:00'),
	(73, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 10:00:00'),
	(74, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '0', '10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '0', '2018-11-29 12:00:00'),
	(75, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0', '35', '0', '2', '0', '10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1', '1', '2', '2018-11-29 14:00:00'),
	(859, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0', '75', '0', '2', '0', '45', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 16:00:00'),
	(861, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2', '0', '2', '2018-11-29 18:00:00'),
	(862, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 20:00:00'),
	(863, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-29 22:00:00'),
	(864, '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '2018-11-30 00:00:00');
/*!40000 ALTER TABLE `draftmedia_visits` ENABLE KEYS */;

-- Dumping structure for table draftmedia.draftmedia_visits_enable
CREATE TABLE IF NOT EXISTS `draftmedia_visits_enable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `enable` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.draftmedia_visits_enable: ~0 rows (approximately)
/*!40000 ALTER TABLE `draftmedia_visits_enable` DISABLE KEYS */;
INSERT INTO `draftmedia_visits_enable` (`id`, `enable`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `draftmedia_visits_enable` ENABLE KEYS */;

-- Dumping structure for table draftmedia.expenses_categories
CREATE TABLE IF NOT EXISTS `expenses_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department` varchar(255) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.expenses_categories: ~0 rows (approximately)
/*!40000 ALTER TABLE `expenses_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses_categories` ENABLE KEYS */;

-- Dumping structure for table draftmedia.hack_attempts
CREATE TABLE IF NOT EXISTS `hack_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aboutus` int(11) DEFAULT '0',
  `companypolitics` int(11) DEFAULT '0',
  `controller` int(11) DEFAULT '0',
  `dea` int(11) DEFAULT '0',
  `home` int(11) DEFAULT '0',
  `login` int(11) DEFAULT '0',
  `paypal` int(11) DEFAULT '0',
  `portfolio` int(11) DEFAULT '0',
  `pricing` int(11) DEFAULT '0',
  `register` int(11) DEFAULT '0',
  `services` int(11) DEFAULT '0',
  `user_profile` int(11) DEFAULT '0',
  `user_requests` int(11) DEFAULT '0',
  `admin_email` int(11) DEFAULT '0',
  `admin_login` int(11) DEFAULT '0',
  `admin_summary` int(11) DEFAULT '0',
  `method` varchar(255) NOT NULL,
  `user_real_ip_address` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `latitude` varchar(255) DEFAULT NULL,
  `longitude` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.hack_attempts: ~133 rows (approximately)
/*!40000 ALTER TABLE `hack_attempts` DISABLE KEYS */;
INSERT INTO `hack_attempts` (`id`, `aboutus`, `companypolitics`, `controller`, `dea`, `home`, `login`, `paypal`, `portfolio`, `pricing`, `register`, `services`, `user_profile`, `user_requests`, `admin_email`, `admin_login`, `admin_summary`, `method`, `user_real_ip_address`, `country`, `region`, `city`, `zipcode`, `organization`, `latitude`, `longitude`, `created_by`, `created_at`) VALUES
	(1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '2', '2018-10-27 11:53:17'),
	(2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '2', '2018-10-27 11:53:19'),
	(3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '2', '2018-10-27 11:53:19'),
	(4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '2', '2018-10-27 22:33:51'),
	(5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 5, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '4', '2018-11-08 17:52:01'),
	(6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '4', '2018-11-08 17:52:49'),
	(7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '4', '2018-11-08 17:53:17'),
	(8, 1, 0, 0, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 0, 'uploadFiles', '::1', '', '', '', '', '', '', '', '2', '2018-11-09 00:02:45'),
	(9, 2, 0, 0, 0, 0, 0, 0, 0, 0, 7, 0, 0, 0, 0, 0, 0, 'uploadFiles', '::1', '', '', '', '', '', '', '', '4', '2018-11-09 00:41:20'),
	(10, 3, 0, 0, 0, 0, 0, 0, 0, 0, 8, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '4', '2018-11-17 02:21:32'),
	(13, 3, 0, 0, 0, 0, 0, 0, 0, 0, 9, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '4', '2018-11-17 02:24:27'),
	(14, 3, 0, 0, 0, 0, 0, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '4', '2018-11-17 02:24:35'),
	(15, 3, 0, 0, 0, 0, 0, 0, 0, 0, 11, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', NULL, '2018-11-17 02:26:03'),
	(16, 3, 0, 0, 0, 0, 0, 0, 0, 0, 12, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '', '2018-11-17 02:26:26'),
	(17, 3, 0, 0, 0, 0, 0, 0, 0, 0, 13, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', '2', '2018-11-17 02:27:02'),
	(18, 4, 0, 0, 0, 0, 0, 0, 0, 0, 13, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '100', '2018-11-17 18:45:37'),
	(19, 4, 0, 0, 0, 0, 0, 0, 0, 0, 14, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', 'Mexico', 'Estado de Baja California', 'Tijuana', '22703', 'Telefonos del Noroeste, S.A. de C.V.', '32.5027', '-117.0037', NULL, '2018-11-20 02:02:58'),
	(20, 4, 0, 0, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', 'Mexico', 'Estado de Baja California', 'Tijuana', '22703', 'Telefonos del Noroeste, S.A. de C.V.', '32.5027', '-117.0037', NULL, '2018-11-20 02:06:43'),
	(21, 4, 0, 1, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', 'Mexico', 'Estado de Baja California', 'Tijuana', '22703', 'Telefonos del Noroeste, S.A. de C.V.', '32.5027', '-117.0037', '2', '2018-11-23 14:49:51'),
	(22, 4, 0, 2, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 14:51:04'),
	(23, 4, 0, 3, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 15:00:02'),
	(24, 4, 0, 4, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 15:00:03'),
	(25, 4, 0, 5, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 22:28:00'),
	(26, 4, 0, 6, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 22:28:05'),
	(27, 4, 0, 7, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 22:28:08'),
	(28, 4, 0, 8, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:17'),
	(29, 4, 0, 9, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:22'),
	(30, 4, 0, 10, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:27'),
	(31, 4, 0, 11, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:32'),
	(32, 4, 0, 12, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:37'),
	(33, 4, 0, 13, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:42'),
	(34, 4, 0, 14, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:47'),
	(35, 4, 0, 15, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:52'),
	(36, 4, 0, 16, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:12:57'),
	(37, 4, 0, 17, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:02'),
	(38, 4, 0, 18, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:07'),
	(39, 4, 0, 19, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:12'),
	(40, 4, 0, 20, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:17'),
	(41, 4, 0, 21, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:22'),
	(42, 4, 0, 22, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:27'),
	(43, 4, 0, 23, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:32'),
	(44, 4, 0, 24, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:37'),
	(45, 4, 0, 25, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:42'),
	(46, 4, 0, 26, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:47'),
	(47, 4, 0, 27, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:52'),
	(48, 4, 0, 28, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:13:57'),
	(49, 4, 0, 29, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:14:02'),
	(50, 4, 0, 30, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:14:07'),
	(51, 4, 0, 31, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:14:08'),
	(52, 4, 0, 32, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:20:07'),
	(53, 4, 0, 33, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:20:09'),
	(54, 4, 0, 34, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:01'),
	(55, 4, 0, 35, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:06'),
	(56, 4, 0, 36, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:11'),
	(57, 4, 0, 37, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:16'),
	(58, 4, 0, 38, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:21'),
	(59, 4, 0, 39, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:26'),
	(60, 4, 0, 40, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:31'),
	(61, 4, 0, 41, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:36'),
	(62, 4, 0, 42, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:42'),
	(63, 4, 0, 43, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:47'),
	(64, 4, 0, 44, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:52'),
	(65, 4, 0, 45, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:32:57'),
	(66, 4, 0, 46, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:02'),
	(67, 4, 0, 47, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:07'),
	(68, 4, 0, 48, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:13'),
	(69, 4, 0, 49, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:18'),
	(70, 4, 0, 50, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:23'),
	(71, 4, 0, 51, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:29'),
	(72, 4, 0, 52, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:33'),
	(73, 4, 0, 53, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:38'),
	(74, 4, 0, 54, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:43'),
	(75, 4, 0, 55, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:48'),
	(76, 4, 0, 56, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:54'),
	(77, 4, 0, 57, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:33:59'),
	(78, 4, 0, 58, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:04'),
	(79, 4, 0, 59, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:09'),
	(80, 4, 0, 60, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:14'),
	(81, 4, 0, 61, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:19'),
	(82, 4, 0, 62, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:24'),
	(83, 4, 0, 63, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:30'),
	(84, 4, 0, 64, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:35'),
	(85, 4, 0, 65, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:40'),
	(86, 4, 0, 66, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:45'),
	(87, 4, 0, 67, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:50'),
	(88, 4, 0, 68, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:34:55'),
	(89, 4, 0, 69, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:00'),
	(90, 4, 0, 70, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:06'),
	(91, 4, 0, 71, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:11'),
	(92, 4, 0, 72, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:16'),
	(93, 4, 0, 73, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:22'),
	(94, 4, 0, 74, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:26'),
	(95, 4, 0, 75, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:32'),
	(96, 4, 0, 76, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:36'),
	(97, 4, 0, 77, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:42'),
	(98, 4, 0, 78, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:47'),
	(99, 4, 0, 79, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:52'),
	(100, 4, 0, 80, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:35:58'),
	(101, 4, 0, 81, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:02'),
	(102, 4, 0, 82, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:07'),
	(103, 4, 0, 83, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:12'),
	(104, 4, 0, 84, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:18'),
	(105, 4, 0, 85, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:23'),
	(106, 4, 0, 86, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:28'),
	(107, 4, 0, 87, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:33'),
	(108, 4, 0, 88, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:38'),
	(109, 4, 0, 89, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:43'),
	(110, 4, 0, 90, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:48'),
	(111, 4, 0, 91, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:54'),
	(112, 4, 0, 92, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:36:59'),
	(113, 4, 0, 93, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:37:04'),
	(114, 4, 0, 94, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:37:09'),
	(115, 4, 0, 95, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:37:14'),
	(116, 4, 0, 96, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:37:19'),
	(117, 4, 0, 97, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:37:24'),
	(118, 4, 0, 98, 0, 0, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-23 23:37:25'),
	(119, 4, 0, 98, 0, 1, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'index', '::1', '', '', '', '', '', '', '', NULL, '2018-11-24 19:04:18'),
	(120, 4, 0, 98, 0, 2, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'ajaxLanguageSelection', '::1', '', '', '', '', '', '', '', NULL, '2018-11-24 19:05:24'),
	(121, 4, 0, 98, 0, 3, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'ajaxLanguageSelection', '::1', '', '', '', '', '', '', '', NULL, '2018-11-24 19:05:55'),
	(122, 4, 0, 98, 0, 4, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'ajaxLanguageSelection', '::1', '', '', '', '', '', '', '', NULL, '2018-11-24 19:06:25'),
	(123, 4, 0, 98, 0, 5, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'ajaxLanguageSelection', '::1', '', '', '', '', '', '', '', NULL, '2018-11-24 19:08:26'),
	(124, 4, 0, 98, 0, 6, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'ajaxLanguageSelection', '::1', '', '', '', '', '', '', '', NULL, '2018-11-24 19:09:24'),
	(125, 4, 0, 98, 0, 7, 0, 0, 0, 0, 15, 0, 0, 0, 0, 0, 0, 'ajaxLanguageSelection', '::1', '', '', '', '', '', '', '', NULL, '2018-11-24 19:09:36'),
	(126, 4, 0, 98, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'ajaxActivationLink', '::1', '', '', '', '', '', '', '', NULL, '2018-11-25 16:13:25'),
	(127, 4, 0, 99, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 09:17:51'),
	(128, 4, 0, 100, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 14:01:27'),
	(129, 4, 0, 101, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 14:01:29'),
	(130, 4, 0, 102, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 14:01:30'),
	(131, 4, 0, 103, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 14:03:18'),
	(132, 4, 0, 104, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 14:04:22'),
	(133, 4, 0, 105, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 14:06:10'),
	(134, 4, 0, 106, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 14:07:55'),
	(135, 4, 0, 107, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 14:09:04'),
	(136, 4, 0, 108, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '8', '2018-11-28 21:36:53'),
	(137, 4, 0, 109, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '8', '2018-11-28 22:14:55'),
	(138, 4, 0, 110, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '8', '2018-11-28 22:15:22'),
	(139, 4, 0, 111, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 22:17:56'),
	(140, 4, 0, 112, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '2', '2018-11-28 22:19:04'),
	(141, 4, 0, 113, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '8', '2018-11-28 22:19:35'),
	(142, 4, 0, 114, 0, 7, 0, 0, 0, 0, 16, 0, 0, 0, 0, 0, 0, 'getUser', '::1', '', '', '', '', '', '', '', '8', '2018-11-28 22:20:52');
/*!40000 ALTER TABLE `hack_attempts` ENABLE KEYS */;

-- Dumping structure for table draftmedia.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dea_requests_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `total_to_pay` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.orders: ~66 rows (approximately)
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` (`id`, `dea_requests_id`, `user_id`, `product_id`, `total_to_pay`, `status`, `created_by`, `created_at`, `deleted_at`) VALUES
	(1, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 20:28:00', NULL),
	(2, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 20:30:35', NULL),
	(3, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:52:57', NULL),
	(4, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:54:01', NULL),
	(5, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:54:36', NULL),
	(6, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:55:04', NULL),
	(7, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:56:08', NULL),
	(8, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:56:55', NULL),
	(9, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:58:26', NULL),
	(10, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:58:56', NULL),
	(11, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:59:10', NULL),
	(12, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:59:20', NULL),
	(13, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:59:31', NULL),
	(14, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 20:59:38', NULL),
	(15, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-09 21:00:17', NULL),
	(16, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:07:09', NULL),
	(17, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:07:53', NULL),
	(18, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:08:55', NULL),
	(19, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:09:35', NULL),
	(20, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:09:44', NULL),
	(21, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:13:10', NULL),
	(22, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:13:33', NULL),
	(23, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:14:39', NULL),
	(24, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:15:31', NULL),
	(25, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:16:42', NULL),
	(26, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:16:47', NULL),
	(27, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-09 21:16:58', NULL),
	(28, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 14:55:40', NULL),
	(29, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 15:31:41', NULL),
	(30, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 15:32:43', NULL),
	(31, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:14:37', NULL),
	(32, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:33:53', NULL),
	(33, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:34:21', NULL),
	(34, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:37:30', NULL),
	(35, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:37:58', NULL),
	(36, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:38:09', NULL),
	(37, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:39:31', NULL),
	(38, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:40:33', NULL),
	(39, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:41:37', NULL),
	(40, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:41:56', NULL),
	(41, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 16:57:59', NULL),
	(42, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 17:01:38', NULL),
	(43, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 17:04:13', NULL),
	(44, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 17:05:44', NULL),
	(45, 43, 2, 2, '666.65', 'ACTIVE', '2', '2018-11-15 18:41:24', NULL),
	(46, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-15 18:42:26', NULL),
	(47, 46, 2, 1, '1667', 'ACTIVE', '2', '2018-11-15 18:44:17', NULL),
	(48, 46, 2, 1, '1667', 'ACTIVE', '2', '2018-11-15 18:46:02', NULL),
	(49, 46, 2, 1, '333.32', 'ACTIVE', '2', '2018-11-15 18:47:09', NULL),
	(50, 44, 4, 1, '333.32', 'ACTIVE', '2', '2018-11-15 18:52:28', NULL),
	(51, 44, 4, 1, '333.32', 'ACTIVE', '2', '2018-11-15 18:53:28', NULL),
	(52, 43, 2, 2, '1499.99', 'ACTIVE', '2', '2018-11-15 18:54:20', NULL),
	(53, 44, 4, 1, '333.32', 'ACTIVE', '2', '2018-11-20 04:30:11', NULL),
	(54, 44, 4, 1, '58.34', 'ACTIVE', '2', '2018-11-20 19:09:42', NULL),
	(55, 44, 4, 7, '35', 'ACTIVE', '2', '2018-11-20 19:10:19', NULL),
	(56, 49, 2, 7, '35', 'ACTIVE', '2', '2018-11-20 19:11:36', NULL),
	(57, 50, 2, 7, '35', 'ACTIVE', '2', '2018-11-20 19:21:21', NULL),
	(58, 50, 2, 7, '35', 'ACTIVE', '2', '2018-11-20 19:24:00', NULL),
	(59, 44, 4, 7, '35', 'ACTIVE', '2', '2018-11-20 19:36:12', NULL),
	(60, 46, 2, 1, '58.34', 'ACTIVE', '2', '2018-11-23 10:53:53', NULL),
	(61, 46, 2, 1, '58.34', 'ACTIVE', '2', '2018-11-23 10:57:05', NULL),
	(62, 46, 2, 1, '58.34', 'ACTIVE', '2', '2018-11-23 10:59:28', NULL),
	(63, 46, 2, 1, '58.34', 'ACTIVE', '2', '2018-11-23 11:22:54', NULL),
	(64, 46, 2, 1, '58.34', 'ACTIVE', '2', '2018-11-23 11:23:07', NULL),
	(65, 46, 2, 1, '58.34', 'ACTIVE', '2', '2018-11-23 11:39:58', NULL),
	(66, 46, 2, 1, '58.34', 'ACTIVE', '2', '2018-11-23 11:41:05', NULL),
	(67, 46, 2, 1, '58.34', 'ACTIVE', '2', '2018-11-23 11:43:20', NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;

-- Dumping structure for table draftmedia.payments
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `dea_requests_id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `amount_paid` varchar(50) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `invoice_dir` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.payments: ~11 rows (approximately)
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` (`id`, `user_id`, `dea_requests_id`, `orders_id`, `amount_paid`, `payment_method`, `invoice_dir`, `status`, `created_by`, `created_at`, `deleted_at`) VALUES
	(1, 2, 43, 44, '666.65', 'Paypal', '', 'ACTIVE', '2', '2018-11-15 17:06:00', NULL),
	(2, 2, 43, 45, '666.65', 'Paypal', '', 'ACTIVE', '2', '2018-11-15 18:41:53', NULL),
	(3, 2, 43, 46, '1499.99', 'Paypal', '', 'ACTIVE', '2', '2018-11-15 18:42:47', NULL),
	(4, 2, 46, 48, '1667', 'Paypal', '', 'ACTIVE', '2', '2018-11-15 18:46:17', NULL),
	(5, 2, 46, 49, '333.32', 'Paypal', '', 'ACTIVE', '2', '2018-11-15 18:47:33', NULL),
	(6, 2, 44, 50, '333.32', 'Paypal', '', 'ACTIVE', '2', '2018-11-15 18:52:43', NULL),
	(7, 2, 44, 51, '333.32', 'Paypal', '', 'ACTIVE', '2', '2018-11-15 18:53:42', NULL),
	(8, 2, 43, 52, '1499.99', 'Paypal', '', 'ACTIVE', '2', '2018-11-15 18:54:37', NULL),
	(10, 2, 49, 56, '35', 'Paypal', 'C:\\xampp\\htdocs\\DraftMedia\\DraftMedia/public/img/Invoice/files/2/DR49O56PA10U2T1542737797.pdf', 'ACTIVE', '2', '2018-11-20 19:16:36', NULL),
	(11, 2, 50, 57, '35', 'Paypal', 'C:\\xampp\\htdocs\\DraftMedia\\DraftMedia/public/img/Invoice/files/2/DR50O57PA11U2T1542738097.pdf', 'ACTIVE', '2', '2018-11-20 19:21:36', NULL),
	(12, 2, 50, 58, '35', 'Paypal', 'C:\\xampp\\htdocs\\DraftMedia\\DraftMedia/public/img/Invoice/files/2/DR50O58PA12U2T1542738266.pdf', 'ACTIVE', '2', '2018-11-20 19:24:26', NULL),
	(13, 2, 44, 59, '35', 'Paypal', 'C:\\xampp\\htdocs\\DraftMedia\\DraftMedia/public/img/Invoice/files/2/DR44O59PA13U2T1542739085.pdf', 'ACTIVE', '2', '2018-11-20 19:38:04', NULL);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;

-- Dumping structure for table draftmedia.paypal
CREATE TABLE IF NOT EXISTS `paypal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dea_requests_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `api_context` varchar(2000) NOT NULL,
  `date_created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.paypal: ~49 rows (approximately)
/*!40000 ALTER TABLE `paypal` DISABLE KEYS */;
INSERT INTO `paypal` (`id`, `dea_requests_id`, `user_id`, `api_context`, `date_created`) VALUES
	(1, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEj3Wgar6aDXw8PfI37J0JKh527TWjwwY9csrZiCmW1BPluFlhjQWzOthtYPmqx-8jp4kjEEs80XaQ3m3ncIJgohFtweQ";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1541795985;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 12:39:44'),
	(2, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAHX3gGOphzvXvTftcbSf8pmLtNH5rcILN8n0CJAvCxeOTj16sUvqzYb7xvrCfDY08wIYWVSmMrxwynTR7n78gQD-PxVuA";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1541797464;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 13:04:23'),
	(3, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAH9Yd46l7OXL9WSe5nqpQNnRLBOQE1dFVu7O8ATAaKPpmcPW9R_7GFi3DG_TvTBRD-IUFWMTXZadFUPX0IvSM-FR7Zr1g";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1541822140;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 19:55:39'),
	(4, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAH9Yd46l7OXL9WSe5nqpQNnRLBOQE1dFVu7O8ATAaKPpmcPW9R_7GFi3DG_TvTBRD-IUFWMTXZadFUPX0IvSM-FR7Zr1g";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32242;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1541822297;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 19:58:17'),
	(5, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAGQAgpFnUB68E0VTvPJ7YMhZVQICEGK91ga_vwrD2x4w90BYxixh8JOSUDoaMkNU3TVQv-3HdlGIyWAUgJghgll3kuQkw";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1541826018;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:52:57'),
	(6, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAGQAgpFnUB68E0VTvPJ7YMhZVQICEGK91ga_vwrD2x4w90BYxixh8JOSUDoaMkNU3TVQv-3HdlGIyWAUgJghgll3kuQkw";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:31399;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1541827018;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:54:01'),
	(7, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAF9s8ogveY_rFaNkZ0guzLQJLPcV42EhzFJ8TrvWARDY0-c6hNluXbjnYZNHhijY8OikduRcj-N4gCHiq_n5r1xBWA2iw";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542322541;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:54:36'),
	(8, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:56:55'),
	(9, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:58:26'),
	(10, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:58:56'),
	(11, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:59:10'),
	(12, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:59:20'),
	(13, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 20:59:38'),
	(14, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:00:17'),
	(15, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:07:09'),
	(16, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:07:53'),
	(17, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:09:44'),
	(18, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:13:33'),
	(19, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:14:39'),
	(20, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:15:32'),
	(21, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:16:47'),
	(22, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-09 21:16:58'),
	(23, NULL, NULL, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 14:55:40'),
	(24, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEcgqzJiH-SeQ6aLbnxJ8U5nE39KKYKBvvJjanPJpaaJq4SAaAOu3QHJ_sMR0zMLsan108kOevidCyxhxjlmkFc5x6_-A";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542324763;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 15:32:43'),
	(25, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAHuW3sBkEexWSub34CVEf1nxh2oe3ysuOUVHwJRT3oCoTz8LYqXeAMwxHXQDQCRkrSB5KNBPK_WT2Oti6mvg_Oy2FG8Mg";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542327278;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 16:14:37'),
	(26, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAHuW3sBkEexWSub34CVEf1nxh2oe3ysuOUVHwJRT3oCoTz8LYqXeAMwxHXQDQCRkrSB5KNBPK_WT2Oti6mvg_Oy2FG8Mg";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:29798;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542329879;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 16:57:59'),
	(27, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEU3b9Aor7lLUFSkzvyeLYumvzQMSUXBD51zK17dv8ImFPbMukJIltl9633Fr5tKkMluNsMZXdqNBj7PMYiVJPITKM9Jg";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542330099;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 17:01:38'),
	(28, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEU3b9Aor7lLUFSkzvyeLYumvzQMSUXBD51zK17dv8ImFPbMukJIltl9633Fr5tKkMluNsMZXdqNBj7PMYiVJPITKM9Jg";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32245;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542330253;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 17:04:13'),
	(29, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEU3b9Aor7lLUFSkzvyeLYumvzQMSUXBD51zK17dv8ImFPbMukJIltl9633Fr5tKkMluNsMZXdqNBj7PMYiVJPITKM9Jg";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32154;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542330345;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 17:05:44'),
	(30, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEh4BSZrJB-qiPtcLJqOZDtI3g6QnObU7gML3NVQlzpHRzzCR-teQodXW03tCky4hy764Shamq2KhggdUhmUQCjRpJi9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542336084;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 18:41:24'),
	(31, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEh4BSZrJB-qiPtcLJqOZDtI3g6QnObU7gML3NVQlzpHRzzCR-teQodXW03tCky4hy764Shamq2KhggdUhmUQCjRpJi9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32337;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542336147;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 18:42:27'),
	(32, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEh4BSZrJB-qiPtcLJqOZDtI3g6QnObU7gML3NVQlzpHRzzCR-teQodXW03tCky4hy764Shamq2KhggdUhmUQCjRpJi9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32227;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542336257;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 18:44:17'),
	(33, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEh4BSZrJB-qiPtcLJqOZDtI3g6QnObU7gML3NVQlzpHRzzCR-teQodXW03tCky4hy764Shamq2KhggdUhmUQCjRpJi9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32122;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542336363;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 18:46:02'),
	(34, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEh4BSZrJB-qiPtcLJqOZDtI3g6QnObU7gML3NVQlzpHRzzCR-teQodXW03tCky4hy764Shamq2KhggdUhmUQCjRpJi9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32054;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542336430;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 18:47:09'),
	(35, 44, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEh4BSZrJB-qiPtcLJqOZDtI3g6QnObU7gML3NVQlzpHRzzCR-teQodXW03tCky4hy764Shamq2KhggdUhmUQCjRpJi9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:31736;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542336748;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 18:52:28'),
	(36, 44, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEh4BSZrJB-qiPtcLJqOZDtI3g6QnObU7gML3NVQlzpHRzzCR-teQodXW03tCky4hy764Shamq2KhggdUhmUQCjRpJi9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:31676;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542336809;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 18:53:28'),
	(37, 43, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAEh4BSZrJB-qiPtcLJqOZDtI3g6QnObU7gML3NVQlzpHRzzCR-teQodXW03tCky4hy764Shamq2KhggdUhmUQCjRpJi9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:31624;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542336861;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-15 18:54:20'),
	(38, 44, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAENgnYEqvWMadrj_fXECRxfDWJT-hP6IevWf0MJch3esW3TS63yyr_MG874UYIrAx1Z_Q1vQzgDNzF4XiJphWVes5gF9w";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542717012;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-20 04:30:12'),
	(39, 44, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAG3HEM2nUN9VTv-egBHE6W1v0vmQP-ozViEVKqIIrUik9hi9EI2zV5MxT7ks-1PB3rj9eSoRx_kl6XS05cDtfPZhuoCkA";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542769783;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-20 19:09:42'),
	(40, 44, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAG3HEM2nUN9VTv-egBHE6W1v0vmQP-ozViEVKqIIrUik9hi9EI2zV5MxT7ks-1PB3rj9eSoRx_kl6XS05cDtfPZhuoCkA";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32363;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542769820;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-20 19:10:20'),
	(41, 49, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAG3HEM2nUN9VTv-egBHE6W1v0vmQP-ozViEVKqIIrUik9hi9EI2zV5MxT7ks-1PB3rj9eSoRx_kl6XS05cDtfPZhuoCkA";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32286;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542769897;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-20 19:11:37'),
	(42, 50, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAG3HEM2nUN9VTv-egBHE6W1v0vmQP-ozViEVKqIIrUik9hi9EI2zV5MxT7ks-1PB3rj9eSoRx_kl6XS05cDtfPZhuoCkA";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:31702;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542770482;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-20 19:21:21'),
	(43, 50, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAG3HEM2nUN9VTv-egBHE6W1v0vmQP-ozViEVKqIIrUik9hi9EI2zV5MxT7ks-1PB3rj9eSoRx_kl6XS05cDtfPZhuoCkA";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:31542;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542770641;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-20 19:24:00'),
	(44, 44, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ae_qRuHFshYiXgxDvInABUEQoJqVtGv8xC6ektW-CERqjXT5r6zpMWln5xEcv2KlGOiunVoHm2ZZ6KuD";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAG3HEM2nUN9VTv-egBHE6W1v0vmQP-ozViEVKqIIrUik9hi9EI2zV5MxT7ks-1PB3rj9eSoRx_kl6XS05cDtfPZhuoCkA";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:30804;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542771379;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELzY3t16kIBZYOK1fo-7iYFE89fmx7l0f5ytQr4-B-IO1qzMU8pSU3YUcOGhuMu0h7xh8wmuna-xSfSk";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-20 19:36:13'),
	(45, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ad5Aggjy8iNvrKyVnrD3SYkWEaDkT8KPGqroCqpetlWhYYkB6cQgz4sVmFxFjX3BLokXv6DnHjUf8oEl";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELaXNq2-viWYlCcJ1LXrqgNLWAiCB0wIT0K7WzQ3rtLN5ja595j-gxlF3f1cSUMKjjKkisyQZ3guBKVR";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAHzbkZagXMuyLUZ7KG81n23Xk1UCgGjG-7jhHJkfYrG1EiaL5Co3Nohj3IQgYaxj0fT5YRytKG6-C9J2lcNKHebCQ190Q";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1542999234;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELaXNq2-viWYlCcJ1LXrqgNLWAiCB0wIT0K7WzQ3rtLN5ja595j-gxlF3f1cSUMKjjKkisyQZ3guBKVR";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-23 10:53:53'),
	(46, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"AQZHSXHuIZj3Kla5Jce4Mt6jA757L-p5buysvW6DADgn561MIOiyQuurZ800kIliqnC7AX5eq00a7Bbe";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-23 10:57:05'),
	(47, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"AQZHSXHuIZj3Kla5Jce4Mt6jA757L-p5buysvW6DADgn561MIOiyQuurZ800kIliqnC7AX5eq00a7Bbe";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-23 10:59:28'),
	(48, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"AQZHSXHuIZj3Kla5Jce4Mt6jA757L-p5buysvW6DADgn561MIOiyQuurZ800kIliqnC7AX5eq00a7Bbe";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-23 11:22:55'),
	(49, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"AQZHSXHuIZj3Kla5Jce4Mt6jA757L-p5buysvW6DADgn561MIOiyQuurZ800kIliqnC7AX5eq00a7Bbe";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-23 11:23:08'),
	(50, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"AQZHSXHuIZj3Kla5Jce4Mt6jA757L-p5buysvW6DADgn561MIOiyQuurZ800kIliqnC7AX5eq00a7Bbe";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAFA84HblS7Y6iPLLUyoZmpV3GdrRxOpENpNFFAVmtc3m2uGfY7EWGi3fU_Ff0JefUTEV6OKNXJslRF1rJMjvmL0PDbm1A";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1543001999;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"EJ1SZYZUZsu3ZCobwHWZiRzYzH88CoUD0d2KRSZDui6z12Qd2WvcWuMq5te_VLmvYZtcOgyPGtL9PoeI";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-23 11:39:59'),
	(51, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ad5Aggjy8iNvrKyVnrD3SYkWEaDkT8KPGqroCqpetlWhYYkB6cQgz4sVmFxFjX3BLokXv6DnHjUf8oEl";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELaXNq2-viWYlCcJ1LXrqgNLWAiCB0wIT0K7WzQ3rtLN5ja595j-gxlF3f1cSUMKjjKkisyQZ3guBKVR";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";N;s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";N;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";N;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELaXNq2-viWYlCcJ1LXrqgNLWAiCB0wIT0K7WzQ3rtLN5ja595j-gxlF3f1cSUMKjjKkisyQZ3guBKVR";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-23 11:41:05'),
	(52, 46, 2, 'O:22:"PayPal\\Rest\\ApiContext":2:{s:33:"\0PayPal\\Rest\\ApiContext\0requestId";N;s:34:"\0PayPal\\Rest\\ApiContext\0credential";O:32:"PayPal\\Auth\\OAuthTokenCredential":7:{s:42:"\0PayPal\\Auth\\OAuthTokenCredential\0clientId";s:80:"Ad5Aggjy8iNvrKyVnrD3SYkWEaDkT8KPGqroCqpetlWhYYkB6cQgz4sVmFxFjX3BLokXv6DnHjUf8oEl";s:46:"\0PayPal\\Auth\\OAuthTokenCredential\0clientSecret";s:80:"ELaXNq2-viWYlCcJ1LXrqgNLWAiCB0wIT0K7WzQ3rtLN5ja595j-gxlF3f1cSUMKjjKkisyQZ3guBKVR";s:45:"\0PayPal\\Auth\\OAuthTokenCredential\0accessToken";s:97:"A21AAE3vsgUp72XXQ28ex2AqBkTy1FTiU43lLSoCjERKRFnA05G248vAj-QQ_unYwr7ffwUV8Km4wqtXprGGdQ17TNi1C89Kg";s:48:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenExpiresIn";i:32400;s:49:"\0PayPal\\Auth\\OAuthTokenCredential\0tokenCreateTime";i:1543002201;s:40:"\0PayPal\\Auth\\OAuthTokenCredential\0cipher";O:22:"PayPal\\Security\\Cipher":1:{s:33:"\0PayPal\\Security\\Cipher\0secretKey";s:80:"ELaXNq2-viWYlCcJ1LXrqgNLWAiCB0wIT0K7WzQ3rtLN5ja595j-gxlF3f1cSUMKjjKkisyQZ3guBKVR";}s:35:"\0PayPal\\Common\\PayPalModel\0_propMap";a:0:{}}}', '2018-11-23 11:43:20');
/*!40000 ALTER TABLE `paypal` ENABLE KEYS */;

-- Dumping structure for table draftmedia.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `opening_price` varchar(50) NOT NULL,
  `monthly_fee` varchar(50) NOT NULL,
  `annual_cost_of_renovation` varchar(50) NOT NULL,
  `description` varchar(510) NOT NULL,
  `department` varchar(255) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.products: ~9 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `opening_price`, `monthly_fee`, `annual_cost_of_renovation`, `description`, `department`, `image_path`, `status`, `created_by`, `modified_by`, `created_at`, `modified_at`, `deleted_at`) VALUES
	(1, 'Diseno Web: Paquete Personal', '0', '58.34', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-09 01:18:55', NULL, NULL),
	(2, 'Diseno Web: Paquete Emprendedor', '0', '166.67', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-09 01:21:01', NULL, NULL),
	(3, 'Diseno Web: Paquete Empresarial', '0', '241.67', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-09 01:23:35', NULL, NULL),
	(4, 'Diseno Web: Paquete Personal (-20%)', '0', '46.67', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-15 22:50:53', NULL, NULL),
	(5, 'Diseno Web: Paquete Emprendedor (-20%)', '0', '133.33', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-15 22:53:14', NULL, NULL),
	(6, 'Diseno Web: Paquete Empresarial (-20%)', '0', '193.33', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-15 22:54:11', NULL, NULL),
	(7, 'Diseno Web: Paquete Personal (-40%)', '0', '35', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-15 22:55:51', NULL, NULL),
	(8, 'Diseno Web: Paquete Emprendedor (-40%)', '0', '100', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-15 22:57:05', NULL, NULL),
	(9, 'Diseno Web: Paquete Empresarial (-40%)', '0', '145', '0', 'Diseno, programacion y mantenimiento de sitio web', 'Diseno Web', NULL, 'ACTIVE', '', NULL, '2018-11-15 22:57:59', NULL, NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

-- Dumping structure for table draftmedia.session_keys
CREATE TABLE IF NOT EXISTS `session_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `session_key` varchar(255) NOT NULL,
  `browser` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `expiration_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `session_key` (`session_key`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.session_keys: ~5 rows (approximately)
/*!40000 ALTER TABLE `session_keys` DISABLE KEYS */;
INSERT INTO `session_keys` (`id`, `user_id`, `session_key`, `browser`, `ip`, `expiration_at`) VALUES
	(2, 2, '/rqPmtiMrfxYajYW/6EAUHIXiOl7O44Jfp34qKQ4GTqq+hAr2Wg8K+JnsX+PRVed3fn40jXyTeGuCK0fhzUz6Q==', 'Chrome', '::1', '2018-11-30 01:15:40'),
	(3, 2, 'pDmLg4fyarhz4SXN7b6pR/4+93C4c251a7jnT4GsSwBaAT3JcT5gI7USrprG7P2ogndas86Lw4t+QHtvIEVszA==', 'Firefox', '', NULL),
	(4, 4, 'k578VTsD4B9pQR+Gref9Qg/eyy5F5po7VvWjmh7r75dWRURL9ihNLlFGDBdEs6gaAna0BlhiMTlgokkwmD5BvA==', 'Firefox', '', NULL),
	(5, 2, 'YUglsv8I2XaFVg8fC4eiwgggKIu+Fe9NX+Kq1AUgUCRYIuQoWsP20U/cgL1SIqueoSUbCYxO4H1N8zkzXP5LYw==', 'Chrome Mobile', '', NULL),
	(13, 8, 'CwMt7aHjE0q+ky/IF//5vL+ZksPY5aplkrpKRB6IowxY28NgHTJTiBCqHBbzk1NBQV8XZducpqkvnqP/jT5w7Q==', 'Chrome', '::1', '2018-11-28 23:38:01');
/*!40000 ALTER TABLE `session_keys` ENABLE KEYS */;

-- Dumping structure for table draftmedia.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privacy_politics` tinyint(4) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `modified_by` varchar(255) DEFAULT NULL,
  `last_activity_at` timestamp NULL DEFAULT NULL,
  `connected_at` timestamp NULL DEFAULT NULL,
  `disconnected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table draftmedia.users: ~7 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `role`, `password`, `privacy_politics`, `activation_code`, `status`, `created_by`, `modified_by`, `last_activity_at`, `connected_at`, `disconnected_at`, `created_at`, `modified_at`, `deleted_at`) VALUES
	(1, 'correo@correo.com', 'Cesar', 'Miranda Meza', 'user', 'TFBAo78aMt1UwSPbSJSXCwdfyMuV2G67xNgXrzVgb56aHv0P1tSe5axrSqmSlADWJnNX9XALBTd0gfkol4Ih4w==', 1, '89728$0134!1$F!661212$!1540076786', 'DELETED', 'DraftMedia Web API', NULL, '2018-10-26 20:10:49', '2018-10-26 20:10:49', NULL, '2018-10-21 01:06:45', NULL, NULL),
	(2, 'correo@correo.com', 'Cesar', 'Miranda Meza', 'admin', 'QGtlGM8wd65vLNVGlpCUgD8Ldq7tVnbcdBR5ljVl8Wiw+Rfsxgk23KRrvxGu0K/rZysPSxraQyNsQjBh9spFDA==', 1, '40453$1594!9$F!392617$!1540213411', 'ACTIVE', 'DraftMedia Web API', '2', '2018-11-30 00:58:59', '2018-11-29 17:05:15', '2018-11-29 17:04:59', '2018-10-22 15:07:05', '2018-11-25 16:35:17', NULL),
	(3, 'test@correo.com', 'Test', 'Testeando', 'user', 'HRCfo926ePMLC+I3x3buxI2DTJVY8puS9eV+qAhmYP1/cORrDN3G1VoR9LXS8gm9V4s9GwQj7yt+ew6CFxLQ+A==', 1, '75759$0885!10$F!465660$!1540579069', 'DELETED', 'DraftMedia Web API', NULL, NULL, NULL, NULL, '2018-10-26 21:17:22', NULL, NULL),
	(4, 'test@correo.com', 'Test', 'Testeando', 'user', 'Qasz4P95/tCC4zClc+FspKazh/e+SJwnpDyKaKvWHzLdr1bvgx9BSo8A7qlWdtPzfBDv6bV3xMjamvKxN8wuLg==', 1, '06893$5655!11$F!049810$!1540581502', 'ACTIVE', 'DraftMedia Web API', NULL, '2018-11-29 18:50:00', '2018-11-23 23:41:59', '2018-11-23 23:42:44', '2018-10-26 21:18:56', NULL, NULL),
	(5, 'tenten@correo.com', 'Tenc', 'Tenten', 'user', 'memJDKvke4w2nAihpsbWQljx+t/vrZerDKDo/eko0DcxZGLIFoiIpA7DSKNqbD9ic9OHjga2ZkKjV6gIT2RC5g==', 1, '17120$2551!13$F!602490$!1540632250', 'ACTIVE', 'DraftMedia Web API', NULL, '2018-11-29 18:49:00', '2018-10-27 11:25:35', NULL, '2018-10-27 11:24:56', NULL, NULL),
	(6, 'haha@correo.com', 'Haha', 'Hihi', 'user', 'uVRpGORek0rkTgEr2ECWn6MYDs8UYuL13rqddJL5xGceLyFJzl4QVGpzbPrzRKX4XH04ES9l23BOz6UZok7MHg==', 1, '13270$3586!14$F!108023$!1540638240', 'ACTIVE', 'DraftMedia Web API', NULL, '2018-11-16 15:49:28', '2018-11-16 15:49:28', '2018-11-16 15:49:50', '2018-10-27 13:04:19', NULL, NULL),
	(7, 'correoOscarLopez@correo.com', 'Oscar', 'Lopez', 'user', 'DdSvMh1xhjkSDZRMnqkyzvtLYxt0KZd9jGUidLxjwpYL5MIWZ0R1b8dLBOxH4f9w5O92I+q2SwOfMROD79KtBw==', 1, '88341$3812!16$F!231576$!1541696240', 'ACTIVE', 'DraftMedia Web API', NULL, NULL, NULL, NULL, '2018-11-08 17:57:32', NULL, NULL),
	(8, 'TestOmar@correo.com', 'Testomar', 'Avilatest', 'admin', 'er186LD1wuI6+3PA8ogqU409BYBgXPzp/YuxNaFKUFVcZVnBKWtmXbAweGhWEeHMd+ogASCOqhKI5bVa4nUwXA==', 1, '34175$4436!24$F!688525$!1543158489', 'ACTIVE', 'DraftMedia Web API', NULL, '2018-11-28 22:38:38', '2018-11-28 22:38:01', '2018-11-28 22:38:38', '2018-11-25 16:10:06', NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
