<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Minhas Planilhas</title>
    <link rel="stylesheet" href="styles/style_planilha_exibicao.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark shadow">
            <div class="text-left text-white p-3">
                <h1>Minhas Planilhas</h1>
            </div>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary" href="logado.php">Voltar</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <?php
    require_once "banco.php";
    session_start();

    $usu = $_SESSION['usuario'];
    $tabela = "planilha_" . $banco->real_escape_string($usu);
    $consulta = "SELECT cod, nome_planilha FROM $tabela";
    $resultado = $banco->query($consulta);

    if (isset($_GET['treino'])) {
        $nomeTreino = $_GET['treino'];
    
        $consulta = "SELECT * FROM planilha_pronta_A WHERE nome_treino = ?";
        $stmt = $banco->prepare($consulta);
        $stmt->bind_param("s", $nomeTreino);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            echo '<div class="container mt-5">';
            echo '<div class="row">';
            echo '<div class="col-md-12">';
            echo '<div class="table-responsive mb-4">';
            echo '<table class="table table-bordered table-striped table-hover">';
            echo '<thead>';
            echo '<h2>' . $nomeTreino .'<h2>';
            echo '<tr>';
            echo '<th>Exercício</th>';
            echo '<th>Séries</th>';
            echo '<th>Repetições</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
    
            while ($row = $resultado->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['nome_exercicio'] . '</td>';
                echo '<td>' . $row['series'] . '</td>';
                echo '<td>' . $row['repeticoes'] . '</td>';
                echo '</tr>';
            }
    
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<p>Nenhum exercício encontrado para o treino selecionado.</p>';
        }
    
        $stmt->close();
    }

    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) {
            echo  '<div class="container mt-5">';
            echo '<div class="row">';
            echo   '<div class="col-md-12">';
            echo '<div class="table-responsive mb-4">';
            echo '<table class="table table-bordered table-striped table-hover">';
            echo '<thead class="">';
            echo '<h2>Nome da planilha: ' . $row['nome_planilha'] . '</h2';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Exercício</th>';
            echo '<th>Séries</th>';
            echo '<th>Repetições</th>';
            echo '<th>Ações</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            for ($i = 0; $i < 10; $i++) {
                $colunaExercicio = "exercicio$i";
                $result = $banco->query("SHOW COLUMNS FROM $tabela LIKE '$colunaExercicio'");

                if ($result->num_rows > 0) {
                    $buscaExercicio = $banco->query("SELECT $colunaExercicio FROM $tabela WHERE cod = {$row['cod']} AND $colunaExercicio IS NOT NULL");

                    if ($buscaExercicio->num_rows > 0) {
                        while ($exercicioRow = $buscaExercicio->fetch_assoc()) {
                            $exercicioCod = $exercicioRow[$colunaExercicio];
                            $detalhesExercicio = $banco->query("SELECT nome, series, repeticoes FROM exercicios WHERE cod = $exercicioCod");

                            if ($detalhesExercicio->num_rows > 0) {
                                $detalhes = $detalhesExercicio->fetch_assoc();
                                echo '<tr>';
                                echo '<td>' . $exercicioCod . '</td>';
                                echo '<td>' . $detalhes['nome'] . '</td>';
                                echo '<td>' . $detalhes['series'] . '</td>';
                                echo '<td>' . $detalhes['repeticoes'] . '</td>';
                                echo '<td>';
                                echo    '<a href="excluirExercicio.php?id=' . $exercicioCod . '" class="btn btn-primary btn-sm">Excluir</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        }
                    }
                }
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo ' </div>';
            echo'</div>';
            echo'</div>';
        }
    } else {
        echo '<p>Nenhuma planilha encontrada.</p>';
    }

    $banco->close();
    ?>




    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>