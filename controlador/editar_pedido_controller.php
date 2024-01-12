<!-- editar_pedido_controller.php -->
<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pedidoId = isset($_POST['id']) ? $_POST['id'] : null;
    $valorTotal = isset($_POST['valor_total']) ? $_POST['valor_total'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    if ($pedidoId && $valorTotal !== null && $status !== null) {
        $queryAtualizarPedido = "UPDATE pedidos SET valor_total = :valor_total, status = :status WHERE id = :id";
        $stmtAtualizarPedido = $conexao->prepare($queryAtualizarPedido);
        $stmtAtualizarPedido->bindParam(':valor_total', $valorTotal, PDO::PARAM_STR);
        $stmtAtualizarPedido->bindParam(':status', $status, PDO::PARAM_STR);
        $stmtAtualizarPedido->bindParam(':id', $pedidoId, PDO::PARAM_INT);

        if ($stmtAtualizarPedido->execute()) {
            // Redirecione para a página de visualização do pedido após a atualização
            header("Location: ../templates/dashboard.php");
            exit;
        } else {
            // Lidar com erro ao atualizar o pedido
            echo "Erro ao atualizar o pedido.";
        }
    } else {
        // Lidar com dados ausentes
        echo "Dados do pedido ausentes.";
    }
} else {
    // Se não for uma requisição POST válida
    http_response_code(400);
    echo "Requisição inválida.";
}
?>
