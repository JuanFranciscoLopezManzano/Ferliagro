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

$id_usuario = $_SESSION['user_id'];

// Obtener los productos del carrito
$query = $pdo->prepare("
    SELECT c.id_carrito, p.nombre, p.precio, p.descripcion, p.imagen, c.cantidad
    FROM carrito c
    JOIN producto p ON c.id_producto = p.id_producto
    WHERE c.id_usuario = ?
");
$query->execute([$id_usuario]);
$productos_carrito = $query->fetchAll(PDO::FETCH_ASSOC);

// Calcular el precio total
$precio_total = 0;
foreach ($productos_carrito as $producto) {
    $precio_total += $producto['precio'] * $producto['cantidad'];  // Multiplicamos el precio por la cantidad
}

?>

<div class="contenedor-producto">
    <h1>Carrito de Compras</h1>

    <?php if (count($productos_carrito) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos_carrito as $producto): ?>
                    <tr>
                        <td>
                            <img src="<?= $producto['imagen'] ?>" alt="<?= $producto['nombre'] ?>" style="width: 50px; height: 50px;">
                            <?= $producto['nombre'] ?>
                        </td>
                        <td><?= $producto['precio'] ?> €</td>
                        <td>
                            <form action="php/actualizar-cantidad.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id_carrito" value="<?= $producto['id_carrito'] ?>">
                                <button type="submit" name="accion" value="decrementar" class="btn btn-secondary">-</button>
                            </form>
                            <span><?= $producto['cantidad'] ?></span>
                            <form action="php/actualizar-cantidad.php" method="POST" style="display: inline;">
                                <input type="hidden" name="id_carrito" value="<?= $producto['id_carrito'] ?>">
                                <button type="submit" name="accion" value="incrementar" class="btn btn-secondary">+</button>
                            </form>
                        </td>
                        <td>
                            <form action="php/eliminar-carrito.php" method="POST">
                                <input type="hidden" name="id_carrito" value="<?= $producto['id_carrito'] ?>">
                                <button type="submit" class="btn btn-danger" title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="total">
            <h3>Total: <?= $precio_total ?> €</h3>
            <a href="pedido.php" class="btn btn-primary">Proceder al Pago</a>
        </div>
    <?php else: ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>
</div>
<style>
    .contenedor-producto {
        font-size:20px;
        background-color: #ccffcc;
        padding: 20px;
        margin: 30px 15%;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        width: 70%;
        display: flex;
        flex-direction: column;
    }
</style>