<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Visualizar Produtos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <?php include('menu.php') ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Listagem de Produtos</h5>
                        <form action="../templates/cadastrar_produto.php" method="post">
                            <div class="mt-4 mb-4">
                                <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
                                <button type="submit" formaction="../templates/manutencao_estoque.php"
                                    class="btn btn-primary ml-2">Manutenção de Estoque</button>
                            </div>
                        </form>

                        <?php
                        include('../config/config.php');

                        // Defina a quantidade de produtos por página
                        $produtosPorPagina = 5;

                        // Obtenha o número total de produtos
                        $queryTotalProdutos = "SELECT COUNT(*) AS total FROM PRODUTOS WHERE ativo = 1";
                        $stmtTotalProdutos = $conexao->prepare($queryTotalProdutos);
                        $stmtTotalProdutos->execute();
                        $totalProdutos = $stmtTotalProdutos->fetch(PDO::FETCH_ASSOC)['total'];

                        // Calcule o número total de páginas
                        $totalPaginas = ceil($totalProdutos / $produtosPorPagina);

                        // Obtenha a página atual
                        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                        // Calcule o índice de início para a consulta SQL
                        $indiceInicio = ($paginaAtual - 1) * $produtosPorPagina;

                        // Consulta SQL modificada com LIMIT para paginação
                        $queryProdutos = "SELECT * FROM PRODUTOS WHERE ativo = 1 LIMIT :indiceInicio, :produtosPorPagina";
                        $stmtProdutos = $conexao->prepare($queryProdutos);
                        $stmtProdutos->bindParam(':indiceInicio', $indiceInicio, PDO::PARAM_INT);
                        $stmtProdutos->bindParam(':produtosPorPagina', $produtosPorPagina, PDO::PARAM_INT);
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
                                    <th>Ações</th>
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
                                    <td>
                                        <a href='../templates/editar_produto.php?id={$item['id']}' class='btn btn-warning'>Editar</a>
                                        <a href='../templates/visualizar_produto.php?id={$item['id']}' class='btn btn-info'>Visualizar</a>
                                        <a href='../templates/excluir_produto.php?id={$item['id']}' class='btn btn-danger'>Excluir</a>
                                    </td>
                                </tr>";
                            }

                            echo "</tbody>
                        </table>";

                            // Adicione a navegação da página
                            echo "<nav aria-label='Page navigation example'>
                                    <ul class='pagination'>";

                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                echo "<li class='page-item " . ($i == $paginaAtual ? 'active' : '') . "'>
                                        <a class='page-link' href='?pagina={$i}'>{$i}</a>
                                      </li>";
                            }

                            echo "</ul>
                                </nav>";
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
