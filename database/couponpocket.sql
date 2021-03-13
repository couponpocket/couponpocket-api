-- MySQL Script generated by MySQL Workbench
-- Sat Mar 13 10:37:24 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema couponpocket
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema couponpocket
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `couponpocket` DEFAULT CHARACTER SET utf8 ;
USE `couponpocket` ;

-- -----------------------------------------------------
-- Table `couponpocket`.`coupons`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `couponpocket`.`coupons` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `where` VARCHAR(255) NOT NULL,
  `points` VARCHAR(255) NOT NULL,
  `condition` VARCHAR(255) NOT NULL,
  `ean` VARCHAR(255) NOT NULL,
  `source` VARCHAR(255) NULL,
  `valid_from` DATETIME NULL,
  `valid_till` DATETIME NULL,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`, `ean`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
