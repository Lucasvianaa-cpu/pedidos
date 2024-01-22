<?php
include('../config/config.php');

// Verifica se o ID do cliente foi fornecido na URL
if (isset($_GET['id'])) {
    $produtoId = $_GET['id'];

   
    $queryProduto = "SELECT * FROM PRODUTOS WHERE id = :produtoId";
    $stmtProduto = $conexao->prepare($queryProduto);
    $stmtProduto->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
    $stmtProduto->execute();
    $dadosProduto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

    if ($dadosProduto) {
        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Editar Produto</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        </head>

        <body>
            <?php include('menu.php') ?>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Editar Produto</h5>
                                <form action="../controlador/editar_produto_controller.php" method="post">
                                    <input type="hidden" name="produto_id" value="<?php echo $dadosProduto['id']; ?>">

                                    <div class="form-group">
                                        <label for="nome">Nome:</label>
                                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $dadosProduto['nome']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="preco_venda">Preço de Venda:</label>
                                        <input type="text" class="form-control" id="preco_venda" name="preco_venda" value="<?php echo $dadosProduto['preco_venda']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="saldo_estoque">Saldo Estoque</label>
                                        <input type="text" class="form-control" id="saldo_estoque" name="saldo_estoque" value="<?php echo $dadosProduto['saldo_estoque']; ?>" required>
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
