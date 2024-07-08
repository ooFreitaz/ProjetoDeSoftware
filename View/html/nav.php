<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Bem Vindo!</title>
    <link rel="stylesheet" href="../css/navs.css">
</head>
<body>
    <a href="perfil.php" class="link">Perfil</a>

    <form action="../../Model/logout.php" method="post">
        <button class="link" type="submit">Logout</button>
    </form>
    <a href="contato.php" class="link">Formulário de Contato</a>
    
    <!-- Botão de alternância do modo escuro -->
    <button class="link" onclick="modoEscuro()">Modo Escuro</button>

    <script src="../js/funcoes.js"></script>
    <script src="../js/modoEscuro.js"></script>
</body>
</html>
