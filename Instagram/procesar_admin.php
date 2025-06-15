<?php
// Configurar zona horaria
date_default_timezone_set('America/Mexico_City');

session_start();
require 'db.php';

// Verificar si es administrador
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo "<script>alert('Acceso denegado.'); window.location.href='index.html';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    
    if ($action == 'add') {
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
            echo "<script>alert('El usuario o email ya existe.'); window.location.href='admin_panel.php';</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, usuario, email, contraseña) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nombre, $usuario, $email, $contraseña);
            
            if ($stmt->execute()) {
                echo "<script>alert('Usuario agregado exitosamente.'); window.location.href='admin_panel.php';</script>";
            } else {
                echo "<script>alert('Error al agregar usuario: " . $stmt->error . "'); window.location.href='admin_panel.php';</script>";
            }
        }
        $stmt->close();
        
    } elseif ($action == 'edit') {
        $user_id = $_POST['user_id'];
        $nombre = $_POST['nombre'];
        $usuario = $_POST['usuario'];
        $email = $_POST['email'];
        $contraseña = $_POST['contraseña'];
        
        $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, usuario = ?, email = ?, contraseña = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $nombre, $usuario, $email, $contraseña, $user_id);
        
        if ($stmt->execute()) {
            echo "<script>alert('Usuario actualizado exitosamente.'); window.location.href='admin_panel.php';</script>";
        } else {
            echo "<script>alert('Error al actualizar usuario: " . $stmt->error . "'); window.location.href='admin_panel.php';</script>";
        }
        $stmt->close();
    }
    
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $user_id = $_GET['id'];
    
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Usuario eliminado exitosamente.'); window.location.href='admin_panel.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar usuario: " . $stmt->error . "'); window.location.href='admin_panel.php';</script>";
    }
    $stmt->close();
}

$conn->close();
?>
