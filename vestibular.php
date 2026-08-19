<?php

session_start();

include "conexaoBD.php";


/* ==========================================
   VERIFICA SE O ID DO VESTIBULAR FOI ENVIADO
========================================== */

if (!isset($_GET['idVestibular'])) {

    header("Location: vestibulares.php");

    exit;
}


$idVestibular = intval($_GET['idVestibular']);


/* ==========================================
   BUSCA OS DADOS DO VESTIBULAR
========================================== */

$sqlVestibular = "
    SELECT *
    FROM vestibulares
    WHERE idVestibular = '$idVestibular'
";

$resultadoVestibular = mysqli_query($conn, $sqlVestibular);


if (mysqli_num_rows($resultadoVestibular) == 0) {

    echo "Vestibular não encontrado.";

    exit;
}


$vestibular = mysqli_fetch_assoc($resultadoVestibular);


$nome = $vestibular['nomeVestibular'];

$descricao = $vestibular['descricaoVestibular'];

$data = $vestibular['dataVestibular'];

$imagem = $vestibular['imagemVestibular'];


/* ==========================================
   VERIFICA SE ESTÁ FAVORITADO
========================================== */

$favoritado = false;


if (isset($_SESSION['idUsuario'])) {

    $idUsuario = $_SESSION['idUsuario'];


    $verificarFavorito = "
        SELECT idFavorito
        FROM favoritos
        WHERE idUsuario = '$idUsuario'
        AND idVestibular = '$idVestibular'
    ";


    $resultadoFavorito = mysqli_query(
        $conn,
        $verificarFavorito
    );


    if (mysqli_num_rows($resultadoFavorito) > 0) {

        $favoritado = true;

    }

}


/* ==========================================
   BUSCA OS EDITAIS
========================================== */

$sqlEditais = "
    SELECT *
    FROM editais
    WHERE idVestibular = '$idVestibular'
    ORDER BY idEdital ASC
";


$resultadoEditais = mysqli_query(
    $conn,
    $sqlEditais
);

?>


<?php include "header.php"; ?>


<!-- ==========================================
     MENSAGEM DE FAVORITO
========================================== -->

<?php

if (isset($_GET['favorito'])) {

    if ($_GET['favorito'] == 'adicionado') {

        echo '
            <div class="mensagem-favorito">
                ⭐ Vestibular adicionado aos favoritos!
            </div>
        ';

    }


    if ($_GET['favorito'] == 'removido') {

        echo '
            <div class="mensagem-favorito">
                ☆ Vestibular removido dos favoritos!
            </div>
        ';

    }

}

?>


<!-- ==========================================
     PÁGINA
========================================== -->

<main class="pagina-vestibular">
    
    <a href="javascript:history.back()" class="botao-voltar">
    ← Voltar
    </a>

    <!-- ======================================
         CARD PRINCIPAL
    ======================================= -->

    <section class="bloco-vestibular">


        <!-- FAVORITO -->

        <form
            action="favoritar.php"
            method="POST"
            class="form-favorito"
        >

            <input
                type="hidden"
                name="idVestibular"
                value="<?= $idVestibular ?>"
            >


            <button
                type="submit"
                class="botao-favorito <?= $favoritado ? 'favoritado' : ''; ?>"
                title="<?= $favoritado
                    ? 'Remover dos favoritos'
                    : 'Adicionar aos favoritos'; ?>"
            >

                <?= $favoritado ? '★' : '☆'; ?>

            </button>

        </form>


        <!-- IMAGEM -->

        <div class="imagem-vestibular">

            <img
                src="<?= htmlspecialchars($imagem) ?>"
                alt="<?= htmlspecialchars($nome) ?>"
            >

        </div>


        <!-- INFORMAÇÕES -->

        <div class="informacoes-vestibular">


            <h1>

                <?= htmlspecialchars($nome) ?>

            </h1>


            <div class="data-vestibular">

                <?= htmlspecialchars($data) ?>

            </div>


            <p>

                <?= htmlspecialchars($descricao) ?>

            </p>


        </div>


    </section>



    <!-- ======================================
         EDITAIS
    ======================================= -->

    <section class="bloco-links-vestibular">


        <h2>

            Editais

        </h2>


        <div class="lista-editais">


            <?php

            if (mysqli_num_rows($resultadoEditais) > 0) {


                while ($edital = mysqli_fetch_assoc($resultadoEditais)) {

            ?>


                    <a
                        href="<?= htmlspecialchars($edital['linkEdital']) ?>"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="link-vestibular"
                    >


                        <div class="icone-edital">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 -960 960 960"
                            >

                                <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/>

                            </svg>

                        </div>


                        <span>

                            <?= htmlspecialchars($edital['nomeEdital']) ?>

                        </span>


                        <span class="seta-edital">

                            →

                        </span>


                    </a>


            <?php

                }


            } else {

            ?>


                <p class="sem-editais">

                    Nenhum edital cadastrado para este vestibular.

                </p>


            <?php

            }

            ?>


        </div>


    </section>


</main>


<?php include "footer.php"; ?>