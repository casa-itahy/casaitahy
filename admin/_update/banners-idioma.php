<?php 

    include("../includes/db.php");
    include ("../php/funcoes.php");
    include("../php/sessao.php");
    session_write_close();

    extract($_POST);

$config = query("SELECT * FROM grupo_banners WHERE id = ".$grupo);

/* Envia a imagem para redimensionamento */
if (isset($_FILES['imagem'])) {
	$imagemUP = $_FILES['imagem'];
	$orientacao = strtoupper($config['0']['orientacao']);

	if ($orientacao == 'v') {
		$tamanho = $config['0']['largura'];
	} else if ($orientacao == 'h') {
		$tamanho = $config['0']['altura'];
	} else {
		$tamanho = $config['0']['largura'];
	}

	$thumb = 724;

	$imagem = gravaImagem($imagemUP, 'banners/grupo'.$grupo, $tamanho, $thumb, $config['0']['orientacao']);

	if (!$imagem) {
		$imagem = '';
	} else {
		$imagem = $imagem;
	}
} else {
	$imagem = '';
}
//$titulo = mysql_escape_string($titulo);
$urllink = stripslashes($urllink);

if (!empty($texto)){
	$texto = $texto;
} else {
	$texto = "";
}

if($temBanner == 'sim') {
	if(!empty($imagem)){
		$imagem = "src = '$imagem', ";
	}

	$sql = "
		UPDATE banners_idioma SET 
        nome = '$titulo',
        descricao = '$descricao',
		".$imagem."
		texto = '".$texto."'
        WHERE banner_id = ".$id." AND idioma_id = ".$idioma;
} else {
	$sql="INSERT INTO banners_idioma (banner_id, idioma_id, nome, texto, descricao, src)
					VALUES('$id','$idioma','$titulo','$texto','$descricao','$imagem')";
}

$q = gravar($sql);

if (is_numeric($q))  {
	$msg = "Operação realizada com sucesso!";
} else {
	$msg = "Erro ao gravar!";
}
if (!headers_sent($filename, $linenum)) {
		header('Location: ../index.php?pag=20&tipo=e&id='.$id);
    exit;
}

?>  