<?php
session_start();
//arqui para troca de idioma

if(isset($_GET['idioma'])) {
	
	//verrificando se o valor do $_GET['idioma'] é numérico
	$idIdioma = $_GET['idioma'];
	$pagina = $_GET['pagina'];
	if(!is_numeric($idIdioma)) {
		header("location: ../../home");
	}else{
	
		$_SESSION['idiomaArtWeb'] = $idIdioma;
		
		header("location: ../../".$pagina);
	}
	
}

?>