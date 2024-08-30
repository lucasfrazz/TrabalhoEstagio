-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema trabalhoestagio
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema trabalhoestagio
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `trabalhoestagio` DEFAULT CHARACTER SET utf8mb4 ;
USE `trabalhoestagio` ;

-- -----------------------------------------------------
-- Table `trabalhoestagio`.`transacoes_financeiras`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trabalhoestagio`.`transacoes_financeiras` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `tipo_transacao` ENUM('receita', 'despesa') NOT NULL,
  `categoria` ENUM('aluguel', 'pagamento', 'prolabore', 'luz', 'agua', 'escola', 'internet', 'outros') NOT NULL,
  `outros` INT(11) NULL DEFAULT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  `descricao` TEXT NULL DEFAULT NULL,
  `data_criacao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `trabalhoestagio`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `trabalhoestagio`.`usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
