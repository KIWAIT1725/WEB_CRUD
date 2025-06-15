<?php
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = trim($_POST['codigo']);
    $descripcion = trim($_POST['descripcion']);
    $cantidad = (int)$_POST['cantidad'];
    $precio = (float)$_POST['precio'];
    $fecha_compra = $_POST['fecha_compra'];
    
    // Validaciones básicas
    if (empty($codigo)) {
        echo json_encode(array('success' => false, 'error' => 'El código es obligatorio'));
        exit;
    }
    
    if ($cantidad <= 0) {
        echo json_encode(array('success' => false, 'error' => 'La cantidad debe ser mayor a 0'));
        exit;
    }
    
    if ($precio < 0) {
        echo json_encode(array('success' => false, 'error' => 'El precio no puede ser negativo'));
        exit;
    }
    
    // Verificar si el código ya existe
    $checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM articulos WHERE codigo = ?");
    $checkStmt->bind_param("s", $codigo);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $checkRow = $checkResult->fetch_assoc();
    
    if ($checkRow['count'] > 0) {
        echo json_encode(array('success' => false, 'error' => 'Ya existe un artículo con ese código'));
        exit;
    }
    
    // Insertar nuevo artículo
    $stmt = $conn->prepare("INSERT INTO articulos (codigo, descripcion, cantidad, precio, fecha_compra) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssids", $codigo, $descripcion, $cantidad, $precio, $fecha_compra);
    
    if ($stmt->execute()) {
        echo json_encode(array(
            'success' => true, 
            'id' => $conn->insert_id,
            'message' => 'Artículo agregado correctamente'
        ));
    } else {
        echo json_encode(array('success' => false, 'error' => 'Error al agregar artículo: ' . $stmt->error));
    }
    
    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'error' => 'Método no permitido'));
}

$conn->close();
?>