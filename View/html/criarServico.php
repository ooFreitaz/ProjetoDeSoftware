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
    <link rel="stylesheet" type="text/css" href="../css/criarServico.css">
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
            <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
            <li><a class="dropdown-item" href="#">Criar Serviço</a></li>
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





  
  <div class="container my-2">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
            <form action="../../Controller/ServiceController.php?action=create_service" method="post" id="RegisterServiceForm" enctype="multipart/form-data">
                <h1 class="text-center">Crie seu Serviço</h1>
                <div class="formContent">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Titulo:</label>
                        <input type="text" name="titulo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor:</label>
                        <input type="number" name="valor" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoria:</label>
                        <select name="categoria" id="categoria" required class="form-select">
                            <option value="select">Selecione uma categoria</option>
                            <option value="animacao">Animação</option>
                            <option value="vlog">Daily Vlogs</option>
                            <option value="gameplay">Gameplays</option>
                            <option value="reel">Reels</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="prazo" class="form-label">Prazo de Entrega:</label>
                        <select name="prazoEntrega" id="prazo" required class="form-select">
                            <option value="1 dia">1 dia</option>
                            <option value="2 dias">2 dias</option>
                            <option value="3 dias">3 dias</option>
                            <option value="4 dias">4 dias</option>
                            <option value="5 dias">5 dias</option>
                            <option value="10 dias">10 dias</option>
                            <option value="20 dias">20 dias</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição:</label>
                        <textarea name="descricao" class="form-control" required maxlength="600" placeholder="Máximo de 600 caracteres..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="imagens" class="form-label">Imagem:</label>
                        <input type="file" name="imagens" accept="image/*" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Link do Youtube:</label>
                        <input type="text" name="link" class="form-control">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="custom-btn">Criar Serviço</button>
                    </div>
                </div>
            </form>
        </div>
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