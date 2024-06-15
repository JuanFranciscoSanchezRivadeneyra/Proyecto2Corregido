<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Access-Control-Allow-Methods: DELETE, OPTIONS');
    exit();
}


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: DELETE');


$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    http_response_code(400);
    echo json_encode(array("message" => "ID de producto no proporcionado"));
    exit;
}


include 'conexion.php';

try {
    
    $query = "DELETE FROM Productos WHERE id = :id";
    $statement = $conex->prepare($query);

    
    $statement->execute(array(':id' => $id));

    
    $rowCount = $statement->rowCount();
    if ($rowCount > 0) {
        http_response_code(200);
        echo json_encode(array("message" => "Producto eliminado correctamente"));
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No se encontró el producto con el ID proporcionado"));
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error en la base de datos: " . $e->getMessage()));
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error en el servidor: " . $e->getMessage()));
}
?>