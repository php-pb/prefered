-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 28/04/2012 às 03h43min
-- Versão do Servidor: 5.1.62
-- Versão do PHP: 5.3.6-13ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `flisol`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comentario`
--

CREATE TABLE IF NOT EXISTS `sala` (
  `palestra_id` int(11) DEFAULT NULL,
  `descricao` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `palestra`
--

CREATE TABLE IF NOT EXISTS `palestra` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `palestrante` varchar(255) NOT NULL,
  `sala` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sala` (`sala`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `palestra`
--

INSERT INTO `palestra` (`id`, `nome`, `palestrante`, `sala`) VALUES
(1, 'Instanlando PHP', 'Vicente Martins', 'Rasmus Doidão'),
(2, 'PHPUnit: Vou salvar you boy!', 'Abdala', 'Rasmus Doidão'),
(3, 'Palestra legal', 'Cara Legal', 'Sala Legal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `voto`
--

CREATE TABLE IF NOT EXISTS `voto` (
  `palestra_id` int(11) NOT NULL DEFAULT '0',
  `gostou` int(11) DEFAULT NULL,
  `nao_gostou` int(11) DEFAULT NULL,
  PRIMARY KEY (`palestra_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `voto`
--

INSERT INTO `voto` (`palestra_id`, `gostou`, `nao_gostou`) VALUES
(1, 2, 2),
(3, 4, 3),
(2, 2, 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
