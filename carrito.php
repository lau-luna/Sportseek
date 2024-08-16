<?php include("template/cabecera.php"); ?>

<br><br><br>


<h3>Carrito de compras</h3>
<div id="carrito-container">
    <table id="carrito-table" class="table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Acciones</th>
</tr>
</thead>
<tbody>
<!-- aca se añaden los productos a traves del js  -->
</tbody>
</table>
<h4>Total:$<span id="total">0</span></h4>
</div>

<script>
    // funciones para el carrito
    function cargarCarrito() {
        let carritoGuardado= JSON.parse(localStorage.getItem('carrito'));
        let carritoTable= document.getElementById('carrito-table').getElementsByTagName('tbody')[0];
        let total=0;

        carritoGuardado.foreach(producto => {
            let fila = carritoTable.insertRow();
            let celdaProducto = fila.insertCell(0);
            let celdaProducto2 = fila.insertCell(1);
            let celdaProducto3 = fila.insertCell(2);

            celdaProducto.innerHTML = producto.nombre;
            celdaProducto2.innerHTML = '$' + producto.precio.toFixed(2);
            celdaProducto3.innerHTML= `<button class="btn btn-danger remove-item" data-id="${producto.id}">Eliminar</button>`;
             total += producto.precio;

        });

document.getElementById('total').innerHTML = total.toFixed(2);

// añadir funcionalidad de eliminar el producto, que bronca programar lpm
document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                eliminarProducto(this.getAttribute('data-id'));
            });
        });
    }
// funcion eliminar un producto
function eliminarProducto(id) {
    let carritoGuardado = JSON.parse(localStorage.getItem('carrito'));
    carritoGuardado= carritoGuardado.filter(producto => producto.id !== id);
    localStorage.setItem('carrito',JSON.stringify(carritoGuardado));
    location.reload();
}

window.onload=cargarCarrito;
</script>


    
        
    