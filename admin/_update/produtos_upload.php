<?php

	// error_reporting(0);
	//	include_once("../php/sessao.php");
	    session_write_close();
		include_once("../includes/db.php");
		include_once("../php/funcoes.php");
	        
	$Id = $_GET['id'];

	$pag = $_GET['pag'];

	$verQtd = query("SELECT * FROM img_pasta_prod WHERE produto_id = '$Id'");

	$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='$pag'");
	$Imagens = query("SELECT * FROM img_pasta_prod WHERE produto_id = '$Id'");
	$Total = count($Imagens);
	if($Total == 0){
		$Pasta = date("YmdHis");
		mkdir("../imagens/".$Pasta, 0777);
	}else{
		$Pasta = $Imagens[0]['pasta'];
	}

	$conn = conecta();
	$imagem = gravaImagem($_FILES['arquivo'], $Pasta, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
	$insert = mysqli_query($conn, "INSERT INTO img_pasta_prod VALUES (NULL, '$Id', '$Pasta', '$imagem', NULL, '', NULL, NULL)");
	echo '1';

?>