<?php
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    header("Location: logintela.php");
    exit();
}

require('../../Controller/conexao.php');

function listarRegistro($conexao, $id) {
    $sql = "SELECT * FROM usuario WHERE id=:id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function listarServicos($conexao, $idUsuario) {
    $sql = "SELECT * FROM servico WHERE dono_servico=:idUsuario";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$registro = listarRegistro($conexao, $id);
$servicos = listarServicos($conexao, $id);

if ($registro) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" type="text/css" href="../css/meusServico.css">
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
            <img src="../../uploads/<?php echo $registro['fotoPerfil']; ?>" alt="mdo" width="32" height="32" class="rounded-circle">
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


  <form id="logout-form" action="../../Model/logout.php" method="POST" style="display: none;">
    <input type="hidden" name="logout" value="1">
  </form>






 <div class="container">
    <div class="myServicesContent">
      <h2>Meus Serviços</h2>
      <?php if (!empty($servicos)) { ?>
        <div class="row">
            <?php foreach ($servicos as $servico) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="../../uploads/<?php echo $servico['imagens']; ?>" class="card-img-top" alt="Imagem do Serviço" width="60%">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($servico['titulo']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($servico['descricao']); ?></p>
                            <p class="card-text"><strong>Categoria:</strong> <?php echo htmlspecialchars($servico['categoria']); ?></p>
                            <p class="card-text"><strong>Valor:</strong> R$<?php echo htmlspecialchars($servico['valor']); ?></p>
                            <p class="card-text"><strong>Prazo de Entrega:</strong> <?php echo htmlspecialchars($servico['prazoEntrega']); ?></p>
                            <a href="detalhesServico.php?id=<?php echo $servico['id']; ?>" class="btn btn-primary">Ver Detalhes</a>
                            <a href="editarServico.php?id=<?php echo $servico['id']; ?>" class="btn btn-primary">Editar</a>
                            <a href="../../Model/deleteServico.php?id=<?php echo $servico['id']; ?>" class="btn btn-primary">Excluir</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
      <?php } else { ?>
        <p>Você ainda não possui serviços cadastrados.</p>
      <?php } ?>
    </div>
</div>




    




    
    <script src="../js/funcoes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
} else {
  header("Location: logintela.php");
}
?>