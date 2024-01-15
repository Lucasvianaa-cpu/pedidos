<?php
include('../config/config.php');

// Formulario Enviado?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados
    $nome = $_POST["nome"];
    $sobrenome = $_POST["sobrenome"];
    $celular = $_POST["celular"];
    $cep = $_POST["cep"];
    $endereco_completo = $_POST["endereco_completo"];

    
    $query = "INSERT INTO clientes (nome, sobrenome, celular, cep, endereco_completo) VALUES (:nome, :sobrenome, :celular, :cep, :endereco_completo)";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":sobrenome", $sobrenome);
    $stmt->bindParam(":celular", $celular);
    $stmt->bindParam(":cep", $cep);
    $stmt->bindParam(":endereco_completo", $endereco_completo);
    $stmt->execute();
} else {
    header("Location: ../templates/cadastrar.php");
    exit();
}

header("Location: ../templates/dashboard.php");
