<?php

include "conexaoBD.php";


/*
    Verifica se o formulário foi enviado.
*/

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    header("Location: editais.php");

    exit;

}


/*
    Recebe os dados.
*/

$idVestibular = intval($_POST['idVestibular']);

$nomeEdital = mysqli_real_escape_string(
    $conn,
    $_POST['nomeEdital']
);

$linkEdital = mysqli_real_escape_string(
    $conn,
    $_POST['linkEdital']
);


/*
    Insere o edital no banco.
*/

$sql = "
    INSERT INTO editais
    (
        idVestibular,
        nomeEdital,
        linkEdital
    )
    VALUES
    (
        $idVestibular,
        '$nomeEdital',
        '$linkEdital'
    )
";


$resultado = mysqli_query($conn, $sql);


/*
    Depois de cadastrar,
    volta para a página de editais.
*/

if ($resultado) {

    header("Location: editais.php");

    exit;

} else {

    echo "Erro ao cadastrar edital: " . mysqli_error($conn);

}

?>