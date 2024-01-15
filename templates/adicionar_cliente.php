<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Registrar Cliente</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>

<body>

    <?php include ('menu.php') ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Registrar Cliente</div>
                    <div class="card-body">
                        <form action="../controlador/adicionar_cliente.php" method="post">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="sobrenome">Sobrenome:</label>
                                <input type="text" class="form-control" id="sobrenome" name="sobrenome" required>
                            </div>
                            <div class="form-group">
                                <label for="celular">Celular:</label>
                                <input type="text" class="form-control" id="celular" name="celular" required>
                            </div>
                            <div class="form-group">
                                <label for="cep">CEP:</label>
                                <input type="text" class="form-control" id="cep" name="cep" required>
                            </div>
                            <div class="form-group">
                                <label for="endereco_completo">Endereço Completo:</label>
                                <input type="text" class="form-control" id="endereco_completo" name="endereco_completo" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar Cliente</button>
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