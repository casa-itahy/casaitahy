<?php

	$noticia = query("SELECT * FROM noticias WHERE status = 1 AND id = ".$pag_id);
    if (count($noticia) < 1) {
    	$noticia = false;
    } else {
    	$noticia = $noticia['0'];
		$noticia['data'] = formataData($noticia['created']);
        $noticia['conteudo'] = imagemEditor($noticia['conteudo']);
    }

    $capa_vendas = query("SELECT titulo, conteudo FROM paginas WHERE tipo = 5 AND id = 18 AND status = 1 ORDER BY id ASC");
    if (!empty($capa_vendas)) {
        $capa_vendas = $capa_vendas[0];
    }

    include_once "templates/noticia.php";