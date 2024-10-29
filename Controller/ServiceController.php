<?php

require_once '../Model/Service.php';
require_once '../Model/ServiceDaoImpl.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';
$serviceDao = new ServiceDaoImpl();
$service = new Service();

switch ($action) {
    case 'create_service':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $service->setTitulo($_POST['titulo']);
            $service->setValor($_POST['valor']);
            $service->setCategoria($_POST['categoria']);
            $service->setDescricao($_POST['descricao']);
            $service->setPrazoEntrega($_POST['prazoEntrega']);
            $service->setLinksYoutube($_POST['link']);
            $service->setDonoServico($_SESSION['id']);

            // Tratamento da imagem
            if (isset($_FILES['imagemServico']) && $_FILES['imagemServico']['error'] === UPLOAD_ERR_OK) {
                $diretorio_upload = '../uploads/';
                $nome_arquivo = basename($_FILES['imagemServico']['name']);
                $caminho_arquivo = $diretorio_upload . $nome_arquivo;
                
                if (move_uploaded_file($_FILES['imagemServico']['tmp_name'], $caminho_arquivo)) {
                    $service->setImagens($nome_arquivo);
                }
            }

            if ($serviceDao->createService($service)) {
                echo '<script type="text/javascript">
                        alert("Serviço criado com sucesso!");
                        window.location.href="../View/html/meusServicos.php";
                      </script>';
            } else {
                echo '<script type="text/javascript">
                        alert("Erro ao criar serviço.");
                        window.location.href="../View/html/criarServico.php";
                      </script>';
            }
        }
        break;

    case 'update_service':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $serviceId = $_POST['id'];
            $existingService = $serviceDao->getService($serviceId);

            if ($existingService && $existingService->getDonoServico() == $_SESSION['id']) {
                $service->setId($serviceId);
                $service->setTitulo($_POST['titulo']);
                $service->setValor($_POST['valor']);
                $service->setCategoria($_POST['categoria']);
                $service->setDescricao($_POST['descricao']);
                $service->setPrazoEntrega($_POST['prazoEntrega']);
                $service->setLinksYoutube($_POST['link']);
                $service->setDonoServico($_SESSION['id']);

                // Tratamento da imagem
                if (isset($_FILES['imagemServico']) && $_FILES['imagemServico']['error'] === UPLOAD_ERR_OK) {
                    $diretorio_upload = '../../uploads/';
                    $nome_arquivo = basename($_FILES['imagemServico']['name']);
                    $caminho_arquivo = $diretorio_upload . $nome_arquivo;
                    
                    if (move_uploaded_file($_FILES['imagemServico']['tmp_name'], $caminho_arquivo)) {
                        $service->setImagens($nome_arquivo);
                    }
                } else {
                    $service->setImagens($existingService->getImagens());
                }

                if ($serviceDao->updateService($service)) {
                    echo '<script type="text/javascript">
                            alert("Serviço atualizado com sucesso!");
                            window.location.href="../View/html/meusServicos.php";
                          </script>';
                } else {
                    echo '<script type="text/javascript">
                            alert("Erro ao atualizar serviço.");
                            window.location.href="../View/html/editarServico.php?id=' . $serviceId . '";
                          </script>';
                }
            } else {
                echo '<script type="text/javascript">
                        alert("Você não tem permissão para editar este serviço.");
                        window.location.href="../View/html/meusServicos.php";
                      </script>';
            }
        }
        break;

    case 'delete_service':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();
            $serviceId = $_POST['id'];
            $service = $serviceDao->getService($serviceId);

            if ($service && $service->getDonoServico() == $_SESSION['id']) {
                if ($serviceDao->deleteService($serviceId)) {
                    echo '<script type="text/javascript">
                            alert("Serviço deletado com sucesso!");
                            window.location.href="../View/html/meusServicos.php";
                          </script>';
                } else {
                    echo '<script type="text/javascript">
                            alert("Erro ao deletar serviço.");
                            window.location.href="../View/html/meusServicos.php";
                          </script>';
                }
            } else {
                echo '<script type="text/javascript">
                        alert("Você não tem permissão para deletar este serviço.");
                        window.location.href="../View/html/meusServicos.php";
                      </script>';
            }
        }
        break;

    default:
        echo '<script type="text/javascript">
                alert("Ação inválida.");
              </script>';
        break;
}
?>