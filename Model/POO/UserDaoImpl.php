<?php

require_once 'Connection.php';
require_once 'UserDao.php';
require_once 'User.php';

class UserDaoImpl implements UserDao {
    private $conn;

    public function __construct() {
        $this->conn = (new Connection())->getConnection();
    }

    public function getAllUsers() {
        try {
            $statement = $this->conn->prepare("SELECT * FROM usuario");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'User');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getUser($id) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM usuario WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            return $statement->fetchObject('User');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function createUser($user) {
        try {
            $statement = $this->conn->prepare("INSERT INTO usuario (nome, cpf, email, senha, fotoPerfil) VALUES (:nome, :cpf, :email, :senha, :fotoPerfil)");
    
            // Criando variáveis para armazenar os valores
            $nome = $user->getNome();
            $cpf = $user->getCpf();
            $email = $user->getEmail();
            $senha = $user->getSenha();
            $fotoPerfil = $user->getFotoPerfil(); // Isso será NULL no momento da inserção
    
            // Usando as variáveis para o bindParam
            $statement->bindParam(':nome', $nome);
            $statement->bindParam(':cpf', $cpf);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':senha', $senha);
            $statement->bindParam(':fotoPerfil', $fotoPerfil); // NULL para a foto de perfil
    
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    

    public function updateUser($user) {
        try {
            $statement = $this->conn->prepare("UPDATE usuario SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, fotoPerfil = :fotoPerfil WHERE id = :id");
            $statement->bindParam(':id', $user->getId());
            $statement->bindParam(':nome', $user->getNome());
            $statement->bindParam(':cpf', $user->getCpf());
            $statement->bindParam(':email', $user->getEmail());
            $statement->bindParam(':senha', $user->getSenha());
            $statement->bindParam(':fotoPerfil', $user->getFotoPerfil());
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteUser($id) {
        try {
            $statement = $this->conn->prepare("DELETE FROM usuario WHERE id = :id");
            $statement->bindParam(':id', $id);
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function login($email, $senha) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha");
            $statement->bindParam(':email', $email);
            $statement->bindParam(':senha', $senha);
            $statement->execute();
            return $statement->fetchObject('User');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }

    public function emailExists($email) {
        try {
            $statement = $this->conn->prepare("SELECT COUNT(*) FROM usuario WHERE email = :email");
            $statement->bindParam(':email', $email);
            $statement->execute();
            
            // Retorna true se o e-mail já existe, false caso contrário
            return $statement->fetchColumn() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
}

?>
