<?php

	#--------------------------------------- Include e Define
	include_once('admin/includes/db.php');
	include_once("plugins/functions.php");
	include_once("plugins/seo.php");	

	//arquivo de idiomas
	//include_once('lang/lang.php');
	
	if ($_SERVER['HTTP_HOST'] === 'localhost' || $_SERVER['HTTP_HOST'] === '127.0.0.1') {
		# Local #
		$raiz = explode("/", $_SERVER['REQUEST_URI']);
		$base = $_SERVER['HTTP_HOST']."/".$raiz['1']."/";
	} else {
		# Online #
		$base = $_SERVER['HTTP_HOST']."/";
	}

	
	define ("IMAGENS","admin/imagens/");

	@session_start();
	//iniciando a seção de idiomas
	if(!isset($_SESSION['idiomaArtWeb'])) {
		$SESSAO_IDIOMA = 1;
	}elseif($_SESSION['idiomaArtWeb'] == 2) {
		$SESSAO_IDIOMA = 2;
	}elseif($_SESSION['idiomaArtWeb'] == 3) {
		$SESSAO_IDIOMA = 3;
	}else{
		$SESSAO_IDIOMA = 1;
	}

	if(isset($idioma_escolhido)){
	    $_SESSION['idioma_id']=$idioma_escolhido;
	    $_SESSION['idioma_sigla']=Idioma::getSigla($idioma_escolhido);
	}
	if(isset($_SESSION['idioma_id'])){
	        $idioma_id=$_SESSION['idioma_id'];
	        $idioma_sigla=$_SESSION['idioma_sigla'];
	}else{
	    $_SESSION['idioma_id']=1;//Portugues
	    $_SESSION['idioma_sigla']='port';//Portugues
	    $idioma_id=1;
	    $idioma_sigla='port';
	}

	session_write_close();

	#------------------------------------------ Carrega Dados Index
	$config = query("SELECT e.dsc_estado as estado_dsc, e.sigl_estado as estado_sigl, cid.dsc_cidade as cidade_dsc, c.* FROM config c LEFT JOIN estados e ON(c.estado=e.id_estado) LEFT JOIN cidades cid ON(c.cidade=cid.id_cidade) WHERE c.id=1");
	$config = $config['0'];

	$menu = query("SELECT p.id, p.titulo, p.tipo, links.lin_nome, m.pag_tab_nome FROM links, paginas p LEFT JOIN modulos m ON(p.tipo=m.id) RIGHT JOIN pag_subpag_nivel csn ON (p.id = csn.pag_pai_id) WHERE csn.pag_filho_id IS NULL AND csn.pag_neto_id IS NULL AND p.status = 1 AND p.tipo <> 5 AND links.lin_id_pg = p.id AND links.tipo = 1 AND p.tipo != 39 ORDER BY p.posicao");

	$texto_rodape = query("SELECT * FROM paginas WHERE tipo = 5 AND id = 15 OR id = 20 ORDER BY id");

	$linkContato = query("SELECT lin_nome FROM links WHERE tipo = 1 AND lin_id_pg = 7");
	if (!empty($linkContato)) {
		$linkContato = $linkContato[0]['lin_nome'];
	}

	if (!empty($config['fone2'])):
		if (is_mobile()):
			$linkWhatsapp = "https://api.whatsapp.com/send?phone=+55".preg_replace('/[^0-9]/', '', $config['fone2']);
		else:
			$linkWhatsapp = "https://web.whatsapp.com/send?phone=+55".preg_replace('/[^0-9]/', '', $config['fone2']);
		endif;
	endif;

	#------------------------------------------ Incluir Pagina
	if (!empty($_GET['page'])) {
		$url = explode('/', $_GET['page']);
		$pag = anti_sql($url['0']);
		if (!empty($url['1'])) {
			$msg = anti_sql($url['1']);
			$status_menu = anti_sql($url['1']);
		}
	} else {
		$pag = "home";
	}

	if(!isset($status_menu)) {
		$status_menu = 0;
	}

	/* PHP INJECTION */
	if(preg_match("/http|www|ftp|.dat|.txt|.gif|wget/", $pag)) {
		echo('<meta http-equiv="refresh" content="0;URL=/erros/404.html">');
	}else{
        
		if($pag == "home" or $pag == "") {
			$chamaTipoPg[0]['lin_pagina'] = "home";
			
		} elseif($pag == "buscar") {
			$chamaTipoPg[0]['lin_pagina'] = "buscar";
		}else{
			$chamaTipoPg = query("SELECT * FROM links WHERE lin_nome = '$pag'");
			$seoTitle = $chamaTipoPg['0']['title'];
			$seoDescription = $chamaTipoPg['0']['metad'];
		}

		if($chamaTipoPg[0]['lin_pagina'] == "") {
			$chamaTipoPg[0]['lin_pagina'] = $pag;
		}

		if (!empty($chamaTipoPg[0]['lin_id_pg'])) {
			$pag_id = $chamaTipoPg[0]['lin_id_pg'];
		}

		$include = "php/".$chamaTipoPg[0]['lin_pagina'].'.php';
		
		if (!file_exists($include)){
			echo('<meta http-equiv="refresh" content="0;URL=/erros/404.html">');
		}
	}

	#---------------------------------------------- SEO
	$chamaSeo = "SELECT * FROM config";
	$mostraSeo = query($chamaSeo);
	#---------------------------------------------- SEO