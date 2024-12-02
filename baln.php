CREATE TABLE `cart_checkout`.`products` (`id` INT(50) NOT NULL AUTO_INCREMENT , `product_name` VARCHAR(255) NOT NULL , `description` TEXT NOT NULL , `price` DECIMAL NOT NULL , `category` VARCHAR(250) NOT NULL , `qty` INT(50) NOT NULL , `image` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


CREATE TABLE `cart_checkout`.`cart` (`id` INT NOT NULL AUTO_INCREMENT , `product_name` VARCHAR(255) NOT NULL , `price` DECIMAL NOT NULL , `image` VARCHAR(255) NOT NULL , `qty` INT(50) NOT NULL , `total_price` DECIMAL NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;


CREATE TABLE `cart_checkout`.`orders` (`id` INT NOT NULL AUTO_INCREMENT , `fname` VARCHAR(255) NOT NULL , `lname` VARCHAR(255) NOT NULL , `address` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `phone` INT(10) NOT NULL , `notes` TEXT NOT NULL , `city` VARCHAR(255) NOT NULL , `total_amt` DECIMAL NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
