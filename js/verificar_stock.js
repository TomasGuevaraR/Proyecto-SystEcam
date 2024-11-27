$(document).ready(function() {
    $('#cantidad').on('change input', function() {
        let productoId = $('#producto').val();
        let cantidad = $(this).val();

        if (productoId && cantidad > 0) {
            $.ajax({
                url: 'Control/verificar_stock.php',
                type: 'POST',
                data: {
                    producto_id: productoId,
                    cantidad: cantidad
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'error') {
                        alert(response.message);
                        $('#cantidad').val(''); // Opcional: resetea la cantidad si no hay suficiente stock
                    }
                },
                error: function() {
                    alert('Error al verificar el stock.');
                }
            });
        }
    });
});
