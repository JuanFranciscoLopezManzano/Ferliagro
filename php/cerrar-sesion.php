<?php
session_start();// Inicia una sesion nueva o reanuda una ya creada.
session_destroy(); //Destruye toda la información registrada de la sesion
header('Location: ../index.php'); // Redirige al usuario a la pagina de inicio.
exit(); //Termina la ejecucion paara asegurar que la redireccion ocurre.
?>