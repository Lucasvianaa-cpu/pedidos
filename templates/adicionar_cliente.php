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

    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color: #f8f9fa;">
        <a class="navbar-brand" href="#">Sistema de Pedidos</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../templates/dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../templates/registrar_pedido.php">Registrar Pedido</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../templates/adicionar_cliente.php">Adicionar Cliente</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../templates/visualizar_produtos.php">Meus Produtos</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../templates/sair.php">
                        <button class="btn btn-danger" style="color: #ffffff;">Sair</button>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

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