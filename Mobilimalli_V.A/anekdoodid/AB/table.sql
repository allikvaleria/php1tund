CREATE TABLE anekdoot(
                       id int PRIMARY key AUTO_INCREMENT,
                       nimetus varchar(20),
                       kuupaev date,
                       kirjeldus text);

INSERT INTO anekdoot(nimetus, kuupaev, varv)
VALUES ('Anekdood N1', 2024-11-29, 'Анекдот - Мiсrоsоft');

SELECT * FROM anekdoot;