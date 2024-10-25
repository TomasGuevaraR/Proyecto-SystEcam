document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Obtener datos del botón
            const id = this.getAttribute('data-id');
            const rol = this.getAttribute('data-rol');

            // Asignar valores a los campos del formulario en el modal
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-rol').value = rol; // Asigna el valor del rol seleccionado
        });
    });
});
