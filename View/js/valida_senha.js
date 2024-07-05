document.getElementById('senha').addEventListener('input', function() {
    var senha = this.value;
    var feedbackElement = document.getElementById('senha-feedback');
    var strength = 0;

    // Verificar o comprimento da senha
    if (senha.length >= 6) {
        strength += 1;
    }
    
    // Verificar se a senha contém caracteres especiais
    if (senha.match(/[!@#$%^&*(),.?":{}|<>-]/)) {
        strength += 1;
    }

    // Verificar se a senha contém letras maiúsculas e minúsculas
    if (senha.match(/[a-z]/) && senha.match(/[A-Z]/)) {
        strength += 1;
    }

    // Mostrar feedback com base na força da senha
    switch (strength) {
        case 0:
        case 1:
            feedbackElement.innerHTML = "Senha fraca";
            feedbackElement.style.color = "red";
            break;
        case 2:
            feedbackElement.innerHTML = "Senha razoável";
            feedbackElement.style.color = "orange";
            break;
        case 3:
            feedbackElement.innerHTML = "Senha forte";
            feedbackElement.style.color = "green";
            break;
    }
});