-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema SCP
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `SCP` ;

-- -----------------------------------------------------
-- Schema SCP
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `SCP` DEFAULT CHARACTER SET utf8 ;
USE `SCP` ;

-- -----------------------------------------------------
-- Table `SCP`.`Clientes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Clientes` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Clientes` (
  `clienteId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `clienteNome` VARCHAR(45) NOT NULL,
  `clienteNacionalidade` VARCHAR(45) NOT NULL,
  `clienteDataNascimento` DATE NOT NULL,
  `clienteCPF` VARCHAR(18) NOT NULL,
  `clienteRG` VARCHAR(10) NOT NULL,
  `clienteOrgaoEmissor` VARCHAR(5) NOT NULL,
  `clienteEstadoOrgaoEmissor` VARCHAR(2) NOT NULL,
  `clienteSexo` ENUM('M', 'F') NOT NULL,
  `clienteEstadoCivil` VARCHAR(45) NOT NULL,
  `clienteRegimeComunhao` VARCHAR(45) NULL,
  `clienteFiliacao` VARCHAR(45) NULL,
  `clienteFiliacao2` VARCHAR(45) NOT NULL,
  `clienteTelefone` VARCHAR(20) NOT NULL,
  `clienteTelefone2` VARCHAR(20) NULL,
  `clienteEndereco` VARCHAR(100) NOT NULL,
  `clienteCidade` VARCHAR(15) NOT NULL,
  `clienteEstado` VARCHAR(2) NOT NULL,
  `clienteCEP` VARCHAR(15) NOT NULL,
  `clienteEmail` VARCHAR(45) NULL,
  `clienteProfissao` VARCHAR(20) NOT NULL,
  `clienteRenda` DOUBLE NOT NULL,
  `clienteEmpresa` VARCHAR(45) NULL,
  `clienteCargo` VARCHAR(45) NULL,
  `clienteCppStatus` ENUM('C', 'SP', 'P', 'N') NULL,
  `clienteCppNome` VARCHAR(45) NULL,
  `clienteCppNacionalidade` VARCHAR(45) NULL,
  `clienteCppDataNascimento` DATE NULL,
  `clienteCppCPF` VARCHAR(18) NULL,
  `clienteCppRG` VARCHAR(10) NULL,
  `clienteCppOrgaoEmissor` VARCHAR(45) NULL,
  `clienteCppEstadoOrgaoEmissor` VARCHAR(45) NULL,
  `clienteCppSexo` ENUM('M', 'F') NULL,
  `clienteCppEstadoCivil` VARCHAR(45) NULL,
  `clienteCppRegimeComunhao` VARCHAR(45) NULL,
  `clienteCppFiliacao` VARCHAR(45) NULL,
  `clienteCppFiliacao2` VARCHAR(45) NULL,
  `clienteCppTelefone` VARCHAR(20) NULL,
  `clienteCppTelefone2` VARCHAR(20) NULL,
  `clienteCppEndereco` VARCHAR(45) NULL,
  `clienteCppCidade` VARCHAR(45) NULL,
  `clienteCppEstado` VARCHAR(45) NULL,
  `clienteCppCEP` VARCHAR(15) NULL,
  `clienteCppEmail` VARCHAR(45) NULL,
  `clienteCppProfissao` VARCHAR(45) NULL,
  `clienteCppRenda` DOUBLE NULL,
  `clienteCppEmpresa` VARCHAR(45) NULL,
  `clienteCppCargo` VARCHAR(45) NULL,
  PRIMARY KEY (`clienteId`),
  UNIQUE INDEX `clienteCPF_UNIQUE` (`clienteCPF` ASC),
  UNIQUE INDEX `clienteEmail_UNIQUE` (`clienteEmail` ASC),
  UNIQUE INDEX `clienteTelefone_UNIQUE` (`clienteTelefone` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCP`.`Vendedores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Vendedores` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Vendedores` (
  `vendedorId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `vendedorNome` VARCHAR(45) NOT NULL,
  `vendedorNacionalidade` VARCHAR(45) NOT NULL,
  `vendedorDataNascimento` DATE NOT NULL,
  `vendedorCPF` VARCHAR(18) NOT NULL,
  `vendedorRG` VARCHAR(10) NOT NULL,
  `vendedorOrgaoEmissor` VARCHAR(45) NOT NULL,
  `vendedorEstadoOrgaoEmissor` VARCHAR(45) NOT NULL,
  `vendedorSexo` ENUM('M', 'F') NOT NULL,
  `vendedorEstadoCivil` VARCHAR(45) NOT NULL,
  `vendedorRegimeComunhao` VARCHAR(45) NULL,
  `vendedorFiliacao` VARCHAR(45) NULL,
  `vendedorFiliacao2` VARCHAR(45) NOT NULL,
  `vendedorTelefone` VARCHAR(20) NOT NULL,
  `vendedorTelefone2` VARCHAR(20) NULL,
  `vendedorEndereco` VARCHAR(45) NOT NULL,
  `vendedorCidade` VARCHAR(45) NOT NULL,
  `vendedorEstado` VARCHAR(45) NOT NULL,
  `vendedorCEP` VARCHAR(15) NOT NULL,
  `vendedorEmail` VARCHAR(45) NULL,
  `vendedorProfissao` VARCHAR(45) NOT NULL,
  `vendedorRenda` DOUBLE NOT NULL,
  `vendedorEmpresa` VARCHAR(45) NULL,
  PRIMARY KEY (`vendedorId`),
  UNIQUE INDEX `clienteCPF_UNIQUE` (`vendedorCPF` ASC),
  UNIQUE INDEX `clienteEmail_UNIQUE` (`vendedorEmail` ASC),
  UNIQUE INDEX `clienteTelefone_UNIQUE` (`vendedorTelefone` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCP`.`Produtos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Produtos` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Produtos` (
  `produtoId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `produtoApartamento` VARCHAR(10) NOT NULL,
  `produtoBox` VARCHAR(10) NOT NULL,
  `produtoValor` DOUBLE NOT NULL,
  `produtoDataVenda` DATE NOT NULL,
  `produtoStatus` VARCHAR(45) NOT NULL,
  `produtoParcelas` VARCHAR(45) NOT NULL,
  `produtoParcelasPeriodicidade` VARCHAR(45) NOT NULL,
  `produtoParcelasDataVencimento` VARCHAR(45) NOT NULL,
  `produtoParcelasValorUnitario` VARCHAR(45) NOT NULL,
  `produtoParcelasValorTotal` VARCHAR(45) NOT NULL,
  `produtoParcelasAtualizacaoMonetaria` VARCHAR(45) NOT NULL,
  `produtoParcelasFormaPagamento` VARCHAR(45) NOT NULL,
  `produtoParcelasObservacoes` VARCHAR(100) NULL,
  `clienteId` INT UNSIGNED NOT NULL,
  `vendedorId` INT UNSIGNED NOT NULL,
  `vendedorDataVencimento` DATE NOT NULL,
  `vendedorComissao` DOUBLE NOT NULL,
  `vendedorFormaPagamento` VARCHAR(45) NOT NULL,
  `vendedorObservacao` VARCHAR(100) NULL,
  PRIMARY KEY (`produtoId`),
  INDEX `fk_Produtos_Clientes_copy11_idx` (`vendedorId` ASC),
  UNIQUE INDEX `produtoApartamento_UNIQUE` (`produtoApartamento` ASC),
  INDEX `fk_Produtos_Clientes1_idx` (`clienteId` ASC),
  CONSTRAINT `fk_Produtos_Clientes_copy11`
    FOREIGN KEY (`vendedorId`)
    REFERENCES `SCP`.`Vendedores` (`vendedorId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Produtos_Clientes1`
    FOREIGN KEY (`clienteId`)
    REFERENCES `SCP`.`Clientes` (`clienteId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCP`.`Indices`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Indices` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Indices` (
  `indiceId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `indiceInccValor` DOUBLE NOT NULL,
  `indiceIgpmValor` DOUBLE NOT NULL,
  `indiceData` DATE NOT NULL,
  `usuarioId` INT NOT NULL,
  PRIMARY KEY (`indiceId`),
  UNIQUE INDEX `impostoData_UNIQUE` (`indiceData` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCP`.`Pagamentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Pagamentos` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Pagamentos` (
  `pagamentoId` INT NOT NULL AUTO_INCREMENT COMMENT '																																																																																																																																																																																																																																								',
  `clienteId` INT UNSIGNED NOT NULL,
  `produtoId` INT UNSIGNED NOT NULL,
  `pagamentoStatusProduto` VARCHAR(45) NOT NULL,
  `pagamentoValorTotal` VARCHAR(45) NOT NULL,
  `pagamentoParcela` VARCHAR(45) NOT NULL,
  `pagamentoValorParcela` VARCHAR(45) NOT NULL,
  `pagamentoValorParcelaUnitario` VARCHAR(45) NOT NULL,
  `pagamentoData` DATE NULL,
  `pagamentoValor` DOUBLE NULL,
  PRIMARY KEY (`pagamentoId`),
  INDEX `fk_Venda_Produtos1_idx` (`produtoId` ASC),
  INDEX `fk_Pagamentos_Clientes1_idx` (`clienteId` ASC),
  CONSTRAINT `fk_Venda_Produtos1`
    FOREIGN KEY (`produtoId`)
    REFERENCES `SCP`.`Produtos` (`produtoId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Pagamentos_Clientes1`
    FOREIGN KEY (`clienteId`)
    REFERENCES `SCP`.`Clientes` (`clienteId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCP`.`Historicos_Pagamentos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Historicos_Pagamentos` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Historicos_Pagamentos` (
  `historicoPgId` INT NOT NULL AUTO_INCREMENT,
  `historicoPgClienteId` INT UNSIGNED NOT NULL,
  `historicoPgProdutoId` INT UNSIGNED NOT NULL,
  `historicoPgPagamentoStatusProduto` VARCHAR(45) NOT NULL,
  `historicoPgPagamentoValorTotal` VARCHAR(45) NOT NULL,
  `historicoPgPagamentoParcela` VARCHAR(45) NOT NULL,
  `historicoPgPagamentoValorParcela` VARCHAR(45) NOT NULL,
  `historicoPgPagamentoValorParcelaUnitario` VARCHAR(45) NOT NULL,
  `historicoPgPagamentoData` DATE NOT NULL,
  `historicoPgPagamentoValor` DOUBLE NOT NULL,
  `historicoPgPagamentoId` INT NOT NULL,
  PRIMARY KEY (`historicoPgId`),
  INDEX `fk_Pagamentos_Clientes1_idx` (`historicoPgClienteId` ASC),
  INDEX `fk_Historicos_Pagamentos_Produtos1_idx` (`historicoPgProdutoId` ASC),
  INDEX `fk_Historicos_Pagamentos_Pagamentos1_idx` (`historicoPgPagamentoId` ASC),
  CONSTRAINT `fk_Pagamentos_Clientes10`
    FOREIGN KEY (`historicoPgClienteId`)
    REFERENCES `SCP`.`Clientes` (`clienteId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Historicos_Pagamentos_Produtos1`
    FOREIGN KEY (`historicoPgProdutoId`)
    REFERENCES `SCP`.`Produtos` (`produtoId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Historicos_Pagamentos_Pagamentos1`
    FOREIGN KEY (`historicoPgPagamentoId`)
    REFERENCES `SCP`.`Pagamentos` (`pagamentoId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCP`.`Historicos_Indices`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Historicos_Indices` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Historicos_Indices` (
  `historicoInId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `historicoInPagamentoId` INT NOT NULL,
  `historicoInIndiceId` INT UNSIGNED NOT NULL,
  `historicoInIndiceInccValor` DOUBLE NULL,
  `historicoInIndiceIgpmValor` DOUBLE NULL,
  `historicoInIndiceData` DATE NOT NULL,
  PRIMARY KEY (`historicoInId`),
  INDEX `fk_Historicos_Indices_Pagamentos1_idx` (`historicoInPagamentoId` ASC),
  INDEX `fk_Historicos_Indices_Indices1_idx` (`historicoInIndiceId` ASC),
  CONSTRAINT `fk_Historicos_Indices_Pagamentos1`
    FOREIGN KEY (`historicoInPagamentoId`)
    REFERENCES `SCP`.`Pagamentos` (`pagamentoId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Historicos_Indices_Indices1`
    FOREIGN KEY (`historicoInIndiceId`)
    REFERENCES `SCP`.`Indices` (`indiceId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCP`.`Usuarios_Login`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Usuarios_Login` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Usuarios_Login` (
  `usuarioLoginId` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `usuarioLoginNome` VARCHAR(45) NOT NULL,
  `usuarioLoginEmail` VARCHAR(45) NOT NULL,
  `usuarioLoginTipo` VARCHAR(45) NOT NULL,
  `usuarioLoginLogin` VARCHAR(45) NOT NULL,
  `usuarioLoginSenha` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`usuarioLoginId`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `SCP`.`Boletos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SCP`.`Boletos` ;

CREATE TABLE IF NOT EXISTS `SCP`.`Boletos` (
  `boletoId` INT NOT NULL AUTO_INCREMENT,
  `boletoNumeroDocumento` VARCHAR(6) NOT NULL,
  `boletoNossoNumero` VARCHAR(15) NOT NULL,
  `boletoSacado` INT NOT NULL,
  `boletoRemetido` INT NOT NULL,
  `boletoDataVencimento` DATE NOT NULL,
  `boletoDataEmissao` DATE NOT NULL,
  `boletoValor` DOUBLE NOT NULL,
  `boletoProdutoId` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`boletoId`),
  INDEX `fk_Boletos_Produtos1_idx` (`boletoProdutoId` ASC),
  UNIQUE INDEX `boletoNumeroDocumento_UNIQUE` (`boletoNumeroDocumento` ASC),
  UNIQUE INDEX `boletoId_UNIQUE` (`boletoId` ASC),
  UNIQUE INDEX `boletoNossoNumero_UNIQUE` (`boletoNossoNumero` ASC),
  CONSTRAINT `fk_Boletos_Produtos1`
    FOREIGN KEY (`boletoProdutoId`)
    REFERENCES `SCP`.`Produtos` (`produtoId`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
