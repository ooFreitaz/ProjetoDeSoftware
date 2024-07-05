  document.getElementById('mostrarSenha').addEventListener('change', function() {
            var senhaInput = document.getElementById('senha');
            if (this.checked) {
                senhaInput.type = 'text';
            } else {
                senhaInput.type = 'password';
            }
        });