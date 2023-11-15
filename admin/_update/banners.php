<?php 

    include("../includes/db.php");
    include ("../php/funcoes.php");
    include("../php/sessao.php");
    session_write_close();

    extract($_POST);

$config = query("SELECT * FROM grupo_banners WHERE id = ". $grupo);



/* Envia a imagem para redimensionamento */
if (isset($_FILES['imagem'])) {
	$imagemUP = $_FILES['imagem'];
	$orientacao = strtoupper($config['0']['orientacao']);

	$tamanho = $config['0']['largura'];
	$thumb = $config['0']['altura'];

	$imagem = gravaImagem($imagemUP, 'banners/grupo'.$grupo, $tamanho, $thumb, $config['0']['orientacao']);

	if (!$imagem) {
		$imagem = '';	
	} else {
		$imagem = "src = '$imagem', ";
	}
} else {
	$imagem = '';
}
//$titulo = mysql_escape_string($titulo);
$urllink = stripslashes($urllink);

	$sql = "
		UPDATE banners SET 
		nome = '$titulo', 
		descricao = '$descricao',
		grupo = '$grupo',
		texto = '$texto',".
		$imagem."
		url_link='$urllink',
		url_categoria = '$url_categoria'
        WHERE id = ". $id;

$q = gravar($sql);

if (is_numeric($q))  {
	$msg = "Operação realizada com sucesso!";
} else {
	$msg = "Erro ao gravar!";
}
if (!headers_sent($filename, $linenum)) {
    header('Location: ../index.php?pag=20&tipo=p&msg='.$msg);
    exit;
}


?>  