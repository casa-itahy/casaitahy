<?php

	$dados = query("SELECT subtitulo, titulo, conteudo, imagem FROM paginas WHERE tipo = 4");
	if (count($dados) > 0) {
		$titulo = $dados['0']['titulo'];
		$conteudo = $dados['0']['conteudo'];
		$imagem = $dados['0']['imagem'];
	}

	include_once "templates/contato.php";