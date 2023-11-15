<?php

	$pagina = query("SELECT * FROM paginas WHERE id=".$pag_id);
    if (count($pagina) < 1) {
    	$pagina = false;
    } else {
    	$pagina = $pagina['0'];
    	$pagina['conteudo'] = imagemEditor($pagina['conteudo']);
    }

    $produtos = query ("SELECT p.*, links.lin_nome FROM produtos p LEFT JOIN links ON(links.lin_id_pg = p.id) WHERE links.tipo = 4 AND p.status = 1 ORDER BY p.posicao ASC");

	$textos = query("SELECT titulo, conteudo, status FROM paginas WHERE tipo = 5 AND id = 19 ORDER BY id ASC");
	if (!empty($textos)) {
		$textos = $textos[0];
	}

    include_once "templates/produtos.php";