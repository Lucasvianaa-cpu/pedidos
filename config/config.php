<?php

// Configurações do banco de dados
$host = 'localhost'; // endereço do banco de dados
$usuario = 'root'; // nome de usuário do banco de dados
$senha = ''; // senha do banco de dados
$banco = 'bd_pedidos'; // nome do banco de dados

try {
    $conexao = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("SET NAMES utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão: " . $erro->getMessage();
    exit();
}
