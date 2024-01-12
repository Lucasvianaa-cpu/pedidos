<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>

    <!-- Inclua os arquivos Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quantidade Total de Pedidos</h5>
                        <!-- Aqui você precisa buscar a quantidade total de pedidos do banco de dados e exibir -->
                        <?php
                        // Exemplo de como buscar a quantidade total de pedidos
                        include('../config/config.php');
                        $queryQuantidadePedidos = "SELECT COUNT(id) as total_pedidos FROM pedidos";
                        $stmtQuantidadePedidos = $conexao->prepare($queryQuantidadePedidos);
                        $stmtQuantidadePedidos->execute();
                        $resultQuantidadePedidos = $stmtQuantidadePedidos->fetch(PDO::FETCH_ASSOC);
                        echo "<p class='card-text'>" . $resultQuantidadePedidos['total_pedidos'] . "</p>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Valor Total de Pedidos</h5>
                        <!-- Aqui você precisa buscar o valor total de todos os pedidos do banco de dados e exibir -->
                        <?php
                        // Exemplo de como buscar o valor total de todos os pedidos
                        $queryValorTotalPedidos = "SELECT SUM(valor_total) as total_valor FROM pedidos WHERE status != 'Cancelado'";
                        $stmtValorTotalPedidos = $conexao->prepare($queryValorTotalPedidos);
                        $stmtValorTotalPedidos->execute();
                        $resultValorTotalPedidos = $stmtValorTotalPedidos->fetch(PDO::FETCH_ASSOC);
                        echo "<p class='card-text'>" . number_format($resultValorTotalPedidos['total_valor'], 2, ',', '.') . "</p>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">Valor de Pedidos Cancelados</h5>
                        <!-- Aqui você precisa buscar o valor total de todos os pedidos do banco de dados e exibir -->
                        <?php
                        // Exemplo de como buscar o valor total de todos os pedidos
                        $queryValorTotalPedidosCancelados = "SELECT SUM(valor_total) as total_valor FROM pedidos WHERE status = 'Cancelado'";
                        $stmtValorTotalPedidosCancelados = $conexao->prepare($queryValorTotalPedidosCancelados);
                        $stmtValorTotalPedidosCancelados->execute();
                        $resultValorTotalPedidosCancelados = $stmtValorTotalPedidosCancelados->fetch(PDO::FETCH_ASSOC);

                        // Correção aqui: corrigir a variável para $resultValorTotalPedidosCancelados
                        echo "<p class='card-text'>" . number_format($resultValorTotalPedidosCancelados['total_valor'], 2, ',', '.') . "</p>";
                        ?>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Registrar Pedido</h5>
                        <form action="registrar_pedido.php" method="get">
                            <button type="submit" class="btn btn-primary">Adicionar Pedido</button>
                        </form>
                    </div>
                </div>
            </div>



            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lista de Pedidos</h5>
                        <!-- Aqui você precisa buscar a lista de pedidos do banco de dados e exibir -->
                        <?php

                        $pedidosPorPagina = 8;
                        $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                        $offset = ($paginaAtual - 1) * $pedidosPorPagina;

                        $queryListaPedidos = "SELECT pedidos.id, pedidos.valor_total, pedidos.status, clientes.nome, clientes.sobrenome
                        FROM pedidos
                        INNER JOIN clientes ON pedidos.cliente_id = clientes.id
                        LIMIT :offset, :pedidosPorPagina";
                        $stmtListaPedidos = $conexao->prepare($queryListaPedidos);
                        $stmtListaPedidos->bindParam(":offset", $offset, PDO::PARAM_INT);
                        $stmtListaPedidos->bindParam(":pedidosPorPagina", $pedidosPorPagina, PDO::PARAM_INT);
                        $stmtListaPedidos->execute();
                        $resultListaPedidos = $stmtListaPedidos->fetchAll(PDO::FETCH_ASSOC);





                        echo "<ul class='list-group'>";
                        foreach ($resultListaPedidos as $pedido) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'><strong>Pedido #" . $pedido['id'] . "</strong>  Valor: <strong>R$</strong> " . number_format($pedido['valor_total'], 2, ',', '.') . "  <strong>Cliente: </strong>" . $pedido['nome'] . ' ' . $pedido['sobrenome'] . " <strong> Status: </strong>" . $pedido['status'] . "
                                <div class='btn-group'>
                                    <a href='visualizar_pedido.php?id=" . $pedido['id'] . "' class='btn btn-outline-primary'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor'class='bi bi-eye' viewBox='0 0 16 16'>
                                    <path d='M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z'/>
                                    <path d='M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0'/>
                                    </svg> Visualizar</a>

                                    <a href='editar_pedido.php?id=" . $pedido['id'] . "' class='btn btn-outline-warning'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325'/>
                                    </svg> Editar</a>
                                
        

                                    
                                    <a href='#' class='btn btn-outline-danger delete-btn' data-id='" . $pedido['id'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
                                    <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5'/>
                                    </svg> Deletar
                                    </a>


                                    <a href='#' class='btn btn-outline-secondary cancelar-btn' data-id='" . $pedido['id'] . "'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
                                    <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5'/>
                                    </svg> Cancelar
                                    </a>
    
                                </div>
                            </li>";
                        }
                        echo "</ul>";


                        $queryTotalPedidos = "SELECT COUNT(*) as total FROM pedidos";
                        $stmtTotalPedidos = $conexao->query($queryTotalPedidos);
                        $totalPedidos = $stmtTotalPedidos->fetchColumn();
                        $totalPaginas = ceil($totalPedidos / $pedidosPorPagina);

                        echo "<div class='pagination justify-content-center mt-4'>";
                        echo "<ul class='pagination'>";
                        $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

                        for ($i = 1; $i <= $totalPaginas; $i++) {
                            $classeAtiva = ($pagina == $i) ? 'active' : '';
                            echo "<li class='page-item {$classeAtiva}'><a class='page-link' href='?pagina={$i}'>{$i}</a></li>";
                        }

                        echo "</ul>";
                        echo "</div>";

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Adicione este script antes do fechamento da tag </body> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            console.log('Botões de exclusão:', deleteButtons);

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();

                    const confirmDelete = confirm('Deseja realmente excluir este pedido?');

                    if (confirmDelete) {
                        const pedidoId = this.getAttribute('data-id');

                        // Aqui você pode enviar uma requisição AJAX para o servidor para excluir o pedido
                        // Exemplo usando Fetch API
                        fetch('../controlador/deletar_pedido_controller.php?id=' + pedidoId, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                            })
                            .then(response => {
                                if (response.headers.get('content-type') && response.headers.get('content-type').indexOf('application/json') !== -1) {
                                    return response.json();
                                } else {
                                    // Se a resposta não for JSON, retorna um objeto indicando sucesso
                                    return {
                                        success: true
                                    };
                                }
                            })
                            .then(data => {
                                // Lidar com a resposta do servidor
                                console.log(data);

                                // Verificar se a exclusão foi bem-sucedida
                                if (data.success) {
                                    // Recarregue a página ou atualize a lista de pedidos
                                    location.reload();
                                } else {
                                    // Se houver uma mensagem de erro, exibir ao usuário
                                    if (data.message) {
                                        alert('Erro ao excluir pedido: ' + data.message);
                                    }
                                }
                            })
                            .catch(error => console.error('Erro ao excluir pedido:', error));
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Adiciona um evento de clique ao botão de cancelar
            $('.cancelar-btn').on('click', function(e) {
                // Impede o comportamento padrão do link
                e.preventDefault();

                // Obtém o ID do pedido a partir do atributo data-id
                var pedidoId = $(this).data('id');

                // Cria um formulário dinâmico
                var form = $('<form action="../controlador/cancelar_pedido_controller.php" method="post">' +
                    '<input type="hidden" name="pedido_id" value="' + pedidoId + '">' +
                    '</form>');

                // Anexa o formulário ao corpo do documento
                $('body').append(form);

                // Submete o formulário
                form.submit();
            });
        });
    </script>

</body>

</html>