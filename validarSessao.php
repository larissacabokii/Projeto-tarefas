<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['logado']) || $_SESSION['logado'] === false) {
    header('Location: formLogin.php?pagina=formLogin&erroLogin=naoLogado');
    exit();
}


?>
