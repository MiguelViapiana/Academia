<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Academia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style="background-color: #032030;">
    <ul class="nav" style="background-color: #003554;">
        <li class="nav-item">
            <a class=" btn btn-outline-primary shadow mx-1" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class=" btn btn-outline-primary mx-1"  href="Cadastro.php">Cadastro</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-primary" style="color: white;" href="Cadastro.php">Cadastre-se</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-primary" style="color: white;" aria-disabled="true">Disabled</a>
        </li>
    </ul>



    <?php
    session_start();

    $usu = $_SESSION["usuario"] ?? null;

    if (!is_null($usu)) {
        header("Location: logado.php");
        exit; // Sair do script após redirecionamento
    }

    require_once "banco.php";

    $usu = $_POST['usuario'] ?? null;
    $sen = $_POST['senha'] ?? null;

    if (is_null($usu) || is_null($sen)) {
        // Tratar campos vazios (opcional)
    } else {
        $busca = $banco->query("SELECT * FROM usuarios WHERE usuario='$usu'");

        if ($busca->num_rows == 0) {
            echo "<h1> Usuário não existe</h1>";
        } else {
            $obj = $busca->fetch_object();

            if ($sen === $obj->senha) {
                $_SESSION["usuario"] = $usu;
                $_SESSION["cod_usuario"] = $obj->cod;
                header("Location: logado.php");
                exit; // Sair do script após redirecionamento
            } else {
                echo "<br> Senha incorreta";
            }
        }
    }
    ?>


    <h1 class="fs-1 fw-boldfw-bold text-white text-center mt-5">ACADEMIA PHP</h1>
    <div class="container-md position-absolute top-50 start-50 translate-middle text-white p-5 shadow-lg rounded" style="background-color: #006DA4;">
        <form action="" method="post">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label fw-bold text-start">Username</label>
                <input type="text" class="form-control shadow-sm" id="exampleFormControlInput1" placeholder="" name="usuario">
            </div>
            <label for="inputPassword5" class="form-label fw-bold text-start" name="senha">Password</label>
            <input type="password" id="inputPassword5" class="form-control shadow-sm" aria-describedby="passwordHelpBlock" name="senha">
            <div id="passwordHelpBlock" class="form-text">
                <p style="color: white;">Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.</p>
            </div>
            <input class="btn btn-primary shadow" type="submit" value="Submit" style="background-color: #004D74;">
        </form>
    </div>
</body>

</html>