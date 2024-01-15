<?php
include('../config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém as informações do formulário
    $pedido_id = $_POST["pedido_id"];
    $produto_id = $_POST["produto_id"];
    $quantidade = $_POST["quantidade"];
    $valor_produto = $_POST["valor_produto"];

    // Ajustar para quando for 0,70 mudar para 0.70
    $valor_produto = str_replace(',', '.', $valor_produto);

    
    $queryItemPedido = "INSERT INTO itempedido (pedido_id, produto_id, quantidade, valor_produto) VALUES (:pedido_id, :produto_id, :quantidade, :valor_produto)";
    $stmtItemPedido = $conexao->prepare($queryItemPedido);
    $stmtItemPedido->bindParam(":pedido_id", $pedido_id);
    $stmtItemPedido->bindParam(":produto_id", $produto_id);
    $stmtItemPedido->bindParam(":quantidade", $quantidade);
    $stmtItemPedido->bindParam(":valor_produto", $valor_produto);
    $stmtItemPedido->execute();

    $queryAtualizarValorTotal = "UPDATE pedidos SET valor_total = (SELECT SUM(valor_produto) FROM itempedido WHERE pedido_id = :pedido_id) WHERE id = :pedido_id";
    $stmtAtualizarValorTotal = $conexao->prepare($queryAtualizarValorTotal);
    $stmtAtualizarValorTotal->bindParam(":pedido_id", $pedido_id);
    $stmtAtualizarValorTotal->execute();

    // Subtrai a quantidade do estoque
    $queryAtualizarEstoque = "UPDATE produtos SET saldo_estoque = saldo_estoque - :quantidade WHERE id = :produto_id";
        $stmtAtualizarEstoque = $conexao->prepare($queryAtualizarEstoque);
        $stmtAtualizarEstoque->bindParam(":quantidade", $quantidade);
        $stmtAtualizarEstoque->bindParam(":produto_id", $produto_id);
        $stmtAtualizarEstoque->execute();

    header("Location: ../templates/adicionar_itens.php?pedido_id=$pedido_id");
    exit();
} else {
    header("Location: ../templates/registrar_pedido.php");
    exit();
}
