<!-- editar_item_pedido.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Editar Item do Pedido</title>
    <!-- Inclua os arquivos Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <!-- Barra de navegação -->
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
                        <h5 class="card-title">Editar Item do Pedido</h5>
                        <?php
                        include('../config/config.php');

                        $itemId = isset($_GET['id']) ? $_GET['id'] : null;

                        if ($itemId) {
                            $queryEditarItemPedido = "
                            SELECT 
            itempedido.id, 
            itempedido.quantidade, 
            itempedido.valor_produto, 
            produtos.preco_venda
        FROM itempedido
        INNER JOIN produtos ON itempedido.produto_id = produtos.id
        WHERE itempedido.id = :id";
                            $stmtEditarItemPedido = $conexao->prepare($queryEditarItemPedido);
                            $stmtEditarItemPedido->bindParam(':id', $itemId, PDO::PARAM_INT);
                            $stmtEditarItemPedido->execute();
                            $itemPedido = $stmtEditarItemPedido->fetch(PDO::FETCH_ASSOC);

                            if ($itemPedido) {
                                // Formulário para editar os detalhes do item do pedido
                                echo "<form action='../controlador/editar_item_pedido_controller.php' method='post'>";
                                echo "<input type='hidden' name='id' value='" . $itemPedido['id'] . "'>";
                                echo "<input type='hidden' name='pedido_id' value='" . (isset($itemPedido['pedido_id']) ? $itemPedido['pedido_id'] : '') . "'>";
                                echo "<div class='form-group'>
        <input type='hidden' name='pedido_id' id='pedido_id' value='" . (isset($itemPedido['pedido_id']) ? $itemPedido['pedido_id'] : '') . "'>
        <label for='quantidade'>Quantidade:</label>
        <input type='text' class='form-control' id='quantidade' name='quantidade' value='" . $itemPedido['quantidade'] . "'>
      </div>";

                                echo "<div class='form-group'>
                                        <label for='valor_produto'>Valor Unitário:</label>
                                        <input type='text' class='form-control' id='preco_venda' name='preco_venda' value='" . $itemPedido['preco_venda'] . "'>
                                    </div>";
                                echo "<div class='form-group'>
                                        <label for='valor_produto'>Valor Total:</label>
                                        <input type='text' class='form-control' id='valor_produto' name='valor_produto' value='" . $itemPedido['valor_produto'] . "'>
                                    </div>";
                                echo "<button type='submit' class='btn btn-primary'>Salvar</button>";
                                echo "</form>";
                            } else {
                                echo "<p class='text-danger'>Item do pedido não encontrado.</p>";
                            }
                        } else {
                            echo "<p class='text-danger'>ID do item do pedido não fornecido.</p>";
                        }
                        ?>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <form action="../templates/dashboard.php" method="post">
                            <button type="submit" class="btn btn-primary">Voltar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Adicione os scripts do Bootstrap (copie o código da sua barra de navegação existente) -->
</body>

</html>