<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Contato</title>
    <link rel="stylesheet" href="../css/contato.css">
</head>
<body>
    <div class="container">
        <a href="nav.php" class="back-button">&larr; Voltar</a>
        <h1>Contato</h1>
        <form action="../../Model/sendContato.php" method="POST">
            <label for="message">Mensagem:</label>
            <textarea id="message" name="message" required></textarea><br>
            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>
