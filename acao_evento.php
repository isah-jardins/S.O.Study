<?php
session_start();
include "conexaoBD.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    header("Location: formLogin.php");
    exit();
}

$idUsuario = $_SESSION['idUsuario'];
$idEvento = $_GET['id'] ?? '';
$acao = $_GET['acao'] ?? '';
$data = $_GET['data'] ?? '';

if ($acao == 'concluir') {
    $sql = "
        UPDATE eventos
        SET concluido = 1
        WHERE idEvento = '$idEvento'
        AND idUsuario = '$idUsuario'
    ";
    mysqli_query($conn, $sql);
}

elseif ($acao == 'desfazer') {
    $sql = "
        UPDATE eventos
        SET concluido = 0
        WHERE idEvento = '$idEvento'
        AND idUsuario = '$idUsuario'
    ";
    mysqli_query($conn, $sql);
}

elseif ($acao == 'remover') {
    $sql = "
        DELETE FROM eventos
        WHERE idEvento = '$idEvento'
        AND idUsuario = '$idUsuario'
    ";
    mysqli_query($conn, $sql);
}

header(
    "Location: calendario.php?data=" . $data
);
exit();
?>