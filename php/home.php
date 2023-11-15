<?php

	$retorno = query("SELECT titulo, title, metad, conteudo, imagem, status FROM paginas WHERE tipo = 5 ORDER BY id ASC");
	if (empty($retorno)) {
		$textos = false;
	} else {
		$textos = $retorno;
	}

	$parceiros = query("SELECT * FROM banners WHERE grupo = 1 AND status = 1 ORDER BY ordem");

	$cases = query("SELECT * FROM banners WHERE grupo = 2 AND status = 1 ORDER BY ordem LIMIT 3");

    $depoimentos = query("SELECT titulo, imagem, descricao, conteudo FROM noticias WHERE status = 1 AND tipo = 3 AND capa = 2 ORDER BY created DESC");

    $noticias = query("SELECT n.*, links.lin_nome FROM noticias n LEFT JOIN links ON(links.lin_id_pg = n.id) WHERE links.tipo = 6 AND n.status = 1 AND n.tipo = 1 ORDER BY n.created ASC LIMIT 3");

	$linkSobre = query("SELECT lin_nome FROM links WHERE tipo = 1 AND lin_id_pg = 1");
	if (!empty($linkSobre)) {
		$linkSobre = $linkSobre[0]['lin_nome'];
	}

	$linkCases = query("SELECT lin_nome FROM links WHERE tipo = 1 AND lin_id_pg = 4");
	if (!empty($linkCases)) {
		$linkCases = $linkCases[0]['lin_nome'];
	}

    $diferenciais = query("SELECT * FROM noticias WHERE status = 1 AND tipo = 5 ORDER BY id ASC");

	$linkDiferenciais = query("SELECT lin_nome FROM links WHERE tipo = 1 AND lin_id_pg = 2");
	if (!empty($linkDiferenciais)) {
		$linkDiferenciais = $linkDiferenciais[0]['lin_nome'];
	}

	$linkNoticias = query("SELECT lin_nome FROM links WHERE tipo = 1 AND lin_id_pg = 6");
	if (!empty($linkNoticias)) {
		$linkNoticias = $linkNoticias[0]['lin_nome'];
	}

	#--------------------------- PAGINA
	
	include_once('templates/home.php');
	
	?>