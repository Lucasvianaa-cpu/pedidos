<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $pedidoId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($pedidoId) {
        try {
            $conexao->beginTransaction();

            // Excluir registros relacionados na tabela itempedido (TABELA FILHA)
            $queryExcluirItensPedido = "DELETE FROM itempedido WHERE pedido_id = :pedido_id";
            $stmtExcluirItensPedido = $conexao->prepare($queryExcluirItensPedido);
            $stmtExcluirItensPedido->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
            $stmtExcluirItensPedido->execute();

            // Excluir o próprio pedido (TABELA PAI)
            $queryExcluirPedido = "DELETE FROM pedidos WHERE id = :id";
            $stmtExcluirPedido = $conexao->prepare($queryExcluirPedido);
            $stmtExcluirPedido->bindParam(':id', $pedidoId, PDO::PARAM_INT);
            
            if ($stmtExcluirPedido->execute()) {
                // Se tudo der certo, commit
                $conexao->commit();

                echo json_encode(['success' => true]);
                exit;
            } else {
                $conexao->rollBack();

                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erro ao excluir pedido']);
                exit;
            }
        } catch (PDOException $e) {
            $conexao->rollBack();

            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erro ao excluir pedido: ' . $e->getMessage()]);
            exit;
        }
    }
}

// Se não for uma requisição DELETE válida
http_response_code(400);
echo json_encode(['success' => false, 'message' => 'Requisição inválida']);
exit;
