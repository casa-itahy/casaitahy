<?php 

	include("../php/sessao.php");
        session_write_close();
include("../includes/db.php");
$pasta = $_GET[pasta];
$id = $_GET[id];
$img = $_GET[img];
$img_id=$_GET[imgid];
$pag = $_GET[pag];

$caminho = "../imagens/".$pasta."/".$img;

if (file_exists($caminho)){
    @unlink ($caminho);
}

$caminho = "../imagens/".$pasta."/thumb/".$img;
if (file_exists($caminho)){
    @unlink ($caminho);
}

$conn = conecta();
$sql="DELETE FROM img_pasta_albuns WHERE id='$img_id';";
$q = @mysqli_query($conn, $sql);

header("Location:../index.php?pag=$pag&id=".$id."&tipo=e");

?>