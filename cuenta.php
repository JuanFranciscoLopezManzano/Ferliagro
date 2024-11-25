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

//Optienen datos del usuario
$stmt = $pdo->prepare("SELECT nombre, apellido, direccion, email, telefono FROM usuario WHERE id_usuario =:user_id");
$stmt->execute(['user_id' => $id_usuario]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){
    echo "Error: usuario no encontrado.";
    exit();
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];


    $actualizar_dtmt = $pdo->prepare("UPDATE usuario SET nombre = :nombre, apellido = :apellido, direccion = :direccion, email = :email, telefono = :telefono WHERE id_usuario = :user_id");
    $actualizar_dtmt->execute([
        'nombre' => $nombre,
        'apellido' => $apellido,
        'direccion' => $direccion,
        'email' => $email,
        'telefono' => $telefono,
        'user_id' => $id_usuario
    ]);
}
?>

<div class="contenedor-producto">
    <h1>Perfil de Usuario</h1>
    <form action="cuenta.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" required>

        <label for="direccion">Direccion:</label>
        <input type="text" name="direccion" id="direccion" value="<?php echo htmlspecialchars($user['direccion']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="telefono">Telecono:</label>
        <input type="text" name="telefono" id="telefono" maxlength="9" pattern="\d{9}" value="<?php echo htmlspecialchars($user['telefono']); ?>" required>

        <button type="submit">Actualizar Perfil</button>
    </form>
</div>