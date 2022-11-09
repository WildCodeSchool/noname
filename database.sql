-- Active: 1665583164957@@127.0.0.1@3306@wildsupply
/*
CREATE TABLE
    user (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        pseudo VARCHAR(20) NOT NULL,
        lastname VARCHAR(20) NOT NULL,
        firstname VARCHAR(20) NOT NULL,
        adress VARCHAR(80) NOT NULL,
        email VARCHAR(50) NOT NULL,
        phone_number VARCHAR(20) NOT NULL,
        photo VARCHAR(255) NOT NULL,
        rating INT DEFAULT 5,
        is_admin BOOL DEFAULT FALSE
    );

CREATE TABLE
    cart (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        status_validation BOOL DEFAULT false,
        `date` DATETIME DEFAULT NOW(),
        user_id INT NOT NULL,
        CONSTRAINT fk_cart_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE NO ACTION
    );

CREATE TABLE
    category_item (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        title VARCHAR(20) NOT NULL,
        description VARCHAR(100) NOT NULL,
        photo VARCHAR(255),
        logo VARCHAR(255)
    );

CREATE TABLE
    product (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        title VARCHAR(20) NOT NULL,
        price INT NOT NULL,
        description TEXT NOT NULL,
        photo JSON NOT NULL,
        status VARCHAR(50) DEFAULT 'en vente',
        material JSON NOT NULL,
        category_item_id INT NOT NULL,
        CONSTRAINT fk_product_category_item FOREIGN KEY (category_item_id) REFERENCES category_item(id),
        category_room JSON NOT NULL,
        color JSON NOT NULL,
        `date` DATETIME DEFAULT NOW(),
        `condition` VARCHAR(20),
        user_id INT NOT NULL,
        CONSTRAINT fk_product_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE NO ACTION,
        cart_id int DEFAULT NULL,
        CONSTRAINT fk_product_cart FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE NO ACTION ON UPDATE NO ACTION
    );

INSERT INTO
    `user`(
        `adress`,
        `email`,
        `pseudo`,
        `photo`,
        `lastname`,
        `firstname`,
        `phone_number`,
        `is_admin`
    )
VALUES (
        '10 rue nationale 59000 lille',
        'steeve@gmail.com',
        'steeve',
        'https://cdn.pixabay.com/photo/2022/10/15/21/23/cat-7523894_960_720.jpg',
        'Gorgio',
        'Steeve',
        '0608070908',
        true
    ), (
        '21 rue faidherbe 59120 loos',
        'pierre@gmail.com',
        'pierre',
        'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2960&q=80',
        'Pif',
        'Pierre',
        '0608070909',
        false
    ), (
        '10 avenue de dunkerque 59160 lomme',
        'jean@gmail.com',
        'jean',
        'https://images.unsplash.com/photo-1552374196-c4e7ffc6e126?crop=entropy&cs=tinysrgb&fm=jpg&ixlib=rb-1.2.1&q=60&raw_url=true&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OHx8cG9ydHJhaXR8ZW58MHx8MHx8&auto=format&fit=crop&w=800',
        'touf',
        'Jean',
        '0608070909',
        false
    ), (
        '10 rue de la clé 59000 lille',
        'marie@gmail.com',
        'marie',
        'https://images.unsplash.com/photo-1563132337-f159f484226c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'good',
        'Marie',
        '0608070910',
        false
    );

INSERT INTO
    `category_item` (
        `title`,
        `description`,
        `photo`,
        `logo`
    )
VALUES (
        "Ameublement",
        "Votre meuble n'a plus son utilité , Vendez le",
        "https://cdn.pixabay.com/photo/2014/08/11/21/39/wall-416060_960_720.jpg",
        "/assets/images/ameublement2.png"
    ), (
        "Décoration",
        "Vous recherchez une décoration unique .",
        "https://cdn.pixabay.com/photo/2017/09/09/18/25/living-room-2732939_960_720.jpg",
        "/assets/images/deco2.png"
    ), (
        "Luminaires",
        "Eclairez votre habitation pour mettre en valeur votre décoration.",
        "https://cdn.pixabay.com/photo/2017/08/10/01/45/lights-2616955_960_720.jpg",
        "/assets/images/luminaire2.png"
    ), (
        "Electromenager",
        "Un soucis de four. Changez le !",
        "https://cdn.pixabay.com/photo/2022/01/04/05/29/kitchen-6914223_960_720.jpg",
        "/assets/images/electromenager2.png"
    );

INSERT INTO
    `product` (
        `title`,
        `price`,
        `photo`,
        `material`,
        `category_item_id`,
        `category_room`,
        `color`,
        `condition`,
        `user_id`,
        `description`
    )
VALUES (
        'chaise en bois',
        50,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        1,
        "Super objet qui a gardé tout son charme"
    ), (
        'lustre cristal',
        200,
        '["https://cdn.pixabay.com/photo/2015/11/20/15/20/crystal-chandelier-from-the-czech-republic-1053325_960_720.jpg"]',
        '["verre"]',
        3,
        '["Salon","Salle à manger"]',
        '["#B09676","#FFFFFF"]',
        'neuf',
        1,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        100,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        2,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        100,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        3,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        100,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        4,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        100,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        1,
        "Super objet qui a gardé tout son charme"
    ), (
        'lustre cristal',
        110,
        '["https://cdn.pixabay.com/photo/2015/11/20/15/20/crystal-chandelier-from-the-czech-republic-1053325_960_720.jpg"]',
        '["verre","métal"]',
        3,
        '["Salon","Salle à manger"]',
        '["#B09676","#FFFFFF"]',
        'neuf',
        2,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en tissus',
        60,
        '["https://cdn.pixabay.com/photo/2017/09/27/02/47/throne-2790789_960_720.png"]',
        '["tissu"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        3,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        2,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        1,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        4,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        2,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        4,
        "Super objet qui a gardé tout son charme"
    ), (
        'lustre cristal',
        180,
        '["https://cdn.pixabay.com/photo/2015/11/20/15/20/crystal-chandelier-from-the-czech-republic-1053325_960_720.jpg"]',
        '["verre","métal"]',
        3,
        '["Salon","Salle à manger"]',
        '["#B09676","#FFFFFF"]',
        'neuf',
        2,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        4,
        "Super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        '["https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"]',
        '["Bois"]',
        1,
        '["Bureau","Salle à manger"]',
        '["#5E370B"]',
        'correct',
        2,
        "Super objet qui a gardé tout son charme"
    );

ALTER TABLE `category_item` ADD in_carousel BOOL DEFAULT FALSE;

UPDATE `category_item` SET in_carousel = TRUE WHERE id = 1;

UPDATE `category_item` SET in_carousel = TRUE WHERE id = 2;

UPDATE `category_item` SET in_carousel = TRUE WHERE id = 3;

UPDATE `category_item` SET in_carousel = TRUE WHERE id = 4;

INSERT INTO
    `category_item` (
        `title`,
        `description`,
        `photo`,
        `logo`
    )
VALUES (
        "New Catégorie",
        "Votre meuble n'a plus son utilité , Vendez le",
        "https://cdn.pixabay.com/photo/2015/04/10/17/03/pots-716579_960_720.jpg",
        "/assets/images/ameublement2.png"
    );

INSERT INTO `cart` ( `user_id` ) VALUES ( 4 );

UPDATE `product` SET cart_id = 1 WHERE id = 1;

UPDATE `product` SET cart_id = 1 WHERE id = 2;

UPDATE `product` SET cart_id = 1 WHERE id = 3;

UPDATE `product` SET status = "en panier" WHERE id = 1;

UPDATE `product` SET status = "en panier" WHERE id = 2;

UPDATE `product` SET status = "en panier" WHERE id = 3;

ALTER TABLE `product` ADD show_phone_user BOOL DEFAULT FALSE;

ALTER TABLE `product` ADD show_email_user BOOL DEFAULT FALSE;

UPDATE `product` SET cart_id = 2 WHERE id = 4;

UPDATE `product` SET status = "en panier" WHERE id = 4;*/

