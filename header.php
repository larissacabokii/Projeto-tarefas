<!DOCTYPE html>
<html lang="pt-br">
<?php
    date_default_timezone_set('America/Sao_Paulo');
    session_start();
?>
<head>
    <title>Genérico</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- jQuery e Máscara -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
         
        $(document).ready(function(){
            $("#telefoneUsuario").mask("(00) 00000-0000");
        });
    </script>

    <!-- Estilo Customizado -->
    <style>
        body {
            background-color:rgb(222, 206, 233);
            min-height: 100vh;
            background-position: center;
            background-size: cover;
            .elemento-com-fundo-desfocado 
             backdrop-filter: blur(5px);
            background-color: rgba(255, 255, 255, 0.26); /* Adiciona um fundo semitransparente */
            background-image: url('src/imagem/tela_fundo.png');
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            border-radius: 0 0 15px 15px;
        }

        .logo img {
            width: 130px;
            transition: transform 0.2s;
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .welcome {
            font-size: 1rem;
            color: #00bcd4;
            margin-left: 15px;
        }

        .main-container {
            padding: 30px 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
    </style>
</head>

<body>
    <!-- Logotipo -->
    <div class="text-center mt-4 logo">
        <a href="index.php" title="Clique para voltar ao início">
            <img src="src/imagem/logo_ttarefa.png" alt="Logotipo">
        </a>
    </div>

    <?php
        error_reporting(0);

        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
            $idUsuario    = $_SESSION['idUsuario'];
            $tipoUsuario  = $_SESSION['tipoUsuario'];
            $nomeUsuario  = $_SESSION['nomeUsuario'];
            $emailUsuario = $_SESSION['emailUsuario'];

            $nomeCompleto = explode(' ', $nomeUsuario);
            $primeiroNome = $nomeCompleto[0];
        }
    ?>


     
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mt-4 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><i class="bi bi-house-fill"></i> Início</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuApp">
                <span class="navbar-toggler-icon"></span>
                
            </button>

            <div class="collapse navbar-collapse" id="menuApp">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                        if($tipoUsuario == 'administrador'){
                            echo "<li class='nav-item'><a class='nav-link' href='formTarefa.php'><i class='bi bi-plus-circle'></i> Cadastrar tarefas</a></li>";
                            echo "<li class='nav-item'><a class='nav-link' href='visualizarTarefa.php'><i class='bi bi-box-seam'></i> Todas as tarefas</a></li>";
                        }

                        if($tipoUsuario == 'cliente'){
                            echo "<li class='nav-item'><a class='nav-link' href='visualizarTarefa.php'><i class='bi bi-box-seam'></i> Minhas tarefas</a></li>";
                            echo "<li class='nav-item'><a class='nav-link' href='formTarefa.php'><i class='bi bi-plus-circle'></i> Cadastrar tarefas</a></li>";
                        }

                        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                            echo "<li class='nav-item'><a class='nav-link' href='logout.php?pagina=formLogin'><i class='bi bi-box-arrow-right'></i> Sair</a></li>";
                        } else {
                            echo "<li class='nav-item'><a class='nav-link' href='formLogin.php?pagina=formLogin'><i class='bi bi-person'></i> Login</a></li>";
                        }
                    ?>
                </ul>
                <?php
                    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                        echo "<span class='welcome'>Olá, <strong>$primeiroNome</strong>! <i class='bi bi-emoji-smile'></i></span>";
                    }
                ?>
            </div>
        </div>
    </nav>


    <div class="container mt-5 mb-5">
       
    </div>
</body>
</html>
