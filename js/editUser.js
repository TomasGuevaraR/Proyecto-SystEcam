document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');
    const editForm = document.getElementById('editForm');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Obtén los datos del usuario del botón
            const userId = this.getAttribute('data-id');
            const userRol = this.getAttribute('data-rol');
            const userEstado = this.getAttribute('data-estado');
            
            // Establece los valores en el formulario del modal
            document.getElementById('edit-id').value = userId;
            document.getElementById('edit-rol').value = userRol;
            document.getElementById('edit-estado').value = userEstado;
        });
    });
});
