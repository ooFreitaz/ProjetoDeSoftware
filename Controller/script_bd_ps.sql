CREATE DATABASE BD_PROJETOSOFTWARE;

USE BD_PROJETOSOFTWARE;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `cpf` CHAR(11) NOT NULL,
  `email` VARCHAR(50) NOT NULL,
  `senha` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
);



