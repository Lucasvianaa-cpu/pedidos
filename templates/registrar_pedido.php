<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrar Pedido</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>

    <?php include('menu.php') ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Registrar Pedido</div>
                    <div class="card-body">
                        <form action="../controlador/adicionar_pedido.php" method="post">
                            <div class="form-group">
                                <label for="cliente_id">Cliente:</label>
                                <?php
                                include('../config/config.php');

                                $queryClientes = "SELECT id, nome, sobrenome FROM clientes";
                                $stmtClientes = $conexao->prepare($queryClientes);
                                $stmtClientes->execute();
                                $clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);

                                echo "<select class='form-control' id='cliente_id' name='cliente_id' required>";
                                echo "<option value='' disabled selected>Selecione o cliente</option>";

                                foreach ($clientes as $cliente) {
                                    echo "<option value='" . $cliente['id'] . "'>" . $cliente['nome'] . ' ' . $cliente['sobrenome'] . "</option>";
                                }

                                echo "</select>";
                                ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar Pedido</button>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <form action="../templates/dashboard.php" method="post">
                        <button type="submit" class="btn btn-primary">Voltar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>


</html>