<?php
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode(array('error' => 'ID no proporcionado'));
        exit;
    }
    
    $id = (int)$_GET['id'];
    
    if ($id <= 0) {
        echo json_encode(array('error' => 'ID inválido'));
        exit;
    }
    
    $stmt = $conn->prepare("SELECT id, codigo, descripcion, cantidad, precio, (cantidad * precio) as total, fecha_compra FROM articulos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $articulo = array(
            'id' => (int)$row['id'],
            'codigo' => $row['codigo'],
            'descripcion' => $row['descripcion'] ? $row['descripcion'] : '',
            'cantidad' => (int)$row['cantidad'],
            'precio' => (float)$row['precio'],
            'total' => (float)$row['total'],
            'fecha_compra' => $row['fecha_compra']
        );
        echo json_encode($articulo);
    } else {
        echo json_encode(array('error' => 'Artículo no encontrado'));
    }
    
    $stmt->close();
} else {
    echo json_encode(array('error' => 'Método no permitido'));
}

$conn->close();
?>