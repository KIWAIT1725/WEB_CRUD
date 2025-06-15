<?php
$servername = "localhost";
$username = "root";        // Cambia por tu usuario
$password = "";            // Cambia por tu contraseña
$dbname = "tienda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Configurar charset
$conn->set_charset("utf8");
?>