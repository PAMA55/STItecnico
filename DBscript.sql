CREATE DATABASE estela;

CREATE TABLE contactosweb(
	ID INT NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(75) NOT NULL,
    tel VARCHAR(10),
    email VARCHAR(75) NOT NULL,
    newsletter BOOLEAN NOT NULL,
    PRIMARY KEY(ID)
)

DELIMITER $$
CREATE PROCEDURE contactosweb_insert (IN spNombre VARCHAR(75), spTel VARCHAR(10), spEmail VARCHAR(75), spNewsletter BOOLEAN)
BEGIN
	INSERT INTO contactosweb(nombre, tel, email, newsletter) VALUES(spNombre, spTel, spEmail, spNewsletter);
END $$

/*  CALL contactosweb_insert ('nombre', '0123456789', 'prueba@hotmail.com', true)  */