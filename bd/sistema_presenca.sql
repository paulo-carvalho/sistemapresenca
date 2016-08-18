-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 18-Ago-2016 às 19:07
-- Versão do servidor: 5.7.9
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
-- Estrutura da tabela `diretorias`
--

DROP TABLE IF EXISTS `diretorias`;
CREATE TABLE IF NOT EXISTS `diretorias` (
  `id_diretoria` int(11) NOT NULL AUTO_INCREMENT,
  `nome_diretoria` varchar(25) NOT NULL,
  PRIMARY KEY (`id_diretoria`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `diretorias`
--

INSERT INTO `diretorias` (`id_diretoria`, `nome_diretoria`) VALUES
(1, 'Presidência'),
(2, 'Projetos'),
(3, 'Marketing'),
(4, 'Recursos Humanos'),
(5, 'Administrativo-Financeiro');

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

DROP TABLE IF EXISTS `evento`;
CREATE TABLE IF NOT EXISTS `evento` (
  `id_evento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome_evento` varchar(100) NOT NULL,
  `data_inicio` datetime NOT NULL,
  `data_fim` datetime NOT NULL,
  `observacoes` text,
  `matr` char(10) NOT NULL,
  PRIMARY KEY (`id_evento`),
  KEY `fk_evento_usuarios1_idx` (`matr`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Tabela para registrar todo e qualquer tipo de evento não presencial que conta nas horas presenciais do membro (eventos MEJ).';

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`id_evento`, `nome_evento`, `data_inicio`, `data_fim`, `observacoes`, `matr`) VALUES
(1, 'Evento exemplo', '2016-02-01 15:00:00', '2016-02-01 18:00:00', 'São informados observações do evento', '2012055214');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horarios`
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
-- Extraindo dados da tabela `horarios`
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
-- Estrutura da tabela `permissoes`
--

DROP TABLE IF EXISTS `permissoes`;
CREATE TABLE IF NOT EXISTS `permissoes` (
  `id_permissoes` int(11) NOT NULL AUTO_INCREMENT,
  `nome_permissoes` varchar(25) NOT NULL,
  PRIMARY KEY (`id_permissoes`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `permissoes`
--

INSERT INTO `permissoes` (`id_permissoes`, `nome_permissoes`) VALUES
(1, 'Administrador'),
(2, 'Membro'),
(3, 'Pós-Júnior');

-- --------------------------------------------------------

--
-- Estrutura da tabela `presenca`
--

DROP TABLE IF EXISTS `presenca`;
CREATE TABLE IF NOT EXISTS `presenca` (
  `id_presenca` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `matr` char(10) NOT NULL,
  `data` datetime NOT NULL,
  `entrada` int(11) NOT NULL COMMENT '0: usuário bateu ponto para sair\n1: usuário bateu ponto para entrar',
  PRIMARY KEY (`id_presenca`),
  KEY `matr` (`matr`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='Tabela para registrar os momentos que o membro bate ponto: entrando e saindo da empresa.';

--
-- Extraindo dados da tabela `presenca`
--

INSERT INTO `presenca` (`id_presenca`, `matr`, `data`, `entrada`) VALUES
(1, '2012055214', '2016-02-06 23:08:00', 1),
(2, '2012055214', '2016-02-06 23:51:38', 0),
(3, '2012055214', '2016-02-10 15:26:15', 1),
(4, '2012055214', '2016-02-10 15:26:24', 0),
(5, '2012055214', '2016-02-10 15:26:26', 1),
(6, '2012055214', '2016-03-04 00:40:43', 0),
(7, '2012055214', '2016-03-04 00:59:21', 1),
(8, '2012055214', '2016-03-13 09:34:00', 0),
(9, '2012055214', '2016-03-13 09:34:07', 1),
(10, '2012055214', '2016-03-20 13:37:12', 0),
(11, '2012055214', '2016-03-27 20:08:44', 1),
(12, '2012055214', '2016-05-02 00:04:18', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `presenca_reuniao`
--

DROP TABLE IF EXISTS `presenca_reuniao`;
CREATE TABLE IF NOT EXISTS `presenca_reuniao` (
  `id_reuniao` int(11) NOT NULL,
  `matr` int(11) NOT NULL,
  KEY `id_reuniao` (`id_reuniao`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `presenca_reuniao`
--

INSERT INTO `presenca_reuniao` (`id_reuniao`, `matr`) VALUES
(1, 2012055214),
(1, 2018676123),
(2, 2012055214),
(3, 2018676123);

-- --------------------------------------------------------

--
-- Estrutura da tabela `reuniao_geral`
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
-- Extraindo dados da tabela `reuniao_geral`
--

INSERT INTO `reuniao_geral` (`id_reuniao`, `data_inicio`, `data_fim`, `detalhes`) VALUES
(1, '2016-02-08 08:00:00', '2016-02-08 10:00:00', 'Ata disponível em:'),
(2, '2016-02-15 08:00:00', '2016-02-15 09:50:00', 'Ata disponível em:'),
(3, '2016-02-11 08:10:00', '2016-02-11 09:59:00', 'Ata disponível em:');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
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
  `data_desligamento` varchar(45) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `linkedin` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`matr`),
  UNIQUE KEY `email` (`email_pessoal`),
  KEY `diretoria` (`diretoria`),
  KEY `id_premissoes_idx` (`permissao`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`matr`, `nome`, `senha`, `email_pessoal`, `email_profissional`, `diretoria`, `cargo`, `ingresso_faculdade`, `ingresso_empresa`, `permissao`, `conectado`, `data_criacao`, `data_desligamento`, `facebook`, `linkedin`) VALUES
('1120120552', 'Paulo', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.com', '', 1, 'trainee', '0000-0', NULL, 2, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('12321321', '', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'email@email.com', '', 1, 'Trainee', '2010/1', NULL, 3, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2000000000', 'l', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'dd@gmail.com', '', 1, 'Trainee', '2016/1', '', 2, 0, '2016-08-07 20:17:02', '', NULL, NULL),
('2010145673', 'Bla Bla', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'bla@email.com', '', 1, 'Trainee', '', '02/02/2016', 3, 0, '2016-02-14 17:45:08', NULL, NULL, NULL),
('2010176654', 'Bruno Costa', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'bc@gmail.com', '', 1, 'Trainee', '2010/2', '11/02/2009', 2, 0, '2016-02-14 18:06:33', NULL, NULL, NULL),
('2010876188', 'Bernadette', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'ber@gmail.com', '', 2, 'Trainee', '', NULL, 2, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2010987164', 'Carolina', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', 'carol@gmail.com', '', 3, 'Trainee', '', NULL, 2, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2012055214', 'Pauloa', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'paulo@paulo.ccom', '', 2, 'trainee', '0000-0', NULL, 1, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2012055219', 'Paulo Henrique de Carvalho', 'ed5ec2ca35dc55e2ccf8f63dc7f52a2b378f87b1fda1a31afa30bbd67c17fa8b', 'paulocarvalho@dcc.ufmg.br', 'paulo.carvalho@ijunior.com.br', 4, 'Diretor', '2012/2', '13/11/2015', 1, 0, '2016-05-05 11:35:42', '', NULL, NULL),
('2014563787', 'JosÃ© Vitor', 'de7cd86411f5c3a6c693bdeab8d94a66979d33d05791b5ebd176837495130b9e', 'josev@gmail.com', 'jose@empresa.com', 2, 'Membro', '', '12/01/2016', 2, 0, '2016-02-14 17:42:59', NULL, NULL, NULL),
('2015673777', 'oi', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'oi@email.com', '', 1, 'Trainee', '2015/2', '', 3, 0, '2016-02-14 17:47:40', NULL, NULL, NULL),
('2015676234', 'Maria da Silva e Silva', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'maria@pessoal.com', 'maria@profissional.com', 2, 'Trainee', '2', '0', 1, 4, '2016-02-14 17:38:59', NULL, NULL, NULL),
('2015787172', 'Maria', '0206a97843b1ba4fbb147d472550ec3b5ee8aacadf3707522157240940d1bebd', 'maria@yahoo.com', 'maria@gmail.com', 3, 'trainee', '2015/2', NULL, 1, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2017143672', 'Julio', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'julio@gmail.com', '', 2, 'Membro', '', NULL, 2, 0, '2016-02-12 12:47:54', NULL, NULL, NULL),
('2018676123', 'User', '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', 'user@email.com', '', 3, 'Trainee', '', NULL, 3, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2019872817', 'Jose da Silva', '55a5e9e78207b4df8699d60886fa070079463547b095d1a05bc719bb4e6cd251', 'jose@gmail.com', 'jose@yahoo.com', 1, 'trainee', '2017/2', NULL, 1, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2019888777', 'qualquer', '75c16ebbb641ed154f47cbaa85ecc06fd394d2c4d0529ccd6b2ec211604e4515', 'qualquer@meialcm.com', '', 2, 'Diretor', '2018/2', '01/02/2016', 3, 0, '2016-02-14 17:48:25', NULL, NULL, NULL),
('2101091231', 'marcos', 'b452bb3317b617a3a51051c5e210d04fc079f302593573bde4bea30c23ba6820', 'marcos@hotmail.com', 'marcos@bing.com', 1, 'Trainee', '2019/1', NULL, 3, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('21312312', 'carlos', '83f720439fec373a817eac1f5ecb45737022dc1b6527f8091721a8209db97905', 'carlos@gmail.com', 'carlos@yahoo.com', 1, 'trainee', '2010/1', NULL, 3, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2131232131', 'Gustavo', '83f720439fec373a817eac1f5ecb45737022dc1b6527f8091721a8209db97905', 'gustavo@gmail.com', 'gustavo@yahoo.com', 1, 'trainee', '9281/1', NULL, 2, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2132103123', 'Ester', '46070d4bf934fb0d4b06d9e2c46e346944e322444900a435d7d9a95e6d7435f5', 'ester@gmail.com', '', 2, 'Membro', '', NULL, 2, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2172313213', 'Bruno', '441b02df090112b0b48b44e9eb6026d2ca1eec0d685c7d5712b59efbb9423a0c', 'bruno@gmail.com', 'bruno@gmail.com', 1, 'trainee', '21313', NULL, 2, 0, '2016-05-05 00:00:00', NULL, NULL, NULL),
('2222222222', 'ff', '92c7d71b95dc6540fc58e891dbe649fe72ae5e93b5f42fd7fbdeefe6cef3e51d', 'fff@gmail.com', '', 1, 'Trainee', '2015/1', '', 1, 0, '2016-08-04 18:57:36', '', NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `evento`
--
ALTER TABLE `evento`
  ADD CONSTRAINT `fk_evento_usuarios1` FOREIGN KEY (`matr`) REFERENCES `usuarios` (`matr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `id_diretoria` FOREIGN KEY (`diretoria`) REFERENCES `diretorias` (`id_diretoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
