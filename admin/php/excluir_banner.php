<?php 

include("../includes/db.php");
include("../php/sessao.php");

$id = $_GET['id'];

if (isset($id)) {

	$dados = query("SELECT src,grupo FROM banners WHERE id =".$id);
	
	$dadosIdioma = query("SELECT src FROM banners_idioma WHERE banner_id = ".$id);

	if($dadosIdioma) { 
		foreach($dadosIdioma as $idioma) {
			$caminho = "../imagens/banners/grupo".$dados['0']['grupo']."/".$idioma['src'];
	
			if (file_exists($caminho)) {	
				unlink ($caminho);
			}
		
			$caminho = "../imagens/banners/grupo".$dados['0']['grupo']."/thumb_".$idioma['src'];
		
			if (file_exists($caminho)) {
				unlink ($caminho);
			}
		}
		
		$q = 'DELETE FROM banners_idioma WHERE banner_id = '.$id;
		$conn = conecta();
		$exec = mysqli_query( $conn, $q);
	}

	$caminho = "../imagens/banners/grupo".$dados['0']['grupo']."/".$dados['0']['src'];
	
	if (file_exists($caminho)) {	
		unlink ($caminho);
	}

	$caminho = "../imagens/banners/grupo".$dados['0']['grupo']."/thumb_".$dados['0']['src'];

	if (file_exists($caminho)) {
		unlink ($caminho);
	}
	
	$q = 'DELETE FROM banners WHERE id='.$id;
	$conn = conecta();
	$exec = mysqli_query( $conn, $q);
	
	$msg = "Banner excluido!";
		
} else {
	$msg = "Banner não excluido!";
}

header("location:../index.php?pag=20&tipo=p");

?>