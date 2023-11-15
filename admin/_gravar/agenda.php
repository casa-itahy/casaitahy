<?php 
	include("../includes/db.php");
	include ("../php/funcoes.php");
	include("../php/sessao.php");
	include("../../php/plugins/seo.php");

extract($_POST);

//$titulo = mysql_escape_string($titulo);
$x = explode("/", $data);
$created = $x['2']."-".$x['1']."-".$x['0'];

	//pegar caminho das imagens no editor
	include("../php/imgCaminho.php");

	$texto = $_POST['texto'];
	$newTexto = pegaImg($texto);
	
	//echo $newTexto;
	
	//echo $base;
	
	//exit();
	
	//link
	//verrificar se o link não ira ser duplicado
	$link = limpaURL($titulo);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link'");
    
    //caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
    if(count($verifica) >0 ) {
    	$dia = date("d-m-i");
    	$link = $link."-".$dia;
    }



$sql="INSERT INTO noticias 
		(
		titulo, 
		descricao,
		conteudo,
		tipo,
		created,
		modified
		)
		VALUES
		(
		'$titulo', 
		'$data',
		'$newTexto',
		'3',
		'$created',
		NOW()
		)";

	$conn = conecta();
	$q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	$insert_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
	
	if($q == false)
	{ 
		$msg = "Erro ao realizar a opera��o!";
	}
	else
	{	 
		//link url
		$gravaLink = "INSERT INTO links (lin_pagina, lin_nome, lin_id_pg, tipo) VALUES ('agenda', '$link', '$insert_id', 7)";
		gravar($gravaLink);
		
		$msg = "Operação realizada com sucesso!";
	}
	
	@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
	
if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag=21&tipo=p&msg='.$msg);
    exit;
}	

?>