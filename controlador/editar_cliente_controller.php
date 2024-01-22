<?php
include('../config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clienteId = $_POST['cliente_id'];
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $celular = $_POST['celular'];
    $cep = $_POST['cep'];
    $endereco_completo = $_POST['endereco_completo'];

    // Atualiza os dados do cliente no banco de dados
    $queryAtualizarCliente = "UPDATE CLIENTES SET nome = :nome, sobrenome = :sobrenome, celular = :celular, cep = :cep, endereco_completo = :endereco_completo WHERE id = :clienteId";
    $stmtAtualizarCliente = $conexao->prepare($queryAtualizarCliente);
    $stmtAtualizarCliente->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmtAtualizarCliente->bindParam(':sobrenome', $sobrenome, PDO::PARAM_STR);
    $stmtAtualizarCliente->bindParam(':celular', $celular, PDO::PARAM_STR);
    $stmtAtualizarCliente->bindParam(':cep', $cep, PDO::PARAM_STR);
    $stmtAtualizarCliente->bindParam(':endereco_completo', $endereco_completo, PDO::PARAM_STR);
    $stmtAtualizarCliente->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmtAtualizarCliente->execute();

    // Redireciona para a página de visualizar clientes após a edição
    header('Location: ../templates/visualizar_clientes.php');
    exit;
}
?>
