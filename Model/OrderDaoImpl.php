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
            $statement->execute();

            return $this->conn->lastInsertId(); 
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function getOrdersByBuyer($idComprador) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM compra WHERE idComprador = :idComprador");
            $statement->bindValue(':idComprador', $idComprador);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'Order');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getOrdersBySeller($idVendedor) {
        try {
            $statement = $this->conn->prepare("SELECT * FROM compra WHERE idVendedor = :idVendedor");
            $statement->bindValue(':idVendedor', $idVendedor);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_CLASS, 'Order');
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
 
}
?>
