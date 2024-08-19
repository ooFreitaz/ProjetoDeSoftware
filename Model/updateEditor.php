<?php
require ('../Controller/conexao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nome"], $_POST["cpf"], $_POST["email"], $_POST["senha"])) {
        $id = $_SESSION['id'];
        $nome = $_POST["nome"];
        $cpf = $_POST["cpf"];
        $email= $_POST["email"];
        $senha = $_POST["senha"];

        // Inicializar variável para o caminho da foto de perfil
        $foto_perfil = null;

        // Processar a imagem de perfil se enviada
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $diretorio_upload = '../uploads/';
            $nome_arquivo = basename($_FILES['foto_perfil']['name']);
            $caminho_arquivo = $diretorio_upload . $nome_arquivo;

            // Mover o arquivo para o diretório de upload
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $caminho_arquivo)) {
                $foto_perfil = $caminho_arquivo;
            }
        }

        // Função para Atualizar o registro no banco de dados
        function atualizarRegistro($conexao, $id, $nome, $cpf, $email, $senha, $foto_perfil) {
            // Preparar a query dependendo se a foto de perfil foi enviada ou não
            if ($foto_perfil) {
                $sql = "UPDATE editor SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, foto_perfil = :foto_perfil WHERE id = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':foto_perfil', $foto_perfil);
            } else {
                $sql = "UPDATE editor SET nome = :nome, cpf = :cpf, email = :email, senha = :senha WHERE id = :id";
                $stmt = $conexao->prepare($sql);
            }
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':cpf', $cpf);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        if (atualizarRegistro($conexao, $id, $nome, $cpf, $email, $senha, $foto_perfil)) {
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
