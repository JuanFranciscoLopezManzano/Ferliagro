<?php
include 'navbar.php';
include 'conexion.php'; // Iniciamos la conexión a la Base de Datos

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consultar productos según la búsqueda o mostrar todos
if ($search) {
    $query = $pdo->prepare("SELECT p.* FROM producto p
                             JOIN categoria c ON p.id_categoria = c.id_categoria
                             WHERE c.nombre = 'fertilizante' AND p.nombre LIKE ?");
    $query->execute(["%$search%"]);
} else {
    $query = $pdo->prepare("SELECT p.* FROM producto p
                             JOIN categoria c ON p.id_categoria = c.id_categoria
                             WHERE c.nombre = 'fertilizante'");
    $query->execute();
}

$productos = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($productos) > 0) {
    echo '<div class="contenedor-producto">'; // Contenedor único para todos los productos
    echo '<div class="row">'; // Iniciamos la fila de productos

    $counter = 0; // Inicializamos un contador para realizar un salto de línea cada dos productos
    foreach ($productos as $fertilizante) {
        echo '<div class="col-md-3 book" onclick="showPopup(' . $fertilizante['id_producto'] . ', \'' . addslashes($fertilizante['nombre']) . '\', \'' . addslashes($fertilizante['descripcion']) . '\', \'' . $fertilizante['imagen'] . '\', \'' . $fertilizante['precio'] . '\')" style="cursor: pointer;">';
        echo '<img src="' . $fertilizante['imagen'] . '" alt="' . $fertilizante['nombre'] . '" class="img-fluid">';
        echo '<h4>' . $fertilizante['nombre'] . '</h4>';
        echo '<div class="price">' . $fertilizante['precio'] . ' €</div>';
        echo '<form action="php/agregar-carrito.php" method="POST">';
        echo '<input type="hidden" name="id_producto" value="' . $fertilizante['id_producto'] . '">';
        echo '<button type="submit" class="comprar">Comprar</button>';
        echo '</form>';
        echo '</div>';


        $counter++; // Incrementamos el contador

        // Cada dos productos, agregamos un salto de línea
        if ($counter % 2 == 0) {
            echo '</div><div class="row">'; // Cerramos la fila actual y abrimos una nueva
        }
    }

    echo '</div>'; // Cerramos la última fila
    echo '</div>'; // Cerramos el contenedor único
} else {
    echo "<p>No se encontraron productos en esta categoría.</p>";
}
?>

<!-- Popup -->
<div id="product-popup" class="popup" style="display: none;">
    <div class="popup-contenido">
        <span class="cerrar" onclick="cerrarPopup()">&times;</span>
        <img id="popup-image" src="" alt="" />
        <h3 id="popup-name"></h3>
        <p id="popup-description"></p>
        <div class="price" id="popup-price"></div>
    </div>
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

    .row {
        justify-content: center;
        gap:20%;
    }

    .col-md-3 {
        margin: 30px;
    }
    .popup {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.7);
    }

    .popup-contenido {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
    }
    .popup-contenido img{
        width: 300px;
        display: block;
        margin: 0 auto;
        max-width: 100%;
        height: auto;
    }

    .cerrar {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .cerrar:hover,
    .cerrar:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

</style>

<script>
function showPopup(id, name, description, image, price) {
    document.getElementById('popup-image').src = image;
    document.getElementById('popup-name').innerText = name;
    document.getElementById('popup-description').innerText = description;
    document.getElementById('popup-price').innerText = price + ' €';
    document.getElementById('product-popup').style.display = 'block';
}

function cerrarPopup() {
    document.getElementById('product-popup').style.display = 'none';
}
</script>
<script src="js/scripts.js"></script>