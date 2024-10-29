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


if ($registro) {
?>

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

<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="nav.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <h3>FindEditor</h3>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="nav.php" class="nav-link px-2 link-body-emphasis">Home</a></li>
          <li><a href="contato.php" class="nav-link px-2 link-body-emphasis">Contato</a></li>
          <li><a href="sobre.php" class="nav-link px-2 link-body-emphasis">Sobre</a></li>
          <li><a href="faq.php" class="nav-link px-2 link-body-emphasis">FAQ</a></li>
        </ul>


        <div class="dropdown text-end">
          <a href="nav.php" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../uploads/<?php echo $registro->getFotoPerfil(); ?>" onerror="this.src='../../uploads/perfil_padrao.jpg'" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="#">Perfil</a></li>
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





  <div class="container diff">
    <div class="row">
      <div class="col-lg-6 col-md-8 mx-auto">
        <form action="../../Controller/UserController.php?action=update_user" method="post" enctype="multipart/form-data" id="dados">
          <div class="mb-3">
            <label for="cpf" class="form-label">CPF:</label>
            <input type="text" class="form-control" name="cpf" id="cpf" minlength="14" maxlength="14" oninput="maskcpf()" value="<?php echo $registro->getCpf(); ?>" required>
          </div>

          <div class="mb-3">
            <label for="nome" class="form-label">Nome:</label>
            <input type="text" class="form-control" name="nome" id="cpf" value="<?php echo $registro->getNome(); ?>" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="text" class="form-control" name="email" id="cpf" value="<?php echo $registro->getEmail(); ?>" required>
          </div>

          <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" class="form-control" id="senha" name="senha" id="cpf" value="<?php echo $registro->getSenha(); ?>" required>
            <input type="checkbox" id="mostrarSenha" class="show-password">   <span id="mostrarSenha">Mostrar Senha</span>
          </div>

          <div class="mb-3">
            <label for="fotoPerfil" class="form-label">Foto de Perfil:</label>
            <input type="file" class="form-control" name="fotoPerfil" id="cpf" accept="image/*">
          </div>

          <button type="submit" class="custom-btn" onclick="return validateCPF()">Alterar</button>
        </form>

        <button class="custom-btn btn-danger" onclick="confirmarDelecao()">Deletar Conta</button>
        <form id="formDeletarConta" action="../../Controller/UserController.php?action=delete_user" method="POST">
            <input type="hidden" name="id" value="<?php echo $registro->getId(); ?>">
        </form>
      </div>

      <div class="col-lg-6 col-md-8 mx-auto text-center mt-4">
        <img src="../../uploads/<?php echo$registro->getFotoPerfil(); ?>" onerror="this.src='../../uploads/perfil_padrao.jpg'" class="profile-picture rounded-circle">
      </div>
    </div>
  </div>






    <script src="../js/mostra_senha.js"></script> 
    <script src="../js/funcoes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
} else {
  header("Location: logintela.php");
}
?>