<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    // Redireciona para a página de login se não estiver logado
    header("Location: ../pages/index.html");
    exit();
}
?>
