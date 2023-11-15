<?php 
include_once("../includes/db.php");
include_once ("../php/funcoes.php");
include("../php/imgCaminho.php");
include("../../php/plugins/seo.php");

extract($_POST);

$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='".$pag."';");

#---- Imagem Principal -------#
$foto_principal = '';
if (!empty($_FILES['imagem'])) {
    $imagemUP = $_FILES['imagem'];
    $imagem = gravaImagem($imagemUP, $tabela, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
    if (!$imagem) {
    	$imagem = '';	
    } else {
    	$foto_principal = $imagem;
    }
}

/* Procura a ultima posição */
$posicao = ultimaPosicao($tabela);
$posicao = $posicao + 1;

if(!isset($destaque)) $destaque = '0';
if(!isset($lancamento)) $lancamento='0';
if(!isset($status)) $status=1;
if(!isset($peso)) $peso=0;
if(!isset($quantidade)) $quantidade=1;
if(!isset($cod)) $cod=1;
if(!isset($valor)) $valor=1;
    
$idiomas = query("SELECT * FROM idiomas WHERE status=1");
$noticia_id = 0;
$erro = true;

foreach ($idiomas as $idioma) {
	
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = $_POST['titulo'.$sigla];
    $texto_curto = $_POST['texto_curto'.$sigla];
    $texto = $_POST['texto'.$sigla];
    $title = $_POST['title'.$sigla];
    $metad = $_POST['metad'.$sigla];
	
	//pegar caminho das imagens no editor
	$newTexto = $texto;

	/*
    $titulo = mysql_escape_string($titulo);
    $texto_curto = mysql_escape_string($texto_curto);
    */
	
    //$conn = conecta();
	
	//link
	//verrificar se o link não ira ser duplicado
	$link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link'");
    
    //caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
    if(count($verifica) >0 ) {
    	$dia = date("d-y-i");
    	$link = $link."-".$dia;
    }
    
    if(strtolower(trim($sigla))=='port') {
    	$conn = conecta();
		$sql="INSERT INTO produtos(
                        titulo,title,metad,categoria_id,
                        imagem,descricao,textoBotao,linkBotao,target,conteudo,
                        cod,posicao,
                        destaque,lancamento,
                        status,peso,quantidade,
                        created,modified, valor, valor2)VALUES(
                        '$titulo','$title','$metad',
                        '$categoria','$foto_principal',
                        '$texto_curto','$textoBotao','$linkBotao','$target','$newTexto','$cod',
                        '$posicao','$destaque',
                        '$lancamento','$status','$peso',
                        '$quantidade',NOW(),NOW(), '$valor', '$valor2')";
				 
                $q = mysqli_query($conn, $sql);
				
				//GRAVANDO LINK NA TABELA LINKS
				//pegando a pagina
				$nomePg = query("SELECT * FROM modulos WHERE id='".$pag."';");
				$nmPagina = $nomePg[0]['pag_tab_nome'];
				
				$nmPagina = "produto";
				$pagina_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);
				//link url
				$gravaLink = "INSERT INTO links (lin_pagina, lin_nome, title, metad, lin_id_pg, tipo) VALUES ('$nmPagina', '$link', '$title', '$metad', '$pagina_id', 4)";
				gravar($gravaLink);
                
        if ($q) {
          $msg = "Operação realizada com sucesso!";
        }
    }else{
  		$conn = conecta();
        if($pagina_id!=0){
            $sql="INSERT INTO produtos_idioma(produto_id,idioma_id,titulo,title,metad,descricao,conteudo)
                    VALUES('$pagina_id','$idioma_id','$titulo','$title','$metad','$texto_curto','$newTexto')";
            
            $q = mysql_query($sql,$conn);
        }
    }
}
if (!headers_sent($filename, $linenum)) {
// descomentar quando não tiver mais imagens
	// header('Location: ../index.php?pag=3&tipo=p&msg='.$msg);
    header('Location: ../index.php?pag=3&tipo=e&lista=&o=&buscar=&id='.$pagina_id);
    exit;
}

?>