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
                        <h5 class="card-title">Editar Pedido</h5>
                        <?php
                        include('../config/config.php');

                        $pedidoId = isset($_GET['id']) ? $_GET['id'] : null;

                        if ($pedidoId) {
                            $queryEditarPedido = "SELECT * FROM pedidos WHERE id = :id";
                            $stmtEditarPedido = $conexao->prepare($queryEditarPedido);
                            $stmtEditarPedido->bindParam(':id', $pedidoId, PDO::PARAM_INT);
                            $stmtEditarPedido->execute();
                            $pedido = $stmtEditarPedido->fetch(PDO::FETCH_ASSOC);

                            if ($pedido) {
                                // Formulário para editar os detalhes do pedido
                                echo "<form action='../controlador/editar_pedido_controller.php' method='post'>";
                                echo "<input type='hidden' name='id' value='" . $pedido['id'] . "'>";
                                echo "<div class='form-group'>
                                        <label for='valor_total'>Valor Total:</label>
                                        <input type='text' class='form-control' readonly id='valor_total' name='valor_total' value='" . $pedido['valor_total'] . "'>
                                    </div>";
                                echo "<div class='form-group'>
                                        <label for='status'>Status:</label>
                                        <input type='text' class='form-control' id='status' name='status' value='" . $pedido['status'] . "'>
                                    </div>";
                                echo "<button type='submit' class='btn btn-primary'>Salvar Alteração e Voltar ao Painel</button>";
                                echo "</form>";
                            } else {
                                echo "<p class='text-danger'>Pedido não encontrado.</p>";
                            }
                        } else {
                            echo "<p class='text-danger'>ID do pedido não fornecido.</p>";
                        }
                        ?>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="card">

                            <div class="card-body text-center">
                                <form action="adicionar_itens.php" method="get">
                                    <input type="hidden" id="pedido_id" name="pedido_id" value="<?= $pedido['id'] ?>">
                                    <button type="submit" class="btn btn-primary">Adicionar Item</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Itens do Pedido</h5>
                        <?php
                        // todos itens pedidos
                        $queryItensPedido = "SELECT itempedido.id, itempedido.quantidade, itempedido.valor_produto, itempedido.pedido_id, produtos.nome AS nome_produto
                             FROM itempedido
                             INNER JOIN produtos ON itempedido.produto_id = produtos.id
                             WHERE itempedido.pedido_id = :pedido_id";

                        $stmtItensPedido = $conexao->prepare($queryItensPedido);
                        $stmtItensPedido->bindParam(':pedido_id', $pedidoId, PDO::PARAM_INT);
                        $stmtItensPedido->execute();
                        $itensPedido = $stmtItensPedido->fetchAll(PDO::FETCH_ASSOC);

                        // Listagem dos itens no pedido
                        echo "<table class='table'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Valor Total (Qtd * Unit)</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>";

                        foreach ($itensPedido as $item) {

                            echo "<tr>
            <td>{$item['id']}</td>
            <td>{$item['nome_produto']}</td>
            <td>{$item['quantidade']}</td>
            <td>{$item['valor_produto']}</td>
            <td>
            <form action='../controlador/editar_item_pedido_controller.php' method='post'>
            <input type='hidden' name='id' value='{$item['id']}'>
            <input type='hidden' name='nome_produto' id='nome_produto' value='{$item['nome_produto']}'>
            <input type='hidden' name='quantidade' id='quantidade' value='{$item['quantidade']}'>
            <input type='hidden' name='valor_produto' id='valor_produto' value='{$item['valor_produto']}'>
            <button type='submit' class='btn btn-outline-primary'>Editar</button>
            <a href='../controlador/excluir_item_pedido_controller.php?id={$item['id']}' class='btn btn-outline-danger'>Excluir</a>
        </form>
       
            </td>
          </tr>";
                        }


                        echo "
                                </tbody>
                        </table>";
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>