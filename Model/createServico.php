<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo "<p>Usuário não está logado.</p>";
    exit();
}

require('../Controller/conexao.php');

// Função para inserir dados no banco de dados
function inserirServico($conexao, $titulo, $valor, $categoria, $descricao, $prazoEntrega, $imagens, $linksYoutube, $dono_servico) {
    $sql = "INSERT INTO servico (titulo, valor, categoria, descricao, prazoEntrega, imagens, linksYoutube, dono_servico) 
            VALUES (:titulo, :valor, :categoria, :descricao, :prazoEntrega, :imagens, :linksYoutube, :dono_servico)";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':prazoEntrega', $prazoEntrega);
    $stmt->bindParam(':imagens', $imagens);
    $stmt->bindParam(':linksYoutube', $linksYoutube);
    $stmt->bindParam(':dono_servico', $dono_servico);
    
    return $stmt->execute();
}

// Recebe os dados do formulário
$titulo = $_POST['titulo'];
$valor = $_POST['valor'];
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao']; // Agora capturando a descrição do formulário
$prazoEntrega = $_POST['prazoEntrega'];
$linksYoutube = $_POST['link'];
$dono_servico = $_SESSION['id']; // Assume que o ID do usuário logado está na sessão

// Lida com o upload de imagem, se houver
$imagens = NULL; // Inicializa como NULL
if (isset($_FILES['imagemServico']) && $_FILES['imagemServico']['error'] == 0) {
    $uploadDir = '../uploads/';
    $uploadFile = $uploadDir . basename($_FILES['imagemServico']['name']);
    if (move_uploaded_file($_FILES['imagemServico']['tmp_name'], $uploadFile)) {
        $imagens = basename($_FILES['imagemServico']['name']);
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao fazer upload da imagem.\");
        </script>
    ";

    header("refresh: 1; url=../View/html/criarServico.php");
    exit();
    }
}

// Insere o serviço no banco de dados
if (inserirServico($conexao, $titulo, $valor, $categoria, $descricao, $prazoEntrega, $imagens, $linksYoutube, $dono_servico)) {
    echo "
        <script type=\"text/javascript\">
            alert(\"Serviço criado com sucesso!\");
        </script>
    ";

    header("refresh: 1; url=../View/html/criarServico.php");
    exit();
} else {
    echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao criar Serviço\");
        </script>
    ";

    header("refresh: 1; url=../View/html/criarServico.php");
    
}
?>
