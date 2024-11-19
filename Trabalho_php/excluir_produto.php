<?php
include('conexao.php'); 
if(isset($_GET['id'])) {
    $produto_id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM cadastrar_produtos WHERE id = ?");
    $stmt->execute([$produto_id]);
    header('Location: index.php'); 
}
?>
