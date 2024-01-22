<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produtoId = $_POST['produto_id'];

    $queryInativarProduto = "UPDATE PRODUTOS SET ativo = 0 WHERE id = :produtoId";
    $stmtInativarProduto = $conexao->prepare($queryInativarProduto);
    $stmtInativarProduto->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
    $stmtInativarProduto->execute();

    header('Location: ../templates/visualizar_produtos.php');
    exit;
}
?>
