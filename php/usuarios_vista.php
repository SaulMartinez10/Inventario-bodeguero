<?php

$host = 'localhost';
$dbname = 'ProyectoGraduacion';
$user = 'postgres';
$password = 'portero104';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

    $query = "SELECT id_usuario, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, edad, nombre_usuario, cargo FROM usuarios ORDER BY id_usuario ASC";

    $stmt = $db->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($usuarios);
    } else {
        echo json_encode(["error" => "No se encontraron Usuarios"]);
    }
} catch (PDOException $e) {
    // Log error message
    error_log($e->getMessage());
    // Show a generic message to the user
    echo json_encode(["error" => "No se pudo realizar la operación. Inténtalo de nuevo más tarde."]);
}

// Esto cierra la conexión en PDO.
$db = null;  
?>