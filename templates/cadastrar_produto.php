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

    <?php include('menu.php') ?>

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