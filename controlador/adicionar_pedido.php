<?php
// Inclua o arquivo de configuração
include('../config/config.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém as informações do formulário
    $cliente_id = $_POST["cliente_id"];
    $quantidade_itens = $_POST["quantidade_itens"];

    // Insere o pedido no banco de dados
    $queryPedido = "INSERT INTO pedidos (cliente_id, status) VALUES (:cliente_id, 'Em andamento')";
    $stmtPedido = $conexao->prepare($queryPedido);
    $stmtPedido->bindParam(":cliente_id", $cliente_id);
    $stmtPedido->execute();

    // Obtém o ID do pedido recém-inserido
    $pedido_id = $conexao->lastInsertId();

    // Agora você pode redirecionar para uma página onde o usuário pode adicionar itens ao pedido
    header("Location: ../templates/adicionar_itens.php?pedido_id=$pedido_id&quantidade_itens=$quantidade_itens");
    exit();
} else {
    // Se o formulário não foi enviado, redireciona para a página de registrar pedido
    header("Location: ../templates/registrar_pedido.php");
    exit();
}
