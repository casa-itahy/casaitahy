<?php 

/*########## IMPORTANTE ###############################################
 * SEMPRE O ID=1 DA TABELA IDIOMAS TERA O PORTUGUÊS ISSO É ESTATICO ##
 * ###################################################################*/
include("../includes/db.php");
include ("../php/funcoes.php");
include("../php/imgCaminho.php");
include("../../php/plugins/seo.php");

extract($_POST);

$modulo = query("SELECT modulo_gemeo, orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='".$pag."';");

$idiomas = query("SELECT * FROM idiomas WHERE status=1");

/* Envia a imagem para redimensionamento */
$imagemUP = $_FILES['imagem'];
$imagem = gravaImagem($imagemUP, $tabela, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
if (!$imagem) {
	$imagem = '';	
}

/* Envia a imagem para redimensionamento */
$iconeUP = $_FILES['icone'];
$icone = gravaImagem($iconeUP, $tabela.'/icones', '44', '44', $modulo['0']['orientacao']);
if (!$icone) {
    $icone = '';   
}

$noticia_id=0;
$erro=true;

// Gravando a data
if (!empty($created)) {
	$created = explode('/', $created);
	$created = $created[2]."-".$created[1]."-".$created[0]." 00:00:00";
} else {
	$created = date('Y-m-d H:i:s');
}

if(!empty($_POST['tags'])){
  $tags =  implode(',',$_POST['tags']);
} else {
  $tags = '';
}

foreach($idiomas as $idioma){
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = addslashes($_POST['titulo'.$sigla]);
    $texto_curto = addslashes($_POST['texto_curto'.$sigla]);
    $texto = $_POST['texto'.$sigla];

    //$titulo = mysql_escape_string($titulo);
    //$texto_curto = mysql_escape_string($texto_curto);
	
	//pegar caminho das imagens no editor
	

	$newTexto = addslashes($texto);

	//echo $newTexto;
	
	//echo $base;
	
	//exit();
	
	//verrificar se o link não ira ser duplicado
    $link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link'");
    
    //caso exista ja um link igual este, entao será adicionado a data (dia e hora) do cadastro no final deste link
    if(count($verifica) >0 ) {
    	$dia = date("d-h-i");
    	$link = $link."-".$dia;
    }

    $conn = conecta();
 
    if(strtolower(trim($sigla))=='port'){        
			$sql="INSERT INTO $tabela 
						(titulo, descricao, autor,conteudo,imagem,icone,capa,tipo,tags,created,modified)
						VALUES('$titulo', '$texto_curto', '$autor','$newTexto','$imagem','$icone','$categoria','".$modulo[0]['modulo_gemeo']."','$tags','$created',NOW())";
	
			$q = mysqli_query($conn, $sql);
			$noticia_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);
			//var_dump($noticia_id);
			//die();
			
			$gravaLink = "INSERT INTO links (lin_pagina, lin_nome, title, metad, lin_id_pg, tipo) VALUES ('noticia', '$link', '$title', '$metad', '$noticia_id', 6)";
			gravar($gravaLink);
    }else{
        if($noticia_id!=0){
            $sql="INSERT INTO noticias_idioma(noticias_id,idioma_id,titulo,descricao,conteudo)VALUES('$noticia_id','$idioma_id','$titulo','$texto_curto','$newTexto')";
            $q = mysqli_query($conn, $sql);
            //var_dump($sql);
            //die();
        }
    }
}
        
if($erro == false){ 
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
        $msg = "Erro ao realizar a operacão!";
}else{
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
        $msg = "Operação realizada com sucesso!";
}


if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}	

?>