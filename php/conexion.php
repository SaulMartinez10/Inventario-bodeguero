<?php

$host = 'localhost';
$dbname = 'ProyectoGraduacion';
$user = 'postgres';
$password = 'portero104';

try {
    $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>

