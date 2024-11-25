<?php
session_start();
include 'conexion.php';

?>
<!DOCTYPE html>
<html lang="en">
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
                    <i class="bi bi-person-circle"></i>
                    <span>Log in</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                    <form class="px-4 py-3" method="POST" action="login.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="email@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">contrasena</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="contrasena">
                        </div>
                        <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                    </form>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="registro.php">¿No tienes cuenta? Regístrate</a>
                </div>
            </div>
            <i class="bi bi-cart4"></i>
        </div>
    </div>
</header>
    <?php if (isset($_SESSION['errord'])): ?>
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <?php echo $_SESSION['errord']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['errord']); ?>
    <?php endif; ?>
<div class="contenedor-registro mt-5">
    <h2>Registro</h2>
    <form action="php/formulario-registro.php" method="POST">
        <!-- Campo: Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="150" required>
        </div>

        <!-- Campo: Apellido -->
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" name="apellido" maxlength="150" required>
        </div>

        <!-- Campo: Dirección -->
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" maxlength="150" required>
        </div>

        <!-- Campo: Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" maxlength="150" required>
        </div>

        <!-- Campo: Teléfono -->
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" maxlength="9" pattern="\d{9}" required>
        </div>

        <!-- Campo: contrasena -->
        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" maxlength="150" required>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>