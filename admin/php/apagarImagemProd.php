<?php 
	include("../php/sessao.php");
        session_write_close();
include("../includes/db.php");
$pasta = $_GET['pasta'];
$id = $_GET['id'];
$img = $_GET['img'];
$pag = $_GET['pag'];

$caminho = "../imagens/".$pasta."/".$img;

if (file_exists($caminho)){
    @unlink($caminho);
}

$caminho = "../imagens/".$pasta."/thumb_".$img;
if (file_exists($caminho)){
    @unlink($caminho);
}
$conn = conecta();

if(!empty($img)){
    $sql="DELETE FROM img_pasta_prod WHERE src='$img';";
    $q = @mysqli_query($conn, $sql);
}

header("Location:../index.php?pag=".$pag."&id=".$id."&tipo=e");

?>