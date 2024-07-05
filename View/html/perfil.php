<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" type="text/css" href="../css/_perfil.css">
</head>
<body>
<?php
session_start();

if(isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    echo "<p>Usuário não está logado.</p>";
    exit();
}

require ('../../Controller/conexao.php');

function listarRegistro($conexao, $id) {
    $sql = "SELECT * FROM usuario WHERE id=:id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$registro = listarRegistro($conexao, $id);

if ($registro) {
?>
    <form action="../../Model/update.php" method="post" id="dados">
        <label>CPF:</label>
        <input type="text" name="cpf" id="cpf" maxlength="14" oninput="maskcpf()" value="<?php echo $registro['cpf']; ?>" required>
        <br>
        
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $registro['nome']; ?>" required>
        <br>

        <label>Email: </label>
        <input type="text" name="email" value="<?php echo $registro['email']; ?>" required>
        <br>

        <label>Senha:</label>
        <input type="text" name="senha" value="<?php echo $registro['senha']; ?>" required>
        <br>

        <button class="button" type="submit">Alterar</button>
    </form>

    <button class="button" onclick="confirmarDelecao()">Deletar Conta</button>

    <form id="formDeletarConta" action="../../Model/delete.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
    </form>
<?php
} else {
    echo "<p>Usuário não encontrado.</p>";
}
?>
    <script src="../js/funcoes.js"></script>
</body>
</html>