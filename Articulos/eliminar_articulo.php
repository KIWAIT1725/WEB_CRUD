<?php
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    
    if (!isset($data['id']) || empty($data['id'])) {
        echo json_encode(array('success' => false, 'error' => 'ID no proporcionado'));
        exit;
    }
    
    $id = (int)$data['id'];
    
    if ($id <= 0) {
        echo json_encode(array('success' => false, 'error' => 'ID inválido'));
        exit;
    }
    
    // Verificar si el artículo existe y obtener sus datos
    $checkStmt = $conn->prepare("SELECT codigo, descripcion FROM articulos WHERE id = ?");
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows == 0) {
        echo json_encode(array('success' => false, 'error' => 'El artículo no existe'));
        exit;
    }
    
    $articulo = $checkResult->fetch_assoc();
    
    // Eliminar artículo
    $stmt = $conn->prepare("DELETE FROM articulos WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(array(
            'success' => true, 
            'message' => 'Artículo eliminado correctamente',
            'articulo_eliminado' => array(
                'codigo' => $articulo['codigo'],
                'descripcion' => $articulo['descripcion']
            )
        ));
    } else {
        echo json_encode(array('success' => false, 'error' => 'Error al eliminar artículo: ' . $stmt->error));
    }
    
    $stmt->close();
} else {
    echo json_encode(array('success' => false, 'error' => 'Método no permitido'));
}

$conn->close();
?>