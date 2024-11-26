<?php
interface OrderDao {
    
    public function createOrder($order);
    public function getOrder($idCompra);
    public function getAllOrders();
    public function getOrdersByUser($idUsuario);
    public function deleteOrder($idCompra);
}
?>
