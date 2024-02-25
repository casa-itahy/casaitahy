<?php

	if (!empty($pag_id)) {

		
		$pagina = query("SELECT * FROM paginas WHERE id=".$pag_id);
		
	    if (count($pagina) < 1) {
	    	$pagina = false;
	    } else {
	    	$pagina = $pagina['0'];
	    	$pagina['conteudo'] = imagemEditor($pagina['conteudo']);
	    }


		if($pag_id == 1) {
			$retorno = query("SELECT titulo, title, metad, conteudo, imagem, status FROM paginas WHERE tipo = 5 AND id = 16 OR id = 17 ORDER BY id ASC");
			if (empty($retorno)) {
				$textos = false;
			} else {
				$textos = $retorno;
			}

		    include_once "templates/empresa.php";
		} else if($pag_id == 55) {
			$retorno = query("SELECT titulo, title, metad, conteudo, imagem, status FROM paginas WHERE tipo = 5 AND id = 56 OR id = 55 ORDER BY id ASC");
			echo "<pre>";
			echo print_r($retorno);
			echo "</pre>";
			if (empty($retorno)) {
				$textos = false;
			} else {
				$textos = $retorno;
			}

		    include_once "templates/avaliar-imovel.php";
		}else if($pag_id == 4) {
			$retorno = query("SELECT titulo, title, metad, conteudo, imagem, status FROM paginas WHERE tipo = 5 AND id = 12 ORDER BY id ASC");
			if (empty($retorno)) {
				$textos = false;
			} else {
				$textos = $retorno;
			}

			$cases = query("SELECT * FROM banners WHERE grupo = 2 AND status = 1 ORDER BY ordem");

		    $depoimentos = query("SELECT titulo, imagem, descricao, conteudo FROM noticias WHERE status = 1 AND tipo = 3 AND capa = 2 ORDER BY created DESC");

		    include_once "templates/cases.php";
		} else if($pag_id == 5) {
			$parceiros = query("SELECT * FROM banners WHERE grupo = 1 AND status = 1 ORDER BY ordem");

		    $limite = 2;

		    if (!empty($_GET['pager'])) {
		        $paginacao = $_GET['pager'];
		    } else {
		        $paginacao = 1;
		    }

		    $inicio = ($paginacao * $limite) - $limite;

		    $depoimentos = query("SELECT titulo, imagem, descricao, conteudo FROM noticias WHERE status = 1 AND tipo = 3 AND capa = 1 ORDER BY created DESC LIMIT $inicio,$limite");

		    $mostraTotal = query("SELECT titulo, imagem, descricao, conteudo FROM noticias WHERE status = 1 AND tipo = 3 ORDER BY created DESC");

		    $total_registros = count($mostraTotal);
		    
		    $total_paginas = ceil($total_registros / $limite);

			$retorno = query("SELECT titulo, title, metad, conteudo, imagem, status FROM paginas WHERE tipo = 5 AND id = 18 ORDER BY id ASC");
			if (empty($retorno)) {
				$textos = false;
			} else {
				$textos = $retorno;
			}

		    include_once "templates/parceiros.php";
		} else {
		    include_once "templates/paginas.php";
		}
	}