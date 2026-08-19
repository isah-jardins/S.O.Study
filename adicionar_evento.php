<?php
session_start();
include "conexaoBD.php";

$data = $_GET['data'] ?? '';

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

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>Adicionar evento</title>

    <link rel="stylesheet" href="css/calendario.css">

</head>

<body>

<div class="formulario">

    <h1>Adicionar evento</h1>

    <form method="POST">

        <label>
            Título
        </label>

        <input
            type="text"
            name="titulo"
            required
        >


        <label>
            Descrição
        </label>

        <textarea
            name="descricao"
        ></textarea>


        <label>
            Data
        </label>

        <input
            type="date"
            name="data"
            value="<?php echo $data; ?>"
            required
        >


        <label>
            Horário
        </label>

        <input
            type="time"
            name="hora"
            required
        >


        <button type="submit">
            Salvar evento
        </button>
    </form>
</div>
</body>
</html>