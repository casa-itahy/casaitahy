<?php 
	include_once("../php/sessao.php");
        session_write_close();
	include_once("../includes/db.php");
	include_once ("../php/funcoes.php");

extract($_POST);

$endereco = addslashes($endereco);

$imagemUP = $_FILES['imagem'];
if ($imagemUP['error'] == 0 ) {
	$imagem = gravaImagem($imagemUP, 'associados/', 800, 300, 'M');
	if (!$imagem) {
		$imagem = '';	
	}
}

	$sql="INSERT INTO $tabela(
        tipo,
		nome, 
		site,
		fone,
        fax,
        celular,
		email,
		endereco,
		estado,                
        regiao,
		created,
		modified,
		logomarca
	) VALUES (
        '0',
		'$nome',
		'$site', 
		'$telefone',
        '$fax',
        '$celular',
		'$email',
		'$endereco',
		$estado,
		'$regiao',
		NOW(),
		NOW(),
		'$imagem'
	)";

	$conn = conecta();
	$q = mysqli_query($conn, $sql);        

	if($q == false){   
		$msg = "Não foi possível inserir os dados!";
    }else{
		$msg = "Operação realizada com sucesso!";
    }
    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

	if (!headers_sent($filename, $linenum)) {
		header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
	    exit;
	}