-- MySQL dump 10.13  Distrib 5.1.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: php_twitter
-- ------------------------------------------------------
-- Server version	5.1.41-3ubuntu12.10

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
-- Table structure for table `follow_tables`
--

DROP TABLE IF EXISTS `follow_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `follow_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `follow_user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `new_fk_constraint_user_id` (`user_id`),
  KEY `new_fk_constraint_follow_uer_id` (`follow_user_id`),
  CONSTRAINT `new_fk_constraint_follow_uer_id` FOREIGN KEY (`follow_user_id`) REFERENCES `user_tables` (`id`),
  CONSTRAINT `new_fk_constraint_user_id` FOREIGN KEY (`user_id`) REFERENCES `user_tables` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `follow_tables`
--

LOCK TABLES `follow_tables` WRITE;
/*!40000 ALTER TABLE `follow_tables` DISABLE KEYS */;
INSERT INTO `follow_tables` VALUES (28,3,1),(40,2,1),(42,4,1),(44,1,3),(45,1,2),(46,1,4);
/*!40000 ALTER TABLE `follow_tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweet_fav`
--

DROP TABLE IF EXISTS `tweet_fav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweet_fav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `tweet_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `new_fk_constraint_FAV` (`user_id`),
  KEY `new_fk_constraint_tweets_fav` (`tweet_id`),
  CONSTRAINT `new_fk_constraint_FAV` FOREIGN KEY (`user_id`) REFERENCES `user_tables` (`id`),
  CONSTRAINT `new_fk_constraint_tweets_fav` FOREIGN KEY (`tweet_id`) REFERENCES `tweets` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweet_fav`
--

