-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema sistema_presenca
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema sistema_presenca
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `sistema_presenca` DEFAULT CHARACTER SET latin1 ;
USE `sistema_presenca` ;

-- -----------------------------------------------------
-- Table `sistema_presenca`.`diretorias`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_presenca`.`diretorias` (
  `id_diretoria` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_diretoria` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id_diretoria`))
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `sistema_presenca`.`permissoes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_presenca`.`permissoes` (
  `id_permissoes` INT(11) NOT NULL AUTO_INCREMENT,
  `nome_permissoes` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`id_permissoes`))
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `sistema_presenca`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_presenca`.`usuarios` (
  `matr` CHAR(10) NOT NULL,
  `nome` VARCHAR(50) NOT NULL,
  `senha` VARCHAR(256) NOT NULL,
  `email_pessoal` CHAR(50) NOT NULL,
  `email_profissional` VARCHAR(50) NULL DEFAULT NULL,
  `diretoria` INT(11) NULL DEFAULT NULL,
  `cargo` CHAR(30) NOT NULL,
  `ingresso_faculdade` VARCHAR(6) NOT NULL,
  `ingresso_empresa` VARCHAR(45) NULL DEFAULT NULL,
  `permissao` INT(11) NOT NULL,
  `conectado` INT(11) NOT NULL COMMENT '1=CONECTADO; 0=NÃO CONECTADO',
  `data_criacao` DATETIME NOT NULL,
  `data_desligamento` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`matr`),
  UNIQUE INDEX `email` (`email_pessoal` ASC),
  INDEX `diretoria` (`diretoria` ASC),
  INDEX `fk_usuarios_permissoes1_idx` (`permissao` ASC),
  CONSTRAINT `id_diretoria`
    FOREIGN KEY (`diretoria`)
    REFERENCES `sistema_presenca`.`diretorias` (`id_diretoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuarios_permissoes1`
    FOREIGN KEY (`permissao`)
    REFERENCES `sistema_presenca`.`permissoes` (`id_permissoes`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `sistema_presenca`.`evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_presenca`.`evento` (
  `id_evento` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_evento` VARCHAR(100) NOT NULL,
  `data_inicio` DATETIME NOT NULL,
  `data_fim` DATETIME NOT NULL,
  `observacoes` TEXT NULL DEFAULT NULL,
  `matr` CHAR(10) NOT NULL,
  `usuarios_matr` CHAR(10) NOT NULL,
  PRIMARY KEY (`id_evento`),
  INDEX `fk_evento_usuarios_idx` (`matr` ASC),
  INDEX `fk_evento_usuarios1_idx` (`usuarios_matr` ASC),
  CONSTRAINT `fk_evento_usuarios1`
    FOREIGN KEY (`usuarios_matr`)
    REFERENCES `sistema_presenca`.`usuarios` (`matr`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tabela para registrar todo e qualquer tipo de evento não presencial que conta nas horas presenciais do membro (eventos MEJ).';


-- -----------------------------------------------------
-- Table `sistema_presenca`.`horarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_presenca`.`horarios` (
  `id_horario` INT(11) NOT NULL AUTO_INCREMENT,
  `dia_semana` VARCHAR(45) NULL DEFAULT NULL,
  `horario` TIME NULL DEFAULT NULL,
  `matr` CHAR(10) NOT NULL,
  PRIMARY KEY (`id_horario`),
  INDEX `fk_horarios_usuarios1_idx` (`matr` ASC),
  CONSTRAINT `fk_horarios_usuarios1`
    FOREIGN KEY (`matr`)
    REFERENCES `sistema_presenca`.`usuarios` (`matr`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 21
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `sistema_presenca`.`presenca`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_presenca`.`presenca` (
  `id_presenca` INT(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `data` DATETIME NOT NULL,
  `entrada` INT(11) NOT NULL COMMENT '0: usuário bateu ponto para sair\n1: usuário bateu ponto para entrar',
  `matr` CHAR(10) NOT NULL,
  PRIMARY KEY (`id_presenca`),
  INDEX `fk_presenca_usuarios1_idx` (`matr` ASC),
  CONSTRAINT `fk_presenca_usuarios1`
    FOREIGN KEY (`matr`)
    REFERENCES `sistema_presenca`.`usuarios` (`matr`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1
COMMENT = 'Tabela para registrar os momentos que o membro bate ponto: entrando e saindo da empresa.';


-- -----------------------------------------------------
-- Table `sistema_presenca`.`reuniao_geral`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_presenca`.`reuniao_geral` (
  `id_reuniao` INT(11) NOT NULL AUTO_INCREMENT,
  `data_inicio` DATETIME NOT NULL,
  `data_fim` DATETIME NOT NULL,
  `detalhes` TEXT NOT NULL,
  PRIMARY KEY (`id_reuniao`))
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `sistema_presenca`.`presenca_reuniao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sistema_presenca`.`presenca_reuniao` (
  `id_reuniao` INT(11) NOT NULL,
  `matr` CHAR(10) NOT NULL,
  INDEX `fk_presenca_reuniao_reuniao_geral1_idx` (`id_reuniao` ASC),
  INDEX `fk_presenca_reuniao_usuarios1_idx` (`matr` ASC))
ENGINE = MyISAM
DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sistema_presenca`.`diretorias`
-- -----------------------------------------------------
START TRANSACTION;
USE `sistema_presenca`;
INSERT INTO `sistema_presenca`.`diretorias` (`id_diretoria`, `nome_diretoria`) VALUES (1, 'Presidência');
INSERT INTO `sistema_presenca`.`diretorias` (`id_diretoria`, `nome_diretoria`) VALUES (2, 'Projetos');
INSERT INTO `sistema_presenca`.`diretorias` (`id_diretoria`, `nome_diretoria`) VALUES (3, 'Marketing e Vendas');
INSERT INTO `sistema_presenca`.`diretorias` (`id_diretoria`, `nome_diretoria`) VALUES (4, 'Recursos Humanos');
INSERT INTO `sistema_presenca`.`diretorias` (`id_diretoria`, `nome_diretoria`) VALUES (5, 'Administrativo-financeiro');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sistema_presenca`.`permissoes`
-- -----------------------------------------------------
START TRANSACTION;
USE `sistema_presenca`;
INSERT INTO `sistema_presenca`.`permissoes` (`id_permissoes`, `nome_permissoes`) VALUES (1, 'Administrador');
INSERT INTO `sistema_presenca`.`permissoes` (`id_permissoes`, `nome_permissoes`) VALUES (2, 'Membro');
INSERT INTO `sistema_presenca`.`permissoes` (`id_permissoes`, `nome_permissoes`) VALUES (3, 'Pós-Júnior');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sistema_presenca`.`usuarios`
-- -----------------------------------------------------
START TRANSACTION;
USE `sistema_presenca`;
INSERT INTO `sistema_presenca`.`usuarios` (`matr`, `nome`, `senha`, `email_pessoal`, `email_profissional`, `diretoria`, `cargo`, `ingresso_faculdade`, `ingresso_empresa`, `permissao`, `conectado`, `data_criacao`, `data_desligamento`) VALUES ('2012055214', 'Pauloa', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.com', NULL, 2, 'Trainee', '2012-2', 'NULL', 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
INSERT INTO `sistema_presenca`.`usuarios` (`matr`, `nome`, `senha`, `email_pessoal`, `email_profissional`, `diretoria`, `cargo`, `ingresso_faculdade`, `ingresso_empresa`, `permissao`, `conectado`, `data_criacao`, `data_desligamento`) VALUES ('2018676123', 'User', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user@email.com', NULL, 3, 'Trainee', NULL, 'NULL', 3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sistema_presenca`.`horarios`
-- -----------------------------------------------------
START TRANSACTION;
USE `sistema_presenca`;
INSERT INTO `sistema_presenca`.`horarios` (`id_horario`, `dia_semana`, `horario`, `matr`) VALUES (1, 'Segunda', '14:15:00.0000', '2012055214');
INSERT INTO `sistema_presenca`.`horarios` (`id_horario`, `dia_semana`, `horario`, `matr`) VALUES (2, 'Terça', '15:20:00.0000', '2012055214');
INSERT INTO `sistema_presenca`.`horarios` (`id_horario`, `dia_semana`, `horario`, `matr`) VALUES (3, 'Segunda', '20:10:00.0000', '2018676123');
INSERT INTO `sistema_presenca`.`horarios` (`id_horario`, `dia_semana`, `horario`, `matr`) VALUES (4, 'Segunda', '10:15:00.0000', '2018676123');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sistema_presenca`.`presenca`
-- -----------------------------------------------------
START TRANSACTION;
USE `sistema_presenca`;
INSERT INTO `sistema_presenca`.`presenca` (`id_presenca`, `data`, `entrada`, `matr`) VALUES (1, '2016-02-06 23:08:00', 1, '2012055214');
INSERT INTO `sistema_presenca`.`presenca` (`id_presenca`, `data`, `entrada`, `matr`) VALUES (2, '2016-02-06 23:51:38', 0, '2012055214');
INSERT INTO `sistema_presenca`.`presenca` (`id_presenca`, `data`, `entrada`, `matr`) VALUES (3, '2016-02-10 15:26:15', 1, '2012055214');
INSERT INTO `sistema_presenca`.`presenca` (`id_presenca`, `data`, `entrada`, `matr`) VALUES (4, '2016-02-10 15:26:24', 0, '2012055214');
INSERT INTO `sistema_presenca`.`presenca` (`id_presenca`, `data`, `entrada`, `matr`) VALUES (5, '2016-02-10 15:26:26', 1, '2012055214');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sistema_presenca`.`reuniao_geral`
-- -----------------------------------------------------
START TRANSACTION;
USE `sistema_presenca`;
INSERT INTO `sistema_presenca`.`reuniao_geral` (`id_reuniao`, `data_inicio`, `data_fim`, `detalhes`) VALUES (1, '2016-02-08 08:00:00', '2016-02-08 10:00:00', 'Ata disponível em:');
INSERT INTO `sistema_presenca`.`reuniao_geral` (`id_reuniao`, `data_inicio`, `data_fim`, `detalhes`) VALUES (2, '2016-02-15 08:00:00', '2016-02-08 09:50:00', 'Ata disponível em:');
INSERT INTO `sistema_presenca`.`reuniao_geral` (`id_reuniao`, `data_inicio`, `data_fim`, `detalhes`) VALUES (3, '2016-02-11 08:10:00', '2016-02-21 09:59:00', 'Ata disponível em:');

COMMIT;


-- -----------------------------------------------------
-- Data for table `sistema_presenca`.`presenca_reuniao`
-- -----------------------------------------------------
START TRANSACTION;
USE `sistema_presenca`;
INSERT INTO `sistema_presenca`.`presenca_reuniao` (`id_reuniao`, `matr`) VALUES (1, '2018676123');
INSERT INTO `sistema_presenca`.`presenca_reuniao` (`id_reuniao`, `matr`) VALUES (1, '2012055214');
INSERT INTO `sistema_presenca`.`presenca_reuniao` (`id_reuniao`, `matr`) VALUES (2, '2012055214');
INSERT INTO `sistema_presenca`.`presenca_reuniao` (`id_reuniao`, `matr`) VALUES (3, '2018676123');

COMMIT;

