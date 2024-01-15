<?php
// Inclua o arquivo de configuração
include('../config/config.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém as informações do formulário
    $pedido_id = $_POST["pedido_id"];
    $produto_id = $_POST["produto_id"];
    $quantidade = $_POST["quantidade"];
    $valor_produto = $_POST["valor_produto"];

    // Insere o item do pedido no banco de dados
    $valor_produto = str_replace(',', '.', $valor_produto);

    
    $queryItemPedido = "INSERT INTO itempedido (pedido_id, produto_id, quantidade, valor_produto) VALUES (:pedido_id, :produto_id, :quantidade, :valor_produto)";
    $stmtItemPedido = $conexao->prepare($queryItemPedido);
    $stmtItemPedido->bindParam(":pedido_id", $pedido_id);
    $stmtItemPedido->bindParam(":produto_id", $produto_id);
    $stmtItemPedido->bindParam(":quantidade", $quantidade);
    $stmtItemPedido->bindParam(":valor_produto", $valor_produto);
    $stmtItemPedido->execute();

    // Atualiza o valor total do pedido
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

    // Redireciona de volta para a página de adicionar itens
    header("Location: ../templates/adicionar_itens.php?pedido_id=$pedido_id");
    exit();
} else {
    // Se o formulário não foi enviado, redireciona para a página de registrar pedido
    header("Location: ../templates/registrar_pedido.php");
    exit();
}
