<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $pedidoId = isset($_GET['id']) ? $_GET['id'] : null;

    if ($pedidoId) {
        try {
            // Iniciar uma transação para garantir atomicidade das operações
            $conexao->beginTransaction();

            // Excluir registros relacionados na tabela itempedido
            $queryExcluirItensPedido = "DELETE FROM itempedido WHERE pedido_id = :pedido_id";
            $stmtExcluirItensPedido = $conexao->prepare($queryExcluirItensPedido);
            $stmtExcluirItensPedido->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
            $stmtExcluirItensPedido->execute();

            // Excluir o próprio pedido
            $queryExcluirPedido = "DELETE FROM pedidos WHERE id = :id";
            $stmtExcluirPedido = $conexao->prepare($queryExcluirPedido);
            $stmtExcluirPedido->bindParam(':id', $pedidoId, PDO::PARAM_INT);
            
            if ($stmtExcluirPedido->execute()) {
                // Commit da transação se tudo estiver bem
                $conexao->commit();

                // Resposta de sucesso
                echo json_encode(['success' => true]);
                exit;
            } else {
                // Se ocorrer um erro, rollback da transação
                $conexao->rollBack();

                // Resposta de erro
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Erro ao excluir pedido']);
                exit;
            }
        } catch (PDOException $e) {
            // Se ocorrer um erro durante a transação, rollback e resposta de erro
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
