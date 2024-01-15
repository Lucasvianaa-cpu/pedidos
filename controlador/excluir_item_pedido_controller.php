<!-- excluir_item_pedido_controller.php -->
<?php
include('../config/config.php');

//VALIDAÇÃO SE O ID VEIO PELO METODO GET NA URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Consulta para obter o ID do pedido antes de excluir o item do pedido
    $queryPedidoId = "SELECT pedido_id FROM itempedido WHERE id = :id";
    $stmtPedidoId = $conexao->prepare($queryPedidoId);
    $stmtPedidoId->bindParam(':id', $itemId, PDO::PARAM_INT);
    $stmtPedidoId->execute();
    $resultPedidoId = $stmtPedidoId->fetch(PDO::FETCH_ASSOC);

    if ($resultPedidoId) {
        // Excluindo Item do Pedido
        $queryExcluirItemPedido = "DELETE FROM itempedido WHERE id = :id";
        $stmtExcluirItemPedido = $conexao->prepare($queryExcluirItemPedido);
        $stmtExcluirItemPedido->bindParam(':id', $itemId, PDO::PARAM_INT);

        if ($stmtExcluirItemPedido->execute()) {

            // Atualiza o valor total do pedido, se excluir o item, deve atualizar o valor total de PEDIDOS
            $queryAtualizarValorTotal = "UPDATE pedidos SET valor_total = (SELECT SUM(valor_produto) FROM itempedido WHERE pedido_id = :pedido_id) WHERE id = :pedido_id";
            $stmtAtualizarValorTotal = $conexao->prepare($queryAtualizarValorTotal);
            $stmtAtualizarValorTotal->bindParam(":pedido_id", $resultPedidoId['pedido_id'], PDO::PARAM_INT);
            $stmtAtualizarValorTotal->execute();

            header("Location: ../templates/editar_pedido.php?id=" . $resultPedidoId['pedido_id']);
            exit;
        } else {
            echo "Erro ao excluir o item do pedido.";
        }
    } else {
        echo "Erro ao obter o ID do pedido.";
    }
} else {
    // Se não for uma requisição GET válida ou o ID do item do pedido não estiver definido
    http_response_code(400);
    echo "Requisição inválida.";
}
?>