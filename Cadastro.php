<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body style= "background-image: url('images/op1.png');">


    <ul class="nav pb-0" style="background-color: #003554;">
        <li class="nav-item">
            <a class=" btn btn-outline-primary mx-1"  aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class=" btn btn-outline-primary mx-1"  href="login.php">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-primary" style="color: white;" href="Cadastro.php">Cadastre-se</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn btn-outline-primary disable" style="color: white;" aria-disabled="true">Disabled</a>
        </li>
    </ul>

    <div class="container-sm position-absolute top-50 start-50 translate-middle text-white p-3 shadow-lg rounded" style="background-color: #006DA4;">
        <h2 style="color: #FFFFFF; text-align: center;">Cadastre-se</h2>
        <div style="display: flex; justify-content: center;">
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-14 mb-1 ">
                        <label for="" class="fw-bold" style="font-size: 0.8em;">Usuario</label>
                        <input type="text" class="form-control shadow" placeholder="" aria-label="Usuario" name="usuario">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-14 mb-1 ">
                        <label for="" class="fw-bold" style="font-size: 0.8em;">Nome</label>
                        <input type="text" class="form-control shadow" placeholder="" aria-label="Nome" name="nome">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-14 mb-1">
                        <label for="" class="fw-bold" style="font-size: 0.8em;">Sobrenome</label>
                        <input type="text" class="form-control shadow" placeholder="" aria-label="Sobrenome" name="sobrenome">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-14 mb-1">
                        <label for="" class="fw-bold" style="font-size: 0.8em;">E-mail</label>
                        <input type="text" class="form-control shadow" placeholder="exemplo@gmail.com" aria-label="E-mail" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-14 mb-1">
                        <label for="" class="fw-bold" style="font-size: 0.8em;">Telefone</label>
                        <input type="text" class="form-control shadow" placeholder="(XX) XXXX-XXXX" aria-label="Telefone" name="telefone">
                </div>
                <div class="row">
                    <div class="col-md-14 mb-1">
                        <label for="" class="fw-bold" style="font-size: 0.8em;">Senha</label>
                        <input type="password" class="form-control shadow" placeholder="Tamanho de 8-20 caracteres" aria-label="Senha" name="senha">
                    </div>
                </div>
              
                <div class="row">
                    <div class="col-md-12 text-center mt-3">
                        <input class="btn btn-primary shadow" type="submit" value="Cadastrar" style="background-color: #004D74;">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php

        require_once "banco.php";

        $usu = $_POST["usuario"] ?? null;
        $nome = $_POST['nome'] ?? null;
        $sobrenome = $_POST['sobrenome'] ?? null;
        $email = $_POST["email"] ?? null;
        $telefone = $_POST["telefone"] ?? null;
        $sen = $_POST['senha'] ?? null;

        if (is_null($usu) || is_null($nome) || is_null($sobrenome) || is_null($email) || is_null($telefone) || is_null($sen)) {

        }else{
            $busca = $banco->query("SELECT * FROM usuarios WHERE email='$email'");

            if ($busca->num_rows == 0) {
                $obj = $busca->fetch_object();
                criarUsuario($usu, $nome, $sobrenome, $email, $telefone, $sen);
                echo "<script>alert('Cadastro efetuado com sucesso!!');</script>";
                header("Location: login.php"); 
                
            }else{
                echo "<script>alert('Email já cadastrado!!');</script>";
            }
        }



    ?>





</body>

</html>