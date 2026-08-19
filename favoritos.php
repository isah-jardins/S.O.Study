<?php

session_start();

include "conexaoBD.php";

if (!isset($_SESSION['idUsuario'])) {
    header("Location: formLogin.php");
    exit();
}

$idUsuario = $_SESSION['idUsuario'];


// ==========================================
// BUSCA OS VESTIBULARES FAVORITADOS
// ==========================================

$sql = "SELECT
            v.idVestibular,
            v.nomeVestibular,
            v.descricaoVestibular,
            v.imagemVestibular,
            v.dataVestibular
        FROM favoritos f
        INNER JOIN vestibulares v
            ON f.idVestibular = v.idVestibular
        WHERE f.idUsuario = '$idUsuario'
        ORDER BY v.idVestibular ASC";

$resultado = mysqli_query($conn, $sql);

?>

<?php include "header.php"; ?>

<link rel="stylesheet" href="css/favoritos.css">


<div class="container">

    <!-- ==========================================
         TÍTULO
         ========================================== -->

    <h1 class="titulo-favoritos">
        ⭐ Favoritos
    </h1>


    <!-- ==========================================
         CALENDÁRIO ÚNICO
         ========================================== -->

    <div class="calendario-favoritos">

        <a
            href="calendario.php"
            class="botao-calendario"
        >

            <span class="icone-calendario">
                📅
            </span>

            <span>
                Acesse o calendário
            </span>

        </a>

    </div>


    <!-- ==========================================
         VERIFICA SE EXISTEM FAVORITOS
         ========================================== -->

    <?php if (mysqli_num_rows($resultado) == 0) { ?>

        <div class="sem-favoritos">

            <h2>
                Você ainda não possui favoritos.
            </h2>

            <p>
                Favorite um vestibular para ele aparecer aqui! ⭐
            </p>

        </div>


    <?php } else { ?>


        <!-- ==========================================
             LISTA DE VESTIBULARES FAVORITADOS
             ========================================== -->

        <?php while ($vestibular = mysqli_fetch_assoc($resultado)) { ?>

            <div class="card-favorito">


                <!-- NOME -->

                <h2>
                    <?= htmlspecialchars(
                        $vestibular['nomeVestibular']
                    ); ?>
                </h2>


                <!-- IMAGEM -->

                <?php if (!empty($vestibular['imagemVestibular'])) { ?>

                    <img
                        src="<?= htmlspecialchars(
                            $vestibular['imagemVestibular']
                        ); ?>"
                        alt="<?= htmlspecialchars(
                            $vestibular['nomeVestibular']
                        ); ?>"
                        class="imagem-favorito"
                    >

                <?php } ?>


                <!-- DATA -->

                <?php if (!empty($vestibular['dataVestibular'])) { ?>

                    <div class="data-favorito">

                        <?= htmlspecialchars(
                            $vestibular['dataVestibular']
                        ); ?>

                    </div>

                <?php } ?>


                <!-- DESCRIÇÃO -->

                <?php if (!empty($vestibular['descricaoVestibular'])) { ?>

                    <p class="descricao-favorito">

                        <?= htmlspecialchars(
                            $vestibular['descricaoVestibular']
                        ); ?>

                    </p>

                <?php } ?>


                <!-- ==========================================
                     EDITAIS
                     ========================================== -->

                <div class="editais-favorito">

                    <h3>
                        📄 Editais
                    </h3>


                    <?php

                    $idVestibular = $vestibular['idVestibular'];

                    $sqlEditais = "SELECT
                                        idEdital,
                                        nomeEdital,
                                        linkEdital
                                   FROM editais
                                   WHERE idVestibular = '$idVestibular'
                                   ORDER BY idEdital ASC";

                    $resultadoEditais = mysqli_query(
                        $conn,
                        $sqlEditais
                    );

                    ?>


                    <?php if (mysqli_num_rows($resultadoEditais) > 0) { ?>


                        <?php while ($edital = mysqli_fetch_assoc($resultadoEditais)) { ?>

                            <a
                                href="<?= htmlspecialchars(
                                    $edital['linkEdital']
                                ); ?>"
                                target="_blank"
                                class="edital-favorito"
                            >

                                📄
                                <?= htmlspecialchars(
                                    $edital['nomeEdital']
                                ); ?>

                            </a>

                        <?php } ?>


                    <?php } else { ?>

                        <p>
                            Nenhum edital cadastrado para este vestibular.
                        </p>

                    <?php } ?>


                </div>


                <!-- ==========================================
                     BOTÃO DE DETALHES
                     ========================================== -->

                <a
                    href="vestibular.php?idVestibular=<?= $idVestibular; ?>"
                    class="botao-detalhes"
                >
                    Ver detalhes →
                </a>


            </div>

        <?php } ?>

    <?php } ?>

</div>


<?php include "footer.php"; ?>