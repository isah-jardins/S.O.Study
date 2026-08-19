<?php

    session_start();

    include "conexaoBD.php";

    if (!isset($_SESSION['idUsuario'])) {
        header("Location: formLogin.php");
        exit();
    }

    $idUsuario = $_SESSION['idUsuario'];
    $idVestibular = $_POST['idVestibular'];

    $sql = "INSERT INTO favoritos (idUsuario, idVestibular)
            VALUES ('$idUsuario', '$idVestibular')";

    $resultado = mysqli_query($conn, $sql);

    if ($resultado) {
        header("Location: enem.php");
        exit();
    } else {
        echo "Erro ao adicionar aos favoritos: " . mysqli_error($conn);
    }

?>            