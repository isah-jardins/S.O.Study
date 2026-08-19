<?php

session_start();

include "conexaoBD.php";


/* ========================================
   DATA RECEBIDA DO CALENDÁRIO
======================================== */

$data = $_GET['data'] ?? '';


/* ========================================
   CADASTRO DO EVENTO
======================================== */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = $_POST['titulo'];

    $descricao = $_POST['descricao'];

    $dataEvento = $_POST['data'];

    $hora = $_POST['hora'];

    $idUsuario = $_SESSION['idUsuario'];


    $sql = "INSERT INTO eventos
            (idUsuario, titulo, descricao, dataEvento, horaEvento, concluido)
            VALUES (?, ?, ?, ?, ?, FALSE)";


    $stmt = mysqli_prepare($conn, $sql);


    mysqli_stmt_bind_param(
        $stmt,
        "issss",
        $idUsuario,
        $titulo,
        $descricao,
        $dataEvento,
        $hora
    );


    if (mysqli_stmt_execute($stmt)) {

        header(
            'Location: calendario.php?data=' . $dataEvento
        );

        exit;

    } else {

        echo "Erro ao cadastrar evento: "
             . mysqli_error($conn);

    }

}

?>


<?php include "header.php"; ?>


<main class="pagina-evento">


    <!-- ====================================
         BOTÃO VOLTAR
    ===================================== -->

    <a
        href="calendario.php"
        class="botao-voltar-evento"
    >

        ← Voltar para o calendário

    </a>


    <!-- ====================================
         FORMULÁRIO
    ===================================== -->

    <div class="formulario">

        <h1>
            Adicionar evento
        </h1>


        <p class="subtitulo-evento">
            Cadastre uma nova atividade no seu calendário.
        </p>


        <form method="POST">


            <label for="titulo">
                Título
            </label>

            <input
                type="text"
                name="titulo"
                id="titulo"
                placeholder="Ex: Prova de Matemática"
                required
            >


            <label for="descricao">
                Descrição
            </label>

            <textarea
                name="descricao"
                id="descricao"
                placeholder="Adicione uma descrição para o evento..."
            ></textarea>


            <label for="data">
                Data
            </label>

            <input
                type="date"
                name="data"
                id="data"
                value="<?= htmlspecialchars($data) ?>"
                required
            >


            <label for="hora">
                Horário
            </label>

            <input
                type="time"
                name="hora"
                id="hora"
                required
            >


            <button type="submit">
                Salvar evento
            </button>


        </form>

    </div>

</main>


<?php include "footer.php"; ?>