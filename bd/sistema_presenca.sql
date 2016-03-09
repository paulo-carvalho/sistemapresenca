<<<<<<< HEAD
-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2016 at 08:18 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sistema_presenca`
--

-- --------------------------------------------------------

--
-- Table structure for table `diretorias`
--

DROP TABLE IF EXISTS `diretorias`;
CREATE TABLE IF NOT EXISTS `diretorias` (
  `id_diretoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_diretoria` varchar(25) NOT NULL,
  PRIMARY KEY (`id_diretoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `diretorias`
--

INSERT INTO `diretorias` (`id_diretoria`, `nome_diretoria`) VALUES
(1, 'Presidência'),
(2, 'Projetos'),
(3, 'Marketing'),
(4, 'Recursos Humanos'),
(5, 'Administrativo-Financeiro');

-- --------------------------------------------------------

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `id_evento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_evento` varchar(100) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `observacoes` text,
  `matr` char(10) NOT NULL,
=======
<<<<<<< 1c230d90bd316f3a5b68a372edac5a7c7da2a1d0
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
>>>>>>> origin/master
  PRIMARY KEY (`id_evento`),
  KEY `fk_evento_usuarios1_idx` (`matr`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Tabela para registrar todo e qualquer tipo de evento não presencial que conta nas horas presenciais do membro (eventos MEJ).';

--
-- Dumping data for table `evento`
--

INSERT INTO `evento` (`id_evento`, `nome_evento`, `data_inicio`, `data_fim`, `observacoes`, `matr`) VALUES
(1, 'Evento exemplo', '2016-02-01 15:00:00', '2016-02-01 18:00:00', 'São informados observações do evento', '2012055214');

-- --------------------------------------------------------

--
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_horario` int(11) NOT NULL AUTO_INCREMENT,
  `matr_usuario` char(10) NOT NULL,
  `dia_semana` varchar(45) DEFAULT NULL,
  `horario` time(4) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_horario`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `horarios`
--

INSERT INTO `horarios` (`id_horario`, `matr_usuario`, `dia_semana`, `horario`, `tipo`) VALUES
(1, '', '', '00:00:00.0000', 'Fixo'),
(2, '', '', '00:00:00.0000', 'Fixo'),
(3, '2016123876', 'Segunda', '14:15:00.0000', 'Fixo'),
(4, '2016123876', 'TerÃ§a', '15:20:00.0000', 'Fixo'),
(5, '', '', '00:00:00.0000', 'Fixo'),
(6, '', '', '00:00:00.0000', 'Fixo'),
(7, '', '', '00:00:00.0000', 'Fixo'),
(8, '', '', '00:00:00.0000', 'Fixo'),
(9, '2018676123', 'Segunda', '20:10:00.0000', 'Fixo'),
(10, '2018676123', 'Segunda', '10:15:00.0000', 'Fixo'),
(11, '', '', '00:00:00.0000', 'Fixo'),
(12, '', '', '00:00:00.0000', 'Fixo'),
(13, '', '', '00:00:00.0000', 'Fixo'),
(14, '', '', '00:00:00.0000', 'Fixo'),
(15, '', '', '00:00:00.0000', 'Fixo'),
(16, '', '', '00:00:00.0000', 'Fixo'),
(17, '', '', '00:00:00.0000', 'Fixo'),
(18, '', '', '00:00:00.0000', 'Fixo'),
(19, '', '', '00:00:00.0000', 'Fixo'),
(20, '', '', '00:00:00.0000', 'Fixo');

-- --------------------------------------------------------

--
-- Table structure for table `permissoes`
--

DROP TABLE IF EXISTS `permissoes`;
CREATE TABLE IF NOT EXISTS `permissoes` (
  `id_permissoes` int(11) NOT NULL AUTO_INCREMENT,
  `nome_permissoes` varchar(25) NOT NULL,
  PRIMARY KEY (`id_permissoes`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissoes`
--

INSERT INTO `permissoes` (`id_permissoes`, `nome_permissoes`) VALUES
(1, 'Administrador'),
(2, 'Membro'),
(3, 'Pós-Júnior');

-- --------------------------------------------------------

--
-- Table structure for table `presenca`
--

DROP TABLE IF EXISTS `presenca`;
CREATE TABLE IF NOT EXISTS `presenca` (
  `id_presenca` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `matr` char(10) NOT NULL,
  `data` datetime NOT NULL,
  `entrada` int(11) NOT NULL COMMENT '0: usuário bateu ponto para sair\n1: usuário bateu ponto para entrar',
  PRIMARY KEY (`id_presenca`),
<<<<<<< HEAD
  KEY `matr` (`matr`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COMMENT='Tabela para registrar os momentos que o membro bate ponto: entrando e saindo da empresa.';

--
-- Dumping data for table `presenca`
--

INSERT INTO `presenca` (`id_presenca`, `matr`, `data`, `entrada`) VALUES
(1, '2012055214', '2016-02-06 23:08:00', 1),
(2, '2012055214', '2016-02-06 23:51:38', 0),
(3, '2012055214', '2016-02-10 15:26:15', 1),
(4, '2012055214', '2016-02-10 15:26:24', 0),
(5, '2012055214', '2016-02-10 15:26:26', 1),
(6, '2012055214', '2016-03-04 00:40:43', 0),
(7, '2012055214', '2016-03-04 00:59:21', 1);
=======
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

=======
-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 19, 2016 at 03:44 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sistema_presenca`
--
CREATE DATABASE IF NOT EXISTS `sistema_presenca` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sistema_presenca`;
>>>>>>> origin/master

-- --------------------------------------------------------

--
<<<<<<< HEAD
-- Table structure for table `presenca_reuniao`
--

DROP TABLE IF EXISTS `presenca_reuniao`;
CREATE TABLE IF NOT EXISTS `presenca_reuniao` (
  `id_reuniao` int(11) NOT NULL,
  `matr` int(11) NOT NULL,
  KEY `id_reuniao` (`id_reuniao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `presenca_reuniao`
--

INSERT INTO `presenca_reuniao` (`id_reuniao`, `matr`) VALUES
(1, 2012055214),
(1, 2018676123),
(2, 2012055214),
(3, 2018676123);
=======
-- Table structure for table `diretorias`
--

DROP TABLE IF EXISTS `diretorias`;
CREATE TABLE IF NOT EXISTS `diretorias` (
  `id_diretoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_diretoria` varchar(25) NOT NULL,
  PRIMARY KEY (`id_diretoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `diretorias`
--

INSERT INTO `diretorias` (`id_diretoria`, `nome_diretoria`) VALUES
(1, 'Presidência'),
(2, 'Projetos'),
(3, 'Marketing'),
(4, 'Recursos Humanos'),
(5, 'Administrativo-Financeiro'),
(6, 'A Definir');
>>>>>>> origin/master

-- --------------------------------------------------------

--
<<<<<<< HEAD
-- Table structure for table `reuniao_geral`
--

DROP TABLE IF EXISTS `reuniao_geral`;
CREATE TABLE IF NOT EXISTS `reuniao_geral` (
  `id_reuniao` int(11) NOT NULL AUTO_INCREMENT,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `detalhes` text NOT NULL,
  PRIMARY KEY (`id_reuniao`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reuniao_geral`
--

INSERT INTO `reuniao_geral` (`id_reuniao`, `data_inicio`, `data_fim`, `detalhes`) VALUES
(1, '2016-02-08 08:00:00', '2016-02-08 10:00:00', 'Ata disponível em:'),
(2, '2016-02-15 08:00:00', '2016-02-15 09:50:00', 'Ata disponível em:'),
(3, '2016-02-11 08:10:00', '2016-02-11 09:59:00', 'Ata disponível em:');
=======
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `id_evento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome_evento` varchar(100) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `observacoes` text,
  `matr` char(10) NOT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `fk_evento_usuarios_idx` (`matr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabela para registrar todo e qualquer tipo de evento não presencial que conta nas horas presenciais do membro (Reuniões Gerais, eventos MEJ).' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `horarios`
--

DROP TABLE IF EXISTS `horarios`;
CREATE TABLE IF NOT EXISTS `horarios` (
  `id_horario` int(11) NOT NULL AUTO_INCREMENT,
  `matr_usuario` char(10) NOT NULL,
  `dia_semana` varchar(45) DEFAULT NULL,
  `horario` time(4) DEFAULT NULL,
  PRIMARY KEY (`id_horario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `horarios`
--

INSERT INTO `horarios` (`id_horario`, `matr_usuario`, `dia_semana`, `horario`) VALUES
(47, '2013062901', 'Segunda', '10:40:00.0000'),
(48, '2013062901', 'TerÃ§a', '23:10:00.0000');

-- --------------------------------------------------------

--
-- Table structure for table `permissoes`
--

DROP TABLE IF EXISTS `permissoes`;
CREATE TABLE IF NOT EXISTS `permissoes` (
  `id_permissoes` int(11) NOT NULL AUTO_INCREMENT,
  `nome_permissoes` varchar(25) NOT NULL,
  PRIMARY KEY (`id_permissoes`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `permissoes`
--

INSERT INTO `permissoes` (`id_permissoes`, `nome_permissoes`) VALUES
(1, 'Administrador'),
(2, 'Membro'),
(3, 'Pós-Júnior');

-- --------------------------------------------------------

--
-- Table structure for table `presenca`
--

DROP TABLE IF EXISTS `presenca`;
CREATE TABLE IF NOT EXISTS `presenca` (
  `id_presenca` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `matr` char(10) NOT NULL,
  `data` datetime NOT NULL,
  `entrada` int(11) NOT NULL COMMENT '0: usuário bateu ponto para sair\n1: usuário bateu ponto para entrar',
  PRIMARY KEY (`id_presenca`),
  KEY `matr` (`matr`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabela para registrar os momentos que o membro bate ponto: entrando e saindo da empresa.' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `presenca`
--

INSERT INTO `presenca` (`id_presenca`, `matr`, `data`, `entrada`) VALUES
(1, '2012055214', '2016-02-06 23:08:00', 1),
(2, '2012055214', '2016-02-06 23:51:38', 0),
(3, '2012055214', '2016-02-10 15:26:15', 1),
(4, '2012055214', '2016-02-10 15:26:24', 0),
(5, '2012055214', '2016-02-10 15:26:26', 1),
(6, '2013062901', '2016-02-15 08:56:32', 1),
(7, '2013062901', '2016-02-15 08:56:45', 0),
(8, '2016123456', '2016-02-17 09:25:44', 1),
(9, '2016123456', '2016-02-18 22:37:59', 0);
>>>>>>> origin/master

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `matr` char(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `email_pessoal` char(50) NOT NULL,
  `email_profissional` varchar(50) DEFAULT NULL,
  `diretoria` int(11) DEFAULT NULL,
  `cargo` char(30) NOT NULL,
  `ingresso_faculdade` varchar(6) NOT NULL,
  `ingresso_empresa` varchar(45) DEFAULT NULL,
  `permissao` int(6) NOT NULL COMMENT 'admin ou comum',
  `conectado` int(11) NOT NULL COMMENT '1=CONECTADO; 0=NÃO CONECTADO',
  `data_criacao` datetime NOT NULL,
<<<<<<< HEAD
  `data_desligamento` datetime DEFAULT NULL,
=======
  `data_desligamento` varchar(45) DEFAULT NULL,
>>>>>>> origin/master
  PRIMARY KEY (`matr`),
  UNIQUE KEY `email` (`email_pessoal`),
  KEY `diretoria` (`diretoria`),
  KEY `id_premissoes_idx` (`permissao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`matr`, `nome`, `senha`, `email_pessoal`, `email_profissional`, `diretoria`, `cargo`, `ingresso_faculdade`, `ingresso_empresa`, `permissao`, `conectado`, `data_criacao`, `data_desligamento`) VALUES
<<<<<<< HEAD
('1120120552', 'Paulo', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.com', '', 1, 'trainee', '0000-0', NULL, 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('12321321', '', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'email@email.com', '', 1, 'Trainee', '2010/1', NULL, 3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2010145673', 'Bla Bla', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'bla@email.com', '', 1, 'Trainee', '', '02/02/2016', 3, 0, '2016-02-14 17:45:08', '0000-00-00 00:00:00'),
('2010176654', 'Bruno Costa', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'bc@gmail.com', '', 1, 'Trainee', '2010/2', '11/02/2009', 2, 0, '2016-02-14 18:06:33', '0000-00-00 00:00:00'),
('2010876188', 'Bernadette', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'ber@gmail.com', '', 2, 'Trainee', '', NULL, 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2010987164', 'Carolina', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'carol@gmail.com', '', 3, 'Trainee', '', NULL, 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2012055214', 'Pauloa', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.ccom', '', 2, 'trainee', '0000-0', NULL, 2, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2014563787', 'JosÃ© Vitor', 'de7cd86411f5c3a6c693bdeab8d94a66979d33d05791b5ebd176837495130b9e', 'josev@gmail.com', 'jose@empresa.com', 2, 'Membro', '', '12/01/2016', 2, 0, '2016-02-14 17:42:59', '0000-00-00 00:00:00'),
('2015673777', 'oi', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'oi@email.com', '', 1, 'Trainee', '2015/2', '', 3, 0, '2016-02-14 17:47:40', '0000-00-00 00:00:00'),
('2015676234', 'Maria da Silva e Silva', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'maria@pessoal.com', 'maria@profissional.com', 2, 'Trainee', '2', '0', 1, 4, '2016-02-14 17:38:59', '0000-00-00 00:00:00'),
('2015787172', 'Maria', '0206a97843b1ba4fbb147d472550ec3b5ee8aacadf3707522157240940d1bebd', 'maria@yahoo.com', 'maria@gmail.com', 3, 'trainee', '2015/2', NULL, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2017143672', 'Julio', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'julio@gmail.com', '', 2, 'Membro', '', NULL, 2, 0, '2016-02-12 12:47:54', '0000-00-00 00:00:00'),
('2018676123', 'User', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user@email.com', '', 3, 'Trainee', '', NULL, 3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2019872817', 'Jose da Silva', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'jose@gmail.com', 'jose@yahoo.com', 1, 'trainee', '2017/2', NULL, 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2019888777', 'qualquer', '75c16ebbb641ed154f47cbaa85ecc06fd394d2c4d0529ccd6b2ec211604e4515', 'qualquer@meialcm.com', '', 2, 'Diretor', '2018/2', '01/02/2016', 3, 0, '2016-02-14 17:48:25', '0000-00-00 00:00:00'),
('2101091231', 'marcos', 'b452bb3317b617a3a51051c5e210d04fc079f302593573bde4bea30c23ba6820', 'marcos@hotmail.com', 'marcos@bing.com', 1, 'Trainee', '2019/1', NULL, 3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('21312312', 'carlos', '83f720439fec373a817eac1f5ecb45737022dc1b6527f8091721a8209db97905', 'carlos@gmail.com', 'carlos@yahoo.com', 1, 'trainee', '2010/1', NULL, 3, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2131232131', 'Gustavo', '83f720439fec373a817eac1f5ecb45737022dc1b6527f8091721a8209db97905', 'gustavo@gmail.com', 'gustavo@yahoo.com', 1, 'trainee', '9281/1', NULL, 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2132103123', 'Ester', '46070d4bf934fb0d4b06d9e2c46e346944e322444900a435d7d9a95e6d7435f5', 'ester@gmail.com', '', 2, 'Membro', '', NULL, 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2172313213', 'Bruno', '441b02df090112b0b48b44e9eb6026d2ca1eec0d685c7d5712b59efbb9423a0c', 'bruno@gmail.com', 'bruno@gmail.com', 1, 'trainee', '21313', NULL, 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
=======
('1120120552', 'Paulo', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.com', '', 1, 'trainee', '0000-0', NULL, 2, 0, '0000-00-00 00:00:00', NULL),
('12321321', '', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'email@email.com', '', 1, 'Trainee', '2010/1', NULL, 3, 0, '0000-00-00 00:00:00', NULL),
('2010123456', 'Maria JosÃ©', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'mj@email.com', '', 3, 'Membro', '2010/1', '01/02/2016', 1, 0, '2016-02-19 00:00:29', NULL),
('2010145673', 'Bla Bla', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'bla@email.com', '', 1, 'Trainee', '', '02/02/2016', 3, 0, '2016-02-14 17:45:08', NULL),
('2010176654', 'Bruno Costa Silva Pereira Braga 2', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'bc@gmail.com', '', 1, 'Trainee', '2010/2', '11/02/2009', 2, 0, '2016-02-14 18:06:33', NULL),
('2010876188', 'Bernadette da Silva e Silva', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'ber@gmail.com', '', 4, 'Diretor', '2010/2', '04/01/2016', 1, 0, '0000-00-00 00:00:00', '19/02/2016'),
('2010888766', 'Nome Completo', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'emailpessoal@email.com', '', 6, 'Trainee', '2010/2', '01/02/2016', 1, 0, '2016-02-19 00:05:20', '02/02/2016'),
('2010987164', 'Carolina Bla Bla', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'carol@gmail.com', 'joia@email.com', 4, 'Diretor', '2010/2', '04/02/2016', 2, 0, '0000-00-00 00:00:00', NULL),
('2012055214', 'Pauloa', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.ccom', '', 2, 'trainee', '0000-0', NULL, 2, 1, '0000-00-00 00:00:00', NULL),
('2012123456', 'Novo UsuÃ¡rio', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'novo@email.com', '', 1, 'Trainee', '2012/2', '01/02/2012', 1, 0, '2016-02-18 23:54:03', NULL),
('2013062901', 'Gabriela Brant Alves', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'gabibrantalves@gmail.com', '', 1, 'Trainee', '2013/1', '12/11/2015', 1, 0, '2016-02-15 08:20:06', ''),
('2014123456', 'teste', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'teste@email.com', '', 6, 'Trainee', '2014/2', '10/02/2016', 1, 0, '2016-02-18 23:55:14', NULL),
('2014563787', 'JosÃ© Vitor', 'de7cd86411f5c3a6c693bdeab8d94a66979d33d05791b5ebd176837495130b9e', 'josev@gmail.com', 'jose@empresa.com', 2, 'Membro', '', '12/01/2016', 3, 0, '2016-02-14 17:42:59', NULL),
('2015673777', 'oi', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'oi@email.com', '', 1, 'Trainee', '2015/2', '', 3, 0, '2016-02-14 17:47:40', NULL),
('2015676234', 'Maria da Silva e Silva', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'maria@pessoal.com', 'maria@profissional.com', 2, 'Trainee', '2', '0', 1, 4, '2016-02-14 17:38:59', NULL),
('2015787172', 'Maria', '0206a97843b1ba4fbb147d472550ec3b5ee8aacadf3707522157240940d1bebd', 'maria@yahoo.com', 'maria@gmail.com', 3, 'trainee', '2015/2', NULL, 1, 0, '0000-00-00 00:00:00', NULL),
('2016123456', 'Membro', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'membro@email.com', '', 1, 'Trainee', '2016/1', '16/02/2016', 2, 0, '2016-02-17 08:56:08', NULL),
('2017143672', 'Julio Julio Julio Julio', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'julio@gmail.com', '', 2, 'Membro', '', NULL, 2, 0, '2016-02-12 12:47:54', NULL),
('2018676123', 'User', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user@email.com', '', 3, 'Trainee', '', NULL, 3, 0, '0000-00-00 00:00:00', NULL),
('2019872817', 'Jose da Silva', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'jose@gmail.com', 'jose@yahoo.com', 1, 'Trainee', '2017/2', '', 1, 0, '0000-00-00 00:00:00', NULL),
('2019888777', 'Qualquer de novo', '75c16ebbb641ed154f47cbaa85ecc06fd394d2c4d0529ccd6b2ec211604e4515', 'qualquer@email.com', 'profissional@email.com', 2, 'Diretor', '2018/2', '01/02/2016', 2, 0, '2016-02-14 17:48:25', NULL),
('2101091231', 'marcos', 'b452bb3317b617a3a51051c5e210d04fc079f302593573bde4bea30c23ba6820', 'marcos@hotmail.com', 'marcos@bing.com', 1, 'Trainee', '2019/1', NULL, 3, 0, '0000-00-00 00:00:00', NULL),
('21312312', 'carlos', '83f720439fec373a817eac1f5ecb45737022dc1b6527f8091721a8209db97905', 'carlos@gmail.com', 'carlos@yahoo.com', 1, 'trainee', '2010/1', NULL, 3, 0, '0000-00-00 00:00:00', NULL),
('2131232131', 'Gustavo Pereira', '83f720439fec373a817eac1f5ecb45737022dc1b6527f8091721a8209db97905', 'gustavo@gmail.com', 'gustavo@yahoo.com', 1, 'Diretor', '2010/2', '', 1, 0, '0000-00-00 00:00:00', NULL),
('2132103123', 'Ester Ester', '46070d4bf934fb0d4b06d9e2c46e346944e322444900a435d7d9a95e6d7435f5', 'ester@gmail.com', '', 2, 'Membro', '2012/2', '', 3, 0, '0000-00-00 00:00:00', NULL),
('2172313213', 'Bruno', '441b02df090112b0b48b44e9eb6026d2ca1eec0d685c7d5712b59efbb9423a0c', 'bruno@gmail.com', 'bruno@gmail.com', 1, 'Trainee', '2010/2', '', 2, 0, '0000-00-00 00:00:00', NULL);
>>>>>>> origin/master

--
-- Constraints for dumped tables
--

--
<<<<<<< HEAD
-- Constraints for table `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `fk_evento_usuarios1` FOREIGN KEY (`matr`) REFERENCES `usuarios` (`matr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
=======
>>>>>>> origin/master
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `id_diretoria` FOREIGN KEY (`diretoria`) REFERENCES `diretorias` (`id_diretoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
<<<<<<< HEAD
=======
>>>>>>> Cadastrar, ver, editar, ativar e desativar FINALIZADOS
>>>>>>> origin/master
