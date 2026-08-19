<?php

include "conexaoBD.php";

/*
    Busca todos os vestibulares cadastrados.
*/
$sqlVestibulares = "
    SELECT *
    FROM vestibulares
    ORDER BY idVestibular ASC
";

$resultadoVestibulares = mysqli_query($conn, $sqlVestibulares);

?>

<?php include "header.php"; ?>


<style>

/* ========================================
   ÁREA PRINCIPAL
======================================== */

.pagina-editais {

    width: 85%;

    margin: 40px auto;

    background-color: #1c5a26;

    padding: 40px;

    border-radius: 15px;

    box-sizing: border-box;

}


/* ========================================
   TÍTULO
======================================== */

.pagina-editais h1 {

    color: white;

    text-align: center;

    margin-bottom: 40px;

}


/* ========================================
   BLOCO DO VESTIBULAR
======================================== */

.bloco-vestibular {

    background-color: #17421e;

    padding: 25px;

    margin-bottom: 35px;

    border-radius: 15px;

}


/* ========================================
   NOME DO VESTIBULAR
======================================== */

.bloco-vestibular h2 {

    color: white;

    margin-bottom: 20px;

    text-align: center;

}


/* ========================================
   EDITAL
======================================== */

.botao-edital {

    display: block;

    padding: 18px 25px;

    margin: 12px 0;

    border-radius: 10px;

    text-decoration: none;

    font-size: 18px;

    font-weight: bold;

    transition: 0.3s;

}


/* Editais pares */

.bloco-vestibular .botao-edital:nth-of-type(odd) {

    background-color: #86c27f;

    color: #17421e;

}


/* Editais ímpares */

.bloco-vestibular .botao-edital:nth-of-type(even) {

    background-color: #ffffff;

    color: #17421e;

}


/* Hover */

.botao-edital:hover {

    transform: translateX(5px);

    opacity: 0.85;

}


/* ========================================
   BOTÃO CADASTRAR EDITAL
======================================== */

.botao-novo-edital {

    display: block;

    text-align: center;

    background-color: #d50063;

    color: white;

    padding: 15px;

    margin-top: 20px;

    border-radius: 10px;

    text-decoration: none;

    font-weight: bold;

    transition: 0.3s;

}


.botao-novo-edital:hover {

    background-color: #b80054;

    color: white;

}


/* ========================================
   SEM EDITAIS
======================================== */

.sem-editais {

    background-color: #86c27f;

    color: #17421e;

    padding: 18px;

    border-radius: 10px;

    text-align: center;

}


/* ========================================
   NENHUM VESTIBULAR
======================================== */

.sem-vestibulares {

    background-color: white;

    color: #17421e;

    padding: 30px;

    border-radius: 10px;

    text-align: center;

}


/* ========================================
   RESPONSIVIDADE
======================================== */

@media (max-width: 700px) {

    .pagina-editais {

        width: 95%;

        padding: 20px;

    }

}

</style>


<main class="pagina-editais">


    <h1>

        Editais

    </h1>


    <?php

    /*
        Verifica se existem vestibulares.
    */

    if (mysqli_num_rows($resultadoVestibulares) > 0) {


        /*
            Percorre cada vestibular.
        */

        while ($vestibular = mysqli_fetch_assoc($resultadoVestibulares)) {

            $idVestibular = $vestibular['idVestibular'];

            $nomeVestibular = $vestibular['nomeVestibular'];

    ?>


        <!-- ========================================
             BLOCO DO VESTIBULAR
        ========================================= -->

        <div class="bloco-vestibular">


            <h2>

                <?= htmlspecialchars($nomeVestibular) ?>

            </h2>


            <?php

            /*
                Busca os editais pertencentes
                a este vestibular.
            */

            $sqlEditais = "
                SELECT *
                FROM editais
                WHERE idVestibular = $idVestibular
                ORDER BY idEdital ASC
            ";

            $resultadoEditais = mysqli_query($conn, $sqlEditais);


            /*
                Verifica se existem editais.
            */

            if (mysqli_num_rows($resultadoEditais) > 0) {


                /*
                    Mostra os editais.
                */

                while ($edital = mysqli_fetch_assoc($resultadoEditais)) {

                    $idEdital = $edital['idEdital'];

                    $nomeEdital = $edital['nomeEdital'];

                    $linkEdital = $edital['linkEdital'];

            ?>


                    <a
                        href="<?= htmlspecialchars($linkEdital) ?>"
                        class="botao-edital"
                        target="_blank"
                    >
                        <?= htmlspecialchars($nomeEdital) ?>
                    </a>


            <?php

                }

            } else {

            ?>


                <div class="sem-editais">

                    Nenhum edital cadastrado para este vestibular.

                </div>


            <?php

            }

            ?>


            <!-- ========================================
                 CADASTRAR NOVO EDITAL
            ========================================= -->

            <a
                href="cadastrarEdital.php?idVestibular=<?= $idVestibular ?>"
                class="botao-novo-edital"
            >

                + Cadastrar novo edital

            </a>


        </div>


    <?php

        }

    } else {

    ?>


        <div class="sem-vestibulares">

            <h2>
                Nenhum vestibular cadastrado.
            </h2>

            <p>
                Cadastre um vestibular primeiro para poder adicionar editais.
            </p>

        </div>


    <?php

    }


    ?>


</main>


<?php include "footer.php"; ?>