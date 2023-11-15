<?php 
	include_once("../php/sessao.php");        
        session_write_close();
	include_once("../includes/db.php");
	include_once("../php/funcoes.php");

extract($_POST);

/*if($pass!='' && $pass!=null)
    $senha= "senha ='".sha1($pass)."',";
else $senha='';*/
$endereco = addslashes($endereco);
$regiao = addslashes($regiao);

$imagemUP = $_FILES['imagem'];
$imagem = gravaImagem($imagemUP, 'associados/', 800, 300, 'M');
if (!$imagem) {
	$imagem = '';	
} else {
	$imagem = "logomarca = '$imagem', ";
}

$sql = "UPDATE $tabela SET
nome='$nome',
site='$site',
fone='$telefone',
fax='$fax',
celular='$celular',".$imagem ."
email='$email',
endereco='$endereco',
cidade = $cidade,
estado = $estado,
regiao='$regiao',
modified =NOW()
WHERE id=$id ";

$conn = conecta();
	$q = @mysqli_query($conn, $sql);
	if($q == false){ 
		$msg = "Não foi possível alterar os dados!";
	}else{		
		$msg = "Dados atualizados com sucesso!";
	}
	@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}

?>