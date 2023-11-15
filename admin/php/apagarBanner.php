<?php

include("../php/sessao.php");
session_write_close();
include("../includes/db.php");

$id = $_GET['id'];
$grupo = $_GET['g'];
$pag = $_GET['pag'];

$sql = "SELECT src FROM banners WHERE id=$id ";
$dados = query($sql);


$sql = "UPDATE banners SET src='' WHERE id=$id ";
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