LOCK TABLES `tweet_fav` WRITE;
/*!40000 ALTER TABLE `tweet_fav` DISABLE KEYS */;
INSERT INTO `tweet_fav` VALUES (35,1,13),(49,1,17),(55,1,519),(57,1,523);
/*!40000 ALTER TABLE `tweet_fav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tweets`
--

DROP TABLE IF EXISTS `tweets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tweets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `twitte` varchar(150) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `new_fk_constraint` (`user_id`),
  CONSTRAINT `new_fk_constraint` FOREIGN KEY (`user_id`) REFERENCES `user_tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=592 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tweets`
--

LOCK TABLES `tweets` WRITE;
/*!40000 ALTER TABLE `tweets` DISABLE KEYS */;
INSERT INTO `tweets` VALUES (0,'i see a ufo! i am sure it\'s a real ufo',2,'2011-01-04 09:30:02'),(1,'todat i see a real ufo whick like a plan! hahaaaaaa',1,'2011-04-01 08:56:40'),(2,'be happy, be fun, be happiness',1,'2011-04-05 09:25:24'),(3,'i am looking up a girl?',2,'2011-12-04 01:04:22'),(4,'f*ck the  gov!',1,'2011-06-03 06:25:24'),(5,'今天没有找到好吃的，就找到几个鸟蛋',3,'2011-12-02 17:04:23'),(6,'妈妈会带回来好吃的吧!',3,'2011-12-03 21:04:22'),(7,'上帝也喜欢我的iphone',4,'2011-12-02 17:04:31'),(8,'手里拿着鸟蛋，觉得很扯淡',3,'2011-12-04 03:14:22'),(9,'卡扎菲在国内支持男女平等，很不错',3,'2011-12-04 03:00:22'),(10,'自己都没有信心，别人鼓励加油是没有用的！',2,'2011-12-03 23:04:22'),(11,'土耳其发生7.2级地震',2,'2011-12-04 03:10:22'),(12,'土耳其已经死伤300人+',2,'2011-12-03 20:04:22'),(13,'蹭网虽然有点那个，不过挺爽的，哈哈',3,'2011-12-04 01:04:22'),(14,'没有共产党，一样有新中国',3,'2011-12-04 15:00:22'),(17,'zheng 你在胡说把你和凤姐关一起',2,'2011-12-04 03:20:22'),(335,'xhd你敢把我和凤姐关一起，我就让凤姐爱上你',3,'2011-12-04 15:04:22'),(472,'on my cat',3,'2011-12-07 05:51:03'),(517,'i am on the ship',4,'2011-12-09 09:43:06'),(518,'do you like iphone? ',4,'2011-12-09 10:01:17'),(519,'you iphone are too expensive',3,'2011-12-09 10:04:54'),(520,'i agree with you  ',2,'2011-12-09 19:22:55'),(521,'http://baidu.com',1,'2011-12-09 13:07:31'),(522,'information test   http://twitter.com  http://www.google.com',1,'2011-12-10 04:54:31'),(523,'http://twitter.com  haha new   http://www.google.com',3,'2011-12-10 04:55:00'),(524,'http://ns.naturess.co.cc',1,'2011-12-10 05:00:41'),(525,'这个网站 太。。。。。 http://ns.naturesss.co.cc',1,'2011-12-10 05:03:20'),(526,'@dsfds',1,'2011-12-10 08:11:35'),(527,'@zheng @xhd 你们都是混蛋',1,'2011-12-10 08:12:19'),(528,'@第三方 @dsf FEFEF @wliment',1,'2011-12-10 08:12:46'),(529,'@',1,'2011-12-10 08:12:53'),(530,'@xhd @zheng haha',1,'2011-12-10 08:17:01'),(531,'@wliment @zheng @ xhd 哈哈',1,'2011-12-10 08:20:11'),(532,'@wliment @zheng @xdsdf 反对是否第三方',1,'2011-12-10 08:20:30'),(533,'@wliment 你是个hundan @xhr 你也是 哈哈哈哈哈哈哈',3,'2011-12-10 08:24:48'),(534,'@dfdf  http://awaker.net',1,'2011-12-10 08:27:21'),(535,'@god 你是谁？？？？',1,'2011-12-10 08:39:52'),(536,'@wliment god 你都不认识,out',3,'2011-12-10 08:46:17'),(537,'@wliment hahahahahaha',3,'2011-12-10 08:46:49'),(538,'dsf',1,'2011-12-10 08:48:34'),(539,'@sdfsdf',1,'2011-12-10 08:48:37'),(540,'@234234 是地方第三方',1,'2011-12-10 08:48:52'),(541,'@www dsfdsf',1,'2011-12-10 08:49:06'),(542,'@sdf 你没',1,'2011-12-10 08:49:28'),(543,'@wlimetnt 是地方',3,'2011-12-10 08:50:45'),(544,'dfsd',1,'2011-12-10 08:52:58'),(545,'@sdfdsfdsf',1,'2011-12-10 08:53:06'),(546,'@wliment you',3,'2011-12-10 08:53:35'),(547,'sdfsdf @sdfdsf',3,'2011-12-10 08:57:34'),(548,'@dsf',1,'2011-12-10 08:58:04'),(549,'@sdfdsf',3,'2011-12-10 09:00:47'),(550,'@wewr 是地方',3,'2011-12-10 09:02:21'),(551,'sdf',3,'2011-12-10 09:02:44'),(552,'是地方',3,'2011-12-10 09:02:50'),(553,'sdfsd',3,'2011-12-10 09:04:11'),(554,'sdfds',3,'2011-12-10 09:06:19'),(555,'@sdfsdf',3,'2011-12-10 09:10:57'),(556,'zxczxc',3,'2011-12-10 09:11:17'),(557,'sdfds',3,'2011-12-10 09:12:26'),(558,'@sdfdsf',3,'2011-12-10 09:14:49'),(559,'233223',3,'2011-12-10 09:15:02'),(560,'sdfsdf',3,'2011-12-10 09:15:30'),(561,'@sdfs',1,'2011-12-10 09:17:03'),(562,'@sdfdsf',1,'2011-12-10 09:17:11'),(563,'@dsfdsf',1,'2011-12-10 09:17:14'),(564,'33sdfsdfsdf @sdfdsf  @wliment http://ccav.com',3,'2011-12-10 09:20:09'),(565,'sdfsdfsdf @wliment http://awaker.net http://www.youtobe.com',3,'2011-12-10 09:32:25'),(566,'@xhr 月全食 http://163.com ',1,'2011-12-10 12:51:47'),(567,'@wliment  git 的你不知道的技巧',3,'2011-12-13 07:32:53'),(568,'@ffff fsdfsdfsdf @fsdf @fsdfsd dsfsdf @fsdfsdf @sss',1,'2011-12-18 14:24:56'),(569,'@sdfff   @wliment 嘎嘎 @xhd  玩玩',1,'2011-12-19 05:04:29'),(570,'@wliment gaga',1,'2011-12-19 05:11:06'),(571,'@xhd    tody',1,'2011-12-19 14:46:18'),(572,'@xhd',1,'2011-12-19 17:38:38'),(573,'@xhd',1,'2011-12-19 17:39:49'),(574,'@xhd',1,'2011-12-19 17:40:13'),(575,'@xhd',1,'2011-12-19 17:41:38'),(576,'@xhd',1,'2011-12-19 17:45:01'),(577,'@xhd',1,'2011-12-19 17:45:12'),(578,'@xhd',1,'2011-12-19 17:50:39'),(579,'@xhd',1,'2011-12-19 17:52:40'),(580,'@xhd',1,'2011-12-19 17:55:19'),(581,'@xhd',1,'2011-12-19 18:00:04'),(582,'@xhd',1,'2011-12-19 18:01:09'),(583,'@xhd',1,'2011-12-19 18:04:08'),(584,'@xhd',1,'2011-12-19 18:08:50'),(585,'@xhd',1,'2011-12-19 18:12:41'),(586,'@zheng',1,'2011-12-25 12:05:25'),(587,'@god',1,'2011-12-25 12:06:47'),(588,'@xhd  你下死我了',1,'2011-12-25 12:13:21'),(589,'额外认为而',1,'2011-12-25 12:14:19'),(590,'我要登船了',4,'2011-12-25 12:15:52'),(591,'我登的船叫小鸡一号',4,'2011-12-25 12:17:47');
/*!40000 ALTER TABLE `tweets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_tables`
--

DROP TABLE IF EXISTS `user_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_tables` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `passwd` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tweets_num` int(10) unsigned NOT NULL,
  `follow_num` int(10) unsigned NOT NULL,
  `icon` varchar(150) NOT NULL,
  `fullname` varchar(150) NOT NULL,
  `user_desc` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_tables`
--

LOCK TABLES `user_tables` WRITE;
/*!40000 ALTER TABLE `user_tables` DISABLE KEYS */;
INSERT INTO `user_tables` VALUES (1,'wliment','123456','wliment@gmail.com',0,0,'php_twitter_photo/icon/1.jpg','郑涛','想干啥就干啥，想吃啥就吃啥，想玩啥就玩啥'),(2,'xhd','123456','xhd@qq.com',0,0,'php_twitter_photo/icon/2.jpeg','无名氏','我是无名士'),(3,'zheng','123456','zheng@163.com',0,0,'php_twitter_photo/icon/3.jpeg','小狐狸','我最喜欢的事情就是吃，最不喜欢的事是没的吃'),(4,'god','123456','god@gmail.com',0,0,'php_twitter_photo/icon/4.jpeg','布斯','my life purpose is to change the world!'),(5,'jams','123456','jams@gmail.com',0,0,'php_twitter_photo/icon/1.jpg','miller jams','i like movie,book.sleep');
/*!40000 ALTER TABLE `user_tables` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-12-25 20:55:34
