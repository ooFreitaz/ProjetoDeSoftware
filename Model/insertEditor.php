<?php
require ('../Controller/conexao.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    function inserirRegistro($conexao, $nome, $cpf, $email, $senha) {
        // Verificar se o email já existe
        $sql_verifica = "SELECT COUNT(*) AS total FROM editor WHERE email = :email";
        $stmt_verifica = $conexao->prepare($sql_verifica);
        $stmt_verifica->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_verifica->execute();
        $resultado = $stmt_verifica->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado['total'] > 0) {
            // Se o email já existe, retornar false
            return false;
        } else {
            // Se o email não existe, proceder com a inserção
            $sql = "INSERT INTO editor (nome, cpf, email, senha) VALUES (:nome, :cpf, :email, :senha)";
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
            $stmt->execute();
            return $conexao->lastInsertId(); // Retorna o ID do usuário inserido
        }
    }
    $userId = inserirRegistro($conexao, $nome, $cpf, $email, $senha);
    if ($userId !== false) {
    // Registro inserido com sucesso
    $_SESSION['id'] = $userId;
    $_SESSION['nome'] = $nome;

    echo "
    <script type=\"text/javascript\">
        alert(\"Registrado com sucesso!.\");
    </script>";

    header("refresh: 1; url=../View/html/nav.php");
    exit();
    } else {
    // Email já cadastrado
    echo "
    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../View/html/cadastroEditor.php'>
    <script type=\"text/javascript\">
        alert(\"Erro: Este email já está em uso.\");
    </script>
    ";
    }
}
?>