<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Pedido</title>
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
                        <h5 class="card-title">Aqui está seu pedido:</h5>
                        <?php
                        include('../config/config.php');

                        $pedidoId = isset($_GET['id']) ? $_GET['id'] : null;


                        if ($pedidoId) {
                            $queryEditarPedido = "SELECT * FROM pedidos WHERE id = :id";
                            $stmtEditarPedido = $conexao->prepare($queryEditarPedido);
                            $stmtEditarPedido->bindParam(':id', $pedidoId, PDO::PARAM_INT);
                            $stmtEditarPedido->execute();
                            $rowPedido = $stmtEditarPedido->fetch(PDO::FETCH_ASSOC);

                            $queryItensPedido = "SELECT valor_produto FROM itempedido WHERE pedido_id = :pedido_id";
                            $stmtItensPedido = $conexao->prepare($queryItensPedido);
                            $stmtItensPedido->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
                            $stmtItensPedido->execute();
                            $itensPedido = $stmtItensPedido->fetchAll(PDO::FETCH_ASSOC);

                            if ($itensPedido) {
                                $valorTotalPedido = 0;
                        
                                foreach ($itensPedido as $item) {
                                    $valorTotalPedido += $item['valor_produto'];
                                }
                                $queryUpdatePedido = "UPDATE pedidos SET valor_total = :valor_total WHERE id = :pedido_id";
                                $stmtUpdatePedido = $conexao->prepare($queryUpdatePedido);
                                $stmtUpdatePedido->bindParam(':valor_total', $valorTotalPedido, PDO::PARAM_STR);
                                $stmtUpdatePedido->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
                                $stmtUpdatePedido->execute();


                            if ($rowPedido) {
                                echo "<p><strong>Código:</strong> " .  $rowPedido['id'] . "</p>";
                                echo "<p><strong>Valor Total:</strong> " . number_format($valorTotalPedido, 2, ',', '.') . "</p>";
                                echo "<p><strong>Status:</strong> " . $rowPedido['status'] . "</p>";
                            } else {
                                echo "<p class='text-danger'>Pedido não encontrado.</p>";
                            }
                        } else {
                            echo "<p class='text-danger'>ID do pedido não fornecido.</p>";
                        }
                    }
                        ?>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Itens do Pedido</h5>
                        <?php
                        $queryItensPedido = "SELECT itempedido.id, itempedido.quantidade, itempedido.valor_produto, produtos.preco_venda, produtos.nome AS nome_produto
                     FROM itempedido
                     INNER JOIN produtos ON itempedido.produto_id = produtos.id
                     WHERE itempedido.pedido_id = :pedido_id";


                        $stmtItensPedido = $conexao->prepare($queryItensPedido);
                        $stmtItensPedido->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
                        $stmtItensPedido->execute();
                        $itensPedido = $stmtItensPedido->fetchAll(PDO::FETCH_ASSOC);

                        if ($itensPedido) {
                            echo "<table class='table'>
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Produto</th>
                                            <th>Quantidade</th>
                                            <th>Preço do Produto Original</th>
                                            <th>Valor Total do Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                            foreach ($itensPedido as $item) {
                                $valorTotalItem = $item['valor_produto'];



                                echo "<tr>
                                            <td>{$item['id']}</td>
                                            <td>{$item['nome_produto']}</td>
                                            <td>{$item['quantidade']}</td>
                                            <td>" . number_format($item['preco_venda'], 2, ',', '.') . "</td>
                                            <td>" . number_format($valorTotalItem, 2, ',', '.') . "</td>
                                        </tr>";
                            }

                            echo "</tbody>
                                  </table>";
                        } else {
                            echo "<p class='text-info'>Nenhum item encontrado para este pedido.</p>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>