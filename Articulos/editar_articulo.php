<?php
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = (int)$_POST['id'];
    $codigo = trim($_POST['codigo']);
    $descripcion = trim($_POST['descripcion']);
    $cantidad = (int)$_POST['cantidad'];
    $precio = (float)$_POST['precio'];
    $fecha_compra = $_POST['fecha_compra'];
    
    // Validaciones básicas
    if ($id <= 0) {
        echo json_encode(array('success' => false, 'error' => 'ID inválido'));
        exit;
    }
    
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
    
    // Verificar si el artículo existe
    $checkStmt = $conn->prepare("SELECT COUNT(*) as count FROM articulos WHERE id = ?");
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    $checkRow = $checkResult->fetch_assoc();
    
    if ($checkRow['count'] == 0) {
        echo json_encode(array('success' => false, 'error' => 'El artículo no existe'));
        exit;
    }
    
    // Verificar si el código ya existe en otro artículo
    $checkCodeStmt = $conn->prepare("SELECT COUNT(*) as count FROM articulos WHERE codigo = ? AND id != ?");
    $checkCodeStmt->bind_param("si", $codigo, $id);
    $checkCodeStmt->execute();
    $checkCodeResult = $checkCodeStmt->get_result();
    $checkCodeRow = $checkCodeResult->fetch_assoc();
    
    if ($checkCodeRow['count'] > 0) {
        echo json_encode(array('success' => false, 'error' => 'Ya existe otro artículo con ese código'));
        exit;
    }
    
    // Actualizar artículo
    $stmt = $conn->prepare("UPDATE articulos SET codigo = ?, descripcion = ?, cantidad = ?, precio = ?, fecha_compra = ? WHERE id = ?");
    $stmt->bind_param("ssidsi", $codigo, $descripcion, $cantidad, $precio, $fecha_compra, $id);
    
    if ($stmt->execute()) {
        echo json_encode(array('success' => true, 'message' => 'Artículo actualizado correctamente'));
    } else {
        echo json_encode(array('success' => false, 'error' => 'Error al actualizar artículo: ' . $stmt->error));
    }
    
    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'error' => 'Método no permitido'));
}

$conn->close();
?>