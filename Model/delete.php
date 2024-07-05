<?php
require ('../Controller/conexao.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    function deletarRegistro($conexao, $id) {
        $sql = "DELETE FROM usuario WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    if (deletarRegistro($conexao, $id)) {
        echo "
        <script type=\"text/javascript\">
            alert(\"Conta deletada com sucesso.\");
        </script>";
        header("refresh: 1; url=../View/html/cadastro.php");
        exit();
    } else {
        echo "
        <script type=\"text/javascript\">
            alert(\"Erro ao deletar a conta.\");
        </script>";
        header("refresh: 1; url=../View/html/perfil.php");
    }
}
?>