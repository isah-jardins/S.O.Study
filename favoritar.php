<?php

session_start();

include "conexaoBD.php";


// Verifica se o usuário está logado
if (!isset($_SESSION['idUsuario'])) {
    header("Location: formLogin.php");
    exit();
}


// Verifica se o vestibular foi enviado
if (!isset($_POST['idVestibular'])) {
    header("Location: vestibulares.php");
    exit();
}


$idUsuario = $_SESSION['idUsuario'];
$idVestibular = intval($_POST['idVestibular']);


// Verifica se o vestibular já está nos favoritos
$verificar = "SELECT idFavorito
              FROM favoritos
              WHERE idUsuario = '$idUsuario'
              AND idVestibular = '$idVestibular'";

$resultado = mysqli_query($conn, $verificar);


if (mysqli_num_rows($resultado) > 0) {

    // ==========================================
    // JÁ ESTÁ FAVORITADO → REMOVE
    // ==========================================

    $remover = "DELETE FROM favoritos
                WHERE idUsuario = '$idUsuario'
                AND idVestibular = '$idVestibular'";

    mysqli_query($conn, $remover);


    header(
        "Location: vestibular.php?idVestibular=$idVestibular&favorito=removido"
    );

    exit();


} else {

    // ==========================================
    // NÃO ESTÁ FAVORITADO → ADICIONA
    // ==========================================

    $adicionar = "INSERT INTO favoritos (idUsuario, idVestibular)
                  VALUES ('$idUsuario', '$idVestibular')";

    mysqli_query($conn, $adicionar);


    header(
        "Location: vestibular.php?idVestibular=$idVestibular&favorito=adicionado"
    );

    exit();

}

?>