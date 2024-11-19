<?php
session_start();
include 'conexao.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $stmt = $pdo->prepare('SELECT * FROM login_vendedor WHERE email_vendedor = :email');
    $stmt->execute(['email' => $email]);
    $vendedor = $stmt->fetch();

    if ($vendedor && password_verify($senha, $vendedor['senha_vendedor'])) {
        $_SESSION['vendedor_id'] = $vendedor['id'];
        $_SESSION['tipo'] = $vendedor['tipo'];
        header('Location: index.php');
    } else {
        $erro = "Email ou senha incorretos!";
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

    <div class="flex min-h-full flex-col justify-content-center px-6 py-12 lg:px-8  w-1/2 rounded-lg bg-gray-900 shadow-2x1 mx-auto mt-16">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm ">
            <img class="mx-auto h-12 w-auto" src="imgs/image (3).png" alt="Your Company">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-white">Sign in to your account</h2>
        </div>
    
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="#" method="POST">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-white">Email</label>
                    <div class="mt-2">
                        <input  name="email" type="email" autocomplete="email" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-white">senha</label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-yellow-600 hover:text-indigo-500">Você esqueceu sua senha?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input  name="senha" type="password" autocomplete="current-password" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-yellow-600 px-3 py-1.5 text-sm/6 
        font-semibold text-white shadow-sm hover:bg-yellow-500 focus-visible:outline focus-visible:outline-2 
        focus-visible:outline-offset-2 focus-visible:outline-indigo-600" name="login">Sign in</button>
                </div>
            </form>
            <?php if (isset($erro)) echo "<p>$teste</p>"; ?>
            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Not a member?
                <a href="login_cliente.php" class="font-semibold text-yellow-500 hover:text-indigo-500">Start a 14 day free trial</a>
            </p>
        </div>
    </div>

</body>

</html>