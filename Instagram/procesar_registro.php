<?php
// Configurar zona horaria
date_default_timezone_set('America/Mexico_City');

require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    
    // Verificar si el usuario o email ya existe
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? OR email = ?");
    $stmt->bind_param("ss", $usuario, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<script>alert('El usuario o email ya existe.'); window.location.href='index.html';</script>";
    } else {
        // Insertar nuevo usuario con fecha actual
        $fecha_actual = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, usuario, email, contraseña, fecha_registro) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $usuario, $email, $contraseña, $fecha_actual);
        
        if ($stmt->execute()) {
            echo "<script>alert('Usuario registrado exitosamente.'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Error al registrar usuario: " . $stmt->error . "'); window.location.href='index.html';</script>";
        }
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Acceso no válido'); window.location.href='index.html';</script>";
}
?>
