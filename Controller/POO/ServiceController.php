<?php

require_once '../Model/Service.php';
require_once '../Model/ServiceDaoImpl.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$serviceDao = new ServiceDaoImpl();
$service = new Service();

switch ($action) {
    case 'create_service':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->setTitulo($_POST['titulo']);
            $service->setValor($_POST['valor']);
            $service->setCategoria($_POST['categoria']);
            $service->setDescricao($_POST['descricao']);
            $service->setPrazoEntrega($_POST['prazoEntrega']);
            $service->setImagens($_POST['imagens']);
            $service->setLinksYoutube($_POST['linksYoutube']);
            $service->setDonoServico($_POST['dono_servico']);
        
            if ($serviceDao->createService($service)) {
                echo 'Serviço criado com sucesso!<br>Volte à página de serviços: <a href="../View/services.php">Retornar</a>';
            } else {
                echo 'Erro ao criar o serviço.';
            }
        }
        break;

    case 'update_service':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->setId($_POST['id']);
            $service->setTitulo($_POST['titulo']);
            $service->setValor($_POST['valor']);
            $service->setCategoria($_POST['categoria']);
            $service->setDescricao($_POST['descricao']);
            $service->setPrazoEntrega($_POST['prazoEntrega']);
            $service->setImagens($_POST['imagens']);
            $service->setLinksYoutube($_POST['linksYoutube']);
            $service->setDonoServico($_POST['dono_servico']);

            if ($serviceDao->updateService($service)) {
                echo 'Serviço atualizado com sucesso!<br>';
            } else {
                echo 'Erro ao atualizar o serviço.';
            }
        }
        break;

    case 'delete_service':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            
            if ($serviceDao->deleteService($id)) {
                echo 'Serviço deletado com sucesso!<br>';
            } else {
                echo 'Erro ao deletar o serviço.';
            }
        }
        break;

    default:
        echo 'Ação inválida.';
        break;
}

?>
