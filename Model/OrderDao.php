<?php
interface OrderDao {

    public function createOrder($order);
    public function getOrdersByBuyer($idComprador);
    public function getOrdersBySeller($idVendedor);
}
?>
