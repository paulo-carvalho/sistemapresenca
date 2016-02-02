-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2016 at 06:19 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `diretorias`
--

CREATE TABLE IF NOT EXISTS `diretorias` (
  `id_diretoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_diretoria` varchar(25) NOT NULL,
  PRIMARY KEY (`id_diretoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
-- Table structure for table `permissoes`
--

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

CREATE TABLE IF NOT EXISTS `presenca` (
  `id_presenca` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `matr` char(10) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `tipo` char(2) NOT NULL COMMENT 'presencial (P) ou nao presencial (NP)',
  `observacoes` text,
  `evento` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_presenca`),
  KEY `matr` (`matr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `matr` char(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(256) NOT NULL,
  `email_pessoal` char(50) NOT NULL,
  `email_profissional` varchar(50) NOT NULL,
  `diretoria` int(11) DEFAULT NULL,
  `cargo` char(30) DEFAULT NULL,
  `permissao` int(6) NOT NULL COMMENT 'admin ou comum',
  `conectado` int(11) NOT NULL COMMENT '1=CONECTADO; 0=NÃO CONECTADO',
  `ingresso_faculdade` varchar(6) NOT NULL,
  `data_criacao` datetime NOT NULL,
  `data_desligamento` datetime NOT NULL,
  PRIMARY KEY (`matr`),
  UNIQUE KEY `email` (`email_pessoal`),
  KEY `diretoria` (`diretoria`),
  KEY `permissao` (`permissao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`matr`, `nome`, `senha`, `email_pessoal`, `email_profissional`, `diretoria`, `cargo`, `permissao`, `conectado`, `ingresso_faculdade`, `data_criacao`, `data_desligamento`) VALUES
('1120120552', 'Paulo', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.com', '', 1, 'trainee', 1, 0, '0000-0', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
('2012055214', 'Pauloa', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.ccom', '', 2, 'trainee', 1, 0, '0000-0', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `presenca`
--
ALTER TABLE `presenca`
  ADD CONSTRAINT `presenca_ibfk_1` FOREIGN KEY (`matr`) REFERENCES `usuarios` (`matr`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`diretoria`) REFERENCES `diretorias` (`id_diretoria`),
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`permissao`) REFERENCES `permissoes` (`id_permissoes`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
