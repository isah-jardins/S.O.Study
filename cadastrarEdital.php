<?php

include "conexaoBD.php";


/*
    Pega o vestibular que veio pela URL.
*/

if (!isset($_GET['idVestibular'])) {

    header("Location: editais.php");

    exit;

}


$idVestibular = intval($_GET['idVestibular']);


/*
    Busca o nome do vestibular.
*/

$sqlVestibular = "
    SELECT *
    FROM vestibulares
    WHERE idVestibular = $idVestibular
";

$resultadoVestibular = mysqli_query($conn, $sqlVestibular);

$vestibular = mysqli_fetch_assoc($resultadoVestibular);


/*
    Se o vestibular não existir,
    volta para a página de editais.
*/

if (!$vestibular) {

    header("Location: editais.php");

    exit;

}

?>

<?php include "header.php"; ?>


<style>

/* ========================================
   FORMULÁRIO
======================================== */

.formulario-edital {

    width: 500px;

    max-width: 90%;

    margin: 50px auto;

    background-color: white;

    padding: 40px;

    border-radius: 20px;

    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);

}


.formulario-edital h1 {

    color: #1c5a26;

    text-align: center;

    margin-bottom: 10px;

}


.formulario-edital h2 {

    color: #17421e;

    text-align: center;

    font-size: 20px;

    margin-bottom: 30px;

}


.formulario-edital label {

    display: block;

    margin-bottom: 7px;

    margin-top: 18px;

    color: #17421e;

    font-weight: bold;

}


.formulario-edital input {

    width: 100%;

    padding: 13px;

    border: 1px solid #ccc;

    border-radius: 8px;

    box-sizing: border-box;

    font-size: 16px;

}


.formulario-edital input:focus {

    outline: none;

    border-color: #1c5a26;

}


.botao-salvar {

    width: 100%;

    margin-top: 25px;

    padding: 14px;

    border: none;

    border-radius: 10px;

    background-color: #d50063;

    color: white;

    font-size: 16px;

    font-weight: bold;

    cursor: pointer;

}


.botao-salvar:hover {

    background-color: #b80054;

}


.botao-voltar {

    display: block;

    text-align: center;

    margin-top: 15px;

    color: #1c5a26;

    text-decoration: none;

    font-weight: bold;

}

</style>


<div class="formulario-edital">


    <h1>

        Novo Edital

    </h1>


    <h2>

        <?= htmlspecialchars($vestibular['nomeVestibular']) ?>

    </h2>


    <form action="actionEdital.php" method="POST">


        <!-- ID DO VESTIBULAR -->

        <input
            type="hidden"
            name="idVestibular"
            value="<?= $idVestibular ?>"
        >


        <!-- NOME -->

        <label for="nomeEdital">

            Nome do edital:

        </label>


        <input
            type="text"
            name="nomeEdital"
            id="nomeEdital"
            placeholder="Ex: Edital nº 01 - Inscrições"
            required
        >


        <!-- LINK -->

        <label for="linkEdital">

            Link do edital:

        </label>


        <input
            type="url"
            name="linkEdital"
            id="linkEdital"
            placeholder="https://..."
            required
        >


        <button
            type="submit"
            class="botao-salvar"
        >

            Cadastrar edital

        </button>


    </form>


    <a
        href="editais.php"
        class="botao-voltar"
    >

        ← Voltar para editais

    </a>


</div>


<?php include "footer.php"; ?>