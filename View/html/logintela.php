<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login de Usuário</title>
    <link rel="stylesheet" href="../css/logintelas.css">
</head>
<body>
    
    <form action="../../Controller/UserController.php?action=login" method="post">
        <div><h1>Faça Login</h1></div>
        <div id="form">
            <label for="email" class="label">Email</label>
            <input type="email" name="email" class="input" required>
            <label for="senha" class="label">Senha</label>
            <input type="password" name="senha" class="input" required>
            <button type="submit">Login</button>
        </div>
        <div>Não tem cadastro? <a href="cadastro.php">Cadastre-se aqui</a></div>
    </form>
</body>
</html>