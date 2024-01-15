<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Visualizar Produtos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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