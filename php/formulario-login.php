<?php
session_start();
include '../conexion.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena']; // Usa 'password' para el campo del formulario

    // Prepara la consulta SQL para obtener el usuario por su email
    $query = "SELECT * FROM usuario WHERE email = :email"; // Utiliza el nombre correcto de la tabla
    $stmt = $pdo->prepare($query); // Prepara la consulta

    // Ejecuta la consulta con el parámetro
    $stmt->execute(['email' => $email]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener un solo registro

    // Verifica si el usuario existe
    if ($resultado) {
        // Verifica la contraseña
        if (password_verify($contrasena, $resultado['contrasena'])) {
            // Iniciar la sesión del usuario
            $_SESSION['user_id'] = $resultado['id_usuario'];
            $_SESSION['user_email'] = $resultado['email'];
            $_SESSION['user_nombre'] = $resultado['nombre'];
            $_SESSION['administrador'] = $resultado['administrador'];

            if($_SESSION['administrador'] == 1){
                header('Location: ../admin/panel-control.php');
            } else {
                header('Location: ../index.php');
            }
            exit();
        } else {
            $_SESSION['error'] = "Email o contraseña incorrecta.";
        }
    } else {
        $_SESSION['error'] = "No se encontró un usuario con ese correo electrónico.";
    }
    header("Location: ../index.php");
    exit();
}
?>
