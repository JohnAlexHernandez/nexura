document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', event => {
            event.preventDefault();
            const url = button.getAttribute('data-url');
            if (confirm('¿Estás seguro de que deseas eliminar esta area?')) {
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert(data.success, 'success');
                        button.closest('tr').remove();
                    } else if (data.error) {
                        showAlert(data.error, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error al eliminar la area.', 'danger');
                });
            }
        });
    });
});

function showAlert(message, type) {
    const alertContainer = document.getElementById('alerts');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} alert-dismissible fade show`;
    alert.role = 'alert';
    alert.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
    alertContainer.appendChild(alert);
    setTimeout(() => {
        alert.remove();
    }, 5000);
}