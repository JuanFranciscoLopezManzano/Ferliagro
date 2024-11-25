<?php
session_start();
include '../conexion.php'; // Conexión a la base de datos
$logged_in = isset($_SESSION['user_id']);


// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['administrador'] != 1) {
    // Si no es administrador, redirigir al inicio o mostrar un mensaje de error
    echo '<script>
            alert("Solo los administradores pueden agregar productos.");
            window.location.href = "index.php";
          </script>';
    exit;
}

// Verificar si se ha enviado el formulario para agregar un producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_POST['imagen']; // Asegúrate de que el campo imagen tenga el URL correcto
    $id_categoria = $_POST['id_categoria'];

    // Insertar el nuevo producto en la base de datos
    $query = $pdo->prepare("INSERT INTO producto (nombre, precio, descripcion, imagen, id_categoria)
                            VALUES (?, ?, ?, ?, ?)");
    $query->execute([$nombre, $precio, $descripcion, $imagen, $id_categoria]);

    // Redirigir a una página de confirmación o listado de productos
    header("Location: panel-control.php"); // Redirigir a la página donde se listan los productos
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FERLIAGRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="estilo-admin.css">
    <style>
        .close {

            color: white; /* Color de la X */
            opacity: 0.8; /* Opacidad para un efecto más suave */
            background:gray;
            align: right;
        }

        .close:hover {
            opacity: 1; /* Aumenta la opacidad al pasar el mouse */
            cursor: pointer; /* Cambia el cursor para indicar que es clickeable */
            background:#c5c5c5;
        }

    </style>
</head>
<body>
<header>
    <div class="contenedor-1 d-flex justify-content-between align-items-center">
        <!-- logo -->
        <div class="contenedor-logo">
            <a href="index.php">
                <img src="../img/logo.png" alt="Logo" id="logo" >
            </a>
        </div>
        <!-- iconos de usuario y carrito -->
        <div class="contenedor-iconos">
            <!-- Icono de usuario con menú desplegable -->
            <div class="dropdown">
                <a href="#" class="dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php if ($logged_in): ?>
                        <span><?php echo htmlspecialchars($_SESSION['user_nombre']); ?></span>
                    <?php else: ?>
                        <i class="bi bi-person-circle"></i>
                        <span>Log in</span>
                    <?php endif; ?>
                </a>

                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <?php if ($logged_in): ?>
                        <a class="dropdown-item" href="../php/cerrar-sesion.php">Cerrar sesión</a>
                    <?php else: ?>
                        <form class="px-4 py-3" method="POST" action="php/formulario-login.php">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="contrasena" placeholder="Contraseña">
                            </div>
                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="registro.php">¿No tienes cuenta? Regístrate</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header>
<br>
<button onclick="window.history.back();" class="btn btn-primary">Volver</button>

<!-- Formulario para agregar un producto -->
<form action="agregar-producto.php" method="POST" class="contenedor-producto2">
    <label for="nombre">Nombre del Producto:</label>
    <input type="text" name="nombre" id="nombre" required><br>

    <label for="precio">Precio:</label>
    <input type="number" name="precio" id="precio" step="0.01" required><br>

    <label for="descripcion">Descripción:</label>
    <textarea name="descripcion" id="descripcion" required></textarea><br>

    <label for="imagen">Imagen (URL):</label>
    <input type="text" name="imagen" id="imagen" required><br>

    <label for="id_categoria">Categoría:</label>
    <select name="id_categoria" id="id_categoria">
        <!-- Aquí cargamos las categorías disponibles desde la base de datos -->
        <?php
        $query = $pdo->prepare("SELECT * FROM categoria");
        $query->execute();
        $categorias = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($categorias as $categoria) {
            echo "<option value='" . $categoria['id_categoria'] . "'>" . $categoria['nombre'] . "</option>";
        }
        ?>
    </select><br>

    <button type="submit" class="btn-agregar">Agregar Producto</button>
</form>
<br>
<br>
<br>