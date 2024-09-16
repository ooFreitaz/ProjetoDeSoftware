<?php
session_start();

if (isset($_SESSION['id'])) {
    $idUsuario = $_SESSION['id'];
} else {
    header("Location: logintela.php");
    exit();
}

require('../Controller/conexao.php');

if (isset($_GET['id'])) {
    $idServico = $_GET['id'];

    // Verifica se o serviço pertence ao usuário logado
    $sql = "SELECT * FROM servico WHERE id = :idServico AND dono_servico = :idUsuario";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':idServico', $idServico, PDO::PARAM_INT);
    $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
    $stmt->execute();

    $servico = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($servico) {
        // Se o serviço pertence ao usuário, delete
        $sql = "DELETE FROM servico WHERE id = :idServico";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':idServico', $idServico, PDO::PARAM_INT);
        $stmt->execute();

        // Redireciona após a exclusão
        echo "
        <script type=\"text/javascript\">
            alert(\"Serviço excluído.\");
        </script>";
        header("refresh: 1; url=../View/html/meusServicos.php");
        exit();
    } else {
        // Se o serviço não pertence ao usuário
        echo "
        <script type=\"text/javascript\">
            alert(\"Servico não encontrado.\");
        </script>";
        header("refresh: 1; url=../View/html/meusServicos.php");
        exit();
    }
} else {
    header("Location: meusServicos.php");
    exit();
}
?>
