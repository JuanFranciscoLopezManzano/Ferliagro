<?php
include 'navbar.php';
include 'conexion.php'; // Iniciamos la conexión a la Base de Datos

// Seleccionamos todos los productos con categoría 'veneno'
$query = $pdo->prepare("SELECT p.* FROM producto p
                         JOIN categoria c ON p.id_categoria = c.id_categoria
                         WHERE c.nombre = 'veneno'");
$query->execute();
$productos = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($productos) > 0) {
    echo '<div class="contenedor-producto">';
    echo '<div class="row">';
    $counter = 0; // Inicializamos un contador para realizar un salto de línea cada dos productos
    foreach ($productos as $veneno) {
        echo '<div class="col-md-3 book" onclick="showPopup(' . $veneno['id_producto'] . ', \'' . addslashes($veneno['nombre']) . '\', \'' . addslashes($veneno['descripcion']) . '\', \'' . $veneno['imagen'] . '\', \'' . $veneno['precio'] . '\')">';
        echo '<img src="' . $veneno['imagen'] . '" alt="' . $veneno['nombre'] . '" class="img-fluid">';
        echo '<h4>' . $veneno['nombre'] . '</h4>';
        echo '<div class="price">' . $veneno['precio'] . ' €</div>';
        echo '<form action="php/agregar-carrito.php" method="POST">';
        echo '<input type="hidden" name="id_producto" value="' . $veneno['id_producto'] . '">';
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
} else {
    echo "No se encontraron productos en esta categoría.";
}
?>

<!-- Pop-up -->
<div id="productPopup" class="popup" style="display:none;" onclick="cerrarPopup(event)">
    <div class="popup-contenido" onclick="event.stopPropagation();">
        <span class="cerrar" onclick="cerrarPopup()">&times;</span>
        <img id="popupImage" src="" alt="" class="img-fluid">
        <h3 id="popupName"></h3>
        <p id="popupDescription"></p>
        <div class="price" id="popupPrice"></div>
    </div>
</div>

<script>
function showPopup(id, name, description, image, price) {
    document.getElementById('popupImage').src = image;
    document.getElementById('popupName').innerText = name;
    document.getElementById('popupDescription').innerText = description;
    document.getElementById('popupPrice').innerText = price + ' €';
    document.getElementById('productPopup').style.display = 'block';
}

function cerrarPopup(event) {
    if (event) {
        event.preventDefault();
    }
    document.getElementById('productPopup').style.display = 'none';
}
</script>

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
        cursor: pointer;
        float: right;
        font-size: 20px;
    }

    .img-fluid {
        cursor: pointer; /* Aplica el cursor de mano a la imagen */
    }
</style>
