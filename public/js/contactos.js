document.addEventListener('DOMContentLoaded', function() {
    // Marcar como leído
    document.querySelectorAll('.marcar-leido').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const row = this.closest('tr');
            
            fetch(`<?= base_url('contacto/marcar-leido/') ?>${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        row.classList.remove('table-warning');
                        this.remove();
                        // Actualizar contador de no leídos
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al marcar como leído');
                });
        });
    });

    // Responder contacto
    document.querySelectorAll('.responder-contacto').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const asunto = this.dataset.asunto;
            
            document.getElementById('asuntoContacto').textContent = asunto;
            document.getElementById('formResponder').action = `<?= base_url('contacto/responder/') ?>${id}`;
            
            const modal = new bootstrap.Modal(document.getElementById('responderModal'));
            modal.show();
        });
    });
});