<?php
session_start();
require 'conexion.php';
$logged_in = isset($_SESSION['user_id']);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FERLIAGRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
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
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        <?php echo $_SESSION['error']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>



<header>
    <div class="contenedor-1 d-flex justify-content-between align-items-center">
        <!-- logo -->
        <div class="contenedor-logo">
            <a href="index.php">
                <img src="img/logo.png" alt="Logo" id="logo">
            </a>
        </div>

        <!-- buscador -->
        <div class="contenedor-buscador">
            <form class="d-flex" method="GET" action="index.php" role="search">
                <input class="form-control" type="search" placeholder="Buscar" aria-label="Buscar" name="search">
            </form>
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
                        <a class="dropdown-item" href="cuenta.php">Mi cuenta</a>
                        <a class="dropdown-item" href="mi-pedido.php">Pedidos</a>
                        <a class="dropdown-item" href="php/cerrar-sesion.php">Cerrar sesión</a>
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
            <a href="carrito.php" class="bi bi-cart4" style="font-size: 1.5rem; color: black; text-decoration: none;"></a>

        </div>
    </div>

    <!-- Menú de categorías -->
    <nav class="menu-categorias text-center">
        <a href="fertilizante.php">Fertilizantes</a>
        <a href="herramienta.php">Herramientas</a>
        <a href="veneno.php">Venenos</a>
    </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Incluye jQuery y Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
