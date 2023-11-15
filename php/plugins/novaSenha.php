<?php

	include("../../admin/includes/db.php");
	include 'functions.php';
	require_once('PHPMailer/class.phpmailer.php');
		

	
	$senha 	= anti_sql(md5($_POST['senha']));
	$idUser = anti_sql($_POST['idUser']);
	$key 	= anti_sql($_POST['key']);
	
	
	$conn = conecta();
	$novaSenha = "UPDATE clientes SET senha = '".$senha."', id_troca = '' WHERE id = '".$idUser."' AND id_troca = '".$key."'";
	$exec = mysql_query($novaSenha, $conn);
	
	if($exec) {
		echo "Senha atualizada";
	}else{
		echo "Ocorreu um problema ao cadastrar sua nova senha ou sua nova senha já foi cadastrada";
	}


?>