<?php
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

try {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
    if (!empty($search)) {
        $sql = "SELECT id, codigo, descripcion, cantidad, precio, (cantidad * precio) as total, fecha_compra 
                FROM articulos 
                WHERE codigo LIKE ? OR descripcion LIKE ? 
                ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
        $searchParam = '%' . $search . '%';
        $stmt->bind_param("ss", $searchParam, $searchParam);
    } else {
        $sql = "SELECT id, codigo, descripcion, cantidad, precio, (cantidad * precio) as total, fecha_compra 
                FROM articulos 
                ORDER BY id DESC";
        $stmt = $conn->prepare($sql);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    
    $articulos = array();
    while ($row = $result->fetch_assoc()) {
        $articulos[] = array(
            'id' => (int)$row['id'],
            'codigo' => $row['codigo'],
            'descripcion' => $row['descripcion'] ? $row['descripcion'] : '',
            'cantidad' => (int)$row['cantidad'],
            'precio' => (float)$row['precio'],
            'total' => (float)$row['total'],
            'fecha_compra' => $row['fecha_compra']
        );
    }
    
    echo json_encode($articulos);
    
} catch (Exception $e) {
    echo json_encode(array('error' => 'Error al obtener artículos: ' . $e->getMessage()));
}

$conn->close();
?>