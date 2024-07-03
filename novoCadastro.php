<?php 

require_once "banco.php";

$usuario = $_POST["Usuario"] ?? null;
$nome = $_POST["Nome"] ?? null;
$sobrenome = $_POST["Sobrenome"] ?? null;
$email = $_POST["E-mail"] ?? null;
$telefone = $_POST["Telefone"] ?? null;
$senha = $_POST["Senha"] ?? null;


require "cadastro.php";

if(is_null($usuario) || is_null($nome) || is_null($sobrenome) || is_null($email) || is_null($telefone)|| is_null($senha)){
    // digitar info
}else{
    // criando
    criarUsuario($usuario, $nome, $sobrenome, $email, $telefone, $senha);
    echo "Usuario criado com sucesso!";
}


?>