<?php
error_reporting(0);
//	include_once("../php/sessao.php");
function NomeArquivo($nome,$Pasta,$ext,$i=0){
	$Path = $Pasta.$nome.$ext;
	if(file_exists($Path)){
		$i++;
		$nNome = $nome.'-'.$i.$ext;
		$Path = $Pasta.$nNome;
		if(file_exists($Path)){
			return $this->NomeArquivo($nome,$Pasta,$ext,$i);
		}else{
			return $nNome.'.'.$ext;
		}
	}else{
		return $nome.'.'.$ext;
	}	
}

include_once("../includes/db.php");
include_once("../php/funcoes.php");
        
$Id = $_GET['id'];

$pag = $_GET['pag'];
$verQtd = query("SELECT * FROM img_pasta_prod WHERE produto_id = '$Id'");

	$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='$pag'");
	$Imagens = query("SELECT * FROM img_pasta_albuns WHERE albuns_id = '$Id'");
	$Total = count($Imagens);
	if($Total == 0){
		$Pasta = date("YmdHis");
		mkdir("../imagens/".$Pasta, 0777);
	}else{
		$Pasta = $Imagens[0]['pasta'];
	}
	
	//$extensao_arquivo = pathinfo($_FILES['arquivo']['name'],PATHINFO_EXTENSION);
	
//	$imagem = NomeArquivo(date("YmdHis").uniqid(),'../imagens/'.$Pasta.'/',$extensao_arquivo);
//	move_uploaded_file($_FILES['arquivo']['tmp_name'],'../imagens/'.$Pasta.'/'.$imagem);

	$imagem = gravaImagem($_FILES['arquivo'], $Pasta, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
	$conn = conecta();
	
	$insert = mysqli_query($conn, "INSERT INTO img_pasta_albuns(id,albuns_id,pasta,src) VALUES (NULL, '$Id', '$Pasta', '$imagem')");
	
	
	echo '1';
		
		


?>