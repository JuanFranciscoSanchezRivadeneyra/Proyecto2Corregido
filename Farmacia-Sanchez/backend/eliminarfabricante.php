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


if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if ($id === null) {
        
        http_response_code(400); 
        echo json_encode(array('message' => 'No se proporcionó el ID del Fabricante.'));
        exit();
    }

    
    $dbFile = 'FarmaciaDB.sqlite3'; 
    $dsn = 'sqlite:' . $dbFile; 
    
    
    try {
        $pdo = new PDO($dsn);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        http_response_code(500); 
        echo json_encode(array('message' => 'Error al conectar con la base de datos: ' . $e->getMessage()));
        exit();
    }

    
    $sql = "DELETE FROM Fabricantes WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

       
        if ($stmt->rowCount() > 0) {
           
            http_response_code(200); 
            echo json_encode(array('message' => 'Fabricante eliminado correctamente'));
        } else {
            
            http_response_code(404); 
            echo json_encode(array('message' => 'No se encontró al fabricante con el ID proporcionado'));
        }
    } catch (PDOException $e) {
        
        http_response_code(500); 
        echo json_encode(array('message' => 'Error al eliminar al fabricante: ' . $e->getMessage()));
    }
} else {
   
    http_response_code(405); 
    echo json_encode(array('message' => 'Método no permitido. Solo se permite DELETE.'));
}
?>