CREATE DATABASE desbugdb;
USE desbugdb;

CREATE TABLE tb_medalha (
  id_medalha 			  INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  ds_medalha 			  VARCHAR(100) 	   NOT NULL,
  img_medalha			  VARCHAR(255)	   NOT NULL,
  vl_medalha_total 	FLOAT 		 	     NOT NULL,

  PRIMARY KEY (id_medalha)
);

CREATE TABLE tb_usuario (
  id_usuario 		  INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nm_nickname 		VARCHAR(30) 	   NOT NULL,
  nm_usuario 		  VARCHAR(100) 	   NOT NULL,
  ds_email 			  VARCHAR(100) 	   NOT NULL,
  ds_senha 			  VARCHAR(15) 	   NOT NULL,
  dt_nascimento 	DATE 				     NOT NULL,
  img_usuario 		VARCHAR(255)			   NULL,
  PRIMARY KEY (id_usuario)
);

CREATE TABLE tb_tempo_ativo (
  id_tempo 			INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario 		INTEGER UNSIGNED NOT NULL,
  dt_entrada 		DATETIME			  		 NULL,
  dt_saida 			DATETIME					   NULL,
  PRIMARY KEY (id_tempo),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario)
);

CREATE TABLE tb_nivel_acesso (
  id_nivel_acesso INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario 		  INTEGER UNSIGNED NOT NULL,
  tp_nivel_acesso CHAR(1) 			   NOT NULL,
  
  PRIMARY KEY (id_nivel_acesso),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario)
);

CREATE TABLE tb_pontuacao (
  id_pontuacao 	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_medalha 		INTEGER UNSIGNED NOT NULL,
  id_usuario 		INTEGER UNSIGNED NOT NULL,
  vl_pontuacao 	FLOAT 			     NOT NULL,
  
  PRIMARY KEY (id_pontuacao),
  FOREIGN KEY (id_medalha) REFERENCES tb_medalha (id_medalha),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario)
);

CREATE TABLE tb_categoria (
  id_categoria 	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario 		INTEGER UNSIGNED NOT NULL,
  ds_categoria 	VARCHAR(100) 	   NOT NULL,
  img_categoria VARCHAR(255) 	   NOT NULL,
  
  PRIMARY KEY (id_categoria),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario (id_usuario)
);

CREATE TABLE tb_situacao (
  id_situacao 	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tp_situacao 	CHAR(1) 				     NULL,
  
  PRIMARY KEY (id_situacao)
);

CREATE TABLE tb_atividade (
  id_atividade 	  INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario 		  INTEGER UNSIGNED NOT NULL,
  id_categoria 	  INTEGER UNSIGNED NOT NULL,
  id_situacao 		INTEGER UNSIGNED NOT NULL,
  img_atividade 	VARCHAR(250) 	   NOT NULL,
  ds_atividade 	VARCHAR(250) 	     NOT NULL,
  
  PRIMARY KEY (id_atividade),
  FOREIGN KEY (id_usuario) 	 REFERENCES tb_usuario   (id_usuario),
  FOREIGN KEY (id_situacao)  REFERENCES tb_situacao  (id_situacao),
  FOREIGN KEY (id_categoria) REFERENCES tb_categoria (id_categoria)
);

CREATE TABLE tb_coleta_dado (
  id_coleta_dado 		  INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_atividade 		    INTEGER UNSIGNED NOT NULL,
  vl_sentimento_ant 	CHAR(1)					     NULL,
  vl_sentimento_prox  CHAR(1)					     NULL,
  
  PRIMARY KEY (id_coleta_dado),
  FOREIGN KEY (id_atividade) REFERENCES tb_atividade (id_atividade)
);
