<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cadastrar Produto</title>

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
        <divs class="collapse navbar-collapse" id="navbarNav">
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
                    <div class="card-header text-center">Adicionar Produto</div>
                    <div class="card-body">
                        <form action="../controlador/adicionar_produto.php" method="post">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="preco_venda">Preço Venda:</label>
                                <input type="decimal" class="form-control" id="preco_venda" name="preco_venda" required>
                            </div>
                            <div class="form-group">
                                <label for="saldo_estoque">Saldo em Estoque:</label>
                                <input type="text" class="form-control" id="saldo_estoque" name="saldo_estoque" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Registrar Produto</button>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <form action="../templates/visualizar_produtos.php" method="post">
                        <button type="submit" class="btn btn-primary">Voltar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>

</html>