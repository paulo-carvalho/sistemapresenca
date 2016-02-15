-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2016 at 01:14 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `diretorias`
--

DROP TABLE IF EXISTS `diretorias`;
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
  `tipo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_horario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabela para registrar os momentos que o membro bate ponto: entrando e saindo da empresa.' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `presenca`
--

INSERT INTO `presenca` (`id_presenca`, `matr`, `data`, `entrada`) VALUES
(1, '2012055214', '2016-02-06 23:08:00', 1),
(2, '2012055214', '2016-02-06 23:51:38', 0),
(3, '2012055214', '2016-02-10 15:26:15', 1),
(4, '2012055214', '2016-02-10 15:26:24', 0),
(5, '2012055214', '2016-02-10 15:26:26', 1);

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
  `data_desligamento` datetime DEFAULT NULL,
  PRIMARY KEY (`matr`),
  UNIQUE KEY `email` (`email_pessoal`),
  KEY `diretoria` (`diretoria`),
  KEY `id_premissoes_idx` (`permissao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`matr`, `nome`, `senha`, `email_pessoal`, `email_profissional`, `diretoria`, `cargo`, `ingresso_faculdade`, `ingresso_empresa`, `permissao`, `conectado`, `data_criacao`, `data_desligamento`) VALUES
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

--
-- Constraints for dumped tables
--

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `id_diretoria` FOREIGN KEY (`diretoria`) REFERENCES `diretorias` (`id_diretoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
