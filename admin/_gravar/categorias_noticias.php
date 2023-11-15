<?php 

	include("../includes/db.php");
	include ("../php/funcoes.php");
	include("../php/imgCaminho.php");
	include("../../php/plugins/seo.php");

	extract($_POST);

	$erro=true;

	//verrificar se o link não ira ser duplicado
    $link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link'");
    
    //caso exista ja um link igual este, entao será adicionado a data (dia e hora) do cadastro no final deste link
    if(count($verifica) >0 ) {
    	$dia = date("d-h-i");
    	$link = $link."-".$dia;
    }

    $conn = conecta();
	$sql="INSERT INTO categorias_noticias (titulo, titulo_ingles, titulo_espanhol, status, created, modified) VALUES('$tituloPort', '$tituloen', '$tituloesp', '1', NOW(), NOW())";

	$q = @mysqli_query($conn, $sql);

    $pegaUltimoId = query("SELECT * FROM categorias_noticias ORDER BY id DESC LIMIT 1");
    $categoria_id = $pegaUltimoId[0]['id'];

	$gravaLink = "INSERT INTO links (lin_pagina, lin_nome, title, metad, lin_id_pg, tipo) VALUES ('noticias_categ', '$link', '$title', '$metad', '$categoria_id', '8')";
	gravar($gravaLink);

	if($erro == false){ 
        $msg = "Erro ao realizar a operacão!";
	}else{
	    $msg = "Operação realizada com sucesso!";
	}

	if (!headers_sent($filename, $linenum)) {
		header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
	    exit;
	}	

?>