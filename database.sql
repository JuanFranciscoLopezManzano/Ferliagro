CREATE DATABASE IF NOT EXISTS proyecto;

USE proyecto;

CREATE TABLE IF NOT EXISTS usuario(
	id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    apellido VARCHAR(150) NOT NULL,
    direccion VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    telefono CHAR(9) NOT NULL,
    administrador BOOLEAN NOT NULL,
    contrasena VARCHAR(150) NOT NULL);


CREATE TABLE IF NOT EXISTS categoria(
	id_categoria INT PRIMARY KEY AUTO_INCREMENT,
	nombre VARCHAR(150) NOT NULL
);


CREATE TABLE IF NOT EXISTS producto(
	id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(150) NOT NULL,
    precio FLOAT NOT NULL,
    descripcion VARCHAR(150) NOT NULL,
    imagen VARCHAR(150) NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categoria (id_categoria)
);


CREATE TABLE IF NOT EXISTS pedido(
	id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    precio_total FLOAT NOT NULL,
    cantidad_producto INT NOT NULL,
    id_producto INT NOT NULL,
    FOREIGN KEY (id_producto) REFERENCES producto (id_producto)
);


CREATE TABLE IF NOT EXISTS carrito(
	id_carrito INT PRIMARY KEY AUTO_INCREMENT,
    fecha DATETIME NOT NULL,
    id_usuario INT NOT NULL,
    id_producto INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario),
    FOREIGN KEY (id_producto) REFERENCES producto (id_producto)
);


CREATE TABLE IF NOT EXISTS pago (
	id_pago INT PRIMARY KEY AUTO_INCREMENT,
    cantidad FLOAT NOT NULL,
    tipo_pago ENUM('VISA','PAYPAL','BIZUM'),
    id_usuario INT NOT NULL,
    id_pedido INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario (id_usuario),
    FOREIGN KEY (id_pedido) REFERENCES pedido (id_pedido)
);



INSERT INTO `categoria`(`nombre`) VALUES ('fertilizante');
INSERT INTO `categoria`(`nombre`) VALUES ('herramienta');
INSERT INTO `categoria`(`nombre`) VALUES ('veneno');


INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Humus de Lombriz 10L',6.78,'El Sustrato Humus de Lombriz Eco es una enmienda orgánica sólida que resulta de la transformación por parte de las Lombrices Rojas de California del estiércol maduro y fermentado varias veces, en humus directamente e íntegramente asimilable.','img/fertilizante-humus.png', 1);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Humisol Green 25, 20L',47.27,'Enmienda húmica compuesta de ácidos húmicos y fúlvicos en forma de líquido soluble.
Su origen va de materia vegetal debidamente seleccionada y tratada hasta leonardita, pasando por diversas mezclas de materias orgánicas. ','img/fertilizante-humisol.png', 1);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Maorvalle 20L',26.36,'Abono orgánico líquido formulado a base de extractos vegetales naturales, rico en potasio y ácido fúlvicos.
Su empleo mejora las características fisioquímicas y biológicas del suelo a la vez que previene las carencias de los elementos que contiene.','img/fertilizante-maorvalle.png', 1);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('BlackJak 5L',66.00,'Es una innovadora leonardita líquida (SC) 100% natural con materia orgánica altamente descompuesta y de rápida asimilación (ácidos húmicos, fúlvicos, úlmicos, humina y nutrientes naturales) con la importante característica de ser un medio ácido.','img/fertilizante-blackjack.png', 1);


INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Pala de Aluminio Redonda',21.90,'Pala redonda de Aluminio con mango de muleta de 130 cms.','img/herramienta-pata.png', 2);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Azadilla Forjada 230',21.90,'Azadadilla fabricada en acero forjado modelo 230B.Ideal para trabajos preparatorios del terreno en agricultura y jardinería.Estupenda relación calidad/Precio.','img/herramienta-azada.png', 2);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Azada de Horquilla',14.40,'Azadada de horquilla fabricada en acero forjado modelo 02A. Ideal para trabajos preparatorios del terreno en agricultura y jardinería.','img/herramienta-azada2.png', 2);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Rastrillo Metálico 18 puntas',11.53,'Rastrillo de acero con 18 dientes para trabajos de jardín.Incluye mango de madera.','img/herramienta-rastrillo.png', 2);


INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Jabón negro',9.99,'El jabón negro Castalia, de fabricación propia, se elabora mediante saponificación de grasas vegetales y potasa soluble en agua.','img/veneno-jabonnegro.png', 3);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Cipergen 250ml',8.99,'Insecticida - Acaricida de amplio espectro con bajo nivel de toxicidad a base de Cipermetrina.','img/veneno-cipergen1.png', 3);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Cipergen 1l',15.99,'Insecticida - Acaricida de amplio espectro con bajo nivel de toxicidad a base de Cipermetrina.','img/veneno-cipergen2.png', 3);
INSERT INTO `producto`(`nombre`,`precio`,`descripcion`,`imagen`,`id_categoria`) VALUES ('Bathe',24.89,'Destinado para tratamientos insecticidas selectivos contra lepidópteros en una amplia variedad de cultivos.','img/veneno-bathe.png', 3);

ALTER TABLE pedido
ADD COLUMN id_usuario INT NOT NULL,
ADD FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario);

ALTER TABLE carrito ADD COLUMN cantidad INT DEFAULT 1;
