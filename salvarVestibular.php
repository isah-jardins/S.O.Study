<?php

include "conexaoBD.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nomeVestibular'];
    $descricao = $_POST['descricaoVestibular'];
    $data = $_POST['dataVestibular'];


    // ==========================================
    // UPLOAD DA IMAGEM
    // ==========================================

    $nomeImagem = $_FILES['imagemVestibular']['name'];
    $arquivoTemporario = $_FILES['imagemVestibular']['tmp_name'];

    $extensao = strtolower(
        pathinfo($nomeImagem, PATHINFO_EXTENSION)
    );


    // Extensões permitidas

    $extensoesPermitidas = ['jpg', 'jpeg', 'png'];


    if (!in_array($extensao, $extensoesPermitidas)) {

        echo "Formato de imagem não permitido.";
        exit();

    }


    // Cria um nome único para a imagem

    $novoNomeImagem = uniqid() . "." . $extensao;


    // Caminho onde a imagem será salva

    $caminho = "img/" . $novoNomeImagem;


    // Move a imagem para a pasta img

    if (!move_uploaded_file($arquivoTemporario, $caminho)) {

        echo "Erro ao enviar a imagem.";
        exit();

    }


    // ==========================================
    // SALVA NO BANCO
    // ==========================================

    $sql = "INSERT INTO vestibulares
            (
                nomeVestibular,
                descricaoVestibular,
                imagemVestibular,
                dataVestibular
            )
            VALUES
            (
                '$nome',
                '$descricao',
                '$caminho',
                '$data'
            )";


    if (mysqli_query($conn, $sql)) {

        header("Location: index.php");
        exit();

    } else {

        echo "Erro ao cadastrar vestibular: "
             . mysqli_error($conn);

    }

}

?>