-- MariaDB dump 10.19  Distrib 10.9.3-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: wild_supply
-- ------------------------------------------------------
-- Server version	8.0.31

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
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `status_validation` tinyint(1) DEFAULT '0',
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cart_user` (`user_id`),
  CONSTRAINT `fk_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_item`
--

DROP TABLE IF EXISTS `category_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category_item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `in_carousel` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_item`
--

LOCK TABLES `category_item` WRITE;
/*!40000 ALTER TABLE `category_item` DISABLE KEYS */;
INSERT INTO `category_item` VALUES
(1,'Ameublement','Votre meuble n\'a plus son utilité , Vendez le','https://cdn.pixabay.com/photo/2014/08/11/21/39/wall-416060_960_720.jpg','/assets/images/ameublement2.png',1),
(2,'Décoration','Vous recherchez une décoration unique .','https://cdn.pixabay.com/photo/2017/09/09/18/25/living-room-2732939_960_720.jpg','/assets/images/deco2.png',1),
(3,'Luminaires','Eclairez votre habitation pour mettre en valeur votre décoration.','https://cdn.pixabay.com/photo/2017/08/10/01/45/lights-2616955_960_720.jpg','/assets/images/luminaire2.png',1),
(4,'Electromenager','Un soucis de four. Changez le !','https://cdn.pixabay.com/photo/2022/01/04/05/29/kitchen-6914223_960_720.jpg','/assets/images/electromenager2.png',1);
/*!40000 ALTER TABLE `category_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `price` int NOT NULL,
  `description` text NOT NULL,
  `photo` json NOT NULL,
  `status` varchar(50) DEFAULT 'en vente',
  `material` json NOT NULL,
  `category_item_id` int NOT NULL,
  `category_room` json NOT NULL,
  `color` json NOT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `condition` varchar(20) DEFAULT NULL,
  `user_id` int NOT NULL,
  `cart_id` int DEFAULT NULL,
  `show_phone_user` tinyint(1) DEFAULT '0',
  `show_email_user` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_product_category_item` (`category_item_id`),
  KEY `fk_product_user` (`user_id`),
  KEY `fk_product_cart` (`cart_id`),
  CONSTRAINT `fk_product_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  CONSTRAINT `fk_product_category_item` FOREIGN KEY (`category_item_id`) REFERENCES `category_item` (`id`),
  CONSTRAINT `fk_product_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES
(17,'Rétroprojecteur',100,'Mon vieux rétro de marque acer.','[\"uploads/20221109_151527.jpg\", \"uploads/20221109_151533.jpg\", \"uploads/20221109_151549.jpg\"]','en vente','[\"PVC\", \"Verre\"]',4,'[\"Bureau\", \"Chambre\", \"Salon\"]','[\"#000000\", \"#3d3846\"]','2022-11-09 14:47:01','Correct',3,NULL,0,0),
(18,'Frigo',499,'Juste un simple frigo','[\"uploads/20221109_151650.jpg\", \"uploads/20221109_151658.jpg\", \"uploads/20221109_151713.jpg\"]','en vente','[\"Métal\", \"PVC\"]',4,'[\"Cuisine\"]','[\"#ffffff\", \"#3d3846\"]','2022-11-09 14:49:07','Correct',3,NULL,0,0),
(19,'Cafetiére',78,'+ café offers.\r\nFais le café, type senseo.','[\"uploads/20221109_151731.jpg\", \"uploads/20221109_151738.jpg\", \"uploads/20221109_151745.jpg\"]','en vente','[\"PVC\"]',4,'[\"Cuisine\"]','[\"#000000\"]','2022-11-09 14:51:10','Nouveau',3,NULL,0,0),
(20,'Micro onde',35,'Un micro onde de marque Listo.','[\"uploads/20221109_151804.jpg\", \"uploads/20221109_151808.jpg\", \"uploads/20221109_151814.jpg\"]','en vente','[\"PVC\"]',4,'[\"Cuisine\"]','[\"#ffffff\", \"#000000\"]','2022-11-09 14:53:16','Correct',4,NULL,0,0),
(21,'Ecran 4:3',45,'Un ecran de PC bof','[\"uploads/20221109_151832.jpg\", \"uploads/20221109_151838.jpg\", \"uploads/20221109_151844.jpg\"]','en vente','[\"PVC\", \"Verre\"]',4,'[\"Bureau\", \"Salon\"]','[\"#000000\", \"#5e5c64\"]','2022-11-09 14:54:50','Nouveau',4,NULL,0,0),
(22,'Une chaise noir',12,'Une chaise noir en bonne etat','[\"uploads/20221109_151907.jpg\", \"uploads/20221109_151913.jpg\"]','en vente','[\"Bois\", \"Tissu\"]',1,'[\"Bureau\", \"Cuisine\", \"Salle à manger\", \"Salon\"]','[\"#000000\"]','2022-11-09 14:56:47','Correct',4,NULL,0,0),
(23,'Bureau',299,'Un bureau haut de gamme','[\"uploads/20221109_151936.jpg\", \"uploads/20221109_151942.jpg\"]','en vente','[\"Bois\"]',1,'[\"Bureau\"]','[\"#3d3846\", \"#986a44\"]','2022-11-09 14:58:46','Nouveau',2,NULL,0,0),
(24,'Chaise bureau',30,'Chaise de bureau sur roulettes, réglable en hauteur, très confortable.','[\"uploads/20221109_152023.jpg\", \"uploads/20221109_152032.jpg\"]','en vente','[\"PVC\", \"Tissu\"]',1,'[\"Bureau\"]','[\"#000000\", \"#241f31\"]','2022-11-09 15:00:37','Correct',2,NULL,0,0),
(25,'Chaise pliante',11,'Chaise pliante orange, idéale pour la pêche.','[\"uploads/20221109_152050.jpg\"]','en vente','[\"PVC\"]',1,'[\"Salle à manger\"]','[\"#ff7800\"]','2022-11-09 15:01:57','Correct',2,NULL,0,0),
(26,'Un néon',85,'Un néon qui fait de la lumière.','[\"uploads/20221109_152107.jpg\"]','en vente','[\"Métal\", \"Verre\"]',3,'[\"Bureau\", \"Cuisine\", \"Salle à manger\"]','[\"#ffffff\"]','2022-11-09 15:03:37','Correct',1,NULL,0,0),
(27,'Table blanche',123,'Une table fragile, et fragilisé.','[\"uploads/20221109_152142.jpg\", \"uploads/20221109_152148.jpg\"]','en vente','[\"Bois\", \"Métal\"]',1,'[\"Bureau\", \"Salle à manger\"]','[\"#deddda\", \"#ffbe6f\"]','2022-11-09 15:05:15','Usagé',1,NULL,0,0),
(28,'Tabouret qui tourne',40,'Un tabouret de bar pour se croire dans un manège.','[\"uploads/20221109_152234.jpg\"]','en vente','[\"Métal\", \"Tissu\"]',1,'[\"Bureau\", \"Cuisine\", \"Salle à manger\"]','[\"#62a0ea\", \"#ffffff\"]','2022-11-09 15:08:30','Correct',1,NULL,0,0),
(29,'Spot',5,'Un spot de lumière blanche','[\"uploads/20221109_152353.jpg\"]','en vente','[\"Verre\"]',3,'[\"Bureau\", \"Cuisine\", \"Salle à manger\", \"Salon\"]','[\"#ffffff\"]','2022-11-09 15:12:05','Correct',1,NULL,0,0),
(30,'Tasse',4,'Un peu sale mais joli.','[\"uploads/20221109_152553.jpg\"]','en vente','[\"Verre\"]',2,'[\"Bureau\", \"Cuisine\", \"Salle à manger\"]','[\"#ffffff\", \"#ff7800\"]','2022-11-09 15:14:17','Correct',4,NULL,0,0);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `adress` varchar(80) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `rating` int DEFAULT '5',
  `is_admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES
(1,'steeve','Gorgio','Steeve','10 rue nationale 59000 lille','steeve@gmail.com','0608070908','https://cdn.pixabay.com/photo/2022/10/15/21/23/cat-7523894_960_720.jpg',5,1),
(2,'pierre','Pif','Pierre','21 rue faidherbe 59120 loos','pierre@gmail.com','0608070909','https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2960&q=80',5,0),
(3,'jean','touf','Jean','10 avenue de dunkerque 59160 lomme','jean@gmail.com','0608070909','https://images.unsplash.com/photo-1552374196-c4e7ffc6e126?crop=entropy&cs=tinysrgb&fm=jpg&ixlib=rb-1.2.1&q=60&raw_url=true&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OHx8cG9ydHJhaXR8ZW58MHx8MHx8&auto=format&fit=crop&w=800',5,0),
(4,'marie','good','Marie','10 rue de la clé 59000 lille','marie@gmail.com','0608070910','https://images.unsplash.com/photo-1563132337-f159f484226c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',5,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'wild_supply'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-11-09 16:22:03
