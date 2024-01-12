<?php
// Inclua o arquivo de configuração
include('../config/config.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém as informações do formulário
    $pedido_id = $_POST["pedido_id"];

    // Atualiza o status do pedido para "Cancelado"
    $queryCancelarPedido = "UPDATE pedidos SET status = 'Cancelado' WHERE id = :pedido_id";
    $stmtCancelarPedido = $conexao->prepare($queryCancelarPedido);
    $stmtCancelarPedido->bindParam(":pedido_id", $pedido_id);
    $stmtCancelarPedido->execute();

    // Redireciona para a página de visualização de pedidos ou para onde for apropriado
    header("Location: ../templates/dashboard.php");
    exit();
} 

