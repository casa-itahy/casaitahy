<?php

	$produto = query("SELECT * FROM produtos WHERE status = 1 AND id = ".$pag_id);
    if (count($produto) < 1) {
    	$produto = false;
    } else {
    	$produto = $produto['0'];
    	$imagens = query("SELECT * FROM img_pasta_prod WHERE produto_id = ".$produto['id']);
    	$valor_formatado = str_replace('.', '', $produto['valor']);
    	$valor_formatado = str_replace(',', '.', $valor_formatado);
    	if ($produto['metragem'] != 0) {
		    $produto['valor_metragem'] = $valor_formatado / $produto['metragem'];
    	}
    }

    $produtos = query ("SELECT p.*, links.lin_nome FROM produtos p LEFT JOIN links ON(links.lin_id_pg = p.id) WHERE links.tipo = 4 AND p.status = 1 AND p.id != ".$pag_id." ORDER BY RAND() LIMIT 3");

    $linkProdutos = query("SELECT lin_nome FROM links WHERE tipo = 1 AND lin_id_pg = 3");
    if (!empty($linkProdutos)) {
        $linkProdutos = $linkProdutos[0]['lin_nome'];
    }

    include_once "templates/produto.php";