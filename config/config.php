<?php

$host = 'localhost'; 
$usuario = 'root'; 
$senha = ''; 
$banco = 'bd_pedidos'; 

try {
    $conexao = new PDO("mysql:host=$host;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->exec("SET NAMES utf8");
} catch (PDOException $erro) {
    echo "Erro na conexão: " . $erro->getMessage();
    exit();
}
