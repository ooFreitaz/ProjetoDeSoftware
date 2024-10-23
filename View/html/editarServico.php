<?php
session_start();

if (isset($_SESSION['id']) && isset($_GET['id'])) {
    $idUsuario = $_SESSION['id'];
    $idServico = $_GET['id'];
} else {
    header("Location: logintela.php");
    exit();
}

require('../../Controller/conexao.php');

function buscarServico($conexao, $idServico, $idUsuario) {
    $sql = "SELECT * FROM servico WHERE id=:idServico AND idDono=:idUsuario";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idServico', $idServico, PDO::PARAM_INT);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function listarRegistro($conexao, $id) {
    $sql = "SELECT * FROM usuario WHERE id=:id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


$registro = listarRegistro($conexao, $idUsuario);
$servico = buscarServico($conexao, $idServico, $idUsuario);

if ($servico) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Serviço</title>
    <link rel="stylesheet" href="../css/editarServico.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

   <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="nav.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <h3>FindEditor</h3>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="nav.php" class="nav-link px-2 link-secondary">Home</a></li>
          <li><a href="contato.php" class="nav-link px-2 link-body-emphasis">Contato</a></li>
          <li><a href="sobre.php" class="nav-link px-2 link-body-emphasis">Sobre</a></li>
          <li><a href="faq.php" class="nav-link px-2 link-body-emphasis">FAQ</a></li>
        </ul>


        <div class="dropdown text-end">
          <a href="nav.php" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../uploads/<?php echo $registro['fotoPerfil']; ?>" onerror="this.src='../../uploads/perfil_padrao.jpg'" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
            <li><a class="dropdown-item" href="criarServico.php">Criar Serviço</a></li>
            <li><a class="dropdown-item" href="#">Meus Serviços</a></li>
            <li><a class="dropdown-item" href="favoritos.php">Favoritos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();">Log out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>


  <form id="logout-form" action="../../Controller/POO/UserController.php?action=logout" method="POST" style="display: none;">
    <input type="hidden" name="logout" value="1">
  </form>








<div class="container">
    <h2>Editar Serviço</h2>

    <form action="../../Model/updateServico.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idServico" value="<?php echo htmlspecialchars($servico['id']); ?>">

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($servico['titulo']); ?>" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <textarea class="form-control" id="descricao" name="descricao" required><?php echo htmlspecialchars($servico['descricao']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="categoria">Categoria:</label>
            <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo htmlspecialchars($servico['categoria']); ?>" required>
        </div>

        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="text" class="form-control" id="valor" name="valor" value="<?php echo htmlspecialchars($servico['valor']); ?>" required>
        </div>

        <div class="form-group">
            <label for="prazoEntrega">Prazo de Entrega:</label>
            <input type="text" class="form-control" id="prazoEntrega" name="prazoEntrega" value="<?php echo htmlspecialchars($servico['prazoEntrega']); ?>" required>
        </div>

        <div class="form-group">
            <label for="imagens">Imagem do Serviço:</label>
            <input type="file" class="form-control" id="imagens" name="imagens">
            <p>Imagem atual: <?php echo htmlspecialchars($servico['imagens']); ?></p>
        </div>

        <div class="form-group">
            <label for="linksYoutube">Link do Youtube:</label>
            <input type="text" class="form-control" id="linksYoutube" name="linksYoutube" value="<?php echo htmlspecialchars($servico['linksYoutube']); ?>">
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

<?php
} else {
    echo "Serviço não encontrado ou você não tem permissão para editá-lo.";
}
?>
