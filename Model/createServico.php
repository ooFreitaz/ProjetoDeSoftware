<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo "<p>Usuário não está logado.</p>";
    exit();
}

require('../Controller/conexao.php');

// Função para inserir dados no banco de dados
function inserirServico($conexao, $titulo, $valor, $categoria, $descricao, $prazoEntrega, $imagens, $linksYoutube, $idDono) {
    $sql = "INSERT INTO servico (titulo, valor, categoria, descricao, prazoEntrega, imagens, linksYoutube, idDono) 
            VALUES (:titulo, :valor, :categoria, :descricao, :prazoEntrega, :imagens, :linksYoutube, :idDono)";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':prazoEntrega', $prazoEntrega);
    $stmt->bindParam(':imagens', $imagens);
    $stmt->bindParam(':linksYoutube', $linksYoutube);
    $stmt->bindParam(':idDono', $idDono);
    
    return $stmt->execute();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $titulo = $_POST['titulo'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $prazoEntrega = $_POST['prazoEntrega'];
    $linksYoutube = $_POST['link'];
    $idDono = $_SESSION['id'];

    // Upload de imagem
    $imagens = NULL; 
    if (isset($_FILES['imagemServico']) && $_FILES['imagemServico']['error'] == 0) {
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($_FILES['imagemServico']['name']);
        if (move_uploaded_file($_FILES['imagemServico']['tmp_name'], $uploadFile)) {
            $imagens = basename($_FILES['imagemServico']['name']);
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem.');</script>";
            header("refresh: 1; url=../View/html/criarServico.php");
            exit();
        }
    }

    // Insere o serviço no banco de dados
    if (inserirServico($conexao, $titulo, $valor, $categoria, $descricao, $prazoEntrega, $imagens, $linksYoutube, $idDono)) {
        echo "<script>alert('Serviço criado com sucesso!');</script>";
        header("refresh: 1; url=../View/html/criarServico.php");
        exit();
    } else {
        echo "<script>alert('Erro ao criar serviço');</script>";
        header("refresh: 1; url=../View/html/criarServico.php");
    }
}
?>
