<?php
include('../config/config.php');

// Verifica se o ID do cliente foi fornecido na URL
if (isset($_GET['id'])) {
    $produtoId = $_GET['id'];

    // Obtém os dados do cliente
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
            <title>Visualizar Produto</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        </head>

        <body>
            <?php include('menu.php') ?>

            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Detalhes do Produto</h5>
                                <p><strong>ID:</strong> <?php echo $dadosProduto['id']; ?></p>
                                <p><strong>Nome:</strong> <?php echo $dadosProduto['nome']; ?></p>
                                <p><strong>Valor Venda:</strong> <?php echo $dadosProduto['preco_venda']; ?></p>
                                <p><strong>Saldo Estoque:</strong> <?php echo $dadosProduto['saldo_estoque']; ?></p>
                            
                                <a href="../templates/visualizar_produtos.php" class="btn btn-primary">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </body>

        </html>
        <?php
    } else {
        echo "Produto não encontrado.";
    }
} else {
    echo "ID do produto não fornecido na URL.";
}
?>
