<!-- excluir_item_pedido_controller.php -->
<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Consulta para obter o ID do pedido antes de excluir o item do pedido
    $queryPedidoId = "SELECT pedido_id FROM itempedido WHERE id = :id";
    $stmtPedidoId = $conexao->prepare($queryPedidoId);
    $stmtPedidoId->bindParam(':id', $itemId, PDO::PARAM_INT);
    $stmtPedidoId->execute();
    $resultPedidoId = $stmtPedidoId->fetch(PDO::FETCH_ASSOC);

    if ($resultPedidoId) {
        // Exclua o item do pedido
        $queryExcluirItemPedido = "DELETE FROM itempedido WHERE id = :id";
        $stmtExcluirItemPedido = $conexao->prepare($queryExcluirItemPedido);
        $stmtExcluirItemPedido->bindParam(':id', $itemId, PDO::PARAM_INT);

        if ($stmtExcluirItemPedido->execute()) {

            // Atualiza o valor total do pedido
            $queryAtualizarValorTotal = "UPDATE pedidos SET valor_total = (SELECT SUM(valor_produto) FROM itempedido WHERE pedido_id = :pedido_id) WHERE id = :pedido_id";
            $stmtAtualizarValorTotal = $conexao->prepare($queryAtualizarValorTotal);
            $stmtAtualizarValorTotal->bindParam(":pedido_id", $resultPedidoId['pedido_id'], PDO::PARAM_INT);
            $stmtAtualizarValorTotal->execute();

            // Redirecione para a página de visualização do pedido após a exclusão
            header("Location: ../templates/editar_pedido.php?id=" . $resultPedidoId['pedido_id']);
            exit;
        } else {
            // Lidar com erro ao excluir o item do pedido
            echo "Erro ao excluir o item do pedido.";
        }
    } else {
        // Lidar com erro ao obter o ID do pedido antes de excluir o item do pedido
        echo "Erro ao obter o ID do pedido.";
    }
} else {
    // Se não for uma requisição GET válida ou o ID do item do pedido não estiver definido
    http_response_code(400);
    echo "Requisição inválida.";
}
?>