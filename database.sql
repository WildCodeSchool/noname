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
        rating INT DEFAULT 5
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
    product (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        title VARCHAR(20) NOT NULL,
        price INT NOT NULL,
        description TEXT NOT NULL,
        photo VARCHAR(255) NOT NULL,
        status VARCHAR(50) DEFAULT 'en vente',
        material VARCHAR(50),
        category_item VARCHAR(50),
        category_room VARCHAR(50),
        color VARCHAR(50),
        `date` DATETIME DEFAULT NOW(),
        `condition` VARCHAR(20),
        user_id INT NOT NULL,
        CONSTRAINT fk_product_user FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE ON UPDATE NO ACTION,
        cart_id int DEFAULT NULL,
        CONSTRAINT fk_product_cart FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE NO ACTION ON UPDATE NO ACTION
    );

INSERT INTO
    `product` (
        `title`,
        `price`,
        `photo`,
        `material`,
        `category_item`,
        `category_room`,
        `color`,
        `condition`,
        `user_id`,
        `description`
    )
VALUES (
        'chaise en bois',
        50,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        1,
        "super objet qui a gardé tout son charme"
    ), (
        'lustre cristal',
        200,
        'https://cdn.pixabay.com/photo/2015/11/20/15/20/crystal-chandelier-from-the-czech-republic-1053325_960_720.jpg',
        'verre',
        'luminaire',
        '["salon","salle à manger"]',
        '["#B09676","#FFFFFF"]',
        'neuf',
        1,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        100,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        2,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        100,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        3,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        100,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        4,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        100,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        1,
        "super objet qui a gardé tout son charme"
    ), (
        'lustre cristal',
        110,
        'https://cdn.pixabay.com/photo/2015/11/20/15/20/crystal-chandelier-from-the-czech-republic-1053325_960_720.jpg',
        '["verre","métal"]',
        'luminaire',
        '["salon","salle à manger"]',
        '["#B09676","#FFFFFF"]',
        'neuf',
        2,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en tissus',
        60,
        'https://cdn.pixabay.com/photo/2017/09/27/02/47/throne-2790789_960_720.png',
        'tissus',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        3,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        2,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        1,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        4,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        2,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        4,
        "super objet qui a gardé tout son charme"
    ), (
        'lustre cristal',
        180,
        'https://cdn.pixabay.com/photo/2015/11/20/15/20/crystal-chandelier-from-the-czech-republic-1053325_960_720.jpg',
        '["verre","métal"]',
        'luminaire',
        '["salon","salle à manger"]',
        '["#B09676","#FFFFFF"]',
        'neuf',
        2,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        4,
        "super objet qui a gardé tout son charme"
    ), (
        'chaise en bois',
        50,
        'https://images.pexels.com/photos/116910/pexels-photo-116910.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        'bois',
        'ameublement',
        '["bureau","salle à manger"]',
        '#5E370B',
        'correct',
        2,
        "super objet qui a gardé tout son charme"
    );

INSERT INTO
    `user`(
        `adress`,
        `email`,
        `pseudo`,
        `photo`,
        `lastname`,
        `firstname`,
        `phone_number`
    )
VALUES (
        '10 rue nationale 59000 lille',
        'steeve@gmail.com',
        'steeve',
        'https://cdn.pixabay.com/photo/2022/10/15/21/23/cat-7523894_960_720.jpg',
        'Gorgio',
        'Steeve',
        '0608070908'
    ), (
        '21 rue faidherbe 59120 loos',
        'pierre@gmail.com',
        'pierre',
        'https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2960&q=80',
        'Pif',
        'Pierre',
        '0608070909'
    ), (
        '10 avenue de dunkerque 59160 lomme',
        'jean@gmail.com',
        'jean',
        'https://images.unsplash.com/photo-1552374196-c4e7ffc6e126?crop=entropy&cs=tinysrgb&fm=jpg&ixlib=rb-1.2.1&q=60&raw_url=true&ixid=MnwxMjA3fDB8MHxzZWFyY2h8OHx8cG9ydHJhaXR8ZW58MHx8MHx8&auto=format&fit=crop&w=800',
        'touf',
        'Jean',
        '0608070909'
    ), (
        '10 rue de la clé 59000 lille',
        'marie@gmail.com',
        'marie',
        'https://images.unsplash.com/photo-1563132337-f159f484226c?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80',
        'good',
        'Marie',
        '0608070910'
    );
