<?php
require_once "banco.php";
session_start();

if (isset($_GET['id'])) {
    $exercicioId = intval($_GET['id']);
    $usu = $_SESSION['usuario'];
    $tabela = "planilha_" . $banco->real_escape_string($usu);

    // Remover o exercício das colunas correspondentes na tabela do usuário
    for ($i = 0; $i < 10; $i++) {
        $colunaExercicio = "exercicio$i";
        
        // Verificar se a coluna existe antes de tentar atualizar
        $result = $banco->query("SHOW COLUMNS FROM $tabela LIKE '$colunaExercicio'");
        if ($result->num_rows > 0) {
            $query = "UPDATE $tabela SET $colunaExercicio = NULL WHERE $colunaExercicio = $exercicioId";
            $banco->query($query);
        }
    }

    // Remover o exercício da tabela 'exercicios'
    $query = "DELETE FROM exercicios WHERE cod = $exercicioId";
    if ($banco->query($query) === TRUE) {
        echo "<script>alert('Exercício excluído com sucesso.'); window.location.href='exibirPlanilhas.php';</script>";
        header("Location: mostrarPlanilhas.php");
    } else {
        echo "Erro ao excluir o exercício: " . $banco->error;
    }

    $banco->close();
} else {
    echo "ID do exercício não fornecido.";
}
?>
