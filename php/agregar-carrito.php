<?php
session_start();
require '../conexion.php'; // Subir un nivel desde "php" al directorio principal

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION['user_id'];
$id_producto = $_POST['id_producto'];

// Verificar que el producto existe en la base de datos
$query_producto = $pdo->prepare("SELECT * FROM producto WHERE id_producto = ?");
$query_producto->execute([$id_producto]);
$producto = $query_producto->fetch(PDO::FETCH_ASSOC);

if ($producto) {
    // El producto existe, proceder con la inserción en el carrito
    $fecha = date('Y-m-d H:i:s');
    $query = $pdo->prepare("INSERT INTO carrito (fecha, id_usuario, id_producto) VALUES (?, ?, ?)");
    $query->execute([$fecha, $id_usuario, $id_producto]);

    // Redirigir al carrito
    header("Location: ../carrito.php");
    exit;
} else {
    // El producto no existe
    echo "Producto no encontrado.";
    exit;
}
?>
