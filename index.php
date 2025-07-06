<?php include "header.php"; ?>

<div class="container mt-5 mb-5">

<?php
include("conexaoBD.php");

session_start();

$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : 0;
$tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : '';

// Monta a query base com JOIN para trazer o nome do responsável
$listarTarefas = "
    SELECT tarefas.*, usuarios.nomeUsuario 
    FROM tarefas
    LEFT JOIN responsaveis ON responsaveis.idTarefa = tarefas.idTarefa
    LEFT JOIN usuarios ON usuarios.idUsuario = responsaveis.idUsuario
";

// Adiciona filtro para usuário comum (não admin)
$condicoes = [];

if ($idUsuario != 1 && $tipoUsuario !== 'administrador') {
    $condicoes[] = "tarefas.idUsuario = $idUsuario";
}

// Filtro de status
if (isset($_GET["filtroTarefa"])) {
    $filtroTarefa = $_GET["filtroTarefa"];

    if ($filtroTarefa != "todos") {
        $condicoes[] = "tarefas.statusTarefa = '$filtroTarefa'";
    }

    switch ($filtroTarefa) {
        case "todos": $mensagemFiltro = "no total"; break;
        case "Pendente": $mensagemFiltro = "pendentes"; break;
        case "Em andamento": $mensagemFiltro = "em andamento"; break;
        case "Concluído": $mensagemFiltro = "concluídas"; break;
        default: $mensagemFiltro = "no total";
    }
} else {
    $filtroTarefa = "todos";
    $mensagemFiltro = "no total";
}

if (!empty($condicoes)) {
    $listarTarefas .= " WHERE " . implode(" AND ", $condicoes);
}

$listarTarefas .= " ORDER BY tarefas.dataCriacao DESC";

$res = mysqli_query($conn, $listarTarefas);
$totalTarefas = mysqli_num_rows($res);

if ($totalTarefas > 0) {
    echo "<div class='alert alert-info text-center'>
            Há <strong>$totalTarefas</strong> tarefa(s) $mensagemFiltro!
          </div>";
} else {
    echo "<div class='alert alert-info text-center'>
            Não há tarefas cadastradas neste sistema!
          </div>";
}

// Define seleção do filtro
$selTodos = "";
$selPendente = "";
$selAndamento = "";
$selConcluido = "";

if ($filtroTarefa == 'todos') {
    $selTodos = "selected";
} else if ($filtroTarefa == 'Pendente') {
    $selPendente = "selected";
} else if ($filtroTarefa == 'Em andamento') {
    $selAndamento = "selected";
} else if ($filtroTarefa == 'Concluído') {
    $selConcluido = "selected";
}
?>

<form name='formFiltro' action='index.php' method='GET'>
    <div class='form-floating mt-3'>
        <select class='form-select' name='filtroTarefa' required>
            <option value='todos' <?php echo $selTodos; ?>>Visualizar todas as Tarefas</option>
            <option value='Pendente' <?php echo $selPendente; ?>>Apenas Pendentes</option>
            <option value='Em andamento' <?php echo $selAndamento; ?>>Apenas Em andamento</option>
            <option value='Concluído' <?php echo $selConcluido; ?>>Apenas Concluídas</option>
        </select>
        <label for='filtroTarefa'>Selecione um Filtro</label>
        <br>
    </div>
    <button type='submit' class='btn btn-outline-success' style='float:right'>
        <i class='bi bi-funnel'></i> Filtrar Tarefas
    </button><br>
</form>

<hr>

<form action="atualizarStatus.php" method="POST">
    <div class="list-group">
<?php
while ($tarefa = mysqli_fetch_assoc($res)) {
    $idTarefa = $tarefa["idTarefa"];
    $tituloTarefa = $tarefa["tituloTarefa"];
    $descricaoTarefa = $tarefa["descricaoTarefa"];
    $dataCriacao = $tarefa["dataCriacao"];
    $dataLimite = $tarefa["dataLimite"];
    $statusTarefa = $tarefa["statusTarefa"];
    $dataConclusao = $tarefa["dataConclusao"];

    if (isset($tarefa["nomeUsuario"])) {
        $nomeResponsavel = $tarefa["nomeUsuario"];
    } else {
        $nomeResponsavel = "Desconhecido";
    }

    if ($statusTarefa == "Concluído") {
        $checked = "checked disabled";
    } else {
        $checked = "";
    }

    if ($statusTarefa == "Pendente") {
        $corBadge = "warning";
    } else if ($statusTarefa == "Em andamento") {
        $corBadge = "primary";
    } else {
        $corBadge = "success";
    }

    echo "<label class='list-group-item d-flex justify-content-between align-items-center'>
            <div class='form-check'>
                <input class='form-check-input me-2' type='checkbox' name='tarefasConcluidas[]' value='$idTarefa' $checked>
                <span>
                    <strong>$tituloTarefa</strong> - $descricaoTarefa <br>
                    Responsável: $nomeResponsavel<br>
                    <small>Criação: $dataCriacao | Limite: $dataLimite";
    if (!empty($dataConclusao)) {
        echo " | Concluída em: $dataConclusao";
    }
    echo "</small>
                </span>
            </div>
            <span class='badge bg-$corBadge'>$statusTarefa</span>
        </label>
        <a href='formEditarTarefa.php?idTarefa=$idTarefa' class='btn btn-sm btn-outline-primary mt-2'>Editar</a>
        <a href='excluirTarefa.php?idTarefa=$idTarefa' class='btn btn-sm btn-outline-danger mt-2' onclick=\"return confirm('Tem certeza que deseja excluir esta tarefa?')\">Excluir</a>";
}
?>
    </div>

    <div class="mt-4 text-center">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check2-circle"></i> Marcar selecionadas como concluídas
        </button>
    </div>
</form>

</div>

<?php include "footer.php"; ?>
