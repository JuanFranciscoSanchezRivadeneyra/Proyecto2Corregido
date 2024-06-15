<?php


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *'); 
    header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    exit();
}


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    include 'conexion.php'; 

    
    $data = json_decode(file_get_contents('php://input'), true);

    
    if (empty($data['nombre']) || empty($data['categoria']) || empty($data['cantidad']) || empty($data['fabricante'])) {
        http_response_code(400); 
        echo json_encode(array('message' => 'Faltan datos requeridos para insertar la venta'));
        exit();
    }

    
    $Ventas = [
        'nombre' => $data['nombre'],
        'categoria' => $data['categoria'],
        'cantidad' => $data['cantidad'],
        'fabricante' => $data['fabricante']
    ];
    

    try {
        
        $query = 'INSERT INTO Ventas (nombre, categoria, cantidad, fabricante) VALUES (:nombre, :categoria, :cantidad, :fabricante)';

        $statement = $conex->prepare($query);

        
        $result = $statement->execute($Ventas);

        if ($result) {
            $id = $conex->lastInsertId(); 
            http_response_code(201); 
            echo json_encode(array('message' => 'Venta insertada correctamente', 'id' => $id));
        } else {
            http_response_code(400); 
            echo json_encode(array('message' => 'Error al intentar insertar la venta'));
        }
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('message' => 'Error en la base de datos: ' . $e->getMessage()));
    } catch (Exception $e) {
        http_response_code(500); 
        echo json_encode(array('message' => 'Error en el servidor: ' . $e->getMessage()));
    }
} else {
    
    http_response_code(405); 
    echo json_encode(array('message' => 'Método no permitido'));
}
?>