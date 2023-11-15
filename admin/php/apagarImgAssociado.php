<?php

include("../php/sessao.php");
session_write_close();
include("../includes/db.php");

$id = $_GET['id'];
$grupo = $_GET['g'];
$pag = $_GET['pag'];

$sql = "SELECT logomarca FROM associados WHERE id=$id ";
$dados = query($sql);


$sql = "UPDATE associados SET logomarca='' WHERE id=$id ";
$conn = conecta();
$exec = mysqli_query( $conn, $sql);
	
	$caminho = "../imagens/associados/".$dados['0']['logomarca'];
	
if (file_exists($caminho)){	
    @unlink ($caminho);
}

	$caminho = "../imagens/associados/thumb_".$dados['0']['logomarca'];

if (file_exists($caminho)) {
	@unlink ($caminho);
}

header("location:../index.php?pag=".$pag."&tipo=e&id=".$id." ");

?>