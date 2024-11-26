<?php
require_once 'Model/ServiceDaoImpl.php';

$serviceDao = new ServiceDaoImpl();

$servicos = $serviceDao->getAllServices();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Bem Vindo!</title>
    <link rel="stylesheet" href="View/css/indexs.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>

<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <div class="col-md-3 mb-2 mb-md-0">
        <a href="#" class="d-inline-flex link-body-emphasis text-decoration-none">
          <h3>FindEditor</h3>
        </a>
      </div>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="View/html/faqDeslogado.php" class="nav-link px-2">FAQ</a></li>
        <li><a href="View/html/sobreDeslogado.php" class="nav-link px-2">Sobre</a></li>
      </ul>

      <div class="col-md-3 text-end">
        <a href="view/html/logintela.php"><button type="button" class="btn btn-outline-primary me-2">Login</button></a>
        <a href="view/html/cadastro.php"><button type="button" class="btn btn-primary">Cadastre-se</button></a>
      </div>
    </header>
</div>

<div class="container">
    <?php if (!empty($servicos)) { ?>
        <div class="row">
            <?php foreach ($servicos as $servico) { ?>
              <div class="col-md-3">
                  <a href="View/html/detalhesServico.php?id=<?php echo $servico['id']; ?>">
                      <div class="card mb-5 shadow-sm">
                          <img src="uploads/<?php echo $servico['imagens']; ?>" class="card-img-top">
                          <div class="card-body">
                              <p class="nomeDono"><?php echo htmlspecialchars($servico['nomeDono']); ?></p>
                              <h5 class="titulo"><?php echo htmlspecialchars($servico['titulo']); ?></h5>
                              <p class="preco">R$<?php echo htmlspecialchars($servico['valor']); ?></p>
                              <p class="dataEntrega"><?php echo htmlspecialchars($servico['prazoEntrega']); ?></p>
                          </div>
                      </div>
                  </a>
              </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <p>Nenhum serviço encontrado.</p>
    <?php } ?>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>