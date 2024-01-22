<?php
include('../config/config.php');

// Verifica se o ID do cliente foi fornecido na URL
if (isset($_GET['id'])) {
    $clienteId = $_GET['id'];

    // Obtém os dados do cliente
    $queryCliente = "SELECT * FROM CLIENTES WHERE id = :clienteId";
    $stmtCliente = $conexao->prepare($queryCliente);
    $stmtCliente->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmtCliente->execute();
    $dadosCliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

    if ($dadosCliente) {
        // Os dados do cliente foram encontrados, exiba o formulário de confirmação
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Excluir Cliente</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        </head>

        <body>
            <?php include('menu.php') ?>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Excluir Cliente</h5>
                                <p>Tem certeza de que deseja excluir o cliente:</p>
                                <p><strong>ID:</strong> <?php echo $dadosCliente['id']; ?></p>
                                <p><strong>Nome:</strong> <?php echo $dadosCliente['nome']; ?></p>
                                <p><strong>Sobrenome:</strong> <?php echo $dadosCliente['sobrenome']; ?></p>
                                <p><strong>Celular:</strong> <?php echo $dadosCliente['celular']; ?></p>
                                <p><strong>CEP:</strong> <?php echo $dadosCliente['cep']; ?></p>
                                <p><strong>Endereço:</strong> <?php echo $dadosCliente['endereco_completo']; ?></p>
                                <form action="../controlador/excluir_cliente_controller.php" method="post">
                                    <input type="hidden" name="cliente_id" value="<?php echo $dadosCliente['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
                                    <a href="../templates/visualizar_clientes.php" class="btn btn-primary">Cancelar</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </body>

        </html>
        <?php
    } else {
        echo "Cliente não encontrado.";
    }
} else {
    echo "ID do cliente não fornecido na URL.";
}
?>
