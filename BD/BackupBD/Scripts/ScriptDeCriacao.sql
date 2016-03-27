-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 05-Mar-2016 às 22:58
-- Versão do servidor: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scp`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `clienteId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `clienteNome` varchar(45) NOT NULL,
  `clienteNacionalidade` varchar(45) NOT NULL,
  `clienteDataNascimento` date NOT NULL,
  `clienteCPF` varchar(18) NOT NULL,
  `clienteRG` varchar(10) NOT NULL,
  `clienteOrgaoEmissor` varchar(5) NOT NULL,
  `clienteEstadoOrgaoEmissor` varchar(2) NOT NULL,
  `clienteSexo` enum('M','F') NOT NULL,
  `clienteEstadoCivil` varchar(45) NOT NULL,
  `clienteRegimeComunhao` varchar(45) DEFAULT NULL,
  `clienteFiliacao` varchar(45) DEFAULT NULL,
  `clienteFiliacao2` varchar(45) NOT NULL,
  `clienteTelefone` varchar(20) NOT NULL,
  `clienteTelefone2` varchar(20) DEFAULT NULL,
  `clienteEndereco` varchar(100) NOT NULL,
  `clienteCidade` varchar(15) NOT NULL,
  `clienteEstado` varchar(2) NOT NULL,
  `clienteCEP` varchar(15) NOT NULL,
  `clienteEmail` varchar(45) DEFAULT NULL,
  `clienteProfissao` varchar(20) NOT NULL,
  `clienteRenda` double NOT NULL,
  `clienteEmpresa` varchar(45) DEFAULT NULL,
  `clienteCargo` varchar(45) DEFAULT NULL,
  `clienteCppStatus` enum('C','SP','P','N') DEFAULT NULL,
  `clienteCppNome` varchar(45) DEFAULT NULL,
  `clienteCppNacionalidade` varchar(45) DEFAULT NULL,
  `clienteCppDataNascimento` date DEFAULT NULL,
  `clienteCppCPF` varchar(18) DEFAULT NULL,
  `clienteCppRG` varchar(10) DEFAULT NULL,
  `clienteCppOrgaoEmissor` varchar(45) DEFAULT NULL,
  `clienteCppEstadoOrgaoEmissor` varchar(45) DEFAULT NULL,
  `clienteCppSexo` enum('M','F') DEFAULT NULL,
  `clienteCppEstadoCivil` varchar(45) DEFAULT NULL,
  `clienteCppRegimeComunhao` varchar(45) DEFAULT NULL,
  `clienteCppFiliacao` varchar(45) DEFAULT NULL,
  `clienteCppFiliacao2` varchar(45) DEFAULT NULL,
  `clienteCppTelefone` varchar(20) DEFAULT NULL,
  `clienteCppTelefone2` varchar(20) DEFAULT NULL,
  `clienteCppEndereco` varchar(45) DEFAULT NULL,
  `clienteCppCidade` varchar(45) DEFAULT NULL,
  `clienteCppEstado` varchar(45) DEFAULT NULL,
  `clienteCppCEP` varchar(15) DEFAULT NULL,
  `clienteCppEmail` varchar(45) DEFAULT NULL,
  `clienteCppProfissao` varchar(45) DEFAULT NULL,
  `clienteCppRenda` double DEFAULT NULL,
  `clienteCppEmpresa` varchar(45) DEFAULT NULL,
  `clienteCppCargo` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`clienteId`),
  UNIQUE KEY `clienteCPF_UNIQUE` (`clienteCPF`),
  UNIQUE KEY `clienteTelefone_UNIQUE` (`clienteTelefone`),
  UNIQUE KEY `clienteEmail_UNIQUE` (`clienteEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicos_indices`
--

CREATE TABLE IF NOT EXISTS `historicos_indices` (
  `historicoIndiceId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pagamentoId` int(11) NOT NULL,
  `indiceId` int(10) unsigned NOT NULL,
  `indiceInccValor` double DEFAULT NULL,
  `indiceIgpmValor` double DEFAULT NULL,
  `indiceData` date NOT NULL,
  PRIMARY KEY (`historicoIndiceId`),
  KEY `fk_Historicos_Indices_Pagamentos1_idx` (`pagamentoId`),
  KEY `fk_Historicos_Indices_Indices1_idx` (`indiceId`)
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `historicos_pagamentos`
--

CREATE TABLE IF NOT EXISTS `historicos_pagamentos` (
  `historicoPagamentoId` int(11) NOT NULL AUTO_INCREMENT,
  `clienteId` int(10) unsigned NOT NULL,
  `produtoId` int(10) unsigned NOT NULL,
  `pagamentoStatusProduto` varchar(45) NOT NULL,
  `pagamentoValorTotal` varchar(45) NOT NULL,
  `pagamentoParcela` varchar(45) NOT NULL,
  `pagamentoValorParcela` varchar(45) NOT NULL,
  `pagamentoValorParcelaUnitario` varchar(45) NOT NULL,
  `pagamentoData` date NOT NULL,
  `pagamentoValor` double NOT NULL,
  `pagamentoId` int(11) NOT NULL,
  PRIMARY KEY (`historicoPagamentoId`),
  KEY `fk_Pagamentos_Clientes1_idx` (`clienteId`),
  KEY `fk_Historicos_Pagamentos_Produtos1_idx` (`produtoId`),
  KEY `fk_Historicos_Pagamentos_Pagamentos1_idx` (`pagamentoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `indices`
--

CREATE TABLE IF NOT EXISTS `indices` (
  `indiceId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `indiceInccValor` double NOT NULL,
  `indiceIgpmValor` double NOT NULL,
  `indiceData` date NOT NULL,
  `vendedorId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`indiceId`),
  UNIQUE KEY `impostoData_UNIQUE` (`indiceData`),
  KEY `fk_Indices_Clientes_copy11_idx` (`vendedorId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pagamentos`
--

CREATE TABLE IF NOT EXISTS `pagamentos` (
  `pagamentoId` int(11) NOT NULL AUTO_INCREMENT COMMENT '																																																																																																																																																																																																																																								',
  `clienteId` int(10) unsigned NOT NULL,
  `produtoId` int(10) unsigned NOT NULL,
  `pagamentoStatusProduto` varchar(45) NOT NULL,
  `pagamentoValorTotal` varchar(45) NOT NULL,
  `pagamentoParcela` varchar(45) NOT NULL,
  `pagamentoValorParcela` varchar(45) NOT NULL,
  `pagamentoValorParcelaUnitario` varchar(45) NOT NULL,
  `pagamentoData` date DEFAULT NULL,
  `pagamentoValor` double DEFAULT NULL,
  PRIMARY KEY (`pagamentoId`),
  KEY `fk_Venda_Produtos1_idx` (`produtoId`),
  KEY `fk_Pagamentos_Clientes1_idx` (`clienteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE IF NOT EXISTS `produtos` (
  `produtoId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `produtoApartamento` varchar(10) NOT NULL,
  `produtoBox` varchar(10) NOT NULL,
  `produtoValor` double NOT NULL,
  `produtoDataVenda` date NOT NULL,
  `produtoStatus` varchar(45) NOT NULL,
  `produtoParcelas` varchar(45) NOT NULL,
  `produtoParcelasPeriodicidade` varchar(45) NOT NULL,
  `produtoParcelasDataVencimento` varchar(45) NOT NULL,
  `produtoParcelasValorUnitario` varchar(45) NOT NULL,
  `produtoParcelasValorTotal` varchar(45) NOT NULL,
  `produtoParcelasAtualizacaoMonetaria` varchar(45) NOT NULL,
  `produtoParcelasFormaPagamento` varchar(45) NOT NULL,
  `produtoParcelasObservacoes` varchar(100) DEFAULT NULL,
  `vendedorId` int(10) unsigned NOT NULL,
  `clienteId` int(10) unsigned NOT NULL,
  PRIMARY KEY (`produtoId`),
  UNIQUE KEY `produtoApartamento_UNIQUE` (`produtoApartamento`),
  KEY `fk_Produtos_Clientes_copy11_idx` (`vendedorId`),
  KEY `fk_Produtos_Clientes1_idx` (`clienteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarioslogin`
--

CREATE TABLE IF NOT EXISTS `usuarioslogin` (
  `usuarioLoginId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuarioLoginNome` varchar(45) NOT NULL,
  `usuarioLoginEmail` varchar(45) NOT NULL,
  `usuarioLoginTipo` varchar(45) NOT NULL,
  `usuarioLoginLogin` varchar(45) NOT NULL,
  `usuarioLoginSenha` varchar(45) NOT NULL,
  PRIMARY KEY (`usuarioLoginId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vendedores`
--

CREATE TABLE IF NOT EXISTS `vendedores` (
  `vendedorId` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vendedorNome` varchar(45) NOT NULL,
  `vendedorNacionalidade` varchar(45) NOT NULL,
  `vendedorDataNascimento` date NOT NULL,
  `vendedorCPF` varchar(18) NOT NULL,
  `vendedorRG` varchar(10) NOT NULL,
  `vendedorOrgaoEmissor` varchar(45) NOT NULL,
  `vendedorEstadoOrgaoEmissor` varchar(45) NOT NULL,
  `vendedorSexo` enum('M','F') NOT NULL,
  `vendedorEstadoCivil` varchar(45) NOT NULL,
  `vendedorRegimeComunhao` varchar(45) DEFAULT NULL,
  `vendedorFiliacao` varchar(45) DEFAULT NULL,
  `vendedorFiliacao2` varchar(45) NOT NULL,
  `vendedorTelefone` varchar(20) NOT NULL,
  `vendedorTelefone2` varchar(20) DEFAULT NULL,
  `vendedorEndereco` varchar(45) NOT NULL,
  `vendedorCidade` varchar(45) NOT NULL,
  `vendedorEstado` varchar(45) NOT NULL,
  `vendedorCEP` varchar(15) NOT NULL,
  `vendedorEmail` varchar(45) DEFAULT NULL,
  `vendedorProfissao` varchar(45) NOT NULL,
  `vendedorRenda` double NOT NULL,
  `vendedorEmpresa` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`vendedorId`),
  UNIQUE KEY `clienteCPF_UNIQUE` (`vendedorCPF`),
  UNIQUE KEY `clienteTelefone_UNIQUE` (`vendedorTelefone`),
  UNIQUE KEY `clienteEmail_UNIQUE` (`vendedorEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `historicos_indices`
--
ALTER TABLE `historicos_indices`
  ADD CONSTRAINT `fk_Historicos_Indices_Pagamentos1` FOREIGN KEY (`pagamentoId`) REFERENCES `pagamentos` (`pagamentoId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Historicos_Indices_Indices1` FOREIGN KEY (`indiceId`) REFERENCES `indices` (`indiceId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `historicos_pagamentos`
--
ALTER TABLE `historicos_pagamentos`
  ADD CONSTRAINT `fk_Pagamentos_Clientes10` FOREIGN KEY (`clienteId`) REFERENCES `clientes` (`clienteId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Historicos_Pagamentos_Produtos1` FOREIGN KEY (`produtoId`) REFERENCES `produtos` (`produtoId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Historicos_Pagamentos_Pagamentos1` FOREIGN KEY (`pagamentoId`) REFERENCES `pagamentos` (`pagamentoId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `indices`
--
ALTER TABLE `indices`
  ADD CONSTRAINT `fk_Indices_Clientes_copy11` FOREIGN KEY (`vendedorId`) REFERENCES `vendedores` (`vendedorId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `fk_Venda_Produtos1` FOREIGN KEY (`produtoId`) REFERENCES `produtos` (`produtoId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Pagamentos_Clientes1` FOREIGN KEY (`clienteId`) REFERENCES `clientes` (`clienteId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `produtos`
--
ALTER TABLE `produtos`
  ADD CONSTRAINT `fk_Produtos_Clientes_copy11` FOREIGN KEY (`vendedorId`) REFERENCES `vendedores` (`vendedorId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Produtos_Clientes1` FOREIGN KEY (`clienteId`) REFERENCES `clientes` (`clienteId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
