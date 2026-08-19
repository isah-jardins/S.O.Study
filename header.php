<?php

error_reporting(0);

session_start();

date_default_timezone_set('America/Sao_Paulo');


// Verifica se existe uma sessão ativa
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {

    $idUsuario    = $_SESSION['idUsuario'];
    $nomeUsuario  = $_SESSION['nomeUsuario'];
    $emailUsuario = $_SESSION['emailUsuario'];

    $nomeCompleto = explode(' ', $nomeUsuario);

    $primeiroNome = $nomeCompleto[0];
}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/styles.css">
    
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>S.O.Study</title>

    <link
        rel="stylesheet"
        href="css/geral.css"
    >

    <link
        rel="stylesheet"
        href="css/styles.css"
    >

    <link
        rel="icon"
        type="image/x-icon"
        href="assets/favicon.ico"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</head>


<body>


<header class="cabecalho">


    <!-- LOGO -->

    <a
        href="index.php"
        class="logo"
    >

        S.O.Study

    </a>


    <!-- MENU -->

    <nav>

        <a href="index.php">
            início
        </a>

        <a href="editais.php">
            Editais
        </a>

        <a href="calendario.php">
            Calendário
        </a>

        <a href="favoritos.php">
            favoritos
        </a>

    </nav>


    <!-- USUÁRIO -->

    <div class="usuario-menu">

        <?php

        if (
            isset($_SESSION['logado']) &&
            $_SESSION['logado'] === true
        ) {

        ?>

            <a
                href="#"
                class="usuario"
            >

                <i class="bi bi-person-circle"></i>

                <?= htmlspecialchars($primeiroNome) ?>

            </a>


            <div class="menu-usuario">

                <a
                    href="logout.php"
                    title="Sair do Sistema"
                >

                    <i class="bi bi-box-arrow-right"></i>

                    Sair

                </a>

            </div>


        <?php

        } else {

        ?>

            <a
                href="formLogin.php"
                class="usuario"
            >

                <i class="bi bi-person-circle"></i>

                Login

            </a>

        <?php

        }

        ?>

    </div>


</header>