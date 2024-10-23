<?php
session_start();

if (isset($_SESSION['id'])) {
    $id = $_SESSION['id']; // ID do usuário logado
} else {
    header("Location: logintela.php");
    exit();
}

require('../../Controller/conexao.php');

// Função para listar os detalhes do serviço específico
function listarDetalhesServico($conexao, $idServico) {
    $sql = "SELECT servico.*, usuario.nome AS nomeDono, usuario.fotoPerfil AS fotoDono
            FROM servico
            JOIN usuario ON servico.idDono = usuario.id
            WHERE servico.id = :idServico";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idServico', $idServico, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Função para buscar a foto de perfil do usuário logado
function buscarFotoPerfil($conexao, $idUsuario) {
    $sql = "SELECT fotoPerfil FROM usuario WHERE id = :idUsuario";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['fotoPerfil'];
}

// Verifica se o ID do serviço foi passado na URL
if (isset($_GET['id'])) {
    $idServico = $_GET['id'];
    $detalhesServico = listarDetalhesServico($conexao, $idServico);
    $fotoPerfilLogado = buscarFotoPerfil($conexao, $id); // Busca a foto do usuário logado
} else {
    header("Location: nav.php");
    exit();
}

if ($detalhesServico) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Serviço</title>
    <link rel="stylesheet" href="../css/nav.css">
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
                <li><a href="nav.php" class="nav-link px-2 link-secondary">Home</a></li>
                <li><a href="contato.php" class="nav-link px-2 link-body-emphasis">Contato</a></li>
                <li><a href="sobre.php" class="nav-link px-2 link-body-emphasis">Sobre</a></li>
                <li><a href="faq.php" class="nav-link px-2 link-body-emphasis">FAQ</a></li>
            </ul>

            <div class="dropdown text-end">
                <!-- Foto do perfil do usuário logado -->
                <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../../uploads/<?php echo $fotoPerfilLogado; ?>" onerror="this.src='../../uploads/perfil_padrao.jpg'" width="32" height="32" class="rounded-circle">
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

<form id="logout-form" action="../../Controller/POO/UserController.php?action=logout" method="POST" style="display: none;">
    <input type="hidden" name="logout" value="1">
</form>

<!-- Conteúdo da página de detalhes do serviço -->
<div class="container">
    <h2>Detalhes do Serviço</h2>
    <div class="row">
        <div class="col-md-6">
            <img src="../../uploads/<?php echo htmlspecialchars($detalhesServico['imagens']); ?>" class="img-fluid" alt="Imagem do serviço">
        </div>
        <div class="col-md-6">
            <h3><?php echo htmlspecialchars($detalhesServico['titulo']); ?></h3>
            <p><strong>Dono:</strong> <?php echo htmlspecialchars($detalhesServico['nomeDono']); ?></p>
            <!-- Exibindo a foto do dono do serviço -->
            <img src="../../uploads/<?php echo ($detalhesServico['fotoDono']); ?>" onerror="this.src='../../uploads/perfil_padrao.jpg'" width="64" height="64" class="rounded-circle mb-3">
            <p><strong>Descrição:</strong> <?php echo htmlspecialchars($detalhesServico['descricao']); ?></p>
            <p><strong>Valor:</strong> R$<?php echo htmlspecialchars($detalhesServico['valor']); ?></p>
            <button class="btn btn-primary">Finalizar Compra</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
} else {
    echo "<p>Serviço não encontrado.</p>";
}
?>
