<?php
include ('conexao.php');
session_start();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirma_senha = $_POST['confirma_senha'];
    $tipo_usuario = $_POST['tipo_usuario'];

   
    if ($senha !== $confirma_senha) {
      $erro = true;
      exit;
    }

    if ($tipo_usuario == 'cliente') {
        $stmt = $pdo->prepare("SELECT id FROM login_cliente WHERE email_cliente = ?");
    } else {
        $stmt = $pdo->prepare("SELECT id FROM login_vendedor WHERE email_vendedor = ?");
    }

    $stmt->execute([$email]);
    $usuario_existente = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario_existente) {
        echo "Este email já está cadastrado.";
        exit;
    }

    // Criptografar a senha
    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

    // Preparar a query de inserção
    if ($tipo_usuario == 'cliente') {
        $stmt = $pdo->prepare("INSERT INTO login_cliente ( email_cliente, senha_cliente, tipo_usuario) VALUES (?, ?, ?)");
    } else {
        $stmt = $pdo->prepare("INSERT INTO login_vendedor (email_vendedor, senha_vendedor, tipo_usuario) VALUES (?, ?, ?)");
    }

    // Executar a query de inserção
    if ($stmt->execute([$email, $senha_criptografada, $tipo_usuario])) {
       $sucesso = true;

       
        header("Location: vendas.php");

    } else {
        $erro_login = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Document</title>
</head>
<body class="bg-black">
<?php if (isset($erro) && $erro): ?>
        <div class="alert alert-danger" role="alert">
            As senhas não coincidem. Tente novamente!
        </div>
    <?php endif; ?>
<div class="flex min-h-full flex-col justify-content-center px-6 py-12 lg:px-8  w-1/2 rounded-lg bg-gray-900 shadow-2x1 mx-auto mt-16">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm ">
    <img class="mx-auto h-12 w-auto" src="imgs/image (3).png" alt="Your Company">
    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign in to your account</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="#" method="POST">
      <div>
        <label for="email" class="block text-sm/6 font-medium text-white">Email address</label>
        <div class="mt-2">
          <input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-yellow-500 hover:text-indigo-500">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="password" name="senha" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
        </div>
      </div>
      <div>
        <div class="flex items-center justify-between">
          <label for="password" class="block text-sm/6 font-medium text-white">Password</label>
          <div class="text-sm">
            <a href="#" class="font-semibold text-yellow-600 hover:text-indigo-500">Forgot password?</a>
          </div>
        </div>
        <div class="mt-2">
          <input id="password" name="confirma_senha" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
        </div>
      </div>
      

      <div class="sm:col-span-3">
            <label for="country" class="block text-sm/6 font-medium text-white">Pais</label>
            <div class="mt-2">
              <select id="country" name="tipo_usuario" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm/6">
    <option>cliente</option>
    <option>vendedor</option>
              </select>
            </div>
          </div>
  
         

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-yellow-600 px-3 py-1.5 text-sm/6 
        font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
      </div>
    </form>
    <p class="mt-10 text-center text-sm/6 text-gray-500">
      Not a member?
      <a href="http://localhost/Trabalho_php/contas/login.php" class="font-semibold text-yellow-500 hover:text-indigo-500">Start a 14 day free trial</a>
    </p>
   
  </div>
</div>

</body>
</html>