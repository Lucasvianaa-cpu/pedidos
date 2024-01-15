<?php
include('../config/config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pedido_id = $_POST["pedido_id"];

    // Status -> CANCELADO
    $queryCancelarPedido = "UPDATE pedidos SET status = 'Cancelado' WHERE id = :pedido_id";
    $stmtCancelarPedido = $conexao->prepare($queryCancelarPedido);
    $stmtCancelarPedido->bindParam(":pedido_id", $pedido_id);
    $stmtCancelarPedido->execute();

    header("Location: ../templates/dashboard.php");
    exit();
} 

