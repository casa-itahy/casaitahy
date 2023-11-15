<?php 

include("../includes/db.php");
//include ("../php/funcoes.php");

extract($_POST);

    $pergunta = $_POST['pergunta'];
    //$pergunta = mysql_escape_string($pergunta);
	
    $conn = conecta();

	$sql="INSERT INTO enq_perguntas
				(pergunta, status, created,modified)
				VALUES('$pergunta', 0, NOW(),NOW())
			";
	$q = mysqli_query($conn, $sql);
	$id_pergunta = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);

if($q == false){
    @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
    $msg = "Erro ao gravar pergunta!";
} else {
	# Grava Respostas #
	
	$erro = false;
	foreach ($resposta as $resp){
		$sql = "
			INSERT INTO enq_respostas
			(id_pergunta, resposta, votos, created, modified)
			VALUES
			('$id_pergunta', '$resp', 0, NOW(), NOW())
		";
		$q = mysqli_query($conn, $sql);
		
		if($q == false){
			$erro = true;
		}
	}
	
	if ($erro) {
		@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
		$msg = "Erro ao gravar Resposta!";
		
	} else {

		@((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res); 
		$msg = "Operação realizada com sucesso!";
	}
}

if (!headers_sent($filename, $linenum)) {
	header('Location: ../index.php?pag=31&tipo=p&msg='.$msg);
    exit;
}	

?>