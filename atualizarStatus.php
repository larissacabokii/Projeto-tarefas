<?php
include("conexaoBD.php");

if (isset($_POST['tarefasConcluidas'])) {
    $dataAtual = date('Y-m-d');

    foreach ($_POST['tarefasConcluidas'] as $idTarefa) {
        $sql = "UPDATE Tarefas 
                SET statusTarefa = 'Concluído', dataConclusao = '$dataAtual' 
                WHERE idTarefa = $idTarefa";
        mysqli_query($conn, $sql);
    }
}

header("Location: index.php");
exit;
?>
