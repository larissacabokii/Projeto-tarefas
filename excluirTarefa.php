<?php
session_start();
include("conexaoBD.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: formLogin.php?erroLogin=acessoProibido");
    exit();
}

// Verifica se o ID da tarefa foi enviado
if (isset($_GET['idTarefa'])) {
    $id = intval($_GET['idTarefa']);

    // Excluir da tabela 'responsaveis' primeiro (porque ela depende da tarefa)
    $sqlDependente = "DELETE FROM responsaveis WHERE idTarefa = $id";
    mysqli_query($conn, $sqlDependente); // Não precisa checar erro aqui, só seguir

    // Agora pode excluir da tabela 'Tarefas'
    $sqlTarefa = "DELETE FROM tarefas WHERE idTarefa = $id";
    if (mysqli_query($conn, $sqlTarefa)) {
        header("Location: index.php?excluido=1");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Erro ao excluir tarefa: " . mysqli_error($conn) . "</div>";
    }
} else {
    echo "<div class='alert alert-warning'>ID da tarefa não especificado.</div>";
}
?>

