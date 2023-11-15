<?php

include("../php/sessao.php");
session_write_close();
include("../includes/db.php");

$id = $_GET[id];
$pag = $_GET[pag];

$sql = "SELECT src FROM docs WHERE id=$id ";
$dados = query($sql);

$sql = "UPDATE docs SET src='' WHERE id=$id ";
	$conn = conecta();
	$q = @mysqli_query($conn, $sql);	
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
$caminho = "../docs_upload/".$dados[0][src];
if (file_exists($caminho)){	
            unlink ($caminho);
}

header("location:../index.php?pag=".$pag."&tipo=e&id=".$id." ");

?>