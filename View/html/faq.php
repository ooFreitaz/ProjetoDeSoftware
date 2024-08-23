<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Bem Vindo!</title>
    <link rel="stylesheet" href="../css/faqs.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
<?php session_start();

if(isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    echo "<p>Usuário não está logado.</p>";
    exit();
}

require ('../../Controller/conexao.php');

function listarRegistro($conexao, $id) {
    $sql = "SELECT * FROM editor WHERE id=:id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

$registro = listarRegistro($conexao, $id);?>

  <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="nav.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <h3>FindEditor</h3>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="nav.php" class="nav-link px-2 link-body-emphasis">Home</a></li>
          <li><a href="contato.php" class="nav-link px-2 link-body-emphasis">Contato</a></li>
          <li><a href="sobre.php" class="nav-link px-2 link-body-emphasis">Sobre</a></li>
          <li><a href="faq.php" class="nav-link px-2 link-secondary">FAQ</a></li>
        </ul>


        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../uploads/<?php echo $registro['foto_perfil']; ?>" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="perfil.php">Perfil</a></li>
            <li><a class="dropdown-item" href="#">Criar Serviço</a></li>
            <li><a class="dropdown-item" href="#">Meus Serviços</a></li>
            <li><a class="dropdown-item" href="#">Favoritos</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Log out</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>



  <div class="container">
    <div id="div2">
        <div class="parte2">
            <h1>Compre tranquilamente</h1>
            Todas as compras estão seguradas <br> automaticamente pelo FindEditor. <br> Aqui o cliente nunca perde!
            <div class="numescondido">01.</div>
        </div>
        <div class="parte2">
            <h1>Como funciona o pagamento?</h1>
            O pagamento é feito através da plataforma e é <br> mantido em custódia até a aprovação do projeto.
            <div class="numescondido">02.</div>
        </div>
        <div class="parte2">
            <h1>A plataforma oferece <br>suporte ao cliente?</h1>
            <p>Sim, oferecemos suporte por e-mail, chat ao vivo e formulário de contato.</p>
            <div class="numescondido">03.</div>
        </div>
        <div class="parte2">
            <h1>Quanto tempo eu <br>possuo para reclamar?</h1>
            <p>O prazo para solicitar o cancelamento é o <br>prazo determinado para entrega, após <br>encerrado o prazo, o comprador pode <br>cancelar a compra unilateralmente <br>afetando a reputação do vendedor.</p>
            <div class="numescondido">04.</div>
        </div>
        <div class="parte2">
            <h1>Vou receber todo o <br>valor pago mesmo?</h1>
            <p>Sim, se o freelancer não entregar no prazo <br> determinado, o FindEditor garante ao comprador <br>100% do valor pago em crédito para compra na plataforma</p>
            <div class="numescondido">05.</div>
        </div>
        <div class="parte2">
            <h1>A plataforma é segura?</h1>
            <p>Sim, utilizamos criptografia e medidas de <br>segurança para proteger seus dados.</p>
            <div class="numescondido">06.</div>
        </div>
    </div>
  </div>







  
  <div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
      <div class="col-md-4 d-flex align-items-center">
        <a href="" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
          <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"/></svg>
        </a>
        <span class="mb-3 mb-md-0 text-body-secondary">&copy; 2024 FindEditor, Inc</span>
      </div>
  
      <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"/></svg></a></li>
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"/></svg></a></li>
        <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"/></svg></a></li>
      </ul>
    </footer>
  </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
