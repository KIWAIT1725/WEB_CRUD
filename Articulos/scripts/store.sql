-- Script: tienda.sql

-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS tienda;
USE tienda;

-- Crear la tabla articulos
CREATE TABLE IF NOT EXISTS articulos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL,
    descripcion VARCHAR(255),
    cantidad INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    total DECIMAL(12, 2) AS (cantidad * precio) STORED,
    fecha_compra DATE NOT NULL
);

-- Insertar registros de prueba en la tabla articulos

INSERT INTO articulos (codigo, descripcion, cantidad, precio, fecha_compra)
VALUES 
('A001', 'Laptop Lenovo IdeaPad 3', 2, 450.00, '2025-06-10'),
('A002', 'Mouse inalámbrico Logitech M185', 5, 12.99, '2025-06-11'),
('A003', 'Teclado mecánico Redragon', 3, 38.50, '2025-06-12'),
('A004', 'Monitor LG 24" IPS', 1, 175.00, '2025-06-13'),
('A005', 'Memoria USB Kingston 64GB', 10, 6.75, '2025-06-14');

-- Consultar los registros insertados

SELECT * FROM articulos;
