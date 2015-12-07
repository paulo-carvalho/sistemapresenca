-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2015 at 02:46 AM
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
DROP DATABASE `sistema_presenca`;
CREATE DATABASE IF NOT EXISTS `sistema_presenca` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sistema_presenca`;

-- --------------------------------------------------------

--
-- Table structure for table `presenca`
--

CREATE TABLE IF NOT EXISTS `presenca` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `matr` char(10) NOT NULL,
  `data_inicio` char(9) NOT NULL,
  `data_fim` char(9) NOT NULL,
  `tipo` char(2) NOT NULL COMMENT 'presencial (P) ou nao presencial (NP)',
  `observacoes` text,
  `evento` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `matr` (`matr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `matr` char(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` char(50) NOT NULL,
  `cargo` char(30) DEFAULT NULL,
  `setor` char(30) DEFAULT NULL,
  `senha` varchar(20) NOT NULL,
  `permissao` varchar(6) NOT NULL COMMENT 'admin ou membro',
  `conectado` int(11) NOT NULL COMMENT '1=conectado;0=não conectado',
  PRIMARY KEY (`matr`),
  UNIQUE KEY `email` (`email`),
  FULLTEXT KEY `setor` (`setor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`matr`, `nome`, `email`, `cargo`, `setor`, `senha`, `permissao`, `conectado`) VALUES
('1120120552', 'Paulo Henrique de Carvalho', 'paulo@paulo.com', 'trainee', 'presidencia', '8d969eef6ecad3c29a3a', 'comum', 0),
('2011102444', 'Teste', 'teste@test.c', 'membro', 'presidencia', '8d969eef6ecad3c29a3a', 'comum', 0),
('2012055055', 'Gabriela', 'gabi@gabi.com.br', 'trainee', 'financeiro', 'e6757959da8eff84c42d', 'comum', 0),
('2012055214', 'Paulaa', 'paulo@paulo.ccomc', 'trainee', 'projetos', '8d969eef6ecad3c29a3a', 'comum', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
