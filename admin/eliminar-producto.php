<?php
session_start();
include '../conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['administrador'] != 1) {
    // Si no es administrador, redirigir al inicio o mostrar un mensaje de error
    echo '<script>
            alert("Solo los administradores pueden agregar productos.");
            window.location.href = "index.php";
          </script>';
    exit;
}
// Verificar si se ha enviado el ID del producto
if (isset($_POST['id_producto'])) {
    $id_producto = $_POST['id_producto'];

    // Eliminar el producto de la base de datos
    $query = $pdo->prepare("DELETE FROM producto WHERE id_producto = ?");
    $query->execute([$id_producto]);

    // Redirigir de vuelta a la página de listado de productos
    header("Location: panel-control.php");
    exit();
} else {
    // Si no se proporciona un ID de producto, redirigir al listado
    header("Location: panel-control.php");
    exit();
}
?>
