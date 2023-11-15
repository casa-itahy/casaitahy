<?php

    $conteudo_pagina = query("SELECT * FROM paginas WHERE id = ".$pag_id);
    if (count($conteudo_pagina) < 1) {
        $conteudo_pagina = false;
    } else {
        $conteudo_pagina = $conteudo_pagina['0'];
        $conteudo_pagina['conteudo'] = imagemEditor($conteudo_pagina['conteudo']);
    }

    if ($pag_id == 2) { // Diferenciais
        $retorno = query("SELECT titulo, title, metad, conteudo, imagem, status FROM paginas WHERE tipo = 5 AND id = 22 ORDER BY id ASC");
        if (empty($retorno)) {
            $textos = false;
        } else {
            $textos = $retorno;
        }

        $diferenciais = query("SELECT * FROM noticias WHERE status = 1 AND tipo = 5 ORDER BY id ASC");

        include_once "templates/diferenciais.php";
    } else {
        $limite = 6;

        if (!empty($_POST['busca'])) {
            $buscar = $_POST['busca'];
            $select_busca = " AND (n.titulo LIKE '%".$buscar."%' OR n.descricao LIKE '%".$buscar."%' OR n.conteudo LIKE '%".$buscar."%')";
            $limite = 100;
        } else {
            $buscar = "";
            $select_busca = "";
        }

        if (!empty($_GET['pager'])) {
            $pagina = $_GET['pager'];
        } else {
            $pagina = 1;
        }

        $inicio = ($pagina * $limite) - $limite;

        $noticias = query("SELECT n.*, links.lin_nome FROM noticias n LEFT JOIN links ON(links.lin_id_pg = n.id) WHERE links.tipo = 6 AND n.status = 1 AND n.tipo = 1 ".$select_busca." ORDER BY n.created DESC LIMIT $inicio,$limite");

        $mostraTotal = query("SELECT n.*, links.lin_nome FROM noticias n LEFT JOIN links ON(links.lin_id_pg = n.id) WHERE links.tipo = 6 AND n.status = 1 AND n.tipo = 1 ".$select_busca." ORDER BY n.created DESC");

        $total_registros = count($mostraTotal);
        
        $total_paginas = ceil($total_registros / $limite);

        $categorias = query("SELECT cn.titulo, cn.id, links.lin_nome FROM categorias_noticias cn LEFT JOIN links ON(links.lin_id_pg = cn.id) WHERE links.tipo = 8 ORDER BY cn.titulo ASC");

        $noticias_destaque = query("SELECT n.*, links.lin_nome FROM noticias n LEFT JOIN links ON(links.lin_id_pg = n.id) WHERE links.tipo = 6 AND n.status = 1 AND n.tipo = 1 AND n.destaque = 1 ORDER BY n.created DESC LIMIT 4");

        include_once "templates/noticias.php";
    }