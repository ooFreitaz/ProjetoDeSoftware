<?php 

session_start();

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
} else {
    header("Location: logintela.php");
    exit();
}

require_once '../../Model/UserDaoImpl.php';

// Criar uma instância de UserDaoImpl para utilizar seus métodos
$userDao = new UserDaoImpl();
// Utilizar o método getUser para obter as informações do usuário
$registro = $userDao->getUser($userId);

// Método existente para listar serviços de outros usuários
function listarServicosDeOutrosUsuarios($conexao, $idUsuario) {
    $sql = "SELECT servico.*, usuario.nome AS nomeDono
            FROM servico
            JOIN usuario ON servico.idDono = usuario.id
            WHERE servico.idDono != :idUsuario";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Continuar utilizando a conexão para listar serviços
require ('../../Controller/conexao.php');
$servicos = listarServicosDeOutrosUsuarios($conexao, $userId);

if ($registro) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Bem Vindo!</title>
    <link rel="stylesheet" href="../css/naaav.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<header class="p-3 mb-5 border-bottom">
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
          <a href="" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../uploads/<?php echo $registro->getFotoPerfil(); ?>" onerror="this.src='../../uploads/perfil_padrao.jpg'" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
            <li><a class="dropdown-item" href="criarServico.php">Criar Serviço</a></li>
            <li><a class="dropdown-item" href="meusServicos.php">Meus Serviços</a></li>
            <li><a class="dropdown-item" href="favoritos.php">Favoritos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" onclick="document.getElementById('logout-form').submit();">Log out</a></li>
          </ul>
        </div>
      </div>
    </div>
</header>

<form id="logout-form" action="../../Controller/UserController.php?action=logout" method="POST" style="display: none;">
    <input type="hidden" name="logout" value="1">
</form>

<div class="container">
    <?php if (!empty($servicos)) { ?>
        <div class="row">
            <?php foreach ($servicos as $servico) { ?>
              <div class="col-md-3">
                  <a href="detalhesServico.php?id=<?php echo $servico['id']; ?>">
                      <div class="card mb-5 shadow-sm">
                          <img src="../../uploads/<?php echo $servico['imagens']; ?>" class="card-img-top">
                          <div class="card-body">
                              <p class="nomeDono"><?php echo htmlspecialchars($servico['nomeDono']); ?></p>
                              <h5 class="titulo"><?php echo htmlspecialchars($servico['titulo']); ?></h5>
                              <p class="preco">R$<?php echo htmlspecialchars($servico['valor']); ?></p>
                          </div>
                      </div>
                  </a>
              </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>Nenhum serviço encontrado.</p>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
} else {
   header("Location: ../../index.php");
}
?>
