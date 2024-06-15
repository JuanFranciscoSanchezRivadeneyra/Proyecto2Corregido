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

    
    if (empty($data['nombre']) || empty($data['telefono']) || empty($data['direccion'])) {
        http_response_code(400); 
        echo json_encode(array('message' => 'Faltan datos requeridos para insertar al fabricante'));
        exit();
    }

    
    $Fabricantes = [
        'nombre' => $data['nombre'],
        'telefono' => $data['telefono'],
        'direccion' => $data['direccion']
   
    ];

    try {
       
        $query = 'INSERT INTO Fabricantes (nombre, telefono, direccion) VALUES (:nombre, :telefono, :direccion)';
        $statement = $conex->prepare($query);

        
        $result = $statement->execute($Fabricantes);

        if ($result) {
            $id = $conex->lastInsertId(); 
            http_response_code(201); 
            echo json_encode(array('message' => 'Fabricante insertado correctamente', 'id' => $id));
        } else {
            http_response_code(400); 
            echo json_encode(array('message' => 'Error al intentar insertar al fabricante'));
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