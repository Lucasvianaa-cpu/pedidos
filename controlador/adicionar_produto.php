<?php
include('../config/config.php');

// Formulario Enviado?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados
    $nome = $_POST["nome"];
    $preco_venda = $_POST["preco_venda"];
    $saldo_estoque = $_POST["saldo_estoque"];
   

    
    $query = "INSERT INTO produtos (nome, preco_venda, saldo_estoque) VALUES (:nome, :preco_venda, :saldo_estoque)";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":preco_venda", $preco_venda);
    $stmt->bindParam(":saldo_estoque", $saldo_estoque);
    $stmt->execute();
} else {
    header("Location: ../templates/dashboard.php");
    exit();
}

header("Location: ../templates/visualizar_produtos.php");
