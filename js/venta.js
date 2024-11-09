// Inicializamos el arreglo para los productos
var productosVenta = [];

// Función para agregar un producto
function agregarProducto(idProducto, nombre, precio) {
    var cantidad = document.querySelector(`input[name="cantidad_${idProducto}"]`).value;
    var subtotal = precio * cantidad;

    // Agregar el producto al array
    productosVenta.push({
        id_producto: idProducto,
        nombre: nombre,
        cantidad: cantidad,
        subtotal: subtotal
    });

    console.log(productosVenta); // Ver en consola si los productos se agregan correctamente

    // Actualizar la interfaz o mostrar algún mensaje si es necesario
    alert(`${nombre} agregado con cantidad: ${cantidad}`);
}

// Función para registrar la venta cuando se hace clic en el botón
document.getElementById("registrarVentaBtn").addEventListener("click", function (event) {
    event.preventDefault(); // Prevenir el envío del formulario de inmediato

    // Verificar si hay productos en la venta
    if (productosVenta.length === 0) {
        alert("Debe agregar al menos un producto.");
        return;
    }

    // Llenar el campo oculto con el arreglo de productos en formato JSON
    document.getElementById("productos_venta").value = JSON.stringify(productosVenta);

    // Enviar el formulario
    document.getElementById("registrarVentaForm").submit();
});
