CREATE DATABASE BD_PROJETOSOFTWARE;

USE BD_PROJETOSOFTWARE;


CREATE TABLE usuario (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, -- futuramente mudar para idUsuario
  nome varchar(50) NOT NULL,
  cpf CHAR(14) NOT NULL,
  email VARCHAR(50) NOT NULL,
  senha VARCHAR(50) NOT NULL,
  fotoPerfil VARCHAR(255)
) ENGINE=InnoDB;


CREATE TABLE servico (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,  -- futuramente mudar para idServico
  titulo varchar(100) NOT NULL,
  valor VARCHAR(50) NOT NULL,
  categoria VARCHAR(50) NOT NULL,
  descricao VARCHAR(600) NOT NULL,
  prazoEntrega VARCHAR(20) NOT NULL,
  imagens VARCHAR(200),
  linksYoutube VARCHAR(255),
  idDono INT NOT NULL,
  foreign key (iDdono) references usuario(id) on delete cascade
) ENGINE=InnoDB;

CREATE TABLE compra(
	idCompra INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  idComprador INT NOT NULL,
  idVendedor INT NOT NULL,
  idServico INT NOT NULL,
  dataCompra DATETIME,
  valorFinal DECIMAL(10,2),
  foreign key (idComprador) references usuario(id) on delete cascade,
  foreign key (idVendedor) references usuario(id) on delete cascade,
  foreign key (idServico) references servico(id) on delete cascade
) ENGINE=InnoDB;

