<?php

include("../php/sessao.php");
session_write_close();
include("../includes/db.php");

$id = $_GET['id'];
$pasta = $_GET['pasta'];
$pag = $_GET['pag'];

switch ($pasta){	
    case "categorias": 
            $tab="categorias_subcat";
            break;
    default: $tab=$pasta;
            break;
}

$sql = "SELECT imagem FROM $tab WHERE id=$id ";
$dados = query($sql);


$sql = "UPDATE $tab SET imagem='' WHERE id=$id ";
	$conn = conecta();
	$q = @mysqli_query($conn, $sql);	
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
        
$caminho = "../imagens/".$pasta."/".$dados[0][imagem];
if (file_exists($caminho)){	
            unlink ($caminho);
}
$caminho = "../imagens/".$pasta."/thumb_".$dados[0][imagem];
if (file_exists($caminho))
{
	unlink ($caminho);
}


header("location:../index.php?pag=".$pag."&tipo=e&id=".$id." ");

?>