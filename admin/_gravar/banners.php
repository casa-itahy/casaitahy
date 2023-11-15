<?php 

    include("../includes/db.php");
    include ("../php/funcoes.php");
    include("../php/sessao.php");
    session_write_close();

    extract($_POST);
	
$posicao = query("SELECT MAX(ordem) as ordem FROM banners WHERE grupo = ". $grupo);
$config = query("SELECT * FROM grupo_banners WHERE id = ". $grupo);

$idiomas = query("SELECT * FROM idiomas WHERE status=1 AND sigla!='Port'");

$ordem = $posicao['0']['ordem'] + 1;

/* Envia a imagem para redimensionamento */
$imagemUP = $_FILES['imagem'];

$orientacao = strtoupper($config['0']['orientacao']);

$tamanho = $config['0']['largura'];
$thumb = $config['0']['altura'];

$imagem = gravaImagem($imagemUP, 'banners/grupo'.$grupo, $tamanho, $thumb, $config['0']['orientacao']);
if (!$imagem) {
	$imagem = '';	
}

//$titulo = mysql_escape_string($titulo);
$urllink = stripslashes($urllink);

if (!empty($texto)){
	$texto = $texto;
} else {
	$texto = "";
}

$conn = conecta();
$sql="INSERT INTO banners (nome, descricao, src, grupo, ordem, url_link, url_categoria, texto)
					VALUES('$titulo','$descricao','$imagem','$grupo','$ordem','$urllink','$url_categoria', '$texto')";

$q = mysqli_query($conn, $sql);

$banner_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);

@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

if($q){
    $msg = "Operação realizada com sucesso!";
}else{
    $msg = "Erro ao gravar no banco!";
}

if(!empty($idiomas)) {
	if (!headers_sent($filename, $linenum)) {
		header('Location: ../index.php?pag=20&tipo=e&id='.$banner_id);
		exit;
	}
} else {
	if (!headers_sent($filename, $linenum)) {
		header('Location: ../index.php?pag=20&tipo=p&msg='.$msg);
		exit;
	}
}


?>  