CREATE TABLE
    user (
        id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
        pseudo VARCHAR(20) NOT NULL,
        adress VARCHAR(80) NOT NULL,
        email VARCHAR(50) NOT NULL,
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