<?php 

include_once("../includes/db.php");
include_once("funcoes.php");

$id = $_GET['id'];

$sql = "SELECT ordem, grupo FROM banners WHERE id = ".$id;        
$dados = query($sql);

$posicaoAtual = $dados['0']['ordem'];
$grupo = $dados['0']['grupo'];

$primeiro = query("SELECT MIN(ordem) as ordem FROM banners WHERE grupo = " . $grupo);
$primeiro = $primeiro['0']['ordem'];

if ($posicaoAtual != $primeiro) {

	$sql = "SELECT * FROM banners WHERE ordem=(SELECT MAX(ordem) FROM banners WHERE ordem < ".$posicaoAtual.")  AND grupo = ".$grupo;
	$proximo = query($sql);

	$proxPos = $proximo['0']['ordem'];
	$idProx = $proximo['0']['id'];

	$sql = "
		UPDATE banners as b1, banners as b2 
		SET
			b1.ordem = ".$posicaoAtual.",
			b2.ordem = ".$proxPos."
		WHERE
			b1.id = ".$idProx."
		AND b2.id= ".$id."
	";
	$q = gravar($sql);

}

if (!headers_sent($filename, $linenum)) {
   header('Location:../index.php?pag=20&tipo=p');
   exit;
}



?>