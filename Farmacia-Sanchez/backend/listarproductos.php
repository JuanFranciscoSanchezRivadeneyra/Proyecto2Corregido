<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


include 'conexion.php'; 

try {
    
    $query = "SELECT * FROM Productos";
    $statement = $conex->prepare($query);
    $statement->execute();

    
    $Productos = $statement->fetchAll(PDO::FETCH_ASSOC);

    
    echo json_encode($Productos);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error al obtener productos: " . $e->getMessage()));
}
?>