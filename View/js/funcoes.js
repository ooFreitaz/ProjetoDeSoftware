function maskcpf(){
    var cpf = document.getElementById("cpf").value;
    cpf = cpf.replace(/\D/g, "");
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d)/, "$1.$2");
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

    document.getElementById("cpf").value = cpf;
}

function confirmarDelecao() {
    if (confirm("Tem certeza que deseja deletar sua conta? Essa ação não pode ser desfeita.")) {
        document.getElementById("formDeletarConta").submit();
    } else {
        window.location.href = "perfil.php"; 
    }
}

function validateCPF() {
    var cpf = document.getElementById('cpf').value;
    if (cpf.length < 14) {
        alert('Por favor, insira um CPF completo.');
        return false; // Impede o envio do formulário
    }
    return true; // Permite o envio do formulário
}