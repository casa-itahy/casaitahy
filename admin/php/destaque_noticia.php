<?php 
include("../php/sessao.php");
session_write_close();
include("../includes/db.php");

	$t = $_GET['t'];
	$id = $_GET['id'];
	$v = $_GET['v'];

	$sql = "UPDATE noticias SET destaque = $v WHERE id = ".$id;

	$conn = conecta();
	$q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	if($q == false){ 
		@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
		erro('
			<p>Ocorreu um problema durante a grava��o no banco de dados mysql!</p>
			<p>O erro encontrado foi:</p>
			<p>'.mysqli_error($GLOBALS["___mysqli_ston"]).'</p>
		');
	}


	header("location:../index.php?pag=".$t."&tipo=p");