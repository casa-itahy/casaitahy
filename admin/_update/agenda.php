<?php 
	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");
	include ("../php/funcoes.php");

extract($_POST);

$x = explode("/", $data);
$created = $x['2']."-".$x['1']."-".$x['0'];


	//pegar caminho das imagens no editor
	include("../php/imgCaminho.php");

	$texto = $_POST['texto'];
	$newTexto = pegaImg($texto);
	
	//echo $newTexto;
	
	//echo $base;
	
	//exit();



//$titulo = mysql_escape_string($titulo);
    
    $sql="UPDATE noticias SET
        	titulo		= '$titulo',
        	descricao	= '$data',
        	conteudo	= '$newTexto',
        	created 	= '$created'
        	WHERE id	= $id
        ";
	$q = gravar($sql);

	$msg = "Operação realizada com sucesso!";
		
if (!headers_sent($filename, $linenum)) {
	header("Location: ../index.php?pag=21&tipo=p&msg=".$msg);
    exit;
}	

?>