-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema superfatto
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `superfatto` ;

-- -----------------------------------------------------
-- Schema superfatto
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `superfatto` DEFAULT CHARACTER SET utf8 ;
USE `superfatto` ;

-- -----------------------------------------------------
-- Table `superfatto`.`departamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`departamento` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`fornecedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`fornecedor` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `cnpj` VARCHAR(45) NULL,
  `nome` VARCHAR(45) NULL,
  `cod_departamento` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_fornecedor_departamento_idx` (`cod_departamento` ASC),
  CONSTRAINT `fk_fornecedor_departamento`
    FOREIGN KEY (`cod_departamento`)
    REFERENCES `superfatto`.`departamento` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`conta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`conta` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `nome_usuario` VARCHAR(45) NULL,
  `senha` VARCHAR(255) NULL,
  `tipo` VARCHAR(45) NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE INDEX `nome_usuario_UNIQUE` (`nome_usuario` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`cliente` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `telefone` VARCHAR(45) NULL,
  PRIMARY KEY (`codigo`),
  CONSTRAINT `fk_cliente_conta1`
    FOREIGN KEY (`codigo`)
    REFERENCES `superfatto`.`conta` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`credencial`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`credencial` (
  `codigo` INT NOT NULL,
  `nome` VARCHAR(45) NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`administrador`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`administrador` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `cod_credencial` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_administrador_credencial1_idx` (`cod_credencial` ASC),
  CONSTRAINT `fk_administrador_conta1`
    FOREIGN KEY (`codigo`)
    REFERENCES `superfatto`.`conta` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_administrador_credencial1`
    FOREIGN KEY (`cod_credencial`)
    REFERENCES `superfatto`.`credencial` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`funcionario` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `cpf` VARCHAR(45) NULL,
  `nome` VARCHAR(45) NULL,
  `setor` VARCHAR(45) NULL,
  `salario` FLOAT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`produto` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `preco` FLOAT NULL,
  `estoque` INT NULL,
  `imagem` VARCHAR(255) NULL,
  `cod_departamento` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_produto_departamento1_idx` (`cod_departamento` ASC),
  CONSTRAINT `fk_produto_departamento1`
    FOREIGN KEY (`cod_departamento`)
    REFERENCES `superfatto`.`departamento` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`lote`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`lote` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `data` DATE NULL,
  `total` FLOAT NOT NULL DEFAULT 0.00,
  `cod_fornecedor` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_lote_fornecedor1_idx` (`cod_fornecedor` ASC),
  CONSTRAINT `fk_lote_fornecedor1`
    FOREIGN KEY (`cod_fornecedor`)
    REFERENCES `superfatto`.`fornecedor` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`produto_lote`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`produto_lote` (
  `cod_produto` INT NOT NULL,
  `cod_lote` INT NOT NULL,
  `quantidade` INT NULL,
  `subtotal` FLOAT NULL,
  INDEX `fk_produto_lote_produto1_idx` (`cod_produto` ASC),
  INDEX `fk_produto_lote_lote1_idx` (`cod_lote` ASC),
  PRIMARY KEY (`cod_produto`, `cod_lote`),
  CONSTRAINT `fk_produto_lote_produto1`
    FOREIGN KEY (`cod_produto`)
    REFERENCES `superfatto`.`produto` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_lote_lote1`
    FOREIGN KEY (`cod_lote`)
    REFERENCES `superfatto`.`lote` (`codigo`)
    ON DELETE RESTRICT
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`endereco`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`endereco` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `rua` VARCHAR(45) NULL,
  `numero` INT NULL,
  `bairro` VARCHAR(45) NULL,
  `cidade` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  `cep` VARCHAR(45) NULL,
  `cod_cliente` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_endereco_cliente1_idx` (`cod_cliente` ASC),
  CONSTRAINT `fk_endereco_cliente1`
    FOREIGN KEY (`cod_cliente`)
    REFERENCES `superfatto`.`cliente` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`venda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`venda` (
  `codigo` INT NOT NULL AUTO_INCREMENT,
  `data` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` FLOAT NOT NULL DEFAULT 0.00,
  `situacao` VARCHAR(255) NOT NULL DEFAULT 'Aguardando preenchimento de dados',
  `id_pagamento` VARCHAR(255) NULL,
  `cod_cliente` INT NOT NULL,
  `cod_endereco` INT NOT NULL,
  PRIMARY KEY (`codigo`),
  INDEX `fk_venda_cliente1_idx` (`cod_cliente` ASC),
  INDEX `fk_venda_endereco1_idx` (`cod_endereco` ASC),
  CONSTRAINT `fk_venda_cliente1`
    FOREIGN KEY (`cod_cliente`)
    REFERENCES `superfatto`.`cliente` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_venda_endereco1`
    FOREIGN KEY (`cod_endereco`)
    REFERENCES `superfatto`.`endereco` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`produto_venda`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`produto_venda` (
  `cod_produto` INT NOT NULL,
  `cod_venda` INT NOT NULL,
  `quantidade` INT NULL,
  `subtotal` FLOAT NULL,
  PRIMARY KEY (`cod_produto`, `cod_venda`),
  INDEX `fk_produto_venda_produto1_idx` (`cod_produto` ASC),
  INDEX `fk_produto_venda_venda1_idx` (`cod_venda` ASC),
  CONSTRAINT `fk_produto_venda_venda1`
    FOREIGN KEY (`cod_venda`)
    REFERENCES `superfatto`.`venda` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_produto_venda_produto1`
    FOREIGN KEY (`cod_produto`)
    REFERENCES `superfatto`.`produto` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`carrinho` (
  `codigo` INT NOT NULL,
  `total` FLOAT NOT NULL DEFAULT 0.0,
  PRIMARY KEY (`codigo`),
  CONSTRAINT `fk_carrinho_cliente1`
    FOREIGN KEY (`codigo`)
    REFERENCES `superfatto`.`cliente` (`codigo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superfatto`.`produto_carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superfatto`.`produto_carrinho` (
  `cod_produto` INT NOT NULL,
  `cod_carrinho` INT NOT NULL,
  `quantidade` INT NULL,
  `subtotal` FLOAT NULL,
  PRIMARY KEY (`cod_produto`, `cod_carrinho`),
  INDEX `fk_produto_carrinho_carrinho1_idx` (`cod_carrinho` ASC),
  INDEX `fk_produto_carrinho_produto1_idx` (`cod_produto` ASC),
  CONSTRAINT `fk_produto_carrinho_produto1`
    FOREIGN KEY (`cod_produto`)
    REFERENCES `superfatto`.`produto` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_produto_carrinho_carrinho1`
    FOREIGN KEY (`cod_carrinho`)
    REFERENCES `superfatto`.`carrinho` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `superfatto`;

DELIMITER $$
USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`conta_BEFORE_DELETE` BEFORE DELETE ON `conta` FOR EACH ROW
BEGIN
	delete from cliente where codigo = old.codigo;
    delete from administrador where codigo = old.codigo;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`cliente_AFTER_INSERT` AFTER INSERT ON `cliente` FOR EACH ROW
BEGIN
	insert into carrinho (codigo) values (new.codigo);
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_BEFORE_UPDATE` BEFORE UPDATE ON `produto` FOR EACH ROW
BEGIN
    update produto_carrinho set quantidade = new.estoque
    where cod_produto = new.codigo AND quantidade > new.estoque;
    
    if (new.estoque = 0) then
		delete from produto_carrinho where cod_produto = new.codigo;
    end if;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_lote_BEFORE_INSERT` BEFORE INSERT ON `produto_lote` FOR EACH ROW
BEGIN
    declare precoProduto float;
    select preco into precoProduto from produto where codigo = new.cod_produto;
    
    set new.subtotal = precoProduto * new.quantidade;
    
    update lote set total = total + new.subtotal where codigo = new.cod_lote;
    update produto set estoque = estoque + new.quantidade where codigo = new.cod_produto;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_lote_BEFORE_UPDATE` BEFORE UPDATE ON `produto_lote` FOR EACH ROW
BEGIN
	declare precoProduto float;
    declare produtoEstoque int;
    select preco into precoProduto from produto where codigo = new.cod_produto;
    select estoque into produtoEstoque from produto where codigo = old.cod_produto;
    
    set new.subtotal = precoProduto * new.quantidade;
    
    update lote set total = total - old.subtotal + new.subtotal where codigo = new.cod_lote;
    if (produtoEstoque >= old.quantidade and old.cod_produto != new.cod_produto) then
		update produto set estoque = estoque - old.quantidade where codigo = old.cod_produto;
        update produto set estoque = estoque + new.quantidade where codigo = new.cod_produto;
	elseif (old.cod_produto = new.cod_produto and produtoEstoque >= old.quantidade) then
		update produto set estoque = estoque - old.quantidade + new.quantidade
        where codigo = old.cod_produto;
    end if;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_lote_BEFORE_DELETE` BEFORE DELETE ON `produto_lote` FOR EACH ROW
BEGIN
	declare produtoEstoque int;
    select estoque into produtoEstoque from produto where codigo = old.cod_produto;
    
    update lote set total = total - old.subtotal where codigo = old.cod_lote;
    
    if (produtoEstoque >= old.quantidade) then
		update produto set estoque = estoque - old.quantidade where codigo = old.cod_produto;
	end if;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_venda_BEFORE_INSERT` BEFORE INSERT ON `produto_venda` FOR EACH ROW
BEGIN
	declare precoProduto float;
    declare estoqueProduto int;
    select preco into precoProduto from produto where codigo = new.cod_produto;
    
    set new.subtotal = precoProduto * new.quantidade;
    
    update venda set total = total + new.subtotal where codigo = new.cod_venda;
    update produto set estoque = estoque - new.quantidade where codigo = new.cod_produto;
    
    select estoque into estoqueProduto from produto where codigo = new.cod_produto;
    
    update produto_carrinho set quantidade = estoqueProduto
    where cod_produto = new.cod_produto AND quantidade > estoqueProduto;
    
    if (estoqueProduto = 0) then
		delete from produto_carrinho where cod_produto = new.cod_produto;
    end if;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_venda_BEFORE_DELETE` BEFORE DELETE ON `produto_venda` FOR EACH ROW
BEGIN
	update venda set total = total - old.subtotal where codigo = old.cod_venda;
    update produto set estoque = estoque + old.quantidade where codigo = old.cod_produto;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_carrinho_BEFORE_INSERT` BEFORE INSERT ON `produto_carrinho` FOR EACH ROW
BEGIN
    declare precoProduto float;
    select preco into precoProduto from produto where codigo = new.cod_produto;
    
    set new.subtotal = precoProduto * new.quantidade;
    
    update carrinho set total = total + new.subtotal where codigo = new.cod_carrinho;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_carrinho_BEFORE_UPDATE` BEFORE UPDATE ON `produto_carrinho` FOR EACH ROW
BEGIN
	declare precoProduto float;
    select preco into precoProduto from produto where codigo = new.cod_produto;
    
    set new.subtotal = precoProduto * new.quantidade;
    
    update carrinho set total = total - old.subtotal + new.subtotal where codigo = new.cod_carrinho;
END$$

USE `superfatto`$$
CREATE DEFINER = CURRENT_USER TRIGGER `superfatto`.`produto_carrinho_BEFORE_DELETE` BEFORE DELETE ON `produto_carrinho` FOR EACH ROW
BEGIN
    update carrinho set total = total - old.subtotal where codigo = old.cod_carrinho;
END$$


DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `superfatto`.`departamento`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (1, 'Mercearia');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (2, 'Higiene');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (3, 'Ferramentas');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (4, 'Bebidas');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (5, 'Eletrodomésticos');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (6, 'Bazar');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (7, 'Esporte');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (8, 'Eletrônicos');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (9, 'Limpeza');
INSERT INTO `superfatto`.`departamento` (`codigo`, `nome`) VALUES (10, 'Carnes');

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`fornecedor`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (1, '60373176000110', 'Distribuidora Alimentar Ltda.', 1);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (2, '63202653000173', 'MegaFornecedores S/A', 2);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (3, '84593941000176', 'SupraProdutos Distribuição', 3);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (4, '44160541000152', 'QualiAlimentos Distribuidora', 4);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (5, '92358470001732', 'Central de Abastecimento Rápido', 5);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (6, '16744252000165', 'Primeira Escolha Logística', 6);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (7, '20778348000111', 'Panorama Distribuidores', 7);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (8, '44726023000153', 'Distribuição Eficiente Ltda.', 8);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (9, '54001364000115', 'SuperSuprimentos S/A', 9);
INSERT INTO `superfatto`.`fornecedor` (`codigo`, `cnpj`, `nome`, `cod_departamento`) VALUES (10, '69270726000140', 'MasterFoods Distribuidora', 10);

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`conta`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`conta` (`codigo`, `nome`, `email`, `nome_usuario`, `senha`, `tipo`) VALUES (1, 'Pedro Casetta', 'administrador@email.com', 'adm123', '$2y$10$rnrNZqaUNroigAVy5uBVVOxvn.Il/KmZ/oxqUwmhyaE7VA049WGBG', 'administrador');
INSERT INTO `superfatto`.`conta` (`codigo`, `nome`, `email`, `nome_usuario`, `senha`, `tipo`) VALUES (2, 'Cliente Teste', 'cliente@email.com', 'cliente123', '$2y$10$rnrNZqaUNroigAVy5uBVVOxvn.Il/KmZ/oxqUwmhyaE7VA049WGBG', 'cliente');

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`cliente`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`cliente` (`codigo`, `telefone`) VALUES (2, '912382719');

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`credencial`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`credencial` (`codigo`, `nome`) VALUES (1, 'abc123');
INSERT INTO `superfatto`.`credencial` (`codigo`, `nome`) VALUES (2, 'fatec321');
INSERT INTO `superfatto`.`credencial` (`codigo`, `nome`) VALUES (3, 'cpssp246');
INSERT INTO `superfatto`.`credencial` (`codigo`, `nome`) VALUES (4, 'djo4492');
INSERT INTO `superfatto`.`credencial` (`codigo`, `nome`) VALUES (5, 'jfk9382');

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`administrador`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`administrador` (`codigo`, `cod_credencial`) VALUES (1, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`funcionario`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (1, '12328491030', 'Pedro', 'Informática', 2000.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (2, '45905160040', 'Marcos', 'Estoque', 2500.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (3, '49766703094', 'Lucélia', 'Limpeza', 2715.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (4, '51528583043', 'Abigail', 'Padaria', 2900.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (5, '05813215026', 'Bertoni', 'Açougue', 2300.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (6, '99695808093', 'Ana', 'Hortifruti', 2150.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (7, '41252204094', 'Tiago', 'Caixa', 1970.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (8, '43436509019', 'João', 'Administração', 3176.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (9, '97628581072', 'José', 'Atendimento', 1889.00);
INSERT INTO `superfatto`.`funcionario` (`codigo`, `cpf`, `nome`, `setor`, `salario`) VALUES (10, '82712811003', 'Maria', 'Entrega', 2115.00);

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`produto`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (1, 'Miojo', 9.90, 200, 'miojo.webp', 1);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (2, 'Escova de dentes', 14.99, 50, 'escova_de_dente.webp', 2);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (3, 'Amendoim granel kg', 11.90, 400, 'amendoim.webp', 1);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (4, 'Coca Cola 1 litro', 8.50, 150, 'coca_cola.webp', 4);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (5, 'Ventilador de chão', 68.90, 50, 'ventilador.webp', 5);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (6, 'Armário de metal', 129.99, 40, 'armario.webp', 6);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (7, 'Bola de futebol', 44.90, 90, 'bola.webp', 7);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (8, 'Bateria de carro', 89.90, 35, 'bateria.webp', 8);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (9, 'Esponja de louça', 19.99, 100, 'esponja.webp', 9);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (10, 'Queijo ralado', 4.59, 95, 'queijo_ralado.webp', 1);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (11, 'Desodorante', 15.99, 100, 'desodorante.webp', 2);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (12, 'Shampoo', 19.90, 230, 'shampoo.webp', 2);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (13, 'Parafusadeira', 159.90, 50, 'parafusadeira.webp', 3);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (14, 'Esmerilhadeira', 199.90, 60, 'esmerilhadeira.webp', 3);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (15, 'Kit de brocas e pontas', 149.99, 70, 'kit-de-acessorios.webp', 3);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (16, 'Acém kg', 59.99, 100, 'acem.webp', 10);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (17, 'Contra-filé kg', 49.99, 150, 'contra-file.webp', 10);
INSERT INTO `superfatto`.`produto` (`codigo`, `nome`, `preco`, `estoque`, `imagem`, `cod_departamento`) VALUES (18, 'Frango kg', 29.99, 200, 'frango.webp', 10);

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`lote`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`lote` (`codigo`, `data`, `total`, `cod_fornecedor`) VALUES (1, '2024-01-12', 0.0, 1);
INSERT INTO `superfatto`.`lote` (`codigo`, `data`, `total`, `cod_fornecedor`) VALUES (2, '2024-01-10', 0.0, 2);
INSERT INTO `superfatto`.`lote` (`codigo`, `data`, `total`, `cod_fornecedor`) VALUES (3, '2024-01-09', 0.0, 3);
INSERT INTO `superfatto`.`lote` (`codigo`, `data`, `total`, `cod_fornecedor`) VALUES (4, '2024-01-07', 0.0, 4);
INSERT INTO `superfatto`.`lote` (`codigo`, `data`, `total`, `cod_fornecedor`) VALUES (5, '2024-01-05', 0.0, 5);

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`produto_lote`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`produto_lote` (`cod_produto`, `cod_lote`, `quantidade`, `subtotal`) VALUES (1, 1, 1, 0.0);
INSERT INTO `superfatto`.`produto_lote` (`cod_produto`, `cod_lote`, `quantidade`, `subtotal`) VALUES (2, 1, 2, 0.0);
INSERT INTO `superfatto`.`produto_lote` (`cod_produto`, `cod_lote`, `quantidade`, `subtotal`) VALUES (3, 1, 3, 0.0);
INSERT INTO `superfatto`.`produto_lote` (`cod_produto`, `cod_lote`, `quantidade`, `subtotal`) VALUES (4, 1, 4, 0.0);
INSERT INTO `superfatto`.`produto_lote` (`cod_produto`, `cod_lote`, `quantidade`, `subtotal`) VALUES (5, 1, 5, 0.0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `superfatto`.`endereco`
-- -----------------------------------------------------
START TRANSACTION;
USE `superfatto`;
INSERT INTO `superfatto`.`endereco` (`codigo`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `cep`, `cod_cliente`) VALUES (1, 'General Tenório', 1945, 'Jardim Nova Ipiranga', 'Presidente Bernardes', 'SP', '67384293', 2);

COMMIT;

