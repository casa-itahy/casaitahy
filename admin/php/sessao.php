<?php

@session_start();


if(!isset($_SESSION["nome_adm"])){
    header("Location: index.php?pag=login");
    exit;
}

//session_write_close();
?>