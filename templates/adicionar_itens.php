<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Adicionar Itens ao Pedido</title>

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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">Adicionar Itens ao Pedido</div>
                    <div class="card-body">
                        <form action="../controlador/processar_itens.php" method="post">
                            <input type="hidden" name="pedido_id" value="<?php echo $_GET['pedido_id']; ?>">
                            <?php

                            include('../config/config.php');
                            $queryProdutos = "SELECT id, nome, preco_venda FROM produtos";
                            $stmtProdutos = $conexao->prepare($queryProdutos);
                            $stmtProdutos->execute();
                            $produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

                            // Lista dos produtos
                            echo "<div class='form-group'>";
                            echo "<label for='produto_id'>Produto:</label>";
                            echo "<select class='form-control' id='produto_id' name='produto_id' required>";
                            echo "<option value='' disabled selected>Selecione o produto</option>";
                            foreach ($produtos as $produto) {
                                echo "<option value='" . $produto['id'] . "'>" . $produto['nome'] . " - R$ " . number_format($produto['preco_venda'], 2, ',', '.') . "</option>";
                            }
                            echo "</select>";
                            echo "</div>";

                            echo "<div class='form-group'>";
                            echo "<label for='quantidade'>Quantidade:</label>";
                            echo "<input type='number' class='form-control' id='quantidade' name='quantidade' required>";
                            echo "</div>";
                            ?>
                            <div class="form-group">
                                <label for="valor_produto">Valor do Produto:</label>
                                <input type="text" class="form-control" id="valor_produto" name="valor_produto" readonly>
                            </div>
                            <button type="submit" class="btn btn-primary">Adicionar Item</button>
                            <button type="button" class="btn btn-primary" id="verPedidoBtn">Ver Pedido</button>
                            <button type="button" class="btn btn-primary" id="voltar">Voltar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        // Script para calcular o valor do produto com base na quantidade selecionada
        $(document).ready(function() {
            $('#quantidade').on('input', function() {
                var quantidade = $(this).val();
                var precoProduto = parseFloat($('#produto_id option:selected').text().split('R$ ')[1].replace(',', '.'));
                var valorProduto = quantidade * precoProduto;
                $('#valor_produto').val(valorProduto.toFixed(2).replace('.', ','));
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('verPedidoBtn').addEventListener('click', function() {
                console.log('Clicou no botão!');

                var queryString = window.location.search;
                var urlParams = new URLSearchParams(queryString);
                var pedidoId = urlParams.get('pedido_id');

                if (pedidoId) {
                    console.log('ID do pedido:', pedidoId);
                    window.location.href = 'visualizar_pedido.php?id=' + pedidoId;
                } else {
                    console.error('ID do pedido não encontrado na URL.');
                }
            });
        });
    </script>



    <script>
        document.getElementById('voltar').addEventListener('click', function() {
            window.location.href = 'dashboard.php';
        });
    </script>

</body>

</html>