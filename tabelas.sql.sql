create database galeria_musicas;
drop database if exists galeria_musicas;
use galeria_musicas;



CREATE TABLE musicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_musica VARCHAR(255) NOT NULL UNIQUE,
    nome_cantor VARCHAR(255) NOT NULL,
    tempo_duracao TIME NOT NULL
);

select * from musicas;
insert into musicas(nome_musica, nome_cantor, tempo_duracao) values ('beat it', 'Michael Jackson', '00:04:59');
UPDATE musicas SET nome_musica = 'Chicago' WHERE id = 1;
delete from musicas where id = 'id';
drop table musicas;


CREATE TABLE catalogo_musica (
    id INT AUTO_INCREMENT PRIMARY KEY,
    faixa_etaria VARCHAR(50) NOT NULL,
    estilo_musica ENUM('Rock', 'Pop', 'Sertanejo', 'Funk', 'Eletrônica', 'MPB', 'Rap/Hip-Hop', 'Jazz/Blues') NOT NULL
);

select * from catalogo_musica;
insert into catalogo_musica(faixa_etaria, estilo_musica) values ('18', 'Rock');
UPDATE catalogo_musica SET faixa_etaria = '12' WHERE id = 1;
delete from catalogo_musica where id = 'id';
drop table catalogo_musica;



CREATE TABLE galeria (
    catalogo_id INT,
    musicas_id INT,
    PRIMARY KEY (catalogo_id, musicas_id),
    FOREIGN KEY (catalogo_id) REFERENCES catalogo_musica(id) ON DELETE CASCADE,
    FOREIGN KEY (musicas_id) REFERENCES musicas(id) ON DELETE CASCADE
);

SELECT * FROM galeria;
INSERT INTO galeria (catalogo_id, musicas_id) VALUES (1, 1);
SELECT 
    c.estilo_musica, 
    c.faixa_etaria, 
    m.nome_musica, 
    m.nome_cantor, 
    TIME_FORMAT(m.tempo_duracao, '%i:%s') AS tempo_duracao
FROM galeria g
JOIN catalogo_musica c ON g.catalogo_id = c.id
JOIN musicas m ON g.musicas_id = m.id;

UPDATE galeria SET musica_id = 2 WHERE catalogo_id = 1 AND musica_id = 1;
DELETE FROM galeria WHERE catalogo_id = 1 AND musica_id = 1;
DROP TABLE galeria;




