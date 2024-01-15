<?php
include('../config/config.php');

// Formulario enviado?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera dados inseridos
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
            session_start();
            $_SESSION['usuario_id'] = $usuarioInfo['id'];
            $_SESSION['usuario_nome'] = $usuarioInfo['nome'];

            echo "<script>window.location.href='../templates/dashboard.php';</script>";
            exit();
        } else {
            echo "<script>alert('Credenciais inválidas.');</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado.');</script>";
    }
}
echo "<script>window.location.href='../templates/login.php';</script>";
exit();
?>
