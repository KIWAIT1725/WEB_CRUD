-- Crear base de datos
CREATE DATABASE IF NOT EXISTS net;
USE net;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar usuario de ejemplo
INSERT INTO usuarios (nombre, usuario, email, contraseña, fecha_registro) VALUES 
('Usuario Demo', 'demo', 'demo@example.com', 'demo123', NOW());

-- Verificar que la tabla tenga la estructura correcta
DESCRIBE usuarios;
