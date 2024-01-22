<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = isset($_POST['acao']) ? $_POST['acao'] : '';

    // Obtém o saldo atual do produto
    $produtoId = $_POST['produto_id'];
    $querySaldoAtual = "SELECT saldo_estoque FROM produtos WHERE id = :produtoId";
    $stmtSaldoAtual = $conexao->prepare($querySaldoAtual);
    $stmtSaldoAtual->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
    $stmtSaldoAtual->execute();
    $resultadoSaldoAtual = $stmtSaldoAtual->fetch(PDO::FETCH_ASSOC);

    // Verifica se o resultado da consulta é válido
    if ($resultadoSaldoAtual) {
        $saldoAtual = $resultadoSaldoAtual['saldo_estoque'];

        if ($acao === 'adicionar') {
            // Lógica para adicionar ao saldo (exemplo)
            $alteracaoSaldo = $_POST['alteracao_saldo'];
            $novoSaldo = $saldoAtual + $alteracaoSaldo;
        } elseif ($acao === 'subtrair') {
            // Lógica para subtrair do saldo (exemplo)
            $alteracaoSaldo = $_POST['alteracao_saldo'];
            
            // Garante que o saldo não se torne negativo
            $novoSaldo = max(0, $saldoAtual - $alteracaoSaldo);
        }

        // Atualizar o saldo no banco de dados (exemplo)
        $queryAtualizarSaldo = "UPDATE produtos SET saldo_estoque = :novoSaldo WHERE id = :produtoId";
        $stmtAtualizarSaldo = $conexao->prepare($queryAtualizarSaldo);
        $stmtAtualizarSaldo->bindParam(':novoSaldo', $novoSaldo, PDO::PARAM_INT);
        $stmtAtualizarSaldo->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
        $stmtAtualizarSaldo->execute();

        // Redirecionar de volta à página de visualização de produtos
        header('Location: ../templates/visualizar_produtos.php');
        exit;
    } else {
        echo "Erro: Produto não encontrado.";
        // Você pode adicionar um redirecionamento ou manipular o erro de outra forma, conforme necessário.
    }
}
?>
