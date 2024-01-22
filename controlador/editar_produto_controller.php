<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produtoId = $_POST['produto_id'];
    $nome = $_POST['nome'];
    $preco_venda = $_POST['preco_venda'];
    $saldo_estoque = $_POST['saldo_estoque'];

    // Atualiza os dados do cliente no banco de dados
    $queryAtualizarProduto = "UPDATE PRODUTOS SET nome = :nome, preco_venda = :preco_venda, saldo_estoque = :saldo_estoque WHERE id = :produtoId";
    $stmtAtualizarProduto = $conexao->prepare($queryAtualizarProduto);
    $stmtAtualizarProduto->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmtAtualizarProduto->bindParam(':preco_venda', $preco_venda, PDO::PARAM_STR);
    $stmtAtualizarProduto->bindParam(':saldo_estoque', $saldo_estoque, PDO::PARAM_STR);
    $stmtAtualizarProduto->bindParam(':produtoId', $produtoId, PDO::PARAM_INT); // Adicione esta linha
    $stmtAtualizarProduto->execute();

    // Redireciona para a página de visualizar clientes após a edição
    header('Location: ../templates/visualizar_produtos.php');
    exit;
}
?>
