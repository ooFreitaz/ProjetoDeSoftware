<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seja Bem Vindo!</title>
    <link rel="stylesheet" href="../css/navs.css">
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
        <li><a href="nav.php" class="nav-link px-2 link-secondary">Home</a></li>
        <li><a href="contato.php" class="nav-link px-2">Contato</a></li>
        <li><a href="sobre.html" class="nav-link px-2">Sobre</a></li>
        <li><a href="faq.html" class="nav-link px-2">FAQ</a></li>
      </ul>

     <div class="btn-group col-3 text-end" role="group" aria-label="Basic outlined example">
        <a href="perfil.php"><button type="button" class="btn btn-dark me-2">Perfil</button></a>
        <a href=""> 
            <form action="../../Model/logout.php" method="post">
                <button class="btn btn-dark" type="submit">Logout</button>
            </form></a>
        
     </div>
    </header>
  </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
