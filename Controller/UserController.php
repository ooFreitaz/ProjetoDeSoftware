<?php

require_once '../Model/User.php';
require_once '../Model/UserDaoImpl.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$userDao = new UserDaoImpl();
$user = new User();

switch ($action) {
    case 'create_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
    
            // Verifica se o e-mail já existe
            if ($userDao->emailExists($email)) {
                echo '<script type="text/javascript">
                        alert("E-mail já cadastrado. Tente outro.");
                        window.location.href="../View/html/cadastro.php";
                      </script>';
            } else {
                $user->setNome($_POST['nome']);
                $user->setCpf($_POST['cpf']);
                $user->setEmail($email);
                $user->setSenha($_POST['senha']);
                $user->setFotoPerfil(null); 
    
                // Cria o usuário e recebe o ID do usuário recém-criado
                $newUserId = $userDao->createUser($user);
    
                if ($newUserId) {
                    // Inicia a sessão e salva o ID do usuário
                    session_start();
                    $_SESSION['id'] = $newUserId;
                    
                    // Redireciona para a página nav.php
                    header('Location: ../View/html/nav.php');
                    exit();
                } else {
                    echo '<script type="text/javascript">
                        alert("Erro ao criar usuário.");
                        window.location.href="../View/html/cadastro.php";
                      </script>';
                }
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
                $_SESSION['id'] = $user->getId();
                echo '<script type="text/javascript">
                        alert("Seja bem vindo.");
                        window.location.href="../View/html/nav.php";
                     </script>';
                exit();
            } else {
                echo '<script type="text/javascript">
                        alert("Email ou senha incorretos.");
                        window.location.href="../View/html/logintela.php";
                      </script>';
            }
        }
        break;

    case 'update_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $userId = $_SESSION['id'];
            $user = $userDao->getUser($userId);
    
            if ($user) {
                $user->setNome($_POST['nome']);
                $user->setCpf($_POST['cpf']);
                $user->setEmail($_POST['email']);
                $user->setSenha($_POST['senha']);
    
                // Processar a imagem de perfil se enviada
                if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] === UPLOAD_ERR_OK) {
                    $diretorio_upload = '../uploads/';
                    $nome_arquivo = basename($_FILES['fotoPerfil']['name']);
                    $caminho_arquivo = $diretorio_upload . $nome_arquivo;
    
                    // Mover o arquivo para o diretório de upload
                    if (move_uploaded_file($_FILES['fotoPerfil']['tmp_name'], $caminho_arquivo)) {
                        $user->setFotoPerfil($nome_arquivo);
                    }
                }
    
                if ($userDao->updateUser($user)) {
                    echo '<script type="text/javascript">
                            alert("Informações alteradas com sucesso!");
                            window.location.href = "../View/html/perfil.php";
                          </script>';
                } else {
                    echo '<script type="text/javascript">
                            alert("Erro ao alterar informações.");
                            window.location.href = "../View/html/perfil.php";
                          </script>';
                }
            }
        }
        break;
        
        

    case 'delete_user':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            
            if ($userDao->deleteUser($id)) {
                echo '<script type="text/javascript">
                        alert("Conta deletada com sucesso.");
                        window.location.href="../../index.php";
                      </script>';
            } else {
                echo '<script type="text/javascript">
                        alert("Erro ao deletar conta.");
                        window.location.href="../../index.php";
                      </script>';
            }
        }
        break;

    case 'logout':

        $userDao->logout();
        header('Location: ../../index.php');
        exit();
        break;

    default:
        echo '<script type="text/javascript">
                alert("Ação inválida.");
              </script>';
        break;
}

?>
