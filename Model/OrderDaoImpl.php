<?php
require_once 'Connection.php';
require_once 'OrderDao.php';
require_once 'Order.php';

class OrderDaoImpl implements OrderDao {
    private $conn;

    public function __construct() {
        $this->conn = (new Connection())->getConnection();
    }

    public function createOrder($order) {
        try {
            $statement = $this->conn->prepare("
                INSERT INTO compra (idComprador, idVendedor, idServico, dataCompra, valorFinal)
                VALUES (:idComprador, :idVendedor, :idServico, :dataCompra, :valorFinal)
            ");
            $statement->bindValue(':idComprador', $order->getIdComprador());
            $statement->bindValue(':idVendedor', $order->getIdVendedor());
            $statement->bindValue(':idServico', $order->getIdServico());
            $statement->bindValue(':dataCompra', $order->getDataCompra());
            $statement->bindValue(':valorFinal', $order->getValorFinal());
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getOrder($idCompra) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM compra WHERE idCompra = :idCompra");
            $statement->bindValue(':idCompra', $idCompra);
            $statement->execute();
            return $statement->fetchObject('Order');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getAllOrders() {
        try {
            $statement = $this->conn->prepare("SELECT * FROM compra");
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'Order');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getOrdersByUser($idUsuario) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM compra WHERE idComprador = :idUsuario OR idVendedor = :idUsuario");
            $statement->bindValue(':idUsuario', $idUsuario);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'Order');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function deleteOrder($idCompra) {
        try {
            $statement = $this->conn->prepare("DELETE FROM compra WHERE idCompra = :idCompra");
            $statement->bindValue(':idCompra', $idCompra);
            return $statement->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
