<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clienteId = $_POST['cliente_id'];

    // Exclui o cliente do banco de dados
    $queryExcluirCliente = "DELETE FROM CLIENTES WHERE id = :clienteId";
    $stmtExcluirCliente = $conexao->prepare($queryExcluirCliente);
    $stmtExcluirCliente->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmtExcluirCliente->execute();

    // Redireciona para a página de visualizar clientes após a exclusão
    header('Location: ../templates/visualizar_clientes.php');
    exit;
}
?>
