-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: gnuboard5
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `g5_auth`
--

DROP TABLE IF EXISTS `g5_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_auth` (
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `au_menu` varchar(50) NOT NULL DEFAULT '',
  `au_auth` set('r','w','d') NOT NULL DEFAULT '',
  PRIMARY KEY (`mb_id`,`au_menu`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_auth`
--

LOCK TABLES `g5_auth` WRITE;
/*!40000 ALTER TABLE `g5_auth` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_autosave`
--

DROP TABLE IF EXISTS `g5_autosave`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_autosave` (
  `as_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL,
  `as_uid` bigint(20) unsigned NOT NULL,
  `as_subject` varchar(255) NOT NULL,
  `as_content` text NOT NULL,
  `as_datetime` datetime NOT NULL,
  PRIMARY KEY (`as_id`),
  UNIQUE KEY `as_uid` (`as_uid`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_autosave`
--

LOCK TABLES `g5_autosave` WRITE;
/*!40000 ALTER TABLE `g5_autosave` DISABLE KEYS */;
INSERT INTO `g5_autosave` VALUES (2,'admin',2025122812592236,'CS1001','<div style=\"text-align: center;\" align=\"center\"><img src=\"http://localhost/data/editor/2512/1303131140168_1.jpg\" title=\"1303131140168_1.jpg\"></div><div style=\"text-align: center;\" align=\"center\"><img src=\"http://localhost/data/editor/2512/1303270339072_1.jpg\" title=\"1303270339072_1.jpg\"></div><div style=\"text-align: center;\">&nbsp;</div>','2025-12-28 13:00:22'),(3,'admin',2025122815182877,'sfsfs111','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%281%29.jpg\" title=\"1303131140168_1 (1).jpg\"><br style=\"clear:both;\"><img src=\"http://localhost/data/editor/2512/1303270339072_1%20%281%29.jpg\" title=\"1303270339072_1 (1).jpg\"><br style=\"clear:both;\">&nbsp;</p>','2025-12-28 15:19:29'),(5,'admin',2026011312591236,'ㄴㄹㄶㄹㄴ','<p>ㅎㄶㄶ</p>','2026-01-13 13:00:13'),(6,'admin',2026011313370852,'ㅁㄻㄹㅇㅁ','<p>ㅁㄻㄻㄹ</p>','2026-01-13 13:38:08'),(7,'admin',2026011315481906,'서울서울','<p><br></p>','2026-01-13 15:49:19'),(8,'admin',2026011408581133,'ㅇㄴㄹ','<p>ㅁㄻㄹ</p>','2026-01-14 08:59:12'),(9,'admin',2026011409213738,'불광역 근처에서 폐건전지를 버리기 가장 확실하고','<p data-path-to-node=\"0\">불광역 근처에서 폐건전지를 버리기 가장 확실하고 좋은 곳은 **\'불광1동 주민센터\'**입니다.</p><p data-path-to-node=\"1\">가장 추천드리는 이유는 단순히 버리는 것을 넘어, 폐건전지를 모아가면 <b data-path-to-node=\"1\" data-index-in-node=\"39\">새 건전지로 교환</b>해주기 때문입니다.</p>','2026-01-14 09:22:38');
/*!40000 ALTER TABLE `g5_autosave` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board`
--

DROP TABLE IF EXISTS `g5_board`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_board` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `bo_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_subject` varchar(255) NOT NULL DEFAULT '',
  `bo_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `bo_admin` varchar(255) NOT NULL DEFAULT '',
  `bo_list_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_read_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_write_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_reply_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_comment_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_upload_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_download_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_html_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_link_level` tinyint(4) NOT NULL DEFAULT 0,
  `bo_count_delete` tinyint(4) NOT NULL DEFAULT 0,
  `bo_count_modify` tinyint(4) NOT NULL DEFAULT 0,
  `bo_read_point` int(11) NOT NULL DEFAULT 0,
  `bo_write_point` int(11) NOT NULL DEFAULT 0,
  `bo_comment_point` int(11) NOT NULL DEFAULT 0,
  `bo_download_point` int(11) NOT NULL DEFAULT 0,
  `bo_use_category` tinyint(4) NOT NULL DEFAULT 0,
  `bo_category_list` text NOT NULL,
  `bo_use_sideview` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_file_content` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_secret` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_dhtml_editor` tinyint(4) NOT NULL DEFAULT 0,
  `bo_select_editor` varchar(50) NOT NULL DEFAULT '',
  `bo_use_rss_view` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_good` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_nogood` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_name` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_signature` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_ip_view` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_list_view` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_list_file` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_list_content` tinyint(4) NOT NULL DEFAULT 0,
  `bo_table_width` int(11) NOT NULL DEFAULT 0,
  `bo_subject_len` int(11) NOT NULL DEFAULT 0,
  `bo_mobile_subject_len` int(11) NOT NULL DEFAULT 0,
  `bo_page_rows` int(11) NOT NULL DEFAULT 0,
  `bo_mobile_page_rows` int(11) NOT NULL DEFAULT 0,
  `bo_new` int(11) NOT NULL DEFAULT 0,
  `bo_hot` int(11) NOT NULL DEFAULT 0,
  `bo_image_width` int(11) NOT NULL DEFAULT 0,
  `bo_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `bo_include_head` varchar(255) NOT NULL DEFAULT '',
  `bo_include_tail` varchar(255) NOT NULL DEFAULT '',
  `bo_content_head` text NOT NULL,
  `bo_mobile_content_head` text NOT NULL,
  `bo_content_tail` text NOT NULL,
  `bo_mobile_content_tail` text NOT NULL,
  `bo_insert_content` text NOT NULL,
  `bo_gallery_cols` int(11) NOT NULL DEFAULT 0,
  `bo_gallery_width` int(11) NOT NULL DEFAULT 0,
  `bo_gallery_height` int(11) NOT NULL DEFAULT 0,
  `bo_mobile_gallery_width` int(11) NOT NULL DEFAULT 0,
  `bo_mobile_gallery_height` int(11) NOT NULL DEFAULT 0,
  `bo_upload_size` int(11) NOT NULL DEFAULT 0,
  `bo_reply_order` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_search` tinyint(4) NOT NULL DEFAULT 0,
  `bo_order` int(11) NOT NULL DEFAULT 0,
  `bo_count_write` int(11) NOT NULL DEFAULT 0,
  `bo_count_comment` int(11) NOT NULL DEFAULT 0,
  `bo_write_min` int(11) NOT NULL DEFAULT 0,
  `bo_write_max` int(11) NOT NULL DEFAULT 0,
  `bo_comment_min` int(11) NOT NULL DEFAULT 0,
  `bo_comment_max` int(11) NOT NULL DEFAULT 0,
  `bo_notice` text NOT NULL,
  `bo_upload_count` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_email` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_cert` enum('','cert','adult','hp-cert','hp-adult') NOT NULL DEFAULT '',
  `bo_use_sns` tinyint(4) NOT NULL DEFAULT 0,
  `bo_use_captcha` tinyint(4) NOT NULL DEFAULT 0,
  `bo_sort_field` varchar(255) NOT NULL DEFAULT '',
  `bo_1_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_2_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_3_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_4_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_5_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_6_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_7_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_8_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_9_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_10_subj` varchar(255) NOT NULL DEFAULT '',
  `bo_1` varchar(255) NOT NULL DEFAULT '',
  `bo_2` varchar(255) NOT NULL DEFAULT '',
  `bo_3` varchar(255) NOT NULL DEFAULT '',
  `bo_4` varchar(255) NOT NULL DEFAULT '',
  `bo_5` varchar(255) NOT NULL DEFAULT '',
  `bo_6` varchar(255) NOT NULL DEFAULT '',
  `bo_7` varchar(255) NOT NULL DEFAULT '',
  `bo_8` varchar(255) NOT NULL DEFAULT '',
  `bo_9` varchar(255) NOT NULL DEFAULT '',
  `bo_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`bo_table`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board`
--

LOCK TABLES `g5_board` WRITE;
/*!40000 ALTER TABLE `g5_board` DISABLE KEYS */;
INSERT INTO `g5_board` VALUES ('chamcode_gallery','default','Selected Works','시공사례','both','',1,1,10,10,10,10,1,10,10,1,1,0,0,0,0,1,'RESIDENCE|RESIDENCE > 서울|RESIDENCE > 서울 > 은평구|RESIDENCE > 인천|RESIDENCE > 청주|COMMERCIAL',0,0,0,1,'smarteditor2',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,600,'theme/gallery_editorial','basic','_head.php','_tail.php','','','','','',4,300,300,125,100,1048576,1,1,0,20,2,0,0,0,0,'',3,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('dataroom','default','자료실','자료실','both','',1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,'',0,0,0,0,'',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,600,'theme/dataroom','theme/basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,1,0,0,0,0,0,'',2,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('news','default','뉴스 & 공지','뉴스 & 공지','both','',1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,'',0,0,0,0,'',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,600,'theme/basic','basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,4,3,0,0,0,0,'',2,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('online7','default','온라인접수7','온라인접수7','both','',1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,'',0,0,0,0,'',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,600,'theme/adm_online7','basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,7,0,0,0,0,0,'',2,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('Portfolio','default','포트폴리오','포트폴리오','both','',1,1,10,10,10,10,10,10,10,1,1,0,0,0,0,1,'기업|기업 > 여자|개인',0,0,0,1,'smarteditor2',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,600,'theme/webzine','basic','_head.php','_tail.php','','','','','',4,600,600,125,100,1048576,1,1,0,5,0,0,0,0,0,'',5,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('product','default','제품소개','','both','',1,1,10,10,10,10,10,10,10,1,1,0,0,0,0,0,'',0,0,0,1,'smarteditor2',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,600,'theme/webzine','basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,10,0,0,0,0,0,'',1,0,'',0,0,'','','','','','','','','','','','','','','','','','','','',''),('qna','default','묻고답하기','묻고답하기','both','',1,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,'',0,0,0,1,'cheditor5',0,0,0,0,0,0,0,0,0,100,60,30,15,15,24,100,600,'theme/basic_qna','basic','_head.php','_tail.php','','','','','',4,202,150,125,100,1048576,1,1,0,2,0,0,0,0,0,'',2,0,'',0,0,'','','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_board` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_file`
--

DROP TABLE IF EXISTS `g5_board_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_board_file` (
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int(11) NOT NULL DEFAULT 0,
  `bf_no` int(11) NOT NULL DEFAULT 0,
  `bf_source` varchar(255) NOT NULL DEFAULT '',
  `bf_file` varchar(255) NOT NULL DEFAULT '',
  `bf_download` int(11) NOT NULL,
  `bf_content` text NOT NULL,
  `bf_fileurl` varchar(255) NOT NULL DEFAULT '',
  `bf_thumburl` varchar(255) NOT NULL DEFAULT '',
  `bf_storage` varchar(50) NOT NULL DEFAULT '',
  `bf_filesize` int(11) NOT NULL DEFAULT 0,
  `bf_width` int(11) NOT NULL DEFAULT 0,
  `bf_height` smallint(6) NOT NULL DEFAULT 0,
  `bf_type` tinyint(4) NOT NULL DEFAULT 0,
  `bf_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`bo_table`,`wr_id`,`bf_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_file`
--

LOCK TABLES `g5_board_file` WRITE;
/*!40000 ALTER TABLE `g5_board_file` DISABLE KEYS */;
INSERT INTO `g5_board_file` VALUES ('chamcode_gallery',1,0,'sub_visual_1020_1765854659.png','be40cd0cd01209b4a21423f85fe24611_9a2R4Ofq_29f7d63cc52b5ae1c3c967211d5d23fd9adc0fd9.png',0,'','','','',433416,1024,1024,2,'2025-12-23 10:19:48'),('chamcode_gallery',2,0,'11.jpg','be40cd0cd01209b4a21423f85fe24611_BgaQze6c_06b6291cc72ef97b6bfe6a795a07b642b4d36ec9.jpg',0,'','','','',114204,311,474,2,'2025-12-23 10:35:47'),('chamcode_gallery',3,0,'20251208_071743.png','be40cd0cd01209b4a21423f85fe24611_37r1JMxH_a562e5be5e3e08ba4145ed74f7716f648a168e8a.png',0,'','','','',45619,293,164,3,'2025-12-23 10:38:44'),('chamcode_gallery',6,0,'Shotcut_00_00_00_033.jpg','be40cd0cd01209b4a21423f85fe24611_NVijTgbs_5df49ef1d2b0333332d623d414d1293ea207b28d.jpg',0,'','','','',1186663,1920,1080,2,'2025-12-23 13:20:44'),('chamcode_gallery',7,0,'KakaoTalk_20251211_081304034.jpg','be40cd0cd01209b4a21423f85fe24611_kx9P58r3_a685654a5476f93521b203ac64e54a660a0fae16.jpg',0,'','','','',770470,1280,960,2,'2025-12-23 13:05:34'),('chamcode_gallery',8,0,'sub_visual_1020_1765854659.png','be40cd0cd01209b4a21423f85fe24611_GhgIEr0R_c7fb0eda749ca08f19c566d085dea63b69c29d62.png',0,'','','','',433416,1024,1024,2,'2025-12-23 13:13:19'),('chamcode_gallery',10,0,'Gemini_Generated_Image_p5tlfjp5tlfjp5tl.png','be40cd0cd01209b4a21423f85fe24611_dvECHhyP_664df98ad101fe206d0e57c2116c376770c79e34.png',0,'','','','',658007,1968,544,3,'2026-01-13 12:43:15'),('chamcode_gallery',11,0,'Gemini_Generated_Image_p5tlfjp5tlfjp5tl.png','be40cd0cd01209b4a21423f85fe24611_yguY3BcE_404e2d2f93278836b333dab3869af66247d23023.png',0,'','','','',658007,1968,544,3,'2026-01-13 12:58:27'),('chamcode_gallery',12,0,'logo.png','be40cd0cd01209b4a21423f85fe24611_UhLFtgQW_486820021a6cd0722cdf70abaa326c18e7b51c75.png',0,'','','','',5662,207,57,3,'2026-01-13 13:05:34'),('chamcode_gallery',13,0,'Gemini_Generated_Image_p5tlfjp5tlfjp5tl.png','be40cd0cd01209b4a21423f85fe24611_6JgU50XL_6354a0dcfc65719508cc8f35fe635313d3e99121.png',0,'','','','',658007,1968,544,3,'2026-01-13 13:06:58'),('chamcode_gallery',17,0,'Gemini_Generated_Image_p5tlfjp5tlfjp5tl.png','be40cd0cd01209b4a21423f85fe24611_Iks7NH6p_fbf755d12448e25aeeac8594e3afa57da0f34910.png',0,'','','','',658007,1968,544,3,'2026-01-13 13:40:19'),('chamcode_gallery',18,0,'Gemini_Generated_Image_p5tlfjp5tlfjp5tl.png','be40cd0cd01209b4a21423f85fe24611_ELBaFpUS_2583855c9fc6a2b175f73a828d78bb6e6a030553.png',0,'','','','',658007,1968,544,3,'2026-01-13 13:41:04'),('chamcode_gallery',19,0,'KakaoTalk_20260112_123021691.jpg','be40cd0cd01209b4a21423f85fe24611_5zrPvBou_72823d5afb80fddf9e2e3a879b78fcf54a0083a7.jpg',0,'','','','',525587,1280,720,2,'2026-01-13 15:22:31'),('chamcode_gallery',20,0,'KakaoTalk_20260112_123021691.jpg','be40cd0cd01209b4a21423f85fe24611_a4LksFnh_4a763ba6e1b5b8726f5bdaf155b84d75307e1e16.jpg',0,'','','','',525587,1280,720,2,'2026-01-13 15:26:07'),('chamcode_gallery',21,0,'Gemini_Generated_Image_p5tlfjp5tlfjp5tl.png','be40cd0cd01209b4a21423f85fe24611_fVNylmi6_fb696ffd3723d0bc9aae4d7be85b7acbc27c0db3.png',0,'','','','',658007,1968,544,3,'2026-01-13 16:33:43'),('chamcode_gallery',21,1,'KakaoTalk_20260112_123021691.jpg','be40cd0cd01209b4a21423f85fe24611_g1dYRMV4_f5ee61d00e6018d8b8f2cfc1e049d64731164a3c.jpg',0,'','','','',525587,1280,720,2,'2026-01-13 16:33:43'),('chamcode_gallery',22,0,'woman-600238_1280.jpg','be40cd0cd01209b4a21423f85fe24611_yqA0fjTz_ee23d409dc11f01d8511610eb188a5bf70b7a845.jpg',0,'','','','',307624,1280,854,2,'2026-01-13 16:37:19'),('chamcode_gallery',22,1,'beautiful-2359121_1280.jpg','be40cd0cd01209b4a21423f85fe24611_L7dOR5vG_de0fc217375cee7d16c10719199e484a040582bf.jpg',0,'','','','',394197,1114,1280,2,'2026-01-13 16:37:19'),('chamcode_gallery',22,2,'KakaoTalk_20260112_123021691.jpg','be40cd0cd01209b4a21423f85fe24611_ZH5OR6cm_1d445c1aafce3dd16580df8e3c03bd33412c1988.jpg',0,'','','','',525587,1280,720,2,'2026-01-14 09:09:56'),('dataroom',1,0,'chamcode_gallery.zip','be40cd0cd01209b4a21423f85fe24611_N9Xr8UqB_9a2be613d1b4226c6ffb4a3998743989929e2fac.zip',0,'','','','',26868,0,0,0,'2025-12-23 14:15:21'),('news',2,0,'sub_visual_1020_1765854659.png','be40cd0cd01209b4a21423f85fe24611_NMZz1xV5_6439b602db6404e78be1b1576bfb201c813b3e40.png',2,'','','','',433416,1024,1024,2,'2025-12-18 13:34:14'),('Portfolio',1,0,'beautiful-2359121_1280.jpg','be40cd0cd01209b4a21423f85fe24611_ChJZcayt_7bc0d90fb2b4671f35bb07a86ae45ae35781f41c.jpg',0,'','','','',394197,1114,1280,2,'2026-01-14 14:14:37'),('Portfolio',1,1,'woman-600238_1280.jpg','be40cd0cd01209b4a21423f85fe24611_EaKjNDv6_e347b9f749d38f2a9f3f3c222a905bb536c1037b.jpg',0,'','','','',307624,1280,854,2,'2026-01-14 14:14:37'),('Portfolio',1,2,'beautiful-2359121_1280.jpg','be40cd0cd01209b4a21423f85fe24611_rwWctzJo_ddd8ff09980d1285df0fe7efad25db90cffd8637.jpg',0,'','','','',394197,1114,1280,2,'2026-01-14 14:14:37'),('Portfolio',4,0,'woman-600238_1280.jpg','be40cd0cd01209b4a21423f85fe24611_3ELsCShd_348a53df311a969811328f0177b86738219f4d52.jpg',0,'','','','',307624,1280,854,2,'2026-01-14 15:57:17'),('Portfolio',4,1,'beautiful-2359121_1280.jpg','be40cd0cd01209b4a21423f85fe24611_Gwxva13O_ecb3bd9340fa1ad6654f453d5bb4ce35491d2d87.jpg',0,'','','','',394197,1114,1280,2,'2026-01-14 15:57:17'),('Portfolio',5,0,'woman-600238_1280.jpg','be40cd0cd01209b4a21423f85fe24611_QMU0yjnP_583337341f0bfa308325cd12d3fd5d4baa32396e.jpg',0,'','','','',307624,1280,854,2,'2026-01-14 15:58:30'),('Portfolio',5,1,'beautiful-2359121_1280.jpg','be40cd0cd01209b4a21423f85fe24611_wrOPolyK_09fcdb4e2476ecd246c9ada0e253bee1a393ce35.jpg',0,'','','','',394197,1114,1280,2,'2026-01-14 15:58:30'),('Portfolio',6,0,'beautiful-2359121_1280.jpg','be40cd0cd01209b4a21423f85fe24611_AHiCt9hU_0a806f867a33d612c7e2eb1758a226571a37b480.jpg',0,'','','','',394197,1114,1280,2,'2026-01-14 15:59:06'),('Portfolio',6,1,'beautiful-2359121_1280.jpg','be40cd0cd01209b4a21423f85fe24611_rF1pxvkw_92b1b2ffbab8223fbd93264f15a192aafc38e723.jpg',0,'','','','',394197,1114,1280,2,'2026-01-14 15:59:06'),('Portfolio',11,0,'woman-600238_1280.jpg','be40cd0cd01209b4a21423f85fe24611_8P3DhwGn_24819954e4f5ac02d628bbb63e51550d94606ccb.jpg',0,'','','','',307624,1280,854,2,'2026-01-15 11:24:33'),('product',1,0,'1303131140168_1.jpg','be40cd0cd01209b4a21423f85fe24611_Tws9jmI3_953cb85d86f440127dc07cf2d949d02a75ebfbfb.jpg',0,'','','','',1064787,1200,900,2,'2025-12-28 12:46:32'),('product',2,0,'1303270339072_1.jpg','be40cd0cd01209b4a21423f85fe24611_9khcTKl5_9395ed02f0fb7a51907535e6ed2d3f7c98b82237.jpg',0,'','','','',208688,1024,768,2,'2025-12-28 14:39:44'),('product',3,0,'1303131140168_1.jpg','be40cd0cd01209b4a21423f85fe24611_HOAUFiG6_86b882a37ca7885ca6fc8a42fcf9f891ffed3029.jpg',0,'','','','',1064787,1200,900,2,'2025-12-29 10:53:52'),('product',4,0,'1303270339072_1.jpg','be40cd0cd01209b4a21423f85fe24611_etwW3x1F_9597c76003800a347072fe2a2160a8c50fd912de.jpg',0,'','','','',208688,1024,768,2,'2025-12-29 11:31:10'),('product',5,0,'1303270339072_1.jpg','be40cd0cd01209b4a21423f85fe24611_3K2geLrs_9da65416ec85fd22cbbeda5f52613f45d90cdb0f.jpg',0,'','','','',208688,1024,768,2,'2025-12-29 12:23:14'),('product',6,0,'1303131140168_1.jpg','be40cd0cd01209b4a21423f85fe24611_Kso0v5ST_d33932ca75b5c748c76dc71c070c14c643b8efd5.jpg',0,'','','','',1064787,1200,900,2,'2025-12-29 12:24:51'),('product',7,0,'1303270339072_1.jpg','be40cd0cd01209b4a21423f85fe24611_9uDNVnls_4fa1da7aecc2a7b847b35aff324e8e829a5330f8.jpg',0,'','','','',208688,1024,768,2,'2025-12-29 12:56:32'),('product',8,0,'1303131140168_1.jpg','be40cd0cd01209b4a21423f85fe24611_Jwt9Ge8k_0ecbb28fe3dabc9c38802867da02efb3cdf9ed3b.jpg',0,'','','','',1064787,1200,900,2,'2025-12-29 13:29:11'),('product',9,0,'1303270339072_1.jpg','be40cd0cd01209b4a21423f85fe24611_Og57HJCE_61dacad0db5a942d26fa0645d6f2ff024eaa6894.jpg',0,'','','','',208688,1024,768,2,'2025-12-29 13:34:59'),('product',10,0,'1303131140168_1.jpg','be40cd0cd01209b4a21423f85fe24611_8627iMdj_345b9d49fef026b8a8ec6334fec1c2e4e999ed01.jpg',0,'','','','',1064787,1200,900,2,'2025-12-29 13:47:33');
/*!40000 ALTER TABLE `g5_board_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_good`
--

DROP TABLE IF EXISTS `g5_board_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_board_good` (
  `bg_id` int(11) NOT NULL AUTO_INCREMENT,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bg_flag` varchar(255) NOT NULL DEFAULT '',
  `bg_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`bg_id`),
  UNIQUE KEY `fkey1` (`bo_table`,`wr_id`,`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_good`
--

LOCK TABLES `g5_board_good` WRITE;
/*!40000 ALTER TABLE `g5_board_good` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_board_good` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_board_new`
--

DROP TABLE IF EXISTS `g5_board_new`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_board_new` (
  `bn_id` int(11) NOT NULL AUTO_INCREMENT,
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` int(11) NOT NULL DEFAULT 0,
  `wr_parent` int(11) NOT NULL DEFAULT 0,
  `bn_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`bn_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_board_new`
--

LOCK TABLES `g5_board_new` WRITE;
/*!40000 ALTER TABLE `g5_board_new` DISABLE KEYS */;
INSERT INTO `g5_board_new` VALUES (1,'news',1,1,'2025-12-18 12:48:31','admin'),(2,'news',2,2,'2025-12-18 13:34:14','admin'),(3,'news',3,3,'2025-12-18 13:40:22','admin'),(4,'news',4,4,'2025-12-18 13:43:29','admin'),(5,'news',5,2,'2025-12-18 14:05:19','admin'),(6,'chamcode_gallery',1,1,'2025-12-23 10:19:48','admin'),(7,'chamcode_gallery',2,2,'2025-12-23 10:35:47','admin'),(8,'chamcode_gallery',3,3,'2025-12-23 10:38:44','admin'),(9,'chamcode_gallery',4,3,'2025-12-23 11:09:37','admin'),(10,'chamcode_gallery',5,3,'2025-12-23 11:10:20','admin'),(11,'chamcode_gallery',6,6,'2025-12-23 13:04:25','admin'),(12,'chamcode_gallery',7,7,'2025-12-23 13:05:34','admin'),(13,'chamcode_gallery',8,8,'2025-12-23 13:13:19','admin'),(14,'news',6,2,'2025-12-23 14:08:19','admin'),(15,'news',7,2,'2025-12-23 14:08:24','admin'),(16,'dataroom',1,1,'2025-12-23 14:15:21','admin'),(17,'product',1,1,'2025-12-28 12:46:32','admin'),(18,'product',2,2,'2025-12-28 14:39:44','admin'),(19,'product',3,3,'2025-12-29 10:53:52','admin'),(20,'product',4,4,'2025-12-29 11:31:10','admin'),(21,'product',5,5,'2025-12-29 12:23:14','admin'),(22,'product',6,6,'2025-12-29 12:24:51','admin'),(23,'product',7,7,'2025-12-29 12:56:32','admin'),(24,'product',8,8,'2025-12-29 13:29:11','admin'),(25,'product',9,9,'2025-12-29 13:34:59','admin'),(26,'product',10,10,'2025-12-29 13:47:33','admin'),(27,'chamcode_gallery',9,9,'2026-01-13 12:35:44','admin'),(28,'chamcode_gallery',10,10,'2026-01-13 12:43:15','admin'),(29,'chamcode_gallery',11,11,'2026-01-13 12:58:27','admin'),(30,'chamcode_gallery',12,12,'2026-01-13 13:05:34','admin'),(31,'chamcode_gallery',13,13,'2026-01-13 13:06:58','admin'),(32,'chamcode_gallery',14,14,'2026-01-13 13:16:34','admin'),(33,'chamcode_gallery',15,15,'2026-01-13 13:19:00','admin'),(34,'chamcode_gallery',16,16,'2026-01-13 13:36:48','admin'),(35,'chamcode_gallery',17,17,'2026-01-13 13:40:19','admin'),(36,'chamcode_gallery',18,18,'2026-01-13 13:41:04','admin'),(37,'chamcode_gallery',19,19,'2026-01-13 15:22:31','admin'),(38,'chamcode_gallery',20,20,'2026-01-13 15:26:07','admin'),(39,'chamcode_gallery',21,21,'2026-01-13 16:33:43','admin'),(40,'chamcode_gallery',22,22,'2026-01-13 16:37:19','admin'),(41,'Portfolio',1,1,'2026-01-14 14:14:37','admin'),(44,'Portfolio',4,4,'2026-01-14 15:57:17','admin'),(45,'Portfolio',5,5,'2026-01-14 15:58:30','admin'),(46,'Portfolio',6,6,'2026-01-14 15:59:06','admin'),(51,'Portfolio',11,11,'2026-01-15 11:24:33','admin'),(52,'qna',1,1,'2026-03-10 16:14:13','admin'),(53,'qna',2,2,'2026-03-11 10:07:19','admin');
/*!40000 ALTER TABLE `g5_board_new` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_cert_history`
--

DROP TABLE IF EXISTS `g5_cert_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_cert_history` (
  `cr_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `cr_company` varchar(255) NOT NULL DEFAULT '',
  `cr_method` varchar(255) NOT NULL DEFAULT '',
  `cr_ip` varchar(255) NOT NULL DEFAULT '',
  `cr_date` date NOT NULL DEFAULT '0000-00-00',
  `cr_time` time NOT NULL DEFAULT '00:00:00',
  PRIMARY KEY (`cr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_cert_history`
--

LOCK TABLES `g5_cert_history` WRITE;
/*!40000 ALTER TABLE `g5_cert_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_cert_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_config`
--

DROP TABLE IF EXISTS `g5_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_config` (
  `cf_id` int(11) NOT NULL AUTO_INCREMENT,
  `cf_title` varchar(255) NOT NULL DEFAULT '',
  `cf_theme` varchar(100) NOT NULL DEFAULT '',
  `cf_admin` varchar(100) NOT NULL DEFAULT '',
  `cf_admin_email` varchar(100) NOT NULL DEFAULT '',
  `cf_admin_email_name` varchar(100) NOT NULL DEFAULT '',
  `cf_add_script` text NOT NULL,
  `cf_use_point` tinyint(4) NOT NULL DEFAULT 0,
  `cf_point_term` int(11) NOT NULL DEFAULT 0,
  `cf_use_copy_log` tinyint(4) NOT NULL DEFAULT 0,
  `cf_use_email_certify` tinyint(4) NOT NULL DEFAULT 0,
  `cf_login_point` int(11) NOT NULL DEFAULT 0,
  `cf_cut_name` tinyint(4) NOT NULL DEFAULT 0,
  `cf_nick_modify` int(11) NOT NULL DEFAULT 0,
  `cf_new_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_new_rows` int(11) NOT NULL DEFAULT 0,
  `cf_search_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_connect_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_faq_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_read_point` int(11) NOT NULL DEFAULT 0,
  `cf_write_point` int(11) NOT NULL DEFAULT 0,
  `cf_comment_point` int(11) NOT NULL DEFAULT 0,
  `cf_download_point` int(11) NOT NULL DEFAULT 0,
  `cf_write_pages` int(11) NOT NULL DEFAULT 0,
  `cf_mobile_pages` int(11) NOT NULL DEFAULT 0,
  `cf_link_target` varchar(50) NOT NULL DEFAULT '',
  `cf_bbs_rewrite` tinyint(4) NOT NULL DEFAULT 0,
  `cf_delay_sec` int(11) NOT NULL DEFAULT 0,
  `cf_filter` text NOT NULL,
  `cf_possible_ip` text NOT NULL,
  `cf_intercept_ip` text NOT NULL,
  `cf_analytics` text NOT NULL,
  `cf_add_meta` text NOT NULL,
  `cf_syndi_token` varchar(255) NOT NULL,
  `cf_syndi_except` text NOT NULL,
  `cf_member_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_use_homepage` tinyint(4) NOT NULL DEFAULT 0,
  `cf_req_homepage` tinyint(4) NOT NULL DEFAULT 0,
  `cf_use_tel` tinyint(4) NOT NULL DEFAULT 0,
  `cf_req_tel` tinyint(4) NOT NULL DEFAULT 0,
  `cf_use_hp` tinyint(4) NOT NULL DEFAULT 0,
  `cf_req_hp` tinyint(4) NOT NULL DEFAULT 0,
  `cf_use_addr` tinyint(4) NOT NULL DEFAULT 0,
  `cf_req_addr` tinyint(4) NOT NULL DEFAULT 0,
  `cf_use_signature` tinyint(4) NOT NULL DEFAULT 0,
  `cf_req_signature` tinyint(4) NOT NULL DEFAULT 0,
  `cf_use_profile` tinyint(4) NOT NULL DEFAULT 0,
  `cf_req_profile` tinyint(4) NOT NULL DEFAULT 0,
  `cf_register_level` tinyint(4) NOT NULL DEFAULT 0,
  `cf_register_point` int(11) NOT NULL DEFAULT 0,
  `cf_icon_level` tinyint(4) NOT NULL DEFAULT 0,
  `cf_use_recommend` tinyint(4) NOT NULL DEFAULT 0,
  `cf_recommend_point` int(11) NOT NULL DEFAULT 0,
  `cf_leave_day` int(11) NOT NULL DEFAULT 0,
  `cf_search_part` int(11) NOT NULL DEFAULT 0,
  `cf_email_use` tinyint(4) NOT NULL DEFAULT 0,
  `cf_email_wr_super_admin` tinyint(4) NOT NULL DEFAULT 0,
  `cf_email_wr_group_admin` tinyint(4) NOT NULL DEFAULT 0,
  `cf_email_wr_board_admin` tinyint(4) NOT NULL DEFAULT 0,
  `cf_email_wr_write` tinyint(4) NOT NULL DEFAULT 0,
  `cf_email_wr_comment_all` tinyint(4) NOT NULL DEFAULT 0,
  `cf_email_mb_super_admin` tinyint(4) NOT NULL DEFAULT 0,
  `cf_email_mb_member` tinyint(4) NOT NULL DEFAULT 0,
  `cf_email_po_super_admin` tinyint(4) NOT NULL DEFAULT 0,
  `cf_prohibit_id` text NOT NULL,
  `cf_prohibit_email` text NOT NULL,
  `cf_new_del` int(11) NOT NULL DEFAULT 0,
  `cf_memo_del` int(11) NOT NULL DEFAULT 0,
  `cf_visit_del` int(11) NOT NULL DEFAULT 0,
  `cf_popular_del` int(11) NOT NULL DEFAULT 0,
  `cf_optimize_date` date NOT NULL DEFAULT '0000-00-00',
  `cf_use_member_icon` tinyint(4) NOT NULL DEFAULT 0,
  `cf_member_icon_size` int(11) NOT NULL DEFAULT 0,
  `cf_member_icon_width` int(11) NOT NULL DEFAULT 0,
  `cf_member_icon_height` int(11) NOT NULL DEFAULT 0,
  `cf_member_img_size` int(11) NOT NULL DEFAULT 0,
  `cf_member_img_width` int(11) NOT NULL DEFAULT 0,
  `cf_member_img_height` int(11) NOT NULL DEFAULT 0,
  `cf_login_minutes` int(11) NOT NULL DEFAULT 0,
  `cf_image_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_flash_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_movie_extension` varchar(255) NOT NULL DEFAULT '',
  `cf_formmail_is_member` tinyint(4) NOT NULL DEFAULT 0,
  `cf_page_rows` int(11) NOT NULL DEFAULT 0,
  `cf_mobile_page_rows` int(11) NOT NULL DEFAULT 0,
  `cf_visit` varchar(255) NOT NULL DEFAULT '',
  `cf_max_po_id` int(11) NOT NULL DEFAULT 0,
  `cf_stipulation` text NOT NULL,
  `cf_privacy` text NOT NULL,
  `cf_use_promotion` tinyint(1) NOT NULL DEFAULT 0,
  `cf_open_modify` int(11) NOT NULL DEFAULT 0,
  `cf_memo_send_point` int(11) NOT NULL DEFAULT 0,
  `cf_mobile_new_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_search_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_connect_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_faq_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_mobile_member_skin` varchar(50) NOT NULL DEFAULT '',
  `cf_captcha_mp3` varchar(255) NOT NULL DEFAULT '',
  `cf_editor` varchar(50) NOT NULL DEFAULT '',
  `cf_cert_use` tinyint(4) NOT NULL DEFAULT 0,
  `cf_cert_find` tinyint(4) NOT NULL DEFAULT 0,
  `cf_cert_ipin` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_hp` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_simple` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kg_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kg_mid` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_use_seed` tinyint(4) NOT NULL DEFAULT 1,
  `cf_cert_kcb_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcp_cd` varchar(255) NOT NULL DEFAULT '',
  `cf_cert_kcp_enckey` varchar(100) NOT NULL DEFAULT '',
  `cf_lg_mid` varchar(100) NOT NULL DEFAULT '',
  `cf_lg_mert_key` varchar(100) NOT NULL DEFAULT '',
  `cf_toss_client_key` varchar(100) NOT NULL DEFAULT '',
  `cf_toss_secret_key` varchar(100) NOT NULL DEFAULT '',
  `cf_cert_limit` int(11) NOT NULL DEFAULT 0,
  `cf_cert_req` tinyint(4) NOT NULL DEFAULT 0,
  `cf_sms_use` varchar(255) NOT NULL DEFAULT '',
  `cf_sms_type` varchar(10) NOT NULL DEFAULT '',
  `cf_icode_id` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_pw` varchar(255) NOT NULL DEFAULT '',
  `cf_icode_server_ip` varchar(50) NOT NULL DEFAULT '',
  `cf_icode_server_port` varchar(50) NOT NULL DEFAULT '',
  `cf_icode_token_key` varchar(100) NOT NULL DEFAULT '',
  `cf_googl_shorturl_apikey` varchar(50) NOT NULL DEFAULT '',
  `cf_social_login_use` tinyint(4) NOT NULL DEFAULT 0,
  `cf_social_servicelist` varchar(255) NOT NULL DEFAULT '',
  `cf_payco_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_payco_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_facebook_appid` varchar(100) NOT NULL,
  `cf_facebook_secret` varchar(100) NOT NULL,
  `cf_twitter_key` varchar(100) NOT NULL,
  `cf_twitter_secret` varchar(100) NOT NULL,
  `cf_google_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_google_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_naver_clientid` varchar(100) NOT NULL DEFAULT '',
  `cf_naver_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_rest_key` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_client_secret` varchar(100) NOT NULL DEFAULT '',
  `cf_kakao_js_apikey` varchar(100) NOT NULL,
  `cf_captcha` varchar(100) NOT NULL DEFAULT '',
  `cf_recaptcha_site_key` varchar(100) NOT NULL DEFAULT '',
  `cf_recaptcha_secret_key` varchar(100) NOT NULL DEFAULT '',
  `cf_1_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_2_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_3_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_4_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_5_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_6_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_7_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_8_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_9_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_10_subj` varchar(255) NOT NULL DEFAULT '',
  `cf_1` varchar(255) NOT NULL DEFAULT '',
  `cf_2` varchar(255) NOT NULL DEFAULT '',
  `cf_3` varchar(255) NOT NULL DEFAULT '',
  `cf_4` varchar(255) NOT NULL DEFAULT '',
  `cf_5` varchar(255) NOT NULL DEFAULT '',
  `cf_6` varchar(255) NOT NULL DEFAULT '',
  `cf_7` varchar(255) NOT NULL DEFAULT '',
  `cf_8` varchar(255) NOT NULL DEFAULT '',
  `cf_9` varchar(255) NOT NULL DEFAULT '',
  `cf_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_config`
--

LOCK TABLES `g5_config` WRITE;
/*!40000 ALTER TABLE `g5_config` DISABLE KEYS */;
INSERT INTO `g5_config` VALUES (1,'극동판넬(주)','kukdong_panel','admin','humdanhouse@naver.com','(주)르네상스 환경디자인 산업','',1,0,0,0,100,15,0,'theme/basic',15,'basic','basic','basic',0,0,0,0,10,10,'_blank',0,0,'','','','','','','','basic',0,0,0,0,0,0,0,0,0,0,0,0,1,100,1,0,0,0,1000,1,0,0,0,0,0,0,0,0,'','',0,0,0,0,'2026-03-18',0,0,0,0,0,0,0,0,'','','',0,15,15,'오늘:1,어제:1,최대:2,전체:52',0,'','',0,0,0,'basic','basic','basic','basic','basic','basic','smarteditor2',0,0,'','','','','',1,'','','','','','','',0,0,'','','','','211.172.232.124','7295','','',0,'','','','','','','','','','','','','','','kcaptcha','','','','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_content`
--

DROP TABLE IF EXISTS `g5_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_content` (
  `co_id` varchar(20) NOT NULL DEFAULT '',
  `co_html` tinyint(4) NOT NULL DEFAULT 0,
  `co_subject` varchar(255) NOT NULL DEFAULT '',
  `co_content` longtext NOT NULL,
  `co_seo_title` varchar(255) NOT NULL DEFAULT '',
  `co_mobile_content` longtext NOT NULL,
  `co_skin` varchar(255) NOT NULL DEFAULT '',
  `co_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `co_tag_filter_use` tinyint(4) NOT NULL DEFAULT 0,
  `co_hit` int(11) NOT NULL DEFAULT 0,
  `co_include_head` varchar(255) NOT NULL,
  `co_include_tail` varchar(255) NOT NULL,
  PRIMARY KEY (`co_id`),
  KEY `co_seo_title` (`co_seo_title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_content`
--

LOCK TABLES `g5_content` WRITE;
/*!40000 ALTER TABLE `g5_content` DISABLE KEYS */;
INSERT INTO `g5_content` VALUES ('CEO',1,'CEO인사말','<br><br><div class=\"con_img\"><img src=\"http://localhost/data/editor/2603/img_about%20%282%29.jpg\" title=\"img_about (2).jpg\" alt=\"img_about%20%282%29.jpg\"></div><br style=\"clear:both;\">\r\n<div class=\"greeting-section\">\r\n            <div class=\"greeting-lead active\">극동판넬(주)는 엄격한 공정 관리로 고품질의 제품을 생산하는 우수한 기업입니다.</div>\r\n            <div class=\"greeting-lead active\">홈페이지 방문을 진심으로 환영합니다. </div>\r\n\r\n            <div class=\"greeting-body active\">\r\n                <p>빠르게 변화하는 21세기에 더욱 풍요로운 인간 생활을 위해 우리는 또 다시 새로운 건축문화 발전을 위해 도전을 시도해야 합니다.</p>\r\n                <br>\r\n                <p>과거의 건축물이 공간 제공의 기능이었다고 한다면 현대 건축물의 주기능은 효과적인 공간 활용, 기능성 경제성 그리고 미적 감각이 고려되어야 합니다. </p>\r\n                <p>이에 극동판넬(주)는 전 직원은 엄격한 자재 생산과 공정관리로 풍요로운 신 주거문화 창조에 이바지 할 것입니다.</p>\r\n                <br>\r\n                <p>고객 여러분의 성원이 있었기에 극동판넬(주)가 있었다는 것을 명심하며 더욱 더 노력하는 모습으로 고객 여러분들과 함께 하겠습니다.</p>\r\n                <br>\r\n                <p>감사합니다.</p>\r\n            </div>\r\n\r\n            <div class=\"representative active\">\r\n                <span class=\"title\">Representative Director</span>\r\n                <strong>대표이사 전영주</strong>\r\n            </div>\r\n        </div>','ceo인사말','','basic','basic',1,0,'',''),('certificate',1,'인증서&시험성적서','<p><strong style=\"font-family: &quot;Noto Sans KR&quot;, sans-serif; display: block; padding-bottom: 15px; font-size: 30px; line-height: 35px; color: rgb(51, 51, 51); text-align: center;\">인증서&amp;시험성적서</strong></p>','인증서시험성적서','','basic','basic',1,0,'',''),('company',1,'회사소개 (System Bridge)','<p><img src=\"http://localhost/data/editor/2603/img_about.jpg\" title=\"img_about.jpg\" alt=\"img_about.jpg\"><br style=\"clear:both;\">시스템 연결용 컨텐츠입니다. 삭제하지 마세요.</p>','회사소개-system-bridge','','theme/basic','basic',1,0,'',''),('history',1,'회사연혁','<p><strong style=\"font-family: &quot;Noto Sans KR&quot;, sans-serif; display: block; padding-bottom: 15px; font-size: 30px; line-height: 35px; color: rgb(51, 51, 51); text-align: center;\">회사연혁</strong></p>','회사연혁','','basic','basic',1,0,'',''),('recruit',1,'체용정보','<p><br></p><table width=\"746\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"color:rgb(85,85,85);font-family:verdana;line-height:19.2px;\"><tbody><tr style=\"font-family:dotum;line-height:16.8px;\"><td style=\"font-family:verdana;line-height:19.2px;\"><table width=\"746\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"line-height:19.2px;\"><tbody><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_30\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:30px;\"><img src=\"http://renpia.com/company/img/recruit_tit.gif\" style=\"border:none;\" alt=\"recruit_tit.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_20\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:20px;\"><img src=\"http://renpia.com/company/img/recruit_img01.jpg\" style=\"border:none;\" alt=\"recruit_img01.jpg\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_10\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:10px;\"><img src=\"http://renpia.com/company/img/recruit_txt01.gif\" style=\"border:none;\" alt=\"recruit_txt01.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_15\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:15px;\">- 채용형태 : 수시채용 (홈페이지 게시판, 취업사이트 게제)<br>- 모집직종 : 일반관리직, 기능직<br>- 복리후생 : 4대보험, 주 5일 근무, 퇴직금. 년차, 경조휴가, 하계휴가</td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_15\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:15px;\"><img src=\"http://renpia.com/company/img/recruit_txt02.gif\" style=\"border:none;\" alt=\"recruit_txt02.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_20\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:20px;\"><img src=\"http://renpia.com/company/img/recruit_img02.gif\" style=\"border:none;\" alt=\"recruit_img02.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td style=\"font-family:verdana;line-height:19.2px;\">- 서류전형방법 : 홈페이지 온라인 입사지원, 기타 서류전형은 필요시 공지</td></tr></tbody></table></td></tr></tbody></table>\r\n\r\n<p><br></p><table width=\"746\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"color:rgb(85,85,85);font-family:verdana;line-height:19.2px;\"><tbody><tr style=\"font-family:dotum;line-height:16.8px;\"><td style=\"font-family:verdana;line-height:19.2px;\"><table width=\"746\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"line-height:19.2px;\"><tbody><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_30\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:30px;\"><img src=\"http://renpia.com/company/img/recruit_tit.gif\" style=\"border:none;\" alt=\"recruit_tit.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_20\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:20px;\"><img src=\"http://renpia.com/company/img/recruit_img01.jpg\" style=\"border:none;\" alt=\"recruit_img01.jpg\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_10\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:10px;\"><img src=\"http://renpia.com/company/img/recruit_txt01.gif\" style=\"border:none;\" alt=\"recruit_txt01.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_15\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:15px;\">- 채용형태 : 수시채용 (홈페이지 게시판, 취업사이트 게제)<br>- 모집직종 : 일반관리직, 기능직<br>- 복리후생 : 4대보험, 주 5일 근무, 퇴직금. 년차, 경조휴가, 하계휴가</td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_15\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:15px;\"><img src=\"http://renpia.com/company/img/recruit_txt02.gif\" style=\"border:none;\" alt=\"recruit_txt02.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_20\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:20px;\"><img src=\"http://renpia.com/company/img/recruit_img02.gif\" style=\"border:none;\" alt=\"recruit_img02.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td style=\"font-family:verdana;line-height:19.2px;\">- 서류전형방법 : 홈페이지 온라인 입사지원, 기타 서류전형은 필요시 공지</td></tr></tbody></table></td></tr></tbody></table>\r\n<p><br></p><table width=\"746\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"color:rgb(85,85,85);font-family:verdana;line-height:19.2px;\"><tbody><tr style=\"font-family:dotum;line-height:16.8px;\"><td style=\"font-family:verdana;line-height:19.2px;\"><table width=\"746\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"line-height:19.2px;\"><tbody><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_30\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:30px;\"><img src=\"http://renpia.com/company/img/recruit_tit.gif\" style=\"border:none;\" alt=\"recruit_tit.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_20\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:20px;\"><img src=\"http://renpia.com/company/img/recruit_img01.jpg\" style=\"border:none;\" alt=\"recruit_img01.jpg\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_10\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:10px;\"><img src=\"http://renpia.com/company/img/recruit_txt01.gif\" style=\"border:none;\" alt=\"recruit_txt01.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_15\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:15px;\">- 채용형태 : 수시채용 (홈페이지 게시판, 취업사이트 게제)<br>- 모집직종 : 일반관리직, 기능직<br>- 복리후생 : 4대보험, 주 5일 근무, 퇴직금. 년차, 경조휴가, 하계휴가</td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_15\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:15px;\"><img src=\"http://renpia.com/company/img/recruit_txt02.gif\" style=\"border:none;\" alt=\"recruit_txt02.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td class=\"bpad_20\" style=\"font-family:verdana;line-height:19.2px;padding-bottom:20px;\"><img src=\"http://renpia.com/company/img/recruit_img02.gif\" style=\"border:none;\" alt=\"recruit_img02.gif\"></td></tr><tr style=\"font-family:dotum;line-height:16.8px;\"><td style=\"font-family:verdana;line-height:19.2px;\">- 서류전형방법 : 홈페이지 온라인 입사지원, 기타 서류전형은 필요시 공지</td></tr></tbody></table></td></tr></tbody></table>','체용정보','','theme/basic','basic',1,0,'','');
/*!40000 ALTER TABLE `g5_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_copyright_config`
--

DROP TABLE IF EXISTS `g5_copyright_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_copyright_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logo_url` varchar(255) NOT NULL DEFAULT '',
  `addr_label` varchar(50) NOT NULL DEFAULT '주소',
  `addr_val` varchar(255) NOT NULL DEFAULT '',
  `tel_label` varchar(50) NOT NULL DEFAULT '연락처',
  `tel_val` varchar(255) NOT NULL DEFAULT '',
  `fax_label` varchar(50) NOT NULL DEFAULT '팩스',
  `fax_val` varchar(255) NOT NULL DEFAULT '',
  `email_label` varchar(50) NOT NULL DEFAULT '이메일',
  `email_val` varchar(255) NOT NULL DEFAULT '',
  `slogan` text NOT NULL,
  `copyright` text NOT NULL,
  `link1_name` varchar(100) NOT NULL DEFAULT '',
  `link1_url` varchar(255) NOT NULL DEFAULT '',
  `link2_name` varchar(100) NOT NULL DEFAULT '',
  `link2_url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_copyright_config`
--

LOCK TABLES `g5_copyright_config` WRITE;
/*!40000 ALTER TABLE `g5_copyright_config` DISABLE KEYS */;
INSERT INTO `g5_copyright_config` VALUES (1,'http://localhost/data/common/footer_logo.png','ADD','경기도 파주시 광탄면 분수3리 94-7 ','Tel1','031-943-65581','FAX','031-943-6558','EMAIL','phofler@gmail.com','창조성 정확성 높은 수준의 품질과 마무리는<br>르네상스 환경디자인산업','Copyright © All rights reserved.','Privacy Policy','http://localhost/bbs/content.php?co_id=company&me_code=1010','Contact Us','http://localhost/bbs/content.php?co_id=company&me_code=1010');
/*!40000 ALTER TABLE `g5_copyright_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_faq`
--

DROP TABLE IF EXISTS `g5_faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_faq` (
  `fa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_id` int(11) NOT NULL DEFAULT 0,
  `fa_subject` text NOT NULL,
  `fa_content` text NOT NULL,
  `fa_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`fa_id`),
  KEY `fm_id` (`fm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_faq`
--

LOCK TABLES `g5_faq` WRITE;
/*!40000 ALTER TABLE `g5_faq` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_faq_master`
--

DROP TABLE IF EXISTS `g5_faq_master`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_faq_master` (
  `fm_id` int(11) NOT NULL AUTO_INCREMENT,
  `fm_subject` varchar(255) NOT NULL DEFAULT '',
  `fm_head_html` text NOT NULL,
  `fm_tail_html` text NOT NULL,
  `fm_mobile_head_html` text NOT NULL,
  `fm_mobile_tail_html` text NOT NULL,
  `fm_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`fm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_faq_master`
--

LOCK TABLES `g5_faq_master` WRITE;
/*!40000 ALTER TABLE `g5_faq_master` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_faq_master` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_group`
--

DROP TABLE IF EXISTS `g5_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_group` (
  `gr_id` varchar(10) NOT NULL DEFAULT '',
  `gr_subject` varchar(255) NOT NULL DEFAULT '',
  `gr_device` enum('both','pc','mobile') NOT NULL DEFAULT 'both',
  `gr_admin` varchar(255) NOT NULL DEFAULT '',
  `gr_use_access` tinyint(4) NOT NULL DEFAULT 0,
  `gr_order` int(11) NOT NULL DEFAULT 0,
  `gr_1_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_2_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_3_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_4_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_5_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_6_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_7_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_8_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_9_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_10_subj` varchar(255) NOT NULL DEFAULT '',
  `gr_1` varchar(255) NOT NULL DEFAULT '',
  `gr_2` varchar(255) NOT NULL DEFAULT '',
  `gr_3` varchar(255) NOT NULL DEFAULT '',
  `gr_4` varchar(255) NOT NULL DEFAULT '',
  `gr_5` varchar(255) NOT NULL DEFAULT '',
  `gr_6` varchar(255) NOT NULL DEFAULT '',
  `gr_7` varchar(255) NOT NULL DEFAULT '',
  `gr_8` varchar(255) NOT NULL DEFAULT '',
  `gr_9` varchar(255) NOT NULL DEFAULT '',
  `gr_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`gr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_group`
--

LOCK TABLES `g5_group` WRITE;
/*!40000 ALTER TABLE `g5_group` DISABLE KEYS */;
INSERT INTO `g5_group` VALUES ('default','Default Group','both','',0,0,'','','','','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_group_member`
--

DROP TABLE IF EXISTS `g5_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_group_member` (
  `gm_id` int(11) NOT NULL AUTO_INCREMENT,
  `gr_id` varchar(255) NOT NULL DEFAULT '',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `gm_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`gm_id`),
  KEY `gr_id` (`gr_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_group_member`
--

LOCK TABLES `g5_group_member` WRITE;
/*!40000 ALTER TABLE `g5_group_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_group_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_login`
--

DROP TABLE IF EXISTS `g5_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_login` (
  `lo_id` int(11) NOT NULL AUTO_INCREMENT,
  `lo_ip` varchar(100) NOT NULL DEFAULT '',
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `lo_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lo_location` text NOT NULL,
  `lo_url` text NOT NULL,
  PRIMARY KEY (`lo_id`),
  UNIQUE KEY `lo_ip_unique` (`lo_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_login`
--

LOCK TABLES `g5_login` WRITE;
/*!40000 ALTER TABLE `g5_login` DISABLE KEYS */;
INSERT INTO `g5_login` VALUES (11,'::1','admin','2026-03-18 12:54:16','/','');
/*!40000 ALTER TABLE `g5_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_mail`
--

DROP TABLE IF EXISTS `g5_mail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_mail` (
  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_subject` varchar(255) NOT NULL DEFAULT '',
  `ma_content` mediumtext NOT NULL,
  `ma_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ma_ip` varchar(255) NOT NULL DEFAULT '',
  `ma_last_option` text NOT NULL,
  PRIMARY KEY (`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_mail`
--

LOCK TABLES `g5_mail` WRITE;
/*!40000 ALTER TABLE `g5_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_mail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_member`
--

DROP TABLE IF EXISTS `g5_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_member` (
  `mb_no` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `mb_password` varchar(255) NOT NULL DEFAULT '',
  `mb_password2` varchar(255) NOT NULL DEFAULT '',
  `mb_name` varchar(255) NOT NULL DEFAULT '',
  `mb_nick` varchar(255) NOT NULL DEFAULT '',
  `mb_nick_date` date NOT NULL DEFAULT '0000-00-00',
  `mb_email` varchar(255) NOT NULL DEFAULT '',
  `mb_homepage` varchar(255) NOT NULL DEFAULT '',
  `mb_level` tinyint(4) NOT NULL DEFAULT 0,
  `mb_sex` char(1) NOT NULL DEFAULT '',
  `mb_birth` varchar(255) NOT NULL DEFAULT '',
  `mb_tel` varchar(255) NOT NULL DEFAULT '',
  `mb_hp` varchar(255) NOT NULL DEFAULT '',
  `mb_certify` varchar(20) NOT NULL DEFAULT '',
  `mb_adult` tinyint(4) NOT NULL DEFAULT 0,
  `mb_dupinfo` varchar(255) NOT NULL DEFAULT '',
  `mb_zip1` char(3) NOT NULL DEFAULT '',
  `mb_zip2` char(3) NOT NULL DEFAULT '',
  `mb_addr1` varchar(255) NOT NULL DEFAULT '',
  `mb_addr2` varchar(255) NOT NULL DEFAULT '',
  `mb_addr3` varchar(255) NOT NULL DEFAULT '',
  `mb_addr_jibeon` varchar(255) NOT NULL DEFAULT '',
  `mb_signature` text NOT NULL,
  `mb_recommend` varchar(255) NOT NULL DEFAULT '',
  `mb_point` int(11) NOT NULL DEFAULT 0,
  `mb_today_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_login_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_ip` varchar(255) NOT NULL DEFAULT '',
  `mb_leave_date` varchar(8) NOT NULL DEFAULT '',
  `mb_intercept_date` varchar(8) NOT NULL DEFAULT '',
  `mb_email_certify` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_email_certify2` varchar(255) NOT NULL DEFAULT '',
  `mb_memo` text NOT NULL,
  `mb_lost_certify` varchar(255) NOT NULL,
  `mb_mailling` tinyint(4) NOT NULL DEFAULT 0,
  `mb_mailling_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_sms` tinyint(4) NOT NULL DEFAULT 0,
  `mb_sms_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_open` tinyint(4) NOT NULL DEFAULT 0,
  `mb_open_date` date NOT NULL DEFAULT '0000-00-00',
  `mb_profile` text NOT NULL,
  `mb_memo_call` varchar(255) NOT NULL DEFAULT '',
  `mb_memo_cnt` int(11) NOT NULL DEFAULT 0,
  `mb_scrap_cnt` int(11) NOT NULL DEFAULT 0,
  `mb_marketing_agree` tinyint(1) NOT NULL DEFAULT 0,
  `mb_marketing_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_thirdparty_agree` tinyint(1) NOT NULL DEFAULT 0,
  `mb_thirdparty_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mb_agree_log` text NOT NULL,
  `mb_1` varchar(255) NOT NULL DEFAULT '',
  `mb_2` varchar(255) NOT NULL DEFAULT '',
  `mb_3` varchar(255) NOT NULL DEFAULT '',
  `mb_4` varchar(255) NOT NULL DEFAULT '',
  `mb_5` varchar(255) NOT NULL DEFAULT '',
  `mb_6` varchar(255) NOT NULL DEFAULT '',
  `mb_7` varchar(255) NOT NULL DEFAULT '',
  `mb_8` varchar(255) NOT NULL DEFAULT '',
  `mb_9` varchar(255) NOT NULL DEFAULT '',
  `mb_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`mb_no`),
  UNIQUE KEY `mb_id` (`mb_id`),
  KEY `mb_today_login` (`mb_today_login`),
  KEY `mb_datetime` (`mb_datetime`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_member`
--

LOCK TABLES `g5_member` WRITE;
/*!40000 ALTER TABLE `g5_member` DISABLE KEYS */;
INSERT INTO `g5_member` VALUES (1,'admin','sha256:12000:H6FYMHy8u+dSBlq7YkIJwV5Bc9weEdqM:l30/rOkx3b/w0ifzMPPUurl+skZKtXDC','*A4B6157319038724E3560894F7F932C8886EBFCF','최고관리자','관리자','0000-00-00','sinem1@naver.com','',10,'','','','010-3400-6723','',0,'','033','76','녹번로7길 16','','','','','',4600,'2026-03-18 09:43:35','::1','2025-12-13 15:57:26','','','','2025-12-13 00:00:00','','','',1,'0000-00-00 00:00:00',1,'0000-00-00 00:00:00',1,'2025-12-15','','',0,0,0,'0000-00-00 00:00:00',0,'0000-00-00 00:00:00','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_member_cert_history`
--

DROP TABLE IF EXISTS `g5_member_cert_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_member_cert_history` (
  `ch_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `ch_name` varchar(255) NOT NULL DEFAULT '',
  `ch_hp` varchar(255) NOT NULL DEFAULT '',
  `ch_birth` varchar(255) NOT NULL DEFAULT '',
  `ch_type` varchar(20) NOT NULL DEFAULT '',
  `ch_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ch_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_member_cert_history`
--

LOCK TABLES `g5_member_cert_history` WRITE;
/*!40000 ALTER TABLE `g5_member_cert_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_member_cert_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_member_social_profiles`
--

DROP TABLE IF EXISTS `g5_member_social_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_member_social_profiles` (
  `mp_no` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `provider` varchar(50) NOT NULL DEFAULT '',
  `object_sha` varchar(45) NOT NULL DEFAULT '',
  `identifier` varchar(255) NOT NULL DEFAULT '',
  `profileurl` varchar(255) NOT NULL DEFAULT '',
  `photourl` varchar(255) NOT NULL DEFAULT '',
  `displayname` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `mp_register_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mp_latest_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`mp_no`),
  KEY `mb_id` (`mb_id`),
  KEY `provider` (`provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_member_social_profiles`
--

LOCK TABLES `g5_member_social_profiles` WRITE;
/*!40000 ALTER TABLE `g5_member_social_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_member_social_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_memo`
--

DROP TABLE IF EXISTS `g5_memo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_memo` (
  `me_id` int(11) NOT NULL AUTO_INCREMENT,
  `me_recv_mb_id` varchar(20) NOT NULL DEFAULT '',
  `me_send_mb_id` varchar(20) NOT NULL DEFAULT '',
  `me_send_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_read_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `me_memo` text NOT NULL,
  `me_send_id` int(11) NOT NULL DEFAULT 0,
  `me_type` enum('send','recv') NOT NULL DEFAULT 'recv',
  `me_send_ip` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`me_id`),
  KEY `me_recv_mb_id` (`me_recv_mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_memo`
--

LOCK TABLES `g5_memo` WRITE;
/*!40000 ALTER TABLE `g5_memo` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_memo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_menu`
--

DROP TABLE IF EXISTS `g5_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_menu` (
  `me_id` int(11) NOT NULL AUTO_INCREMENT,
  `me_code` varchar(255) NOT NULL DEFAULT '',
  `me_name` varchar(255) NOT NULL DEFAULT '',
  `me_link` varchar(255) NOT NULL DEFAULT '',
  `me_target` varchar(255) NOT NULL DEFAULT '',
  `me_order` int(11) NOT NULL DEFAULT 0,
  `me_use` tinyint(4) NOT NULL DEFAULT 0,
  `me_mobile_use` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`me_id`)
) ENGINE=InnoDB AUTO_INCREMENT=774 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_menu`
--

LOCK TABLES `g5_menu` WRITE;
/*!40000 ALTER TABLE `g5_menu` DISABLE KEYS */;
INSERT INTO `g5_menu` VALUES (745,'10','회사소개1','#','self',0,1,0),(746,'1010','회사개요','/bbs/content.php?co_id=company&amp;me_code=1010','self',0,1,0),(747,'1020','인사말','/bbs/content.php?co_id=ceo&amp;me_code=1020','self',0,1,0),(748,'1030','제품개요','/bbs/content.php?co_id=history&amp;me_code=1030','self',0,1,0),(749,'1040','연혁','/bbs/content.php?co_id=history&amp;me_code=1040','self',0,1,0),(750,'1050','조직도','http://localhost/theme/corporate/page/org.php','self',0,1,0),(751,'1060','사업분야','http://localhost/theme/corporate/page/business.php','self',0,1,0),(752,'1070','인증/실적','http://localhost/theme/corporate/page/cert.php','self',0,1,0),(753,'1080','채용정보','/bbs/content.php?co_id=location&amp;me_code=1080','self',0,1,0),(754,'1090','찾아오시는길','/bbs/content.php?co_id=location&amp;me_code=1090','self',0,1,0),(755,'20','제품소개','http://localhost/bbs/board.php?bo_table=produc&amp;cate=1010t&amp;me_code=20','self',0,1,0),(756,'2010','오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어','http://localhost/bbs/board.php?bo_table=product&amp;cate=1010&amp;me_code=2010','self',0,1,0),(757,'2020','자동대문','http://localhost/bbs/board.php?bo_table=product&amp;sca=자동대문','self',0,1,0),(758,'2030','오버헤드도어','http://localhost/bbs/board.php?bo_table=product&amp;sca=오버헤드도어','self',0,1,0),(759,'2040','현관문','http://localhost/bbs/board.php?bo_table=product&amp;sca=현관문','self',0,1,0),(760,'2050','친환경','http://localhost/bbs/board.php?bo_table=product&amp;sca=친환경','self',0,1,0),(761,'2060','오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어오버헤드도어','111','self',0,1,1),(762,'2070','오버헤드도어','11111','self',0,1,1),(763,'2080','오버헤드도어','22222','self',0,1,1),(764,'2090','오버헤드도어','adadad','self',0,1,1),(765,'20a0','오버헤드도어','sfsfs','self',0,1,1),(766,'20b0','오버헤드도어','sfafd','self',0,1,1),(767,'20c0','오버헤드도어','afafdafd','self',0,1,1),(768,'30','시공사례','chamcode_gallery','self',0,1,0),(769,'40','온라인문의','/contact.php?&amp;me_code=40','self',0,1,0),(770,'50','고객지원','/bbs/board.php?bo_table=news&amp;me_code=5010','self',0,1,0),(771,'5010','뉴스 & 공지','/bbs/board.php?bo_table=news&amp;me_code=5010','self',0,1,0),(772,'5020','자료실','/bbs/board.php?bo_table=dataroom&amp;me_code=5020','self',0,1,0),(773,'5030','묻고답하기','/bbs/board.php?bo_table=qna&amp;me_code=5030','self',0,1,1);
/*!40000 ALTER TABLE `g5_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_new_win`
--

DROP TABLE IF EXISTS `g5_new_win`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_new_win` (
  `nw_id` int(11) NOT NULL AUTO_INCREMENT,
  `nw_division` varchar(10) NOT NULL DEFAULT 'both',
  `nw_device` varchar(10) NOT NULL DEFAULT 'both',
  `nw_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nw_disable_hours` int(11) NOT NULL DEFAULT 0,
  `nw_left` int(11) NOT NULL DEFAULT 0,
  `nw_top` int(11) NOT NULL DEFAULT 0,
  `nw_height` int(11) NOT NULL DEFAULT 0,
  `nw_width` int(11) NOT NULL DEFAULT 0,
  `nw_subject` text NOT NULL,
  `nw_content` text NOT NULL,
  `nw_content_html` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`nw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_new_win`
--

LOCK TABLES `g5_new_win` WRITE;
/*!40000 ALTER TABLE `g5_new_win` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_new_win` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_board_skin_config`
--

DROP TABLE IF EXISTS `g5_plugin_board_skin_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_board_skin_config` (
  `bs_id` varchar(100) NOT NULL DEFAULT '',
  `bs_theme` varchar(50) NOT NULL DEFAULT 'corporate',
  `bs_lang` varchar(10) NOT NULL DEFAULT 'ko',
  `bo_table` varchar(50) NOT NULL,
  `bs_title` varchar(255) NOT NULL DEFAULT '',
  `bs_skin` varchar(255) NOT NULL DEFAULT 'theme/basic',
  `bs_layout` varchar(20) NOT NULL,
  `bs_cols` int(11) NOT NULL DEFAULT 4,
  `bs_ratio` varchar(20) NOT NULL DEFAULT '4x3',
  `bs_theme_mode` varchar(20) NOT NULL DEFAULT '',
  `bs_bo_table` varchar(50) NOT NULL DEFAULT '',
  `bs_count` int(11) NOT NULL DEFAULT 4,
  `bs_subject_len` int(11) NOT NULL DEFAULT 30,
  `bs_options` varchar(255) NOT NULL DEFAULT '',
  `bs_active` tinyint(4) NOT NULL DEFAULT 1,
  `bs_sort` int(11) NOT NULL DEFAULT 0,
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`bs_id`),
  KEY `index_theme_lang` (`bs_theme`,`bs_lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_board_skin_config`
--

LOCK TABLES `g5_plugin_board_skin_config` WRITE;
/*!40000 ALTER TABLE `g5_plugin_board_skin_config` DISABLE KEYS */;
INSERT INTO `g5_plugin_board_skin_config` VALUES ('2','corporate_light','kr','chamcode_gallery','','theme/gallery_editorial','gallery',4,'4x3','','',4,30,'',1,0,'2026-01-12 11:37:52'),('corporate_light_product','corporate_light','kr','Portfolio','','theme/webzine','webzine',2,'4x3','','',4,30,'',1,0,'2026-01-15 08:56:29');
/*!40000 ALTER TABLE `g5_plugin_board_skin_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_company_add`
--

DROP TABLE IF EXISTS `g5_plugin_company_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_company_add` (
  `co_id` varchar(100) NOT NULL,
  `co_theme` varchar(100) NOT NULL,
  `co_lang` varchar(20) NOT NULL,
  `co_subject` varchar(255) NOT NULL DEFAULT '',
  `co_content` mediumtext NOT NULL,
  `co_skin` varchar(50) NOT NULL DEFAULT '',
  `co_bgcolor` varchar(20) NOT NULL DEFAULT '#000000',
  `co_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`co_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_company_add`
--

LOCK TABLES `g5_plugin_company_add` WRITE;
/*!40000 ALTER TABLE `g5_plugin_company_add` DISABLE KEYS */;
INSERT INTO `g5_plugin_company_add` VALUES ('kukdong_panel','kukdong_panel','','메인지도','<div align=\"\" style=\"\"><!-- [Infrastructure] Main Map Premium Skin - Standardized -->\r\n<meta charset=\"utf-8\">\r\n<style>\r\n    .ci-skin-wrapper.main-map-section {\r\n        width: 100%;\r\n        max-width: 100%;\r\n        margin: 0 auto;\r\n        padding: var(--spacing-section, 15vh) 0;\r\n        box-sizing: border-box;\r\n        background-color: transparent;\r\n    }\r\n\r\n    /* 1. Full Width Map Container */\r\n    .location-map-wrap {\r\n        width: 100%;\r\n        height: 600px !important;\r\n        background: var(--color-bg-dark, #121212);\r\n        position: relative;\r\n        overflow: hidden;\r\n    }\r\n\r\n    /* Map Element */\r\n    #root_daum_roughmap {\r\n        width: 100%;\r\n        height: 100%;\r\n        filter: grayscale(20%) contrast(105%);\r\n    }\r\n\r\n    /* Header Standards (Typography Protocol) */\r\n    .section-header {\r\n        margin-bottom: 60px;\r\n    }\r\n\r\n    .main-map-header .section-title {\r\n        color: var(--color-title-main, #d4af37);\r\n        font-family: var(--font-heading);\r\n        font-size: 3rem;\r\n        margin-bottom: 15px;\r\n        font-weight: 800;\r\n        text-transform: uppercase;\r\n        letter-spacing: 0.1em;\r\n    }\r\n\r\n    .main-map-header .section-subtitle {\r\n        color: var(--color-text-secondary, #666);\r\n        font-size: 1.1rem;\r\n        margin-top: 5px;\r\n        letter-spacing: 0.2em;\r\n        text-transform: uppercase;\r\n    }\r\n\r\n    /* Map Header Info Block (Data Bound) */\r\n    .main-map-info-wrap {\r\n        margin-top: 40px;\r\n        color: var(--color-text-primary);\r\n        font-size: 0.95rem;\r\n        line-height: 1.8;\r\n    }\r\n\r\n    .main-map-info-item {\r\n        margin-bottom: 8px;\r\n        opacity: 0.9;\r\n    }\r\n\r\n    .main-map-info-item strong {\r\n        color: var(--color-accent-gold);\r\n        margin-right: 12px;\r\n        font-weight: 700;\r\n        text-transform: uppercase;\r\n        font-size: 0.8rem;\r\n        letter-spacing: 0.1em;\r\n    }\r\n\r\n    .main-map-info-divider {\r\n        margin: 0 15px;\r\n        opacity: 0.3;\r\n        color: var(--color-text-secondary);\r\n    }\r\n\r\n    /* Responsive */\r\n    @media (max-width: 768px) {\r\n        .ci-skin-wrapper.main-map-section {\r\n            padding: 10vh 0;\r\n        }\r\n\r\n        .location-map-wrap {\r\n            height: 450px !important;\r\n        }\r\n    }\r\n</style>\r\n\r\n<div class=\"ci-skin-wrapper main-map-section\">\r\n    <!-- Header: Consistent with Main Sections -->\r\n    <div class=\"section-header\">\r\n        <h2 class=\"section-title\">LOCATION</h2>\r\n        <p class=\"section-subtitle\">오시는 길</p>\r\n\r\n        <!-- [Standardized] Data Binding via Copyright Manager Placeholders -->\r\n        <div class=\"main-map-info-wrap\">\r\n            <div class=\"main-map-info-item\">\r\n                <strong>ADD</strong> <span>{CP_ADDRESS}</span>\r\n            </div>\r\n            <div class=\"main-map-info-item\">\r\n                <strong>Tel</strong> <span>{CP_TEL}</span>\r\n                <span class=\"main-map-info-divider\">/</span>\r\n                <strong>FAX</strong> <span>{CP_FAX}</span>\r\n            </div>\r\n        </div>\r\n    </div>\r\n\r\n    <!-- Map Area: Full Bleed Concept -->\r\n    <div class=\"location-map-wrap\">\r\n        {MAP_API_DISPLAY}\r\n    </div>\r\n</div></div><p><br></p>','main_map','','2026-03-16 14:37:54'),('kukdong_panel_CEO','kukdong_panel','kr','CEO인사말','<div align=\"\" style=\"\"><style>\r\n    /* \r\n     * Type C: Vertical Cinematic Design (Visionary)\r\n     * Standardized for Theme Compatibility\r\n     */\r\n\r\n    /* [Standard] Wrapper Pattern */\r\n    .ci-skin-wrapper {\r\n        width: 100%;\r\n        max-width: var(--spacing-container, 1200px);\r\n        margin: 0 auto;\r\n        padding: var(--spacing-section, 60px) 20px;\r\n        box-sizing: border-box;\r\n        text-align: center;\r\n    }\r\n\r\n    /* 1. Vertical Header */\r\n    .ci-skin-wrapper .vertical-header .section-title {\r\n        font-size: 3.2rem;\r\n        font-weight: 800;\r\n        color: var(--color-text-primary);\r\n        margin-bottom: 15px;\r\n        line-height: 1.1;\r\n        font-family: var(--font-heading, sans-serif);\r\n    }\r\n\r\n    .ci-skin-wrapper .vertical-header .section-subtitle {\r\n        color: var(--color-text-secondary, #666);\r\n        font-size: 1.1rem;\r\n        font-weight: 600;\r\n        letter-spacing: 0.1em;\r\n        text-transform: uppercase;\r\n        margin-bottom: 0;\r\n    }\r\n\r\n    /* Decorative Line */\r\n    .ci-skin-wrapper .vertical-header::after {\r\n        content: \'\';\r\n        display: block;\r\n        width: 60px;\r\n        height: 4px;\r\n        /* Map to Accent for consistency */\r\n        background: var(--color-accent-gold, #d4af37);\r\n        margin: 20px auto 0;\r\n        border-radius: 2px;\r\n    }\r\n\r\n    /* 2. Cinematic Image */\r\n    .ci-skin-wrapper .cinema-image {\r\n        width: 100%;\r\n        height: 400px;\r\n        margin-bottom: 60px;\r\n        border-radius: 20px;\r\n        overflow: hidden;\r\n        position: relative;\r\n        box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.5);\r\n    }\r\n\r\n    .ci-skin-wrapper .cinema-image img {\r\n        width: 100%;\r\n        height: 100%;\r\n        object-fit: cover;\r\n        transition: transform 0.7s ease;\r\n        display: block;\r\n    }\r\n\r\n    .ci-skin-wrapper .cinema-image:hover img {\r\n        transform: scale(1.05);\r\n    }\r\n\r\n    /* Overlay Gradient */\r\n    .ci-skin-wrapper .cinema-image::after {\r\n        content: \'\';\r\n        position: absolute;\r\n        bottom: 0;\r\n        left: 0;\r\n        width: 100%;\r\n        height: 50%;\r\n        background: linear-gradient(to top, var(--color-bg-dark, #1c1c1c) 0%, transparent 100%);\r\n        opacity: 0.8;\r\n    }\r\n\r\n    /* 3. Main Text Block - Container */\r\n    .ci-skin-wrapper .main-text {\r\n        max-width: 800px;\r\n        margin: 0 auto 80px;\r\n    }\r\n\r\n    .ci-skin-wrapper .intro-text {\r\n        font-size: 1.15rem;\r\n        color: var(--color-text-secondary);\r\n        line-height: 1.8;\r\n        margin-bottom: 20px;\r\n    }\r\n\r\n    .ci-skin-wrapper .intro-text strong {\r\n        color: var(--color-text-primary);\r\n        font-weight: 600;\r\n    }\r\n\r\n    /* 4. Three Column Features */\r\n    .ci-skin-wrapper .feature-grid {\r\n        display: grid;\r\n        grid-template-columns: repeat(3, 1fr);\r\n        gap: 30px;\r\n        text-align: left;\r\n    }\r\n\r\n    .ci-skin-wrapper .feature-card {\r\n        background: var(--color-bg-panel, #f8fafc);\r\n        padding: 40px 30px;\r\n        border-radius: 12px;\r\n        transition: transform 0.3s ease, box-shadow 0.3s ease;\r\n        position: relative;\r\n        overflow: hidden;\r\n        border-top: 1px solid var(--color-border, rgba(255, 255, 255, 0.05));\r\n    }\r\n\r\n    .ci-skin-wrapper .feature-card:hover {\r\n        transform: translateY(-10px);\r\n        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);\r\n        border-top: 1px solid var(--color-accent-gold, #d4af37);\r\n    }\r\n\r\n    .ci-skin-wrapper .feature-icon {\r\n        font-size: 2.5rem;\r\n        margin-bottom: 20px;\r\n        /* Dynamic Gradient based on Theme Accent */\r\n        background: linear-gradient(135deg, var(--color-accent-gold, #d4af37) 0%, #a08020 100%);\r\n        -webkit-background-clip: text;\r\n        background-clip: text;\r\n        -webkit-text-fill-color: transparent;\r\n        display: inline-block;\r\n        font-weight: 700;\r\n        font-family: var(--font-heading, sans-serif);\r\n    }\r\n\r\n    .ci-skin-wrapper .feature-card h3 {\r\n        font-size: 1.4rem;\r\n        color: var(--color-text-primary);\r\n        margin-bottom: 15px;\r\n        font-weight: 700;\r\n        font-family: var(--font-heading, sans-serif);\r\n    }\r\n\r\n    .ci-skin-wrapper .feature-card p {\r\n        font-size: 0.95rem;\r\n        color: var(--color-text-secondary, #666);\r\n        line-height: 1.6;\r\n    }\r\n\r\n    /* Responsive */\r\n    @media (max-width: 768px) {\r\n        .ci-skin-wrapper .feature-grid {\r\n            grid-template-columns: 1fr;\r\n        }\r\n\r\n        .ci-skin-wrapper .cinema-image {\r\n            height: 250px;\r\n        }\r\n    }\r\n</style>\r\n\r\n<div class=\"ci-skin-wrapper\">\r\n    <!-- 1. Header -->\r\n    <div class=\"vertical-header\" data-aos=\"fade-up\">\r\n        <p class=\"section-subtitle\">Company Overview</p>\r\n        <h2 class=\"section-title\">Master of Panel Solution</h2>\r\n    </div>\r\n\r\n    <!-- 2. Image -->\r\n    <div class=\"cinema-image\" data-aos=\"zoom-in\" data-aos-delay=\"200\">\r\n        <img src=\"https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&amp;w=2069&amp;auto=format&amp;fit=crop\" alt=\"Company Office\">\r\n    </div>\r\n\r\n    <!-- 3. Text -->\r\n    <div class=\"main-text\" data-aos=\"fade-up\" data-aos-delay=\"400\">\r\n        <!-- ADDED CLASS .intro-text HERE -->\r\n        <p class=\"intro-text\"><b>\r\n      극동판넬(주)</b>는 엄격한 공정 관리로 고품질의 제품을 생산하는 우수한 기업입니다.\r\n<br>홈페이지 방문을 진심으로 환영합니다.\r\n\r\n        </p>\r\n        <p class=\"intro-text\" style=\"margin-top:20px; font-size:1rem; color:var(--color-text-secondary);\">\r\n빠르게 변화하는 21세기에 더욱 풍요로운 인간 생활을 위해\r\n우리는 또 다시 새로운 건축문화 발전을 위해<br>&nbsp;도전을 시도해야 합니다.\r\n        </p>\r\n      <p class=\"intro-text\" style=\"margin-top:20px; font-size:1rem; color:var(--color-text-secondary);\">\r\n과거의 건축물이 공간 제공의 기능이었다고 한다면 현대 건축물의 주기능은 효과적인 공간 활용, 기능성 경제성\r\n그리고 미적 감각이 고려되어야 합니다. 이에 극동판넬(주)는 전 직원은 엄격한 자재 생산과 공정관리로\r\n<br>풍요로운 신 주거문화 창조에 이바지 할 것입니다.\r\n        </p>\r\n      <p class=\"intro-text\" style=\"margin-top:20px; font-size:1rem; color:var(--color-text-secondary);\">\r\n고객 여러분의 성원이 있었기에 극동판넬(주)가 있었다는 것을 명심하며\r\n더욱 더 노력하는 모습으로 <br>고객 여러분들과 함께 하겠습니다.\r\n        <br><br><strong style=\"text-align: center; font-family: &quot;Noto Sans KR&quot;, sans-serif; display: block; padding-bottom: 15px; font-size: 19px; line-height: 29px; color: rgb(51, 51, 51);\">대표이사 전영주</strong></p>\r\n     \r\n    </div>\r\n\r\n    <!-- 4. Features (Business Areas) -->\r\n    <div class=\"feature-grid\">\r\n        <!-- Card 1 -->\r\n        <div class=\"feature-card\" data-aos=\"fade-up\" data-aos-delay=\"500\"><div style=\"text-align: left;\"> <div class=\"feature-icon\">01</div></div>\r\n            <h3>Analysis &amp; Solution</h3>\r\n            <p>공간의 목적을 분석하고 최적의 패널 솔루션을 제안합니다.</p>\r\n        </div>\r\n        <!-- Card 2 -->\r\n        <div class=\"feature-card\" data-aos=\"fade-up\" data-aos-delay=\"600\">\r\n            <div class=\"feature-icon\">02</div>\r\n            <h3>Precision Engineering</h3>\r\n            <p>정밀한 설계와 고품질 자재로 빈틈없는 건축을 실현합니다.</p>\r\n        </div>\r\n        <!-- Card 3 -->\r\n        <div class=\"feature-card\" data-aos=\"fade-up\" data-aos-delay=\"700\">\r\n            <div class=\"feature-icon\">03</div>\r\n            <h3>Total Care Service</h3>\r\n            <p>공 후에도 체계적인 사후 관리를 통해 최상의 상태를 유지합니다.</p>\r\n        </div>\r\n    </div>\r\n</div></div><p><br></p>','type_c','#ffffff','2026-03-17 13:31:48'),('kukdong_panel_certificate','kukdong_panel','kr','인증서&시험성적서','<style>\r\n    /* Certificate Type A - Grid Gallery (Smart Inherited)\r\n     * Standardized for Theme Compatibility\r\n     */\r\n\r\n    /* [Standard] Wrapper Pattern */\r\n    .ci-skin-wrapper {\r\n        width: 100%;\r\n        max-width: var(--spacing-container, 1200px);\r\n        margin: 0 auto;\r\n        padding: var(--spacing-section, 60px) 20px;\r\n        box-sizing: border-box;\r\n    }\r\n\r\n    /* Header - Center Style (matches Type C & Timelines) */\r\n    .ci-skin-wrapper .section-header {\r\n        text-align: center;\r\n        margin-bottom: 50px;\r\n    }\r\n\r\n    /* Bottom Gold Bar */\r\n    .ci-skin-wrapper .section-header::after {\r\n        content: \'\';\r\n        display: block;\r\n        width: 60px;\r\n        height: 4px;\r\n        background: var(--color-accent-gold, #d4af37);\r\n        margin: 20px auto 0;\r\n        border-radius: 2px;\r\n    }\r\n\r\n    .ci-skin-wrapper .section-header h2 {\r\n        /* Section Title Rule: Accent Color */\r\n        color: var(--color-accent-gold, #d4af37);\r\n        font-family: var(--font-heading);\r\n        font-size: 2.5rem;\r\n        margin-bottom: 1rem;\r\n        font-weight: 700;\r\n    }\r\n\r\n    .ci-skin-wrapper .section-header p {\r\n        color: var(--color-text-secondary);\r\n        justify-content: center;\r\n    }\r\n\r\n    .cert-grid {\r\n        display: grid;\r\n        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));\r\n        gap: 30px;\r\n    }\r\n\r\n    .cert-item {\r\n        background: var(--color-bg-panel, #1e1e1e);\r\n        border: 1px solid var(--color-border, rgba(255, 255, 255, 0.1));\r\n        padding: 20px;\r\n        text-align: center;\r\n        border-radius: 12px;\r\n        transition: transform 0.3s, border-color 0.3s;\r\n    }\r\n\r\n    .cert-item:hover {\r\n        transform: translateY(-5px);\r\n        border-color: var(--color-accent-gold, #d4af37);\r\n    }\r\n\r\n    .cert-img-wrap {\r\n        width: 100%;\r\n        aspect-ratio: 3/4;\r\n        background: rgba(0, 0, 0, 0.2);\r\n        margin-bottom: 20px;\r\n        overflow: hidden;\r\n        position: relative;\r\n        border-radius: 4px;\r\n        border: 1px solid rgba(255, 255, 255, 0.05);\r\n    }\r\n\r\n    .cert-img-wrap img {\r\n        width: 100%;\r\n        height: 100%;\r\n        object-fit: contain;\r\n        padding: 10px;\r\n        box-sizing: border-box;\r\n        transition: transform 0.3s;\r\n    }\r\n\r\n    .cert-item:hover .cert-img-wrap img {\r\n        transform: scale(1.05);\r\n    }\r\n\r\n    .cert-title {\r\n        font-size: 1.1rem;\r\n        font-weight: 700;\r\n        color: var(--color-text-primary);\r\n        margin: 10px 0 5px;\r\n        font-family: var(--font-heading);\r\n    }\r\n\r\n    .cert-desc {\r\n        font-size: 0.9rem;\r\n        color: var(--color-text-secondary);\r\n    }\r\n</style>\r\n\r\n<div class=\"ci-skin-wrapper\">\r\n    <div class=\"section-header text-center mb-5\">\r\n        <h2>CERTIFICATES</h2>\r\n        <p>기술력과 품질을 인증받은 기업입니다.</p>\r\n    </div>\r\n\r\n    <div class=\"cert-grid\">\r\n        <!-- Item 1 -->\r\n        <div class=\"cert-item\" data-aos=\"fade-up\">\r\n            <div class=\"cert-img-wrap\">\r\n                <img src=\"https://plus.unsplash.com/premium_photo-1661331773030-349071aafe25?q=80&amp;w=600&amp;auto=format&amp;fit=crop\" alt=\"ISO 9001\">\r\n            </div>\r\n            <h3 class=\"cert-title\">ISO 9001</h3>\r\n            <p class=\"cert-desc\">품질경영시스템 인증</p>\r\n        </div>\r\n\r\n        <!-- Item 2 -->\r\n        <div class=\"cert-item\" data-aos=\"fade-up\" data-aos-delay=\"100\">\r\n            <div class=\"cert-img-wrap\">\r\n                <img src=\"https://plus.unsplash.com/premium_photo-1661391983057-047b74f39ce2?q=80&amp;w=600&amp;auto=format&amp;fit=crop\" alt=\"ISO 14001\">\r\n            </div>\r\n            <h3 class=\"cert-title\">ISO 14001</h3>\r\n            <p class=\"cert-desc\">환경경영시스템 인증</p>\r\n        </div>\r\n\r\n        <!-- Item 3 -->\r\n        <div class=\"cert-item\" data-aos=\"fade-up\" data-aos-delay=\"200\">\r\n            <div class=\"cert-img-wrap\">\r\n                <img src=\"https://images.unsplash.com/photo-1635350736475-c8cef4b21906?q=80&amp;w=600&amp;auto=format&amp;fit=crop\" alt=\"Venture\">\r\n            </div>\r\n            <h3 class=\"cert-title\">벤처기업 인증</h3>\r\n            <p class=\"cert-desc\">혁신성장유형</p>\r\n        </div>\r\n\r\n        <!-- Item 4 -->\r\n        <div class=\"cert-item\" data-aos=\"fade-up\" data-aos-delay=\"300\">\r\n            <div class=\"cert-img-wrap\">\r\n                <img src=\"https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&amp;w=600&amp;auto=format&amp;fit=crop\" alt=\"Patent\">\r\n            </div>\r\n            <h3 class=\"cert-title\">특허증</h3>\r\n            <p class=\"cert-desc\">기술 특허 등록</p>\r\n        </div>\r\n    </div>\r\n</div><p><br></p>','cert_a','#ffffff','2026-03-17 13:36:44');
/*!40000 ALTER TABLE `g5_plugin_company_add` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_copyright`
--

DROP TABLE IF EXISTS `g5_plugin_copyright`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_copyright` (
  `cp_id` varchar(20) NOT NULL DEFAULT '',
  `cp_subject` varchar(255) NOT NULL DEFAULT '',
  `logo_url` varchar(255) NOT NULL DEFAULT '',
  `addr_label` varchar(50) NOT NULL DEFAULT '주소',
  `addr_val` varchar(255) NOT NULL DEFAULT '',
  `tel_label` varchar(50) NOT NULL DEFAULT '연락처',
  `tel_val` varchar(255) NOT NULL DEFAULT '',
  `fax_label` varchar(50) NOT NULL DEFAULT '팩스',
  `fax_val` varchar(255) NOT NULL DEFAULT '',
  `email_label` varchar(50) NOT NULL DEFAULT '이메일',
  `email_val` varchar(255) NOT NULL DEFAULT '',
  `slogan` text NOT NULL,
  `copyright` text NOT NULL,
  `link1_name` varchar(100) NOT NULL DEFAULT '',
  `link1_url` varchar(255) NOT NULL DEFAULT '',
  `link2_name` varchar(100) NOT NULL DEFAULT '',
  `link2_url` varchar(255) NOT NULL DEFAULT '',
  `cp_content` mediumtext NOT NULL,
  `cp_skin` varchar(50) NOT NULL DEFAULT 'style_a',
  `cp_bgcolor` varchar(20) NOT NULL DEFAULT '',
  `cp_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `company_label` varchar(50) NOT NULL DEFAULT '상호',
  `company_val` varchar(255) NOT NULL DEFAULT '',
  `ceo_label` varchar(50) NOT NULL DEFAULT '대표자',
  `ceo_val` varchar(255) NOT NULL DEFAULT '',
  `bizno_label` varchar(50) NOT NULL DEFAULT '사업자등록번호',
  `bizno_val` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`cp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_copyright`
--

LOCK TABLES `g5_plugin_copyright` WRITE;
/*!40000 ALTER TABLE `g5_plugin_copyright` DISABLE KEYS */;
INSERT INTO `g5_plugin_copyright` VALUES ('default','기본 카피라이트','http://localhost/data/common/footer_logo.png','ADD','경기도 파주시 광탄면 분수3리 94-7 ','Tel','031-943-65581','FAX','031-943-6558','EMAIL','phofler@gmail.com','LET\'S TALK.','Copyright © All rights reserved.','Privacy Policy','http://localhost/bbs/content.php?co_id=company&me_code=1010','Contact Us','http://localhost/bbs/content.php?co_id=company&me_code=1010','<style>\r\n    /* Style B: Modern Split Premium */\r\n    .footer-skin-b {\r\n        padding: 100px 0;\r\n        background-color: var(--cp-bg, #1a1a1a);\r\n        color: #eee;\r\n        /* border: 2px dashed #3498db; Removed per user request */\r\n        margin: 20px 0;\r\n    }\r\n\r\n    .footer-skin-b .footer-container {\r\n        max-width: 1200px;\r\n        margin: 0 auto;\r\n        padding: 0 20px;\r\n        display: flex;\r\n        justify-content: space-between;\r\n        align-items: flex-start;\r\n        gap: 60px;\r\n    }\r\n\r\n    .footer-skin-b .footer-left {\r\n        flex: 1;\r\n    }\r\n\r\n    .footer-skin-b .footer-right {\r\n        flex: 1.5;\r\n    }\r\n\r\n    .footer-skin-b .footer-logo {\r\n        margin-bottom: 30px;\r\n    }\r\n\r\n    .footer-skin-b .footer-logo img {\r\n        height: 45px;\r\n        object-fit: contain;\r\n    }\r\n\r\n    .footer-skin-b .footer-links {\r\n        display: flex;\r\n        gap: 20px;\r\n        margin-bottom: 30px;\r\n    }\r\n\r\n    .footer-skin-b .footer-links a {\r\n        color: #999;\r\n        font-size: 0.9rem;\r\n        text-decoration: none;\r\n    }\r\n\r\n    .footer-skin-b .footer-copyright {\r\n        font-size: 0.85rem;\r\n        color: rgba(255, 255, 255, 0.3);\r\n    }\r\n\r\n    .footer-skin-b .footer-contact-grid {\r\n        display: flex;\r\n        flex-direction: column;\r\n        gap: 25px;\r\n    }\r\n\r\n    .footer-skin-b .info-item {\r\n        display: flex;\r\n        align-items: center;\r\n        gap: 15px;\r\n    }\r\n\r\n    .footer-skin-b .info-item.label-top {\r\n        flex-direction: row;\r\n        /* Changed from column to row */\r\n        align-items: center;\r\n        /* Changed from flex-start */\r\n        gap: 15px;\r\n        /* Matched gap with other info-items */\r\n    }\r\n\r\n    .footer-skin-b .value {\r\n        color: #eee;\r\n        font-size: 1rem;\r\n    }\r\n\r\n    .footer-skin-b .value a {\r\n        color: inherit;\r\n        text-decoration: none;\r\n    }\r\n\r\n    .footer-skin-b .value a:hover {\r\n        text-decoration: underline;\r\n    }\r\n\r\n    .footer-skin-b .contact-flex {\r\n        display: flex;\r\n        gap: 20px;\r\n        padding-top: 20px;\r\n        border-top: 1px solid rgba(255, 255, 255, 0.05);\r\n    }\r\n</style>\r\n\r\n<div class=\"footer-skin-b\" style=\"background-color: rgb(255, 255, 255);\">\r\n    <div class=\"footer-container\">\r\n        <div class=\"footer-left\">\r\n            <div class=\"footer-logo\">\r\n                <img src=\"http://localhost/data/common/footer_logo.png\" class=\"footer-logo\">\r\n            </div>\r\n            <div class=\"footer-links\">\r\n                <a href=\"http://localhost/bbs/content.php?co_id=company&amp;me_code=1010\">Privacy Policy</a>\r\n                <a href=\"http://localhost/bbs/content.php?co_id=company&amp;me_code=1010\">Contact Us</a>\r\n            </div>\r\n            <div class=\"footer-copyright\">\r\n                Copyright © All rights reserved.\r\n            </div>\r\n        </div>\r\n\r\n        <div class=\"footer-right\">\r\n            <div class=\"footer-contact-grid\">\r\n                <div class=\"info-item label-top\">\r\n                    <span class=\"label\">ADD</span>\r\n                    <span class=\"value\">경기도 파주시 광탄면 분수3리 94-7 </span>\r\n                </div>\r\n                <div class=\"contact-flex\">\r\n                    <div class=\"info-item\">\r\n                        <span class=\"label\">Tel</span>\r\n                        <span class=\"value\"><a href=\"tel:031-943-65581\">031-943-65581</a></span>\r\n                    </div>\r\n                    <div class=\"info-item\">\r\n                        <span class=\"label\">FAX</span>\r\n                        <span class=\"value\">031-943-6558</span>\r\n                    </div>\r\n                    <div class=\"info-item\">\r\n                        <span class=\"label\">EMAIL</span>\r\n                        <span class=\"value\"><a href=\"mailto:phofler@gmail.com\">phofler@gmail.com</a></span>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>','style_b','#ffffff','2026-03-16 12:45:35','상호','','대표자','','사업자등록번호',''),('kukdong_panel','극동카피라이트','http://localhost/data/common/footer_logo_kukdong_panel.png','주소','경기도 남양주시 진접읍 양진로926번길 14','대표번호','1551-9123','팩스','1551-9123','이메일','dearceo@naver.com','LET\'S TALK.','Copyright © KUKDONGPANEL.,LTD All rights reserved.','','','','','<style>\r\n    /* Style B: Modern Split Premium */\r\n    .footer-skin-b {\r\n        padding: 80px 0;\r\n        background-color: var(--cp-bg, #ffffff);\r\n        color: #333;\r\n        margin: 20px 0;\r\n    }\r\n\r\n    .footer-skin-b .footer-container {\r\n        max-width: 1200px;\r\n        margin: 0 auto;\r\n        padding: 0 20px;\r\n        display: flex;\r\n        justify-content: space-between;\r\n        align-items: flex-start;\r\n        gap: 60px;\r\n    }\r\n\r\n    .footer-skin-b .footer-left {\r\n        flex: 1;\r\n    }\r\n\r\n    .footer-skin-b .footer-right {\r\n        flex: 1.5;\r\n    }\r\n\r\n    .footer-skin-b .footer-logo {\r\n        margin-bottom: 30px;\r\n    }\r\n\r\n    .footer-skin-b .footer-logo img {\r\n        height: 45px;\r\n        object-fit: contain;\r\n    }\r\n\r\n    .footer-skin-b .footer-links {\r\n        display: flex;\r\n        gap: 20px;\r\n        margin-bottom: 30px;\r\n    }\r\n\r\n    .footer-skin-b .footer-links a {\r\n        font-size: 0.95rem;\r\n        color: #333;\r\n        font-weight: 500;\r\n        text-decoration: none;\r\n    }\r\n\r\n    .footer-skin-b .footer-copyright {\r\n        font-size: 0.85rem;\r\n        color: #999;\r\n    }\r\n\r\n    .footer-skin-b .footer-contact-grid {\r\n        display: grid;\r\n        gap: 20px;\r\n    }\r\n\r\n    .footer-skin-b .info-item {\r\n        font-size: 0.9rem;\r\n    }\r\n\r\n    .footer-skin-b .label {\r\n        display: block;\r\n        font-size: 0.75rem;\r\n        text-transform: uppercase;\r\n        color: #999;\r\n        margin-bottom: 5px;\r\n    }\r\n\r\n    .footer-skin-b .value {\r\n        font-weight: 500;\r\n    }\r\n\r\n    .footer-skin-b .contact-flex {\r\n        display: flex;\r\n        gap: 40px;\r\n        flex-wrap: wrap;\r\n    }\r\n</style>\r\n\r\n<div class=\"footer-skin-b\" style=\"background-color: rgb(18, 18, 18);\">\r\n    <div class=\"footer-container\">\r\n        <div class=\"footer-left\">\r\n            <div class=\"footer-logo\">\r\n                <img src=\"http://localhost/data/common/footer_logo_kukdong_panel.png\" class=\"footer-logo\">\r\n            </div>\r\n            <div class=\"footer-links\">\r\n                \r\n                \r\n            </div>\r\n            <div class=\"footer-copyright\">\r\n                Copyright © KUKDONGPANEL.,LTD All rights reserved.\r\n            </div>\r\n        </div>\r\n\r\n        <div class=\"footer-right\">\r\n            <div class=\"footer-contact-grid\">\r\n                <div class=\"info-item label-top\" style=\"margin-bottom:10px; border-bottom:1px solid rgba(0,0,0,0.05); padding-bottom:15px;\">\r\n                    <span class=\"value\" style=\"font-weight:700; font-size:1.1rem;\">{company}</span>\r\n                    <span class=\"value\" style=\"margin-left:20px;\"><span class=\"label\" style=\"display:inline; margin-right:5px;\">{ceo_name}</span> {ceo}</span>\r\n                    <span class=\"value\" style=\"margin-left:20px;\"><span class=\"label\" style=\"display:inline; margin-right:5px;\">{bizno_name}</span> {bizno}</span>\r\n                </div>\r\n                <div class=\"info-item label-top\">\r\n                    <span class=\"label\">주소</span>\r\n                    <span class=\"value\">경기도 남양주시 진접읍 양진로926번길 14</span>\r\n                </div>\r\n                <div class=\"contact-flex\">\r\n                    <div class=\"info-item\">\r\n                        <span class=\"label\">대표번호</span>\r\n                        <span class=\"value\"><a href=\"tel:1551-9123\">1551-9123</a></span>\r\n                    </div>\r\n                    <div class=\"info-item\">\r\n                        <span class=\"label\">팩스</span>\r\n                        <span class=\"value\">1551-9123</span>\r\n                    </div>\r\n                    <div class=\"info-item\">\r\n                        <span class=\"label\">이메일</span>\r\n                        <span class=\"value\"><a href=\"mailto:humdanhouse@naver.com\">humdanhouse@naver.com</a></span>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n        </div>\r\n    </div>\r\n</div>','style_b','#121212','2026-03-17 11:01:43','COMPANY','극동판넬공업(주)','대표','전영주','사업자등록번호','132-81-27509');
/*!40000 ALTER TABLE `g5_plugin_copyright` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_latest_skin_config`
--

DROP TABLE IF EXISTS `g5_plugin_latest_skin_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_latest_skin_config` (
  `ls_id` int(11) NOT NULL AUTO_INCREMENT,
  `ls_theme` varchar(50) NOT NULL DEFAULT 'corporate',
  `ls_lang` varchar(10) NOT NULL DEFAULT 'ko',
  `ls_title` varchar(255) NOT NULL DEFAULT '',
  `ls_more_link` varchar(255) NOT NULL DEFAULT '',
  `ls_description` text NOT NULL DEFAULT '',
  `ls_skin` varchar(255) NOT NULL DEFAULT 'theme/basic',
  `ls_bo_table` varchar(50) NOT NULL DEFAULT '',
  `ls_count` int(11) NOT NULL DEFAULT 4,
  `ls_subject_len` int(11) NOT NULL DEFAULT 30,
  `ls_options` varchar(255) NOT NULL DEFAULT '',
  `ls_active` tinyint(4) NOT NULL DEFAULT 1,
  `ls_sort` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ls_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_latest_skin_config`
--

LOCK TABLES `g5_plugin_latest_skin_config` WRITE;
/*!40000 ALTER TABLE `g5_plugin_latest_skin_config` DISABLE KEYS */;
INSERT INTO `g5_plugin_latest_skin_config` VALUES (3,'corporate','kr','chamcode_gallery1','bbs/board.php?bo_table=chamcode_gallery&me_code=3030','111111','theme/works_dark','chamcode_gallery',8,30,'main_chamcode_gallery',1,0),(4,'corporate_light','kr','Selected Works','/bbs/board.php?bo_table=chamcode_gallery&me_code=3030','','clean_notice','chamcode_gallery',8,30,'',1,0),(5,'kukdong_panel','kr','공지사항','/bbs/board.php?bo_table=news&me_code=3030','','clean_notice','news',4,30,'',1,1),(6,'kukdong_panel','kr','자료실','/bbs/board.php?bo_table=dataroom&me_code=3030','','clean_notice','dataroom',4,30,'',1,0),(7,'kukdong_panel','kr','Best Products','','?���?? ???? ???? ã?? ?????? ????Ʈ????','theme/kukdong_best','product',4,30,'',1,2);
/*!40000 ALTER TABLE `g5_plugin_latest_skin_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_main_content`
--

DROP TABLE IF EXISTS `g5_plugin_main_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_main_content` (
  `mc_id` int(11) NOT NULL AUTO_INCREMENT,
  `ms_id` int(11) NOT NULL DEFAULT 0,
  `mc_style` varchar(50) NOT NULL DEFAULT 'A',
  `mc_sort` int(11) NOT NULL DEFAULT 0,
  `mc_image` varchar(255) NOT NULL DEFAULT '',
  `mc_title` varchar(255) NOT NULL DEFAULT '',
  `mc_desc` text NOT NULL DEFAULT '',
  `mc_link` varchar(255) NOT NULL DEFAULT '',
  `mc_target` varchar(20) NOT NULL DEFAULT '',
  `mc_tag` varchar(50) NOT NULL DEFAULT '',
  `mc_subtitle` varchar(255) NOT NULL DEFAULT '',
  `mc_link_text` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`mc_id`),
  KEY `ms_id` (`ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_main_content`
--

LOCK TABLES `g5_plugin_main_content` WRITE;
/*!40000 ALTER TABLE `g5_plugin_main_content` DISABLE KEYS */;
INSERT INTO `g5_plugin_main_content` VALUES (1,0,'A',1,'https://images.unsplash.com/photo-1580273916550-e323be2ae537?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxfHwlRUMlOUUlOTAlRUIlOEYlOTklRUMlQjAlQTh8ZW58MHx8fHwxNzY2MzYzNzk5fDA&ixlib=rb-4.1.0&rect=42,572,2058,1542&q=80&fm=jpg&fit=crop&w=800&h=600','Innovation through Passion and Dedication','(주)르네상스 환경디자인산업은 1978년에 설립되었으며, \r\n\r\n저희는 차별화된 특수자동게이트, 썬큰, 오버헤드도어, 특수 계단구조물, 주물 게이트, 알루미늄 주물 휀스, 단조난간, 화분대, 방범창 등 특화된 금속 구조물을 전문적으로 다루고 있습니다.','/bbs/content.php?co_id=company&me_code=1010','','','',''),(2,0,'B',1,'https://images.unsplash.com/photo-1484291470158-b8f8d608850d?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw1fHwlRUIlQjAlOTQlRUIlOEIlQTR8ZW58MHx8fHwxNzY2MzYzMzk1fDA&ixlib=rb-4.1.0&rect=600,800,4800,2400&q=80&fm=jpg&fit=crop&w=1200&h=600','Innovation through Passion and Dedication1','Innovation through Passion and DedicationInnovation through Passion and DedicationInnovation through Passion and DedicationInnovation through Passion and Dedication1','bbs/content.php?co_id=company&me_code=1010','','','',''),(3,0,'C',1,'https://images.unsplash.com/photo-1554469384-e58fac16e23a?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw0fHwlRUElQjElQjQlRUIlQUMlQkN8ZW58MHx8fHwxNzY2Mjk5NzQ3fDA&ixlib=rb-4.1.0&rect=85,1563,3852,2889&q=80&fm=jpg&fit=crop&w=800&h=600','Innovation through1','(주)르네상스 환경디자인산업은 1978년에 설립되었으며, \r\n\r\n저희는 차별화된 특수자동게이트, 썬큰, 오버헤드도어, 특수 계단구조물, 주물 게이트, 알루미늄 주물 휀스, 단조난간, 화분대, 방범창 등 특화된 금속 구조물을 전문적으로 다루고 있습니다.\r\n','/bbs/content.php?co_id=company&me_code=1010','','','',''),(4,0,'A',2,'4_1766302034_11.jpg',' Innovation through Passion and Dedication','(주)르네상스 환경디자인산업은 1978년에 설립되었으며, 창조성 정확성 높은 수준의 품질과 마무리는 르네상스 환경디자인산업의 가장 중요한 사업 목표입니다.\r\n\r\n저희는 차별화된 특수자동게이트, 썬큰, 오버헤드도어, 특수 계단구조물, 주물 게이트, 알루미늄 주물 휀스, 단조난간, 화분대, 방범창 등 특화된 금속 구조물을 전문적으로 다루고 있습니다.','/bbs/content.php?co_id=company&me_code=1010','','','',''),(5,0,'B',2,'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw3fHwlRUIlODIlQTglRUMlOUUlOTB8ZW58MHx8fHwxNzY2MzAxMjQ2fDA&ixlib=rb-4.1.0&rect=37,594,2546,1910&q=80&fm=jpg&fit=crop&w=800&h=600','Innovation through Passion and Dedication','Innovation through Passion and DedicationInnovation through Passion and DedicationInnovation through Passion and Dedication','','','','',''),(6,0,'C',2,'https://images.unsplash.com/photo-1462396240927-52058a6a84ec?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw1fHwlRUElQjElQjQlRUIlQUMlQkN8ZW58MHx8fHwxNzY2Mjk5NzQ3fDA&ixlib=rb-4.1.0&rect=459,344,3674,2759&q=80&fm=jpg&fit=crop&w=800&h=600','ㅁㄻㅇㄹ','(주)르네상스 환경디자인산업은 1978년에 설립되었으며, \r\n\r\n저희는 차별화된 특수자동게이트, 썬큰, 오버헤드도어, 특수 계단구조물, 주물 게이트, 알루미늄 주물 휀스, 단조난간, 화분대, 방범창 등 특화된 금속 구조물을 전문적으로 다루고 있습니다.','','','','',''),(7,0,'A',3,'https://images.unsplash.com/photo-1443527394413-4b820fd08dde?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxOHx8JUVBJUIxJUI0JUVCJUFDJUJDfGVufDB8fHx8MTc2NjI5OTc0N3ww&ixlib=rb-4.1.0&rect=863,401,4289,3214&q=80&fm=jpg&fit=crop&w=800&h=600',' Innovation through Passion and Dedication','(주)르네상스 환경디자인산업은 1978년에 설립되었으며, 창조성 정확성 높은 수준의 품질과 마무리는 르네상스 환경디자인산업의 가장 중요한 사업 목표입니다.','','','','',''),(8,0,'B',3,'https://images.unsplash.com/photo-1554469384-e58fac16e23a?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw0fHwlRUElQjElQjQlRUIlQUMlQkN8ZW58MHx8fHwxNzY2Mjk5NzQ3fDA&ixlib=rb-4.1.0&rect=111,1211,3200,2400&q=80&fm=jpg&fit=crop&w=800&h=600','ㄴㅁㅈㄴㅇㄴㅇㄹㄹ','ㅁㄹㅇㅁㄻㄹ','','','','',''),(9,0,'C',3,'','','','','','','',''),(10,0,'A',4,'https://images.unsplash.com/photo-1514897575457-c4db467cf78e?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw2fHwlRUIlOEIlQUN8ZW58MHx8fHwxNzY2Mjk5NzcxfDA&ixlib=rb-4.1.0&rect=588,273,2920,2187&q=80&fm=jpg&fit=crop&w=800&h=600','ㅇㅁㅁㅇㅁ','ㅇㅁㅁㅇㅁㅇㅁㅁㅇㅁㅇㅁㅁㅇㅁ','','','','',''),(11,0,'B',4,'https://images.unsplash.com/photo-1462396240927-52058a6a84ec?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw1fHwlRUElQjElQjQlRUIlQUMlQkN8ZW58MHx8fHwxNzY2Mjk5NzQ3fDA&ixlib=rb-4.1.0&rect=208,157,4141,3108&q=80&fm=jpg&fit=crop&w=800&h=600','ㄻㄹㅇㅁㄹ','ㅁㄹㅇㅁㄻㄹ','','','','',''),(12,0,'C',4,'','','','','','','',''),(14,0,'A',5,'14_1766303256_11.jpg','ㅁㅇㅁㅇㅁ','ㅇㅁㅇㅁ','','','','',''),(15,0,'A',6,'','','','','','','',''),(16,0,'B',5,'https://images.unsplash.com/photo-1527576539890-dfa815648363?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxNHx8JUVBJUIxJUI0JUVCJUFDJUJDfGVufDB8fHx8MTc2NjI5OTc0N3ww&ixlib=rb-4.1.0&rect=399,1298,3195,2396&q=80&fm=jpg&fit=crop&w=800&h=600','ㄴㄹㄴㄹㄴㄹ','ㄴㄹㄴㄹㄴㄹ','','','','',''),(35,20,'A',1,'http://localhost/data/common_assets/kukdong_panel/asset_1773801001_4396.jpg','징크판넬','세련된 입체감과 칼라풀한 외관을 연출, 건축물의 품격을 높여주는 <strong>징크판넬</strong>! \r\n지붕과 벽체용으로 같이 사용할 수 있는 혼용 타입이며 강력한 클립의 결합으로 별도의 지붕캡이 필요 없는 혁신적인 외장재입니다.','www.naver.com','','Zinc Panel','그라스울판넬 / 준불연 스치로폴판넬','자세히 보기 '),(37,20,'A',2,'http://localhost/data/common_assets/kukdong_panel/asset_1773562308_7018.jpg','11','1111','www.naver.com','','EPS Panel','111','자세히 보기 '),(38,22,'A',1,'','','','','','','','');
/*!40000 ALTER TABLE `g5_plugin_main_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_main_content_sections`
--

DROP TABLE IF EXISTS `g5_plugin_main_content_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_main_content_sections` (
  `ms_id` int(11) NOT NULL AUTO_INCREMENT,
  `ms_title` varchar(255) NOT NULL DEFAULT '',
  `ms_subtitle` varchar(255) NOT NULL DEFAULT '',
  `ms_lang` varchar(10) NOT NULL DEFAULT 'kr',
  `ms_theme` varchar(50) NOT NULL DEFAULT 'corporate',
  `ms_key` varchar(100) NOT NULL DEFAULT '',
  `ms_content_source` varchar(50) NOT NULL DEFAULT '',
  `ms_show_title` tinyint(4) NOT NULL DEFAULT 1,
  `ms_skin` varchar(50) NOT NULL DEFAULT 'A',
  `ms_sort` int(11) NOT NULL DEFAULT 0,
  `ms_active` tinyint(4) NOT NULL DEFAULT 1,
  `ms_accent_color` varchar(20) NOT NULL DEFAULT '#FF3B30',
  `ms_font_mode` varchar(20) NOT NULL DEFAULT 'serif',
  `ms_bg_color` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_main_content_sections`
--

LOCK TABLES `g5_plugin_main_content_sections` WRITE;
/*!40000 ALTER TABLE `g5_plugin_main_content_sections` DISABLE KEYS */;
INSERT INTO `g5_plugin_main_content_sections` VALUES (20,'Product Introduction','성우첨단패널의 혁신적인 기술력을 소개합니다.','kr','kukdong_panel','kukdong_panel','',1,'product_intro',1,1,'','',''),(22,'국문지도','','kr','kukdong_panel','kukdong_panel','kukdong_panel',1,'main_loader',2,1,'','','');
/*!40000 ALTER TABLE `g5_plugin_main_content_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_main_image_add`
--

DROP TABLE IF EXISTS `g5_plugin_main_image_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_main_image_add` (
  `mi_id` int(11) NOT NULL AUTO_INCREMENT,
  `mi_style` varchar(50) NOT NULL DEFAULT 'basic',
  `mi_sort` int(11) NOT NULL DEFAULT 0,
  `mi_image` varchar(255) NOT NULL DEFAULT '',
  `mi_image_mobile` varchar(255) DEFAULT '',
  `mi_video` varchar(255) NOT NULL DEFAULT '',
  `mi_tag` varchar(255) DEFAULT '',
  `mi_title` varchar(255) NOT NULL DEFAULT '',
  `mi_subtitle` varchar(255) DEFAULT '',
  `mi_desc` varchar(255) NOT NULL DEFAULT '',
  `mi_link` varchar(255) NOT NULL DEFAULT '',
  `mi_btn_text` varchar(100) DEFAULT '',
  `mi_target` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`mi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_main_image_add`
--

LOCK TABLES `g5_plugin_main_image_add` WRITE;
/*!40000 ALTER TABLE `g5_plugin_main_image_add` DISABLE KEYS */;
INSERT INTO `g5_plugin_main_image_add` VALUES (1,'A',1,'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxfHwlRUElQjElQjQlRUIlQUMlQkN8ZW58MHx8fHwxNzY2MjA4NTA5fDA&ixlib=rb-4.1.0&rect=1111,111,2406,3611&q=80&fm=jpg&fit=crop&w=640&h=960','','','','제목1','','(주)르네상스 환경디자인산업은 1978년에 설립되었으며, 창조성 정확성 높은 수준의 품질과 마무리는 르네상스 환경디자인산업의 가장 중요한 사업 목표입니다.','/bbs/content.php?co_id=company&me_code=1010','','_blank'),(2,'A',2,'https://images.unsplash.com/photo-1522069365959-25716fb5001a?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwzMnx8JUVBJUIxJUI0JUVCJUFDJUJDfGVufDB8fHx8MTc2NjIxMzg4N3ww&ixlib=rb-4.1.0&rect=269,399,2124,3186&q=80&fm=jpg&fit=crop&w=640&h=960','','','','제목2','','(주)르네상스 환경디자인산업은 1978년에 설립되었으며, 창조성 정확성 높은 수준의 품질과 마무리는 르네상스 환경디자인산업의 가장 중요한 사업ㅇ','/bbs/content.php?co_id=company&me_code=1010','','_blank'),(13,'B',1,'https://images.unsplash.com/photo-1467803738586-46b7eb7b16a1?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxNnx8JUVBJUIxJUI0JUVCJUFDJUJDfGVufDB8fHx8MTc2NjIwODUwOXww&ixlib=rb-4.1.0&rect=106,61,5287,2972&q=80&fm=jpg&fit=crop&w=1920&h=1080','','','','11','','222','/bbs/content.php?co_id=company&me_code=1010','',''),(14,'B',2,'https://images.unsplash.com/photo-1523833082115-1e8e294bd14e?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw5fHwlRUIlQjklODQlRUQlOTYlODklRUElQjglQjB8ZW58MHx8fHwxNzY2MjkwMjI3fDA&ixlib=rb-4.1.0&rect=21,58,4419,2487&q=80&fm=jpg&fit=crop&w=1920&h=1080','','','','2222','','33333','/bbs/content.php?co_id=company&me_code=1010','',''),(75,'A',3,'https://images.unsplash.com/photo-1542361345-89e58247f2d5?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxMXx8JUVBJUIxJUI0JUVCJUFDJUJDfGVufDB8fHx8MTc2NjIwODUwOXww&ixlib=rb-4.1.0&rect=1237,245,1543,2315&q=80&fm=jpg&fit=crop&w=640&h=960','','','','제목3','','3333','/bbs/content.php?co_id=company&me_code=1020','',''),(76,'A',4,'76_1766285666_11.jpg','','','','제목4','','444444','/bbs/content.php?co_id=company&me_code=1020','',''),(77,'A',5,'https://images.unsplash.com/photo-1583900985737-6d0495555783?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwzfHwlRUIlQjklODQlRUQlODIlQTQlRUIlOEIlODh8ZW58MHx8fHwxNzY2Mjg3MzU0fDA&ixlib=rb-4.1.0&rect=311,160,2113,3168&q=80&fm=jpg&fit=crop&w=640&h=960','','','','제목5','','555555','','',''),(78,'A',6,'https://images.unsplash.com/photo-1443527394413-4b820fd08dde?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxOHx8JUVBJUIxJUI0JUVCJUFDJUJDfGVufDB8fHx8MTc2NjIwODUwOXww&ixlib=rb-4.1.0&rect=1749,67,2585,3877&q=80&fm=jpg&fit=crop&w=640&h=960','','','','제목6','','66666666666666666666666666666666666666666666666666666666666666666666666666666666','','',''),(87,'A',8,'https://images.unsplash.com/photo-1523833082115-1e8e294bd14e?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw5fHwlRUIlQjklODQlRUQlOTYlODklRUElQjglQjB8ZW58MHx8fHwxNzY2MjkwMjI3fDA&ixlib=rb-4.1.0&rect=395,0,1744,2616&q=80&fm=jpg&fit=crop&w=640&h=960','','','','88888888888888','','8888888888888888888888888888888','','',''),(88,'A',9,'https://images.unsplash.com/photo-1502085671122-2d218cd434e6?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw0fHwlRUMlODIlQjB8ZW58MHx8fHwxNzY2Mjg4NTQ3fDA&ixlib=rb-4.1.0&rect=1467,0,1902,2846&q=80&fm=jpg&fit=crop&w=640&h=960','','','','999','','10000','','',''),(89,'A',10,'89_1766290791_11.jpg','','','','ㅇㅇㅇㅇㅇ','','ㅇㅇㅇㅇㅇㅇ','','',''),(90,'A',11,'90_1766290832_11.jpg','','','','ㅁㄴㅇㅁㅇㅁ','','ㄴㅁㅇㅁㅇㄴ','','',''),(91,'C',10,'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d','','','','LUXURY ENTRANCEPREMIUM SOLUTIONS','','Experience the ultimate first impression with our premium gate solutions.Designe','http://localhost/bbs/content.php?co_id=company&me_code=1010','',''),(92,'C',20,'https://images.unsplash.com/photo-1512917774080-9991f1c4c750','','','','SMART TECHNOLOGYARTISTIC CRAFT','','Advanced technology meeting artistic craftsmanship for your home.\r\nSeamlessly integrating security into your life.','http://localhost/bbs/content.php?co_id=company&me_code=1020','',''),(95,'C',21,'https://images.unsplash.com/photo-1550136513-548af4445338?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwyNnx8JUVBJUIxJUI0JUVCJUFDJUJDfGVufDB8fHx8MTc2NjIxMzg4N3ww&ixlib=rb-4.1.0&rect=43,204,3772,2123&q=80&fm=jpg&fit=crop&w=1920&h=1080','','','','33333','','44444444','http://localhost/bbs/content.php?co_id=company&me_code=1010','',''),(96,'C',22,'https://images.unsplash.com/photo-1462396240927-52058a6a84ec?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw1fHwlRUElQjElQjQlRUIlQUMlQkN8ZW58MHx8fHwxNzY2Mjk5NzQ3fDA&ixlib=rb-4.1.0&rect=459,689,3674,2071&q=80&fm=jpg&fit=crop&w=1920&h=1080','','','','','','','','',''),(97,'A',1,'','','','','','','','','',''),(98,'1',1,'','','','','','','','','',''),(125,'corporate',0,'https://images.unsplash.com/photo-1534113690287-c6cd5448d374?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxOHx8ZG9vcnxlbnwwfHx8fDE3Njc1NzkyNDl8MA&ixlib=rb-4.1.0&rect=883,61,1253,1881&q=80&fm=jpg&fit=crop&w=640&h=960','','','','11111','','11111','','',''),(126,'corporate',0,'https://images.unsplash.com/photo-1635435561330-daf4bd15c261?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxfHxiaWclMjAlMjBkb29yfGVufDB8fHx8MTc2NzU3OTI4NXww&ixlib=rb-4.1.0&rect=930,184,2183,3273&q=80&fm=jpg&fit=crop&w=640&h=960','','','','ssss','','sss','','',''),(127,'corporate',0,'https://images.unsplash.com/photo-1597586124394-fbd6ef244026?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxNHx8Z2lybHN8ZW58MHx8fHwxNzY3NTc5MzI0fDA&ixlib=rb-4.1.0&rect=254,312,3717,5574&q=80&fm=jpg&fit=crop&w=640&h=960','','','','33333','','33333333','','',''),(128,'corporate',0,'https://images.unsplash.com/photo-1603993641717-a22c732d8df7?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw5fHwlRUIlQjklODQlRUQlODIlQTQlRUIlOEIlODh8ZW58MHx8fHwxNzY3NTcyMTg3fDA&ixlib=rb-4.1.0&rect=1124,0,2560,3840&q=80&fm=jpg&fit=crop&w=640&h=960','','','','4444','','4444444444444444','','',''),(129,'corporate_light',0,'mv_lib_1768448585_49b87f9d.jpg','','','','Digital Obsession','','ㄹㄴㄹㄴ','dfadfaf','',''),(130,'corporate_light',0,'mv_lib_1768448610_116017a1.jpg','','','','Digital Obsession','','ㅁㄻㄹㅇ','','',''),(133,'kukdong_panel',0,'http://localhost/data/common_assets/kukdong_panel/mv_1773730689_5929.jpg','','','','','','','','','_blank'),(134,'kukdong_panel',0,'http://localhost/data/common_assets/kukdong_panel/mv_1773731271_7447.jpg','','','','','','','','','');
/*!40000 ALTER TABLE `g5_plugin_main_image_add` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_main_image_config`
--

DROP TABLE IF EXISTS `g5_plugin_main_image_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_main_image_config` (
  `mi_id` varchar(50) NOT NULL,
  `mi_theme` varchar(255) NOT NULL,
  `mi_lang` varchar(255) NOT NULL,
  `mi_custom` varchar(255) NOT NULL,
  `mi_subject` varchar(255) NOT NULL,
  `mi_skin` varchar(50) NOT NULL,
  `mi_effect` varchar(20) DEFAULT 'none',
  `mi_overlay` float DEFAULT 0.4,
  `mi_bgcolor` varchar(20) NOT NULL,
  `mi_content` text NOT NULL,
  `mi_datetime` datetime NOT NULL,
  PRIMARY KEY (`mi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_main_image_config`
--

LOCK TABLES `g5_plugin_main_image_config` WRITE;
/*!40000 ALTER TABLE `g5_plugin_main_image_config` DISABLE KEYS */;
INSERT INTO `g5_plugin_main_image_config` VALUES ('corporate','','','','리네상스','ultimate_hero','none',0.4,'','','2026-01-07 15:00:06'),('corporate_light','','','','메인이미지','ultimate_hero','none',0.4,'','','2026-01-15 12:45:18'),('kukdong_panel','kukdong_panel','kr','','메인 비주얼','ultimate_hero','none',0.3,'','','2026-03-17 20:18:53');
/*!40000 ALTER TABLE `g5_plugin_main_image_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_map_api`
--

DROP TABLE IF EXISTS `g5_plugin_map_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_map_api` (
  `ma_id` varchar(255) NOT NULL DEFAULT '',
  `ma_provider` varchar(20) NOT NULL DEFAULT 'naver',
  `ma_lat` varchar(50) NOT NULL DEFAULT '',
  `ma_lng` varchar(50) NOT NULL DEFAULT '',
  `ma_api_key` varchar(255) NOT NULL DEFAULT '',
  `ma_client_id` varchar(255) NOT NULL DEFAULT '',
  `ma_regdate` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`ma_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_map_api`
--

LOCK TABLES `g5_plugin_map_api` WRITE;
/*!40000 ALTER TABLE `g5_plugin_map_api` DISABLE KEYS */;
INSERT INTO `g5_plugin_map_api` VALUES ('corporate','kakao','37.5665','126.9780','3f59ad4358e18f294732333c1b270fa6','nd582w0kst','2026-01-09 12:56:04'),('kukdong_panel','kakao','37.7037704','127.1818166','3f59ad4358e18f294732333c1b270fa6','nd582w0kst','2026-03-16 14:03:21');
/*!40000 ALTER TABLE `g5_plugin_map_api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_online_inquiry`
--

DROP TABLE IF EXISTS `g5_plugin_online_inquiry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_online_inquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `contact` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `ip` varchar(255) NOT NULL DEFAULT '',
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  `admin_memo` text NOT NULL,
  `state` varchar(20) NOT NULL DEFAULT '접수',
  `theme` varchar(50) NOT NULL DEFAULT '',
  `lang` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_online_inquiry`
--

LOCK TABLES `g5_plugin_online_inquiry` WRITE;
/*!40000 ALTER TABLE `g5_plugin_online_inquiry` DISABLE KEYS */;
INSERT INTO `g5_plugin_online_inquiry` VALUES (4,'이관형','01034006723','','Online Inquiry','1111111','::1','2025-12-15 12:09:42','','접수','',''),(5,'이관형','01034006723','','Online Inquiry','111111','::1','2025-12-15 12:10:43','','접수','',''),(6,'ㄹㅇㄹㅇㄹ','ㅇㄹㅇㄹ','','Online Inquiry','ㅇㄹㅇㄹㅇ','::1','2025-12-15 12:11:26','','접수','',''),(17,'이관형','010-6989-89596','','Online Inquiry','사랑합니다.','::1','2025-12-23 13:49:43','','접수','',''),(18,'이관형','010-6989-89596','','Online Inquiry','사랑합니다.','::1','2025-12-23 13:49:45','','접수','',''),(19,'ㅇㅇㅇㅇ','ㅇㅇㅇㅇㅇㅇ','','Online Inquiry','[제품 문의]제품명: 단조11--------------------------------문의내용을 입력해주세요.','::1','2025-12-29 14:17:03','','접수','',''),(20,'ㅇㅇㅇㅇ','ㅇㅇㅇㅇㅇㅇ','','Online Inquiry','[제품 문의]제품명: 단조11--------------------------------문의내용을 입력해주세요.','::1','2025-12-29 14:17:06','','접수','',''),(21,'1111','11111','','Online Inquiry','[제품 문의]\r\n제품명: 단조11\r\n--------------------------------\r\n11111\r\n문의내용을 입력해주세요.','::1','2025-12-29 14:23:36','','접수','',''),(22,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:51','','접수','corporate','kr'),(23,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:53','','접수','corporate','kr'),(24,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:54','','접수','corporate','kr'),(25,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:54','','접수','corporate','kr'),(26,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:54','','접수','corporate','kr'),(27,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:54','','접수','corporate','kr'),(28,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:54','','접수','corporate','kr'),(29,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:54','','접수','corporate','kr'),(30,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:55','','접수','corporate','kr'),(31,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:55','','접수','corporate','kr'),(32,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:33:56','','접수','corporate','kr'),(33,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:34:26','','접수','corporate','kr'),(34,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:34:26','','접수','corporate','kr'),(35,'이관형','ㅇㅇㅇㅇ','','Online Inquiry from Main Section','ㅇㄴㄴㄹㄴㄴㄴㄹㄴㄴㄹ','::1','2026-01-08 16:34:27','','접수','corporate','kr'),(36,'이관형1','11111','','Online Inquiry from Main Section','1111111','::1','2026-01-08 16:35:29','','접수','corporate','kr'),(37,'111','1111','','Online Inquiry from Main Section','1111','::1','2026-01-08 16:36:19','','접수','corporate','kr'),(38,'이관형','fffffffff','','Online Inquiry from Main Section','ffffffff','::1','2026-01-08 16:37:23','','접수','corporate','kr'),(39,'이관형','010-3400-6723','phofler@gmail.com','Online Inquiry from Main Section','테스트테스트테스트','::1','2026-01-09 09:47:08','','접수','corporate','kr'),(40,'이관형','010-3400-6723','phofler@gmail.com','Online Inquiry from Main Section','테스트입니다.','::1','2026-01-09 09:52:41','','접수','corporate','kr');
/*!40000 ALTER TABLE `g5_plugin_online_inquiry` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_online_inquiry_config`
--

DROP TABLE IF EXISTS `g5_plugin_online_inquiry_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_online_inquiry_config` (
  `oi_id` varchar(50) NOT NULL DEFAULT '',
  `theme` varchar(50) NOT NULL DEFAULT '',
  `lang` varchar(10) NOT NULL DEFAULT '',
  `skin` varchar(50) NOT NULL DEFAULT 'basic',
  `oi_bgcolor` varchar(20) NOT NULL DEFAULT '',
  `subject` varchar(255) NOT NULL DEFAULT '',
  `content` longtext NOT NULL,
  `label_name` varchar(100) NOT NULL DEFAULT 'Name',
  `label_phone` varchar(100) NOT NULL DEFAULT 'Phone',
  `label_msg` varchar(100) NOT NULL DEFAULT 'Message',
  `label_submit` varchar(100) NOT NULL DEFAULT 'Submit',
  `reg_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`oi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_online_inquiry_config`
--

LOCK TABLES `g5_plugin_online_inquiry_config` WRITE;
/*!40000 ALTER TABLE `g5_plugin_online_inquiry_config` DISABLE KEYS */;
INSERT INTO `g5_plugin_online_inquiry_config` VALUES ('corporate','corporate','kr','basic','','','<div align=\"\" style=\"\"><div style=\"padding:20px; border:1px solid #ddd; background:#f9f9f9; border-radius:10px;\">\r\n    <h3 style=\"margin-top:0; color:#333;\">온라인 문의 안내</h3>\r\n    <p style=\"color:#666;\">저희 제품과 서비스에 대해 궁금한 점이 있으시면 아래 양식을 통해 문의해 주세요. 담당자가 확인 후 신속하게 답변 드리겠습니다.</p>\r\n</div></div><p><br></p>','Name','Phone','Message','Submit','2026-01-08 15:59:39');
/*!40000 ALTER TABLE `g5_plugin_online_inquiry_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_sub_design`
--

DROP TABLE IF EXISTS `g5_plugin_sub_design`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_sub_design` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `me_code` varchar(255) NOT NULL DEFAULT '',
  `sd_main_text` varchar(255) NOT NULL DEFAULT '',
  `sd_sub_text` varchar(255) NOT NULL DEFAULT '',
  `sd_visual_img` varchar(255) NOT NULL DEFAULT '',
  `sd_visual_url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`sd_id`),
  UNIQUE KEY `me_code` (`me_code`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_sub_design`
--

LOCK TABLES `g5_plugin_sub_design` WRITE;
/*!40000 ALTER TABLE `g5_plugin_sub_design` DISABLE KEYS */;
INSERT INTO `g5_plugin_sub_design` VALUES (1,'10','','','',''),(2,'1010','CEO Message1','Creating the Future of Environmental Design1','sub_visual_1010_1766372665.jpg','https://images.unsplash.com/photo-1462396240927-52058a6a84ec?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHw1fHwlRUElQjElQjQlRUIlQUMlQkN8ZW58MHx8fHwxNzY2Mjk5NzQ3fDA&ixlib=rb-4.1.0&rect=459,804,3674,1841&q=80&fm=jpg&fit=crop&w=1200&h=600'),(3,'1020','CEO Message1','Creating the Future of Environmental Design1','sub_visual_1020_1765854659.png',''),(4,'1030','','','',''),(5,'1040','','','',''),(6,'1050','','','',''),(7,'1060','','','',''),(8,'1070','','','',''),(9,'1080',' 채용정보',' 채용정보 채용정보 채용정보 채용정보','sub_visual_1080_1766023892.png',''),(10,'1090','','','',''),(11,'20','제품소개','제품소개제품소개제품소개','',''),(12,'2010','제품소개','제품소개제품소개제품소개제품소개','',''),(13,'2020','','','',''),(14,'2030','','','',''),(15,'2040','','','',''),(16,'2050','','','',''),(17,'30','시공사례','시공사례시공사례시공사례시공사례시공사례시공사례','','https://images.unsplash.com/reserve/Af0sF2OS5S5gatqrKzVP_Silhoutte.jpg?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxfHwlRUMlODIlQUMlRUIlOUUlOTF8ZW58MHx8fHwxNzY2MzczMjczfDA&ixlib=rb-4.1.0&rect=207,277,1659,830&q=80&fm=jpg&fit=crop&w=1200&h=600'),(18,'40','제','','',''),(19,'50','','','',''),(20,'5010',' 뉴스 & 공지',' 뉴스 & 공지 뉴스 & 공지 뉴스 & 공지','sub_visual_5010_1766029524.jpg',''),(21,'5020','','','',''),(22,'2060','','','',''),(23,'2070','','','',''),(24,'2080','','','',''),(25,'2090','','','',''),(26,'20a0','','','',''),(27,'20b0','','','',''),(28,'20c0','','','',''),(29,'5030','','','','');
/*!40000 ALTER TABLE `g5_plugin_sub_design` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_sub_design_groups`
--

DROP TABLE IF EXISTS `g5_plugin_sub_design_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_sub_design_groups` (
  `sd_id` varchar(100) NOT NULL DEFAULT '',
  `sd_theme` varchar(50) NOT NULL DEFAULT '',
  `sd_lang` varchar(10) NOT NULL DEFAULT 'kr',
  `sd_skin` varchar(50) NOT NULL DEFAULT 'standard',
  `sd_layout` varchar(20) NOT NULL DEFAULT 'full',
  `sd_breadcrumb` tinyint(1) NOT NULL DEFAULT 0,
  `sd_breadcrumb_skin` varchar(50) NOT NULL DEFAULT 'dropdown',
  `sd_menu_table` varchar(50) NOT NULL DEFAULT '',
  `sd_created` datetime NOT NULL,
  `sd_updated` datetime NOT NULL,
  PRIMARY KEY (`sd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_sub_design_groups`
--

LOCK TABLES `g5_plugin_sub_design_groups` WRITE;
/*!40000 ALTER TABLE `g5_plugin_sub_design_groups` DISABLE KEYS */;
INSERT INTO `g5_plugin_sub_design_groups` VALUES ('corporate','corporate','kr','standard','full',0,'dropdown','','2026-01-05 15:14:57','2026-01-05 15:45:17'),('corporate_light','corporate_light','kr','instinct','full',0,'dropdown','','0000-00-00 00:00:00','2026-01-14 12:42:35'),('kukdong_panel','kukdong_panel','kr','standard','full',1,'dropdown','default','2026-03-16 19:04:41','2026-03-17 10:45:18');
/*!40000 ALTER TABLE `g5_plugin_sub_design_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_sub_design_items`
--

DROP TABLE IF EXISTS `g5_plugin_sub_design_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_sub_design_items` (
  `sdi_id` int(11) NOT NULL AUTO_INCREMENT,
  `sd_id` varchar(100) NOT NULL DEFAULT '',
  `me_code` varchar(255) NOT NULL DEFAULT '',
  `me_name` varchar(255) NOT NULL DEFAULT '',
  `sd_main_text` varchar(255) NOT NULL DEFAULT '',
  `sd_sub_text` varchar(255) NOT NULL DEFAULT '',
  `sd_tag` varchar(255) NOT NULL DEFAULT '',
  `sd_effect` text DEFAULT NULL,
  `sd_visual_img` varchar(255) NOT NULL DEFAULT '',
  `sd_visual_url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`sdi_id`),
  UNIQUE KEY `sd_me_code_idx` (`sd_id`,`me_code`) USING BTREE,
  KEY `sd_id` (`sd_id`),
  KEY `me_code` (`me_code`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_sub_design_items`
--

LOCK TABLES `g5_plugin_sub_design_items` WRITE;
/*!40000 ALTER TABLE `g5_plugin_sub_design_items` DISABLE KEYS */;
INSERT INTO `g5_plugin_sub_design_items` VALUES (35,'corporate','10','','회사소개1','회사소개회사소개회사소개1','',NULL,'','https://images.unsplash.com/photo-1526510747491-58f928ec870f?ixid=M3w4NDU5NTl8MHwxfHNlYXJjaHwxM3x8JUVDJTk3JUFDJUVDJTlFJTkwfGVufDB8fHx8MTc2NzUxMDk3N3ww&ixlib=rb-4.1.0&rect=0,1967,3638,852&q=80&fm=jpg&fit=crop&w=1920&h=450'),(36,'corporate','1010','','','','',NULL,'',''),(37,'corporate','101010','','','','',NULL,'',''),(38,'corporate','20','','','','',NULL,'',''),(39,'corporate','TC1010','','','','',NULL,'',''),(40,'corporate','TC10101010','','','','',NULL,'',''),(41,'corporate','TC101040','','','','',NULL,'',''),(42,'corporate','TC1020','','','','',NULL,'',''),(43,'corporate','TC102010','','','','',NULL,'',''),(44,'corporate','TC101020','','','','',NULL,'',''),(45,'corporate','TC101010','','','','',NULL,'',''),(46,'corporate','30','','','','',NULL,'',''),(47,'corporate','40','','','','',NULL,'',''),(48,'corporate','50','','','','',NULL,'',''),(49,'corporate','5010','','','','',NULL,'',''),(50,'corporate','5020','','','','',NULL,'',''),(51,'corporate','5030','','','','',NULL,'',''),(52,'corporate_light','10','회사소개','Defined by Instinct.','About Company','WHO WE ARE',NULL,'','http://localhost/data/main_visual/mv_lib_1768018245_6e1cb2f5.jpg'),(53,'corporate_light','1010','회사개요','Defined by Instinct.','About Company','WHO WE ARE1',NULL,'','http://localhost/data/main_visual/mv_lib_1768018448_c5ccb2d9.jpg'),(54,'corporate_light','101010','하하위메뉴','','','',NULL,'',''),(55,'corporate_light','1020','인사말','','','',NULL,'',''),(56,'corporate_light','1030','찾아오시는길','','','',NULL,'',''),(57,'corporate_light','20','포토리오','Defined by Instinct.','Portfolio','',NULL,'','http://localhost/data/main_visual/mv_lib_1768362148_cf19640a.jpg'),(58,'corporate_light','TC1010','대문','','','',NULL,'',''),(59,'corporate_light','TC10101010','aaaa','','','',NULL,'',''),(60,'corporate_light','TC101040','테스트3','','','',NULL,'',''),(61,'corporate_light','TC1020','자동대문','','','',NULL,'',''),(62,'corporate_light','TC102010','1111','','','',NULL,'',''),(63,'corporate_light','TC101020','목재대문','','','',NULL,'',''),(64,'corporate_light','TC101010','단조재문','','','',NULL,'',''),(65,'corporate_light','30','갤러리','Selected Works','Gallery','',NULL,'','http://localhost/data/main_visual/mv_lib_1768191364_021edc2a.jpg'),(66,'corporate_light','40','온라인문의','','','',NULL,'',''),(67,'corporate_light','50','고객지원','','','',NULL,'',''),(68,'corporate_light','5010','뉴스 & 공지','','','',NULL,'',''),(69,'corporate_light','5020','자료실','','','',NULL,'',''),(70,'corporate_light','5030','묻고답하기','','','',NULL,'',''),(71,'kukdong_panel','10','','회사소개','성우첨단패널의 혁신적인 기술력이 집약된 고기능성 패널 솔루션','WHO WE ARE','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','','http://localhost/data/main_visual/mv_lib_1773656056_efefdae5.jpg'),(72,'kukdong_panel','1010','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','','http://localhost/data/main_visual/mv_lib_1773663097_eb081e49.jpg'),(73,'kukdong_panel','101010','','','','',NULL,'',''),(74,'kukdong_panel','1020','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(75,'kukdong_panel','1030','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(76,'kukdong_panel','20','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(77,'kukdong_panel','30','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(78,'kukdong_panel','40','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(79,'kukdong_panel','50','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(80,'kukdong_panel','5010','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(81,'kukdong_panel','5020','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(82,'kukdong_panel','5030','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','',''),(83,'kukdong_panel','1040','','','','','{\"tag\":{\"type\":\"fade-down\",\"delay\":200,\"duration\":1000},\"main\":{\"type\":\"fade-up\",\"delay\":400,\"duration\":1000},\"sub\":{\"type\":\"fade-up\",\"delay\":600,\"duration\":1000}}','','');
/*!40000 ALTER TABLE `g5_plugin_sub_design_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_plugin_top_menu_config`
--

DROP TABLE IF EXISTS `g5_plugin_top_menu_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_plugin_top_menu_config` (
  `tm_id` varchar(255) NOT NULL DEFAULT '',
  `tm_theme` varchar(255) NOT NULL DEFAULT '',
  `tm_lang` varchar(255) NOT NULL DEFAULT '',
  `tm_custom` varchar(255) NOT NULL DEFAULT '',
  `tm_skin` varchar(255) NOT NULL DEFAULT '',
  `tm_logo_pc` varchar(255) NOT NULL DEFAULT '',
  `tm_logo_mo` varchar(255) NOT NULL DEFAULT '',
  `tm_menu_table` varchar(255) NOT NULL DEFAULT '',
  `tm_reg_dt` datetime DEFAULT NULL,
  PRIMARY KEY (`tm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_plugin_top_menu_config`
--

LOCK TABLES `g5_plugin_top_menu_config` WRITE;
/*!40000 ALTER TABLE `g5_plugin_top_menu_config` DISABLE KEYS */;
INSERT INTO `g5_plugin_top_menu_config` VALUES ('corporate','corporate','kr','','basic','tm_corporate_pc.png','','','2026-01-05 12:29:34'),('corporate_light','corporate','kr','light','minimal','tm_corporate_light_pc.png','','','2026-01-09 16:51:32'),('kukdong_panel','kukdong_panel','kr','','transparent','tm_kukdong_panel_pc.png','tm_kukdong_panel_mo.png','','2026-03-13 16:18:20');
/*!40000 ALTER TABLE `g5_plugin_top_menu_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_point`
--

DROP TABLE IF EXISTS `g5_point`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_point` (
  `po_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `po_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `po_content` varchar(255) NOT NULL DEFAULT '',
  `po_point` int(11) NOT NULL DEFAULT 0,
  `po_use_point` int(11) NOT NULL DEFAULT 0,
  `po_expired` tinyint(4) NOT NULL DEFAULT 0,
  `po_expire_date` date NOT NULL DEFAULT '0000-00-00',
  `po_mb_point` int(11) NOT NULL DEFAULT 0,
  `po_rel_table` varchar(20) NOT NULL DEFAULT '',
  `po_rel_id` varchar(20) NOT NULL DEFAULT '',
  `po_rel_action` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`po_id`),
  KEY `index1` (`mb_id`,`po_rel_table`,`po_rel_id`,`po_rel_action`),
  KEY `index2` (`po_expire_date`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_point`
--

LOCK TABLES `g5_point` WRITE;
/*!40000 ALTER TABLE `g5_point` DISABLE KEYS */;
INSERT INTO `g5_point` VALUES (1,'admin','2025-12-13 16:37:26','2025-12-13 첫로그인',100,0,0,'9999-12-31',100,'@login','admin','2025-12-13'),(2,'admin','2025-12-14 11:16:06','2025-12-14 첫로그인',100,0,0,'9999-12-31',200,'@login','admin','2025-12-14'),(3,'admin','2025-12-15 09:13:18','2025-12-15 첫로그인',100,0,0,'9999-12-31',300,'@login','admin','2025-12-15'),(4,'admin','2025-12-16 08:23:33','2025-12-16 첫로그인',100,0,0,'9999-12-31',400,'@login','admin','2025-12-16'),(5,'admin','2025-12-17 09:06:12','2025-12-17 첫로그인',100,0,0,'9999-12-31',500,'@login','admin','2025-12-17'),(6,'admin','2025-12-18 08:50:24','2025-12-18 첫로그인',100,0,0,'9999-12-31',600,'@login','admin','2025-12-18'),(7,'admin','2025-12-19 08:17:40','2025-12-19 첫로그인',100,0,0,'9999-12-31',700,'@login','admin','2025-12-19'),(8,'admin','2025-12-20 11:52:58','2025-12-20 첫로그인',100,0,0,'9999-12-31',800,'@login','admin','2025-12-20'),(9,'admin','2025-12-21 11:37:50','2025-12-21 첫로그인',100,0,0,'9999-12-31',900,'@login','admin','2025-12-21'),(10,'admin','2025-12-22 08:22:10','2025-12-22 첫로그인',100,0,0,'9999-12-31',1000,'@login','admin','2025-12-22'),(11,'admin','2025-12-23 09:54:10','2025-12-23 첫로그인',100,0,0,'9999-12-31',1100,'@login','admin','2025-12-23'),(12,'admin','2025-12-24 09:50:40','2025-12-24 첫로그인',100,0,0,'9999-12-31',1200,'@login','admin','2025-12-24'),(13,'admin','2025-12-25 12:09:28','2025-12-25 첫로그인',100,0,0,'9999-12-31',1300,'@login','admin','2025-12-25'),(14,'admin','2025-12-26 08:18:09','2025-12-26 첫로그인',100,0,0,'9999-12-31',1400,'@login','admin','2025-12-26'),(15,'admin','2025-12-27 12:15:00','2025-12-27 첫로그인',100,0,0,'9999-12-31',1500,'@login','admin','2025-12-27'),(16,'admin','2025-12-28 10:29:51','2025-12-28 첫로그인',100,0,0,'9999-12-31',1600,'@login','admin','2025-12-28'),(17,'admin','2025-12-29 09:29:55','2025-12-29 첫로그인',100,0,0,'9999-12-31',1700,'@login','admin','2025-12-29'),(18,'admin','2025-12-30 08:31:32','2025-12-30 첫로그인',100,0,0,'9999-12-31',1800,'@login','admin','2025-12-30'),(19,'admin','2025-12-31 18:15:05','2025-12-31 첫로그인',100,0,0,'9999-12-31',1900,'@login','admin','2025-12-31'),(20,'admin','2026-01-01 12:20:01','2026-01-01 첫로그인',100,0,0,'9999-12-31',2000,'@login','admin','2026-01-01'),(21,'admin','2026-01-02 09:11:18','2026-01-02 첫로그인',100,0,0,'9999-12-31',2100,'@login','admin','2026-01-02'),(22,'admin','2026-01-03 12:18:45','2026-01-03 첫로그인',100,0,0,'9999-12-31',2200,'@login','admin','2026-01-03'),(23,'admin','2026-01-04 10:45:47','2026-01-04 첫로그인',100,0,0,'9999-12-31',2300,'@login','admin','2026-01-04'),(24,'admin','2026-01-05 08:30:12','2026-01-05 첫로그인',100,0,0,'9999-12-31',2400,'@login','admin','2026-01-05'),(25,'admin','2026-01-06 09:06:20','2026-01-06 첫로그인',100,0,0,'9999-12-31',2500,'@login','admin','2026-01-06'),(26,'admin','2026-01-07 10:04:03','2026-01-07 첫로그인',100,0,0,'9999-12-31',2600,'@login','admin','2026-01-07'),(27,'admin','2026-01-08 09:36:43','2026-01-08 첫로그인',100,0,0,'9999-12-31',2700,'@login','admin','2026-01-08'),(28,'admin','2026-01-09 08:43:58','2026-01-09 첫로그인',100,0,0,'9999-12-31',2800,'@login','admin','2026-01-09'),(29,'admin','2026-01-10 11:37:48','2026-01-10 첫로그인',100,0,0,'9999-12-31',2900,'@login','admin','2026-01-10'),(30,'admin','2026-01-12 08:38:26','2026-01-12 첫로그인',100,0,0,'9999-12-31',3000,'@login','admin','2026-01-12'),(31,'admin','2026-01-13 09:48:28','2026-01-13 첫로그인',100,0,0,'9999-12-31',3100,'@login','admin','2026-01-13'),(32,'admin','2026-01-14 08:19:49','2026-01-14 첫로그인',100,0,0,'9999-12-31',3200,'@login','admin','2026-01-14'),(33,'admin','2026-01-15 08:44:18','2026-01-15 첫로그인',100,0,0,'9999-12-31',3300,'@login','admin','2026-01-15'),(34,'admin','2026-01-16 09:20:56','2026-01-16 첫로그인',100,0,0,'9999-12-31',3400,'@login','admin','2026-01-16'),(35,'admin','2026-01-17 13:00:59','2026-01-17 첫로그인',100,0,0,'9999-12-31',3500,'@login','admin','2026-01-17'),(36,'admin','2026-01-22 15:47:21','2026-01-22 첫로그인',100,0,0,'9999-12-31',3600,'@login','admin','2026-01-22'),(37,'admin','2026-01-24 12:30:45','2026-01-24 첫로그인',100,0,0,'9999-12-31',3700,'@login','admin','2026-01-24'),(38,'admin','2026-03-09 08:44:10','2026-03-09 첫로그인',100,0,0,'9999-12-31',3800,'@login','admin','2026-03-09'),(39,'admin','2026-03-10 16:12:18','2026-03-10 첫로그인',100,0,0,'9999-12-31',3900,'@login','admin','2026-03-10'),(40,'admin','2026-03-11 10:04:57','2026-03-11 첫로그인',100,0,0,'9999-12-31',4000,'@login','admin','2026-03-11'),(41,'admin','2026-03-13 14:03:28','2026-03-13 첫로그인',100,0,0,'9999-12-31',4100,'@login','admin','2026-03-13'),(42,'admin','2026-03-14 00:15:07','2026-03-14 첫로그인',100,0,0,'9999-12-31',4200,'@login','admin','2026-03-14'),(43,'admin','2026-03-15 10:07:24','2026-03-15 첫로그인',100,0,0,'9999-12-31',4300,'@login','admin','2026-03-15'),(44,'admin','2026-03-16 09:13:04','2026-03-16 첫로그인',100,0,0,'9999-12-31',4400,'@login','admin','2026-03-16'),(45,'admin','2026-03-17 09:28:23','2026-03-17 첫로그인',100,0,0,'9999-12-31',4500,'@login','admin','2026-03-17'),(46,'admin','2026-03-18 09:43:35','2026-03-18 첫로그인',100,0,0,'9999-12-31',4600,'@login','admin','2026-03-18');
/*!40000 ALTER TABLE `g5_point` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_poll`
--

DROP TABLE IF EXISTS `g5_poll`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_poll` (
  `po_id` int(11) NOT NULL AUTO_INCREMENT,
  `po_subject` varchar(255) NOT NULL DEFAULT '',
  `po_poll1` varchar(255) NOT NULL DEFAULT '',
  `po_poll2` varchar(255) NOT NULL DEFAULT '',
  `po_poll3` varchar(255) NOT NULL DEFAULT '',
  `po_poll4` varchar(255) NOT NULL DEFAULT '',
  `po_poll5` varchar(255) NOT NULL DEFAULT '',
  `po_poll6` varchar(255) NOT NULL DEFAULT '',
  `po_poll7` varchar(255) NOT NULL DEFAULT '',
  `po_poll8` varchar(255) NOT NULL DEFAULT '',
  `po_poll9` varchar(255) NOT NULL DEFAULT '',
  `po_cnt1` int(11) NOT NULL DEFAULT 0,
  `po_cnt2` int(11) NOT NULL DEFAULT 0,
  `po_cnt3` int(11) NOT NULL DEFAULT 0,
  `po_cnt4` int(11) NOT NULL DEFAULT 0,
  `po_cnt5` int(11) NOT NULL DEFAULT 0,
  `po_cnt6` int(11) NOT NULL DEFAULT 0,
  `po_cnt7` int(11) NOT NULL DEFAULT 0,
  `po_cnt8` int(11) NOT NULL DEFAULT 0,
  `po_cnt9` int(11) NOT NULL DEFAULT 0,
  `po_etc` varchar(255) NOT NULL DEFAULT '',
  `po_level` tinyint(4) NOT NULL DEFAULT 0,
  `po_point` int(11) NOT NULL DEFAULT 0,
  `po_date` date NOT NULL DEFAULT '0000-00-00',
  `po_ips` mediumtext NOT NULL,
  `mb_ids` text NOT NULL,
  `po_use` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_poll`
--

LOCK TABLES `g5_poll` WRITE;
/*!40000 ALTER TABLE `g5_poll` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_poll` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_poll_etc`
--

DROP TABLE IF EXISTS `g5_poll_etc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_poll_etc` (
  `pc_id` int(11) NOT NULL DEFAULT 0,
  `po_id` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `pc_name` varchar(255) NOT NULL DEFAULT '',
  `pc_idea` varchar(255) NOT NULL DEFAULT '',
  `pc_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_poll_etc`
--

LOCK TABLES `g5_poll_etc` WRITE;
/*!40000 ALTER TABLE `g5_poll_etc` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_poll_etc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_popular`
--

DROP TABLE IF EXISTS `g5_popular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_popular` (
  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_word` varchar(50) NOT NULL DEFAULT '',
  `pp_date` date NOT NULL DEFAULT '0000-00-00',
  `pp_ip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`pp_id`),
  UNIQUE KEY `index1` (`pp_date`,`pp_word`,`pp_ip`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_popular`
--

LOCK TABLES `g5_popular` WRITE;
/*!40000 ALTER TABLE `g5_popular` DISABLE KEYS */;
INSERT INTO `g5_popular` VALUES (5,'1010','2025-12-29','::1'),(3,'101010','2025-12-29','::1'),(1,'101020','2025-12-29','::1'),(2,'101030','2025-12-29','::1'),(6,'101040','2025-12-29','::1'),(4,'102010','2025-12-29','::1'),(7,'1010','2025-12-30','::1'),(9,'101020','2025-12-30','::1'),(8,'101040','2025-12-30','::1'),(10,'1020','2025-12-30','::1'),(11,'102010','2025-12-30','::1'),(12,'2010','2026-01-12','::1'),(18,'1010','2026-01-13','::1'),(13,'2010','2026-01-13','::1'),(15,'>','2026-01-13','::1'),(14,'RESIDENCE','2026-01-13','::1'),(19,'RESIDENCE11111','2026-01-13','::1'),(16,'서울','2026-01-13','::1'),(20,'은평구','2026-01-13','::1'),(17,'인천','2026-01-13','::1'),(22,'>','2026-01-14','::1'),(21,'RESIDENCE','2026-01-14','::1'),(24,'기업','2026-01-14','::1'),(23,'서울','2026-01-14','::1'),(25,'여자','2026-01-14','::1'),(27,'>','2026-01-15','::1'),(26,'기업','2026-01-15','::1'),(28,'여자','2026-01-15','::1');
/*!40000 ALTER TABLE `g5_popular` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_qa_config`
--

DROP TABLE IF EXISTS `g5_qa_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_qa_config` (
  `qa_id` int(11) NOT NULL AUTO_INCREMENT,
  `qa_title` varchar(255) NOT NULL DEFAULT '',
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `qa_use_email` tinyint(4) NOT NULL DEFAULT 0,
  `qa_req_email` tinyint(4) NOT NULL DEFAULT 0,
  `qa_use_hp` tinyint(4) NOT NULL DEFAULT 0,
  `qa_req_hp` tinyint(4) NOT NULL DEFAULT 0,
  `qa_use_sms` tinyint(4) NOT NULL DEFAULT 0,
  `qa_send_number` varchar(255) NOT NULL DEFAULT '0',
  `qa_admin_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_admin_email` varchar(255) NOT NULL DEFAULT '',
  `qa_use_editor` tinyint(4) NOT NULL DEFAULT 0,
  `qa_subject_len` int(11) NOT NULL DEFAULT 0,
  `qa_mobile_subject_len` int(11) NOT NULL DEFAULT 0,
  `qa_page_rows` int(11) NOT NULL DEFAULT 0,
  `qa_mobile_page_rows` int(11) NOT NULL DEFAULT 0,
  `qa_image_width` int(11) NOT NULL DEFAULT 0,
  `qa_upload_size` int(11) NOT NULL DEFAULT 0,
  `qa_insert_content` text NOT NULL,
  `qa_include_head` varchar(255) NOT NULL DEFAULT '',
  `qa_include_tail` varchar(255) NOT NULL DEFAULT '',
  `qa_content_head` text NOT NULL,
  `qa_content_tail` text NOT NULL,
  `qa_mobile_content_head` text NOT NULL,
  `qa_mobile_content_tail` text NOT NULL,
  `qa_1_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_2_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_3_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_4_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_5_subj` varchar(255) NOT NULL DEFAULT '',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_qa_config`
--

LOCK TABLES `g5_qa_config` WRITE;
/*!40000 ALTER TABLE `g5_qa_config` DISABLE KEYS */;
INSERT INTO `g5_qa_config` VALUES (1,'1:1문의','회원|포인트','basic','basic',1,0,1,0,0,'0','','',1,60,30,15,15,600,1048576,'','','','','','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_qa_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_qa_content`
--

DROP TABLE IF EXISTS `g5_qa_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_qa_content` (
  `qa_id` int(11) NOT NULL AUTO_INCREMENT,
  `qa_num` int(11) NOT NULL DEFAULT 0,
  `qa_parent` int(11) NOT NULL DEFAULT 0,
  `qa_related` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `qa_name` varchar(255) NOT NULL DEFAULT '',
  `qa_email` varchar(255) NOT NULL DEFAULT '',
  `qa_hp` varchar(255) NOT NULL DEFAULT '',
  `qa_type` tinyint(4) NOT NULL DEFAULT 0,
  `qa_category` varchar(255) NOT NULL DEFAULT '',
  `qa_email_recv` tinyint(4) NOT NULL DEFAULT 0,
  `qa_sms_recv` tinyint(4) NOT NULL DEFAULT 0,
  `qa_html` tinyint(4) NOT NULL DEFAULT 0,
  `qa_subject` varchar(255) NOT NULL DEFAULT '',
  `qa_content` text NOT NULL,
  `qa_status` tinyint(4) NOT NULL DEFAULT 0,
  `qa_file1` varchar(255) NOT NULL DEFAULT '',
  `qa_source1` varchar(255) NOT NULL DEFAULT '',
  `qa_file2` varchar(255) NOT NULL DEFAULT '',
  `qa_source2` varchar(255) NOT NULL DEFAULT '',
  `qa_ip` varchar(255) NOT NULL DEFAULT '',
  `qa_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `qa_1` varchar(255) NOT NULL DEFAULT '',
  `qa_2` varchar(255) NOT NULL DEFAULT '',
  `qa_3` varchar(255) NOT NULL DEFAULT '',
  `qa_4` varchar(255) NOT NULL DEFAULT '',
  `qa_5` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`qa_id`),
  KEY `qa_num_parent` (`qa_num`,`qa_parent`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_qa_content`
--

LOCK TABLES `g5_qa_content` WRITE;
/*!40000 ALTER TABLE `g5_qa_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_qa_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_scrap`
--

DROP TABLE IF EXISTS `g5_scrap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_scrap` (
  `ms_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `bo_table` varchar(20) NOT NULL DEFAULT '',
  `wr_id` varchar(15) NOT NULL DEFAULT '',
  `ms_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ms_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_scrap`
--

LOCK TABLES `g5_scrap` WRITE;
/*!40000 ALTER TABLE `g5_scrap` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_scrap` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_banner`
--

DROP TABLE IF EXISTS `g5_shop_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_banner` (
  `bn_id` int(11) NOT NULL AUTO_INCREMENT,
  `bn_alt` varchar(255) NOT NULL DEFAULT '',
  `bn_url` varchar(255) NOT NULL DEFAULT '',
  `bn_device` varchar(10) NOT NULL DEFAULT '',
  `bn_position` varchar(255) NOT NULL DEFAULT '',
  `bn_border` tinyint(4) NOT NULL DEFAULT 0,
  `bn_new_win` tinyint(4) NOT NULL DEFAULT 0,
  `bn_begin_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bn_end_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bn_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `bn_hit` int(11) NOT NULL DEFAULT 0,
  `bn_order` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`bn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_banner`
--

LOCK TABLES `g5_shop_banner` WRITE;
/*!40000 ALTER TABLE `g5_shop_banner` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_cart`
--

DROP TABLE IF EXISTS `g5_shop_cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_cart` (
  `ct_id` int(11) NOT NULL AUTO_INCREMENT,
  `od_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `it_id` varchar(20) NOT NULL DEFAULT '',
  `it_name` varchar(255) NOT NULL DEFAULT '',
  `it_sc_type` tinyint(4) NOT NULL DEFAULT 0,
  `it_sc_method` tinyint(4) NOT NULL DEFAULT 0,
  `it_sc_price` int(11) NOT NULL DEFAULT 0,
  `it_sc_minimum` int(11) NOT NULL DEFAULT 0,
  `it_sc_qty` int(11) NOT NULL DEFAULT 0,
  `ct_status` varchar(255) NOT NULL DEFAULT '',
  `ct_history` text NOT NULL,
  `ct_price` int(11) NOT NULL DEFAULT 0,
  `ct_point` int(11) NOT NULL DEFAULT 0,
  `cp_price` int(11) NOT NULL DEFAULT 0,
  `ct_point_use` tinyint(4) NOT NULL DEFAULT 0,
  `ct_stock_use` tinyint(4) NOT NULL DEFAULT 0,
  `ct_option` varchar(255) NOT NULL DEFAULT '',
  `ct_qty` int(11) NOT NULL DEFAULT 0,
  `ct_notax` tinyint(4) NOT NULL DEFAULT 0,
  `io_id` varchar(255) NOT NULL DEFAULT '',
  `io_type` tinyint(4) NOT NULL DEFAULT 0,
  `io_price` int(11) NOT NULL DEFAULT 0,
  `ct_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ct_ip` varchar(25) NOT NULL DEFAULT '',
  `ct_send_cost` tinyint(4) NOT NULL DEFAULT 0,
  `ct_direct` tinyint(4) NOT NULL DEFAULT 0,
  `ct_select` tinyint(4) NOT NULL DEFAULT 0,
  `ct_select_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ct_id`),
  KEY `od_id` (`od_id`),
  KEY `it_id` (`it_id`),
  KEY `ct_status` (`ct_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_cart`
--

LOCK TABLES `g5_shop_cart` WRITE;
/*!40000 ALTER TABLE `g5_shop_cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_category`
--

DROP TABLE IF EXISTS `g5_shop_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_category` (
  `ca_id` varchar(10) NOT NULL DEFAULT '0',
  `ca_name` varchar(255) NOT NULL DEFAULT '',
  `ca_order` int(11) NOT NULL DEFAULT 0,
  `ca_skin_dir` varchar(255) NOT NULL DEFAULT '',
  `ca_mobile_skin_dir` varchar(255) NOT NULL DEFAULT '',
  `ca_skin` varchar(255) NOT NULL DEFAULT '',
  `ca_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `ca_img_width` int(11) NOT NULL DEFAULT 0,
  `ca_img_height` int(11) NOT NULL DEFAULT 0,
  `ca_mobile_img_width` int(11) NOT NULL DEFAULT 0,
  `ca_mobile_img_height` int(11) NOT NULL DEFAULT 0,
  `ca_sell_email` varchar(255) NOT NULL DEFAULT '',
  `ca_use` tinyint(4) NOT NULL DEFAULT 0,
  `ca_stock_qty` int(11) NOT NULL DEFAULT 0,
  `ca_explan_html` tinyint(4) NOT NULL DEFAULT 0,
  `ca_head_html` text NOT NULL,
  `ca_tail_html` text NOT NULL,
  `ca_mobile_head_html` text NOT NULL,
  `ca_mobile_tail_html` text NOT NULL,
  `ca_list_mod` int(11) NOT NULL DEFAULT 0,
  `ca_list_row` int(11) NOT NULL DEFAULT 0,
  `ca_mobile_list_mod` int(11) NOT NULL DEFAULT 0,
  `ca_mobile_list_row` int(11) NOT NULL DEFAULT 0,
  `ca_include_head` varchar(255) NOT NULL DEFAULT '',
  `ca_include_tail` varchar(255) NOT NULL DEFAULT '',
  `ca_mb_id` varchar(255) NOT NULL DEFAULT '',
  `ca_cert_use` tinyint(4) NOT NULL DEFAULT 0,
  `ca_adult_use` tinyint(4) NOT NULL DEFAULT 0,
  `ca_nocoupon` tinyint(4) NOT NULL DEFAULT 0,
  `ca_1_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_2_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_3_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_4_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_5_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_6_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_7_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_8_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_9_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_10_subj` varchar(255) NOT NULL DEFAULT '',
  `ca_1` varchar(255) NOT NULL DEFAULT '',
  `ca_2` varchar(255) NOT NULL DEFAULT '',
  `ca_3` varchar(255) NOT NULL DEFAULT '',
  `ca_4` varchar(255) NOT NULL DEFAULT '',
  `ca_5` varchar(255) NOT NULL DEFAULT '',
  `ca_6` varchar(255) NOT NULL DEFAULT '',
  `ca_7` varchar(255) NOT NULL DEFAULT '',
  `ca_8` varchar(255) NOT NULL DEFAULT '',
  `ca_9` varchar(255) NOT NULL DEFAULT '',
  `ca_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ca_id`),
  KEY `ca_order` (`ca_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_category`
--

LOCK TABLES `g5_shop_category` WRITE;
/*!40000 ALTER TABLE `g5_shop_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_coupon`
--

DROP TABLE IF EXISTS `g5_shop_coupon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_coupon` (
  `cp_no` int(11) NOT NULL AUTO_INCREMENT,
  `cp_id` varchar(100) NOT NULL DEFAULT '',
  `cp_subject` varchar(255) NOT NULL DEFAULT '',
  `cp_method` tinyint(4) NOT NULL DEFAULT 0,
  `cp_target` varchar(255) NOT NULL DEFAULT '',
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `cz_id` int(11) NOT NULL DEFAULT 0,
  `cp_start` date NOT NULL DEFAULT '0000-00-00',
  `cp_end` date NOT NULL DEFAULT '0000-00-00',
  `cp_price` int(11) NOT NULL DEFAULT 0,
  `cp_type` tinyint(4) NOT NULL DEFAULT 0,
  `cp_trunc` int(11) NOT NULL DEFAULT 0,
  `cp_minimum` int(11) NOT NULL DEFAULT 0,
  `cp_maximum` int(11) NOT NULL DEFAULT 0,
  `od_id` bigint(20) unsigned NOT NULL,
  `cp_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cp_no`),
  UNIQUE KEY `cp_id` (`cp_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_coupon`
--

LOCK TABLES `g5_shop_coupon` WRITE;
/*!40000 ALTER TABLE `g5_shop_coupon` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_coupon` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_coupon_log`
--

DROP TABLE IF EXISTS `g5_shop_coupon_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_coupon_log` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cp_id` varchar(100) NOT NULL DEFAULT '',
  `mb_id` varchar(100) NOT NULL DEFAULT '',
  `od_id` bigint(20) NOT NULL,
  `cp_price` int(11) NOT NULL DEFAULT 0,
  `cl_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cl_id`),
  KEY `mb_id` (`mb_id`),
  KEY `od_id` (`od_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_coupon_log`
--

LOCK TABLES `g5_shop_coupon_log` WRITE;
/*!40000 ALTER TABLE `g5_shop_coupon_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_coupon_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_coupon_zone`
--

DROP TABLE IF EXISTS `g5_shop_coupon_zone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_coupon_zone` (
  `cz_id` int(11) NOT NULL AUTO_INCREMENT,
  `cz_type` tinyint(4) NOT NULL DEFAULT 0,
  `cz_subject` varchar(255) NOT NULL DEFAULT '',
  `cz_start` date NOT NULL DEFAULT '0000-00-00',
  `cz_end` date NOT NULL DEFAULT '0000-00-00',
  `cz_file` varchar(255) NOT NULL DEFAULT '',
  `cz_period` int(11) NOT NULL DEFAULT 0,
  `cz_point` int(11) NOT NULL DEFAULT 0,
  `cp_method` tinyint(4) NOT NULL DEFAULT 0,
  `cp_target` varchar(255) NOT NULL DEFAULT '',
  `cp_price` int(11) NOT NULL DEFAULT 0,
  `cp_type` tinyint(4) NOT NULL DEFAULT 0,
  `cp_trunc` int(11) NOT NULL DEFAULT 0,
  `cp_minimum` int(11) NOT NULL DEFAULT 0,
  `cp_maximum` int(11) NOT NULL DEFAULT 0,
  `cz_download` int(11) NOT NULL DEFAULT 0,
  `cz_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`cz_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_coupon_zone`
--

LOCK TABLES `g5_shop_coupon_zone` WRITE;
/*!40000 ALTER TABLE `g5_shop_coupon_zone` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_coupon_zone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_default`
--

DROP TABLE IF EXISTS `g5_shop_default`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_default` (
  `de_id` int(11) NOT NULL AUTO_INCREMENT,
  `de_admin_company_owner` varchar(255) NOT NULL DEFAULT '',
  `de_admin_company_name` varchar(255) NOT NULL DEFAULT '',
  `de_admin_company_saupja_no` varchar(255) NOT NULL DEFAULT '',
  `de_admin_company_tel` varchar(255) NOT NULL DEFAULT '',
  `de_admin_company_fax` varchar(255) NOT NULL DEFAULT '',
  `de_admin_tongsin_no` varchar(255) NOT NULL DEFAULT '',
  `de_admin_company_zip` varchar(255) NOT NULL DEFAULT '',
  `de_admin_company_addr` varchar(255) NOT NULL DEFAULT '',
  `de_admin_info_name` varchar(255) NOT NULL DEFAULT '',
  `de_admin_info_email` varchar(255) NOT NULL DEFAULT '',
  `de_shop_skin` varchar(255) NOT NULL DEFAULT '',
  `de_shop_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `de_type1_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_type1_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_type1_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_type1_list_row` int(11) NOT NULL DEFAULT 0,
  `de_type1_img_width` int(11) NOT NULL DEFAULT 0,
  `de_type1_img_height` int(11) NOT NULL DEFAULT 0,
  `de_type2_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_type2_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_type2_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_type2_list_row` int(11) NOT NULL DEFAULT 0,
  `de_type2_img_width` int(11) NOT NULL DEFAULT 0,
  `de_type2_img_height` int(11) NOT NULL DEFAULT 0,
  `de_type3_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_type3_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_type3_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_type3_list_row` int(11) NOT NULL DEFAULT 0,
  `de_type3_img_width` int(11) NOT NULL DEFAULT 0,
  `de_type3_img_height` int(11) NOT NULL DEFAULT 0,
  `de_type4_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_type4_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_type4_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_type4_list_row` int(11) NOT NULL DEFAULT 0,
  `de_type4_img_width` int(11) NOT NULL DEFAULT 0,
  `de_type4_img_height` int(11) NOT NULL DEFAULT 0,
  `de_type5_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_type5_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_type5_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_type5_list_row` int(11) NOT NULL DEFAULT 0,
  `de_type5_img_width` int(11) NOT NULL DEFAULT 0,
  `de_type5_img_height` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type1_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_mobile_type1_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_type1_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type1_list_row` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type1_img_width` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type1_img_height` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type2_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_mobile_type2_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_type2_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type2_list_row` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type2_img_width` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type2_img_height` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type3_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_mobile_type3_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_type3_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type3_list_row` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type3_img_width` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type3_img_height` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type4_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_mobile_type4_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_type4_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type4_list_row` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type4_img_width` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type4_img_height` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type5_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_mobile_type5_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_type5_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type5_list_row` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type5_img_width` int(11) NOT NULL DEFAULT 0,
  `de_mobile_type5_img_height` int(11) NOT NULL DEFAULT 0,
  `de_rel_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_rel_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_rel_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_rel_img_width` int(11) NOT NULL DEFAULT 0,
  `de_rel_img_height` int(11) NOT NULL DEFAULT 0,
  `de_mobile_rel_list_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_mobile_rel_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_rel_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_mobile_rel_img_width` int(11) NOT NULL DEFAULT 0,
  `de_mobile_rel_img_height` int(11) NOT NULL DEFAULT 0,
  `de_search_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_search_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_search_list_row` int(11) NOT NULL DEFAULT 0,
  `de_search_img_width` int(11) NOT NULL DEFAULT 0,
  `de_search_img_height` int(11) NOT NULL DEFAULT 0,
  `de_mobile_search_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_search_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_mobile_search_list_row` int(11) NOT NULL DEFAULT 0,
  `de_mobile_search_img_width` int(11) NOT NULL DEFAULT 0,
  `de_mobile_search_img_height` int(11) NOT NULL DEFAULT 0,
  `de_listtype_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_listtype_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_listtype_list_row` int(11) NOT NULL DEFAULT 0,
  `de_listtype_img_width` int(11) NOT NULL DEFAULT 0,
  `de_listtype_img_height` int(11) NOT NULL DEFAULT 0,
  `de_mobile_listtype_list_skin` varchar(255) NOT NULL DEFAULT '',
  `de_mobile_listtype_list_mod` int(11) NOT NULL DEFAULT 0,
  `de_mobile_listtype_list_row` int(11) NOT NULL DEFAULT 0,
  `de_mobile_listtype_img_width` int(11) NOT NULL DEFAULT 0,
  `de_mobile_listtype_img_height` int(11) NOT NULL DEFAULT 0,
  `de_bank_use` int(11) NOT NULL DEFAULT 0,
  `de_bank_account` text NOT NULL,
  `de_card_test` int(11) NOT NULL DEFAULT 0,
  `de_card_use` int(11) NOT NULL DEFAULT 0,
  `de_card_noint_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_card_point` int(11) NOT NULL DEFAULT 0,
  `de_settle_min_point` int(11) NOT NULL DEFAULT 0,
  `de_settle_max_point` int(11) NOT NULL DEFAULT 0,
  `de_settle_point_unit` int(11) NOT NULL DEFAULT 0,
  `de_level_sell` int(11) NOT NULL DEFAULT 0,
  `de_delivery_company` varchar(255) NOT NULL DEFAULT '',
  `de_send_cost_case` varchar(255) NOT NULL DEFAULT '',
  `de_send_cost_limit` varchar(255) NOT NULL DEFAULT '',
  `de_send_cost_list` varchar(255) NOT NULL DEFAULT '',
  `de_hope_date_use` int(11) NOT NULL DEFAULT 0,
  `de_hope_date_after` int(11) NOT NULL DEFAULT 0,
  `de_baesong_content` text NOT NULL,
  `de_change_content` text NOT NULL,
  `de_point_days` int(11) NOT NULL DEFAULT 0,
  `de_simg_width` int(11) NOT NULL DEFAULT 0,
  `de_simg_height` int(11) NOT NULL DEFAULT 0,
  `de_mimg_width` int(11) NOT NULL DEFAULT 0,
  `de_mimg_height` int(11) NOT NULL DEFAULT 0,
  `de_sms_cont1` text NOT NULL,
  `de_sms_cont2` text NOT NULL,
  `de_sms_cont3` text NOT NULL,
  `de_sms_cont4` text NOT NULL,
  `de_sms_cont5` text NOT NULL,
  `de_sms_use1` tinyint(4) NOT NULL DEFAULT 0,
  `de_sms_use2` tinyint(4) NOT NULL DEFAULT 0,
  `de_sms_use3` tinyint(4) NOT NULL DEFAULT 0,
  `de_sms_use4` tinyint(4) NOT NULL DEFAULT 0,
  `de_sms_use5` tinyint(4) NOT NULL DEFAULT 0,
  `de_sms_hp` varchar(255) NOT NULL DEFAULT '',
  `de_pg_service` varchar(255) NOT NULL DEFAULT '',
  `de_kcp_mid` varchar(255) NOT NULL DEFAULT '',
  `de_kcp_site_key` varchar(255) NOT NULL DEFAULT '',
  `de_inicis_mid` varchar(255) NOT NULL DEFAULT '',
  `de_inicis_iniapi_key` varchar(30) NOT NULL DEFAULT '',
  `de_inicis_iniapi_iv` varchar(30) NOT NULL DEFAULT '',
  `de_inicis_sign_key` varchar(255) NOT NULL DEFAULT '',
  `de_iche_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_easy_pay_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_easy_pay_services` varchar(255) NOT NULL DEFAULT '',
  `de_samsung_pay_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_inicis_lpay_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_inicis_kakaopay_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_inicis_cartpoint_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_nicepay_mid` varchar(30) NOT NULL DEFAULT '',
  `de_nicepay_key` varchar(255) NOT NULL DEFAULT '',
  `de_item_use_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_item_use_write` tinyint(4) NOT NULL DEFAULT 0,
  `de_code_dup_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_cart_keep_term` int(11) NOT NULL DEFAULT 0,
  `de_guest_cart_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_admin_buga_no` varchar(255) NOT NULL DEFAULT '',
  `de_vbank_use` varchar(255) NOT NULL DEFAULT '',
  `de_taxsave_use` tinyint(4) NOT NULL,
  `de_taxsave_types` set('account','vbank','transfer') NOT NULL DEFAULT 'account',
  `de_guest_privacy` text NOT NULL,
  `de_hp_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_escrow_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_tax_flag_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_kakaopay_mid` varchar(255) NOT NULL DEFAULT '',
  `de_kakaopay_key` varchar(255) NOT NULL DEFAULT '',
  `de_kakaopay_enckey` varchar(255) NOT NULL DEFAULT '',
  `de_kakaopay_hashkey` varchar(255) NOT NULL DEFAULT '',
  `de_kakaopay_cancelpwd` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_mid` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_cert_key` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_button_key` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_test` tinyint(4) NOT NULL DEFAULT 0,
  `de_naverpay_mb_id` varchar(255) NOT NULL DEFAULT '',
  `de_naverpay_sendcost` varchar(255) NOT NULL DEFAULT '',
  `de_member_reg_coupon_use` tinyint(4) NOT NULL DEFAULT 0,
  `de_member_reg_coupon_term` int(11) NOT NULL DEFAULT 0,
  `de_member_reg_coupon_price` int(11) NOT NULL DEFAULT 0,
  `de_member_reg_coupon_minimum` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`de_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_default`
--

LOCK TABLES `g5_shop_default` WRITE;
/*!40000 ALTER TABLE `g5_shop_default` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_default` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_event`
--

DROP TABLE IF EXISTS `g5_shop_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_event` (
  `ev_id` int(11) NOT NULL AUTO_INCREMENT,
  `ev_skin` varchar(255) NOT NULL DEFAULT '',
  `ev_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `ev_img_width` int(11) NOT NULL DEFAULT 0,
  `ev_img_height` int(11) NOT NULL DEFAULT 0,
  `ev_list_mod` int(11) NOT NULL DEFAULT 0,
  `ev_list_row` int(11) NOT NULL DEFAULT 0,
  `ev_mobile_img_width` int(11) NOT NULL DEFAULT 0,
  `ev_mobile_img_height` int(11) NOT NULL DEFAULT 0,
  `ev_mobile_list_mod` int(11) NOT NULL DEFAULT 0,
  `ev_mobile_list_row` int(11) NOT NULL DEFAULT 0,
  `ev_subject` varchar(255) NOT NULL DEFAULT '',
  `ev_subject_strong` tinyint(4) NOT NULL DEFAULT 0,
  `ev_head_html` text NOT NULL,
  `ev_tail_html` text NOT NULL,
  `ev_use` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ev_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_event`
--

LOCK TABLES `g5_shop_event` WRITE;
/*!40000 ALTER TABLE `g5_shop_event` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_event_item`
--

DROP TABLE IF EXISTS `g5_shop_event_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_event_item` (
  `ev_id` int(11) NOT NULL DEFAULT 0,
  `it_id` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`ev_id`,`it_id`),
  KEY `it_id` (`it_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_event_item`
--

LOCK TABLES `g5_shop_event_item` WRITE;
/*!40000 ALTER TABLE `g5_shop_event_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_event_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_inicis_log`
--

DROP TABLE IF EXISTS `g5_shop_inicis_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_inicis_log` (
  `oid` bigint(20) unsigned NOT NULL,
  `P_TID` varchar(255) NOT NULL DEFAULT '',
  `P_MID` varchar(255) NOT NULL DEFAULT '',
  `P_AUTH_DT` varchar(255) NOT NULL DEFAULT '',
  `P_STATUS` varchar(255) NOT NULL DEFAULT '',
  `P_TYPE` varchar(255) NOT NULL DEFAULT '',
  `P_OID` varchar(255) NOT NULL DEFAULT '',
  `P_FN_NM` varchar(255) NOT NULL DEFAULT '',
  `P_AUTH_NO` varchar(255) NOT NULL DEFAULT '',
  `P_AMT` int(11) NOT NULL DEFAULT 0,
  `P_RMESG1` varchar(255) NOT NULL DEFAULT '',
  `post_data` text NOT NULL,
  `is_mail_send` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`oid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_inicis_log`
--

LOCK TABLES `g5_shop_inicis_log` WRITE;
/*!40000 ALTER TABLE `g5_shop_inicis_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_inicis_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item`
--

DROP TABLE IF EXISTS `g5_shop_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item` (
  `it_id` varchar(20) NOT NULL DEFAULT '',
  `ca_id` varchar(10) NOT NULL DEFAULT '0',
  `ca_id2` varchar(255) NOT NULL DEFAULT '',
  `ca_id3` varchar(255) NOT NULL DEFAULT '',
  `it_skin` varchar(255) NOT NULL DEFAULT '',
  `it_mobile_skin` varchar(255) NOT NULL DEFAULT '',
  `it_name` varchar(255) NOT NULL DEFAULT '',
  `it_seo_title` varchar(200) NOT NULL DEFAULT '',
  `it_maker` varchar(255) NOT NULL DEFAULT '',
  `it_origin` varchar(255) NOT NULL DEFAULT '',
  `it_brand` varchar(255) NOT NULL DEFAULT '',
  `it_model` varchar(255) NOT NULL DEFAULT '',
  `it_option_subject` varchar(255) NOT NULL DEFAULT '',
  `it_supply_subject` varchar(255) NOT NULL DEFAULT '',
  `it_type1` tinyint(4) NOT NULL DEFAULT 0,
  `it_type2` tinyint(4) NOT NULL DEFAULT 0,
  `it_type3` tinyint(4) NOT NULL DEFAULT 0,
  `it_type4` tinyint(4) NOT NULL DEFAULT 0,
  `it_type5` tinyint(4) NOT NULL DEFAULT 0,
  `it_basic` text NOT NULL,
  `it_explan` mediumtext NOT NULL,
  `it_explan2` mediumtext NOT NULL,
  `it_mobile_explan` mediumtext NOT NULL,
  `it_cust_price` int(11) NOT NULL DEFAULT 0,
  `it_price` int(11) NOT NULL DEFAULT 0,
  `it_point` int(11) NOT NULL DEFAULT 0,
  `it_point_type` tinyint(4) NOT NULL DEFAULT 0,
  `it_supply_point` int(11) NOT NULL DEFAULT 0,
  `it_notax` tinyint(4) NOT NULL DEFAULT 0,
  `it_sell_email` varchar(255) NOT NULL DEFAULT '',
  `it_use` tinyint(4) NOT NULL DEFAULT 0,
  `it_nocoupon` tinyint(4) NOT NULL DEFAULT 0,
  `it_soldout` tinyint(4) NOT NULL DEFAULT 0,
  `it_stock_qty` int(11) NOT NULL DEFAULT 0,
  `it_stock_sms` tinyint(4) NOT NULL DEFAULT 0,
  `it_noti_qty` int(11) NOT NULL DEFAULT 0,
  `it_sc_type` tinyint(4) NOT NULL DEFAULT 0,
  `it_sc_method` tinyint(4) NOT NULL DEFAULT 0,
  `it_sc_price` int(11) NOT NULL DEFAULT 0,
  `it_sc_minimum` int(11) NOT NULL DEFAULT 0,
  `it_sc_qty` int(11) NOT NULL DEFAULT 0,
  `it_buy_min_qty` int(11) NOT NULL DEFAULT 0,
  `it_buy_max_qty` int(11) NOT NULL DEFAULT 0,
  `it_head_html` text NOT NULL,
  `it_tail_html` text NOT NULL,
  `it_mobile_head_html` text NOT NULL,
  `it_mobile_tail_html` text NOT NULL,
  `it_hit` int(11) NOT NULL DEFAULT 0,
  `it_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `it_update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `it_ip` varchar(25) NOT NULL DEFAULT '',
  `it_order` int(11) NOT NULL DEFAULT 0,
  `it_tel_inq` tinyint(4) NOT NULL DEFAULT 0,
  `it_info_gubun` varchar(50) NOT NULL DEFAULT '',
  `it_info_value` text NOT NULL,
  `it_sum_qty` int(11) NOT NULL DEFAULT 0,
  `it_use_cnt` int(11) NOT NULL DEFAULT 0,
  `it_use_avg` decimal(2,1) NOT NULL,
  `it_shop_memo` text NOT NULL,
  `ec_mall_pid` varchar(255) NOT NULL DEFAULT '',
  `it_img1` varchar(255) NOT NULL DEFAULT '',
  `it_img2` varchar(255) NOT NULL DEFAULT '',
  `it_img3` varchar(255) NOT NULL DEFAULT '',
  `it_img4` varchar(255) NOT NULL DEFAULT '',
  `it_img5` varchar(255) NOT NULL DEFAULT '',
  `it_img6` varchar(255) NOT NULL DEFAULT '',
  `it_img7` varchar(255) NOT NULL DEFAULT '',
  `it_img8` varchar(255) NOT NULL DEFAULT '',
  `it_img9` varchar(255) NOT NULL DEFAULT '',
  `it_img10` varchar(255) NOT NULL DEFAULT '',
  `it_1_subj` varchar(255) NOT NULL DEFAULT '',
  `it_2_subj` varchar(255) NOT NULL DEFAULT '',
  `it_3_subj` varchar(255) NOT NULL DEFAULT '',
  `it_4_subj` varchar(255) NOT NULL DEFAULT '',
  `it_5_subj` varchar(255) NOT NULL DEFAULT '',
  `it_6_subj` varchar(255) NOT NULL DEFAULT '',
  `it_7_subj` varchar(255) NOT NULL DEFAULT '',
  `it_8_subj` varchar(255) NOT NULL DEFAULT '',
  `it_9_subj` varchar(255) NOT NULL DEFAULT '',
  `it_10_subj` varchar(255) NOT NULL DEFAULT '',
  `it_1` varchar(255) NOT NULL DEFAULT '',
  `it_2` varchar(255) NOT NULL DEFAULT '',
  `it_3` varchar(255) NOT NULL DEFAULT '',
  `it_4` varchar(255) NOT NULL DEFAULT '',
  `it_5` varchar(255) NOT NULL DEFAULT '',
  `it_6` varchar(255) NOT NULL DEFAULT '',
  `it_7` varchar(255) NOT NULL DEFAULT '',
  `it_8` varchar(255) NOT NULL DEFAULT '',
  `it_9` varchar(255) NOT NULL DEFAULT '',
  `it_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`it_id`),
  KEY `ca_id` (`ca_id`),
  KEY `it_name` (`it_name`),
  KEY `it_seo_title` (`it_seo_title`),
  KEY `it_order` (`it_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item`
--

LOCK TABLES `g5_shop_item` WRITE;
/*!40000 ALTER TABLE `g5_shop_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_option`
--

DROP TABLE IF EXISTS `g5_shop_item_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_option` (
  `io_no` int(11) NOT NULL AUTO_INCREMENT,
  `io_id` varchar(255) NOT NULL DEFAULT '0',
  `io_type` tinyint(4) NOT NULL DEFAULT 0,
  `it_id` varchar(20) NOT NULL DEFAULT '',
  `io_price` int(11) NOT NULL DEFAULT 0,
  `io_stock_qty` int(11) NOT NULL DEFAULT 0,
  `io_noti_qty` int(11) NOT NULL DEFAULT 0,
  `io_use` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`io_no`),
  KEY `io_id` (`io_id`),
  KEY `it_id` (`it_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_option`
--

LOCK TABLES `g5_shop_item_option` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_qa`
--

DROP TABLE IF EXISTS `g5_shop_item_qa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_qa` (
  `iq_id` int(11) NOT NULL AUTO_INCREMENT,
  `it_id` varchar(20) NOT NULL DEFAULT '',
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `iq_secret` tinyint(4) NOT NULL DEFAULT 0,
  `iq_name` varchar(255) NOT NULL DEFAULT '',
  `iq_email` varchar(255) NOT NULL DEFAULT '',
  `iq_hp` varchar(255) NOT NULL DEFAULT '',
  `iq_password` varchar(255) NOT NULL DEFAULT '',
  `iq_subject` varchar(255) NOT NULL DEFAULT '',
  `iq_question` text NOT NULL,
  `iq_answer` text NOT NULL,
  `iq_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `iq_ip` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`iq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_qa`
--

LOCK TABLES `g5_shop_item_qa` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_qa` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_qa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_relation`
--

DROP TABLE IF EXISTS `g5_shop_item_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_relation` (
  `it_id` varchar(20) NOT NULL DEFAULT '',
  `it_id2` varchar(20) NOT NULL DEFAULT '',
  `ir_no` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`it_id`,`it_id2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_relation`
--

LOCK TABLES `g5_shop_item_relation` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_stocksms`
--

DROP TABLE IF EXISTS `g5_shop_item_stocksms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_stocksms` (
  `ss_id` int(11) NOT NULL AUTO_INCREMENT,
  `it_id` varchar(20) NOT NULL DEFAULT '',
  `ss_hp` varchar(255) NOT NULL DEFAULT '',
  `ss_send` tinyint(4) NOT NULL DEFAULT 0,
  `ss_send_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ss_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ss_ip` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`ss_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_stocksms`
--

LOCK TABLES `g5_shop_item_stocksms` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_stocksms` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_stocksms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_item_use`
--

DROP TABLE IF EXISTS `g5_shop_item_use`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_item_use` (
  `is_id` int(11) NOT NULL AUTO_INCREMENT,
  `it_id` varchar(20) NOT NULL DEFAULT '0',
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `is_name` varchar(255) NOT NULL DEFAULT '',
  `is_password` varchar(255) NOT NULL DEFAULT '',
  `is_score` tinyint(4) NOT NULL DEFAULT 0,
  `is_subject` varchar(255) NOT NULL DEFAULT '',
  `is_content` text NOT NULL,
  `is_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_ip` varchar(25) NOT NULL DEFAULT '',
  `is_confirm` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`is_id`),
  KEY `index1` (`it_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_item_use`
--

LOCK TABLES `g5_shop_item_use` WRITE;
/*!40000 ALTER TABLE `g5_shop_item_use` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_item_use` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order`
--

DROP TABLE IF EXISTS `g5_shop_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order` (
  `od_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `od_name` varchar(20) NOT NULL DEFAULT '',
  `od_email` varchar(100) NOT NULL DEFAULT '',
  `od_tel` varchar(20) NOT NULL DEFAULT '',
  `od_hp` varchar(20) NOT NULL DEFAULT '',
  `od_zip1` char(3) NOT NULL DEFAULT '',
  `od_zip2` char(3) NOT NULL DEFAULT '',
  `od_addr1` varchar(100) NOT NULL DEFAULT '',
  `od_addr2` varchar(100) NOT NULL DEFAULT '',
  `od_addr3` varchar(255) NOT NULL DEFAULT '',
  `od_addr_jibeon` varchar(255) NOT NULL DEFAULT '',
  `od_deposit_name` varchar(20) NOT NULL DEFAULT '',
  `od_b_name` varchar(20) NOT NULL DEFAULT '',
  `od_b_tel` varchar(20) NOT NULL DEFAULT '',
  `od_b_hp` varchar(20) NOT NULL DEFAULT '',
  `od_b_zip1` char(3) NOT NULL DEFAULT '',
  `od_b_zip2` char(3) NOT NULL DEFAULT '',
  `od_b_addr1` varchar(100) NOT NULL DEFAULT '',
  `od_b_addr2` varchar(100) NOT NULL DEFAULT '',
  `od_b_addr3` varchar(255) NOT NULL DEFAULT '',
  `od_b_addr_jibeon` varchar(255) NOT NULL DEFAULT '',
  `od_memo` text NOT NULL,
  `od_cart_count` int(11) NOT NULL DEFAULT 0,
  `od_cart_price` int(11) NOT NULL DEFAULT 0,
  `od_cart_coupon` int(11) NOT NULL DEFAULT 0,
  `od_send_cost` int(11) NOT NULL DEFAULT 0,
  `od_send_cost2` int(11) NOT NULL DEFAULT 0,
  `od_send_coupon` int(11) NOT NULL DEFAULT 0,
  `od_receipt_price` int(11) NOT NULL DEFAULT 0,
  `od_cancel_price` int(11) NOT NULL DEFAULT 0,
  `od_receipt_point` int(11) NOT NULL DEFAULT 0,
  `od_refund_price` int(11) NOT NULL DEFAULT 0,
  `od_bank_account` varchar(255) NOT NULL DEFAULT '',
  `od_receipt_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `od_coupon` int(11) NOT NULL DEFAULT 0,
  `od_misu` int(11) NOT NULL DEFAULT 0,
  `od_shop_memo` text NOT NULL,
  `od_mod_history` text NOT NULL,
  `od_status` varchar(255) NOT NULL DEFAULT '',
  `od_hope_date` date NOT NULL DEFAULT '0000-00-00',
  `od_settle_case` varchar(255) NOT NULL DEFAULT '',
  `od_other_pay_type` varchar(100) NOT NULL DEFAULT '',
  `od_test` tinyint(4) NOT NULL DEFAULT 0,
  `od_mobile` tinyint(4) NOT NULL DEFAULT 0,
  `od_pg` varchar(255) NOT NULL DEFAULT '',
  `od_tno` varchar(255) NOT NULL DEFAULT '',
  `od_app_no` varchar(20) NOT NULL DEFAULT '',
  `od_escrow` tinyint(4) NOT NULL DEFAULT 0,
  `od_casseqno` varchar(255) NOT NULL DEFAULT '',
  `od_tax_flag` tinyint(4) NOT NULL DEFAULT 0,
  `od_tax_mny` int(11) NOT NULL DEFAULT 0,
  `od_vat_mny` int(11) NOT NULL DEFAULT 0,
  `od_free_mny` int(11) NOT NULL DEFAULT 0,
  `od_delivery_company` varchar(255) NOT NULL DEFAULT '0',
  `od_invoice` varchar(255) NOT NULL DEFAULT '',
  `od_invoice_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `od_cash` tinyint(4) NOT NULL,
  `od_cash_no` varchar(255) NOT NULL,
  `od_cash_info` text NOT NULL,
  `od_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `od_pwd` varchar(255) NOT NULL DEFAULT '',
  `od_ip` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`od_id`),
  KEY `index2` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order`
--

LOCK TABLES `g5_shop_order` WRITE;
/*!40000 ALTER TABLE `g5_shop_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order_address`
--

DROP TABLE IF EXISTS `g5_shop_order_address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order_address` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `ad_subject` varchar(255) NOT NULL DEFAULT '',
  `ad_default` tinyint(4) NOT NULL DEFAULT 0,
  `ad_name` varchar(255) NOT NULL DEFAULT '',
  `ad_tel` varchar(255) NOT NULL DEFAULT '',
  `ad_hp` varchar(255) NOT NULL DEFAULT '',
  `ad_zip1` char(3) NOT NULL DEFAULT '',
  `ad_zip2` char(3) NOT NULL DEFAULT '',
  `ad_addr1` varchar(255) NOT NULL DEFAULT '',
  `ad_addr2` varchar(255) NOT NULL DEFAULT '',
  `ad_addr3` varchar(255) NOT NULL DEFAULT '',
  `ad_jibeon` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`ad_id`),
  KEY `mb_id` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order_address`
--

LOCK TABLES `g5_shop_order_address` WRITE;
/*!40000 ALTER TABLE `g5_shop_order_address` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order_address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order_data`
--

DROP TABLE IF EXISTS `g5_shop_order_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order_data` (
  `od_id` bigint(20) unsigned NOT NULL,
  `cart_id` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `dt_pg` varchar(255) NOT NULL DEFAULT '',
  `dt_data` text NOT NULL,
  `dt_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `od_id` (`od_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order_data`
--

LOCK TABLES `g5_shop_order_data` WRITE;
/*!40000 ALTER TABLE `g5_shop_order_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order_delete`
--

DROP TABLE IF EXISTS `g5_shop_order_delete`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order_delete` (
  `de_id` int(11) NOT NULL AUTO_INCREMENT,
  `de_key` varchar(255) NOT NULL DEFAULT '',
  `de_data` longtext NOT NULL,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `de_ip` varchar(255) NOT NULL DEFAULT '',
  `de_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`de_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order_delete`
--

LOCK TABLES `g5_shop_order_delete` WRITE;
/*!40000 ALTER TABLE `g5_shop_order_delete` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order_delete` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_order_post_log`
--

DROP TABLE IF EXISTS `g5_shop_order_post_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_order_post_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` bigint(20) unsigned NOT NULL,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `post_data` text NOT NULL,
  `ol_code` varchar(255) NOT NULL DEFAULT '',
  `ol_msg` text NOT NULL,
  `ol_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ol_ip` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_order_post_log`
--

LOCK TABLES `g5_shop_order_post_log` WRITE;
/*!40000 ALTER TABLE `g5_shop_order_post_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_order_post_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_personalpay`
--

DROP TABLE IF EXISTS `g5_shop_personalpay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_personalpay` (
  `pp_id` bigint(20) unsigned NOT NULL,
  `od_id` bigint(20) unsigned NOT NULL,
  `pp_name` varchar(255) NOT NULL DEFAULT '',
  `pp_email` varchar(255) NOT NULL DEFAULT '',
  `pp_hp` varchar(255) NOT NULL DEFAULT '',
  `pp_content` text NOT NULL,
  `pp_use` tinyint(4) NOT NULL DEFAULT 0,
  `pp_price` int(11) NOT NULL DEFAULT 0,
  `pp_pg` varchar(255) NOT NULL DEFAULT '',
  `pp_tno` varchar(255) NOT NULL DEFAULT '',
  `pp_app_no` varchar(20) NOT NULL DEFAULT '',
  `pp_casseqno` varchar(255) NOT NULL DEFAULT '',
  `pp_receipt_price` int(11) NOT NULL DEFAULT 0,
  `pp_settle_case` varchar(255) NOT NULL DEFAULT '',
  `pp_bank_account` varchar(255) NOT NULL DEFAULT '',
  `pp_deposit_name` varchar(255) NOT NULL DEFAULT '',
  `pp_receipt_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pp_receipt_ip` varchar(255) NOT NULL DEFAULT '',
  `pp_shop_memo` text NOT NULL,
  `pp_cash` tinyint(4) NOT NULL DEFAULT 0,
  `pp_cash_no` varchar(255) NOT NULL DEFAULT '',
  `pp_cash_info` text NOT NULL,
  `pp_ip` varchar(255) NOT NULL DEFAULT '',
  `pp_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pp_id`),
  KEY `od_id` (`od_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_personalpay`
--

LOCK TABLES `g5_shop_personalpay` WRITE;
/*!40000 ALTER TABLE `g5_shop_personalpay` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_personalpay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_sendcost`
--

DROP TABLE IF EXISTS `g5_shop_sendcost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_sendcost` (
  `sc_id` int(11) NOT NULL AUTO_INCREMENT,
  `sc_name` varchar(255) NOT NULL DEFAULT '',
  `sc_zip1` varchar(10) NOT NULL DEFAULT '',
  `sc_zip2` varchar(10) NOT NULL DEFAULT '',
  `sc_price` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`sc_id`),
  KEY `sc_zip1` (`sc_zip1`),
  KEY `sc_zip2` (`sc_zip2`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_sendcost`
--

LOCK TABLES `g5_shop_sendcost` WRITE;
/*!40000 ALTER TABLE `g5_shop_sendcost` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_sendcost` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_shop_wish`
--

DROP TABLE IF EXISTS `g5_shop_wish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_shop_wish` (
  `wi_id` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `it_id` varchar(20) NOT NULL DEFAULT '0',
  `wi_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wi_ip` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`wi_id`),
  KEY `index1` (`mb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_shop_wish`
--

LOCK TABLES `g5_shop_wish` WRITE;
/*!40000 ALTER TABLE `g5_shop_wish` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_shop_wish` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_social_profile`
--

DROP TABLE IF EXISTS `g5_social_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_social_profile` (
  `mp_no` int(11) NOT NULL AUTO_INCREMENT,
  `mb_id` varchar(255) NOT NULL DEFAULT '',
  `provider` varchar(50) NOT NULL DEFAULT '',
  `object_sha` varchar(45) NOT NULL DEFAULT '',
  `identifier` varchar(255) NOT NULL DEFAULT '',
  `profileurl` varchar(255) NOT NULL DEFAULT '',
  `photourl` varchar(255) NOT NULL DEFAULT '',
  `displayname` varchar(150) NOT NULL DEFAULT '',
  `description` varchar(255) NOT NULL DEFAULT '',
  `mp_register_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mp_latest_day` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY `mp_no` (`mp_no`),
  KEY `mb_id` (`mb_id`),
  KEY `provider` (`provider`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_social_profile`
--

LOCK TABLES `g5_social_profile` WRITE;
/*!40000 ALTER TABLE `g5_social_profile` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_social_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_tree_category_add`
--

DROP TABLE IF EXISTS `g5_tree_category_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_tree_category_add` (
  `tc_id` int(11) NOT NULL AUTO_INCREMENT,
  `tc_code` varchar(20) NOT NULL DEFAULT '',
  `tc_name` varchar(255) NOT NULL DEFAULT '',
  `tc_link` varchar(255) NOT NULL DEFAULT '',
  `tc_target` varchar(10) NOT NULL DEFAULT '',
  `tc_order` int(11) NOT NULL DEFAULT 0,
  `tc_use` tinyint(4) NOT NULL DEFAULT 1,
  `tc_menu_use` tinyint(4) NOT NULL DEFAULT 1,
  `tc_regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`tc_id`),
  UNIQUE KEY `tc_code` (`tc_code`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_tree_category_add`
--

LOCK TABLES `g5_tree_category_add` WRITE;
/*!40000 ALTER TABLE `g5_tree_category_add` DISABLE KEYS */;
INSERT INTO `g5_tree_category_add` VALUES (1,'10','제품소개','','',0,1,1,'2025-12-27 18:32:07'),(2,'1010','대문','','',0,1,1,'2025-12-27 18:34:00'),(3,'1020','자동대문','','',0,1,1,'2025-12-27 18:35:07'),(4,'101010','단조재문','','',2,1,1,'2025-12-27 18:36:12'),(5,'101020','목재대문','','',1,1,1,'2025-12-27 18:37:10'),(7,'101030','슬라이딩게이트','','',0,1,0,'2025-12-27 18:49:23'),(8,'101040','테스트3','','',0,1,1,'2025-12-28 10:57:01'),(9,'10101010','aaaa','','',0,1,1,'2025-12-28 12:38:20'),(10,'102010','1111','','',0,1,1,'2025-12-29 09:30:49'),(11,'20','시공사례','chamcode_gallery','',0,1,1,'2026-01-12 13:44:13'),(12,'2010','RESIDENCE','/bbs/board.php?bo_table=chamcode_gallery&me_code=3030','',1,1,1,'2026-01-12 14:02:13'),(13,'2020',' COMMERCIAL','','',2,1,1,'2026-01-12 14:02:49'),(14,'201010','서울','','',0,1,1,'2026-01-12 14:22:05'),(15,'201020','인천','','',0,1,1,'2026-01-12 14:22:25'),(16,'201030','청주','','',0,1,1,'2026-01-12 16:03:48'),(17,'20101010','은평구','','',0,1,1,'2026-01-12 16:49:32'),(18,'30','포토폴리오','Portfolio','',0,1,1,'2026-01-14 13:09:09'),(19,'3010','기업','','',0,1,1,'2026-01-14 13:09:32'),(20,'3020','개인','','',0,1,1,'2026-01-14 13:09:48'),(21,'301010','여자','','',0,1,1,'2026-01-14 13:19:10');
/*!40000 ALTER TABLE `g5_tree_category_add` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_uniqid`
--

DROP TABLE IF EXISTS `g5_uniqid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_uniqid` (
  `uq_id` bigint(20) unsigned NOT NULL,
  `uq_ip` varchar(255) NOT NULL,
  PRIMARY KEY (`uq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_uniqid`
--

LOCK TABLES `g5_uniqid` WRITE;
/*!40000 ALTER TABLE `g5_uniqid` DISABLE KEYS */;
INSERT INTO `g5_uniqid` VALUES (2025121812481828,'::1'),(2025121812482330,'::1'),(2025121812584312,'::1'),(2025121813020886,'::1'),(2025121813225718,'::1'),(2025121813231723,'::1'),(2025121813232660,'::1'),(2025121813235475,'::1'),(2025121813260650,'::1'),(2025121813280337,'::1'),(2025121813283624,'::1'),(2025121813284930,'::1'),(2025121813285013,'::1'),(2025121813290719,'::1'),(2025121813294942,'::1'),(2025121813304865,'::1'),(2025121813315847,'::1'),(2025121813324181,'::1'),(2025121813400694,'::1'),(2025121813491101,'::1'),(2025121814035821,'::1'),(2025122215385651,'::1'),(2025122215391413,'::1'),(2025122215395708,'::1'),(2025122215420605,'::1'),(2025122215433649,'::1'),(2025122215433920,'::1'),(2025122215441991,'::1'),(2025122215442055,'::1'),(2025122215442107,'::1'),(2025122215442134,'::1'),(2025122215442163,'::1'),(2025122215463878,'::1'),(2025122309541994,'::1'),(2025122309543456,'::1'),(2025122309554350,'::1'),(2025122309560172,'::1'),(2025122309561177,'::1'),(2025122310043643,'::1'),(2025122310114092,'::1'),(2025122310134186,'::1'),(2025122310164451,'::1'),(2025122310181456,'::1'),(2025122310375919,'::1'),(2025122311470887,'::1'),(2025122312241228,'::1'),(2025122312542632,'::1'),(2025122313022139,'::1'),(2025122313035716,'::1'),(2025122313044973,'::1'),(2025122313060117,'::1'),(2025122313130172,'::1'),(2025122313202472,'::1'),(2025122313591292,'::1'),(2025122313592167,'::1'),(2025122314102513,'::1'),(2025122314104216,'::1'),(2025122314104309,'::1'),(2025122314104849,'::1'),(2025122314110368,'::1'),(2025122314110730,'::1'),(2025122314133416,'::1'),(2025122314134193,'::1'),(2025122314145371,'::1'),(2025122314203742,'::1'),(2025122314263448,'::1'),(2025122717204963,'::1'),(2025122717320139,'::1'),(2025122811050781,'::1'),(2025122811053600,'::1'),(2025122811102053,'::1'),(2025122811103306,'::1'),(2025122811104379,'::1'),(2025122811172309,'::1'),(2025122811172863,'::1'),(2025122811181567,'::1'),(2025122811194125,'::1'),(2025122811195704,'::1'),(2025122811200566,'::1'),(2025122811213925,'::1'),(2025122811552328,'::1'),(2025122811563520,'::1'),(2025122811565233,'::1'),(2025122811570136,'::1'),(2025122811572275,'::1'),(2025122811572635,'::1'),(2025122811574297,'::1'),(2025122811580868,'::1'),(2025122811591454,'::1'),(2025122811591764,'::1'),(2025122812000549,'::1'),(2025122812001264,'::1'),(2025122812001784,'::1'),(2025122812065647,'::1'),(2025122812074982,'::1'),(2025122812112372,'::1'),(2025122812122175,'::1'),(2025122812155901,'::1'),(2025122812171321,'::1'),(2025122812175435,'::1'),(2025122812194508,'::1'),(2025122812200727,'::1'),(2025122812223287,'::1'),(2025122812232789,'::1'),(2025122812294212,'::1'),(2025122812294732,'::1'),(2025122812301531,'::1'),(2025122812303405,'::1'),(2025122812324692,'::1'),(2025122812343373,'::1'),(2025122812352998,'::1'),(2025122812383773,'::1'),(2025122812394863,'::1'),(2025122812411533,'::1'),(2025122812425151,'::1'),(2025122812480029,'::1'),(2025122812480979,'::1'),(2025122812492130,'::1'),(2025122812510718,'::1'),(2025122812540064,'::1'),(2025122812554589,'::1'),(2025122812560138,'::1'),(2025122812572707,'::1'),(2025122812584085,'::1'),(2025122812584578,'::1'),(2025122812585710,'::1'),(2025122812590621,'::1'),(2025122812592236,'::1'),(2025122813002470,'::1'),(2025122813010355,'::1'),(2025122813023515,'::1'),(2025122813080037,'::1'),(2025122813082337,'::1'),(2025122813112700,'::1'),(2025122813113564,'::1'),(2025122813115180,'::1'),(2025122813132535,'::1'),(2025122813154648,'::1'),(2025122813164239,'::1'),(2025122813165929,'::1'),(2025122813171360,'::1'),(2025122813184197,'::1'),(2025122813184864,'::1'),(2025122813454838,'::1'),(2025122813464276,'::1'),(2025122814390791,'::1'),(2025122815041438,'::1'),(2025122815050651,'::1'),(2025122815053428,'::1'),(2025122815070975,'::1'),(2025122815075912,'::1'),(2025122815084336,'::1'),(2025122815085747,'::1'),(2025122815091177,'::1'),(2025122815102261,'::1'),(2025122815121098,'::1'),(2025122815121268,'::1'),(2025122815121354,'::1'),(2025122815121375,'::1'),(2025122815121766,'::1'),(2025122815123579,'::1'),(2025122815145089,'::1'),(2025122815162969,'::1'),(2025122815182877,'::1'),(2025122909311895,'::1'),(2025122909312972,'::1'),(2025122909313889,'::1'),(2025122909324282,'::1'),(2025122909331780,'::1'),(2025122910532236,'::1'),(2025122910575304,'::1'),(2025122910582378,'::1'),(2025122911171625,'::1'),(2025122911172598,'::1'),(2025122911302561,'::1'),(2025122912224479,'::1'),(2025122912234197,'::1'),(2025122912240601,'::1'),(2025122912252187,'::1'),(2025122912254859,'::1'),(2025122912282574,'::1'),(2025122912284217,'::1'),(2025122912303432,'::1'),(2025122912304363,'::1'),(2025122912315346,'::1'),(2025122912321437,'::1'),(2025122912350552,'::1'),(2025122912355688,'::1'),(2025122912383373,'::1'),(2025122912385069,'::1'),(2025122912385833,'::1'),(2025122912410058,'::1'),(2025122912434623,'::1'),(2025122912503354,'::1'),(2025122912514614,'::1'),(2025122912560194,'::1'),(2025122912565886,'::1'),(2025122912573076,'::1'),(2025122912592567,'::1'),(2025122913281770,'::1'),(2025122913334989,'::1'),(2025122913464743,'::1'),(2025122913481967,'::1'),(2025122914030344,'::1'),(2025122914190438,'::1'),(2025122914231618,'::1'),(2025123016033657,'::1'),(2026011213392227,'::1'),(2026011213573899,'::1'),(2026011214042422,'::1'),(2026011214044594,'::1'),(2026011214075062,'::1'),(2026011214340596,'::1'),(2026011214380009,'::1'),(2026011214380054,'::1'),(2026011214383283,'::1'),(2026011214433667,'::1'),(2026011214440351,'::1'),(2026011214440780,'::1'),(2026011215074171,'::1'),(2026011215080720,'::1'),(2026011215090014,'::1'),(2026011215091049,'::1'),(2026011215091310,'::1'),(2026011215270908,'::1'),(2026011215273785,'::1'),(2026011215283286,'::1'),(2026011215351683,'::1'),(2026011215353838,'::1'),(2026011215482203,'::1'),(2026011215494359,'::1'),(2026011215542661,'::1'),(2026011216000166,'::1'),(2026011216001046,'::1'),(2026011216010531,'::1'),(2026011216035877,'::1'),(2026011216043415,'::1'),(2026011216434235,'::1'),(2026011216454116,'::1'),(2026011216482179,'::1'),(2026011216495934,'::1'),(2026011309504179,'::1'),(2026011309505217,'::1'),(2026011309533705,'::1'),(2026011309561004,'::1'),(2026011309561853,'::1'),(2026011309562543,'::1'),(2026011310325344,'::1'),(2026011310391305,'::1'),(2026011310402709,'::1'),(2026011310422175,'::1'),(2026011310422299,'::1'),(2026011310422332,'::1'),(2026011310454822,'::1'),(2026011310460994,'::1'),(2026011310482676,'::1'),(2026011310511975,'::1'),(2026011310545997,'::1'),(2026011311413854,'::1'),(2026011311451479,'::1'),(2026011311492287,'::1'),(2026011311500200,'::1'),(2026011311515403,'::1'),(2026011311523539,'::1'),(2026011311574767,'::1'),(2026011311581509,'::1'),(2026011312104312,'::1'),(2026011312110482,'::1'),(2026011312132545,'::1'),(2026011312134049,'::1'),(2026011312282259,'::1'),(2026011312284789,'::1'),(2026011312290083,'::1'),(2026011312293197,'::1'),(2026011312295574,'::1'),(2026011312311197,'::1'),(2026011312334867,'::1'),(2026011312353817,'::1'),(2026011312531708,'::1'),(2026011312550321,'::1'),(2026011312591236,'::1'),(2026011313052008,'::1'),(2026011313064166,'::1'),(2026011313162603,'::1'),(2026011313185305,'::1'),(2026011313363817,'::1'),(2026011313370852,'::1'),(2026011313400572,'::1'),(2026011313403192,'::1'),(2026011315220694,'::1'),(2026011315254810,'::1'),(2026011315341849,'::1'),(2026011315342856,'::1'),(2026011315345073,'::1'),(2026011315364109,'::1'),(2026011315372215,'::1'),(2026011315375285,'::1'),(2026011315454478,'::1'),(2026011315455699,'::1'),(2026011315481906,'::1'),(2026011315561257,'::1'),(2026011315562300,'::1'),(2026011315563226,'::1'),(2026011316213014,'::1'),(2026011316332087,'::1'),(2026011316370781,'::1'),(2026011408545951,'::1'),(2026011408564596,'::1'),(2026011408580182,'::1'),(2026011408581133,'::1'),(2026011409035064,'::1'),(2026011409064476,'::1'),(2026011409092274,'::1'),(2026011409094375,'::1'),(2026011409104450,'::1'),(2026011409120293,'::1'),(2026011409201878,'::1'),(2026011409202557,'::1'),(2026011409213738,'::1'),(2026011409245572,'::1'),(2026011409250069,'::1'),(2026011409404819,'::1'),(2026011410032420,'::1'),(2026011410033218,'::1'),(2026011410061672,'::1'),(2026011410063532,'::1'),(2026011410064256,'::1'),(2026011410065350,'::1'),(2026011410072145,'::1'),(2026011410110088,'::1'),(2026011410125099,'::1'),(2026011410223945,'::1'),(2026011412441079,'::1'),(2026011412473063,'::1'),(2026011412511196,'::1'),(2026011412514107,'::1'),(2026011412515736,'::1'),(2026011413012590,'::1'),(2026011413012730,'::1'),(2026011413034322,'::1'),(2026011413034838,'::1'),(2026011413103881,'::1'),(2026011413153202,'::1'),(2026011413153303,'::1'),(2026011413154847,'::1'),(2026011413165555,'::1'),(2026011413165715,'::1'),(2026011413170060,'::1'),(2026011413170709,'::1'),(2026011413183830,'::1'),(2026011413191807,'::1'),(2026011413264787,'::1'),(2026011413284337,'::1'),(2026011413322626,'::1'),(2026011413354374,'::1'),(2026011413362902,'::1'),(2026011413384014,'::1'),(2026011413384856,'::1'),(2026011413405802,'::1'),(2026011413410538,'::1'),(2026011413410706,'::1'),(2026011413435671,'::1'),(2026011413440531,'::1'),(2026011413440777,'::1'),(2026011413465942,'::1'),(2026011413470100,'::1'),(2026011413492022,'::1'),(2026011413513740,'::1'),(2026011413555640,'::1'),(2026011414020806,'::1'),(2026011414033524,'::1'),(2026011414035116,'::1'),(2026011414050482,'::1'),(2026011414102062,'::1'),(2026011414104018,'::1'),(2026011414104497,'::1'),(2026011414141488,'::1'),(2026011414162287,'::1'),(2026011414302819,'::1'),(2026011414304118,'::1'),(2026011414305150,'::1'),(2026011415040709,'::1'),(2026011415045562,'::1'),(2026011415114043,'::1'),(2026011415171112,'::1'),(2026011415561492,'::1'),(2026011415565521,'::1'),(2026011415573743,'::1'),(2026011415584484,'::1'),(2026011415594033,'::1'),(2026011416051821,'::1'),(2026011416071859,'::1'),(2026011416081802,'::1'),(2026011416090331,'::1'),(2026011416123287,'::1'),(2026011509514387,'::1'),(2026011510043563,'::1'),(2026011510074790,'::1'),(2026011510110889,'::1'),(2026011510125332,'::1'),(2026011510125603,'::1'),(2026011510155572,'::1'),(2026011510183441,'::1'),(2026011510192534,'::1'),(2026011510214186,'::1'),(2026011510302271,'::1'),(2026011510370859,'::1'),(2026011510414719,'::1'),(2026011510455569,'::1'),(2026011510475355,'::1'),(2026011511084399,'::1'),(2026011511155843,'::1'),(2026011511204604,'::1'),(2026011511235185,'::1'),(2026011511291226,'::1'),(2026011511291656,'::1'),(2026011511292160,'::1'),(2026011511293396,'::1'),(2026011511294727,'::1'),(2026011511300672,'::1'),(2026011511342397,'::1'),(2026011511342536,'::1'),(2026011511343377,'::1'),(2026011511345089,'::1'),(2026011511345884,'::1'),(2026011511350218,'::1'),(2026011511350231,'::1'),(2026011511350249,'::1'),(2026011511350726,'::1'),(2026011511351613,'::1'),(2026011511352840,'::1'),(2026011511353015,'::1'),(2026011511353156,'::1'),(2026011511371783,'::1'),(2026011511372881,'::1'),(2026011511373009,'::1'),(2026011511375285,'::1'),(2026031016125518,'::1'),(2026031016133567,'::1'),(2026031110054328,'::1'),(2026031715502122,'::1');
/*!40000 ALTER TABLE `g5_uniqid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_visit`
--

DROP TABLE IF EXISTS `g5_visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_visit` (
  `vi_id` int(11) NOT NULL AUTO_INCREMENT,
  `vi_ip` varchar(100) NOT NULL DEFAULT '',
  `vi_date` date NOT NULL DEFAULT '0000-00-00',
  `vi_time` time NOT NULL DEFAULT '00:00:00',
  `vi_referer` text NOT NULL,
  `vi_agent` varchar(200) NOT NULL DEFAULT '',
  `vi_browser` varchar(255) NOT NULL DEFAULT '',
  `vi_os` varchar(255) NOT NULL DEFAULT '',
  `vi_device` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`vi_id`),
  UNIQUE KEY `index1` (`vi_ip`,`vi_date`),
  KEY `index2` (`vi_date`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_visit`
--

LOCK TABLES `g5_visit` WRITE;
/*!40000 ALTER TABLE `g5_visit` DISABLE KEYS */;
INSERT INTO `g5_visit` VALUES (1,'::1','2025-12-13','16:00:07','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(2,'::1','2025-12-14','14:06:16','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36 Edg/129.0.0.0','','',''),(3,'::1','2025-12-15','08:25:04','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(4,'::1','2025-12-16','08:28:00','http://localhost/plugin/map_api/adm/config_form.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(5,'::1','2025-12-17','09:06:00','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(6,'::1','2025-12-18','09:11:27','http://localhost/plugin/company_intro/adm/list.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(7,'::1','2025-12-19','09:12:17','http://localhost/plugin/top_menu_manager/admin.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(8,'::1','2025-12-20','11:52:49','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(9,'::1','2025-12-21','11:52:52','http://localhost/plugin/main_image_manager/adm/list.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(10,'::1','2025-12-22','11:58:21','http://localhost/plugin/copyright_manager/admin.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(11,'::1','2025-12-23','12:05:27','http://localhost/bbs/write.php?w=u&bo_table=chamcode_gallery&wr_id=3&page=','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(12,'::1','2025-12-24','12:10:47','http://localhost/bbs/content.php?co_id=ceo&me_code=1020','Mozilla/5.0 (Linux; U; Android 4.1; en-us; GT-N7100 Build/JRO03C) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30','','',''),(13,'::1','2025-12-25','12:11:01','http://localhost/plugin/main_content_manager/adm/list.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(14,'::1','2025-12-26','12:11:27','http://localhost/plugin/top_menu_manager/admin.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(15,'::1','2025-12-27','12:14:46','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(16,'::1','2025-12-28','12:15:58','http://localhost/bbs/board.php?bo_table=product&me_code=2010','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(17,'::1','2025-12-29','12:22:44','http://localhost/bbs/board.php?bo_table=product&cate=101040','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(18,'::1','2025-12-30','12:40:43','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(19,'::1','2025-12-31','17:52:21','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(20,'::1','2026-01-01','17:53:01','http://localhost/plugin/main_image_manager/adm/list.php?style=basic','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(21,'::1','2026-01-02','15:32:56','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(22,'::1','2026-01-03','15:28:51','','Go-http-client/1.1','','',''),(23,'127.0.0.1','2026-01-03','18:05:34','','','','',''),(24,'::1','2026-01-05','08:29:37','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(25,'::1','2026-01-06','09:05:17','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(26,'::1','2026-01-07','10:03:46','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(27,'::1','2026-01-08','10:08:37','http://localhost/plugin/map_api/adm/write.php','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(28,'::1','2026-01-09','09:47:08','','','','',''),(29,'::1','2026-01-10','11:37:22','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(30,'::1','2026-01-12','08:38:17','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(31,'::1','2026-01-13','09:48:19','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(32,'::1','2026-01-14','09:55:03','http://localhost/bbs/write.php?w=u&bo_table=chamcode_gallery&wr_id=22&me_code=3030&page=1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(33,'::1','2026-01-15','09:56:05','http://localhost/bbs/board.php?bo_table=Portfolio&me_code=20&sfl=ca_name&stx=%EA%B8%B0%EC%97%85','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(34,'::1','2026-01-16','09:24:42','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(35,'::1','2026-01-17','13:00:52','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(36,'::1','2026-01-20','10:31:39','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(37,'::1','2026-01-22','15:47:13','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(38,'::1','2026-01-24','12:30:20','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','','',''),(39,'::1','2026-01-26','08:53:45','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36','','',''),(40,'127.0.0.1','2026-01-26','16:33:34','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36','','',''),(41,'::1','2026-02-09','09:15:59','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36','','',''),(42,'127.0.0.1','2026-02-25','13:51:10','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','','',''),(43,'::1','2026-02-25','13:51:36','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','','',''),(44,'::1','2026-03-09','08:43:46','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','','',''),(45,'::1','2026-03-10','16:12:11','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','','',''),(46,'::1','2026-03-13','12:29:38','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','','',''),(51,'::1','2026-03-14','08:41:53','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','','',''),(52,'::1','2026-03-15','10:06:57','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','','',''),(59,'::1','2026-03-16','09:06:19','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','','',''),(62,'127.0.0.1','2026-03-16','20:19:01','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','','',''),(63,'::1','2026-03-17','10:05:18','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','','',''),(66,'::1','2026-03-18','09:29:33','','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36','','','');
/*!40000 ALTER TABLE `g5_visit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_visit_sum`
--

DROP TABLE IF EXISTS `g5_visit_sum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_visit_sum` (
  `vs_date` date NOT NULL DEFAULT '0000-00-00',
  `vs_count` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`vs_date`),
  KEY `index1` (`vs_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_visit_sum`
--

LOCK TABLES `g5_visit_sum` WRITE;
/*!40000 ALTER TABLE `g5_visit_sum` DISABLE KEYS */;
INSERT INTO `g5_visit_sum` VALUES ('2025-12-13',1),('2025-12-14',1),('2025-12-15',1),('2025-12-16',1),('2025-12-17',1),('2025-12-18',1),('2025-12-19',1),('2025-12-20',1),('2025-12-21',1),('2025-12-22',1),('2025-12-23',1),('2025-12-24',1),('2025-12-25',1),('2025-12-26',1),('2025-12-27',1),('2025-12-28',1),('2025-12-29',1),('2025-12-30',1),('2025-12-31',1),('2026-01-01',1),('2026-01-02',1),('2026-01-05',1),('2026-01-06',1),('2026-01-07',1),('2026-01-08',1),('2026-01-09',1),('2026-01-10',1),('2026-01-12',1),('2026-01-13',1),('2026-01-14',1),('2026-01-15',1),('2026-01-16',1),('2026-01-17',1),('2026-01-20',1),('2026-01-22',1),('2026-01-24',1),('2026-02-09',1),('2026-03-09',1),('2026-03-10',1),('2026-03-13',1),('2026-03-14',1),('2026-03-15',1),('2026-03-17',1),('2026-03-18',1),('2026-01-03',2),('2026-01-26',2),('2026-02-25',2),('2026-03-16',2);
/*!40000 ALTER TABLE `g5_visit_sum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_chamcode_gallery`
--

DROP TABLE IF EXISTS `g5_write_chamcode_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_chamcode_gallery` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT 0,
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT 0,
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `wr_comment` int(11) NOT NULL DEFAULT 0,
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT 0,
  `wr_link2_hit` int(11) NOT NULL DEFAULT 0,
  `wr_hit` int(11) NOT NULL DEFAULT 0,
  `wr_good` int(11) NOT NULL DEFAULT 0,
  `wr_nogood` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `wr_file` tinyint(4) NOT NULL DEFAULT 0,
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_chamcode_gallery`
--

LOCK TABLES `g5_write_chamcode_gallery` WRITE;
/*!40000 ALTER TABLE `g5_write_chamcode_gallery` DISABLE KEYS */;
INSERT INTO `g5_write_chamcode_gallery` VALUES (1,-1,'',1,0,0,'','','html1','청주에서 시공한사진입니다.','<p>청주에서 시공한사진입니다.<br>청주에서 시공한사진입니다.<br>청주에서 시공한사진입니다.</p><p><img src=\"http://localhost/data/editor/2512/KakaoTalk_20251215_164920274.jpg\" title=\"KakaoTalk_20251215_164920274.jpg\"><br style=\"clear:both;\">&nbsp;</p>','청주에서-시공한사진입니다','','',0,0,2,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 10:19:48',1,'2025-12-23 10:19:48','::1','','','','','','','','','','','',''),(2,-2,'',2,0,0,'','','html1','청주시공','<p><img src=\"http://localhost/data/editor/2512/KakaoTalk_20251215_164920274%20%281%29.jpg\" title=\"KakaoTalk_20251215_164920274 (1).jpg\"><br style=\"clear:both;\">&nbsp;</p>','청주시공','','',0,0,2,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 10:35:47',1,'2025-12-23 10:35:47','::1','','','','','','','','','','','',''),(3,-3,'',3,0,2,'','','html1','율량동 시공업체','<div style=\"text-align: center;\"><img src=\"http://localhost/data/editor/2512/KakaoTalk_20251215_164920274%20%282%29.jpg\" title=\"KakaoTalk_20251215_164920274 (2).jpg\"></div>&nbsp;','율량동-시공업체','','',0,0,2,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 10:38:44',1,'2025-12-23 11:10:20','::1','','','','','','','','','','','',''),(4,-3,'',3,1,1,'','','','','dddddd','','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 11:09:37',0,'','::1','','','','','','','','','','','',''),(5,-3,'',3,1,2,'','','','','휼륭하네요~\r\n감사합니다.','','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 11:10:20',0,'','::1','','','','','','','','','','','',''),(6,-4,'',6,0,0,'','','html1','ㄴㄹㄴㄹ','<p>ㄴㄹㄴㄹㅇㄴㄹㅇㄴ<img src=\"http://localhost/data/editor/2512/1cbdb19e-35b9-435b-8ca3-ea0ac5beb4ce.png\" title=\"1cbdb19e-35b9-435b-8ca3-ea0ac5beb4ce.png\">&nbsp;</p>','ㄴㄹㄴㄹ','','',0,0,2,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 13:04:25',1,'2025-12-23 13:04:25','::1','','','','','','','','','','','',''),(7,-5,'',7,0,0,'','','html1','ㄹㄴㄹㄴ','<p><img src=\"http://localhost/data/editor/2512/ChatGPT%20Image%202025%EB%85%84%2012%EC%9B%94%204%EC%9D%BC%20%EC%98%A4%ED%9B%84%2012_42_27.png\" title=\"ChatGPT Image 2025년 12월 4일 오후 12_42_27.png\"><br style=\"clear:both;\">&nbsp;</p>','ㄹㄴㄹㄴ','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 13:05:34',1,'2025-12-23 13:05:34','::1','','','','','','','','','','','',''),(8,-6,'',8,0,0,'','','html1','ㄴㄹㄴㄹㅇ','<p>ㄴㄹㄴㄹㅇㄴ</p>','ㄴㄹㄴㄹㅇ','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 13:13:19',1,'2025-12-23 13:13:19','::1','','','','','','','','','','','',''),(9,-7,'',9,0,0,'','RESIDENCE','html1','ㄴㄹㄴㄹ','<p>ㄴㄹㄴㄹㅇ</p>','ㄴㄹㄴㄹ-1','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 12:35:44',0,'2026-01-13 12:35:44','::1','','','2010','','','','','','','','',''),(10,-8,'',10,0,0,'','RESIDENCE > 서울','html1','ㄴㄹㄴㄹㄴㅁ','<p>ㄻㄻㄹㅇㅁ</p>','ㄴㄹㄴㄹㄴㅁ','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 12:43:15',1,'2026-01-13 12:43:15','::1','','','201010','','','','','','','','',''),(11,-9,'',11,0,0,'','RESIDENCE','html1','ㅇㄴㄻㄻㄹ','<p>ㅁㄻㄻㄹ</p>','ㅇㄴㄻㄻㄹ','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 12:58:27',1,'2026-01-13 12:58:27','::1','','','2010','','','','','','','','',''),(12,-10,'',12,0,0,'','RESIDENCE > 서울','html1','ㅇㄴㄻ','<p>ㅇㅁㄻㄻㄹ</p>','ㅇㄴㄻ','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 13:05:34',1,'2026-01-13 13:05:34','::1','','','201010','','','','','','','','',''),(13,-11,'',13,0,0,'','RESIDENCE > 서울','html1','ㄱㅇㅎㄴ','<p>ㅎㄶㄹㄶㄶㄹ</p>','ㄱㅇㅎㄴ','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 13:06:58',1,'2026-01-13 13:06:58','::1','','','201010','','','','','','','','',''),(14,-12,'',14,0,0,'','RESIDENCE','html1','ㅇㄴㄹㄴㅁ','<p>ㄻㄻㄹㅇ</p>','ㅇㄴㄹㄴㅁ','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 13:16:34',0,'2026-01-13 13:16:34','::1','','','2010','','','','','','','','',''),(15,-13,'',15,0,0,'','RESIDENCE','html1','ㅁㅇㄻ','<p>ㄻㅇㅁㄻ</p>','ㅁㅇㄻ','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 13:19:00',0,'2026-01-13 13:19:00','::1','','','2010','','','','','','','','',''),(16,-14,'',16,0,0,'','RESIDENCE > 서울','html1','ㅁㅇㄻㄹㅇㅁ','<p>ㄻㄻㄻ</p>','ㅁㅇㄻㄹㅇㅁ','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 13:36:48',0,'2026-01-13 13:36:48','::1','','','201010','','','','','','','','',''),(17,-15,'',17,0,0,'','RESIDENCE','html1','ㅁㄻㄻㄹ','<p>ㄴㄻㄹㅇ</p>','ㅁㄻㄻㄹ','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 13:40:19',1,'2026-01-13 13:40:19','::1','','','2010','','','','','','','','',''),(18,-16,'',18,0,0,'','RESIDENCE > 서울','html1','ㅁㄻㄹ','<p>ㅁㅁㄻㄹㅇㅁ</p>','ㅁㄻㄹ','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 13:41:04',1,'2026-01-13 13:41:04','::1','','','201010','','','','','','','','',''),(19,-17,'',19,0,0,'','RESIDENCE > 서울','html1','dsfs','<p>dfdsfsfs</p>','dsfs','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 15:22:31',1,'2026-01-13 15:22:31','::1','','','201010','','','','','','','','',''),(20,-18,'',20,0,0,'','RESIDENCE > 인천','html1','ss','<p>fsfsfsfd</p>','ss','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 15:26:07',1,'2026-01-13 15:26:07','::1','','','201020','','','','','','','','',''),(21,-19,'',21,0,0,'','RESIDENCE > 서울','html1','ㅇㅁㄻ','<p>ㄻㄹㅇㅁㄹ</p>','ㅇㅁㄻ','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 16:33:43',2,'2026-01-13 16:33:43','::1','','','201010','','','','','','','','',''),(22,-20,'',22,0,0,'','RESIDENCE > 서울','html1','불광역 근처에서 폐건전지를 버리기 가장 확실하고','<p data-path-to-node=\"0\">불광역 근처에서 폐건전지를 버리기 가장 확실하고 좋은 곳은 **\'불광1동 주민센터\'**입니다.</p><p data-path-to-node=\"1\">가장 추천드리는 이유는 단순히 버리는 것을 넘어, 폐건전지를 모아가면 <b data-path-to-node=\"1\" data-index-in-node=\"39\">새 건전지로 교환</b>해주기 때문입니다.</p>','불광역-근처에서-폐건전지를-버리기-가장-확실하고','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-13 16:37:19',3,'2026-01-13 16:37:19','::1','','','201010','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_chamcode_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_dataroom`
--

DROP TABLE IF EXISTS `g5_write_dataroom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_dataroom` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT 0,
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT 0,
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `wr_comment` int(11) NOT NULL DEFAULT 0,
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT 0,
  `wr_link2_hit` int(11) NOT NULL DEFAULT 0,
  `wr_hit` int(11) NOT NULL DEFAULT 0,
  `wr_good` int(11) NOT NULL DEFAULT 0,
  `wr_nogood` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `wr_file` tinyint(4) NOT NULL DEFAULT 0,
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_dataroom`
--

LOCK TABLES `g5_write_dataroom` WRITE;
/*!40000 ALTER TABLE `g5_write_dataroom` DISABLE KEYS */;
INSERT INTO `g5_write_dataroom` VALUES (1,-1,'',1,0,0,'','','','자료실입니다.','자료실입니다.\r\n자료실입니다.\r\n자료실입니다.','자료실입니다','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 14:15:21',1,'2025-12-23 14:15:21','::1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_dataroom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_menu_add`
--

DROP TABLE IF EXISTS `g5_write_menu_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_menu_add` (
  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_code` varchar(255) NOT NULL DEFAULT '',
  `ma_name` varchar(255) NOT NULL DEFAULT '',
  `ma_link` varchar(255) NOT NULL DEFAULT '',
  `ma_target` varchar(255) NOT NULL DEFAULT '',
  `ma_order` int(11) NOT NULL DEFAULT 0,
  `ma_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_mobile_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_icon` varchar(255) NOT NULL DEFAULT '',
  `ma_regdt` datetime NOT NULL DEFAULT '0000-01-01 00:00:00',
  PRIMARY KEY (`ma_id`),
  KEY `ma_code` (`ma_code`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_menu_add`
--

LOCK TABLES `g5_write_menu_add` WRITE;
/*!40000 ALTER TABLE `g5_write_menu_add` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_menu_add` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_menu_pdc`
--

DROP TABLE IF EXISTS `g5_write_menu_pdc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_menu_pdc` (
  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_code` varchar(255) NOT NULL DEFAULT '',
  `ma_name` varchar(255) NOT NULL DEFAULT '',
  `ma_link` varchar(255) NOT NULL DEFAULT '',
  `ma_target` varchar(255) NOT NULL DEFAULT '',
  `ma_order` int(11) NOT NULL DEFAULT 0,
  `ma_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_mobile_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_menu_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_icon` varchar(255) NOT NULL DEFAULT '',
  `ma_regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`ma_id`),
  KEY `ma_code` (`ma_code`)
) ENGINE=InnoDB AUTO_INCREMENT=959 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_menu_pdc`
--

LOCK TABLES `g5_write_menu_pdc` WRITE;
/*!40000 ALTER TABLE `g5_write_menu_pdc` DISABLE KEYS */;
INSERT INTO `g5_write_menu_pdc` VALUES (936,'10','회사소개','/plugin/company_intro/?co_id=CEO&me_code=1010','',0,1,1,0,'','2026-03-17 15:00:22'),(937,'1010','CEO인사말','/plugin/company_intro/?co_id=CEO&me_code=1010','',0,1,1,0,'','2026-03-17 15:00:22'),(938,'1020','인증서 · 시험성적서','/plugin/company_intro/?co_id=certificate&me_code=1011','',0,1,1,0,'','2026-03-17 15:00:22'),(939,'1030','회사연혁','/plugin/company_intro/?co_id=history&me_code=1012','',0,1,1,0,'','2026-03-17 15:00:22'),(940,'1040','찾아오시는 길','/plugin/company_intro/?co_id=kukdong_panel_CEO&me_code=1013','',0,1,1,0,'','2026-03-17 15:00:22'),(941,'20','판넬제품소개','/plugin/company_intro/?co_id=CEO&me_code=2010','',0,1,1,0,'','2026-03-17 15:00:22'),(942,'2010','징크판넬','/plugin/company_intro/?co_id=CEO&me_code=2011','',0,1,1,0,'','2026-03-17 15:00:22'),(943,'2020','V75판넬','/plugin/company_intro/?co_id=CEO&me_code=2012','',0,1,1,0,'','2026-03-17 15:00:22'),(944,'2030','메탈판넬','','',0,1,1,0,'','2026-03-17 15:00:22'),(945,'2040','라인메탈 1000','','',0,1,1,0,'','2026-03-17 15:00:22'),(946,'2050','라인메탈 600','','',0,1,1,0,'','2026-03-17 15:00:22'),(947,'2060','모자이크 메탈','','',0,1,1,0,'','2026-03-17 15:00:22'),(948,'2070','500골','','',0,1,1,0,'','2026-03-17 15:00:22'),(949,'2080','1000골','','',0,1,1,0,'','2026-03-17 15:00:22'),(950,'2090','250골','','',0,1,1,0,'','2026-03-17 15:00:22'),(951,'2011','포켓형 준불연EPS','','',0,1,1,0,'','2026-03-17 15:00:22'),(952,'2012','잔골/평판','','',0,1,1,0,'','2026-03-17 15:00:22'),(953,'2013','지붕4골','','',0,1,1,0,'','2026-03-17 15:00:22'),(954,'21','부자재','','',0,1,1,0,'','2026-03-17 15:00:22'),(955,'22','고객지원','/bbs/board.php?bo_table=news&me_code=4010','',0,1,1,0,'','2026-03-17 15:00:22'),(956,'2210','공지사항','/bbs/board.php?bo_table=news&me_code=4010','',0,1,1,0,'','2026-03-17 15:00:22'),(957,'2211','자료실','/bbs/board.php?bo_table=news&me_code=5011','',0,1,1,0,'','2026-03-17 15:00:22'),(958,'23','온라인견적상담','','',0,1,1,0,'','2026-03-17 15:00:22');
/*!40000 ALTER TABLE `g5_write_menu_pdc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_menu_pdc_cn`
--

DROP TABLE IF EXISTS `g5_write_menu_pdc_cn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_menu_pdc_cn` (
  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_code` varchar(255) NOT NULL DEFAULT '',
  `ma_name` varchar(255) NOT NULL DEFAULT '',
  `ma_link` varchar(255) NOT NULL DEFAULT '',
  `ma_target` varchar(255) NOT NULL DEFAULT '',
  `ma_order` int(11) NOT NULL DEFAULT 0,
  `ma_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_mobile_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_menu_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_icon` varchar(255) NOT NULL DEFAULT '',
  `ma_regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`ma_id`),
  KEY `ma_code` (`ma_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_menu_pdc_cn`
--

LOCK TABLES `g5_write_menu_pdc_cn` WRITE;
/*!40000 ALTER TABLE `g5_write_menu_pdc_cn` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_menu_pdc_cn` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_menu_pdc_en`
--

DROP TABLE IF EXISTS `g5_write_menu_pdc_en`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_menu_pdc_en` (
  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_code` varchar(255) NOT NULL DEFAULT '',
  `ma_name` varchar(255) NOT NULL DEFAULT '',
  `ma_link` varchar(255) NOT NULL DEFAULT '',
  `ma_target` varchar(255) NOT NULL DEFAULT '',
  `ma_order` int(11) NOT NULL DEFAULT 0,
  `ma_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_mobile_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_menu_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_icon` varchar(255) NOT NULL DEFAULT '',
  `ma_regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`ma_id`),
  KEY `ma_code` (`ma_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_menu_pdc_en`
--

LOCK TABLES `g5_write_menu_pdc_en` WRITE;
/*!40000 ALTER TABLE `g5_write_menu_pdc_en` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_menu_pdc_en` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_menu_pdc_jp`
--

DROP TABLE IF EXISTS `g5_write_menu_pdc_jp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_menu_pdc_jp` (
  `ma_id` int(11) NOT NULL AUTO_INCREMENT,
  `ma_code` varchar(255) NOT NULL DEFAULT '',
  `ma_name` varchar(255) NOT NULL DEFAULT '',
  `ma_link` varchar(255) NOT NULL DEFAULT '',
  `ma_target` varchar(255) NOT NULL DEFAULT '',
  `ma_order` int(11) NOT NULL DEFAULT 0,
  `ma_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_mobile_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_menu_use` tinyint(4) NOT NULL DEFAULT 1,
  `ma_icon` varchar(255) NOT NULL DEFAULT '',
  `ma_regdt` datetime DEFAULT NULL,
  PRIMARY KEY (`ma_id`),
  KEY `ma_code` (`ma_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_menu_pdc_jp`
--

LOCK TABLES `g5_write_menu_pdc_jp` WRITE;
/*!40000 ALTER TABLE `g5_write_menu_pdc_jp` DISABLE KEYS */;
/*!40000 ALTER TABLE `g5_write_menu_pdc_jp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_news`
--

DROP TABLE IF EXISTS `g5_write_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_news` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT 0,
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT 0,
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `wr_comment` int(11) NOT NULL DEFAULT 0,
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT 0,
  `wr_link2_hit` int(11) NOT NULL DEFAULT 0,
  `wr_hit` int(11) NOT NULL DEFAULT 0,
  `wr_good` int(11) NOT NULL DEFAULT 0,
  `wr_nogood` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `wr_file` tinyint(4) NOT NULL DEFAULT 0,
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_news`
--

LOCK TABLES `g5_write_news` WRITE;
/*!40000 ALTER TABLE `g5_write_news` DISABLE KEYS */;
INSERT INTO `g5_write_news` VALUES (1,-1,'',1,0,0,'','','','dadada','dadadadad','dadada','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-18 12:48:31',0,'2025-12-18 12:48:31','::1','','','','','','','','','','','',''),(2,-2,'',2,0,3,'','','','홈페이지에 오신 것을 환영합니다.','(주)케임오토시스템 홈페이지에 오신 것을 환영합니다.\r\n \r\n항상 최선을 다하는 기업이 될 것을 약속드립니다.\r\n \r\n감사합니다.','홈페이지에-오신-것을-환영합니다','','',0,0,4,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-18 13:34:14',1,'2025-12-23 14:08:24','::1','','','','','','','','','','','',''),(3,-3,'',3,0,0,'','','','안녕하세요','안녕하세요\r\n안녕하세요\r\n안녕하세요','안녕하세요','','',0,0,3,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-18 13:40:22',0,'2025-12-18 13:40:22','::1','','','','','','','','','','','',''),(4,-4,'',4,0,0,'','','','ㅇㄹㄴㄹㄴ','ㄹㄴㄹㄴㄹ','ㅇㄹㄴㄹㄴ','','',0,0,4,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-18 13:43:29',0,'2025-12-18 13:43:29','::1','','','','','','','','','','','',''),(5,-2,'',2,1,1,'','','','','안녕하세요','','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-18 14:05:19',0,'','::1','','','','','','','','','','','',''),(6,-2,'',2,1,2,'','','','','fsfsfs','','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 14:08:19',0,'','::1','','','','','','','','','','','',''),(7,-2,'',2,1,3,'','','','','sgsgsfgs','','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-23 14:08:24',0,'','::1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_online7`
--

DROP TABLE IF EXISTS `g5_write_online7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_online7` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT 0,
  `wr_reply` varchar(10) NOT NULL DEFAULT '',
  `wr_parent` int(11) NOT NULL DEFAULT 0,
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `wr_comment` int(11) NOT NULL DEFAULT 0,
  `wr_comment_reply` varchar(5) NOT NULL DEFAULT '',
  `ca_name` varchar(255) NOT NULL DEFAULT '',
  `wr_option` set('html1','html2','secret','mail') NOT NULL DEFAULT 'html1',
  `wr_subject` varchar(255) NOT NULL DEFAULT '',
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT 0,
  `wr_link2_hit` int(11) NOT NULL DEFAULT 0,
  `wr_hit` int(11) NOT NULL DEFAULT 0,
  `wr_good` int(11) NOT NULL DEFAULT 0,
  `wr_nogood` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL DEFAULT '',
  `wr_password` varchar(255) NOT NULL DEFAULT '',
  `wr_name` varchar(255) NOT NULL DEFAULT '',
  `wr_email` varchar(255) NOT NULL DEFAULT '',
  `wr_homepage` varchar(255) NOT NULL DEFAULT '',
  `wr_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `wr_file` tinyint(4) NOT NULL DEFAULT 0,
  `wr_last` varchar(19) NOT NULL DEFAULT '',
  `wr_ip` varchar(255) NOT NULL DEFAULT '',
  `wr_facebook_user` varchar(255) NOT NULL DEFAULT '',
  `wr_twitter_user` varchar(255) NOT NULL DEFAULT '',
  `wr_1` varchar(255) NOT NULL DEFAULT '',
  `wr_2` varchar(255) NOT NULL DEFAULT '',
  `wr_3` varchar(255) NOT NULL DEFAULT '',
  `wr_4` varchar(255) NOT NULL DEFAULT '',
  `wr_5` varchar(255) NOT NULL DEFAULT '',
  `wr_6` varchar(255) NOT NULL DEFAULT '',
  `wr_7` varchar(255) NOT NULL DEFAULT '',
  `wr_8` varchar(255) NOT NULL DEFAULT '',
  `wr_9` varchar(255) NOT NULL DEFAULT '',
  `wr_10` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_online7`
--

LOCK TABLES `g5_write_online7` WRITE;
/*!40000 ALTER TABLE `g5_write_online7` DISABLE KEYS */;
INSERT INTO `g5_write_online7` VALUES (1,-1,'',1,0,0,'','','html1','이관형님의 온라인 문의입니다.','dsfsfds\n\n연락처: ㅇㅇㅇㅇ','이관형님의-온라인-문의입니다','','',0,0,1,0,0,'guest','*11B511F4C2F57852A994021646B461AB8FAF7B6C','이관형','','','2025-12-15 09:29:52',0,'2025-12-15 09:29:52','::1','','','ㅇㅇㅇㅇ','','','','','','','','',''),(2,-2,'',2,0,0,'','','html1','이관형님의 온라인 문의입니다.','testtesttesttesttesttest\n\n연락처: test','이관형님의-온라인-문의입니다-1','','',0,0,1,0,0,'guest','*F1E4976725795EEE027CBA1CD802F54C9BC34712','이관형','','','2025-12-15 09:33:08',0,'2025-12-15 09:33:08','::1','','','test','','','','','','','','',''),(3,-2,'',3,0,0,'','','html1','이관형님의 온라인 문의입니다.','ㄹㅈㄹㄷㅈㄱㅈㄷㄱ\n\n연락처: 01034006723','이관형님의-온라인-문의입니다-2','','',0,0,0,0,0,'admin','','이관형','','','2025-12-15 12:01:44',0,'2025-12-15 12:01:44','::1','','','01034006723','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_online7` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_portfolio`
--

DROP TABLE IF EXISTS `g5_write_portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_portfolio` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT 0,
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT 0,
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `wr_comment` int(11) NOT NULL DEFAULT 0,
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT 0,
  `wr_link2_hit` int(11) NOT NULL DEFAULT 0,
  `wr_hit` int(11) NOT NULL DEFAULT 0,
  `wr_good` int(11) NOT NULL DEFAULT 0,
  `wr_nogood` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `wr_file` tinyint(4) NOT NULL DEFAULT 0,
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_portfolio`
--

LOCK TABLES `g5_write_portfolio` WRITE;
/*!40000 ALTER TABLE `g5_write_portfolio` DISABLE KEYS */;
INSERT INTO `g5_write_portfolio` VALUES (1,-1,'',1,0,0,'','기업 > 여자','','dddddd','지난 1년간 은(Silver)의 성과는 그야말로 경이적이었습니다. 2025년 9월 초부터 11월 초 사이, 은 가격은 약 50%에 육박하는 랠리를 기록하며 사실상 거의 모든 자산의 수익률을 압도했습니다.\r\n\r\n​\r\n\r\n이러한 기록적인 급등은 단순히 우연이 아니라, 여러 시장 상황이 맞물려 발생한 결과입니다. 금과의 뿌리 깊은 상관관계부터 글로벌 전력화 추세, 인공지능(AI), 그리고 가상화폐 채굴 수요가 불러온 수급 불균형에 이르기까지 다양한 요인들이 동시에 작용했습니다. 이처럼 여러 힘이 하나로 모인 \'결정적 시점\'을 정확히 이해하기 위해서는 시장의 포지셔닝과 그 저변에 깔린 심리를 심층적으로 살펴볼 필요가 있습니다.','dddddd','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-14 14:14:37',3,'2026-01-14 14:14:37','::1','','','301010','','','','','','','','',''),(4,-4,'',4,0,0,'','개인','','dafafafd','fafdafa','dafafafd','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-14 15:57:17',2,'2026-01-14 15:57:17','::1','','','3020','','','','','','','','',''),(5,-5,'',5,0,0,'','기업 > 여자','','afafafd','afdfafafd','afafafd','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-14 15:58:30',2,'2026-01-14 15:58:30','::1','','','301010','','','','','','','','',''),(6,-6,'',6,0,0,'','기업 > 여자','','daffd','afafafad','daffd','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-14 15:59:06',2,'2026-01-14 15:59:06','::1','','','301010','','','','','','','','',''),(11,-7,'',11,0,0,'','기업 > 여자','','남성 베이직 패딩 빵빵한 보온 방풍 스탠드칼라 겨울 아우터','<p>패션디자인의 아이디어를 표현하기위한 그림으로 패션디자인의 표현에 중점을 두고 자신의 디자인을 표현하는 다양한 일러스트레이션을 위한 기초 드로잉 과정과 인체구조 이해와 다양한 포즈의 옷 실루엣, 소재의 질감, 디자인 도식화까지 표현할 수 있도록 하는 교육과정이다.<br>패션디자인의 아이디어를 표현하기위한 그림으로 패션디자인의 표현에 중점을 두고 자신의 디자인을 표현하는 다양한 일러스트레이션을 위한 기초 드로잉 과정과 인체구조 이해와 다양한 포즈의 옷 실루엣, 소재의 질감, 디자인 도식화까지 표현할 수 있도록 하는 교육과정이다.<br><br><img src=\"http://localhost/data/editor/2601/beautiful-2359121_1280.jpg\" title=\"beautiful-2359121_1280.jpg\"><br style=\"clear:both;\">&nbsp;</p>','남성-베이직-패딩-빵빵한-보온-방풍-스탠드칼라-겨울','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2026-01-15 11:24:33',1,'2026-01-15 11:24:33','::1','','','301010','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_product`
--

DROP TABLE IF EXISTS `g5_write_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_product` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT 0,
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT 0,
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `wr_comment` int(11) NOT NULL DEFAULT 0,
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT 0,
  `wr_link2_hit` int(11) NOT NULL DEFAULT 0,
  `wr_hit` int(11) NOT NULL DEFAULT 0,
  `wr_good` int(11) NOT NULL DEFAULT 0,
  `wr_nogood` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `wr_file` tinyint(4) NOT NULL DEFAULT 0,
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_product`
--

LOCK TABLES `g5_write_product` WRITE;
/*!40000 ALTER TABLE `g5_write_product` DISABLE KEYS */;
INSERT INTO `g5_write_product` VALUES (1,-1,'',1,0,0,'','슬라이딩게이트','html1','CS1001','<div style=\"text-align: center;\" align=\"center\"><img src=\"http://localhost/data/editor/2512/1303131140168_1.jpg\" title=\"1303131140168_1.jpg\"></div><div style=\"text-align: center;\" align=\"center\"><img src=\"http://localhost/data/editor/2512/1303270339072_1.jpg\" title=\"1303270339072_1.jpg\"></div><div style=\"text-align: center;\">&nbsp;</div>','cs1001','','',0,0,2,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-28 12:46:32',1,'2025-12-28 12:46:32','::1','','','- 재질/설치타입 협의\r\n- 디자인 협의 가능\r\n- 지정색 도장 가능\r\n- 주문 제작','','','','','','','','',''),(2,-2,'',2,0,0,'','','html1','sfsfs11133333','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%281%29.jpg\" title=\"1303131140168_1 (1).jpg\"><br style=\"clear:both;\"><img src=\"http://localhost/data/editor/2512/1303270339072_1%20%281%29.jpg\" title=\"1303270339072_1 (1).jpg\"><br style=\"clear:both;\">&nbsp;</p>','sfsfs11133333','','',0,0,3,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-28 14:39:44',1,'2025-12-28 14:39:44','::1','','','fsdfsfs11\r\nfadfaffad111333333','','','','','','','','',''),(3,-3,'',3,0,0,'','','html1','3333','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%282%29.jpg\" title=\"1303131140168_1 (2).jpg\"><br style=\"clear:both;\"><img src=\"http://localhost/data/editor/2512/1303270339072_1%20%282%29.jpg\" title=\"1303270339072_1 (2).jpg\"><br style=\"clear:both;\">&nbsp;</p>','3333','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-29 10:53:52',1,'2025-12-29 10:53:52','::1','','','333333','','','','','','','','',''),(4,-4,'',4,0,0,'','','html1','테스트3','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%284%29.jpg\" title=\"1303131140168_1 (4).jpg\"><br style=\"clear:both;\"><img src=\"http://localhost/data/editor/2512/1303270339072_1%20%284%29.jpg\" title=\"1303270339072_1 (4).jpg\"><br style=\"clear:both;\">&nbsp;</p>','테스트3','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-29 11:31:10',1,'2025-12-29 11:31:10','::1','','','101040','','','','','','','','','ㄴㅇㄴㅇㄴㅇ'),(5,-5,'',5,0,0,'','','html1','목재대문','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%285%29.jpg\" title=\"1303131140168_1 (5).jpg\"><br style=\"clear:both;\">&nbsp;</p>','목재대문','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-29 12:23:14',1,'2025-12-29 12:23:14','::1','','','101030','','','','','','','','','목재대문\r\n목재대문'),(6,-6,'',6,0,0,'','','html1','슬라이딩케이스2','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%286%29.jpg\" title=\"1303131140168_1 (6).jpg\"><br style=\"clear:both;\"><img src=\"http://localhost/data/editor/2512/1303270339072_1%20%285%29.jpg\" title=\"1303270339072_1 (5).jpg\"><br style=\"clear:both;\">&nbsp;</p>','슬라이딩케이스2','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-29 12:24:51',1,'2025-12-29 12:24:51','::1','','','101030','','','','','','','','','ㅇㄴㄹㄴㅇ\r\nㅇㄹㄴㄹ2\r\nㄻㄹ2222'),(7,-7,'',7,0,0,'','','html1','1111','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%287%29.jpg\" title=\"1303131140168_1 (7).jpg\"><br style=\"clear:both;\">&nbsp;</p>','1111','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-29 12:56:32',1,'2025-12-29 12:56:32','::1','','','102010','','','','','','','','','1111'),(8,-8,'',8,0,0,'','','html1','ㅇㅇㅇㅇㅇ','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%289%29.jpg\" title=\"1303131140168_1 (9).jpg\"><br style=\"clear:both;\"><img src=\"http://localhost/data/editor/2512/1303270339072_1%20%287%29.jpg\" title=\"1303270339072_1 (7).jpg\"><br style=\"clear:both;\">&nbsp;</p>','ㅇㅇㅇㅇㅇ','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-29 13:29:11',1,'2025-12-29 13:29:11','::1','','','101040','','','','','','','','','ㅇㅇㅇㅇㅇㅇ'),(9,-9,'',9,0,0,'','','html1','1111','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%2810%29.jpg\" title=\"1303131140168_1 (10).jpg\"><br style=\"clear:both;\">&nbsp;</p>','1111-1','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-29 13:34:59',1,'2025-12-29 13:34:59','::1','','','101010','','','','','','','','','3333'),(10,-10,'',10,0,0,'','','html1','단조11','<p><img src=\"http://localhost/data/editor/2512/1303131140168_1%20%2811%29.jpg\" title=\"1303131140168_1 (11).jpg\"><br style=\"clear:both;\"><img src=\"http://localhost/data/editor/2512/1303270339072_1%20%288%29.jpg\" title=\"1303270339072_1 (8).jpg\"><br style=\"clear:both;\">&nbsp;</p>','단조11','','',0,0,0,0,0,'admin','','관리자','sinem1@naver.com','','2025-12-29 13:47:33',1,'2025-12-29 13:47:33','::1','','','101010','','','','','','','','','ㄴㄹㄴㄹㄴㄹ11');
/*!40000 ALTER TABLE `g5_write_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `g5_write_qna`
--

DROP TABLE IF EXISTS `g5_write_qna`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `g5_write_qna` (
  `wr_id` int(11) NOT NULL AUTO_INCREMENT,
  `wr_num` int(11) NOT NULL DEFAULT 0,
  `wr_reply` varchar(10) NOT NULL,
  `wr_parent` int(11) NOT NULL DEFAULT 0,
  `wr_is_comment` tinyint(4) NOT NULL DEFAULT 0,
  `wr_comment` int(11) NOT NULL DEFAULT 0,
  `wr_comment_reply` varchar(5) NOT NULL,
  `ca_name` varchar(255) NOT NULL,
  `wr_option` set('html1','html2','secret','mail') NOT NULL,
  `wr_subject` varchar(255) NOT NULL,
  `wr_content` text NOT NULL,
  `wr_seo_title` varchar(255) NOT NULL DEFAULT '',
  `wr_link1` text NOT NULL,
  `wr_link2` text NOT NULL,
  `wr_link1_hit` int(11) NOT NULL DEFAULT 0,
  `wr_link2_hit` int(11) NOT NULL DEFAULT 0,
  `wr_hit` int(11) NOT NULL DEFAULT 0,
  `wr_good` int(11) NOT NULL DEFAULT 0,
  `wr_nogood` int(11) NOT NULL DEFAULT 0,
  `mb_id` varchar(20) NOT NULL,
  `wr_password` varchar(255) NOT NULL,
  `wr_name` varchar(255) NOT NULL,
  `wr_email` varchar(255) NOT NULL,
  `wr_homepage` varchar(255) NOT NULL,
  `wr_datetime` datetime NOT NULL DEFAULT current_timestamp(),
  `wr_file` tinyint(4) NOT NULL DEFAULT 0,
  `wr_last` varchar(19) NOT NULL,
  `wr_ip` varchar(255) NOT NULL,
  `wr_facebook_user` varchar(255) NOT NULL,
  `wr_twitter_user` varchar(255) NOT NULL,
  `wr_1` varchar(255) NOT NULL,
  `wr_2` varchar(255) NOT NULL,
  `wr_3` varchar(255) NOT NULL,
  `wr_4` varchar(255) NOT NULL,
  `wr_5` varchar(255) NOT NULL,
  `wr_6` varchar(255) NOT NULL,
  `wr_7` varchar(255) NOT NULL,
  `wr_8` varchar(255) NOT NULL,
  `wr_9` varchar(255) NOT NULL,
  `wr_10` varchar(255) NOT NULL,
  PRIMARY KEY (`wr_id`),
  KEY `wr_seo_title` (`wr_seo_title`),
  KEY `wr_num_reply_parent` (`wr_num`,`wr_reply`,`wr_parent`),
  KEY `wr_is_comment` (`wr_is_comment`,`wr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `g5_write_qna`
--

LOCK TABLES `g5_write_qna` WRITE;
/*!40000 ALTER TABLE `g5_write_qna` DISABLE KEYS */;
INSERT INTO `g5_write_qna` VALUES (1,-1,'',1,0,0,'','','html1','111111','<p><img src=\"http://localhost/data/editor/2603/20260310161359_eb661b29f77534eb15e8ee83a39972ad_jij4.jpg\" alt=\"KakaoTalk_20260306_090631239.jpg\" style=\"width: 800px; height: 1067px;\" /></p>','111111','','',0,0,2,0,0,'admin','','관리자','sinem1@naver.com','','2026-03-10 16:14:13',0,'2026-03-10 16:14:13','::1','','','','','','','','','','','',''),(2,-2,'',2,0,0,'','','html1','111111','<p><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/gCChzfU5lLc?si=qwoq3BDXxve2-rN0\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen=\"\"></iframe><br /></p>','111111-1','','',0,0,1,0,0,'admin','','관리자','sinem1@naver.com','','2026-03-11 10:07:19',0,'2026-03-11 10:07:19','::1','','','','','','','','','','','','');
/*!40000 ALTER TABLE `g5_write_qna` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-18 13:22:00
