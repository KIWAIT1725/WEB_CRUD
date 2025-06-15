<?php
// Configurar zona horaria para toda la aplicación
date_default_timezone_set('America/Mexico_City');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "net";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer charset
$conn->set_charset("utf8");
?>
