<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Visualizar Clientes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <?php include('menu.php') ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Clientes Cadastrados</h5>
                        <form action="../templates/adicionar_cliente.php" method="post">
                            <div class="mt-4 mb-4">
                                <button type="submit" class="btn btn-primary">Cadastrar Cliente</button>
                            </div>
                        </form>

                        <?php

                        include('../config/config.php');

                        $queryClientes = "SELECT * FROM CLIENTES";

                        $stmtClientes = $conexao->prepare($queryClientes);
                        $stmtClientes->execute();
                        $itensClientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);

                        if ($itensClientes) {
                            echo "<table class='table'>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Sobrenome</th>
                                    <th>Celular</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>";

                            foreach ($itensClientes as $item) {
                                echo "<tr>
                                    <td>{$item['id']}</td>
                                    <td>{$item['nome']}</td>
                                    <td>{$item['sobrenome']}</td>
                                    <td>{$item['celular']}</td>
                                    <td>
                                        <a href='../templates/editar_cliente.php?id={$item['id']}' class='btn btn-warning'>Editar</a>
                                        <a href='../templates/visualizar_cliente.php?id={$item['id']}' class='btn btn-info'>Visualizar</a>
                                        <a href='../templates/excluir_cliente.php?id={$item['id']}' class='btn btn-danger'>Excluir</a>
                                    </td>
                                </tr>";
                            }

                            echo "</tbody>
                        </table>";
                        } else {
                            echo "<p class='text-info'>Nenhum cliente encontrado na listagem de clientes.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
