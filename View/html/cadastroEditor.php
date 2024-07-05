<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="../css/cadastroEditor.css">
</head>
<body>

    <?php require ("../../Controller/conexao.php"); ?>
   
    <form action="../../Model/insertEditor.php" method="post" id="cadastroForm">
        <div><h1>Cadastre-se</h1></div>
        <div id="form">
            <label for="nome" class="label">Nome</label>
            <input type="text" name="nome" class="input" required>
            <label for="cpf" class="label">CPF</label>
            <input type="text" id="cpf" class="input" placeholder="000.000.000-00" maxlength="14" oninput="maskcpf()" name="cpf" required>
            <label for="email" class="label">Email</label>
            <input type="email" name="email" class="input" required>
            <label for="senha" class="label">Senha</label>
            <input type="password" name="senha" id="senha" class="input" required>
            <input type="checkbox" id="mostrarSenha" class="show-password">
                
            <div id="senha-feedback">Força da Senha</div> <!-- Feedback da senha -->
            <button type="submit">Cadastrar</button>
        </div>
        <div>Já tem cadastro? <a href="logintela.php">Faça login</a></div>
    </form>
    


    <script src="../js/funcoes.js"></script>
    <script src="../js/valida_senha.js"></script>
    <script src="../js/mostra_senha.js"></script>
</body>
</html>