<?php
$host = 'localhost';
$dbname = 'proyecto';
$user = 'root';
$pass = '';

try {
    // Se crea una nueva instancia PDO para la conexión a ala base de datos
    $pdo = new PDO(dsn: "mysql:host=$host;dbname=$dbname", username: $user, password: $pass);
    // Se configura PDO para lanzar excepciones en caso de errores.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Captura cualquier excepcion de conexion y muestra un mensaje de error.
    die("No ha sido posible conectar a la Base de Datos: " . $e->getMessage());
}



?>

