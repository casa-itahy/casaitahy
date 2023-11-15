<?php

	include_once("../php/sessao.php");
    session_write_close();
	include_once("../includes/db.php");
	include_once("../php/funcoes.php");
	include_once("../php/class.upload.php");
	include("../php/imgCaminho.php");
	include("../../php/plugins/seo.php");

extract($_POST);

$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='".$pag."';");

$idiomas = query("SELECT * FROM idiomas WHERE status=1");

if (empty($pasta)){
	$pasta = date("dmYhis");
}

#---- Imagem Principal -------#
if (isset($_FILES['imagem'])) {
	$imagemUP = $_FILES['imagem'];
	$imagem = gravaImagem($imagemUP, $tabela, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
	if (!$imagem) {
		$UPimagem = '';	
	} else {
		$UPimagem = "imagem = '$imagem',";
	}
}

if(!isset($peso)) $peso=0;
if(!isset($quantidade)) $quantidade=1;
// if(!isset($cod)) $cod=1;
if(!isset($valor)) $valor=1;

$noticia_id=0;
$erro=true;

foreach ($idiomas as $idioma) {
	
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = $_POST['titulo'.$sigla];
    $title = $_POST['title'.$sigla];
    $metad = $_POST['metad'.$sigla];
    $texto_curto = $_POST['texto_curto'.$sigla];
    $newTexto = $_POST['texto'.$sigla];

    //$titulo = mysql_escape_string($titulo);
    //$texto_curto = mysql_escape_string($texto_curto);
    //$cod = mysql_escape_string($cod);
	//link
	//verrificar se o link não ira ser duplicado
	$link = limpaURL($title);
    $verifica = query("SELECT * FROM links WHERE lin_nome = '$link' AND lin_id_pg <> $id");
    
    //caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
    if(count($verifica) >0 ) {
    	$dia = date("d-y-i");
    	$link = $link."-".$dia;
    }

    if(strtolower(trim($sigla))=='port') {
        $sql = "UPDATE produtos SET
                titulo='$titulo',
                title='$title',
                metad='$metad',
                categoria_id = '$categoria',
                descricao='$texto_curto', 
                cod='$cod',
				textoBotao='$textoBotao',
                linkBotao='$linkBotao',
                target='$target',
                valor='$valor',
                valor2='$valor2',
                metragem='$metragem',
                dormitorios='$dormitorios',
                suites='$suites',
                vagas='$vagas',
                condominio='$condominio',
                iptu='$iptu',
                endereco='".addslashes($endereco)."',
				peso='$peso',
				quantidade='$quantidade',
                conteudo='$newTexto',
                ".$UPimagem." modified =NOW() WHERE id=$id ";
				

		$conn = conecta();
        $upLink = "UPDATE links SET title='$title', metad='$metad', lin_nome = '$link' WHERE lin_id_pg = '$id' AND tipo = 4";
        $q2 = mysqli_query($conn,$upLink);

        $q = gravar($sql);
    } else {
         $sql = "UPDATE produtos_idioma SET
                titulo='$titulo',
                title='$title',
                metad='$metad',
                descricao='$texto_curto',
                conteudo='$newTexto' 
                WHERE produto_id=$id AND idioma_id=$idioma_id";
                  
         $conn = conecta();
         $q = @mysqli_query($conn, $sql);
         if(mysqli_affected_rows($conn)==0){
             $sql="INSERT INTO produtos_idioma(produto_id,idioma_id,titulo,title,metad,descricao,conteudo)
                    VALUES('$id','$idioma_id','$titulo','$title','$metad','$texto_curto','$newTexto')";
            
             $q = gravar($sql);
         }
    }
         
    $msg = "Operação realizada com sucesso!";
}

if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}