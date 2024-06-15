CREATE TABLE IF NOT EXISTS Productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(45),
    codigobarras VARCHAR(45),
    cantidadstock INTEGER,
    preciounitario DECIMAL(10,2),
    categoriamedicamento VARCHAR(45),
    fabricante VARCHAR(45)
);

INSERT INTO Productos(nombre, codigobarras, cantidadstock, preciounitario, categoriamedicamento, fabricante) VALUES('Ibuprofeno 400mg', '1234567890123', 210, 117.90, 'ANALGÉSICO', 'BAYERN');
INSERT INTO Productos(nombre, codigobarras, cantidadstock, preciounitario, categoriamedicamento, fabricante) VALUES('Paracetamol 500mg', '2345678901234', 110 , 190.90, 'ANALGÉSICO', 'SANOFI');
INSERT INTO Productos(nombre, codigobarras, cantidadstock, preciounitario, categoriamedicamento, fabricante) VALUES('Amoxicilina 500mg', '3456789012345', 670 , 188.90, 'ANTIBIÓTICO', 'PFIZER');
INSERT INTO Productos(nombre, codigobarras, cantidadstock, preciounitario, categoriamedicamento, fabricante) VALUES('Omeprazol 20mg', '4567890123456', 500, 199.90, 'ANTIÁCIDO', 'SANOFI');
INSERT INTO Productos(nombre, codigobarras, cantidadstock, preciounitario, categoriamedicamento, fabricante) VALUES('Atorvastatina 20mg', '5678901234567', 125, 179.90, 'HIPOLIPEMIANTE', 'PFIZER');
INSERT INTO Productos(nombre, codigobarras, cantidadstock, preciounitario, categoriamedicamento, fabricante) VALUES('Sertralina 50mg', '6789012345678', 60, 99.90, 'ANTIDEPRESIVO', 'BAYERN');

CREATE TABLE IF NOT EXISTS Fabricantes(
    id integer primary key autoincrement,
    nombre varchar(45),
    telefono varchar(45),
    direccion varchar(45)

    
);

INSERT INTO Fabricantes(nombre, telefono, direccion) VALUES('BAYERN','2345435345', 'Avenida de las Rosas, #10, Colonia Jardines del Valle');
INSERT INTO Fabricantes(nombre, telefono, direccion) VALUES('PFIZER','4567776454', 'Boulevard de las Flores, #25, Colonia Primavera');
INSERT INTO Fabricantes(nombre, telefono, direccion) VALUES('SANOFI','6263745673', 'Paseo de los Girasoles, #36, Colonia Florido');


CREATE TABLE IF NOT EXISTS Ventas (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(45),
    categoria VARCHAR(45),
    cantidad INTEGER,
    fabricante VARCHAR(45)
);

insert into Ventas(nombre, categoria, cantidad, fabricante) values('Ibuprofeno 400mg','ANALGÉSICO', 2, 'BAYERN');
insert into Ventas(nombre, categoria, cantidad, fabricante) values('Paracetamol 500mg','ANALGÉSICO', 3, 'SANOFI');
insert into Ventas(nombre, categoria, cantidad, fabricante) values('Amoxicilina 500mg','ANTIBIÓTICO', 5, 'PFIZER');
