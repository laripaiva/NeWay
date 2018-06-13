-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 12-Jun-2018 às 13:27
-- Versão do servidor: 5.7.21
-- PHP Version: 7.0.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bd_neway`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorys`
--

DROP TABLE IF EXISTS `categorys`;
CREATE TABLE IF NOT EXISTS `categorys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorys`
--

INSERT INTO `categorys` (`id`, `nome`) VALUES
(1, 'Programação'),
(2, 'Banco de dados'),
(9, 'Engenharia de software');

-- --------------------------------------------------------

--
-- Estrutura da tabela `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(70) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `categoria` int(11) DEFAULT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `carga_horaria` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cat` (`categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `courses`
--

INSERT INTO `courses` (`id`, `titulo`, `descricao`, `categoria`, `foto`, `carga_horaria`) VALUES
(1, 'PHP', 'Curso de PHP.k', 1, NULL, NULL),
(2, 'Django', 'Curso de Django', 1, NULL, '9'),
(3, 'f', 'd', 1, NULL, '03:02'),
(4, 'pora', 'f', 1, NULL, '09:00'),
(5, 'poraa', 'f', 1, NULL, '09:00'),
(6, 'lmd', 'kdf', 1, '..\\uploads\\imagens/set-transaction.png', '00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `historic`
--

DROP TABLE IF EXISTS `historic`;
CREATE TABLE IF NOT EXISTS `historic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_module` int(11) NOT NULL,
  `id_watch_courses` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_module` (`id_module`),
  KEY `fk_wc` (`id_watch_courses`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `historic`
--

INSERT INTO `historic` (`id`, `id_module`, `id_watch_courses`) VALUES
(33, 1, 11),
(34, 2, 11),
(35, 3, 12),
(36, 4, 12),
(37, 4, 10),
(38, 2, 1),
(43, 1, 1),
(44, 3, 10),
(45, 1, 13),
(46, 2, 13),
(47, 4, 14),
(48, 3, 14),
(49, 1, 15),
(50, 2, 15);

-- --------------------------------------------------------

--
-- Estrutura da tabela `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(70) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `id_courses` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_courses` (`id_courses`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `modules`
--

INSERT INTO `modules` (`id`, `titulo`, `descricao`, `id_courses`) VALUES
(1, 'Introdução', 'klknk', 1),
(2, 'Conclusão', 'Conclusão do Curso PHP', 1),
(3, 'Introdução', 'Introdução ao Django', 2),
(4, 'Conclusão', 'Conclusão ', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` varchar(20) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `payment`
--

INSERT INTO `payment` (`id`, `data`, `id_user`) VALUES
(1, '06/06/2018', 35),
(2, '07/06/2018', 38),
(3, '08/06/2018', 39);

-- --------------------------------------------------------

--
-- Estrutura da tabela `texts`
--

DROP TABLE IF EXISTS `texts`;
CREATE TABLE IF NOT EXISTS `texts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(70) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `id_modules` int(11) NOT NULL,
  `diretorio` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_modules` (`id_modules`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `texts`
--

INSERT INTO `texts` (`id`, `titulo`, `descricao`, `id_modules`, `diretorio`) VALUES
(1, 'Texto 1', 'Texto 1111', 1, '..\\admin\\uploads\\videos/Z7NQHHK.pdf'),
(18, 'Hello', 'Hello', 1, '..\\uploads\\videos/farmajusta---versao-final.pdf'),
(19, 'Texto 1', 'Esse é o texto 1', 3, '..\\uploads\\videos/farmajusta-(ciopia).pdf'),
(20, 'as', 'a', 1, NULL),
(21, 'tese', 'teste', 1, NULL),
(22, 'kef', 'nds', 1, NULL),
(23, 'b', 'b', 1, '..\\uploads\\videos/eubebada.mp4'),
(24, 'Hello', 'hello', 3, '..\\uploads\\videos/exercicio-9.pdf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `nome_final` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `data_habilitacao` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `level`, `nome`, `nome_final`, `email`, `senha`, `data_habilitacao`) VALUES
(1, 3, 'Galeto', 'Garcia', 'galeto@gmail.com', '202cb962ac59075b964b07152d234b70', NULL),
(2, 2, 'Pedro', 'luiz', 'pedro@gmail.com', '202cb962ac59075b964b07152d234b70', '31/05/2018'),
(3, 2, 'Godinez', 'Nascimento', 'israel@gmail.com', '202cb962ac59075b964b07152d234b70', '03/06/2018'),
(5, 2, 'Larissa', 'Paiva', 'larissa@gmail.com', '202cb962ac59075b964b07152d234b70', '01/06/2018'),
(35, 1, 'hey', 'hye', 'hey@gmail.com', '18bd9197cb1d833bc352f47535c00320', ''),
(38, 2, 'Giselle', 'Vianna', 'giselle@gmail.com', '202cb962ac59075b964b07152d234b70', '07/06/2018'),
(39, 2, 'ana', 'ana', 'ana@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', '08/06/2018');

-- --------------------------------------------------------

--
-- Estrutura da tabela `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(70) NOT NULL,
  `descricao` varchar(200) NOT NULL,
  `id_modules` int(11) NOT NULL,
  `diretorio` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_modules` (`id_modules`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `videos`
--

INSERT INTO `videos` (`id`, `titulo`, `descricao`, `id_modules`, `diretorio`) VALUES
(1, 'Hello it\'s me drunk', 'esse é o visdeo ', 1, '..\\uploads\\videos/Exercicio-numero-7-Adm-Estrategica.pdf'),
(52, 'Tentativa', 'Tentativa', 1, '..\\uploads\\videos/Festa de jornalismo.pdf'),
(53, 'Video3', 'video3', 1, '..\\uploads\\videos/AFAZERES.txt'),
(54, 'Another one ', 'Another video', 1, '..\\uploads\\videos/ANEXO_II.doc.pdf'),
(55, 'km', 'o', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `watch_courses`
--

DROP TABLE IF EXISTS `watch_courses`;
CREATE TABLE IF NOT EXISTS `watch_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_courses` int(11) NOT NULL,
  `certificado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_courses` (`id_courses`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `watch_courses`
--

INSERT INTO `watch_courses` (`id`, `id_user`, `id_courses`, `certificado`) VALUES
(1, 5, 1, NULL),
(10, 5, 2, NULL),
(11, 3, 1, NULL),
(12, 3, 2, NULL),
(13, 38, 1, NULL),
(14, 38, 2, NULL),
(15, 39, 1, NULL);

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_cat` FOREIGN KEY (`categoria`) REFERENCES `categorys` (`id`);

--
-- Limitadores para a tabela `historic`
--
ALTER TABLE `historic`
  ADD CONSTRAINT `fk_module` FOREIGN KEY (`id_module`) REFERENCES `modules` (`id`),
  ADD CONSTRAINT `fk_wc` FOREIGN KEY (`id_watch_courses`) REFERENCES `watch_courses` (`id`);

--
-- Limitadores para a tabela `modules`
--
ALTER TABLE `modules`
  ADD CONSTRAINT `modules_ibfk_1` FOREIGN KEY (`id_courses`) REFERENCES `courses` (`id`);

--
-- Limitadores para a tabela `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `texts`
--
ALTER TABLE `texts`
  ADD CONSTRAINT `texts_ibfk_1` FOREIGN KEY (`id_modules`) REFERENCES `modules` (`id`);

--
-- Limitadores para a tabela `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`id_modules`) REFERENCES `modules` (`id`);

--
-- Limitadores para a tabela `watch_courses`
--
ALTER TABLE `watch_courses`
  ADD CONSTRAINT `watch_courses_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `watch_courses_ibfk_2` FOREIGN KEY (`id_courses`) REFERENCES `courses` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
