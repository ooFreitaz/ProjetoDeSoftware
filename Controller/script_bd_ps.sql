USE BD_PROJETOSOFTWARE;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cpf` CHAR(14) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `senha` VARCHAR(50) NOT NULL,
  `fotoPerfil` VARCHAR(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS `servico`;
CREATE TABLE IF NOT EXISTS `servico` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) NOT NULL,
  `valor` VARCHAR(50) NOT NULL,
  `categoria` VARCHAR(50) NOT NULL,
  `descricao` VARCHAR(255) NOT NULL,
  `prazoEntrega` VARCHAR(20) NOT NULL,
  `imagens` VARCHAR(50),
  `linksYoutube` VARCHAR(255),
  PRIMARY KEY (`id`),
  dono_servico int,
  foreign key (dono_servico) references usuario(id) on delete cascade
) ENGINE=InnoDB;