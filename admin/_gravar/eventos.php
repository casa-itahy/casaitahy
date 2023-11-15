<?php 
	include("../includes/db.php");
	include ("../php/funcoes.php");

extract($_POST);

//$titulo = mysql_escape_string($titulo);



$sql="INSERT INTO $tabela 
		(
		titulo, 
		data,
		conteudo,
		created,
		modified
		)
		VALUES
		(
		'$titulo', 
		'$data',
		'$texto',
		NOW(),
		NOW()
		)";

	$conn = conecta();
	$q = mysqli_query($conn, $sql) or die(mysqli_error($GLOBALS["___mysqli_ston"]));
	
	if($q == false)
	{ 
		$msg = "Erro ao realizar a opera��o!";
	}
	else
	{	 
		$msg = "Operação realizada com sucesso!";
	}
	
	@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);
	
if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag=100&msg='.$msg);
    exit;
}	

?>