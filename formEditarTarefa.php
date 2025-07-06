<?php include "header.php" ?>
<?php include "validarSessao.php" ?>
<?php
include("conexaoBD.php");

session_start();
$mensagem = "";

// --- TRATA POST (atualização da tarefa) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idTarefa"])) {
    $idTarefa = $_POST["idTarefa"];
    $tituloTarefa = $_POST["tituloTarefa"];
    $descricaoTarefa = $_POST["descricaoTarefa"];
    $dataCriacao = $_POST["dataCriacao"];
    $dataLimite = $_POST["dataLimite"];
    $statusTarefa = $_POST["statusTarefa"];

    $atualizar = "
        UPDATE Tarefas 
        SET 
            
            tituloTarefa = '$tituloTarefa',
            descricaoTarefa = '$descricaoTarefa',
            dataCriacao = '$dataCriacao',
            dataLimite = '$dataLimite',
            statusTarefa = '$statusTarefa'
        WHERE idTarefa = $idTarefa
    ";

    if (mysqli_query($conn, $atualizar)) {
        // Redireciona com mensagem de sucesso
        header("Location: formEditarTarefa.php?idTarefa=$idTarefa&sucesso=1");
        exit();
    } else {
        $mensagem = "<div class='alert alert-danger'>Erro ao atualizar: " . mysqli_error($conn) . "</div>";
    }
}

// --- MENSAGEM DE SUCESSO ---
if (isset($_GET["sucesso"]) && $_GET["sucesso"] == 1) {
    $mensagem = "<div class='alert alert-success'>Tarefa atualizada com sucesso!</div>";
}

// --- TRATA GET (carrega dados da tarefa) ---
if (isset($_GET['idTarefa'])) {
    $idTarefa = intval($_GET['idTarefa']);

    $buscarTarefa = "SELECT * FROM Tarefas WHERE idTarefa = $idTarefa";
    $res = mysqli_query($conn, $buscarTarefa);

    if (mysqli_num_rows($res) > 0) {
        $registro = mysqli_fetch_assoc($res);
        $tituloTarefa    = $registro['tituloTarefa'];
        $descricaoTarefa = $registro['descricaoTarefa']; // Aqui estava errado
        $dataCriacao     = $registro['dataCriacao'];
        $dataLimite      = $registro['dataLimite'];
        $statusTarefa    = $registro['statusTarefa'];
    } else {
        echo "<div class='alert alert-danger'>Tarefa não encontrada.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger'>ID da tarefa não informado.</div>";
    exit;
}
?>

<div class="container text-center mb-3 mt-3">
    <?php include "footer.php" ?>
    <h2>Editar tarefa:</h2>
    <div class="d-flex justify-content-center mb-3">
        <div class="row">
            <div class="col-12">
                <form action="formEditarTarefa.php?idTarefa=<?php echo $idTarefa ?>" method="POST" class="was-validated">

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="idTarefa" name="idTarefa" value="<?php echo $idTarefa ?>" readonly required>
                        <label for="idTarefa">*ID</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="tituloTarefa" name="tituloTarefa" value="<?php echo $tituloTarefa ?>" required>
                        <label for="tituloTarefa">Título da tarefa</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <textarea class="form-control" id="descricaoTarefa" name="descricaoTarefa" required><?php echo $descricaoTarefa ?></textarea>
                        <label for="descricaoTarefa">Descrição da tarefa</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control" id="dataCriacao" name="dataCriacao" value="<?php echo $dataCriacao ?>" required>
                        <label for="dataCriacao">Data de criação</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="date" class="form-control" id="dataLimite" name="dataLimite" value="<?php echo $dataLimite ?>" required>
                        <label for="dataLimite">Data limite</label>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="statusTarefa" name="statusTarefa" value="<?php echo $statusTarefa ?>" required>
                        <label for="statusTarefa">Status</label>
                    </div>

                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <?php echo $mensagem; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php" ?>
