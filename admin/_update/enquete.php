<?php

	include("../php/sessao.php");
    session_write_close();
	include("../includes/db.php");

	extract($_POST);

	//$pergunta = mysql_escape_string($pergunta);

    $conn = conecta();

        $sql = "UPDATE enq_perguntas SET
        pergunta='$pergunta',
		modified =NOW()
        WHERE id=$id ";
		$q = mysqli_query($conn, $sql);

	if($q == false){
		$msg = "Erro ao realizar a operação!";
	}else{
		# Grava Respostas #
		$erro = false;
		foreach ($resposta as $k=>$resp){
			$sql = "
				UPDATE enq_respostas SET
				resposta='$resp',
				modified =NOW()
				WHERE id=$k ";
			$q = mysqli_query($conn, $sql);
		}
		
		$msg = "Operação realizada com sucesso!";
		
	}
        @((is_null($___mysqli_res = mysqli_close($conn))) ? false : $___mysqli_res);

if (!headers_sent($filename, $linenum)) {
	header("Location: ../index.php?pag=31&tipo=p&msg=".$msg);
    exit;
}

?>