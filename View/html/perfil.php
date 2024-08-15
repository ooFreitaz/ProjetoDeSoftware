<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" type="text/css" href="../css/perfi.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="nav.php" class="d-inline-flex link-body-emphasis text-decoration-none">
          <h3>FindEditor</h3>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="nav.php" class="nav-link px-2">Home</a></li>
        <li><a href="contato.php" class="nav-link px-2">Contato</a></li>
        <li><a href="sobre.html" class="nav-link px-2">Sobre</a></li>
        <li><a href="faq.html" class="nav-link px-2">FAQ</a></li>
      </ul>
    </header>
  </div>
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
    $sql = "SELECT * FROM editor WHERE id=:id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$registro = listarRegistro($conexao, $id);

if ($registro) {
?>
    <form action="../../Model/updateEditor.php" method="post" id="dados">
        <div id="div-dados">
            <div class="conjunto-dados">
                <label>CPF:</label>
                <input class = "input" type="text" name="cpf" id="cpf" maxlength="14" oninput="maskcpf()" value="<?php echo $registro['cpf']; ?>" required>
                <br>
            </div>
        
            <div class="conjunto-dados">
                <label>Nome:</label>
                <input class = "input" type="text" name="nome" value="<?php echo $registro['nome']; ?>" required>
                <br>
            </div>

            <div class="conjunto-dados">
                <label>Email: </label>
                <input class = "input" type="text" name="email" value="<?php echo $registro['email']; ?>" required>
                <br>
            </div>

            <div class="conjunto-dados">
                <label>Senha:</label>
                <input class = "input" type="text" name="senha" value="<?php echo $registro['senha']; ?>" required>
                <br>
            </div>

        </div>
        <button class="botao" type="submit">Alterar</button>
    </form>

    <button class="botao-delete" onclick="confirmarDelecao()">Deletar Conta</button>

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