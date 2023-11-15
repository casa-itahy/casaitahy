<?php

include("../php/sessao.php");
session_write_close();
include("../includes/db.php");

$id = $_GET[id];
$tab = $_GET[pasta];
$pag = $_GET[pag];

$sql = "SELECT pdf_src FROM $tab WHERE id=$id ";
$dados = query($sql);

$sql = "UPDATE $tab SET pdf_src='' WHERE id=$id ";
	$conn = conecta();
	$q = @mysqli_query($conn, $sql);	
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
$caminho = "../docs_upload/".$dados[0][pdf_src];
if (file_exists($caminho)){	
            unlink ($caminho);
}
$caminho = "../docs_upload/thumb_".$dados[0][pdf_src];
if (file_exists($caminho))
{
	unlink ($caminho);
}


header("location:../index.php?pag=".$pag."&tipo=e&id=".$id." ");

?>