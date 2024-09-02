<?php

require_once '../Model/User.php';
require_once '../Model/UserDaoImpl.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$userDao = new UserDaoImpl();
$user = new User();

switch ($action) {
    case 'create_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->setNome($_POST['nome']);
            $user->setCpf($_POST['cpf']);
            $user->setEmail($_POST['email']);
            $user->setSenha($_POST['senha']);
            $user->setFotoPerfil($_POST['fotoPerfil']);
        
            if ($userDao->createUser($user)) {
                echo 'Usuário criado com sucesso!<br>Volte à página de login: <a href="../View/login.php">Retornar</a>';
            } else {
                echo 'Erro ao criar o usuário.';
            }
        }
        break;

    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            
            $user = $userDao->login($email, $senha);
            if ($user) {
                session_start();
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['user_name'] = $user->getNome();
                $_SESSION['user_email'] = $user->getEmail();
                header('Location: ../View/dashboard.php');
                exit();
            } else {
                echo 'E-mail ou senha incorretos<br><a href="../View/login.php">Voltar à página de login</a>';
            }
        }
        break;

    case 'update_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->setId($_POST['id']);
            $user->setNome($_POST['nome']);
            $user->setCpf($_POST['cpf']);
            $user->setEmail($_POST['email']);
            $user->setSenha($_POST['senha']);
            $user->setFotoPerfil($_POST['fotoPerfil']);

            if ($userDao->updateUser($user)) {
                echo 'Usuário atualizado com sucesso!<br>';
            } else {
                echo 'Erro ao atualizar o usuário.';
            }
        }
        break;

    case 'delete_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            
            if ($userDao->deleteUser($id)) {
                echo 'Usuário deletado com sucesso!<br>';
            } else {
                echo 'Erro ao deletar o usuário.';
            }
        }
        break;

    default:
        echo 'Ação inválida.';
        break;
}

?>
