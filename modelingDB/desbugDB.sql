CREATE DATABASE desbugDB;
USE desbugDB;

CREATE TABLE tb_usuario (
  id_usuario 		INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nm_nickname 		VARCHAR(50) 	  NOT NULL,
  nm_usuario 		VARCHAR(50) 	  NOT NULL,
  ds_email 			VARCHAR(100) 	  NOT NULL,
  ds_senha 			VARCHAR(100) 	  NOT NULL,
  dt_nascimento 	DATE 				  NOT NULL,
  img_usuario 		VARCHAR(255) 			NULL,
  PRIMARY KEY(id_usuario)
);

CREATE TABLE tb_categoria (
  id_categoria 	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  ds_categoria 	VARCHAR(255) 	  NOT NULL,
  img_categoria 	VARCHAR(255)     NOT NULL,
  PRIMARY KEY(id_categoria)
);

CREATE TABLE tb_escolhe_categoria (
  id_escolhe_categoria 	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_categoria 			INTEGER UNSIGNED NOT NULL,
  id_usuario 				INTEGER UNSIGNED NOT NULL,
  
  PRIMARY KEY(id_escolhe_categoria),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
  FOREIGN KEY (id_categoria) REFERENCES tb_categoria(id_categoria)
  
  ON DELETE CASCADE
  ON UPDATE CASCADE
);

CREATE TABLE tb_situacao (
  id_situacao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  tp_situacao CHAR(1) NULL,
  PRIMARY KEY(id_situacao)
);

CREATE TABLE tb_atividade (
  id_atividade 	INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_categoria		INTEGER UNSIGNED NOT NULL,
  id_situacao 		INTEGER UNSIGNED NOT NULL,
  img_atividade 	VARCHAR(255) 	  NOT NULL,
  ds_atividade 	VARCHAR(255) 	  NOT NULL,
  
  PRIMARY KEY(id_atividade),
  FOREIGN KEY (id_situacao) REFERENCES tb_situacao(id_situacao),
  FOREIGN KEY (id_categoria) REFERENCES tb_categoria(id_categoria)
);

CREATE TABLE tb_coleta_dado (
  id_coleta_dado 		INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario 			INTEGER UNSIGNED NOT NULL,
  id_atividade 		INTEGER UNSIGNED NOT NULL,
  vl_sentimento_ant 	CHAR(1) 	NOT NULL,
  vl_sentimento_prox CHAR(1) 	NOT NULL,
  
  PRIMARY KEY(id_coleta_dado),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
  FOREIGN KEY (id_atividade) REFERENCES tb_atividade(id_atividade)
);

CREATE TABLE tb_medalha (
  id_medalha 			INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  ds_medalha 			VARCHAR(100) 	  NOT NULL,
  img_medalha 			VARCHAR(255) 	  NOT NULL,
  vl_medalha_total 	FLOAT 			  NOT NULL,
  PRIMARY KEY(id_medalha)
);

CREATE TABLE tb_nivel_acesso (
  id_nivel_acesso INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario 		INTEGER UNSIGNED NOT NULL,
  tp_nivel_acesso CHAR(1) 					NULL,
  
  PRIMARY KEY(id_nivel_acesso),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);

CREATE TABLE tb_pontuacao (
  id_pontuacao INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario 	INTEGER UNSIGNED NOT NULL,
  id_medalha 	INTEGER UNSIGNED NOT NULL,
  vl_pontuacao FLOAT 			  NOT NULL,
  
  PRIMARY KEY(id_pontuacao),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario),
  FOREIGN KEY (id_medalha) REFERENCES tb_medalha(id_medalha)
);

CREATE TABLE tb_tempo_ativo (
  id_tempo 	 INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  id_usuario INTEGER UNSIGNED NOT NULL,
  dt_entrada TIMESTAMP 				 NULL,
  dt_saida 	 TIMESTAMP 				 NULL,
  
  PRIMARY KEY(id_tempo),
  FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);

/* VIEW DE AGRUPAMENTO DE PONTUAÇÕES */
CREATE OR REPLACE VIEW vw_pontuacao AS
SELECT p.id_pontuacao, SUM(p.vl_pontuacao) as vl_pontuacao,
		 u.*,
		 m.*		
FROM tb_pontuacao p
JOIN tb_usuario u
ON u.id_usuario = p.id_usuario

JOIN tb_medalha m
ON m.id_medalha = p.id_medalha

WHERE u.id_usuario = p.id_usuario
GROUP BY u.id_usuario, m.id_medalha;

/* VIEW DE AGRUPAMENTO NO TOTAL DO TEMPO */
CREATE OR REPLACE VIEW vw_tempo_total AS
SELECT id_tempo, id_usuario, dt_entrada, dt_saida,
		 IFNULL(
		 	TIMESTAMPDIFF(MINUTE, SUM(dt_entrada), SUM(dt_saida)), 
		 	0
		 ) AS dt_tempo_total
FROM tb_tempo_ativo
GROUP BY id_usuario, dt_entrada;

/* VIEW DE AGRUPAMENTO NO TOTAL DO TEMPO */
CREATE OR REPLACE VIEW vw_tempo_diario AS
SELECT DAYOFWEEK(CURTIME()) AS dia_atual, tt.*  FROM vw_tempo_total tt
WHERE DAYOFWEEK(dt_entrada) = DAYOFWEEK(CURTIME());

/* VIEW DE AGRUPAMENTO NA CONTAGEM DE SENTIMENTOS */
CREATE OR REPLACE VIEW vw_quantidade_sentimento AS
SELECT u.id_usuario, cd.vl_sentimento_prox,
		 COUNT(s.tp_situacao) AS qtd_sentimento
FROM tb_coleta_dado cd

JOIN tb_atividade a
ON a.id_atividade = cd.id_atividade

JOIN tb_situacao s
ON s.id_situacao = a.id_situacao

JOIN tb_usuario u
ON u.id_usuario = cd.id_usuario

GROUP BY u.id_usuario, cd.vl_sentimento_prox;