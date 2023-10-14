<?php

$host = 'localhost';
$dbname = 'ProyectoGraduacion';
$user = 'postgres';
$password = 'portero104';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

    $query = "SELECT id_empleado, primer_nombre_empleado, segundo_nombre_empleado, primer_apellido_empleado, segundo_apellido_empleado, edad, cargo FROM empleados_construccion ORDER BY id_empleado ASC";

    $stmt = $db->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($empleados);
    } else {
        echo json_encode(["error" => "No se encontraron empleados"]);
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