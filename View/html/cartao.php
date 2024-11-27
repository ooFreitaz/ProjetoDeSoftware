<?php 

session_start();

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $serviceId = $_GET['id'];
    $servicePrice = $_GET['valor'];
    $serviceOwner = $_GET['idDono'];
} else {
    header("Location: logintela.php");
    exit();
}

require_once '../../Model/UserDaoImpl.php';

$userDao = new UserDaoImpl();

$registro = $userDao->getUser($userId);


if ($registro) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Bem Vindo!</title>
    <link rel="stylesheet" href="../css/cartao.css">
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
          <li><a href="nav.php" class="nav-link px-2 link-body-emphasis">Home</a></li>
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
            <li><a class="dropdown-item" href="servicosComprados.php">Minhas Compras</a></li>
            <li><a class="dropdown-item" href="servicosVendidos.php">Minhas Vendas</a></li>
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
            <form action="../../Controller/OrderController.php?action=create_order" method="post" id="RegisterOrderForm" enctype="multipart/form-data">
                <h1 class="text-center">Dados de pagamento</h1>
                <div class="formContent">
                    <div class="mb-3">
                        <label for="titular" class="form-label">Nome do Titular:</label>
                        <input type="text" name="titular" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF do Titular:</label>
                        <input type="text" id="cpf" class="form-control" placeholder="000.000.000-00" maxlength="14" oninput="maskcpf()" name="cpf" required>
                    </div>

                    <div class="mb-3">
                        <label for="numero" class="form-label">Número do Cartão:</label>
                        <input type="text" name="numero" class="form-control" required placeholder="0000.0000.0000.0000" maxlength="16">
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código de Verificação:</label>
                        <input type="number" name="codigo" class="form-control" required placeholder="000" maxlength="3">
                    </div>

                    <div class="mb-3">
                        <label for="data" class="form-label">Data de Expiração:</label>
                        <input type="text" name="codigo" class="form-control" required placeholder="mm/aa">
                    </div>
                    
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor: R$<?php echo htmlspecialchars($servicePrice);?> </label>
                        <input type="hidden" name="valorFinal" value="<?php echo htmlspecialchars($servicePrice);?>">
                        <input type="hidden" name="idServico" value="<?php echo htmlspecialchars($serviceId);?>">
                        <input type="hidden" name="idVendedor" value="<?php echo htmlspecialchars($serviceOwner);?>">
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="custom-btn">Finalizar pagamento</button>
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
   header("Location: ../../index.php");
}
?>
