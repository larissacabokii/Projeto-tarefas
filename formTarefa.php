<?php include "header.php" ?>
<?php include "conexaoBD.php"; ?>

<div class="container text-center mb-3 mt-3">
    
    <h2>Cadastrar nova tarefa:</h2>
    <div class="d-flex justify-content-center mb-3">
        <div class="row">
            <div class="col-12">
                <form action="actionTarefa.php" method="POST" class="was-validated" enctype="multipart/form-data">

                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="tituloTarefa" placeholder="Título da tarefa" name="tituloTarefa" required>
                        <label for="tituloTarefa">Título da Tarefa</label>
                        <div class="valid-feedback">Campo preenchido.</div>
                        <div class="invalid-feedback">Por favor, preencha este campo.</div>
                    </div>

                    <div class="form-floating mb-3 mt-3">
                        <textarea class="form-control" id="descricaoTarefa" placeholder="Informe uma breve descrição sobre a tarefa" name="descricaoTarefa" required style="height: 100px;"></textarea>
                        <label for="descricaoTarefa">Descrição da Tarefa</label>
                        <div class="valid-feedback">Campo preenchido.</div>
                        <div class="invalid-feedback">Por favor, preencha este campo.</div>
                    </div>

                    <div class="form-floating mt-3 mb-3">
                        <input type="date" class="form-control" id="dataCriacao" name="dataCriacao" required>
                        <label for="dataCriacao">Data de Criação da Tarefa</label>
                        <div class="valid-feedback">Campo preenchido.</div>
                        <div class="invalid-feedback">Por favor, informe a data.</div>
                    </div>

                    <div class="form-floating mt-3 mb-3">
                        <input type="date" class="form-control" id="dataLimite" name="dataLimite" required>
                        <label for="dataLimite">Data Limite da Tarefa</label>
                        <div class="valid-feedback">Campo preenchido.</div>
                        <div class="invalid-feedback">Por favor, informe a data.</div>
                    </div>

                    <div class="form-floating mt-3 mb-3">
                        <select class="form-select" id="statusTarefa" name="statusTarefa" required>
                            <option value="" disabled selected>Selecione o status</option>
                            <option value="Pendente">Pendente</option>
                            <option value="Em andamento">Em andamento</option>
                            <option value="Concluido">Concluido</option>
                        </select>
                        <label for="statusTarefa">Status da Tarefa</label>
                        <div class="valid-feedback">Campo preenchido.</div>
                        <div class="invalid-feedback">Por favor, selecione um status.</div>
                    </div>
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="idResponsavel" name="idResponsavel" required>
                            <option value="" disabled selected>Selecione o responsável</option>
                            <?php
                                include "conexaoBD.php";
                                $sql = "SELECT idUsuario, nomeUsuario FROM usuarios";
                                $resultado = $conn->query($sql);
                                while ($linha = $resultado->fetch_assoc()) {
                                    echo "<option value='{$linha['idUsuario']}'>{$linha['nomeUsuario']}</option>";
                                }
                            ?>
                        </select>
                        <label for="idResponsavel">Responsável pela Tarefa</label>
                        <div class="valid-feedback">Campo preenchido.</div>
                        <div class="invalid-feedback">Por favor, selecione um responsável.</div>
                    </div>


                    <button type="submit" class="btn btn-success">Cadastrar Tarefa</button>
                </form>
            </div>
        </div>
    </div>
    <br>
</div>

<?php include "footer.php" ?>
