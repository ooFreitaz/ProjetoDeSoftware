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
    
            $nome = $user->getNome();
            $cpf = $user->getCpf();
            $email = $user->getEmail();
            $senha = $user->getSenha();
            $fotoPerfil = $user->getFotoPerfil(); // Isso será NULL no momento da inserção
    
            $statement->bindParam(':nome', $nome);
            $statement->bindParam(':cpf', $cpf);
            $statement->bindParam(':email', $email);
            $statement->bindParam(':senha', $senha);
            $statement->bindParam(':fotoPerfil', $fotoPerfil);
    
            $statement->execute();
    
            // Retorna o ID do usuário recém-criado
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
        

    public function updateUser($user) {
        try {
            // Preparar a query dependendo se a foto de perfil foi enviada ou não
            if ($user->getFotoPerfil()) {
                $sql = "UPDATE usuario SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, fotoPerfil = :fotoPerfil WHERE id = :id";
            } else {
                $sql = "UPDATE usuario SET nome = :nome, cpf = :cpf, email = :email, senha = :senha WHERE id = :id";
            }
    
            $statement = $this->conn->prepare($sql);
    
            // Atribuir valores aos parâmetros
            $statement->bindValue(':nome', $user->getNome());
            $statement->bindValue(':cpf', $user->getCpf());
            $statement->bindValue(':email', $user->getEmail());
            $statement->bindValue(':senha', $user->getSenha());
            $statement->bindValue(':id', $user->getId(), PDO::PARAM_INT);
    
            // Se a foto de perfil estiver presente, atribuí-la ao parâmetro
            if ($user->getFotoPerfil()) {
                $statement->bindValue(':fotoPerfil', $user->getFotoPerfil());
            }
    
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
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
