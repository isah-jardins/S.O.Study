<?php
    session_start (); //Da início à sessão
    session_unset(); //Apaga os registros da sessão
    session_destroy(); //Destrói a sessão

    header("Location: index.php"); //Redireciona o usuário para o formulário de Login 
    exit();
?>