-- Active: 1665583164957@@127.0.0.1@3306@wildsupply

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

INSERT INTO
     `cart` (
       `user_id`
     )
VALUES (
      4
);

UPDATE `product` SET cart_id = 1 WHERE id = 1;
UPDATE `product` SET cart_id = 1 WHERE id = 2;
UPDATE `product` SET cart_id = 1 WHERE id = 3;
UPDATE `product` SET status = "en panier" WHERE id = 1;
UPDATE `product` SET status = "en panier" WHERE id = 2;
UPDATE `product` SET status = "en panier" WHERE id = 3;

ALTER TABLE `product` ADD show_phone_user BOOL DEFAULT FALSE;
ALTER TABLE `product` ADD show_email_user BOOL DEFAULT FALSE;

UPDATE `product` SET cart_id = 2 WHERE id = 4;
UPDATE `product` SET status = "en panier" WHERE id = 4;
