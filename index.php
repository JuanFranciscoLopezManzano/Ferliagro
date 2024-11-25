<?php
include 'navbar.php';
include 'conexion.php'; // Iniciamos la conexión a la Base de Datos

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Consultar productos según la búsqueda o mostrar todos
if ($search) {
    $query = $pdo->prepare("SELECT * FROM producto WHERE nombre LIKE ?");
    $query->execute(["%$search%"]);
    $productos = $query->fetchAll(PDO::FETCH_ASSOC);
} else {
    $productos = []; // Si no hay búsqueda, inicializamos como vacío
}
?>

<body>
    <style>

        .lista-producto {
            display: flex;
            flex-direction: column; /* Muestra los productos uno debajo del otro */
        }

        .productos {
            display: flex;
            align-items: center; 
            margin-bottom: 20px;
            padding: 10px;   
 
        }
        .productos img{
            width: 150px;
        }
    </style>

<?php if ($search): ?>
    <div class="contenedor-producto">
        <h2>RESULTADOS DE LA BÚSQUEDA</h2>
        <div class="lista-producto">
            <?php if (count($productos) > 0): ?>
                <?php $counter = 0; ?>
                <?php foreach ($productos as $producto): ?>
                    <?php if ($counter % 2 == 0): ?>
                        <div class="row">
                    <?php endif; ?>
                    
                    <div class="productos col-md-6">
                        <img src="<?= htmlspecialchars($producto['imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>">
                        <div class="detalles-producto">
                            <p><?= htmlspecialchars($producto['nombre']) ?> -<br><?= htmlspecialchars($producto['precio']) ?> €</p>
                            <button>Comprar</button>
                        </div>
                    </div>
                    
                    <?php 
                    $counter++; 
                    if ($counter % 2 == 0 || $counter == count($productos)): ?>
                        </div> <!-- Cierra la fila -->
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No se encontraron productos que coincidan con la búsqueda.</p>
            <?php endif; ?>
        </div>
    </div>
<?php else: ?>
    <div class="contenedor-producto" style="display: block;">
        <h2>LO MEJOR EN FERTILIZANTES</h2>
        <div class="lista-productos">
            <div class="producto">
                <img src="img/fertilizante-blackjack.png" alt="BlackJak 5L">
                <div class="detalles-producto">
                    <p><strong>BlackJak 5L -<br> Bioestimulante</strong></p>
                    <button>Comprar</button>
                </div>
            </div>
            <div class="producto">
                <img src="img/fertilizante-humisol.png" alt="Humisol Green 25, 20L">
                <div class="detalles-producto">
                    <p><strong>Humisol Green 25, 20L -<br>Ácido Fúlvicos y Húmicos</strong></p>
                    <button>Comprar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="contenedor-producto">
        <h2>LAS HERRAMIENTAS MÁS POPULARES</h2>
        <div class="lista-productos">
            <div class="producto">
                <img src="img/herramienta-azada2.png" alt="Azada de horquilla 02-A">
                <div class="detalles-producto">
                    <p><strong>Azada de <br> Horquillas 02-A</strong></p>
                    <button>Comprar</button>
                </div>
            </div>
            <div class="producto">
                <img src="img/herramienta-azada.png" alt="Azadilla Forjada 230-B">
                <div class="detalles-producto">
                    <p><strong>Azadilla Forjada-<br>230-B</strong></p>
                    <button>Comprar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="contenedor-producto">
        <h2>LOS VENENOS MÁS EFICACES</h2>
        <div class="lista-productos">
            <div class="producto">
                <img src="img/veneno-bathe.png" alt="Bathe 1KG">
                <div class="detalles-producto">
                    <p><strong>Bathe 1KG - Bacillus<br> Thuringiensis</strong></p>
                    <button>Comprar</button>
                </div>
            </div>
            <div class="producto">
                <img src="img/veneno-cipergen2.png" alt="Cipergen 1L">
                <div class="detalles-producto">
                    <p><strong>Cipergen 1L-<br>Cipermetrina</strong></p>
                    <button>Comprar</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<footer class="footer">
    <p><strong>Contacto:</strong></p>
    <p>Teléfono: +34 965872341</p>
    <p>Email: tuabono@gmail.com</p>
    <br>
    <div class="redes-iconos">
        <a href="https://www.facebook.com" target="_blank" class="icono-red">
            <i class="fab fa-facebook-f"></i>
        </a>
        <a href="https://www.twitter.com" target="_blank" class="icono-red">
            <i class="fab fa-twitter"></i>
        </a>
        <a href="https://www.instagram.com" target="_blank" class="icono-red">
            <i class="fab fa-instagram"></i>
        </a>
        <a href="https://www.linkedin.com" target="_blank" class="icono-red">
            <i class="fab fa-linkedin-in"></i>
        </a>
    </div>
</footer>

<div class="back-to-top" id="back-to-top">
    <i class="fas fa-arrow-up"></i>
</div>
<script src="js/script.js"></script>
</body>
