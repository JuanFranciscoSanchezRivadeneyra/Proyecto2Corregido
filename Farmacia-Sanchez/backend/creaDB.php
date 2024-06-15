<?php
function abrirDB()
{
    $archivo="./FarmaciaDB.sqlite3";
    if(file_exists($archivo)){
        echo "la base de datos ya existe";
        return null;
    }else{
        $baseDeDatos = new PDO("sqlite:" . $archivo);
        $baseDeDatos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $baseDeDatos;
    }
}


function crearTablaProductos($baseDeDatos)
{
    $definicionTabla = "CREATE TABLE IF NOT EXISTS Productos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(45),
    codigobarras VARCHAR(45),
    cantidadstock INTEGER,
    preciounitario DECIMAL(10,2),
    categoriamedicamento VARCHAR(45),
    fabricante VARCHAR(45)
    );";

    $resultado = $baseDeDatos->exec($definicionTabla);
    return $resultado;
}

function crearTablaFabricantes($baseDeDatos)
{
    $definicionTabla = "CREATE TABLE IF NOT EXISTS Fabricantes(
    id integer primary key autoincrement,
    nombre varchar(45),
    telefono varchar(45),
    direccion varchar(45)
        
    );";

    $resultado = $baseDeDatos->exec($definicionTabla);
    return $resultado;
}

function crearTablaVentas($baseDeDatos)
{
    $definicionTabla = "CREATE TABLE IF NOT EXISTS Ventas(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(45),
    categoria VARCHAR(45),
    cantidad INTEGER,
    fabricante VARCHAR(45)
        
    );";

    $resultado = $baseDeDatos->exec($definicionTabla);
    return $resultado;
}

////////////////////////////////////////////////////////////////////
function insertaProductos($baseDeDatos, $Productos)
{
    $query = "INSERT INTO producto (nombre, codigobarras, cantidadstock, preciounitario, categoriamedicamento, fabricante) VALUES (:nombre, :codigobarras, :cantidadstock, :preciounitario, :categoriamedicamento, :fabricante);";
    $sentencia = $baseDeDatos->prepare($query);
    $resultado = $sentencia->execute($Productos);
    if ($resultado === true) {
        http_response_code(200);
        return true;
    } else {
        http_response_code(400);
        return false;
    }
}

function insertaFabricantes($baseDeDatos, $Fabricantes)
{
    $query="INSERT INTO Fabricante(nombre, telefono, direccion) VALUES(:nombre, :telefono, :direccion);";
    $sentencia = $baseDeDatos->prepare($query);
    $resultado = $sentencia->execute($Fabricantes);
    if ($resultado === true) {
        http_response_code(200);
        return true;
    } else {
        http_response_code(400);
        return false;
    }
}

function insertaVentas($baseDeDatos, $Ventas)
{
    $query="INSERT INTO ventas(nombre, categoria, cantidad, fabricante) VALUES(:nombre, :categoria, :cantidad, :fabricante);";
    $sentencia = $baseDeDatos->prepare($query);
    $resultado = $sentencia->execute($Ventas);
    if ($resultado === true) {
        http_response_code(200);
        return true;
    } else {
        http_response_code(400);
        return false;
    }
}

////////////////////////////////////////////////////////////////////
function insertaDatosProductos($baseDeDatos, $DatosProductos)
{

    $Productos = [
        "nombre" => "",
        "codigobarras" => "",
        "cantidadstock" => "",
        "preciounitario" => "",
        "categoriamedicamento" => "",
        "fabricante" => ""
    ];
    
    foreach ($DatosProductos as $valor) {
        $Productos["nombre"] = $valor["nombre"];
        $Productos["codigobarras"] = $valor["codigobarras"];
        $Productos["cantidadstock"] = $valor["cantidadstock"];
        $Productos["preciounitario"] = $valor["preciounitario"];
        $Productos["categoriamedicamento"] = $valor["categoriamedicamento"];
        $Productos["fabricante"] = $valor["fabricante"];
        insertaProductos($baseDeDatos, $Productos);
    }
    
}

function insertaDatosFabricantes($baseDeDatos, $DatosFabricantes)
{
    
    $Fabricantes = [
        "nombre" => "",
        "telefono" => "",
        "direccion" => "",
    ];
    foreach ($DatosFabricantes as $valor) {
        $Productos["nombre"] = $valor["nombre"];
        $Productos["telefono"] = $valor["telefono"];
        $Productos["direccion"] = $valor["direccion"];
        insertaFabricantes($baseDeDatos, $Fabricantes);
    }
}


function insertaDatosVentas($baseDeDatos, $DatosVentas)
{
    
    $Ventas = [
        "nombre" => "",
        "categoria" => "",
        "cantidad" => "",
        "fabricante" => ""
    ];
    
    foreach ($DatosVentas as $valor) {
        $Productos["nombre"] = $valor["nombre"];
        $Productos["categoria"] = $valor["categoria"];
        $Productos["cantidad"] = $valor["cantidad"];
        $Productos["fabricante"] = $valor["fabricante"];
        insertaVentas($baseDeDatos, $Ventas);
    }
}

$db = abrirDB();
if ($db) {
    try{
        crearTablaProductos($db);
        insertaDatosProductos($db, $DatosProductos);
        crearTablaFabricantes($db);
        insertaDatosFabricantes($db, $DatosFabricantes);
        crearTablaVentas($db);
        insertaDatosVentas($db, $DatosVentas);
        http_response_code(200);
        echo "ok";
    }catch(Exception $Exception){
        http_response_code(400);
        echo "Error: " . $Exception;
    }
} else {
    http_response_code(400);
    echo "la base de datos ya existe";
}

?>