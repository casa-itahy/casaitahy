<?php 
	include("../php/sessao.php");
        session_write_close();
	include("../includes/db.php");
	include ("../php/funcoes.php");
	include("../php/imgCaminho.php");
	include("../../php/plugins/seo.php");

extract($_POST);

$idiomas = query("SELECT * FROM idiomas WHERE status=1");
$modulo = query("SELECT orientacao, tam_principal, tam_thumb FROM modulos WHERE pag_tab_id='".$pag."';");

//$titulo = mysql_escape_string($titulo);
//$texto_curto = mysql_escape_string($texto_curto);

$imagemUP = $_FILES['imagem'];
if (count($imagemUP) != 0 )
{
	if ($imagemUP['error'] == 0 )
	{
		$imagem = gravaImagem($imagemUP, $tabela, $modulo['0']['tam_principal'], $modulo['0']['tam_thumb'], $modulo['0']['orientacao']);
		if (!$imagem) {
			$UPimagem = "";
		} else {
			$UPimagem = "imagem='$imagem',";
		}
	}
}

$iconeUP = $_FILES['icone'];
if (count($iconeUP) != 0 )
{
	if ($iconeUP['error'] == 0 )
	{
		$icone = gravaImagem($iconeUP, $tabela.'/icones', '44', '44', $modulo['0']['orientacao']);
		if (!$icone) {
			$UPicone = "";
		} else {
			$UPicone = "icone='$icone',";
		}
	}
}

// Gravando a data
$created = explode('/', $created);
$created = $created[2]."-".$created[1]."-".$created[0]." 00:00:00";

if(!empty($_POST['tags'])){
  $tags =  implode(',',$_POST['tags']);
} else {
  $tags = '';
}

$erro=true;
foreach($idiomas as $idioma){
    $idioma_id = $idioma['id'];
    $sigla = $idioma['sigla'];
    $titulo = addslashes($_POST['titulo'.$sigla]);
    $texto_curto = addslashes($_POST['texto_curto'.$sigla]);
    $texto = $_POST['texto'.$sigla];
	
	//pegar caminho das imagens no editor
	

	
	$newTexto = addslashes($texto);
	
	//echo $newTexto;
	
	//echo $base;
	
	//exit();	

    //$titulo = mysql_escape_string($titulo);
    //$texto_curto = mysql_escape_string($texto_curto);
    $conn = conecta();
    if(strtolower(trim($sigla))=='port'){   
        $sql = "UPDATE $tabela SET 
        titulo='$titulo', 
        descricao='$texto_curto',
        tags='$tags',
        autor='$autor',
        capa='$categoria',
        conteudo='$newTexto',".
        $UPimagem .
        $UPicone
        ."modified =NOW(),
        created='$created'
        WHERE id=$id ";
        $q = mysqli_query($conn, $sql);

		$link = limpaURL($title);
		$verifica = query("SELECT * FROM links WHERE lin_nome = '$link' AND lin_id_pg <> $id");
		
		//caso exista ja um link igual este, entao será adicionado a data do cadastro no final deste link, a data no formato dd-mm-yyyy !!!SEM AS BARAS!!!
		if(count($verifica) >0 ) {
			$dia = date("d-y-i");
			$link = $link."-".$dia;
		}
			
		$conn = conecta();
		$upLink = "UPDATE links SET title='$title', metad='$metad', lin_nome = '$link' WHERE lin_id_pg = '$id' AND tipo = 6";
		$q2 = @mysqli_query($conn, $upLink);
    }else{        
        $sql="UPDATE noticias_idioma SET
        titulo='$titulo', 
        descricao='$texto_curto',
        conteudo='$newTexto'
        WHERE noticias_id=$id AND idioma_id=$idioma_id";
        $q = mysqli_query($conn, $sql);        
        //SE NÃO EXISTE DADOS DE IDIOMA NA TABELA, CRIAR: (sitemas antes deste código não inserem noticoas de idioma vazio)
        if(mysqli_affected_rows($conn)==0){
            $sql="INSERT INTO noticias_idioma(noticias_id,idioma_id,titulo,descricao,conteudo)VALUES('$id','$idioma_id','$titulo','$texto_curto','$newTexto')";
            $q = mysqli_query($conn, $sql);
        }
    }		
	if($q == false){ 		
		$msg = "Erro ao realizar a operação!";
	}else{		
		$msg = "Operação realizada com sucesso!";
	}
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
}

if($erro == false){ 
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
        $msg = "Erro ao realizar a operacão!";
}else{
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
        $msg = "Operação realizada com sucesso!";
}
if (!headers_sent($filename, $linenum)) {
	header("Location: ../index.php?pag=".$pag."&tipo=p&msg=".$msg);
    exit;
}	

?>