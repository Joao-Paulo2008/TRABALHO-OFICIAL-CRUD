<?php

session_start();
include('conexao.php');

 if (!isset($_SESSION['vendedor_id'])) {
    header('Location: entrar_vendedor.php');
    exit();
}
 

if(isset($_POST['cadastrar'])){

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $estoque = $_POST['estoque'];
    $peso = $_POST["peso"];
    $altura = $_POST["altura"];
    $largura = $_POST["largura"];
    $comprimento = $_POST["comprimento"];
    $vendedor_id = $_SESSION['vendedor_id']; 
    $link = $_POST["link"];

    $stmt = $pdo->prepare("INSERT INTO cadastrar_produtos (nome_produto, descricao_produto, preco_produto, estoque_produto, vendedor_id, peso, altura, largura, comprimento, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $preco, $estoque, $vendedor_id, $peso, $altura, $largura, $comprimento, $link]);

    
}

$vendedor_id = $_SESSION['vendedor_id']; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  
    $primeiro_nome = $_POST['primeiro_nome'];
    $segundo_nome = $_POST['segundo_nome'];
    $email_vendedor = $_POST['email_vendedor'];
    $nome_loja = $_POST['nome_loja'];
    $CNPJ = $_POST['CNPJ'];
    $CEP = $_POST['CEP'];
    $pais =  $_POST['pais'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $numero = $_POST['numero'];

    
    $endereco = $pais . ', ' .$estado .', ' . $cidade . ', ' . $bairro . ', Número: ' . $numero;


    $stmt = $pdo->prepare("SELECT * FROM login_vendedor WHERE id = ?");
    $stmt->execute([$vendedor_id]);
    $dadosExistem = $stmt->fetch();

    if ($dadosExistem) {
        
        $stmt = $pdo->prepare("UPDATE login_vendedor SET primeiro_nome = ?, segundo_nome = ?, nome_loja = ?, CNPJ = ?, CEP = ?, endereco = ? WHERE id = ?");
        $stmt->execute([$primeiro_nome, $segundo_nome, $nome_loja, $CNPJ, $CEP, $endereco, $vendedor_id]);
  
    } else {
    
        $stmt = $pdo->prepare("INSERT INTO login_vendedor (primeiro_nome, segundo_nome, nome_loja, CNPJ, CEP, endereco) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$primeiro_nome, $segundo_nome, $nome_loja, $CNPJ, $CEP, $endereco]);
        
    }
}
}

$vendedor_id = $_SESSION['vendedor_id']; 

$stmt = $pdo->prepare("SELECT * FROM cadastrar_produtos WHERE vendedor_id = ?");
$stmt->execute([$vendedor_id]);
$produtos = $stmt->fetchAll();

    
   
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
<body class="bg-gray-950">

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
    <a class="nav-link disabled" aria-disabled="true"><button type="button" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag" viewBox="0 0 16 16">
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
        <button class="btn btn-outline-danger ml-2" onclick="excluirProduto(<?php echo $produto['id']; ?>)">Excluir</button>
        <?php endforeach;?>
       


      <a href="#" class="group border-4 border-dotted rounded-lg">
     <br>
     <br> 
      <h1 class="text-center mt-20 font-black text-lg text-yellow-500"> + Novo Produto </h1>
 
      <h2 class="text-center  text-gray-700 text-white"> Adicone um novo produto </h2>
       <div class="d-flex justify-content-center mt-5">
      <button class="btn btn-outline-warning " style="width: 250px;" onclick="MostrarMais()">Adicionar</button>
      </div>
    </a> 
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
        <h2 class="text-base/7 font-semibold text-white">Informações do produto</h2>
        <p class="mt-1 text-sm/6 text-white">Digite as Informações do produtos e as dimensões do pacode que o produto será enviado.</p>
  
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-4">
            <label for="username" class="block text-sm/6 font-medium text-white">Nome do Produto</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="nome" id="username" autocomplete="username" class="block flex-1 border-0 bg-white rounded-md py-1.5 pl-1 text-black placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" >
              </div>
            </div>
          </div>
          <div class="sm:col-span-4">
            <label for="username" class="block text-sm/6 font-medium text-white">Preço do Produto</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="preco"   class="block flex-1 border-0 bg-white rounded-md py-1.5 pl-1 text-white placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" >
              </div>
            </div>
          </div>
          <div class="sm:col-span-4">
            <label for="Estoque" class="block text-sm/6 font-medium text-white">Estoque do Produto</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="estoque"  class="block flex-1 border-0 bg-white rounded-md py-1.5 pl-1 text-white placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" >
              </div>
            </div>
          </div>
          <div class="sm:col-span-4">
            <label for="username" class="block text-sm/6 font-medium text-white"> Peso do Produto(kg)</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="peso"   class="block flex-1 border-0 bg-white rounded-md py-1.5 pl-1 text-white placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" >
              </div>
            </div>
          </div>

          
        
          <div class="sm:col-span-2 sm:col-start-1">
            <label for="city" class="block text-sm/6 font-medium text-white">Largura(cm)</label>
            <div class="mt-2">
              <input type="text" name="largura"  autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-2">
            <label for="region" class="block text-sm/6 font-medium text-white">alutra(cm)</label>
            <div class="mt-2">
              <input type="text" name="altura"  autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-2">
            <label for="postal-code" class="block text-sm/6 font-medium text-white">Comprimento(cm)</label>
            <div class="mt-2">
              <input type="text" name="comprimento" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
        </div>
      

          <div class="col-span-full">
            <label for="about" class="block text-sm/6 font-medium text-white">Descrição do produto</label>
            <div class="mt-2">
              <textarea name="descricao" rows="3" class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6"></textarea>
            </div>
          </div>
          <div class="sm:col-span-4">
            <label for="username" class="block text-sm/6 font-medium text-white"> LINK da imagem (link web):</label>
            <div class="mt-2">
              <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="link"   class="block flex-1 border-0 bg-white rounded-md py-1.5 pl-1 text-white placeholder:text-gray-400 focus:ring-0 sm:text-sm/6" >
              </div>
            </div>
          </div>
       
  
      
        </div>
      </div>
  
      <div class="border-b border-white pb-12">
        <h2 class="text-base/7 font-semibold text-white">Informações da loja/vendedor</h2>
        <p class="mt-1 text-sm/6 text-gray-600">Adicione aqui Informações necessarias</p>
  
        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
          <div class="sm:col-span-3">
            <label for="first-name" class="block text-sm/6 font-medium text-white">Primeiro nome</label>
            <div class="mt-2">
              <input type="text" name="primeiro_nome" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-3">
            <label for="last-name" class="block text-sm/6 font-medium text-white">Segundo nome</label>
            <div class="mt-2">
              <input type="text" name="segundo_nome" id="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
  
          <div class="sm:col-span-4">
            <label for="email" class="block text-sm/6 font-medium text-white">Email da loja</label>
            <div class="mt-2">
              <input id="email" name="email_vendedor" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
          <div class="sm:col-span-4">
            <label for="name" class="block text-sm/6 font-medium text-white">Nome da loja</label>
            <div class="mt-2">
              <input  name="nome_loja" type="text" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
          <div class="sm:col-span-4">
            <label  class="block text-sm/6 font-medium text-white">CNPJ</label>
            <div class="mt-2">
              <input  name="CNPJ" type="number" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
            </div>
          </div>
          <div class="sm:col-span-4">
            <label  class="block text-sm/6 font-medium text-white">CEP</label>
            <div class="mt-2">
              <input  name="CEP" type="number" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-white shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
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
      <button type="submit" class=" text-sm font-semibold text-white btn btn-outline-success" onclick="VerMenos()" name="cadastrar">Save</button>
    </div>
  </form>
  
</div>
</div>
</div>

<script>

function excluirProduto(id) {
    if (confirm("Tem certeza de que deseja excluir este produto?")) {
        window.location.href = 'excluir_produto.php?id=' + id;
    }

    
}


function MostrarMais() {
            var div = document.getElementById("div");
            div.classList.toggle("hidden"); 
        }

        function VerMenos(){
          var div = document.getElementById("div");
          div.classList.add("hidden"); 
        }



        </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>