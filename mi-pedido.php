<?php
include 'navbar.php';
include 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_nombre'])) {
    echo '<script>
            alert("Debes iniciar sesión para acceder a esta página.");
            window.location.href = "index.php";
          </script>';
    exit;
}
//Optiene el ID del usuario logueado
$id_usuario = $_SESSION['user_id'];
try {
    // Prepara la consulta con un marcador de posición
    $query = $pdo->prepare("
        SELECT 
            p.id_pedido,
            p.precio_total,
            dp.id_producto,
            pr.nombre AS nombre_producto,
            dp.cantidad,
            dp.precio_unitario,
            u.nombre AS nombre_usuario,
            u.apellido
        FROM pedido p
        JOIN detalle_pedido dp ON p.id_pedido = dp.id_pedido
        JOIN producto pr ON dp.id_producto = pr.id_producto
        JOIN usuario u ON p.id_usuario = u.id_usuario
        WHERE u.id_usuario = :id_usuario
    ");

    // Vincula el parámetro
    $query->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

    // Ejecuta la consulta
    $query->execute();

    // Obtiene los resultados
    $pedidos = $query->fetchAll(PDO::FETCH_ASSOC);

    // Opcional: Imprime los resultados para depuración
    print_r($pedidos);

} catch (PDOException $e) {
    echo "Error al obtener los pedidos: " . $e->getMessage();
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Mis Pedidos</h2>

    <?php if (count($pedidos) > 0): ?>
        <div class="lista-pedidos">
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido">
                    <img src="<?= htmlspecialchars($pedido['producto_imagen']) ?>" alt="<?= htmlspecialchars($pedido['producto_nombre']) ?>" class="imagen-producto">
                    <div class="detalles-pedido">
                        <h3><?= htmlspecialchars($pedido['producto_nombre']) ?></h3>
                        <p><strong>Cantidad:</strong> <?= $pedido['cantidad_producto'] ?></p>
                        <p><strong>Precio Total:</strong> <?= number_format($pedido['precio_total'], 2) ?> €</p>
                        <p><strong>Tipo de Pago:</strong> <?= htmlspecialchars($pedido['tipo_pago'] ?? 'N/A') ?></p>
                        <p><strong>Importe Pagado:</strong> <?= number_format($pedido['pago_cantidad'] ?? 0, 2) ?> €</p>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No has realizado pedidos aún.</p>
    <?php endif; ?>
</body>
</html>