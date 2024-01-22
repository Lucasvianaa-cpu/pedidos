<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manutenção de Estoque</title>

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
                    <div class="card-header text-center">Manutenção de Estoque</div>
                    <div class="card-body">
                        <form action="../controlador/manutencao_saldo_estoque.php" method="post">
                            <?php


                            include('../config/config.php');
                            $queryProdutos = "SELECT id, nome, saldo_estoque FROM produtos";
                            $stmtProdutos = $conexao->prepare($queryProdutos);
                            $stmtProdutos->execute();
                            $produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

                            // Lista dos produtos
                            echo "<div class='form-group'>";
                            echo "<label for='produto_id'>Produto:</label>";
                            echo "<select class='form-control' id='produto_id' name='produto_id' required>";
                            echo "<option value='' disabled selected>Selecione o produto</option>";
                            foreach ($produtos as $produto) {
                                echo "<option value='" . $produto['id'] . "'>" . $produto['nome'] . " - "  . $produto['saldo_estoque'] . "</option>";
                            }
                            echo "</select>";
                            echo "</div>";

                            ?>
                            <div class="form-group">
                                <label for="alteracao_saldo">Alteração de Saldo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn btn-secondary" name="acao" value="subtrair">-</button>
                                    </div>
                                    <input type="number" class="form-control" id="alteracao_saldo" name="alteracao_saldo" placeholder="Digite o valor">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary" name="acao" value="adicionar">+</button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="voltar">Voltar</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script>
        document.getElementById('voltar').addEventListener('click', function() {
            window.location.href = 'visualizar_produtos.php';
        });
    </script>











</body>

</html>