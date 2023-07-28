-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema lights_out
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema lights_out
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `lights_out` DEFAULT CHARACTER SET utf8 ;
USE `lights_out` ;

-- -----------------------------------------------------
-- Table `lights_out`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(250) NULL,
  `last_name` VARCHAR(250) NULL,
  `email` VARCHAR(250) NULL,
  `password` VARCHAR(250) NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`cart`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`cart` (
  `cart_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `created_date` DATE NULL,
  PRIMARY KEY (`cart_id`),
  INDEX `fk_cart_users_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_cart_users`
    FOREIGN KEY (`user_id`)
    REFERENCES `lights_out`.`users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`vendor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`vendor` (
  `vendor_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(250) NULL,
  `last_name` VARCHAR(250) NULL,
  `phone_number` VARCHAR(250) NULL,
  `email` VARCHAR(250) NULL,
  `password` VARCHAR(250) NULL,
  PRIMARY KEY (`vendor_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`products` (
  `product_id` INT NOT NULL AUTO_INCREMENT,
  `vendor_id` INT NOT NULL,
  `name` VARCHAR(250) NULL,
  `long_description` VARCHAR(1000) NULL,
  `price` DECIMAL(10,2) NULL,
  `image_link` VARCHAR(250) NULL,
  PRIMARY KEY (`product_id`),
  INDEX `fk_products_vendor1_idx` (`vendor_id` ASC) VISIBLE,
  CONSTRAINT `fk_products_vendor1`
    FOREIGN KEY (`vendor_id`)
    REFERENCES `lights_out`.`vendor` (`vendor_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`cart_products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`cart_products` (
  `cart_product_id` INT NOT NULL AUTO_INCREMENT,
  `cart_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NULL,
  PRIMARY KEY (`cart_product_id`),
  INDEX `fk_cart_products_cart1_idx` (`cart_id` ASC) VISIBLE,
  INDEX `fk_cart_products_products1_idx` (`product_id` ASC) VISIBLE,
  CONSTRAINT `fk_cart_products_cart1`
    FOREIGN KEY (`cart_id`)
    REFERENCES `lights_out`.`cart` (`cart_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cart_products_products1`
    FOREIGN KEY (`product_id`)
    REFERENCES `lights_out`.`products` (`product_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`blog_post`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`blog_post` (
  `blog_id` INT NOT NULL AUTO_INCREMENT,
  `vendor_id` INT NOT NULL,
  `title` VARCHAR(250) NULL,
  `blog_url` VARCHAR(500) NULL,
  `image_link` VARCHAR(250) NULL,
  PRIMARY KEY (`blog_id`),
  INDEX `fk_blog_post_vendor1_idx` (`vendor_id` ASC) VISIBLE,
  CONSTRAINT `fk_blog_post_vendor1`
    FOREIGN KEY (`vendor_id`)
    REFERENCES `lights_out`.`vendor` (`vendor_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`feedback`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`feedback` (
  `feedback_id` INT NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(250) NULL,
  `last_name` VARCHAR(250) NULL,
  `email` VARCHAR(250) NULL,
  `comment` VARCHAR(250) NULL,
  PRIMARY KEY (`feedback_id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `reference_number` VARCHAR(100) NULL,
  `total` DECIMAL(10,2) NULL,
  `shipping` DECIMAL(10,2) NULL,
  `order_date` DATE NULL,
  `user_id` INT NOT NULL,
  PRIMARY KEY (`order_id`),
  INDEX `fk_orders_users1_idx` (`user_id` ASC) VISIBLE,
  UNIQUE INDEX `reference_number_UNIQUE` (`reference_number` ASC) VISIBLE,
  CONSTRAINT `fk_orders_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `lights_out`.`users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`order_details`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`order_details` (
  `order_details_id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `product_name` VARCHAR(250) NULL,
  `quantity` INT NULL,
  `price` DECIMAL(10,2) NULL,
  PRIMARY KEY (`order_details_id`),
  INDEX `fk_order_details_orders1_idx` (`order_id` ASC) VISIBLE,
  CONSTRAINT `fk_order_details_orders1`
    FOREIGN KEY (`order_id`)
    REFERENCES `lights_out`.`orders` (`order_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `lights_out`.`reference_numbers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `lights_out`.`reference_numbers` (
  `reference_number` VARCHAR(100) NOT NULL,
  `user_id` INT NOT NULL,
  UNIQUE INDEX `reference_number_UNIQUE` (`reference_number` ASC) VISIBLE,
  INDEX `fk_reference_numbers_users1_idx` (`user_id` ASC) VISIBLE,
  CONSTRAINT `fk_reference_numbers_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `lights_out`.`users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
