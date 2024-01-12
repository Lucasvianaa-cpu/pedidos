<?php
// Inclua o arquivo de configuração
include('../config/config.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém as credenciais do formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Consulta o banco de dados para obter o hash da senha
    $query = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    // Verifica se o usuário foi encontrado
    if ($stmt->rowCount() == 1) {
        $usuarioInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se a senha fornecida corresponde ao hash armazenado
        if (password_verify($senha, $usuarioInfo['senha'])) {
            // Inicia a sessão e armazena informações do usuário
            session_start();
            $_SESSION['usuario_id'] = $usuarioInfo['id'];
            $_SESSION['usuario_nome'] = $usuarioInfo['nome'];

            // Redireciona para a página de dashboard ou outra página após o login
            echo "<script>window.location.href='../templates/dashboard.php';</script>";
            exit();
        } else {
            // Se as credenciais estiverem incorretas, exibe um alerta de JavaScript
            echo "<script>alert('Credenciais inválidas.');</script>";
        }
    } else {
        // Se o usuário não for encontrado, exibe um alerta de JavaScript
        echo "<script>alert('Usuário não encontrado.');</script>";
    }
}

// Se o formulário não foi enviado ou houve erro, redireciona para a página de login
echo "<script>window.location.href='../templates/login.php';</script>";
exit();
?>
