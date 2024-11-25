<?php
session_start();
require '../conexion.php'; // Subir un nivel desde "php" al directorio principal

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION['user_id'];
$id_carrito = $_POST['id_carrito'];
$accion = $_POST['accion'];

// Obtener la cantidad actual del producto en el carrito
$query = $pdo->prepare("SELECT cantidad FROM carrito WHERE id_carrito = ? AND id_usuario = ?");
$query->execute([$id_carrito, $id_usuario]);
$resultado = $query->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $cantidad_actual = $resultado['cantidad'];

    // Determinar la nueva cantidad dependiendo de la acción
    if ($accion == 'incrementar') {
        $nueva_cantidad = $cantidad_actual + 1;
    } elseif ($accion == 'decrementar' && $cantidad_actual > 1) {
        $nueva_cantidad = $cantidad_actual - 1;
    }

    // Actualizar la cantidad en la base de datos
    if (isset($nueva_cantidad)) {
        $query_update = $pdo->prepare("UPDATE carrito SET cantidad = ? WHERE id_carrito = ?");
        $query_update->execute([$nueva_cantidad, $id_carrito]);
    }
}

header("Location: ../carrito.php");
exit;
