<?php


class DrexCartInstaller {
	
	public function isInstalled() {
		try {
			$this->DrexCartConfig = ClassRegistry::init('DrexCart.DrexCartConfig');
			$this->DrexCartConfig->create();
			return true;
		} catch (Exception $e) {
			//echo $e->getMessage();
			return false;
		}
	}
	
	public function runStep1() {
		$this->DrexCartConfig = ClassRegistry::init('DrexCart.DrexCartConfig');
		//$this->DrexCartConfig->create();
		try {
			$this->DrexCartConfig->query("SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema findy2_drexcart
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `findy2_drexcart` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `findy2_drexcart` ;

-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_config`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_config` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `config_code` VARCHAR(45) NOT NULL,
  `config_value` VARCHAR(45) NOT NULL,
  `config_value_type` ENUM('string', 'int', 'boolean') NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `created_date` DATETIME NOT NULL,
  `last_login` DATETIME NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_product_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_product_types` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `product_type` VARCHAR(45) NOT NULL,
  `product_type_name` VARCHAR(45) NOT NULL,
  `shippable` INT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `rate` DECIMAL(10,5) NOT NULL,
  `main_image` VARCHAR(45) NOT NULL,
  `main_thumb_image` VARCHAR(45) NOT NULL,
  `product_types_id` INT NOT NULL,
  `product_weight` DECIMAL(10,5) NULL,
  `visible` INT(1) NOT NULL DEFAULT 1,
  `enabled` INT(1) NOT NULL DEFAULT 1,
  `created_date` DATETIME NOT NULL,
  `quantity` INT(11) NOT NULL,
  `num_of_views` INT(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_products_product_types1_idx` (`product_types_id` ASC),
  CONSTRAINT `fk_products_product_types1`
    FOREIGN KEY (`product_types_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_product_types` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_carts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_carts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_date` VARCHAR(45) NOT NULL,
  `users_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_cart_users_idx` (`users_id` ASC),
  CONSTRAINT `fk_cart_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_categories` (
  `id` INT NOT NULL,
  `name` VARCHAR(45) NOT NULL,
  `parent_categories_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_categories_categories1_idx` (`parent_categories_id` ASC),
  CONSTRAINT `fk_categories_categories1`
    FOREIGN KEY (`parent_categories_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_products_to_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_products_to_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `categories_id` INT NOT NULL,
  `products_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_products_to_categories_categories1_idx` (`categories_id` ASC),
  INDEX `fk_products_to_categories_products1_idx` (`products_id` ASC),
  CONSTRAINT `fk_products_to_categories_categories1`
    FOREIGN KEY (`categories_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_categories` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_products_to_categories_products1`
    FOREIGN KEY (`products_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_cart_products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_cart_products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `drex_cart_products_id` INT NOT NULL,
  `drex_cart_carts_id` INT NOT NULL,
  `quantity` INT(11) NOT NULL DEFAULT 1,
  `rate` DECIMAL(10,5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_drex_cart_cart_products_drex_cart_products1_idx` (`drex_cart_products_id` ASC),
  INDEX `fk_drex_cart_cart_products_drex_cart_carts1_idx` (`drex_cart_carts_id` ASC),
  CONSTRAINT `fk_drex_cart_cart_products_drex_cart_products1`
    FOREIGN KEY (`drex_cart_products_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drex_cart_cart_products_drex_cart_carts1`
    FOREIGN KEY (`drex_cart_carts_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_carts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_order_statuses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_order_statuses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_orders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_orders` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created_date` DATETIME NOT NULL,
  `drex_cart_users_id` INT NULL,
  `drex_cart_order_statuses_id` INT NOT NULL,
  `billing_firstname` VARCHAR(45) NOT NULL,
  `billing_lastname` VARCHAR(45) NOT NULL,
  `billing_address1` VARCHAR(45) NOT NULL,
  `billing_address2` VARCHAR(45) NOT NULL,
  `billing_city` VARCHAR(20) NOT NULL,
  `billing_state` VARCHAR(20) NOT NULL,
  `billing_zip` VARCHAR(10) NOT NULL,
  `status_date` DATETIME NOT NULL,
  `billing_phone` VARCHAR(10) NOT NULL,
  `shipping_firstname` VARCHAR(45) NULL,
  `shipping_lastname` VARCHAR(45) NULL,
  `shipping_address1` VARCHAR(45) NULL,
  `shipping_address2` VARCHAR(45) NULL,
  `shipping_city` VARCHAR(20) NULL,
  `shipping_state` VARCHAR(20) NULL,
  `shipping_zip` VARCHAR(10) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_drex_cart_orders_drex_cart_users1_idx` (`drex_cart_users_id` ASC),
  INDEX `fk_drex_cart_orders_drex_cart_order_statuses1_idx` (`drex_cart_order_statuses_id` ASC),
  CONSTRAINT `fk_drex_cart_orders_drex_cart_users1`
    FOREIGN KEY (`drex_cart_users_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drex_cart_orders_drex_cart_order_statuses1`
    FOREIGN KEY (`drex_cart_order_statuses_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_order_statuses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_order_status_histories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_order_status_histories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `status_date` DATETIME NOT NULL,
  `note` VARCHAR(255) NULL,
  `drex_cart_order_statuses_id` INT NOT NULL,
  `drex_cart_orders_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_drex_cart_order_status_histories_drex_cart_order_statuse_idx` (`drex_cart_order_statuses_id` ASC),
  INDEX `fk_drex_cart_order_status_histories_drex_cart_orders1_idx` (`drex_cart_orders_id` ASC),
  CONSTRAINT `fk_drex_cart_order_status_histories_drex_cart_order_statuses1`
    FOREIGN KEY (`drex_cart_order_statuses_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_order_statuses` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drex_cart_order_status_histories_drex_cart_orders1`
    FOREIGN KEY (`drex_cart_orders_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_payment_profiles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_payment_profiles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `card_number` VARCHAR(16) NOT NULL,
  `card_exp` DATE NOT NULL,
  `gateway_profile_id` INT NOT NULL,
  `created_date` DATETIME NOT NULL,
  `drex_cart_users_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_drex_cart_payment_profiles_drex_cart_users1_idx` (`drex_cart_users_id` ASC),
  CONSTRAINT `fk_drex_cart_payment_profiles_drex_cart_users1`
    FOREIGN KEY (`drex_cart_users_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `findy2_drexcart`.`drex_cart_order_products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `findy2_drexcart`.`drex_cart_order_products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `drex_cart_orders_id` INT NOT NULL,
  `drex_cart_products_id` INT NOT NULL,
  `rate` DECIMAL(10,5) NOT NULL,
  `tracking_number` VARCHAR(45) NULL,
  `complete_date` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_drex_cart_order_products_drex_cart_orders1_idx` (`drex_cart_orders_id` ASC),
  INDEX `fk_drex_cart_order_products_drex_cart_products1_idx` (`drex_cart_products_id` ASC),
  CONSTRAINT `fk_drex_cart_order_products_drex_cart_orders1`
    FOREIGN KEY (`drex_cart_orders_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_orders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_drex_cart_order_products_drex_cart_products1`
    FOREIGN KEY (`drex_cart_products_id`)
    REFERENCES `findy2_drexcart`.`drex_cart_products` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
					
					
					
					
					INSERT INTO `findy2_drexcart`.`drex_cart_order_statuses` (`status_name`) VALUES ('Entered');
					
					
					");
			return true;
		} catch (Exception $e) {
			echo $e->getMessage();
			return false;
		}
	}
	
	public function runStep2($sitename='DrexCart') {
		$this->DrexCartConfig = ClassRegistry::init('DrexCart.DrexCartConfig');
		$this->DrexCartConfig->create();
		$this->DrexCartConfig->deleteAll(array('config_code'=>'sitename'));
		$this->DrexCartConfig->id = null;
		$this->DrexCartConfig->save(array('DrexCartConfig'=>array('config_code'=>'sitename',
																  'config_value'=>$sitename,
																  'config_value_type'=>'string')));
		//echo 'step2 ran';
	}
	
}