<?php
    error_reporting(0); //Desabilita alertas de erros de execução
    session_start(); //Inicia sessão

    //Configura o fuso horário para América/São Paulo
    date_default_timezone_set('America/Sao_Paulo');

    //Verifica se há sessão ativa
    if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
        //Armazena em variáveis PHP os dados das variáveis de Sessão 
        $idUsuario    = $_SESSION['idUsuario'];
        $nomeUsuario  = $_SESSION['nomeUsuario'];
        $emailUsuario = $_SESSION['emailUsuario'];
        
        $nomeCompleto = explode(' ', $nomeUsuario); //Usa a função explode para fragmentar o nome do usuário
        $primeiroNome = $nomeCompleto[0]; //Armazena na primeira posição do array o primeiro fragmento do nome
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>S.O.Study</title>

        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body style="background-color:#5baeab;">
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark"  style= "background-color:#081d41;">
            <div class="container">
                <a class="navbar-brand" href="index.php">S.O.Study</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-1">
                        <li class="nav-item"><a class="nav-link" href="index.php">Início</a></li>
                        <li class="nav-item"><a class="nav-link" href="favoritos.php">Favoritos</a></li>
                    </ul>
                    <ul class="navbar-nav mb2 mb-lg-0 ms-lg-2">
                        <?php
                            //Verifica se há sessão ativa
                            if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                                
                                    echo "
                                        <li class='nav-item dropdown'>
                                            <a class='nav-link dropdown-toggle' id='navbarDropdown' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'><i class = 'bi bi-person-circle'></i> $primeiroNome</a>
                                            <ul class='dropdown-menu' aria-labelledby='navbarDropdown'>
                                                <li><a class='dropdown-item' href='logout.php' title= 'Sair do Sistema'>Sair</a></li>
                                            </ul>
                                        </li>
                                    ";  
                            }
                            else{
                                echo "<li class='nav-item'><a class='nav-link' href='formLogin.php'>Login</a></li>";
                            }
                        ?>
                    </ul>
                </div>
                
            </div>
        </nav>
        
        