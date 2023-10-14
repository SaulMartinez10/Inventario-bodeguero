<?php
$host = "localhost";
$port = "5432";
$dbname = "ProyectoGraduacion";
$user = "postgres";
$password = "portero104";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try{
    // Crear una conexión a la base de datos PostgreSQL
    $dbconn = new PDO($dsn);

    if($dbconn){
        // Verificar si los datos fueron enviados por POST
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recuperar datos del formulario
            $descripcion = $_POST['descripcion'];
            $tipo_categoria = $_POST['tipo_categoria'];
            $producto = $_POST['producto'];
            $fecha_control = $_POST['datepicker'];
            $cantidad = $_POST['cantidad'];

            if(!is_numeric($cantidad) || !is_numeric($tipo_categoria)){
                // Si no es un número, redirigir con un mensaje de error.
                header("Location: ../Añadir-control.html?error=".urlencode("Error: Campos inválidos tipo o cantidad"));
                exit;
            }            
            
            // Crear una sentencia SQL INSERT para lista_control
            $sqlControl = "INSERT INTO lista_control(tipo, producto, descripcion, fechacontrol, cantidad) VALUES(:tipo, :producto, :descripcion, :fechacontrol, :cantidad)";
            $resultControl = $dbconn->prepare($sqlControl);
            $resultControl->execute(array(':tipo' => $tipo_categoria, ':producto' => $producto, ':descripcion' => $descripcion, ':fechacontrol' => $fecha_control, ':cantidad' => $cantidad));
            
            // Crear una sentencia SQL INSERT para productos, con lógica de actualización si el producto ya existe
            $sqlProducto = "INSERT INTO productos(codcategoria, nombre_producto, cantidad) VALUES(:codcategoria, :nombre_producto, :cantidad) 
                            ON CONFLICT(nombre_producto) 
                            DO UPDATE SET cantidad = productos.cantidad + EXCLUDED.cantidad";
            
            $resultProducto = $dbconn->prepare($sqlProducto);
            $resultProducto->execute(array(':codcategoria' => $tipo_categoria, ':nombre_producto' => $producto, ':cantidad' => $cantidad));

            // Redirigir a la página Anadir-control.html con un parámetro de éxito
            header("Location: ../Añadir-control.html?success=true");
            exit;
        }
    }

}catch (PDOException $e){
    echo $e->getMessage();
}
?>
