<?php
include 'navbar.php';
include 'conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo '<script>
            alert("Debes iniciar sesión para realizar un pedido.");
            window.location.href = "login.php";
          </script>';
    exit;
}

// Obtener los productos del carrito del usuario
$id_usuario = $_SESSION['user_id'];
$query = $pdo->prepare("SELECT c.id_carrito, p.nombre, p.precio, p.id_producto
                        FROM carrito c
                        JOIN producto p ON c.id_producto = p.id_producto
                        WHERE c.id_usuario = ?");
$query->execute([$id_usuario]);
$productos_carrito = $query->fetchAll(PDO::FETCH_ASSOC);

// Calcular el precio total y la cantidad de productos
$precio_total = 0;
$cantidad_producto = 0;
foreach ($productos_carrito as $producto) {
    $precio_total += $producto['precio'];
    $cantidad_producto++;  // Asumimos que hay una sola unidad por producto
}

// Manejar la lógica del formulario de pago
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo_pago = $_POST['tipo_pago'];

    // Insertar el pedido en la base de datos
    $query_pedido = $pdo->prepare("INSERT INTO pedido ( precio_total, cantidad_producto, id_producto, id_usuario)
                                   VALUES (?, ?, ?, ?)");
    $query_pedido->execute([$precio_total, $cantidad_producto, $productos_carrito[0]['id_producto'], $id_usuario]);
    $id_pedido = $pdo->lastInsertId();  // Obtener el id del último pedido insertado

    // Insertar el pago en la base de datos
    $query_pago = $pdo->prepare("INSERT INTO pago (cantidad, tipo_pago, id_usuario, id_pedido)
                                 VALUES (?, ?, ?, ?)");
    $query_pago->execute([$precio_total, $tipo_pago, $id_usuario, $id_pedido]);

    // Eliminar los productos del carrito después de realizar el pedido
    $query_delete_cart = $pdo->prepare("DELETE FROM carrito WHERE id_usuario = ?");
    $query_delete_cart->execute([$id_usuario]);

    // Redirigir a una página de confirmación o de agradecimiento
    echo '<script>
            alert("Pedido realizado con éxito.");
            window.location.href = "index.php"; // Página de agradecimiento
          </script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido</title>
    <style>

    .contenedor-productos {
        background-color: #e1fbe1;
        align-content: center;
        width: 50%;
        padding: 20px;
        margin: 30px 25%;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }
    </style>
</head>
<body>

    <div class="contenedor-productos">
        <h1>Realizar Pedido</h1>

        <p><strong>Productos en tu carrito:</strong></p>
        <ul>
            <?php foreach ($productos_carrito as $producto): ?>
                <li><?= htmlspecialchars($producto['nombre']) ?> - <?= htmlspecialchars($producto['precio']) ?> €</li>
            <?php endforeach; ?>
        </ul>

        <p><strong>Total a Pagar: <?= number_format($precio_total, 2) ?> €</strong></p>

        <!-- Formulario para elegir el tipo de pago -->
        <form action="pedido.php" method="POST">
            <label for="tipo_pago">Selecciona el método de pago:</label><br><br>

            <!-- Botones de radio para seleccionar el tipo de pago -->
            <input type="radio" name="tipo_pago" value="VISA" id="visa" required>
            <label for="visa">VISA</label><br>

            <input type="radio" name="tipo_pago" value="PAYPAL" id="paypal" required>
            <label for="paypal">PAYPAL</label><br>

            <input type="radio" name="tipo_pago" value="BIZUM" id="bizum" required>
            <label for="bizum">BIZUM</label><br><br>

            <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
        </form>
    </div>

</body>
</html>
