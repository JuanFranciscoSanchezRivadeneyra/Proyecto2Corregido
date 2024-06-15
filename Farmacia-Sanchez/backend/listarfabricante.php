<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");


include 'conexion.php'; 

try {
    
    $query = "SELECT * FROM Fabricantes";
    $statement = $conex->prepare($query);
    $statement->execute();

    
    $Fabricantes = $statement->fetchAll(PDO::FETCH_ASSOC);

    
    echo json_encode($Fabricantes);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error al obtener a los fabricantes: " . $e->getMessage()));
}
?>