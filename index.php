<?php
session_start();
include('conexao.php');


$stmt = $pdo->prepare("SELECT * FROM cadastrar_produtos");
$stmt->execute();
$produtos = $stmt->fetchAll();

include('conexao.php');


$stmt = $pdo->prepare("
    SELECT nome_produto, preco_produto 
    FROM cadastrar_produtos
    ORDER BY preco DESC
");

$stmt->execute();
$prod = $stmt->fetchAll();

$nome = [];
$valores = [];


foreach ($prod as $produt) {
    $nome[] = $produt['nome_produto'];
    $valores[] = $produt['preco_produto'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Crud PHP</title>
</head>
<body>

<!-- Começo NAVBAR -->   
<nav class="navbar bg-gray-900 border-bottom border-body" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand"><img src="imgs/image (3).png" alt="" width="100px"></a>
    
    <ul class="nav justify-content-center ms-auto">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Ofertas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="login_cliente.php">Entrar</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#"><button type="button" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
  <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
</svg></button></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" aria-disabled="true" href="vendas.php"><button type="button" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
  <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1z"/>
</svg></button></a>
  </li>
</ul>
    <form class="d-flex ustify-content-center" role="search">
      <input class="form-control me-4" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</nav>

<!-- Começo CARROSSEL -->
<div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="imgs/www.reallygreatsite.com.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="imgs/www.reallygreatsite.com (1).png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="imgs/www.reallygreatsite.com (2).png" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!--Começo dos Produtos -->

<div class="bg-gray-950">
  <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="sr-only">Products</h2>

    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
    <?php foreach ($produtos as $produto): ?>
    <a href="#" class="group">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7 aspect-black">
          <img src="<?php echo htmlspecialchars($produto['image_url']) ?>" alt="Tall slender porcelain bottle with natural clay textured body and cork stopper." class="h-full w-full object-cover object-center group-hover:opacity-75">
        </div>
        <h3 class="mt-4 text-sm text-gray-700 text-white" ><?php echo htmlspecialchars($produto['nome_produto']) ?></h3>
        <p class="mt-1 text-lg font-medium text-gray-900 text-white"><?php   echo number_format($produto['preco_produto'], 2, ',', '.') ?></p>
        <button id="btn_unico" class="btn btn-outline-primary" onclick="MostrarMais(<?= $produto['id'] ?>)">Ver mais</button>
        <?php endforeach; ?> 
      </div>
  </div>
</div>

<script>
        
        var clientes = <?php echo json_encode($nome); ?>;
        var valores = <?php echo json_encode($valores); ?>;

       
        var ctx = document.getElementById('gastosChart').getContext('2d');
        var gastosChart = new Chart(ctx, {
            type: 'bar', 
            data: {
                labels: produtos, 
                datasets: [{
                    label: 'Total  (R$)',
                    data: valores, 
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', 
                    borderColor: 'rgba(75, 192, 192, 1)', 
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true, 
                scales: {
                    y: {
                        beginAtZero: true 
                    }
                }
            }
        });
    </script>




<script>
    function MostrarMais(idProduto) {
            window.location.href = "compra.php?id=" + idProduto;
        }

    </script>

 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>