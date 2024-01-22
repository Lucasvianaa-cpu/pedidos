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
        // Os dados do cliente foram encontrados, exiba o formulário de edição
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Editar Cliente</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        </head>

        <body>
            <?php include('menu.php') ?>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Editar Cliente</h5>
                                <form action="../controlador/editar_cliente_controller.php" method="post">
                                    <input type="hidden" name="cliente_id" value="<?php echo $dadosCliente['id']; ?>">

                                    <div class="form-group">
                                        <label for="nome">Nome:</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $dadosCliente['nome']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="sobrenome">Sobrenome:</label>
                                        <input type="text" class="form-control" id="sobrenome" name="sobrenome" value="<?php echo $dadosCliente['sobrenome']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="celular">Celular:</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $dadosCliente['celular']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cep">CEP:</label>
                                        <input type="text" class="form-control" id="cep" name="cep" value="<?php echo $dadosCliente['cep']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="endereco_completo">Endereço Completo:</label>
                                        <input type="text" class="form-control" id="endereco_completo" name="endereco_completo" value="<?php echo $dadosCliente['endereco_completo']; ?>" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
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
