<?php

date_default_timezone_set('America/Sao_Paulo');

require_once '../Model/Order.php';
require_once '../Model/OrderDaoImpl.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$orderDao = new OrderDaoImpl();
$order = new Order();



switch ($action) {
    case 'create_order':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $order->setIdComprador($_SESSION['id']);
            $order->setIdVendedor($_POST['idVendedor']);
            $order->setIdServico($_POST['idServico']);
            $order->setDataCompra(date('Y-m-d H:i:s'));
            $order->setValorFinal($_POST['valorFinal']);
        
            $orderId = $orderDao->createOrder($order); // Retorna o ID do pedido
        
            if ($orderId) {
                echo '<script type="text/javascript">
                        alert("Pedido feito com sucesso! Número do Pedido: ' . $orderId . '");
                        window.location.href="../View/html/servicosComprados.php";
                      </script>';
            } else {
                echo '<script type="text/javascript">
                        alert("Erro ao finalizar pedido!");
                        window.location.href="../View/html/cartao.php";
                      </script>';
            }
        }
        break;

    default:
        echo "Ação inválida.";
        break;
}
?>
