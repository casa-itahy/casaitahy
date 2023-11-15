<?php 
	include_once("../php/sessao.php");
        session_write_close();
	include_once("../includes/db.php");
	include_once("../php/funcoes.php");

extract($_POST);

$endereco = addslashes($endereco);
$regiao = addslashes($regiao);

/*if($pass!='' && $pass!=null)
    $senha= "senha ='".sha1($pass)."',";
else $senha='';*/

$sql = "UPDATE associados SET
nome='$nome',
site='$site',
fone='$telefone',
fax='$fax',
celular='$celular',
email='$email',
endereco='$endereco',
cidade = $cidade,
estado = $estado,
regiao='$regiao',
categoria='$categoria',
latitude='$latitude',
longitude='$longitude',
modified = NOW()
WHERE id=$id ";

$conn = conecta();
	$q = @mysqli_query($conn,$sql);
	if($q == false){ 
		$msg = "Não foi possível alterar os dados!".$sql;
	}else{		
		$msg = "Dados atualizados com sucesso!";
	}
	@mysqli_close($conn);

if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag='.$pag.'&tipo=p&msg='.$msg);
    exit;
}

?>