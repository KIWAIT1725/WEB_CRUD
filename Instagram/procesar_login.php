<?php
require 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    
    // Verificar credenciales de administrador
    if ($usuario === "KIWAIT" && $contraseña === "1725") {
        $_SESSION['admin'] = true;
        $_SESSION['usuario'] = $usuario;
        echo "<script>alert('Bienvenido KIWAIT'); window.location.href='admin_panel.php';</script>";
        exit();
    }
    
    // Verificar usuario normal en la base de datos
    $stmt = $conn->prepare("SELECT id, nombre, usuario, contraseña FROM usuarios WHERE usuario = ? OR email = ?");
    $stmt->bind_param("ss", $usuario, $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verificar contraseña (en producción usar password_verify)
        if ($contraseña === $row['contraseña']) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['usuario'] = $row['usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            
            echo "<script>alert('Hola " . $row['nombre'] . " Bienvenido a Instagram.'); window.location.href='dashboard.php';</script>";
        } else {
            echo "<script>alert('Contraseña incorrecta.'); window.location.href='index.html';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.'); window.location.href='index.html';</script>";
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Acceso no valido'); window.location.href='index.html';</script>";
}
?>
