<?php

include("../php/sessao.php");
session_write_close();
include("../includes/db.php");

$id = $_GET['id'];
$grupo = $_GET['g'];
$pag = $_GET['pag'];
$idioma = $_GET['idioma'];

$sql = "SELECT src FROM banners_idioma WHERE banner_id = ".$id." AND idioma_id = ".$idioma;
$dados = query($sql);

$sql = "UPDATE banners_idioma SET src='' WHERE banner_id = ".$id." AND idioma_id = ".$idioma;
$q = gravar($sql);
	
	$caminho = "../imagens/banners/grupo".$grupo."/".$dados['0']['src'];
	
if (file_exists($caminho)){	
    unlink ($caminho);
}

	$caminho = "../imagens/banners/grupo".$grupo."/thumb_".$dados['0']['src'];

if (file_exists($caminho)) {
	unlink ($caminho);
}

header("location:../index.php?pag=".$pag."&tipo=e&id=".$id." ");

?>