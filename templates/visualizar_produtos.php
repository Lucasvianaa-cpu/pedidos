<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Visualizar Produtos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <?php include ('menu.php') ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Listagem de Produtos</h5>
                        <form action="../templates/cadastrar_produto.php" method="post">
                            <button type="submit" class="btn btn-primary mt-4 mb-4">Cadastrar Produto</button>
                        </form>

                        <?php

                        include('../config/config.php');

                        $queryProdutos = "SELECT * FROM PRODUTOS";

                        $stmtProdutos = $conexao->prepare($queryProdutos);
                        $stmtProdutos->execute();
                        $itensProdutos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

                        if ($itensProdutos) {
                            echo "<table class='table'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Saldo em Estoque</th>
                                    <th>Preço do Produto</th>
                                    <th>Valor Total do Item</th>
                                </tr>
                            </thead>
                            <tbody>";

                            foreach ($itensProdutos as $item) {
                                $valorTotalItem = $item['saldo_estoque'] * $item['preco_venda'];

                                echo "<tr>
                                    <td>{$item['id']}</td>
                                    <td>{$item['nome']}</td>
                                    <td>{$item['saldo_estoque']}</td>
                                    <td>" . number_format($item['preco_venda'], 2, ',', '.') . "</td>
                                    <td>" . number_format($valorTotalItem, 2, ',', '.') . "</td>
                                </tr>";
                            }

                            echo "</tbody>
                        </table>";
                        } else {
                            echo "<p class='text-info'>Nenhum item encontrado na listagem de produtos.</p>";
                        }
                        ?>
                    </div>
                </div>



            </div>
        </div>
    </div>

</body>

</html>