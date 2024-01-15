<?php
// Inclua o arquivo de configuração
include('../config/config.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id = $_POST["cliente_id"];
    $quantidade_itens = $_POST["quantidade_itens"];

    // Insere o pedido no banco de dados
    $queryPedido = "INSERT INTO pedidos (cliente_id, status) VALUES (:cliente_id, 'Em andamento')";
    $stmtPedido = $conexao->prepare($queryPedido);
    $stmtPedido->bindParam(":cliente_id", $cliente_id);
    $stmtPedido->execute();

    // Obtém o ULTIMO ID de PEDIDOS
    $pedido_id = $conexao->lastInsertId();

    header("Location: ../templates/adicionar_itens.php?pedido_id=$pedido_id&quantidade_itens=$quantidade_itens");
    exit();
} else {
    header("Location: ../templates/registrar_pedido.php");
    exit();
}
