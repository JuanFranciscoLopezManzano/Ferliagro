const backToTopButton = document.getElementById('back-to-top');

window.onscroll = function () {
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        backToTopButton.classList.add('show');  //Muestra el botón
    } else {
        backToTopButton.classList.remove('show');  // Oculta el botón
    }
};

backToTopButton.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });  //
});


function cerrarPopup(event) {
    if (event) {
        event.preventDefault();
    }
    document.getElementById('productPopup').style.display = 'none';
}

function agregarCarrito(idProducto) {
    fetch('agregar_carrito.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id_producto: idProducto }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto añadido al carrito');
        } else {
            alert('Hubo un problema al añadir el producto al carrito');
        }
    })
    .catch(error => console.error('Error:', error));
}
