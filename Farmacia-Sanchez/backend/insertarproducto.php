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


$data = json_decode(file_get_contents("php://input"), true);


if (empty($data["nombre"]) || empty($data["codigobarras"]) || empty($data["cantidadstock"]) || empty($data["preciounitario"]) || empty($data["categoriamedicamento"]) || empty($data["fabricante"])) {
    
    http_response_code(400);
    echo json_encode(array("message" => "Faltan datos requeridos"));
    exit;
}


include 'conexion.php';


$Productos = [
    "nombre" => $data["nombre"],
    "codigobarras" => $data["codigobarras"],
    "cantidadstock" => $data["cantidadstock"],
    "preciounitario" => $data["preciounitario"],
    "categoriamedicamento" => $data["categoriamedicamento"],
    "fabricante" => $data["fabricante"]
];


try {
    
    $query = "INSERT INTO Productos (nombre, codigobarras, cantidadstock, preciounitario, categoriamedicamento, fabricante) VALUES (:nombre, :codigobarras, :cantidadstock, :preciounitario, :categoriamedicamento, :fabricante)";

    $statement = $conex->prepare($query);

    
    $result = $statement->execute($Productos);

    if ($result) {
        http_response_code(200);
        echo json_encode(array("message" => "Producto insertado correctamente"));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Error al insertar producto"));
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error en la base de datos: " . $e->getMessage()));
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Error en el servidor: " . $e->getMessage()));
}
?>