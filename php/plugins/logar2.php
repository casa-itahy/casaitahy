<?php
 
	include("../../admin/includes/db.php");
	include 'functions.php';

	$senha = sha1(anti_sql($_POST['senha']));
	$login = anti_sql($_POST['login']);
	$pagina = $_POST['pagina'];

	$retorno = query("SELECT id, nome, status FROM clientes WHERE login = '$login' AND senha = '$senha'");
	if (count($retorno) > 0) {
	    session_start();
		$_SESSION['cliente']['id'] = $retorno['0']['id'];
		$_SESSION['cliente']['nome'] = $retorno['0']['nome'];
		session_write_close();

		echo '<script>location.href="'.$pagina.'"</script>';
	} else {
		echo "Usuário ou senha incorreto(s)!";
	}