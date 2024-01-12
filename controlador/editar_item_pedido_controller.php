<?php
include('../config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $itemId = $_POST['id'];
    $pedidoId = $_POST['pedido_id'];
    $quantidade = $_POST['quantidade'];
    $valorProduto = $_POST['valor_produto'];

    // Realiza as operações de atualização no banco de dados

    // Atualiza o item do pedido
    $queryUpdateItem = "UPDATE itempedido SET quantidade = :quantidade, valor_produto = :valor_produto WHERE id = :id";
    $stmtUpdateItem = $conexao->prepare($queryUpdateItem);
    $stmtUpdateItem->bindParam(':id', $itemId, PDO::PARAM_INT);
    $stmtUpdateItem->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
    $stmtUpdateItem->bindParam(':valor_produto', $valorProduto, PDO::PARAM_STR);
    $stmtUpdateItem->execute();

    // Obtém o ID do produto associado ao item do pedido
    $queryProdutoId = "SELECT produto_id FROM itempedido WHERE id = :id";
    $stmtProdutoId = $conexao->prepare($queryProdutoId);
    $stmtProdutoId->bindParam(':id', $itemId, PDO::PARAM_INT);
    $stmtProdutoId->execute();
    $produtoId = $stmtProdutoId->fetchColumn();

    // Atualiza o saldo do estoque do produto (subtrai ou adiciona a quantidade ao estoque)
    $queryAtualizaEstoque = "UPDATE produtos SET saldo_estoque = saldo_estoque - :quantidade WHERE id = :produto_id";
    $stmtAtualizaEstoque = $conexao->prepare($queryAtualizaEstoque);
    $stmtAtualizaEstoque->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
    $stmtAtualizaEstoque->bindParam(':produto_id', $produtoId, PDO::PARAM_INT);
    $stmtAtualizaEstoque->execute();

    // Calcular o novo valor_total
    $queryNovoValorTotal = "SELECT SUM(quantidade * valor_produto) AS novo_valor_total FROM itempedido WHERE pedido_id = :pedido_id";
    $stmtNovoValorTotal = $conexao->prepare($queryNovoValorTotal);
    $stmtNovoValorTotal->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
    $stmtNovoValorTotal->execute();
    $novoValorTotal = $stmtNovoValorTotal->fetchColumn();

    // Atualiza o valor_total no pedido
    $queryAtualizaValorTotal = "UPDATE pedidos SET valor_total = :novo_valor_total WHERE id = :pedido_id";
    $stmtAtualizaValorTotal = $conexao->prepare($queryAtualizaValorTotal);
    $stmtAtualizaValorTotal->bindParam(':novo_valor_total', $novoValorTotal, PDO::PARAM_STR);
    $stmtAtualizaValorTotal->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
    $stmtAtualizaValorTotal->execute();

    // Redireciona de volta ao pedido
    header("Location: ../templates/editar_item_pedido.php?id=" . $itemId);
    exit();
} else {
    // Se a requisição não for do tipo POST, redireciona para alguma página apropriada
    header("Location: ../alguma_pagina_de_erro.php");
    exit();
}
?>
