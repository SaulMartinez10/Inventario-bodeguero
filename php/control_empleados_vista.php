<?php
$host = 'localhost';
$dbname = 'ProyectoGraduacion';
$user = 'postgres';
$password = 'portero104';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);

    $query = "SELECT idlistacontrol, idempleado, fechacontrol_empleados, descripcion FROM listacontrolempleados ORDER BY idlistacontrol ASC";

    $stmt = $db->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $lista_control_empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lista_control_empleados);
    } else {
        echo json_encode(["error" => "No se encontraron registros en listacontrolempleados"]);
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
