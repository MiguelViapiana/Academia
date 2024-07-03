<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Treinos Prontos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style_logado.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark shadow">
            <div class="text-left text-white p-3">
                <h1>Meus Treinos Prontos</h1>
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

    <section class="container mt-5">
    <?php
    require_once "banco.php";
    session_start();

    function exibirTreino($banco, $nomeTreino) {

        $consulta = "SELECT * FROM planilha_pronta_a WHERE nome_treino = ?";
        $stmt = $banco->prepare($consulta);
    
        if (!$stmt) {
            die('Erro na preparação da consulta: ' . $banco->error);
        }
    
        $stmt->bind_param("s", $nomeTreino);
        $stmt->execute();
    
        if ($stmt->error) {
            die('Erro na execução da consulta: ' . $stmt->error);
        }
    
        $resultado = $stmt->get_result();
    
        if ($resultado->num_rows > 0) {
            echo '<div class="container mt-5">';
            echo '<div class="row">';
            echo '<div class="col-md-12">';
            echo '<div class="table-responsive mb-4">';
            echo '<h2>' . $nomeTreino . '</h2>';
            echo '<table class="table table-bordered table-striped table-hover">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Exercício</th>';
            echo '<th>Peso</th>';
            echo '<th>Séries</th>';
            echo '<th>Repetições</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
    
            while ($row = $resultado->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row['nome_exercicio'] . '</td>';
                echo '<td>' . $row['peso'] . '</td>';
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
            echo '<p>Nenhum exercício encontrado para ' . $nomeTreino . '.</p>';
        }
    
        $stmt->close();
    }

    if (isset($_GET['treino'])) {
        // Exibir apenas o treino específico
        $nomeTreino = $_GET['treino'];
        exibirTreino($banco, $nomeTreino);
    } else {
        // Exibir os três treinos
        exibirTreino($banco, 'Treino A');
        exibirTreino($banco, 'Treino B');
        exibirTreino($banco, 'Treino C');
    }

    $banco->close();
    ?>
    </section>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>