

<?php


session_start();
include 'conexao.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: entrar_cliente.php");
    exit();
}


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Produto inválido!";
    exit();
}

$produto_id = $_GET['id'];


$stmt = $pdo->prepare("SELECT * FROM cadastrar_produtos WHERE id = :id");
$stmt->execute(['id' => $produto_id]);
$produto = $stmt->fetch();

if (!$produto) {
    echo "Produto não encontrado!";
    exit();
}


$id_ven = $produto['vendedor_id'];
$stmt2 = $pdo->prepare("SELECT * FROM login_vendedor WHERE id = :id");
$stmt2->execute(['id' => $id_ven]);
$vendedor = $stmt2->fetch();




if(isset($_POST['comprar'])){




  
  $quantidade = $_POST['Q'];
  $forma_pagamento = $_POST['forma_pagamento'];
  $cliente_id = $_SESSION['cliente_id'];
  
  $stmt5 = $pdo->prepare("SELECT * FROM cadastrar_produtos WHERE id = :id");
    $stmt5->execute(['id' => $produto_id]);
    $produto = $stmt5->fetch();

    $CLiente = $pdo->prepare("SELECT * FROM login_cliente WHERE id = ?");
    $CLiente->execute([$cliente_id]);
    $dadosExistem = $CLiente->fetch();

    if ($produto['estoque_produto'] >= $quantidade) {


   
   



      $preco_total = $quantidade * $produto['preco_produto'];
      $data_atual = date('Y-m-d');
        $stmt3 = $pdo->prepare("INSERT INTO compras_realizadas (cliente_id, produto_id, preco, quantidade, data_compra) VALUES (?, ?, ?, ?, ?)");
        $stmt3->execute([$cliente_id, $produto_id, $preco_total, $quantidade, $data_atual]);
        $novo_estoque = $produto['estoque_produto'] - $quantidade;
        $stmt4 = $pdo->prepare("UPDATE cadastrar_produtos SET estoque_produto = ? WHERE id = ?");
        $stmt4->execute([$novo_estoque, $produto_id]);

        echo "Compra realizada com sucesso!";
    } else {
        echo "Estoque insuficiente!";
    }



  
  $cliente_id = $_SESSION['cliente_id']; 

  
    $primeiro_nome_C = $_POST['primeiro_nome_C'];
    $segundo_nome_C = $_POST['segundo_nome_C'];
    $nome = $primeiro_nome_C.' '.$segundo_nome_C;
    $email_cliente = $_POST['Email'];
    $CPF = $_POST['CPF'];
    $CEP_C = $_POST['CEP_C'];
    $pais =  $_POST['pais'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];

    
    $endereco_C = $pais . ', ' .$estado .', ' . $cidade . ', ' . $bairro . ', Número: ' . $numero;

   $cliente_id = $_SESSION['cliente_id'];
    $stmt = $pdo->prepare("SELECT * FROM login_cliente WHERE id = ?");
    $stmt->execute([$cliente_id]);
    $dadosExistem = $stmt->fetch();

    if ($dadosExistem) {
        
        $stmt = $pdo->prepare("UPDATE login_cliente SET nome_cliente = ?, cpf = ?, cep = ?, endereco = ? WHERE id = ?");
        $stmt->execute([$nome, $CPF, $CEP_C, $endereco_C, $cliente_id]);
  
    } else {
    
        $stmt = $pdo->prepare("INSERT INTO login_cliente (nome_cliente, cpf, cep, endereco) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $CPF, $CEP_C, $endereco_C]);
        
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

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
    <a class="nav-link" onclick="carrinho()" href="#"><button type="button" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
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


<div class="bg-gray-950">
  <div class="pt-6">
   

    <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-3 lg:gap-x-8 lg:px-8">
      <img src="https://tailwindui.com/plus/img/ecommerce-images/product-page-02-featured-product-shot.jpg" alt="Model wearing plain white basic tee." class="aspect-[4/5] size-full object-cover sm:rounded-lg lg:aspect-[3/4] lg:col-span-1 lg:border-r lg:border-gray-200 lg:pr-8">
        
          <div class="mt-4 lg:row-span-3 lg:mt-0">
        <h2 class="sr-only">Product information</h2>
        <h2 class="text-white text-2xl"><?php echo htmlspecialchars($produto['nome_produto']) ?></h2>
        <p class="text-3xl tracking-tight text-white"><?php   echo number_format($produto['preco_produto'], 2, ',', '.') ?></p>

        
        <div class="mt-6">
          <h3 class="sr-only">Reviews</h3>
          <div class="flex items-center">
            <div class="flex items-center">
          
              <svg class="size-5 shrink-0 text-gray-200 active:text-yellow-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
              </svg>
              <svg class="size-5 shrink-0 text-gray-200 active:text-yellow-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
              </svg>
              <svg class="size-5 shrink-0 text-gray-200  active:text-yellow-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
              </svg>
              <svg class="size-5 shrink-0 text-gray-200  active:text-yellow-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
              </svg>
              <svg class="size-5 shrink-0 text-gray-200  active:text-yellow-300" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401Z" clip-rule="evenodd" />
              </svg>
            </div>
            <p class="sr-only">4 out of 5 stars</p>
            <a href="#" class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">117 reviews</a>
          </div>
        </div>
          <button type="submit" class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-yellow-500 px-8 py-3 text-base font-medium text-white hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" onclick="MostrarMais()">Add to bag</button>
        </form>
      </div>

    </div>

 
     
      <div class="py-10 lg:col-span-2 lg:col-start-1 lg:border-r lg:border-gray-200 lg:pb-16 lg:pr-8 lg:pt-6">
        <!-- Description and details -->
        <div>
          <h3 class="text-white">Descrição</h3>
<br>
          <div class="space-y-6">
            <p class="text-base text-white"><?php echo htmlspecialchars($produto['descricao_produto']) ?></p>
          </div>
        </div>

        <div class="mt-10">
          <h3 class="text-sm font-medium text-white">Informações adicionais do produto</h3>

          <div class="mt-4">
            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
              <li class="text-gray-400"><span class="text-white">Peso: <?php echo htmlspecialchars($produto['peso']) ?>(kg)</span></li>
              <li class="text-gray-400"><span class="text-white">Altura: <?php echo htmlspecialchars($produto['altura']) ?>(cm)</span></li>
              <li class="text-gray-400"><span class="text-white">Largura: <?php echo htmlspecialchars($produto['largura']) ?>(cm)</span></li>
              <li class="text-gray-400"><span class="text-white">Comprimento: <?php echo htmlspecialchars($produto['comprimento']) ?>(cm)</span></li>
            </ul>
          </div>
        </div>

        <div class="mt-10">
          <h3 class="text-sm font-medium text-white">Informações do vendedor</h3>

          <div class="mt-4">
            <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
              <li class="text-gray-400"><span class="text-white">Nome do vendedor: <?php echo htmlspecialchars($vendedor['primeiro_nome']) ?> <?php echo htmlspecialchars($vendedor['segundo_nome']) ?></span></li>
              <li class="text-gray-400"><span class="text-white">Nome da loja: <?php echo htmlspecialchars($vendedor['nome_loja']) ?></span></li>
              <li class="text-gray-400"><span class="text-white">CEP da loja: <?php echo htmlspecialchars($vendedor['CEP']) ?></span></li>
              <li class="text-gray-400"><span class="text-white">Endereço da loja: <?php echo htmlspecialchars($vendedor['endereco']) ?></span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="relative z-10 hidden bg-gray-950" id="div" role="dialog" aria-modal="true">

<div class="fixed inset-0 hidden bg-gray-950 bg-opacity-100 transition-opacity md:block" aria-hidden="true"></div>
<div class="fixed inset-0 z-10 w-screen overflow-y-auto">
<div class="flex min-h-full items-stretch justify-center text-center md:items-center md:px-2 lg:px-4">
  
<form method="POST" action="#">
    <div class="space-y-12">
      <div class="border-b border-white pb-12">
        <h2 class="text-base/7 font-semibold text-white">Informações da compra</h2>
        <p class="mt-1 text-sm/6 text-white">Digite as Informações da realização da compra.</p>
  
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="username" class="block text-sm/6 font-medium text-white">Quantidade do produto</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="number" name="Q" id="username"  class="block flex-1 border-0 bg-white rounded-md py-1.5 pl-1 text-black placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" >
              </div>
            </div>
          </div>
          <div class="sm:col-span-4">
            <label for="username" class="block text-sm/6 font-medium text-white">Forma de pagamento</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <select type="text" name="forma_pagamento"   class="block flex-1 border-0 bg-white rounded-md py-1.5 pl-1 text-white placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" >
             <option >Pix</option>
             <option >Cartao</option>
             <option >Boleto</option>
              </select>              
              </div>
            </div>
          </div>

        </div>

        </div>
      </div>
  
      <div class="border-b border-white pb-12">
        <h2 class="text-base/7 font-semibold text-white">Informações pessoais</h2>
        <p class="mt-1 text-sm/6 text-gray-600">Adicione aqui Informações necessarias.</p>
  
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="first-name" class="block text-sm/6 font-medium text-white">Primeiro nome</label>
            <div class="mt-2">
              <input type="text" name="primeiro_nome_C" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-3">
            <label for="last-name" class="block text-sm/6 font-medium text-white">Segundo nome</label>
            <div class="mt-2">
              <input type="text" name="segundo_nome_C" id="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-4">
            <label for="email" class="block text-sm/6 font-medium text-white">Email pessoal</label>
            <div class="mt-2">
              <input id="email" name="Email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
          </div>
          <div class="sm:col-span-4">
            <label  class="block text-sm/6 font-medium text-white">CPF</label>
            <div class="mt-2">
              <input  name="CPF" type="number" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
          <div class="sm:col-span-4">
            <label  class="block text-sm/6 font-medium text-white">CEP</label>
            <div class="mt-2">
              <input  name="CEP_C" type="number" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
         
          <div class="sm:col-span-3">
            <label for="country" class="block text-sm/6 font-medium text-white">Pais</label>
            <div class="mt-2">
              <select id="country" name="pais" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm/6">
              <option>Afeganistão</option>
    <option>Albânia</option>
    <option>Argélia</option>
    <option>Samoa Americana</option>
    <option>Andorra</option>
    <option>Angola</option>
    <option>Anguila</option>
    <option>Antártida</option>
    <option>Antígua e Barbuda</option>
    <option>Argentina</option>
    <option>Armênia</option>
    <option>Aruba</option>
    <option>Austrália</option>
    <option>Áustria</option>
    <option>Armênia</option>
    <option>Bahamas</option>
    <option>Bahrein</option>
    <option>Bangladesh</option>
    <option>Barbados</option>
    <option>Bielorrússia</option>
    <option>Bélgica</option>
    <option>Belize</option>
    <option>Benin</option>
    <option>Bermudas</option>
    <option>Butão</option>
    <option>Bolívia</option>
    <option>Bósnia e Herzegovina</option>
    <option>Botswana</option>
    <option>Brasil</option>
    <option>Brunei</option>
    <option>Bulgária</option>
    <option>Burkina Faso</option>
    <option>Burundi</option>
    <option>Camboja</option>
    <option>Camarões</option>
    <option>Canadá</option>
    <option>Cabo Verde</option>
    <option>Ilhas Cayman</option>
    <option>República Centro-Africana</option>
    <option>Chade</option>
    <option>Chile</option>
    <option>China</option>
    <option>Colômbia</option>
    <option>Comores</option>
    <option>Congo</option>
    <option>República Democrática do Congo</option>
    <option>Ilhas Cook</option>
    <option>Costa Rica</option>
    <option>Costa do Marfim</option>
    <option>Croácia</option>
    <option>Cuba</option>
    <option>Chipre</option>
    <option>República Tcheca</option>
    <option>Dinamarca</option>
              </select>
            </div>
          </div>
  
          <div class="col-span-full">
            <label  class="block text-sm/6 font-medium text-white">ESTADO:</label>
            <div class="mt-2">
              <input type="text" name="estado"  autocomplete="street-address" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-2 sm:col-start-1">
            <label for="city" class="block text-sm/6 font-medium text-white">CIDADE:</label>
            <div class="mt-2">
              <input type="text" name="cidade" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm/6 font-medium text-white">BAIRRO:</label>
            <div class="mt-2">
              <input type="text" name="bairro"  autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-2">
            <label for="postal-code" class="block text-sm/6 font-medium text-white">NUMERO:</label>
            <div class="mt-2">
              <input type="number" name="numero"  autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
        </div>
      </div>
  
     
    <div class="mt-6 flex items-center justify-end gap-x-6">
      <button type="button" class="text-sm/6 font-semibold text-white btn btn-outline-danger" onclick="VerMenos()">Cancel</button>
      <button type="submit" id="comprar" class=" text-sm font-semibold text-white btn btn-outline-success" onclick="VerMenos()" name="comprar">Save</button>
    </div>
  </form>
  
</div>
</div>
</div>

<script>

        $('#comprar').click(function() {
            $.post('compra.php', function(resultado) {
                resultado = JSON.parse(resultado);
                
                
                if (resultado.erro) {
                    $('#resultado').html(`Erro: ${resultado.erro}`);
                } else {
                    let valorFrete = resultado.preco;
                    let prazoEntrega = resultado.prazo;
                    $('#resultado').html(`O valor do frete é <b>R$ ${valorFrete}</b> e o prazo de entrega é <b>${prazoEntrega} dias úteis</b>.`);
                }
            });
        });


        function MostrarMais() {
            var div = document.getElementById("div");
            div.classList.toggle("hidden"); 
        }

        function VerMenos(){
          var div = document.getElementById("div");
          div.classList.add("hidden"); 
        }


        </script>
</body>
</html>