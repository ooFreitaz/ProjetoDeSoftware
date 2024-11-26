<?php

require_once 'Connection.php';
require_once 'ServiceDao.php';
require_once 'Service.php';

class ServiceDaoImpl implements ServiceDao {
    private $conn;

    public function __construct() {
        $this->conn = (new Connection())->getConnection();
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
            $statement = $this->conn->prepare("INSERT INTO servico (titulo, valor, categoria, descricao, prazoEntrega, imagens, linksYoutube, idDono) 
                                             VALUES (:titulo, :valor, :categoria, :descricao, :prazoEntrega, :imagens, :linksYoutube, :idDono)");
            
            $titulo = $service->getTitulo();
            $valor = $service->getValor();
            $categoria = $service->getCategoria();
            $descricao = $service->getDescricao();
            $prazoEntrega = $service->getPrazoEntrega();
            $imagens = $service->getImagens();
            $linksYoutube = $service->getLinksYoutube();
            $idDono = $service->getDonoServico();

            $statement->bindParam(':titulo', $titulo);
            $statement->bindParam(':valor', $valor);
            $statement->bindParam(':categoria', $categoria);
            $statement->bindParam(':descricao', $descricao);
            $statement->bindParam(':prazoEntrega', $prazoEntrega);
            $statement->bindParam(':imagens', $imagens);
            $statement->bindParam(':linksYoutube', $linksYoutube);
            $statement->bindParam(':idDono', $idDono);

            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateService($service) {
        try {
            if ($service->getImagens()) {
                $sql = "UPDATE servico SET titulo = :titulo, valor = :valor, categoria = :categoria, 
                        descricao = :descricao, prazoEntrega = :prazoEntrega, imagens = :imagens, 
                        linksYoutube = :linksYoutube WHERE id = :id";
            } else {
                $sql = "UPDATE servico SET titulo = :titulo, valor = :valor, categoria = :categoria, 
                        descricao = :descricao, prazoEntrega = :prazoEntrega, 
                        linksYoutube = :linksYoutube WHERE id = :id";
            }

            $statement = $this->conn->prepare($sql);

            $statement->bindValue(':titulo', $service->getTitulo());
            $statement->bindValue(':valor', $service->getValor());
            $statement->bindValue(':categoria', $service->getCategoria());
            $statement->bindValue(':descricao', $service->getDescricao());
            $statement->bindValue(':prazoEntrega', $service->getPrazoEntrega());
            $statement->bindValue(':linksYoutube', $service->getLinksYoutube());
            $statement->bindValue(':id', $service->getId(), PDO::PARAM_INT);

            if ($service->getImagens()) {
                $statement->bindValue(':imagens', $service->getImagens());
            }

            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
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

    public function getServicesByUser($idUsuario) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM servico WHERE idDono = :idUsuario");
            $statement->bindParam(':idUsuario', $idUsuario);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'Service');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getServiceByUser($idUsuario, $idServico) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM servico WHERE idDono = :idUsuario");
            $statement->bindParam(':idUsuario', $idUsuario);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'Service');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function listServicesFromOtherUsers($idUsuario) {
        try {
            $statement = $this->conn->prepare("SELECT servico.*, usuario.nome AS nomeDono
                                             FROM servico
                                             JOIN usuario ON servico.idDono = usuario.id
                                             WHERE servico.idDono != :idUsuario");
            $statement->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>