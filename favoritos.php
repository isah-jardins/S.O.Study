<?php
session_start();
include "conexaoBD.php";
include "header.php";

if (!isset($_SESSION['idUsuario'])) {
    header("Location: formLogin.php");
    exit();
}
$idUsuario = $_SESSION['idUsuario'];

$sql = "SELECT v.idVestibular,
               v.nomeVestibular,
               v.descricao,
               v.imagem
        FROM favoritos f
        INNER JOIN vestibulares v
            ON f.idVestibular = v.idVestibular
        WHERE f.idUsuario = '$idUsuario'";
$resultado = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Favoritos - S.O.Study</title>

    <link rel="stylesheet" href="css/ideia.css">
</head>

<body>
    <div class="container">
        <h1 class="titulo-favoritos">⭐ Favoritos</h1>
        <?php if (mysqli_num_rows($resultado) == 0) { ?>

            <div class="sem-favoritos">
                <h2>Você ainda não possui favoritos.</h2>
                <p>Favorite um vestibular para ele aparecer aqui! ⭐</p>
            </div>

        <?php } else { ?>
            <?php while ($vestibular = mysqli_fetch_assoc($resultado)) { ?>
                <div class="card-favorito">

                    <h2>
                        <?= htmlspecialchars($vestibular['nomeVestibular']); ?>
                    </h2>

                    <div class="conteudo-favorito">
                        <div class="editais-favorito">
                            <h3>Editais</h3>
                            <?php

                            $idVestibular = $vestibular['idVestibular'];
                            $sqlEditais = "SELECT idEdital,
                                                nomeEdital,
                                                linkEdital
                                        FROM editais
                                        WHERE idVestibular = '$idVestibular'";
                            $resultadoEditais = mysqli_query($conn, $sqlEditais);
                            ?>

                            <?php if (mysqli_num_rows($resultadoEditais) > 0) { ?>
                                <?php while ($edital = mysqli_fetch_assoc($resultadoEditais)) { ?>
                                    
                                    <a href="<?= htmlspecialchars($edital['linkEdital']); ?>"
                                    target="_blank"
                                    class="edital-favorito">
                                        📄 <?= htmlspecialchars($edital['nomeEdital']); ?>
                                    </a>

                                <?php } ?>
                            <?php } else { ?>
                                <p>Nenhum edital cadastrado.</p>
                            <?php } ?>
                        </div>

                        <a href="calendario.php" class="calendario-favorito">
                            <span class="icone-calendario">📅</span>
                            <span>Acesse o calendário</span>
                        </a>

                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</body>
<?php include "footer.php"; ?>