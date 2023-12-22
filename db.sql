/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.5.5-10.4.28-MariaDB : Database - db_len
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_len` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `db_len`;

/*Table structure for table `tbl_album` */

DROP TABLE IF EXISTS `tbl_album`;

CREATE TABLE `tbl_album` (
  `id` varchar(50) NOT NULL,
  `album` varchar(250) DEFAULT NULL,
  `from_csv` tinyint(4) DEFAULT 0,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_album` */

insert  into `tbl_album`(`id`,`album`,`from_csv`,`entry_by`,`entry_at`) values ('17030493-6421-5982-b579-338930a2415f','New Album',0,'1','0000-00-00 00:00:00');

/*Table structure for table `tbl_artist` */

DROP TABLE IF EXISTS `tbl_artist`;

CREATE TABLE `tbl_artist` (
  `id` varchar(50) NOT NULL,
  `artist` varchar(250) DEFAULT NULL,
  `from_csv` tinyint(4) DEFAULT 0,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_artist` */

insert  into `tbl_artist`(`id`,`artist`,`from_csv`,`entry_by`,`entry_at`) values ('17030493-6423-2973-983d-376fc38547f5','Artist',0,'1','0000-00-00 00:00:00');

/*Table structure for table `tbl_audit_logs` */

DROP TABLE IF EXISTS `tbl_audit_logs`;

CREATE TABLE `tbl_audit_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `record_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `operation` varchar(50) DEFAULT NULL,
  `from` varchar(10) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `custom_text` longtext DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `ip_address` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17032336 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_audit_logs` */

insert  into `tbl_audit_logs`(`id`,`record_id`,`user_id`,`action`,`operation`,`from`,`status`,`date_added`,`date_modified`,`custom_text`,`is_deleted`,`ip_address`) values (17030493,0,1,'Add','add_songs','panel',0,'2023-12-20 05:15:18','2023-12-20 05:15:18','',1,'::1'),(17030494,0,1,'Add','add_songs','panel',1,'2023-12-20 05:17:58','2023-12-20 05:17:58','',1,'::1'),(17030496,0,1,'Add','add_songs','panel',1,'2023-12-20 05:21:08','2023-12-20 05:21:08','',1,'::1'),(17030497,0,1,'Add','add_songs','panel',1,'2023-12-20 05:22:19','2023-12-20 05:22:19','',1,'::1'),(17030498,0,1,'Add','add_songs','panel',1,'2023-12-20 05:24:40','2023-12-20 05:24:40','',1,'::1'),(17030566,0,1,'Add','add_song_like','panel',1,'2023-12-20 12:46:47','2023-12-20 12:46:47','',1,'::1'),(17030577,0,1,'Add','add_comment','panel',1,'2023-12-20 13:06:32','2023-12-20 13:06:32','',1,'::1'),(17030592,0,1,'Add','add_to_playlist','panel',1,'2023-12-20 13:30:59','2023-12-20 13:30:59','',1,'::1'),(17030593,0,1,'Add','add_to_playlist','panel',1,'2023-12-20 13:31:48','2023-12-20 13:31:48','',1,'::1'),(17030594,0,1,'Add','add_to_playlist','panel',1,'2023-12-20 13:33:24','2023-12-20 13:33:24','',1,'::1'),(17030596,0,1,'Update','update_playlist_name','panel',1,'2023-12-20 13:38:09','2023-12-20 13:38:09','',1,'::1'),(17030597,0,1,'Update','update_playlist_name','panel',1,'2023-12-20 13:38:25','2023-12-20 13:38:25','',1,'::1'),(17030709,0,1,'Update','update_profile','panel',1,'2023-12-20 16:45:40','2023-12-20 16:45:40','',1,'::1'),(17030721,0,0,'Add','add_review','panel',1,'2023-12-20 17:05:46','2023-12-20 17:05:46','',1,'::1'),(17030725,0,2,'Add','add_review','panel',1,'2023-12-20 17:11:51','2023-12-20 17:11:51','',1,'::1'),(17030731,0,2,'Add','add_review','panel',1,'2023-12-20 17:22:05','2023-12-20 17:22:05','',1,'::1'),(17032326,0,NULL,'Login','login_user','panel',1,'2023-12-22 13:40:38','2023-12-22 13:40:38','',NULL,'::1'),(17032328,0,NULL,'Login','login_user','panel',1,'2023-12-22 13:43:38','2023-12-22 13:43:38','',NULL,'::1'),(17032330,0,NULL,'Login','login_user','panel',1,'2023-12-22 13:47:00','2023-12-22 13:47:00','',NULL,'::1'),(17032335,0,NULL,'Login','login_user','panel',1,'2023-12-22 13:55:06','2023-12-22 13:55:06','',NULL,'::1');

/*Table structure for table `tbl_comment_song` */

DROP TABLE IF EXISTS `tbl_comment_song`;

CREATE TABLE `tbl_comment_song` (
  `id` varchar(50) NOT NULL,
  `song_id` varchar(50) DEFAULT NULL,
  `comment` longtext DEFAULT NULL,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_comment_song` */

insert  into `tbl_comment_song`(`id`,`song_id`,`comment`,`entry_by`,`entry_at`) values ('17030577-9202-1037-d5e8-c0b7e76d4449','17030498-8055-1368-37e8-c93422df4151','Test','1','2023-12-20 13:06:32');

/*Table structure for table `tbl_genre` */

DROP TABLE IF EXISTS `tbl_genre`;

CREATE TABLE `tbl_genre` (
  `id` varchar(50) NOT NULL,
  `genre` varchar(250) DEFAULT NULL,
  `from_csv` tinyint(4) DEFAULT 0,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_genre` */

insert  into `tbl_genre`(`id`,`genre`,`from_csv`,`entry_by`,`entry_at`) values ('17030493-6422-5138-adee-b1685cc74009','New Genre',0,'1','0000-00-00 00:00:00');

/*Table structure for table `tbl_like_song` */

DROP TABLE IF EXISTS `tbl_like_song`;

CREATE TABLE `tbl_like_song` (
  `id` varchar(50) NOT NULL,
  `song_id` varchar(50) DEFAULT NULL,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_like_song` */

/*Table structure for table `tbl_playlist` */

DROP TABLE IF EXISTS `tbl_playlist`;

CREATE TABLE `tbl_playlist` (
  `id` varchar(50) NOT NULL,
  `playlist` varchar(150) DEFAULT NULL,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  `update_by` varchar(50) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_playlist` */

insert  into `tbl_playlist`(`id`,`playlist`,`entry_by`,`entry_at`,`update_by`,`update_at`) values ('17030593-8786-2473-d46f-019662e546c2','New List','1','2023-12-20 13:33:07','1','2023-12-20 13:38:25');

/*Table structure for table `tbl_playlist_details` */

DROP TABLE IF EXISTS `tbl_playlist_details`;

CREATE TABLE `tbl_playlist_details` (
  `id` varchar(50) NOT NULL,
  `playlist_id` varchar(50) DEFAULT NULL,
  `song_id` varchar(50) DEFAULT NULL,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_playlist_details` */

insert  into `tbl_playlist_details`(`id`,`playlist_id`,`song_id`,`entry_by`,`entry_at`) values ('17030593-8787-0320-455c-3ce8bce1410c','17030593-8786-2473-d46f-019662e546c2','17030498-8055-1368-37e8-c93422df4151','1','2023-12-20 13:33:07');

/*Table structure for table `tbl_review` */

DROP TABLE IF EXISTS `tbl_review`;

CREATE TABLE `tbl_review` (
  `id` varchar(50) DEFAULT NULL,
  `song_id` varchar(50) DEFAULT NULL,
  `overall_ratting` int(11) DEFAULT 0,
  `bass_complexity` int(11) DEFAULT 0,
  `drum_complexity` int(11) DEFAULT 0,
  `bass_tone` int(11) DEFAULT 0,
  `drum_sound` int(11) DEFAULT 0,
  `is_slap` tinyint(4) DEFAULT 0,
  `bass_solo` tinyint(4) DEFAULT 0,
  `drum_solo` tinyint(4) DEFAULT 0,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  `update_by` varchar(50) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_review` */

insert  into `tbl_review`(`id`,`song_id`,`overall_ratting`,`bass_complexity`,`drum_complexity`,`bass_tone`,`drum_sound`,`is_slap`,`bass_solo`,`drum_solo`,`entry_by`,`entry_at`,`update_by`,`update_at`) values ('17030725-1151-2267-1efe-8824847a45ea','17030498-8055-1368-37e8-c93422df4151',4,4,4,4,4,1,0,0,'2','2023-12-20 17:11:51','2','2023-12-20 17:22:05'),('17030725-5828-2118-1c53-3ef7e437429c','17030498-8055-1368-37e8-c93422df4151',4,4,4,4,4,1,0,0,'1','2023-12-20 17:12:38',NULL,NULL);

/*Table structure for table `tbl_roles` */

DROP TABLE IF EXISTS `tbl_roles`;

CREATE TABLE `tbl_roles` (
  `id` varchar(50) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_roles` */

insert  into `tbl_roles`(`id`,`role`) values ('17032247-7146-0982-b242-91f27655411c','Admin'),('17032249-8048-6243-9ae7-5df91521499a','User');

/*Table structure for table `tbl_search_history` */

DROP TABLE IF EXISTS `tbl_search_history`;

CREATE TABLE `tbl_search_history` (
  `id` varchar(50) NOT NULL,
  `search_type` varchar(50) DEFAULT NULL,
  `search` varchar(250) DEFAULT NULL,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_search_history` */

insert  into `tbl_search_history`(`id`,`search_type`,`search`,`entry_by`,`entry_at`) values ('17030532-7473-3021-2149-a28b5bf84bc7','artist','Artist','1','0000-00-00 00:00:00'),('17030532-9119-6299-8896-0b10b5074eab','artist','Artist','1','0000-00-00 00:00:00'),('17030533-0343-9949-f2eb-789240ad4576','artist','Artist next','1','0000-00-00 00:00:00'),('17030533-1861-1176-0971-509bd04e43a2','artist','Artist','1','0000-00-00 00:00:00'),('17030533-7878-1553-d356-682f6ab5405b','artist','Artist','1','2023-12-20 06:22:58'),('17030534-5209-9762-ac56-f31c1ab74080','artist','Artist','1','2023-12-20 11:54:12'),('17030570-0206-0272-0280-4836e82344b8','artist','Artist','1','2023-12-20 12:53:22'),('17030570-1545-8482-7e4e-f3ac54504f29','artist','Artist','1','2023-12-20 12:53:35'),('17030570-1832-2894-229d-3bf2438d41b5','artist','Artist','1','2023-12-20 12:53:38'),('17030570-7355-5107-300f-e3fae4644e04','artist','Artist','1','2023-12-20 12:54:33'),('17030570-7843-8455-5745-d09710e44edd','artist','Artist','1','2023-12-20 12:54:38'),('17030583-5297-2846-7c9a-5317dd7844ac','artist','Artist','1','2023-12-20 13:15:52'),('17030584-9762-8900-e955-98a53da6463e','artist','Artist','1','2023-12-20 13:18:17'),('17030585-5449-6303-9ae2-c761b66742b3','artist','Artist','1','2023-12-20 13:19:14'),('17030585-9393-2298-a2c9-577b40704eb2','artist','Artist','1','2023-12-20 13:19:53'),('17030734-2625-5959-6046-3f0fb99c416c','artist','Artist','1','2023-12-20 17:27:06'),('17030734-4509-6319-d17d-d5920bc74b48','artist','Artist','1','2023-12-20 17:27:25'),('17030734-7437-4130-ce93-dc93cd7241b8','artist','Artist','1','2023-12-20 17:27:54'),('17032338-6493-7553-2536-ad9325434bde','artist','Artist',NULL,'2023-12-22 14:01:04'),('17032338-8938-6725-b4e9-481a26bd47a9','artist','Artist',NULL,'2023-12-22 14:01:29'),('17032339-1029-4403-033d-bc80f5204df4','artist','Artist','17032330-2049-6627-f9ce-3bbfb79c4c1b','2023-12-22 14:01:50'),('17032339-9695-5259-f0b9-0f7387b842a8','artist','Artist','17032330-2049-6627-f9ce-3bbfb79c4c1b','2023-12-22 14:03:16'),('17032340-5256-2271-1fa3-401416724016','artist','Artist','17032330-2049-6627-f9ce-3bbfb79c4c1b','2023-12-22 14:04:12');

/*Table structure for table `tbl_search_keyword` */

DROP TABLE IF EXISTS `tbl_search_keyword`;

CREATE TABLE `tbl_search_keyword` (
  `id` varchar(50) NOT NULL,
  `search_type` varchar(50) DEFAULT NULL,
  `search` varchar(250) DEFAULT NULL,
  `cnt` int(11) DEFAULT 1,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_search_keyword` */

insert  into `tbl_search_keyword`(`id`,`search_type`,`search`,`cnt`,`entry_by`,`entry_at`) values ('17030532-7473-9929-5013-a501937d4ba5','artist','Artist',22,'1','0000-00-00 00:00:00'),('17030533-0344-3540-9fa6-26d241c844bc','artist','Artist next',1,'1','0000-00-00 00:00:00');

/*Table structure for table `tbl_song_type` */

DROP TABLE IF EXISTS `tbl_song_type`;

CREATE TABLE `tbl_song_type` (
  `id` varchar(50) NOT NULL,
  `song_type` varchar(250) DEFAULT NULL,
  `from_csv` tinyint(4) DEFAULT 0,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_song_type` */

insert  into `tbl_song_type`(`id`,`song_type`,`from_csv`,`entry_by`,`entry_at`) values ('17030493-6422-1542-f09c-6f56e32f4c3a','Type',0,'1','0000-00-00 00:00:00');

/*Table structure for table `tbl_songs` */

DROP TABLE IF EXISTS `tbl_songs`;

CREATE TABLE `tbl_songs` (
  `id` varchar(50) NOT NULL,
  `bass_player` longtext DEFAULT NULL,
  `title` varchar(500) DEFAULT NULL,
  `artist_id` varchar(50) DEFAULT NULL,
  `artist` varchar(250) DEFAULT NULL,
  `album_id` varchar(50) DEFAULT NULL,
  `album` varchar(250) DEFAULT NULL,
  `apple_link` longtext DEFAULT NULL,
  `spotify_link` longtext DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `drummer` varchar(250) DEFAULT NULL,
  `instruments` varchar(500) DEFAULT NULL,
  `overall_ratting` int(11) DEFAULT 0,
  `bass_complexity` int(11) DEFAULT 0,
  `drum_complexity` int(11) DEFAULT 0,
  `bass_tone` int(11) DEFAULT 0,
  `drum_sound` int(11) DEFAULT 0,
  `is_slap` tinyint(4) DEFAULT 0,
  `bass_solo` tinyint(4) DEFAULT 0,
  `drum_solo` tinyint(4) DEFAULT 0,
  `type_id` varchar(50) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `genre_id` varchar(50) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `referance` longtext DEFAULT NULL,
  `from_csv` tinyint(4) DEFAULT 0,
  `comment_cnt` int(11) DEFAULT NULL,
  `like_cnt` int(11) DEFAULT NULL,
  `avg_ratting` varchar(10) DEFAULT NULL,
  `entry_by` varchar(50) DEFAULT NULL,
  `entry_at` datetime DEFAULT NULL,
  `update_by` varchar(50) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_songs` */

insert  into `tbl_songs`(`id`,`bass_player`,`title`,`artist_id`,`artist`,`album_id`,`album`,`apple_link`,`spotify_link`,`year`,`drummer`,`instruments`,`overall_ratting`,`bass_complexity`,`drum_complexity`,`bass_tone`,`drum_sound`,`is_slap`,`bass_solo`,`drum_solo`,`type_id`,`type`,`genre_id`,`genre`,`referance`,`from_csv`,`comment_cnt`,`like_cnt`,`avg_ratting`,`entry_by`,`entry_at`,`update_by`,`update_at`) values ('17030498-8055-1368-37e8-c93422df4151','player','New Songs','17030493-6423-2973-983d-376fc38547f5','Artist','17030493-6421-5982-b579-338930a2415f','New Album','www.apple.com','www.spotify.com',2023,'Drummer','Drum',4,4,4,4,4,1,0,0,'17030493-6422-1542-f09c-6f56e32f4c3a','Type','17030493-6422-5138-adee-b1685cc74009','New Genre','None',0,1,0,NULL,'1','0000-00-00 00:00:00',NULL,NULL);

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `id` varchar(50) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email_verified` tinyint(4) DEFAULT 0,
  `local_id` varchar(50) DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `provider_info` longtext DEFAULT NULL,
  `fcm_token` longtext DEFAULT NULL,
  `role_id` varchar(50) DEFAULT NULL,
  `last_logged_in` datetime DEFAULT NULL,
  `last_login_offset` varchar(50) DEFAULT NULL,
  `insert_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`id`,`fname`,`lname`,`name`,`email`,`username`,`password`,`email_verified`,`local_id`,`provider`,`provider_info`,`fcm_token`,`role_id`,`last_logged_in`,`last_login_offset`,`insert_at`) values ('1',NULL,NULL,'Admin','admin@fk.com','admin','admin',0,NULL,NULL,NULL,NULL,'17032247-7146-0982-b242-91f27655411c','2023-11-28 07:34:57','330','2023-02-01 11:49:50'),('17032330-2049-6627-f9ce-3bbfb79c4c1b','Pansuriya','Chirag','Pansuriya Chirag','chiragpansuriya210@gmail.','chiragpansuriya210@gmail.com',NULL,1,'jWum6WZU23aYhSttBLuiQn8QzTt2','google.com','{\"providerId\":\"google.com\",\"displayName\":\"Pansuriya Chirag\",\"photoUrl\":\"https:\\/\\/lh3.googleusercontent.com\\/a\\/ACg8ocIKrUT_KvRobrjPRM_HD_YRUIxNhNlGd9o70CXtRCv8=s96-c\",\"federatedId\":\"113062039936122195954\",\"email\":\"chiragpansuriya210@gmail.com\",\"rawId\":\"113062039936122195954\"}',NULL,'17032249-8048-6243-9ae7-5df91521499a',NULL,NULL,'2023-12-22 13:47:00');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
