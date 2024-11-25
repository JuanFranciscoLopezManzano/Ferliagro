<?php
session_start();
include '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

    // Verificar si el email ya está en uso usando PDO
    $verificacion = $pdo->prepare("SELECT * FROM usuario WHERE email = :email");
    $verificacion->bindParam(':email', $email);
    $verificacion->execute();
    $r = $verificacion->rowCount();

    if ($r > 0) {
        $_SESSION['errord']= "El email ya está en uso.";

    } else {
        // Consulta SQL para insertar nuevo usuario
        $sql = "INSERT INTO usuario (nombre, apellido, direccion, email, telefono, contrasena, administrador) 
                VALUES (:nombre, :apellido, :direccion, :email, :telefono, :contrasena, 0)";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':contrasena', $contrasena);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                header('Location: ../index.php');
            } else {
                echo "Error al registrar usuario.<br>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
