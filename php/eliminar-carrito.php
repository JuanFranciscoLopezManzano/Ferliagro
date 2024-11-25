<?php
session_start();
include '../conexion.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Verificar si se ha recibido un ID del carrito
if (isset($_POST['id_carrito'])) {
    $id_carrito = $_POST['id_carrito'];

    // Eliminar el producto del carrito
    $query = $pdo->prepare("DELETE FROM carrito WHERE id_carrito = ?");
    $query->execute([$id_carrito]);

    // Redirigir al carrito después de eliminar el producto
    header("Location: ../carrito.php");
    exit;
} else {
    // Si no se recibió un ID válido, redirigir al carrito
    header("Location: ../carrito.php");
    exit;
}
?>
