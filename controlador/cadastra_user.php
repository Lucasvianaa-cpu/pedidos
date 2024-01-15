<?php
include('../config/config.php');

// Formulario Enviado?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o novo usuário no banco de dados
    $query = "INSERT INTO usuarios (nome, email, usuario, senha) VALUES (:nome, :email, :usuario, :senha)";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->bindParam(":senha", $senhaHash);
    $stmt->execute();

    try {
        $stmt->execute();
        // Redireciona para a página de login após o registro bem-sucedido
        header("Location: ../templates/login.php?cadastrar=sucesso");
        exit();
    } catch (PDOException $e) {
        // Em caso de erro, redireciona de volta para a página de registro com mensagem de erro
        header("Location: ../templates/cadastrar.php?erro=" . $e->getMessage());
        exit();
    }
} else {
    header("Location: ../templates/cadastrar.php");
    exit();
}
