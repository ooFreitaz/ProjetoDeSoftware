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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" type="text/css" href="../css/criarServicos.css">
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


  <form id="logout-form" action="../../Model/logout.php" method="POST" style="display: none;">
    <input type="hidden" name="logout" value="1">
  </form>





  
  <div class="container">
      <div>
      <form action="../../Model/createServico.php" method="post" id="cadastroForm" enctype="multipart/form-data">
  <h1>Crie seu Serviço</h1>
  <div class="formContent">
    <div class="groupContent">
      <label for="titulo" class="label">Titulo:</label>
      <input type="text" name="titulo" class="input" required>
    </div>
    <div class="groupContent">
      <label for="valor" class="label">Valor:</label>
      <input type="number" name="valor" class="input" required>
    </div>
    <div class="groupContent">
      <label for="categoria" class="label">Categoria:</label>
      <select name="categoria" id="categoria" required>
        <option value="select">Selecione uma categoria</option>
        <option value="animacao">Animação</option>
        <option value="vlog">Daily Vlogs</option>
        <option value="gameplay">Gameplays</option>
        <option value="reel">Reels</option>
      </select>
    </div>
    <div class="groupContent">
      <label for="prazo" class="label">Prazo de Entrega:</label>
      <select name="prazoEntrega" id="prazo" required>
        <option value="1 dia">1 dia</option>
        <option value="2 dias">2 dias</option>
        <option value="3 dias">3 dias</option>
        <option value="4 dias">4 dias</option>
        <option value="5 dias">5 dias</option>
        <option value="10 dias">10 dias</option>
        <option value="20 dias">20 dias</option>
      </select>
    </div>
    <div class="groupContent">
      <label for="descricao" class="label">Descrição:</label>
      <textarea name="descricao" class="input" required></textarea>
    </div>
    <div class="groupContent">
      <label for="imagem" class="label">Imagem:</label>
      <input type="file" name="imagemServico" accept="image/*">
    </div>
    <div class="groupContent">
      <label for="link" class="label">Link do Youtube:</label>
      <input type="text" name="link" class="input">
    </div>
    <button type="submit" class="button">Criar Serviço</button>
  </div>
</form>

      </div>
  </div>




    




    
    <script src="../js/funcoes.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

<?php
} else {
    echo "<p>Usuário não encontrado.</p>";
}
?>