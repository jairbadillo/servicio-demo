document.addEventListener('DOMContentLoaded', function () {
    // Obtener el nombre de la ruta actual
    const currentPage = document.body.getAttribute('data-page');
    
    // Verificar si estamos en la página de login
    if (currentPage === 'login') {
        // Oculta o muestra los que esta en el campo password del login
        document.getElementById('togglePassword').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.innerHTML = '<i class="bi bi-eye-fill"></i>';
            } else {
                passwordField.type = 'password';
                this.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
            }
        });
    }
});