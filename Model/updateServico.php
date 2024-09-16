<?php
require ('../Controller/conexao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["idServico"], $_POST["titulo"], $_POST["descricao"], $_POST["categoria"], $_POST["valor"], $_POST["prazoEntrega"])) {
        $idServico = $_POST["idServico"];
        $titulo = $_POST["titulo"];
        $descricao = $_POST["descricao"];
        $categoria = $_POST["categoria"];
        $valor = $_POST["valor"];
        $prazoEntrega = $_POST["prazoEntrega"];

        // Inicializar variável para o caminho da imagem do serviço
        $imagem = null;

        // Processar a imagem se enviada
        if (isset($_FILES['imagens']) && $_FILES['imagens']['error'] === UPLOAD_ERR_OK) {
            $diretorio_upload = '../uploads/';
            $nome_arquivo = basename($_FILES['imagens']['name']);
            $caminho_arquivo = $diretorio_upload . $nome_arquivo;

            // Mover o arquivo para o diretório de upload
            if (move_uploaded_file($_FILES['imagens']['tmp_name'], $caminho_arquivo)) {
                $imagem = $caminho_arquivo;
            }
        }

        // Função para Atualizar o serviço no banco de dados
        function atualizarServico($conexao, $idServico, $titulo, $descricao, $categoria, $valor, $prazoEntrega, $imagem) {
            if ($imagem) {
                $sql = "UPDATE servico SET titulo = :titulo, descricao = :descricao, categoria = :categoria, valor = :valor, prazoEntrega = :prazoEntrega, imagens = :imagem WHERE id = :idServico";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':imagem', $imagem);
            } else {
                $sql = "UPDATE servico SET titulo = :titulo, descricao = :descricao, categoria = :categoria, valor = :valor, prazoEntrega = :prazoEntrega WHERE id = :idServico";
                $stmt = $conexao->prepare($sql);
            }
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':categoria', $categoria);
            $stmt->bindParam(':valor', $valor);
            $stmt->bindParam(':prazoEntrega', $prazoEntrega);
            $stmt->bindParam(':idServico', $idServico, PDO::PARAM_INT);
            return $stmt->execute();
        }

        if (atualizarServico($conexao, $idServico, $titulo, $descricao, $categoria, $valor, $prazoEntrega, $imagem)) {
            echo "
            <script type=\"text/javascript\">
                alert(\"Serviço atualizado com sucesso!\");
                window.location.href = \"../View/html/meusServicos.php\";
            </script>";
        } else {
            echo "
            <script type=\"text/javascript\">
                alert(\"Erro ao atualizar serviço.\");
                window.location.href = \"../View/html/meusServicos.php\";
            </script>";
        }
    } else {
        echo "Campos obrigatórios não foram preenchidos.";
    }
}
?>
