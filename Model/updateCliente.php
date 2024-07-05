<?php
require ('../Controller/conexao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["nome"], $_POST["email"], $_POST["senha"])) {
        $id = $_SESSION['id'];
        $nome = $_POST["nome"];
        $email= $_POST["email"];
        $senha = $_POST["senha"];

        // Função para Atualizar o registro no banco de dados
        function atualizarRegistro($conexao, $id, $nome, $email, $senha) {
            $sql = "UPDATE cliente SET nome = :nome, email = :email, senha = :senha WHERE id = :id";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        if (atualizarRegistro($conexao, $id, $nome, $email, $senha)) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Informações alteradas com sucesso!\");
                window.location.href = \"../View/html/perfil.php\";
            </script>";
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao alterar informações\");
                window.location.href = \"../View/html/perfil.php\";
            </script>";
        }
    } else {
        echo "Campos obrigatórios não foram preenchidos.";
    }
}
?>
