<?php include "header.php"; ?>

<div class='container mt-3 mb-3'>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include "conexaoBD.php";
    session_start();

    $tituloTarefa = $descricaoTarefa = $dataCriacao = $dataLimite = $statusTarefa = "";
    $erroPreenchimento = false;

    // Validações
    function testar_entrada($dado) {
        $dado = trim($dado);
        $dado = stripslashes($dado);
        $dado = htmlspecialchars($dado);
        return $dado;
    }

    if (empty($_POST["tituloTarefa"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>TÍTULO</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $tituloTarefa = testar_entrada($_POST["tituloTarefa"]);
    }

    if (empty($_POST["descricaoTarefa"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>DESCRIÇÃO</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $descricaoTarefa = testar_entrada($_POST["descricaoTarefa"]);
    }

    if (empty($_POST["dataCriacao"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>DATA DE CRIAÇÃO</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $dataCriacao = testar_entrada($_POST["dataCriacao"]);
    }

    if (empty($_POST["dataLimite"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>DATA LIMITE</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $dataLimite = testar_entrada($_POST["dataLimite"]);
    }

    if (empty($_POST["statusTarefa"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>STATUS</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $statusTarefa = testar_entrada($_POST["statusTarefa"]);
    }

    if (empty($_POST["idResponsavel"])) {
        echo "<div class='alert alert-warning text-center'>O campo <strong>RESPONSÁVEL</strong> é obrigatório!</div>";
        $erroPreenchimento = true;
    } else {
        $idResponsavel = intval($_POST["idResponsavel"]);
    }

    // Se estiver tudo certo, inserir no banco
    if (!$erroPreenchimento) {

        $idUsuario = $_SESSION['idUsuario']; // quem criou

        // Insere tarefa
        $inserirTarefa = "INSERT INTO tarefas (tituloTarefa, descricaoTarefa, dataCriacao, dataLimite, statusTarefa, idUsuario)
                          VALUES ('$tituloTarefa', '$descricaoTarefa', '$dataCriacao', '$dataLimite', '$statusTarefa', '$idUsuario')";

        if (mysqli_query($conn, $inserirTarefa)) {

            $idTarefaInserida = mysqli_insert_id($conn); // pega o ID da tarefa inserida

            // Insere o responsável
            $inserirResponsavel = "INSERT INTO responsaveis (idTarefa, idUsuario) VALUES ($idTarefaInserida, $idResponsavel)";
            mysqli_query($conn, $inserirResponsavel);

            echo "<div class='alert alert-success text-center'>Tarefa cadastrada com sucesso!</div>";

            echo "<div class='container mt-3'>
                    <div class='table-responsive'>
                        <table class='table'>
                            <tr><th>TÍTULO DA TAREFA</th><td>$tituloTarefa</td></tr>
                            <tr><th>DESCRIÇÃO DA TAREFA</th><td>$descricaoTarefa</td></tr>
                            <tr><th>DATA DE CRIAÇÃO</th><td>$dataCriacao</td></tr>
                            <tr><th>DATA LIMITE</th><td>$dataLimite</td></tr>
                            <tr><th>STATUS DA TAREFA</th><td>$statusTarefa</td></tr>
                        </table>
                    </div>
                </div>";

        } else {
            echo "<div class='alert alert-danger text-center'>
                    Erro ao tentar inserir a tarefa no banco de dados!
                  </div>";
        }

        mysqli_close($conn);
    }
} else {
    header("location:formTarefa.php");
}
?>

</div>

<?php include "footer.php"; ?>
