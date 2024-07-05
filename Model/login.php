<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BD_PROJETOSOFTWARE";

$conn = new mysqli($servername, $username, $password, $dbname);

session_start();

if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['senha'];

$sql = "SELECT * FROM usuario WHERE email='$email' AND senha='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id = $row['id'];
    $nome = $row['nome'];
    $_SESSION['id'] = $id;
    $_SESSION['nome'] = $nome;

    echo "
        <script type=\"text/javascript\">
            alert(\"Bem vindo {$nome}\");
        </script>
    ";

    header("refresh: 1; url=../View/html/nav_logado.php");
    exit();
} else {
    echo "
        <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=../View/html/logintela.php'>
        <script type=\"text/javascript\">
            alert(\"Email ou senha incorretos!\");
        </script>
    ";
}

$conn->close();
?>