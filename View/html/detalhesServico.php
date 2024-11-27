<?php
session_start();

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $serviceId = $_GET['id'];
} else {
    header("Location: logintela.php");
    exit();
}

require_once '../../Model/UserDaoImpl.php';
require_once '../../Model/ServiceDaoImpl.php';

$userDao = new UserDaoImpl();

$registro = $userDao->getUser($userId);

$serviceDao = new ServiceDaoImpl();

$detalhesServico = $serviceDao->getServiceDetails($serviceId);


if ($detalhesServico) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Serviço</title>
    <link rel="stylesheet" href="../css/detalhesServicos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Header -->
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
                <!-- Foto do perfil do usuário logado -->
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
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


<div class="container">
    <div class="row">

        <div class="col-md-6">
            <img src="../../uploads/<?php echo htmlspecialchars($detalhesServico['imagens']); ?>" class="img-fluid serviceImg" alt="Imagem do serviço">
        </div>

        <div class="col-md-6 d-flex justify-content-center flex-column align-items-center">
            <div class="serviceInfo">
                <h3 class="form-title"><?php echo htmlspecialchars($detalhesServico['titulo']); ?></h3>
                <img src="../../uploads/<?php echo ($detalhesServico['fotoDono']); ?>" onerror="this.src='../../uploads/perfil_padrao.jpg'" width="64" height="64" class="rounded-circle mb-3">
                <p class="form-label"><strong>Dono:</strong> <?php echo htmlspecialchars($detalhesServico['nomeDono']); ?></p>
                <p class="form-label"><strong>Descrição:</strong> <?php echo htmlspecialchars($detalhesServico['descricao']); ?></p>
                <p class="form-label"><strong>Prazo de Entrega:</strong> <?php echo htmlspecialchars($detalhesServico['prazoEntrega']); ?></p>
                <p class="form-label"><strong>Valor Final:</strong> R$<?php echo htmlspecialchars($detalhesServico['valor'] * 1.05); ?> </p>
                <p>Taxa de 5% já aplicada</p>
                <a href="cartao.php?id=<?php echo $serviceId; ?>&valor=<?php echo htmlspecialchars($detalhesServico['valor'] * 1.05); ?>&idDono=<?php echo $detalhesServico['idDono']; ?>"><button class="custom-btn" href="cartao.php">Finalizar Compra</button></a>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <div class="col-md-4 d-flex align-items-center">
        <a href="" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
          <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
        </a>
        <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2024 FindEditor, Inc</span>
      </div>
  
      <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
      </ul>
    </footer>
  </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
} else {
    echo "<p>Serviço não encontrado.</p>";
}
?>
