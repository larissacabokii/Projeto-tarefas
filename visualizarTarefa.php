<?php
include "header.php";
session_start();
include "conexaoBD.php";
?>

<div class="container text-center mt-5 mb-5">

<?php
if (!isset($_SESSION['idUsuario'])) {
    echo "<div class='alert alert-warning'>Sessão não encontrada. Faça login.</div>";
    include "footer.php";
    exit;
}

$idUsuario = $_SESSION['idUsuario'];
$tipoUsuario = $_SESSION['tipoUsuario'] ?? '';

// Verifica se veio um idTarefa na URL
if (isset($_GET['idTarefa'])) {
    $idTarefa = intval($_GET['idTarefa']);

    // Admin pode ver qualquer tarefa
    if ($idUsuario == 1 || $tipoUsuario === 'administrador') {
    $sql = "SELECT tarefas.*, usuarios.nomeUsuario AS nomeResponsavel
            FROM tarefas
            LEFT JOIN responsaveis ON tarefas.idTarefa = responsaveis.idTarefa
            LEFT JOIN usuarios ON responsaveis.idUsuario = usuarios.idUsuario
            WHERE tarefas.idTarefa = $idTarefa";
} else {
    // Cliente só vê a tarefa dele
    $sql = "SELECT tarefas.*, usuarios.nomeUsuario AS nomeResponsavel
            FROM tarefas
            LEFT JOIN responsaveis ON tarefas.idTarefa = responsaveis.idTarefa
            LEFT JOIN usuarios ON responsaveis.idUsuario = usuarios.idUsuario
            WHERE tarefas.idTarefa = $idTarefa AND tarefas.idUsuario = $idUsuario";
}

    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        $tarefa = mysqli_fetch_assoc($res);
        ?>
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h4 class="card-title"><b><?= $tarefa['tituloTarefa'] ?></b></h4>
                <p class="card-text"><?= $tarefa['descricaoTarefa'] ?></p>
                <p class="card-text">Criada em: <?= $tarefa['dataCriacao'] ?></p>
                <p class="card-text">Data limite: <?= $tarefa['dataLimite'] ?></p>
                <p class="card-text">Status: <?= $tarefa['statusTarefa'] ?></p>
                <p class="card-text"><b>Responsável:</b> <?= $tarefa['nomeResponsavel'] ?? 'Não definido' ?></p>
                <?php if (!empty($tarefa['dataConclusao'])): ?>
                    <p class="card-text">Concluída em: <?= $tarefa['dataConclusao'] ?></p>
                <?php endif; ?>

                <div class="mt-3">
                    <a href="visualizarTarefa.php" class="btn btn-secondary">Voltar para lista</a>
                    <?php if ($_SESSION['logado'] === true): ?>
                        <form action="formEditarTarefa.php?idTarefa=<?= $idTarefa ?>" method="POST" class="d-inline">
                            <input type="hidden" name="idTarefa" value="<?= $idTarefa ?>">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="bi bi-pencil-square"></i> Editar Tarefa
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "<div class='alert alert-danger'>Tarefa não encontrada ou acesso negado.</div>";
    }
} else {
    // Exibe a lista de tarefas
    echo "<h3 class='mb-4' style='color: white;'>Lista de Tarefas</h3>";

    if ($idUsuario == 1 || $tipoUsuario === 'administrador') {
    $sql = "SELECT tarefas.*, usuarios.nomeUsuario AS nomeResponsavel
            FROM tarefas
            LEFT JOIN responsaveis ON tarefas.idTarefa = responsaveis.idTarefa
            LEFT JOIN usuarios ON responsaveis.idUsuario = usuarios.idUsuario
            ORDER BY tarefas.dataCriacao DESC";
} else {
    $sql = "SELECT tarefas.*, usuarios.nomeUsuario AS nomeResponsavel
            FROM tarefas
            LEFT JOIN responsaveis ON tarefas.idTarefa = responsaveis.idTarefa
            LEFT JOIN usuarios ON responsaveis.idUsuario = usuarios.idUsuario
            WHERE tarefas.idUsuario = $idUsuario
            ORDER BY tarefas.dataCriacao DESC";
}


    $res = mysqli_query($conn, $sql);

    if (mysqli_num_rows($res) > 0) {
        echo "<div class='row justify-content-center'>";
        while ($tarefa = mysqli_fetch_assoc($res)) {
            ?>
            <div class="card col-md-4 m-2">
                <div class="card-body">
                    <h5 class="card-title"><?= $tarefa['tituloTarefa'] ?></h5>
                    <p class="card-text">Status: <b><?= $tarefa['statusTarefa'] ?></b></p>
                    <p class="card-text">Criada em: <?= $tarefa['dataCriacao'] ?></p>
                    <p class="card-text">Responsável: <b><?= $tarefa['nomeResponsavel'] ?? 'Não definido' ?></b></p>
                    <a href="visualizarTarefa.php?idTarefa=<?= $tarefa['idTarefa'] ?>" class="btn btn-primary">Ver detalhes</a>
                </div>
            </div>
            <?php
        }
        echo "</div>";
    } else {
        echo "<div class='alert alert-info'>Nenhuma tarefa encontrada.</div>";
    }
}
?>

</div>

<?php include "footer.php"; ?>
