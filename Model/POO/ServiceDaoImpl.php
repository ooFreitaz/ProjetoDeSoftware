<?php

require_once 'Connection.php';
require_once 'ServiceDao.php';
require_once 'Service.php';

class ServiceDaoImpl implements ServiceDao {
    private $conn;

    public function __construct() {
        $this->conn = (new Connection())->getConnection();
    }

    public function getAllServices() {
        try {
            $statement = $this->conn->prepare("SELECT * FROM servico");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'Service');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getService($id) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM servico WHERE id = :id");
            $statement->bindParam(':id', $id);
            $statement->execute();
            return $statement->fetchObject('Service');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function createService($service) {
        try {
            $statement = $this->conn->prepare("INSERT INTO servico (titulo, valor, categoria, descricao, prazoEntrega, imagens, linksYoutube, dono_servico) VALUES (:titulo, :valor, :categoria, :descricao, :prazoEntrega, :imagens, :linksYoutube, :dono_servico)");
            $statement->bindParam(':titulo', $service->getTitulo());
            $statement->bindParam(':valor', $service->getValor());
            $statement->bindParam(':categoria', $service->getCategoria());
            $statement->bindParam(':descricao', $service->getDescricao());
            $statement->bindParam(':prazoEntrega', $service->getPrazoEntrega());
            $statement->bindParam(':imagens', $service->getImagens());
            $statement->bindParam(':linksYoutube', $service->getLinksYoutube());
            $statement->bindParam(':dono_servico', $service->getDonoServico());
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateService($service) {
        try {
            $statement = $this->conn->prepare("UPDATE servico SET titulo = :titulo, valor = :valor, categoria = :categoria, descricao = :descricao, prazoEntrega = :prazoEntrega, imagens = :imagens, linksYoutube = :linksYoutube, dono_servico = :dono_servico WHERE id = :id");
            $statement->bindParam(':id', $service->getId());
            $statement->bindParam(':titulo', $service->getTitulo());
            $statement->bindParam(':valor', $service->getValor());
            $statement->bindParam(':categoria', $service->getCategoria());
            $statement->bindParam(':descricao', $service->getDescricao());
            $statement->bindParam(':prazoEntrega', $service->getPrazoEntrega());
            $statement->bindParam(':imagens', $service->getImagens());
            $statement->bindParam(':linksYoutube', $service->getLinksYoutube());
            $statement->bindParam(':dono_servico', $service->getDonoServico());
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteService($id) {
        try {
            $statement = $this->conn->prepare("DELETE FROM servico WHERE id = :id");
            $statement->bindParam(':id', $id);
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
