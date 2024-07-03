<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planilha de Treino</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/style_logado.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark"">
        <a class="navbar-brand " href="#">Planilha de Treino</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="btn btn-outline-light mx-1" href="mostrarPlanilhas.php  ">Mostrar Planilhas</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light mx-1" href="#criar">Criar Planilha</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light mx-1" href="meus_treinos_prontos.php">Meus Treinos Prontos</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light  mx-1" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <header class="jumbotron text-center bg-primary text-white">
        <h1 class="display-4">Bem-vindo aos Treinos </h1>
        <p class="lead">Personalize seu próprio treino ou escolha um pronto para começar!</p>
    </header>

    <section id="criar" class="container mt-5">
        <h2 class="text-center">Criar Treino</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="nome">Nome do Treino</label>
                <input type="text" class="form-control" id="nome" placeholder="Digite o nome do seu treino" name="nomePlanilha" required>
            </div>
            <button type="submit" class="btn btn-primary">Criar</button>
        </form>
    </section>

    <section class="container mt-5">
        <h2 class="text-center">Treinos Criados</h2>
        <form method="post">
            <div class="form-group">
                <label for="treinos">Selecione um Treino</label>
                <select class="form-control" id="treinos" name="treinos">
                    <?php
                    // Inicia ou retoma a sessão
                    session_start();
                    // Verifica se a sessão 'treinos' existe, senão cria uma array vazia
                    if (!isset($_SESSION['treino'])) {
                        $_SESSION['treino'] = [];
                    }

                    // Adiciona o novo treino à sessão se não estiver duplicado
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['nomePlanilha'])) {
                        $nomeTreino = htmlspecialchars($_POST['nomePlanilha']);
                        if (!in_array($nomeTreino, $_SESSION['treino'])) {
                            $_SESSION['treino'][] = $nomeTreino;
                        }
                    }

                    // Exibe as opções salvas
                    foreach ($_SESSION['treino'] as $treino) {
                        echo "<option value=\"$treino\">$treino</option>";
                    }

                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="selecionar">Selecionar Planilha</button>
        </form>
    </section>

    <?php

    require_once "banco.php";

    $nomePlanilha = $_POST['treinos'] ?? null;
    $usuario = $_SESSION['usuario'] ?? null;

    if (isset($_POST['selecionar'])) {
        if (is_null($nomePlanilha) && is_null($usuario)) {
        } else {

            $_SESSION['nomePlanilha'] = $nomePlanilha;
            header("Location: treinoPersonalizado.php");
        }
    }

    ?>

    <section id="pegar" class="container mt-5">
        <h2 class="text-center">Treinos prontos</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Treino A</h5>
                        <p class="card-text">Treino de peito e tríceps.</p>
                        <a href="meus_treinos_prontos.php?treino=Treino A" class="btn btn-primary">Visualizar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Treino B</h5>
                        <p class="card-text">Treino de inferiores.</p>
                        <a href="meus_treinos_prontos.php?treino=Treino B" class="btn btn-primary">Visualizar</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Treino C</h5>
                        <p class="card-text">Treino de costas.</p>
                        <a href="meus_treinos_prontos.php?treino=Treino C" class="btn btn-primary">Visualizar</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-4 text-white">
        <p>&copy; 2024 Planilha de Treino. Todos os direitos reservados.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>